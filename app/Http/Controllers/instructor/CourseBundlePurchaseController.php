<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\OfflinePayment;
use App\Models\BundlePayment;
use App\Models\CourseBundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CourseBundlePurchaseController extends Controller
{
    // public function purchase($id)
    // {
    //     $bundle = CourseBundle::where('id', $id)->first();
    //     if (!$bundle) {
    //         Session::flash('error', get_phrase('Data not found.'));
    //         return redirect()->back();
    //     }

    //     // check course owner
    //     if ($bundle->user_id == auth()->user()->id) {
    //         Session::flash('error', get_phrase('You own this item.'));
    //         return redirect()->back();
    //     }

    //     $my_bundle = BundlePayment::where([
    //         'user_id' => auth()->id(),
    //         'bundle_id' => $bundle->id,
    //     ])->exists();

    //     if ($my_bundle) {
    //         Session::flash('info', get_phrase('You have already purchased this bundle.'));
    //         return redirect()->route('my.course.bundles');
    //     }
    //     // check any offline processing data
    //     $processing_payments = OfflinePayment::where([
    //         'user_id' => auth()->user()->id,
    //         'items' => $bundle->id,
    //         'item_type' => 'bundle',
    //         'status' => 0,
    //     ])->exists();

    //     if ($processing_payments) {
    //         Session::flash('warning', get_phrase('Your request is in process.'));
    //         return redirect()->back();
    //     }

    //     // prepare bootcamp payment data
    //     $price = $bundle->discount_flag ? $bundle->price - $bundle->discounted_price : $bundle->price;
    //     $payment_details = [
    //         'items' => [
    //             [
    //                 'id' => $bundle->id,
    //                 'title' => $bundle->title,
    //                 'subtitle' => '',
    //                 'price' => $bundle->price,
    //                 'discount_price' => $price,
    //             ],
    //         ],

    //         'custom_field' => [
    //             'item_type' => 'bundle',
    //             'pay_for' => get_phrase('Bundle payment'),
    //         ],

    //         'success_method' => [
    //             'model_name' => 'BundlePayment',
    //             'function_name' => 'purchase_bundle',
    //         ],

    //         'payable_amount' => round($price, 2),
    //         'tax' => 0,
    //         'coupon' => null,
    //         'cancel_url' => route('course.bundle.details', $bundle->slug),
    //         'success_url' => route('payment.success', ''),
    //     ];

    //     Session::put(['payment_details' => $payment_details]);
    //     return redirect()->route('payment');
    // }
    public function purchase(Request $request, $id)
    {
        // dd("Controller Hit", $request->query());

        Session::forget('payment_details');
        $bundle = CourseBundle::where('id', $id)->first();
        if (!$bundle) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check course owner
        if ($bundle->user_id == auth()->user()->id) {
            Session::flash('error', get_phrase('You own this item.'));
            return redirect()->back();
        }

        $my_bundle = BundlePayment::where([
            'user_id' => auth()->id(),
            'bundle_id' => $bundle->id,
        ])->exists();

        if ($my_bundle) {
            Session::flash('info', get_phrase('You have already purchased this bundle.'));
            return redirect()->route('my.course.bundles');
        }

        // check any offline processing data
        $processing_payments = OfflinePayment::where([
            'user_id' => auth()->user()->id,
            'items' => $bundle->id,
            'item_type' => 'bundle',
            'status' => 0,
        ])->exists();

        if ($processing_payments) {
            Session::flash('warning', get_phrase('Your request is in process.'));
            return redirect()->back();
        }

        // bundle price
        $price = $bundle->discount_flag ? $bundle->price - $bundle->discounted_price : $bundle->price;

        $coupon_discount = 0;
        $coupon_code = null;

        // coupon logic (same as index)
        if ($request->has('coupon')) {

            $code   = $request->query('coupon');
            $coupon = Coupon::where('code', $code)->first();

            if (!$coupon) {
                Session::flash('error', get_phrase('This coupon is not valid.'));
                return redirect()->back();
            }

            // expiry check
            if ($coupon->status && (time() >= $coupon->expiry)) {
                Session::flash('error', get_phrase('Ops! coupon is expired.'));
                return redirect()->back();
            }

            $userId = auth()->user()->id;

            // student condition
            if (!empty($coupon->student_id) && $coupon->student_id != $userId) {
                Session::flash('error', get_phrase('This coupon is not applicable for you.'));
                return redirect()->back();
            }

            // bundle condition
            if (!empty($coupon->bundle_id) && $coupon->bundle_id != $bundle->id) {
                Session::flash('error', get_phrase('This coupon is not applicable on this bundle.'));
                return redirect()->back();
            }

            $coupon_discount = $coupon->discount;
            $coupon_code = $coupon->code;

            // percentage discount calculation
            $discount_amount = ($price * $coupon_discount) / 100;

            // final price
            $price = $price - $discount_amount;
        }

        // prepare payment data
        $payment_details = [
            'items' => [
                [
                    'id' => $bundle->id,
                    'title' => $bundle->title,
                    'subtitle' => '',
                    'price' => $bundle->discount_flag ? $bundle->price - $bundle->discounted_price : $bundle->price,
                    'discount_price' => $price,
                ],
            ],

            'custom_field' => [
                'item_type' => 'bundle',
                'pay_for' => get_phrase('Bundle payment'),
                'coupon_discount' => $discount_amount,
            ],

            'success_method' => [
                'model_name' => 'BundlePayment',
                'function_name' => 'purchase_bundle',
            ],

            'payable_amount' => round($price, 2),
            'tax' => 0,
            'coupon' => $coupon_code,
            'cancel_url' => route('course.bundle.details', $bundle->slug),
            'success_url' => route('payment.success', ''),
        ];


        Session::put(['payment_details' => $payment_details]);

        return redirect()->route('payment');
    }
}
