<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ get_phrase('Invoice') }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-table td {
            vertical-align: top;
        }

        .company-info p {
            margin: 2px 0;
        }

        .invoice-title {
            font-size: 22px;
            font-weight: bold;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .invoice-table th {
            background: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }
    </style>
</head>

<body>

@php
    $companyName = get_settings('system_name') ?? 'Company';

    // ✅ YOUR LOGO (PDF SAFE)
    $logoUrl = env('APP_URL') . '/public/uploads/dark_logo/darklogo-1769084998.png';
    $imageData = file_get_contents($logoUrl);
    $CompanyLogo = 'data:image/png;base64,' . base64_encode($imageData);

    $companyAddress = get_settings('address');
    $companyPhone = get_settings('phone');
    $companyEmail = get_settings('system_email');
    $companyGST = get_settings('company_gst');

    $user = get_user_info($invoice->user_id);
    $location = json_decode($user->address);

    $course_ids = json_decode($bundle->course_ids);
    $courses = \App\Models\Course::whereIn('id', $course_ids)->get();
@endphp


<!-- ================= HEADER ================= -->

<table class="header-table">
    <tr>

        <td width="60%">
            @if($CompanyLogo)
                <img src="{{ $CompanyLogo }}" width="120">
            @endif

            <div class="company-info">
                <strong>{{ $companyName }}</strong>
                <p>{{ $companyAddress }}</p>
                <p>Phone: {{ $companyPhone }}</p>
                <p>Email: {{ $companyEmail }}</p>

                @if($companyGST)
                    <p>GSTIN: {{ $companyGST }}</p>
                @endif
            </div>
        </td>

        <td class="text-right">
            <div class="invoice-title">INVOICE</div>

            <p><strong>ID:</strong> {{ $invoice->id }}</p>

            <p>
                <strong>Date:</strong>
                {{ date('d M Y h:i A', strtotime($invoice->created_at)) }}
            </p>
        </td>

    </tr>
</table>


<!-- ================= BILL TO ================= -->

<table class="invoice-table">
    <tr>
        <td colspan="4">
            <strong>{{ get_phrase('Invoice To') }}</strong><br>

            {{ $user->name }} <br>
            {{ $user->email ?? 'N/A'}} <br>
            {{ $location->city ?? 'N/A' }},
            {{ $location->state ?? 'N/A' }},
            {{ $location->country ?? 'N/A' }} <br>
            {{ $user->phone }}
        </td>
    </tr>
</table>



<!-- ================= BUNDLE TABLE ================= -->

<table class="invoice-table">

    <thead>
        <tr>
            <th width="25%">Bundle</th>
            <th>Included Courses</th>
            <th width="20%" class="text-right">Amount</th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td>{{ $invoice->title }}</td>

            <td>
                <ul>
                    @foreach ($courses as $course)
                        <li>{{ $course->title }}</li>
                    @endforeach
                </ul>
            </td>

            <td class="text-right">
                {{ currency($invoice->amount,2) }}
            </td>
        </tr>

        <tr>
            <td colspan="2" class="text-right">
                <strong>Total</strong>
            </td>

            <td class="text-right">
                <strong>{{ currency($invoice->amount,2) }}</strong>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="text-right">
                Payment Method
            </td>

            <td class="text-right">
                {{ ucfirst($invoice->payment_method) }}
            </td>
        </tr>

    </tbody>

</table>



<!-- ================= FOOTER ================= -->

<div class="footer">
    Thank you for your purchase! <br>
    Contact us at {{ $companyEmail }} | {{ $companyPhone }}
</div>

</body>
</html>