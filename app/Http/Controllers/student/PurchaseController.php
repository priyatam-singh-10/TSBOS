<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\CartItem;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment_history;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    public function purchase_history()
    {
        $page_data['payments'] = Payment_history::join('courses', 'payment_histories.course_id', 'courses.id')
            ->join('users', 'payment_histories.user_id', 'users.id')
            ->where('payment_histories.user_id', auth()->user()->id)
            ->select('payment_histories.*', 'courses.title as course_title', 'users.name as user_name')
            ->latest('id')->paginate(10);
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.purchase_history.index';
        return view($view_path, $page_data);
    }

    public function invoice($id)
    {
        // validate course id
        if (!is_numeric($id) && $id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check existence
        $payment = Payment_history::join('courses', 'payment_histories.course_id', 'courses.id')
            ->join('users', 'payment_histories.user_id', 'users.id')
            ->where('payment_histories.id', $id)
            ->select('payment_histories.*', 'courses.title as course_title', 'users.name as user_name')->first();
        if (!$payment) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $page_data['invoice'] = $payment;
        $view_path            = 'frontend.' . get_frontend_settings('theme') . '.student.purchase_history.invoice';
        return view($view_path, $page_data);
    }

    public function purchase_course(Request $request, $course_id)
    {
        $batch_id = $request->query('batch_id');
        // validate course id
        if (!is_numeric($course_id) && $course_id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check personal course
        if (Course::where('id', $course_id)->where('user_id', auth()->user()->id)->exists()) {
            Session::flash('error', get_phrase('Ops! You own this course.'));
            return redirect()->back();
        }

        // Check if the course is purchased and not expired
        $existingEnrollment = Enrollment::where('user_id', auth()->user()->id)
            ->where('course_id', $course_id)
            ->where(function ($query) {
                $query->where('expiry_date', '>', now()->timestamp)
                    ->orWhereNull('expiry_date');
            })
            ->exists();

        if ($existingEnrollment) {
            Session::flash('error', get_phrase('You already enrolled in this course'));
            return redirect()->back();
        }

        // get course details by id
        $course_details = Course::where('id', $course_id)->first();

        // if course doesn't exist redirect back
        if (!$course_details) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // if course is free then enroll user and redirect to my courses
        if ($course_details->is_paid == 0) {
            $enrollment['user_id']         = auth()->user()->id;
            $enrollment['course_id']       = $course_id;
            $enrollment['batch_id']        = $batch_id;
            $enrollment['enrollment_type'] = 'free';
            $enrollment['entry_date']      = time();

            $course_details = get_course_info($course_id);

            if ($course_details->expiry_period > 0) {
                $days = $course_details->expiry_period * 30;
                $enrollment['expiry_date'] = strtotime("+" . $days . " days");
            } else {
                $enrollment['expiry_date'] = null;
            }

            Enrollment::insert($enrollment);
            return redirect()->route('my.courses');
        } else {
            $query = CartItem::where('course_id', $course_id)->where('user_id', auth()->user()->id);
            if ($query->count() == 0) {
                CartItem::insert(['user_id' => auth()->user()->id, 'course_id' => $course_id, 'batch_id'   => $batch_id, 'created_at' => date('Y-m-d H:i:s')]);
                return redirect(route('cart'));
            } elseif ($query->count() == 1) {
                return redirect(route('cart'));
            }
        }

        // redirect to cart store
        return redirect()->back();
    }

    // public function batchWiseCoursePayout($course_id, $batch_id)
    // {
    //     if (!auth()->check()) {
    //         return redirect()->route('login');
    //     }

    //     $course = Course::find($course_id);
    //     $batch  = Batch::find($batch_id); // batch fetch

    //     if (!$course || !$batch) {
    //         Session::flash('error', get_phrase('Data not found'));
    //         return redirect()->back();
    //     }

    //     // already enrolled check
    //     $already_enrolled = Enrollment::where('user_id', auth()->id())
    //         ->where('course_id', $course_id)
    //         ->where('batch_id', $batch_id)
    //         ->exists();

    //     if ($already_enrolled) {
    //         Session::flash('error', get_phrase('Already enrolled'));
    //         return redirect()->route('my.courses');
    //     }

    //     $items[] = [
    //         'id'             => $course->id,
    //         'title'          => $course->title . ' - ' . $batch->name,
    //         'batch_id'       => $batch_id,
    //         'subtitle'       => '',
    //         'price'          => $batch->batch_price,   // CHANGE
    //         'discount_price' => 0,
    //     ];

    //     $payment_details = [
    //         'items' => $items,

    //         'custom_field' => [
    //             'item_type'       => 'course',
    //             'pay_for'         => 'course payment',
    //             'batch_ids'       => [$batch_id],
    //             'user_id'         => auth()->id(),
    //             'user_photo'      => auth()->user()->photo,
    //             'cart_id'         => [$course_id],
    //             'coupon_discount' => 0,
    //             'gifted_user_id'  => '',
    //         ],

    //         'success_method' => [
    //             'model_name'    => 'PurchaseCourse',
    //             'function_name' => 'Batchwisepurchase_course',
    //         ],

    //         'tax'            => 0,
    //         'coupon'         => null,
    //         'payable_amount' => $batch->batch_price, //CHANGE
    //         'cancel_url'     => route('home'),
    //         'success_url'    => route('payment.success', ''),
    //     ];

    //     Session::put(['payment_details' => $payment_details]);

    //     return redirect()->route('payment');
    // }
    public function batchWiseCoursePayout($batch_id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // batch fetch
        $batch = Batch::find($batch_id);

        if (!$batch) {
            Session::flash('error', get_phrase('Data not found'));
            return redirect()->back();
        }

        // JSON se course ids nikaalo
        $course_ids = json_decode($batch->course_id, true) ?? [];

        if (empty($course_ids)) {
            Session::flash('error', get_phrase('No courses assigned to this batch'));
            return redirect()->back();
        }

        // all courses fetch karo
        $courses = Course::whereIn('id', $course_ids)->get();

        // enrollment check for all courses
        foreach ($courses as $course) {
            $already_enrolled = Enrollment::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->where('batch_id', $batch_id)
                ->exists();

            if ($already_enrolled) {
                Session::flash('error', get_phrase('Already enrolled in ' . $course->title));
                return redirect()->route('my.batchwise.courses');
            }
        }

        // Prepare payment items for all courses
        $items = [];
        foreach ($courses as $course) {
            $items[] = [
                'id'             => $course->id,
                'title'          => $course->title . ' - ' . $batch->name,
                'batch_id'       => $batch_id,
                'subtitle'       => '',
                'price'          => $batch->batch_price,   // same price for batch
                'discount_price' => 0,
            ];
        }

        $payment_details = [
            'items' => $items,

            'custom_field' => [
                'item_type'       => 'course',
                'pay_for'         => 'course payment',
                'batch_ids'       => [$batch_id],
                'user_id'         => auth()->id(),
                'user_photo'      => auth()->user()->photo,
                'cart_id'         => $course_ids,
                'coupon_discount' => 0,
                'gifted_user_id'  => '',
            ],

            'success_method' => [
                'model_name'    => 'PurchaseCourse',
                'function_name' => 'Batchwisepurchase_course',
            ],

            'tax'            => 0,
            'coupon'         => null,
            'payable_amount' => $batch->batch_price, // total price for all courses
            'cancel_url'     => route('home'),
            'success_url'    => route('payment.success', ''),
        ];

        Session::put(['payment_details' => $payment_details]);

        return redirect()->route('payment');
    }
    // public function purchase_course(Request $request, $course_id)
    // {
    //     $batch_id = $request->query('batch_id');

    //     // validate course id
    //     if (!is_numeric($course_id) || $course_id < 1) {
    //         Session::flash('error', get_phrase('Data not found.'));
    //         return redirect()->back();
    //     }

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
    //         Session::flash('error', get_phrase('You already enrolled in this course'));
    //         return redirect()->back();
    //     }

    //     // get course details by id
    //     $course_details = Course::where('id', $course_id)->first();

    //     // if course doesn't exist redirect back
    //     if (!$course_details) {
    //         Session::flash('error', get_phrase('Data not found.'));
    //         return redirect()->back();
    //     }

    //     // Enroll user (free or paid)
    //     if ($course_details->is_paid == 0) {
    //         $enrollment['user_id']         = auth()->user()->id;
    //         $enrollment['course_id']       = $course_id;
    //         $enrollment['batch_id']        = $batch_id;
    //         $enrollment['enrollment_type'] = 'free';
    //         $enrollment['entry_date']      = time();

    //         $course_info = get_course_info($course_id);

    //         if ($course_info->expiry_period > 0) {
    //             $days = $course_info->expiry_period * 30;
    //             $enrollment['expiry_date'] = strtotime("+" . $days . " days");
    //         } else {
    //             $enrollment['expiry_date'] = null;
    //         }

    //         Enrollment::insert($enrollment);
    //         return redirect()->route('my.courses');
    //     } else {
    //         $query = CartItem::where('course_id', $course_id)->where('user_id', auth()->user()->id);
    //         if ($query->count() == 0) {
    //             CartItem::insert([
    //                 'user_id'    => auth()->user()->id,
    //                 'course_id'  => $course_id,
    //                 'batch_id'   => $batch_id,
    //                 'created_at' => date('Y-m-d H:i:s')
    //             ]);
    //             return redirect(route('cart'));
    //         } elseif ($query->count() == 1) {
    //             return redirect(route('cart'));
    //         }
    //     }
    //     return redirect()->back();
    // }


    public function payout(Request $request)
    {
        // get all item details by its id
        $items_id = json_decode($request->items);
        $batch_ids = json_decode($request->batch_ids, true);
        $courses  = $items_id;

        // if order is gift then select gifted user id
        if ($request->gifted_user_email) {
            $gifted_user_id = User::where('role', '!=', 'admin')->where('email', $request->gifted_user_email)->value('id');
            if (!$gifted_user_id) {
                Session::flash('error', get_phrase("User email doesn't exists."));
                return redirect()->back();
            }

            $courses = [];
            foreach ($items_id as $item) {
                if (Enrollment::where('course_id', $item)->where('user_id', $gifted_user_id)->doesntExist()) {
                    $courses[] = $item;
                }
            }

            if (count($courses) == 0) {
                Session::flash('error', get_phrase('User already enrolled.'));
                return redirect()->back();
            }
        }

        $selected_courses = Course::whereIn('id', $courses)->get();

        // prepare each item by its id
        foreach ($selected_courses as $key => $course) {
            $items[] = [
                'id'             => $course->id,
                'title'          => $course->title,
                'batch_id'       => $batch_ids[$key] ?? null,
                'subtitle'       => '',
                'price'          => $course->price,
                'discount_price' => $course->discount_flag ? $course->discounted_price : 0,
            ];
        }

        $payment_details = [
            'items'          => $items,

            'custom_field'   => [
                'item_type'       => 'course',
                'pay_for'         => 'course payment',
                'batch_ids' => $batch_ids,
                'user_id'         => auth()->user()->id,
                'user_photo'      => auth()->user()->photo,
                'cart_id'         => $items_id,
                'coupon_discount' => $request->coupon_discount,
                'gifted_user_id'  => $gifted_user_id ?? '',
            ],

            'success_method' => [
                'model_name'    => 'PurchaseCourse',
                'function_name' => 'purchase_course',
            ],

            'tax'            => round($request->tax, 2),
            'coupon'         => $request->coupon_code,
            'payable_amount' => round($request->payable, 2),
            'cancel_url'     => route('cart'),
            'success_url'    => route('payment.success', ''),
        ];

        //dd( $payment_details);
        Session::put(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }
}
