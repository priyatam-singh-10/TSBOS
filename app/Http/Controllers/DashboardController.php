<?php

namespace App\Http\Controllers;

use App\Models\BootcampPurchase;
use App\Models\Enrollment;
use App\Models\Payment_history;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $totalWebinarRevenue = BootcampPurchase::where('status', 1)->sum('admin_revenue');
        $totalCourseRevenue = Payment_history::sum('admin_revenue');
        $enrolledStudent = Enrollment::with('course', 'users', 'batch')->orderBy('created_at', 'desc')->take(5)->get();
        $monthly_amount = array(0);
        for ($i = 1; $i <= 12; $i++) {
            $total_amount = date('t', strtotime(date("Y-$i-1 00:00:00")));
            $amount       = Payment_history::whereDate('created_at', '>=', date("Y-$i-1 00:00:00"))->whereDate('created_at', '<=', date("Y-$i-$total_amount 23:59:59"))->get();
            if (count($amount) > 0) {
                array_push($monthly_amount, array_sum($amount->pluck('admin_revenue')->toArray()));
            } else {
                array_push($monthly_amount, 0);
            }
        }
        $page_data['monthly_amount'] = $monthly_amount;
        $page_data['totalCourseRevenue'] = $totalCourseRevenue;
        $page_data['totalWebinarRevenue'] = $totalWebinarRevenue;
        $page_data['enrolledStudent'] = $enrolledStudent;
        return view('admin.dashboard.index', $page_data);
    }
}
