<style>
    .spinner-border {
        width: 3.5rem;
        height: 3.5rem;
    }

    @media only screen and (max-width: 767px) {
        .payment_modalTab {
            height: auto !important;
        }
    }
</style>
<div class="row justify-content-between">
    <div class="col-md-6 col-lg-5 d-none">
        <p class="payment_tab_title pb-30">{{ get_phrase('') }}</p>
        <!-- Tab -->
        <div class="nav flex-md-column flex-row nav-pills payment_modalTab w-100" role="tablist"
            aria-orientation="vertical">

            <!--@foreach ($payment_gateways as $key => $payment_gateway)
-->
            <!--    <div class="tabItem" onclick="showPaymentGatewayByAjax('{{ $payment_gateway->identifier }}')" id="{{ $payment_gateway->identifier }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $payment_gateway->identifier }}" role="tab" aria-controls="{{ $payment_gateway->identifier }}" aria-selected="true">-->
            <!--        <div class="payment_gateway_option d-flex align-items-center">-->
            <!--            <div class="logo">-->
            <!--                <img width="100px" src="{{ get_image('assets/payment/' . $payment_gateway->identifier . '.png') }}" alt="" />-->
            <!--            </div>-->
            <!--            <div class="info">-->
            <!--                <p class="card_no">{{ $payment_gateway->title }}</p>-->
            <!--                <p class="card_date"></p>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--
