<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class BootcampPurchase extends Model
{
    use HasFactory;

    public static function purchase_bootcamp($identifier)
    {
        // get payment details
        $payment_details = session('payment_details');

        if (Session::has('keys')) {
            $transaction_keys           = session('keys');
            $transaction_keys           = json_encode($transaction_keys);
            $payment['payment_details'] = $transaction_keys;
            $remove_session_item[]      = 'keys';
        }
        if (Session::has('session_id')) {
            $transaction_keys           = session('session_id');
            $payment['payment_details'] = $transaction_keys;
            $remove_session_item[]      = 'session_id';
        }

        // generate invoice for payment
        $payment['invoice']        = '#' . Str::random(20);
        $payment['user_id']        = auth()->user()->id;
        $payment['bootcamp_id']    = $payment_details['items'][0]['id'];
        $payment['price']          = $payment_details['payable_amount'];
        $payment['tax']            = $payment_details['tax'];
        $payment['payment_method'] = $identifier;
        $payment['status']         = 1;

        $package = Bootcamp::find($payment_details['items'][0]['id']);
        if (get_user_info($package->user_id)->role == 'admin') {
            $payment['admin_revenue'] = $payment_details['payable_amount'];
        } else {
            $payment['instructor_revenue'] = $payment_details['payable_amount'] * (get_settings('instructor_revenue') / 100);
            $payment['admin_revenue']      = $payment_details['payable_amount'] - $payment['instructor_revenue'];
        }

        // insert payment details
        BootcampPurchase::insert($payment);

        //whatsapp message start 

        $user      = auth()->user();
        $bootcamp  = Bootcamp::find($payment_details['items'][0]['id']);
        $phone     = $user->phone;
        $invoice   = $payment['invoice'];
        $title     = $bootcamp->title;

        $join_link = '';
        $start_time = '';
        $end_time = '';

        $invoiceData = BootcampPurchase::where('invoice', $invoice)->first();

        $bootcamp = Bootcamp::find($invoiceData->bootcamp_id);

        $invoiceData->title = $bootcamp->title ?? '';

        $pdf = Pdf::loadView('frontend.default.invoices.invoice', [
            'invoice' => $invoiceData
        ]);

        $filename = "invoice_" . str_replace('#', '', $invoice) . ".pdf";

        $folder = public_path('invoices');

        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $path = $folder . '/' . $filename;

        $pdf->save($path);

        $pdf_url = asset('invoices/' . $filename);

        $liveclass = DB::table('bootcamp_live_classes as blc')
            ->join('bootcamp_modules as bm', 'bm.id', '=', 'blc.module_id')
            ->where('bm.bootcamp_id', $bootcamp->id)
            ->select('blc.joining_data', 'blc.start_time', 'blc.end_time')
            ->first();

        if ($liveclass) {

            if ($liveclass->joining_data) {
                $zoomData = json_decode($liveclass->joining_data, true);
                $join_link = $zoomData['start_url'] ?? '';
            }

            if ($liveclass->start_time) {
                $start_time = date('d M Y, h:i A', $liveclass->start_time);
            }

            if ($liveclass->end_time) {
                $end_time = date('d M Y, h:i A', $liveclass->end_time);
            }
        }

        $message = "🎉 *Webinar Purchase Confirmation* 🎉\n\n" .
            "Hello *{$user->name}*,\n\n" .
            "Your registration for the webinar *{$title}* has been successfully confirmed ✅.\n\n" .
            "🧾 *Invoice:* {$invoice}\n" .
            "📅 *Date:* {$start_time}\n" .
            "⏰ *End Time:* {$end_time}\n\n" .
            "🔗 *Join Link:*\n{$join_link}\n\n" .
            "🔗 *Invoice pdf:*\n{$pdf_url}\n\n" .
            "⏳ Please join 10 minutes before the scheduled time.\n\n" .
            "🙏 Regards,\n" .
            "The Sommnath Bhattacharyaa Occult Sciences";

        $message = urlencode($message);
        $phone = str_replace('+', '', $phone);

        $url = "https://511.wazipers.com/api/send?number={$phone}&type=text&message={$message}&instance_id=6A687EE3B3B2F&access_token=6a4f950a626af";


        try {
            file_get_contents($url);
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Error: ' . $e->getMessage());
        }
        //whatsapp message end

        $buyer_email = auth()->user()->email;
        $fromEmail   = get_settings('system_email');
        $fromName    = get_settings('system_name');

        if (filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::send([], [], function ($message) use (
                    $buyer_email,
                    $fromEmail,
                    $fromName,
                    $payment_details,
                    $user,
                    $title,
                    $invoice,
                    $join_link,
                    $start_time,
                    $end_time
                ) {
                    $message->from($fromEmail, $fromName)
                        ->to($buyer_email)
                        ->subject('Webinar Purchase Successful')
                        ->html('
                            <!DOCTYPE html>
                            <html>
                            <head>
                                <meta charset="utf-8">
                                <title>Webinar Purchase Successful</title>
                                <style>
                                    body { font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333; }
                                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 8px; }
                                    h2 { color: #007bff; }
                                    p { font-size: 14px; line-height: 1.6; }
                                    .box { background: #f1f5f9; padding: 15px; border-radius: 6px; margin-top: 10px; }
                                    .btn {
                                        display: inline-block;
                                        padding: 12px 18px;
                                        background: #28a745;
                                        color: #fff !important;
                                        text-decoration: none;
                                        border-radius: 5px;
                                        margin-top: 10px;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="container">
                                    <h2>Hi ' . $user->name . ',</h2>

                                    <p>Thank you for purchasing the webinar.</p>

                                    <div class="box">
                                        <strong>Webinar:</strong> ' . $title . '<br>
                                        <strong>Invoice:</strong> ' . $invoice . '<br>
                                        <strong>Start Time:</strong> ' . $start_time . '<br>
                                        <strong>End Time:</strong> ' . $end_time . '<br>
                                    </div>

                                    <p>You can join your live session using the link below:</p>

                                    <a href="' . $join_link . '" class="btn">Join Webinar</a>

                                    <p>If the button does not work, copy this link:</p>
                                    <p><a href="' . $join_link . '">' . $join_link . '</a></p>

                                    <hr>

                                    <p><strong>Total Paid:</strong> ' . currency($payment_details["payable_amount"]) . '</p>

                                    <p>We recommend joining 5 minutes before the session.</p>

                                    <p>Regards,<br>' . get_settings("system_name") . '</p>
                                </div>
                            </body>
                            </html>
                        ');
                });
            } catch (\Exception $e) {
                \Log::error("Webinar buyer mail failed: " . $e->getMessage());
            }
        }
        $remove_session_item[] = 'payment_details';
        Session::forget($remove_session_item);
        Session::flash('success', 'Webinar purchased successfully.');
        return redirect()->route('my.webinars');
    }
}
