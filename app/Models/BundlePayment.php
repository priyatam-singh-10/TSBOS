<?php

namespace App\Models;


use App\Mail\CourseBundleMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use DB;


class BundlePayment extends Model
{

    protected $fillable = ['user_id', 'bundle_id', 'payment_method', 'payment_details', 'amount', 'admin_revenue', 'instructor_revenue', 'tax', 'status'];

    public function courseBundle()
    {
        return $this->belongsTo(CourseBundle::class, 'bundle_id', 'id');
    }

    public static function purchase_bundle($identifier)
    {
        // Get payment details from session
        $payment_details = session('payment_details');
        if (!$payment_details) {
            Session::flash('error', get_phrase('Payment details not found.'));
            return redirect()->back();
        }

        // Prepare payment data
        $payment_data = [
            'user_id' => auth()->user()->id,
            'bundle_id' => $payment_details['items'][0]['id'],
            'amount' => $payment_details['payable_amount'],
            'tax' => $payment_details['tax'],
            'payment_method' => $identifier,
            'status' => 1,
        ];

        // Handle session keys if present
        $remove_session_item = [];
        if (Session::has('keys')) {
            $payment_data['payment_details'] = json_encode(session('keys'));
            $remove_session_item[] = 'keys';
        } elseif (Session::has('session_id')) {
            $payment_data['payment_details'] = session('session_id');
            $remove_session_item[] = 'session_id';
        }

        // Calculate revenue split
        $bundle = CourseBundle::find($payment_details['items'][0]['id']);
        if (!$bundle) {
            Session::flash('error', get_phrase('Bundle not found.'));
            return redirect()->back();
        }

        if (get_user_info($bundle->user_id)->role == 'admin') {
            $payment_data['admin_revenue'] = $payment_details['payable_amount'];
        } else {
            $instructor_revenue_percent = get_settings('instructor_revenue');
            $payment_data['instructor_revenue'] = $payment_details['payable_amount'] * ($instructor_revenue_percent / 100);
            $payment_data['admin_revenue'] = $payment_details['payable_amount'] - $payment_data['instructor_revenue'];
        }

        // Create payment record
        $bundle_payment = BundlePayment::create($payment_data);
        if (!$bundle_payment) {
            Session::flash('error', get_phrase('Failed to process payment.'));
            return redirect()->back();
        }

        // Enroll user in courses
        $courses = json_decode($bundle->course_ids, true) ?? [];
        $course_titles = [];
        $enroll_data = [
            'user_id' => auth()->user()->id,
            'enrollment_type' => 'bundle',
            'entry_date' => strtotime('now'),
            'expiry_date' => now()->addDays($bundle->subscription_limit)->timestamp,
        ];

        foreach ($courses as $course_id) {
            $course = DB::table('courses')->find($course_id);
            if ($course) {
                $course_titles[] = $course->title;
                $enroll_data['course_id'] = $course_id;

                if (!Enrollment::where($enroll_data)->exists()) {
                    Enrollment::create($enroll_data);
                }
            }
        }

        // Generate invoice PDF
        $invoice = BundlePayment::join('course_bundles', 'bundle_payments.bundle_id', 'course_bundles.id')
            ->where('bundle_payments.id', $bundle_payment->id)
            ->select('bundle_payments.*', 'course_bundles.title', 'course_bundles.slug')
            ->first();

        if (!$invoice) {
            Session::flash('error', get_phrase('Invoice generation failed.'));
            return redirect()->back();
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('frontend.default.student.my_course_bundles.invoice_pdf_view', [
            'invoice' => $invoice,
            'bundle' => $bundle,
        ]);

        $filename = "bundle_invoice_{$bundle_payment->id}.pdf";
        $folder = public_path('invoices');
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }
        $pdf->save("{$folder}/{$filename}");
        $pdf_url = asset("invoices/{$filename}");

        // Send WhatsApp notification
        $course_list_text = implode("\n• ", array_map(fn($title) => "• {$title}", $course_titles));
        self::sendBundleWhatsAppMessage(auth()->user()->name, $bundle, $pdf_url, $course_list_text);

        // Send email (uncomment if needed)
        // $mail_data = [...];
        // if (get_settings('student_email_verification')) {
        //     self::send_mail($mail_data);
        // }

        // Clear session
        $remove_session_item[] = 'payment_details';
        Session::forget($remove_session_item);
        Session::flash('success', 'Bundle purchased successfully.');
        return redirect()->route('course.bundles');
    }

    private static function sendBundleWhatsAppMessage($name, $bundle, $pdf_url, $course_list_text)
    {
        $phone = auth()->user()->phone;
        $phone = str_replace('+', '', $phone);
        $message = "🎉 *Bundle Purchase Confirmation* 🎉\n\n" .
            "Hello *{$name}*,\n\n" .
            "You have successfully purchased the bundle *{$bundle->title}* ✅.\n\n" .
            "📚 *Courses Included:*\n{$course_list_text}\n\n" .
            "🧾 *Invoice PDF:*\n{$pdf_url}\n\n" .
            "🙏 Thank you for learning with us!";

        try {
            \App\Services\WhatsappService::sendViaGet($phone, $message);
        } catch (\Exception $e) {
            \Log::error('WhatsApp Error: ' . $e->getMessage());
        }
    }

    public static function send_mail($mail_data)
    {
        config([
            'mail.mailers.smtp.transport' => get_settings('protocol'),
            'mail.mailers.smtp.host' => get_settings('smtp_host'),
            'mail.mailers.smtp.port' => get_settings('smtp_port'),
            'mail.mailers.smtp.encryption' => get_settings('smtp_crypto'),
            'mail.mailers.smtp.username' => get_settings('smtp_from_email'),
            'mail.mailers.smtp.password' => get_settings('smtp_pass'),
            'mail.from.address' => get_settings('smtp_from_email'),
            'mail.from.name' => get_settings('smtp_user'),
        ]);

        $send = Mail::to(auth()->user()->email)->send(new CourseBundleMail($mail_data));
        return $send;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function bundle()
    {
        return $this->belongsTo(CourseBundle::class, 'course_id');
    }
}
