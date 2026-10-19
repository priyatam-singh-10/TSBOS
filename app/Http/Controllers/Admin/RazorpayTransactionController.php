<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Pagination\LengthAwarePaginator;

class RazorpayTransactionController extends Controller
{

    public function razorpayTransactions(Request $request)
    {
        $api = new Api(
            env('RAZORPAY_KEY'),
            env('RAZORPAY_SECRET')
        );

        $response = $api->payment->all([
            'count' => 100
        ]);

        $payments = collect($response->items);


        if ($request->category == 'payment_link') {
            $payments = $payments->whereNotNull('payment_link_id');
        }

        if ($request->category == 'website') {
            $payments = $payments->whereNull('payment_link_id');
        }

        if ($request->status) {
            $payments = $payments->where('status', $request->status);
        }

        if ($request->method) {
            $payments = $payments->where('method', $request->method);
        }

        if ($request->from_date) {
            $from = strtotime($request->from_date);
            $payments = $payments->filter(fn($p) => $p->created_at >= $from);
        }

        if ($request->to_date) {
            $to = strtotime($request->to_date . ' 23:59:59');
            $payments = $payments->filter(fn($p) => $p->created_at <= $to);
        }
        // Mobile Number Filter
        if ($request->mobile) {
            $mobile = $request->mobile;

            $payments = $payments->filter(function ($p) use ($mobile) {
                return isset($p->contact) &&
                    str_contains($p->contact, $mobile);
            });
        }


        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentItems = $payments->slice(
            ($currentPage - 1) * $perPage,
            $perPage
        )->values();

        $payments = new LengthAwarePaginator(
            $currentItems,
            $payments->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        return view('admin.razorpay-transactions', compact('payments'));
    }
}
