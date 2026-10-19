<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseCourse extends Model
{
    use HasFactory;

    public static function purchase_course($identifier)
    {
        // get payment details
        $payment_details = session('payment_details');

        if (Session::has('keys')) {
            $transaction_keys          = session('keys');
            $transaction_keys          = json_encode($transaction_keys);
            $payment['transaction_id'] = $transaction_keys;
            $remove_session_item[]     = 'keys';
        }
        if (Session::has('session_id')) {
            $transaction_keys      = session('session_id');
            $payment['session_id'] = $transaction_keys;
            $remove_session_item[] = 'session_id';
        }

        // generate invoice for payment
        $payment['invoice'] = Str::random(20);
        for ($i = 0; $i < count($payment_details['items']); $i++) {
            $price           = $payment_details['items'][$i]['price'];
            $course_discount = $payment_details['items'][$i]['discount_price'];
            $baseAmount  = $course_discount ? $course_discount : $price;
            $batch_id = $payment_details['custom_field']['batch_ids'][$i] ?? null;
            if (get_course_creator_id($payment_details['items'][$i]['id'])->role == 'admin') {
                $payment['admin_revenue'] = $payment_details['payable_amount'];
            } else {

                $payment['instructor_revenue'] = $baseAmount * (get_settings('instructor_revenue') / 100);
                $payment['admin_revenue']      = $payment_details['payable_amount'] - $payment['instructor_revenue'];
            }

            $payment['course_id']    = $payment_details['items'][$i]['id'];
            $payment['tax']          = $payment_details['tax'];
            $payment['amount']       = $baseAmount;
            $payment['user_id']      = auth()->user()->id;
            $payment['payment_type'] = $identifier;
            $payment['coupon']       = $payment_details['coupon'];

            // insert payment history
            // $payment_history = DB::table('payment_histories')->insert($payment);
            $payment_id = DB::table('payment_histories')->insertGetId($payment);
            $payment_history = $payment_id ? true : false;

            // if payment has done then enroll user
            if ($payment_history) {
                $enroll['course_id']       = $payment_details['items'][$i]['id'];
                $enroll['user_id']         = $payment_details['custom_field']['gifted_user_id'] ? $payment_details['custom_field']['gifted_user_id'] : auth()->user()->id;
                $enroll['enrollment_type'] = "paid";
                $enroll['entry_date']      = time();
                $enroll['batch_id']        = $batch_id;

                $course_details = get_course_info($payment_details['items'][$i]['id']);

                if ($course_details->expiry_period > 0) {
                    $days = $course_details->expiry_period * 30;
                    $enroll['expiry_date'] = strtotime("+" . $days . " days");
                } else {
                    $enroll['expiry_date'] = null;
                }
                // insert a new enrollment
                DB::table('enrollments')->insert($enroll);

                // WhatsApp message send
                $invoiceData = DB::table('payment_histories')->where('id', $payment_id)->first();
                $invoiceData->course_title = $course_details->title;
                $pdf = Pdf::loadView('frontend.default.student.purchase_history.invoice_pdf_view', [
                    'invoice' => $invoiceData
                ]);


                $filename = "course_invoice_" . $payment_id . ".pdf";

                $folder = public_path('invoices');

                if (!file_exists($folder)) {
                    mkdir($folder, 0755, true);
                }

                $path = $folder . '/' . $filename;

                $pdf->save($path);

                $pdf_url = asset('invoices/' . $filename);
                // dd($pdf_url);
                // ===== WHATSAPP CALL UPDATED =====
                self::sendCourseWhatsAppMessage(auth()->user()->name, $course_details, $pdf_url);
            }
        }

        // if payment and enroll has been done then remove items from cart
        if ($payment_history && $enroll) {
            $cart_items = $payment_details['custom_field']['cart_id'];
            foreach ($cart_items as $item) {
                DB::table('cart_items')->where('user_id', auth()->user()->id)->where('course_id', $item)->delete();
            }
        }

        // call mail function and pass payment details
        self::course_purchase_mail_function($payment_details);

        $remove_session_item[] = 'payment_details';
        Session::forget($remove_session_item);
        Session::flash('success', 'Course enrolled successfully.');

        return redirect()->route('my.courses');
    }

    public static function Batchwisepurchase_course($identifier)
    {
        // get payment details
        $payment_details = session('payment_details');

        if (Session::has('keys')) {
            $transaction_keys          = session('keys');
            $transaction_keys          = json_encode($transaction_keys);
            $payment['transaction_id'] = $transaction_keys;
            $remove_session_item[]     = 'keys';
        }
        if (Session::has('session_id')) {
            $transaction_keys      = session('session_id');
            $payment['session_id'] = $transaction_keys;
            $remove_session_item[] = 'session_id';
        }

        // 🔹 Only handle first item for batch payment
        $first_item      = $payment_details['items'][0];
        $batch_id        = $payment_details['custom_field']['batch_ids'][0] ?? null;
        $price           = $first_item['price'];
        $course_discount = $first_item['discount_price'];
        $baseAmount      = $course_discount ? $course_discount : $price;

        if (get_course_creator_id($first_item['id'])->role == 'admin') {
            $payment['admin_revenue'] = $payment_details['payable_amount'];
        } else {
            $payment['instructor_revenue'] = $baseAmount * (get_settings('instructor_revenue') / 100);
            $payment['admin_revenue']      = $payment_details['payable_amount'] - $payment['instructor_revenue'];
        }

        $payment['course_id']    = $first_item['id'];
        $payment['batch_id']     = $batch_id;
        $payment['tax']          = $payment_details['tax'];
        $payment['amount']       = $baseAmount;
        $payment['user_id']      = auth()->user()->id;
        $payment['payment_type'] = $identifier;
        $payment['coupon']       = $payment_details['coupon'];

        // insert payment history
        $payment_id = DB::table('batchwise_payment_histories')->insertGetId($payment);

        if ($payment_id) {


            // ✅ Get batch
            $batch_details = DB::table('batches')->where('id', $batch_id)->first();

            $course_ids = [];

            if ($batch_details && !empty($batch_details->course_id)) {

                $raw = $batch_details->course_id;

                // remove extra quotes if stored like "[\"1\",\"3\"]"
                $raw = stripslashes($raw);

                $decoded = json_decode($raw, true);

                if (is_array($decoded)) {
                    $course_ids = $decoded;
                } else {
                    // support comma format 1,3
                    $course_ids = explode(',', str_replace(['[', ']', '"'], '', $raw));
                }
            }

            // ✅ USER ID
            $user_id = !empty($payment_details['custom_field']['gifted_user_id'])
                ? $payment_details['custom_field']['gifted_user_id']
                : auth()->user()->id;


            // ✅ INSERT ENROLLMENT PER COURSE
            foreach ($course_ids as $course_id) {

                $course_id = (int) trim($course_id);

                if ($course_id <= 0) {
                    continue;
                }

                // duplicate prevent
                $exists = DB::table('enrollments')
                    ->where('user_id', $user_id)
                    ->where('course_id', $course_id)
                    ->where('batch_id', $batch_id)
                    ->exists();

                if (!$exists) {
                    DB::table('enrollments')->insert([
                        'user_id'         => $user_id,
                        'course_id'       => $course_id,
                        'batch_id'        => $batch_id,
                        'enrollment_type' => 'paid',
                        'entry_date'      => time(),
                        'expiry_date'     => null,
                    ]);
                }
            }
            /*
        |--------------------------------------------------------------------------
        | Invoice + WhatsApp (UNCHANGED)
        |--------------------------------------------------------------------------
        */

            $course_titles = implode(', ', \App\Models\Course::whereIn('id', $course_ids)->pluck('title')->toArray());

            $invoiceData = DB::table('batchwise_payment_histories')->where('id', $payment_id)->first();
            $invoiceData->course_title = $course_titles;
            $invoiceData->batch_name   = $batch_details->name ?? 'Live Batch';

            $pdf = Pdf::loadView('frontend.default.student.purchase_history.invoice_pdf_view_batchwise', [
                'invoice' => $invoiceData
            ]);

            $filename = "batchwise_course_invoice_" . $payment_id . ".pdf";
            $folder   = public_path('invoices');

            if (!file_exists($folder)) mkdir($folder, 0755, true);

            $path = $folder . '/' . $filename;
            $pdf->save($path);
            $pdf_url = asset('invoices/' . $filename);

            self::sendBatchCourseWhatsAppMessage(
                auth()->user()->name,
                $course_titles,
                $batch_details,
                $pdf_url
            );
        }

        $remove_session_item[] = 'payment_details';
        Session::forget($remove_session_item);
        Session::flash('success', 'Course enrolled successfully.');

        return redirect()->route('my.batchwise.courses');
    }


    private static function sendBatchCourseWhatsAppMessage($name, $course_titles, $batch, $pdf_url)
    {
        $start_date = $batch->start_date
            ? date('d M Y', strtotime($batch->start_date))
            : 'Soon';

        $end_date = $batch->end_date
            ? date('d M Y', strtotime($batch->end_date))
            : 'N/A';

        $batch_name  = $batch->name ?? 'N/A';
        $batch_price = $batch->batch_price ?? 0;
        $phone       = auth()->user()->phone;
        $phone = str_replace('+', '', $phone);
        $message = "🎉 *Batch Enrollment Confirmation* 🎉\n\n" .
            "Hello *{$name}*,\n\n" .
            "You have successfully enrolled in:\n\n" .
            "👨‍🏫 *Batch:* {$batch_name}\n\n" .
            "👨‍🏫 *Batch Price:* ₹ {$batch_price}\n\n" .
            "📘 *Courses:* {$course_titles}\n" .
            "📅 *Start Date:* {$start_date}\n" .
            "📅 *End Date:* {$end_date}\n" .
            "🧾 *Invoice PDF:*\n{$pdf_url}\n\n" .
            "🙏 Welcome to The Sommnath Bhattacharyaa Occult Sciences";

        try {
            \App\Services\WhatsappService::sendViaGet($phone, $message);
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Error: ' . $e->getMessage());
        }
    }

    // New function to send WhatsApp message
    private static function sendCourseWhatsAppMessage($name, $course, $pdf_url)
    {
        $price = $course->price ?? 0;
        $phone = auth()->user()->phone;
        $phone = str_replace('+', '', $phone);
        $message = "🎉 *Course Enrollment Confirmation* 🎉\n\n" .
            "Hello *{$name}*,\n\n" .
            "You have successfully enrolled in the Recorded course *{$course->title}* ✅.\n\n" .
            "📅 *Price:* ₹ {$price}\n" .
            "🧾 *Invoice PDF:*\n{$pdf_url}\n\n" .
            "🙏 Welcome to The Sommnath Bhattacharyaa Occult Sciences";

        try {
            \App\Services\WhatsappService::sendViaGet($phone, $message);
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Error: ' . $e->getMessage());
        }
    }


    private static function course_purchase_mail_function($payment_details)
    {
        // From email fallback
        $fromEmail = get_settings('smtp_from_email') ?: 'hello@example.com';
        $fromName  = 'Course Purchase Mail';

        // 1 Buyer mail
        $buyer_email = auth()->user()->email;

        if (filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::send('admin.mail.course_purchase_mail_student', [
                    'user_name' => auth()->user()->name,
                    'course_list' => $payment_details['items'],
                    'total_amount' => $payment_details['payable_amount'],
                ], function ($message) use ($buyer_email, $fromEmail, $fromName) {
                    $message->from($fromEmail, $fromName);
                    $message->to($buyer_email)
                        ->subject('Course Purchase Successful');
                });
            } catch (\Exception $e) {
                // SMTP authentication fail error catch
                \Log::error("Buyer mail failed: " . $e->getMessage());
            }
        }

        // 2 Instructor mails (grouped by creator)
        $creator_courses = [];

        foreach ($payment_details['items'] as $item) {
            $course = DB::table('courses')->where('id', $item['id'])->first();

            if ($course) {
                // main creator
                if ($course->user_id) {
                    $creator_courses[$course->user_id][] = $item;
                }
                // multiple instructors
                if (!empty($course->instructor_ids)) {
                    $instructor_ids = json_decode($course->instructor_ids, true);
                    if (is_array($instructor_ids)) {
                        foreach ($instructor_ids as $instructor_id) {
                            $creator_courses[$instructor_id][] = $item;
                        }
                    }
                }
            }
        }

        // Remove duplicates
        foreach ($creator_courses as $key => $courses) {
            $creator_courses[$key] = array_unique($courses, SORT_REGULAR);
        }

        // Send mail per instructor
        foreach ($creator_courses as $creator_id => $courses) {
            $creator = DB::table('users')->where('id', $creator_id)->first();

            if ($creator && filter_var($creator->email, FILTER_VALIDATE_EMAIL)) {
                try {
                    Mail::send('admin.mail.course_purchase_mail_instructor', [
                        'creator_name' => $creator->name,
                        'buyer_name' => auth()->user()->name,
                        'course_list' => $courses,
                    ], function ($message) use ($creator, $fromEmail, $fromName) {
                        $message->from($fromEmail, $fromName);
                        $message->to($creator->email)
                            ->subject('Your Courses Have Been Purchased');
                    });
                } catch (\Exception $e) {
                    \Log::error("Instructor mail failed (ID: {$creator_id}): " . $e->getMessage());
                }
            }
        }

        // 3 Root admin mail
        $rootAdmin = User::orderBy('id', 'asc')->first();

        if ($rootAdmin && filter_var($rootAdmin->email, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::send('admin.mail.course_purchase_mail_rootAdmin', [
                    'admin_name' => $rootAdmin->name,
                    'buyer_name' => auth()->user()->name,
                    'course_list' => $payment_details['items'],
                    'total_amount' => $payment_details['payable_amount'],
                ], function ($message) use ($rootAdmin, $fromEmail, $fromName) {
                    $message->from($fromEmail, $fromName);
                    $message->to($rootAdmin->email)
                        ->subject('New Course Purchase Notification');
                });
            } catch (\Exception $e) {
                \Log::error("Admin mail failed: " . $e->getMessage());
            }
        }
    }
}
