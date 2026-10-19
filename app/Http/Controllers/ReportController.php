<?php

namespace App\Http\Controllers;

use App\Models\Payment_history;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function admin_revenue(Request $request)
    {
        if ($request->eDateRange) {
            $date                    = explode('-', $request->eDateRange);
            $start_date              = strtotime($date[0] . ' 00:00:00');
            $end_date                = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;

            $page_data['reports'] = Payment_history::whereNotNull('course_id')->where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->query());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::whereNotNull('course_id')->where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))->latest('id')->paginate(10);
        }

        return view('admin.report.admin_revenue', $page_data);
    }

    public function admin_revenue_filter(Request $request)
    {
        if ($request->eDateRange) {
            $date                            = explode('-', $request->eDateRange);
            $start_date                      = strtotime($date[0] . ' 00:00:00');
            $end_date                        = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date']         = $start_date;
            $page_data['end_date']           = $end_date;
            $page_data['reports'] = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->query());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10);
        }
        return view('admin.report.admin_revenue');
    }

    public function admin_revenue_delete($id)
    {

        Payment_history::where('id', $id)->delete();
        Session::flash('success', get_phrase('Admin revenue delete successfully'));
        return redirect()->back();
    }

    public function instructor_revenue(Request $request)
    {
        if ($request->eDateRange) {
            $date                            = explode('-', $request->eDateRange);
            $start_date                      = strtotime($date[0] . ' 00:00:00');
            $end_date                        = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date']         = $start_date;
            $page_data['end_date']           = $end_date;
            $page_data['reports'] = Payment_history::whereNotNull('course_id')->where('instructor_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->query());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::whereNotNull('course_id')->where('instructor_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10);
        }
        return view('admin.report.instructor_revenue', $page_data);
    }

    public function instructor_revenue_delete($id)
    {

        Payment_history::where('id', $id)->delete();
        Session::flash('success', get_phrase('Instructor revenue delete successfully'));
        return redirect()->back();
    }

    // public function purchase_history(Request $request)
    // {
    //     if ($request->eDateRange) {
    //         $date                          = explode('-', $request->eDateRange);
    //         $start_date                    = strtotime($date[0] . ' 00:00:00');
    //         $end_date                      = strtotime($date[1] . ' 23:59:59');
    //         $page_data['start_date']       = $start_date;
    //         $page_data['end_date']         = $end_date;
    //         $page_data['reports'] = Payment_history::whereNotNull('course_id')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
    //             ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
    //             ->latest('id')->paginate(10)->appends($request->all());
    //     } else {
    //         $start_date              = strtotime('first day of this month');
    //         $end_date                = strtotime('last day of this month');
    //         $page_data['start_date'] = $start_date;
    //         $page_data['end_date']   = $end_date;
    //         $page_data['reports']    = Payment_history::whereNotNull('course_id')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
    //             ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
    //             ->latest('id')->paginate(10);
    //     }
    //     return view('admin.report.purchase_history', $page_data);
    // }
    public function purchase_history(Request $request)
    {
        $type = $request->type ?? 'course';

        if ($request->eDateRange) {
            $date = explode(' - ', $request->eDateRange);

            $start_date = strtotime(date('Y-m-d', strtotime($date[0])) . ' 00:00:00');
            $end_date   = strtotime(date('Y-m-d', strtotime($date[1])) . ' 23:59:59');
        } else {
            $start_date = strtotime('first day of this month');
            $end_date   = strtotime('last day of this month');
        }

        $page_data['start_date'] = $start_date;
        $page_data['end_date']   = $end_date;

        // webinar data
        if ($type == 'webinar') {

            $page_data['reports'] = \App\Models\BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
                ->select(
                    'bootcamp_purchases.*',
                    'bootcamps.user_id as author',
                    'bootcamps.title',
                    'bootcamps.slug',
                    'bootcamps.price as amount'
                )
                ->where('bootcamp_purchases.created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('bootcamp_purchases.created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('bootcamp_purchases.id')
                ->paginate(10)
                ->appends($request->all());
        } elseif ($type == 'bundle') {

            $query = \App\Models\BundlePayment::with(['user', 'bundle.courses']);

            $query->whereBetween('created_at', [
                date('Y-m-d H:i:s', $start_date),
                date('Y-m-d H:i:s', $end_date)
            ]);

            $query->orderBy('created_at', 'desc');

            $page_data['reports'] = $query->paginate(10)->appends($request->all());
        } elseif ($type == 'batchwisecourse') {

            $page_data['reports'] = DB::table('batchwise_payment_histories as p')
                ->leftJoin('courses as c', 'c.id', '=', 'p.course_id')
                ->leftJoin('batches as b', 'b.id', '=', 'p.batch_id')
                ->select(
                    'p.*',
                    'c.title as course_title',
                    'b.name as batch_name'
                )
                ->whereBetween('p.created_at', [
                    date('Y-m-Y H:i:s', $start_date),
                    date('Y-m-d H:i:s', $end_date)
                ])
                ->orderByDesc('p.id')
                ->paginate(10)
                ->appends($request->all());
        } else {

            // course data
            $page_data['reports'] = Payment_history::whereNotNull('course_id')
                ->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')
                ->paginate(10)
                ->appends($request->all());
        }

        $page_data['type'] = $type;

        return view('admin.report.purchase_history', $page_data);
    }

    // public function purchase_history(Request $request)
    // {
    //     $type = $request->type ?? 'course';

    //     if ($request->eDateRange) {
    //         $date = explode(' - ', $request->eDateRange);

    //         $start_date = strtotime(date('Y-m-d', strtotime($date[0])) . ' 00:00:00');
    //         $end_date   = strtotime(date('Y-m-d', strtotime($date[1])) . ' 23:59:59');
    //     } else {
    //         $start_date = strtotime('first day of this month');
    //         $end_date   = strtotime('last day of this month');
    //     }

    //     $page_data['start_date'] = $start_date;
    //     $page_data['end_date']   = $end_date;

    //     // webinar data
    //     if ($type == 'webinar') {

    //         $page_data['reports'] = \App\Models\BootcampPurchase::join('bootcamps', 'bootcamp_purchases.bootcamp_id', 'bootcamps.id')
    //             ->select(
    //                 'bootcamp_purchases.*',
    //                 'bootcamps.user_id as author',
    //                 'bootcamps.title',
    //                 'bootcamps.slug',
    //                 'bootcamps.price as amount'
    //             )
    //             ->where('bootcamp_purchases.created_at', '>=', date('Y-m-d H:i:s', $start_date))
    //             ->where('bootcamp_purchases.created_at', '<=', date('Y-m-d H:i:s', $end_date))
    //             ->latest('bootcamp_purchases.id')
    //             ->paginate(10)
    //             ->appends($request->all());
    //     } elseif ($type == 'bundle') {

    //         $query = \App\Models\BundlePayment::with(['user', 'bundle.courses']);

    //         // date filter
    //         $query->whereBetween('created_at', [
    //             date('Y-m-d H:i:s', $start_date),
    //             date('Y-m-d H:i:s', $end_date)
    //         ]);

    //         // search filter
    //         if ($request->has('search') && $request->search != '') {
    //             $query->whereHas('bundle', function ($q) use ($request) {
    //                 $q->where('title', 'like', '%' . $request->search . '%');
    //             });
    //         }

    //         // status filter
    //         $status = $request->status ?? 'all';

    //         if ($status != 'all') {

    //             $currentTime = now();

    //             $query->whereHas('bundle', function ($q) use ($status, $currentTime) {

    //                 if ($status == 'active') {
    //                     $q->whereRaw('DATE_ADD(created_at, INTERVAL subscription_limit DAY) > ?', [$currentTime]);
    //                 } else {
    //                     $q->whereRaw('DATE_ADD(created_at, INTERVAL subscription_limit DAY) <= ?', [$currentTime]);
    //                 }
    //             });
    //         }

    //         $query->orderBy('created_at', 'desc');

    //         $page_data['reports'] = $query->paginate(10)->appends($request->all());
    //     } else {

    //         // course data
    //         $page_data['reports'] = Payment_history::whereNotNull('course_id')
    //             ->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
    //             ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
    //             ->latest('id')
    //             ->paginate(10)
    //             ->appends($request->all());
    //     }

    //     $page_data['type'] = $type;

    //     return view('admin.report.purchase_history', $page_data);
    // }
    public function purchase_history_invoice($id = '')
    {
        $page_data['report'] = Payment_history::where('id', $id)->first();
        return view('admin.report.report_invoice', $page_data);
    }
    public function purchase_history_invoice_batchwise($id = '')
    {
        $page_data['report'] = DB::table('batchwise_payment_histories')->where('id', $id)->first();
        return view('admin.report.report_invoice_batchwise', $page_data);
    }
}
