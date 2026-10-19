<?php

namespace App\Http\Controllers\frontend;

use Razorpay\Api\Api;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\ManagePlan;
use App\Models\PlanPayment;
use App\Models\PlanPurchaseUser;
use App\Models\User;
use Illuminate\Http\Request;

class ManagePlanController extends Controller
{
    public function buyForm(Request $request)
    {
        $code = $request->id;

        $plan = ManagePlan::where('code', $code)->firstOrFail();
        if ($plan->status == 0) {
            abort(404);
        }
        $Batchname = Batch::find($plan->batch_id);

        return view('frontend.default.plan_buy.buy_form', compact('plan', 'Batchname'));
    }

    public function checkout(Request $request)
    {
        $plan = ManagePlan::where('course_id', $request->course_id)->firstOrFail();

        session([
            'purchase_user_data' => [
                'course_id'  => $plan->course_id,
                'batch_id'   => $plan->batch_id,
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'mobile'     => $request->mobile,
                'city'       => $request->city,
                'amount'     => $plan->price
            ]
        ]);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'amount' => $plan->price * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount'   => $order['amount'],
            'plan_name' => $plan->course->title ?? 'Course Payment',
            'key'      => env('RAZORPAY_KEY')
        ]);
    }

    public function paymentSuccess(Request $request)
    {

        $data = session('purchase_user_data');

        if (!$data) {
            return redirect()->back();
        }

        // ✅ PAYMENT SUCCESS

        $user = PlanPurchaseUser::create([
            'course_id'  => $data['course_id'],
            'batch_id'   => $data['batch_id'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'mobile'     => $data['mobile'],
            'city'       => $data['city']
        ]);

        PlanPayment::create([
            'purchase_user_id' => $user->id,
            'payment_id'       => $request->razorpay_payment_id,
            'order_id'         => $request->razorpay_order_id,
            'amount'           => $data['amount'],
            'status'           => 'success'
        ]);

        User::create([
            'name'   => $data['first_name'] . ' ' . $data['last_name'],
            'phone'  => $data['mobile'],
            'status' => 1,
            'role'   => 'student',
        ]);

        session()->forget('purchase_user_data');

        return redirect()->route('thank.you');
    }

    public function thankYou()
    {
        return view('frontend.default.thankyou');
    }
}
