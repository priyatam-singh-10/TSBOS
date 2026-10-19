@extends('layouts.admin')
@push('title', get_phrase('Razorpay Transactions'))
@section('content')
    <div class="container-fluid">
        <div class="ol-card radius-8px">
            <div class="ol-card-body my-3 py-12px px-20px">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                    <h4 class="title fs-16px">
                        <i class="fi-rr-settings-sliders me-2"></i>
                        Razorpay Transactions
                    </h4>

                </div>
            </div>
        </div>

        {{-- @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}

        <div class="card">
            <div class="card-body table-responsive">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.razorpay.transactions') }}">

                        <div class="row g-3 align-items-end">
                            {{-- Mobile Number --}}
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label fw-semibold">Mobile</label>
                                <input type="text" name="mobile" value="{{ request('mobile') }}" class="form-control"
                                    placeholder="Enter Mobile">
                            </div>
                            {{-- Payment Status --}}
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="captured" {{ request('status') == 'captured' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="created" {{ request('status') == 'created' ? 'selected' : '' }}>Created
                                    </option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed
                                    </option>
                                </select>
                            </div>

                            {{-- Payment Method --}}
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label fw-semibold">Method</label>
                                <select name="method" class="form-control">
                                    <option value="">All Methods</option>
                                    <option value="card" {{ request('method') == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="upi" {{ request('method') == 'upi' ? 'selected' : '' }}>UPI</option>
                                    <option value="netbanking" {{ request('method') == 'netbanking' ? 'selected' : '' }}>
                                        Netbanking</option>
                                    <option value="wallet" {{ request('method') == 'wallet' ? 'selected' : '' }}>Wallet
                                    </option>
                                </select>
                            </div>

                            {{-- From Date --}}
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label fw-semibold">From Date</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}"
                                    class="form-control">
                            </div>

                            {{-- To Date --}}
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label fw-semibold">To Date</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                            </div>

                            {{-- Category --}}
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category" class="form-control">
                                    <option value="">All Payments</option>
                                    <option value="payment_link"
                                        {{ request('category') == 'payment_link' ? 'selected' : '' }}>
                                        Payment Link
                                    </option>
                                    <option value="website" {{ request('category') == 'website' ? 'selected' : '' }}>
                                        Website Payment
                                    </option>
                                </select>
                            </div>

                            {{-- Buttons --}}
                            <div class="col-lg-2 col-md-4 d-flex gap-2">
                                <button type="submit" class="btn ol-btn-primary w-100">
                                    Filter
                                </button>

                                <a href="{{ route('admin.razorpay.transactions') }}" class="btn ol-btn-light w-100">
                                    Reset
                                </a>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="table-responsive course_list overflow-auto overflow-autoo">
                    <table class="table table-bordered">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mobile</th>
                                <th>Payment ID</th>
                                <th>Order ID</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if ($payments->count())
                                @foreach ($payments as $payment)
                                    <tr>

                                        <td>
                                            {{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}
                                        </td>

                                        <td>{{ $payment->contact ?? '-' }}</td>

                                        <td>{{ $payment->id ?? '-' }}</td>

                                        <td>{{ $payment->order_id ?? '-' }}</td>

                                        <td>₹{{ $payment->amount / 100 }}</td>

                                        <td>{{ $payment->method ?? '-' }}</td>

                                        <td>
                                            @if ($payment->status == 'captured')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif ($payment->status == 'failed')
                                                <span class="badge bg-danger">Failed</span>
                                            @else
                                                <span class="badge bg-warning">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>{{ date('d-m-Y h:i A', $payment->created_at) }}</td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No Transactions Found</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
