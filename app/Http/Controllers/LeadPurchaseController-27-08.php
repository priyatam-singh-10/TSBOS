<?php

namespace App\Http\Controllers;

use App\Models\LeadPurchase;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Illuminate\Support\Facades\Log;

class LeadPurchaseController extends Controller
{
    public function createOrder(Request $request)
    {
        $lead = session('lead_purchase');

        if (!$lead) {
            return response()->json(['error' => 'Session expired'], 400);
        }

        $amount = (int) $request->amount;

        if ($amount < 1) {
            return response()->json(['error' => 'Invalid amount'], 400);
        }

        $api = new Api(
            env('RAZORPAY_KEY'),
            env('RAZORPAY_SECRET')
        );

        $order = $api->order->create([
            'receipt'  => 'lead_' . time(),
            'amount'   => $amount * 100,
            'currency' => 'INR'
        ]);

        // INSERT BEFORE PAYMENT
        LeadPurchase::create([
            'webinar_name'    => $request->webinar_name,
            'user_name'       => $lead['user_name'],
            'mobile'          => $lead['mobile'],
            'city'            => $lead['city'],
            'price'           => $amount,
            'payment_gateway' => 'razorpay',
            'order_id'        => $order['id'],
            'payment_status'  => 'pending',
            'payment_id'      => null
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount'   => $amount,
            'key'      => env('RAZORPAY_KEY')
        ]);
    }

    // Payment Success Save
    public function paymentSuccess(Request $request)
    {
        // First get record
        $leadPurchase = LeadPurchase::where(
            'order_id',
            $request->razorpay_order_id
        )->first();

        if (!$leadPurchase) {
            return response()->json([
                'status' => false,
                'message' => 'Purchase not found'
            ]);
        }

        // Update payment details
        $leadPurchase->update([
            'payment_id'     => $request->razorpay_payment_id,
            'payment_status' => 'paid'
        ]);
        $this->sendWhatsappConfirmation($leadPurchase);
        session()->forget('lead_purchase');

        return response()->json([
            'status' => true
        ]);
    }
    public function razorpayWebhook(Request $request)
    {

        Log::info('Razorpay Webhook Hit');
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        $webhookSecret = env('RAZORPAY_WEBHOOK_SECRET');

        try {

            $api = new Api(
                env('RAZORPAY_KEY'),
                env('RAZORPAY_SECRET')
            );

            $api->utility->verifyWebhookSignature(
                $payload,
                $signature,
                $webhookSecret
            );
        } catch (\Exception $e) {

            Log::error('Webhook Signature Failed: ' . $e->getMessage());

            return response()->json(['status' => false], 400);
        }

        $data = json_decode($payload, true);

        $event = $data['event'];

        $payment = $data['payload']['payment']['entity'];

        $orderId = $payment['order_id'];
        $paymentId = $payment['id'];

        $leadPurchase = LeadPurchase::where('order_id', $orderId)->first();

        if (!$leadPurchase) {
            Log::error('Order not found: ' . $orderId);
            return response()->json(['status' => false]);
        }

        if ($event == 'payment.captured') {

            // avoid duplicate update
            if ($leadPurchase->payment_status !== 'paid') {

                $leadPurchase->update([
                    'payment_id' => $paymentId,
                    'payment_status' => 'paid'
                ]);

                $this->sendWhatsappConfirmation($leadPurchase);
            }
        }

        if ($event == 'payment.failed') {

            $leadPurchase->update([
                'payment_status' => 'failed'
            ]);
        }

        return response()->json(['status' => true]);
    }
    private function sendWhatsappConfirmation($leadPurchase)
    {
        $phone = $leadPurchase->mobile;
        $phone = str_replace('+', '', $phone);
        $message =
            "🎉 Webinar Purchase Confirmation 🎉\n\n" .
            "Hello {$leadPurchase->user_name},\n\n" .
            "Your registration for {$leadPurchase->webinar_name} confirmed ✅\n" .
            "Price: ₹{$leadPurchase->price}\n\n" .
            "Regards,\nTSBOS";

        $message = urlencode($message);

        $url = "https://511.wazipers.com/api/send?number={$phone}&type=text&message={$message}&instance_id=6A687EE3B3B2F&access_token=6a4f950a626af";

        try {
            file_get_contents($url);
        } catch (\Exception $e) {
            Log::error('WhatsApp Error: ' . $e->getMessage());
        }
    }
}