@endforeach-->

            <div class="w-100">
                @php $firstActive = null; @endphp
                @foreach ($payment_gateways as $payment_gateway)
                    @if ($payment_gateway->status == 1)
                        @php
                            if (!$firstActive) {
                                $firstActive = $payment_gateway->identifier;
                            }
                        @endphp
                        <div class="payment_gateway_option d-flex align-items-center mb-3">
                            <!--<div class="logo">-->
                            <!--<img width="100px" src="{{ get_image('assets/payment/' . $payment_gateway->identifier . '.png') }}" alt="" />-->
                            <!--</div>-->
                            <!--<div class="info">-->
                            <!--<p class="card_no">{{ $payment_gateway->title }}</p>-->
                            <!--</div>-->
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </div>
    <div class="col-md-12">
        <p class="payment_tab_title pb-30 pt-4">{{ get_phrase('Item List') }}</p>
        <div class="payment_table">
            <div class="table-responsive">
                <table class="table eTable eTable-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment_details['items'] as $key => $item)
                            <tr>
                                <td>
                                    <div class="dAdmin_info_name">
                                        <p><span>{{ $key + 1 }}</span></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="dAdmin_info_name min-w-100px">
                                        <p>{{ $item['title'] }}</p>
                                    </div>
                                    @if (isset($item['subtitle']))
                                        <div class="dAdmin_info_name min-w-100px">
                                            <strong>{{ $item['subtitle'] }}</strong>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="dAdmin_info_name min-w-150px text-end">
                                        @if ($item['discount_price'] > 0)
                                            <p class="text-dark">
                                                <small class="text-muted">
                                                    <del>{{ currency($item['price'], 2) }}</del>
                                                </small>
                                                {{ currency($item['discount_price'], 2) }}
                                            </p>
                                        @else
                                            <p>{{ currency($item['price'], 2) }}</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end">
                                <div class="dAdmin_info_name min-w-100px">
                                    <p class="fw-bold">{{ get_phrase('Total') }}</p>
                                </div>
                            </td>

                            @php
                                $payable = $payment_details['items'][0]['price'];

                                if ($payment_details['items'][0]['discount_price'] > 0) {
                                    $payable = $payment_details['items'][0]['discount_price'];
                                }

                                if (isset($payment_details['custom_field']['coupon_discount'])) {
                                    $payable = $payable;
                                }

                                $payable = $payable + $payment_details['tax'];
                            @endphp
                            <td>
                                <div class="dAdmin_info_name min-w-100px text-end">
                                    <p class="fw-bold">{{ currency($payable, 2) }}</p>
                                </div>
                            </td>
                        </tr>

                        @isset($payment_details['coupon'])
                            <tr>
                                <td></td>
                                <td>
                                    <div class="dAdmin_info_name min-w-100px">
                                        <p>
                                            {{ get_phrase('Coupon') }}
                                            ({{ $payment_details['coupon'] }})
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="dAdmin_info_name min-w-150px text-end">
                                        <p>
                                            {{ get_phrase('-') }}
                                            {{ currency($payment_details['custom_field']['coupon_discount'], 2) }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endisset

                        @if ($payment_details['tax'] > 0)
                            <tr>
                                <td></td>
                                <td>
                                    <div class="dAdmin_info_name min-w-100px">
                                        <p>{{ get_phrase('Tax') }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="dAdmin_info_name min-w-150px text-end">
                                        <p>
                                            {{ get_phrase('+') }}
                                            {{ currency($payment_details['tax'], 2) }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        <tr class="table-active">
                            <td colspan="2">
                                <div class="dAdmin_info_name text-end">
                                    <p class="fw-bold">{{ get_phrase('Grand Total') }}: </p>
                                </div>
                            </td>
                            <td>
                                <div class="dAdmin_info_name min-w-100px text-end">
                                    <p class="fw-bold">{{ currency($payment_details['payable_amount'], 2) }}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Content -->
        <div class="tab-content">
            <div class="tab-pane fade show active text-end pb-4" id="showPaymentGatewayByAjax">
            </div>
        </div>
        {{-- 
        <div class="row g-1">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="coupon"
                        placeholder="{{ get_phrase('Apply coupon') }}" value="{{ request()->query('coupon') }}">
                    <button type="button" class="input-group-text eBtn gradient text-white" id="apply-coupon">
                        {{ get_phrase('Apply') }}
                    </button>
                </div>
            </div>
        </div> --}}

    </div>
</div>


<script src="https://checkout.flutterwave.com/v3.js"></script>
<script type="text/javascript">
    "use strict";

    function showPaymentGatewayByAjax(identifier) {
        $('#showPaymentGatewayByAjax').html(

            '<div class="w-100 text-center my-5"><div class="spinner-border" role="status"><span class="visually-hidden"></span></div></div>'
        );
        $.ajax({
            url: "{{ route('payment.show_payment_gateway_by_ajax', '') }}/" + identifier,
            success(response) {
                $('#showPaymentGatewayByAjax').html(response);
            }
        });
    }
    // Automatically load the first active gateway on page load
    $(document).ready(function() {
        var firstActive = "{{ $firstActive }}";
        if (firstActive) {
            showPaymentGatewayByAjax(firstActive);
        }
    });
    // $(document).ready(function() {

    //     // submit coupon
    //     $('#apply-coupon').on('click', function(e) {
    //         e.preventDefault();

    //         alert('Apply button clicked');

    //         let code = $('input[name="coupon"]').val();

    //         let url = "{{ route('purchase.course.bundle', $payment_details['items'][0]['id']) }}" +
    //             "?coupon=" + code;

    //         alert(url);

    //         window.location.href = url;
    //     });

    //     // cancel coupon
    //     $('#cancel-coupon').on('click', function(e) {
    //         e.preventDefault();

    //         alert("Coupon Cancel Clicked");

    //         window.location.href =
    //             "{{ route('purchase.course.bundle', $payment_details['items'][0]['id']) }}";
    //     });

    //     $('input[name="is_gift"]').change(function(e) {
    //         if ($(this).prop('checked')) {

    //             alert("Gift option enabled");

    //             $('.gifted_user').attr({
    //                 'name': 'gifted_user_email',
    //                 'required': '1'
    //             }).removeClass('d-none');

    //         } else {

    //             alert("Gift option disabled");

    //             $('.gifted_user').removeAttr('name required').addClass('d-none');
    //         }
    //     });

    // });
</script>
