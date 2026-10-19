<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>

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
    </style>
</head>

<body>

    @php
        $companyName = get_settings('system_name') ?? 'Your Company Name';
        $companyLogo = get_image(get_frontend_settings('dark_logo'));
        $companyAddress = get_settings('address') ?? '';
        $companyPhone = get_settings('phone') ?? '';
        $companyEmail = get_settings('system_email') ?? '';
        $companyGST = get_settings('company_gst') ?? '';

    @endphp

    <!-- HEADER -->
    <table class="header-table">
        <tr>
            <td>
                @if ($companyLogo)
                    <img src="{{ public_path(parse_url($companyLogo, PHP_URL_PATH)) }}" width="120">
                @endif

                <div class="company-info">
                    <strong>{{ $companyName }}</strong>
                    <p>{{ $companyAddress }}</p>
                    <p>Phone: {{ $companyPhone }}</p>
                    <p>Email: {{ $companyEmail }}</p>
                    @if ($companyGST)
                        <p>GSTIN: {{ $companyGST }}</p>
                    @endif
                </div>
            </td>

            <td class="text-right">
                <div class="invoice-title">INVOICE</div>
                <p>#{{ str_pad($invoice->invoice, 5, '0', STR_PAD_LEFT) }}</p>
                <p>Date: {{ date('d-m-Y h:i A', strtotime($invoice->created_at)) }}</p>
            </td>
        </tr>
    </table>

    <!-- BILLING TABLE -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Batch</th>
                <th>Item</th>
                <th>Date</th>
                <th>Payment Method</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>{{ $invoice->batch_name ?? 'N/A' }}</td>
                <td>{{ $invoice->course_title ?? 'Course Purchase' }}</td>
                <td>{{ date('d-m-Y', strtotime($invoice->created_at)) }}</td>
                <td>{{ ucfirst($invoice->payment_type ?? 'Online') }}</td>
                <td class="text-right">{{ currency($invoice->amount, 2) }}</td>
            </tr>

            <tr>
                @php
                    $location = json_decode(auth()->user()->address);
                @endphp

                <td colspan="3">
                    <strong>Billed To:</strong><br>
                    {{ auth()->user()->name }}<br>
                    {{ $location->city ?? '' }},
                    {{ $location->state ?? '' }},
                    {{ $location->country ?? '' }}<br>
                    {{ auth()->user()->phone }}
                </td>

                <td class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>{{ currency($invoice->amount, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Thank you for your purchase!<br>
        Contact: {{ $companyEmail }} | {{ $companyPhone }}
    </div>

</body>

</html>
