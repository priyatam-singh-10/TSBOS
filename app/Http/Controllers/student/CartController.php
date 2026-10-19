<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // public function index(Request $request)
    // {
    //     // has any coupon then validate coupon
    //     if (request()->has('coupon')) {
    //         $code   = request()->query('coupon');
    //         $coupon = Coupon::where('code', $code)->first();
    //         if (! $coupon) {
    //             Session::flash('error', get_phrase('This coupon is not valid.'));
    //             return redirect()->back();
    //         }

    //         if ($coupon->status && (time() >= $coupon->expiry)) {
    //             Session::flash('error', get_phrase('Ops! coupon is expired.'));
    //             return redirect()->back();
    //         }
    //         $discount = $coupon->discount;
    //         $page_data['coupon'] = $coupon;
    //     }

    //     // cart items by course id
    //     $page_data['cart_items'] = CartItem::join('courses', 'cart_items.course_id', '=', 'courses.id')
    //         ->select('cart_items.id as cart_id', 'courses.*', 'courses.id as course_id', 'cart_items.batch_id as batch_id')
    //         ->where('cart_items.user_id', auth()->user()->id)->get();
    //     $page_data['discount'] = isset($discount) ? $discount : 0;

    //     $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.cart.index';
    //     return view($view_path, $page_data);
    // }
    public function index(Request $request)
    {
        $discount = 0;

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

            // cart course ids
            $cartCourseIds = CartItem::where('user_id', $userId)->pluck('course_id')->toArray();

            // student condition
            if (!empty($coupon->student_id) && $coupon->student_id != $userId) {
                Session::flash('error', get_phrase('This coupon is not applicable for you.'));
                return redirect()->back();
            }

            // course condition
            if (!empty($coupon->course_id) && !in_array($coupon->course_id, $cartCourseIds)) {
                Session::flash('error', get_phrase('This coupon is not applicable on this course.'));
                return redirect()->back();
            }

            // bundle condition (agar bundle cart me hai)
            // if (!empty($coupon->bundle_id)) {
            //     $cartBundleIds = CartItem::where('user_id', $userId)->pluck('bundle_id')->toArray();

            //     if (!in_array($coupon->bundle_id, $cartBundleIds)) {
            //         Session::flash('error', get_phrase('This coupon is not applicable on this bundle.'));
            //         return redirect()->back();
            //     }
            // }

            // agar sab valid hai
            $discount = $coupon->discount;
            $page_data['coupon'] = $coupon;
        }

        // cart items
        $page_data['cart_items'] = CartItem::join('courses', 'cart_items.course_id', '=', 'courses.id')
            ->select('cart_items.id as cart_id', 'courses.*', 'courses.id as course_id', 'cart_items.batch_id as batch_id')
            ->where('cart_items.user_id', auth()->user()->id)
            ->get();

        $page_data['discount'] = $discount;

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.cart.index';
        return view($view_path, $page_data);
    }

    public function store(Request $request, $id)
    {
        $batch_id = $request->query('batch_id');
        // check personal course
        if (Course::where('id', $id)->where('user_id', auth()->user()->id)->exists()) {
            Session::flash('error', get_phrase('Ops! You own this course.'));
            return redirect()->back();
        }

        // Check if the course is purchased and not expired
        $existingEnrollment = Enrollment::where('user_id', auth()->user()->id)
            ->where('course_id', $id)
            ->where(function ($query) {
                $query->where('expiry_date', '>', now()->timestamp)
                    ->orWhereNull('expiry_date');
            })
            ->exists();

        if ($existingEnrollment) {
            Session::flash('error', get_phrase('You already purchased the course.'));
            return redirect()->back();
        }

        // if course_id doesn't exit in cart then insert course_id
        if (CartItem::where('user_id', auth()->user()->id)->where('course_id', $id)->doesntExist()) {
            CartItem::insert(['user_id' => auth()->user()->id, 'course_id' => $id, 'batch_id'  => $batch_id]);
        }

        // redirect back
        Session::flash('success', get_phrase('Item added to the cart.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        // if user has selected item then delete item else redirect to cart page
        $query = CartItem::where('course_id', $id)->where('user_id', auth()->user()->id);

        if ($query->exists()) {
            $query->delete();
            Session::flash('success', get_phrase('Item removed from cart.'));
        } else {
            Session::flash('error', get_phrase('Data not found.'));
        }
        return redirect()->back();
    }

    // public function LiveClassBatchstore(Request $request, $course_id, $batch_id)
    // {
    //     // $batch_id = $request->batch_id;
    //     // check personal course
    //     if (Course::where('id', $course_id)->where('user_id', auth()->user()->id)->exists()) {
    //         Session::flash('error', get_phrase('Ops! You own this course.'));
    //         return redirect()->back();
    //     }

    //     // Check if the course is purchased and not expired
    //     $existingEnrollment = Enrollment::where('user_id', auth()->user()->id)
    //         ->where('course_id', $course_id)
    //         ->where(function ($query) {
    //             $query->where('expiry_date', '>', now()->timestamp)
    //                 ->orWhereNull('expiry_date');
    //         })
    //         ->exists();

    //     if ($existingEnrollment) {
    //         Session::flash('error', get_phrase('You already purchased the course.'));
    //         return redirect()->back();
    //     }

    //     // if course_id doesn't exit in cart then insert course_id
    //     if (CartItem::where('user_id', auth()->user()->id)->where('course_id', $course_id)->doesntExist()) {
    //         CartItem::insert(['user_id' => auth()->user()->id, 'course_id' => $course_id, 'batch_id'  => $batch_id]);
    //     }

    //     // redirect back
    //     Session::flash('success', get_phrase('Item added to the cart.'));
    //     return redirect()->back();
    // }
}
