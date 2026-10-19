@extends('layouts.default')

@section('content')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        .enroll-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .enroll-card {
            width: 900px;
            display: flex;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        /* LEFT SIDE */
        .plan-box {
            width: 40%;
            background: #177580;
            color: #fff;
            padding: 40px;
        }

        .plan-box h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .price-box {
            /* background: #1c1c1c; */
            border-radius: 12px;
            /* padding: 20px; */
            margin: 25px 0;
            /* text-align: center; */
        }

        .price-box h1 {
            font-size: 40px;
            color: #d4af37;
        }

        /* RIGHT SIDE */
        .form-box {
            width: 60%;
            background: #f7f4ef;
            padding: 40px;
        }

        .form-control {
            height: 45px;
            border-radius: 10px;
        }

        .pay-btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(45deg, #b78b3c, #e6c06a);
            color: #fff;
            font-weight: 600;
        }
    </style>

    <div class="enroll-wrapper">

        <div class="enroll-card">

            <!-- LEFT PLAN DETAILS -->
            <div class="plan-box">

                <h2>
                    Enroll in <br>
                    <b>
                        {{ $Batchname->name ?? 'No Batch' }}
                        -
                        {{ $plan->course->title ?? 'N/A' }}
                    </b>
                </h2>

                <p>Secure your seat and begin your learning journey.</p>

                <div class="price-box">
                    <p>Total Amount</p>
                    <h1>₹{{ $plan->price }}</h1>
                    <small>One-time payment • Lifetime access</small>
                </div>

                <ul>
                    <li>Instant digital access on payment</li>
                    <li>WhatsApp onboarding support</li>
                    <li>256-bit encrypted checkout</li>
                    <li>Powered by Razorpay Secure</li>
                </ul>

            </div>


            <!-- RIGHT FORM -->
            <div class="form-box">

                <h4 class="mb-4">Complete Your Enrollment</h4>

                <form id="paymentForm">

                    @csrf
                    <input type="hidden" name="course_id" value="{{ $plan->course_id }}">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>First Name</label>
                            <input type="text" name="first_name" placeholder="enter first name" class="form-control"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" placeholder="enter last name" class="form-control"
                                required>
                        </div>

                        <div class="col-12 mb-3">
                            <label>WhatsApp / Mobile</label>
                            <input type="text" name="mobile" placeholder="enter WhatsApp or mobile number"
                                class="form-control" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label>City</label>
                            <input type="text" name="city" placeholder="enter city" class="form-control" required>
                        </div>

                    </div>

                    <button type="submit" class="pay-btn">
                        Pay ₹{{ $plan->price }} & Enroll Now
                    </button>

                </form>

            </div>

        </div>
    </div>


    <form id="successForm" action="{{ route('buy.payment.success') }}" method="POST">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>


    <script>
        document.getElementById('paymentForm').onsubmit = async function(e) {

            e.preventDefault();

            let inputs = this.querySelectorAll("input[type='text']");

            for (let input of inputs) {
                if (input.value.trim() === "") {
                    alert(input.name + " cannot be empty or spaces only");
                    input.focus();
                    return;
                }
            }


            let formData = new FormData(this);

            let response = await fetch("{{ route('buy.checkout') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            });

            let data = await response.json();

            var options = {
                key: data.key,
                amount: data.amount,
                currency: "INR",
                name: data.plan_name,
                order_id: data.order_id,

                handler: function(response) {
                    document.getElementById('razorpay_payment_id').value =
                        response.razorpay_payment_id;

                    document.getElementById('razorpay_order_id').value =
                        response.razorpay_order_id;

                    document.getElementById('razorpay_signature').value =
                        response.razorpay_signature;

                    document.getElementById('successForm').submit();
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }
    </script>
@endsection
