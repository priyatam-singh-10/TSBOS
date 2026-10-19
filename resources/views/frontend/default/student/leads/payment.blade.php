<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Payment - Webinar</title>
    <!-- fav icon -->
    <link rel="shortcut icon" href="https://thesommnathbhattacharyaa.in/public/uploads/favicon/favicon-1769074279.png" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Razorpay SDK -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        :root {
            --primary: #006266;
            --primary-light: #02979D;
            --secondary: #F9D058;
            --secondary-dark: #B97A2C;
            --accent: #F3F8F6;
            --text-dark: #1a1a1a;
            --text-muted: #666;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
            background: var(--accent);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        /* Progress Bar */
        .progress-bar-container {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
        }

        .progress-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 3px solid #ddd;
            background: white;
            color: #999;
        }

        .step.completed .step-circle {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .step.active .step-circle {
            background: var(--secondary);
            border-color: var(--secondary);
            color: var(--text-dark);
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(249, 208, 88, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(249, 208, 88, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(249, 208, 88, 0);
            }
        }

        .step-label {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .step.completed .step-label {
            color: var(--primary);
        }

        .step.active .step-label {
            color: var(--text-dark);
            font-weight: 600;
        }

        .step-arrow {
            color: #ddd;
            font-size: 20px;
        }

        /* Main Content */
        .main-content {
            padding: 60px 0;
        }

        .payment-card {
            background: white;
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .payment-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--secondary), var(--secondary-dark), var(--secondary));
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .payment-title {
            font-size: 2.2rem;
            color: var(--primary);
            text-align: center;
            margin-bottom: 15px;
        }

        .payment-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        /* Benefits List */
        .benefits-list {
            background: var(--accent);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .benefit-item:last-child {
            border-bottom: none;
        }

        .benefit-item i {
            color: var(--primary-light);
            font-size: 24px;
        }

        .benefit-item span {
            font-size: 1.05rem;
            color: var(--text-dark);
        }
        .registration-highlight{
            text-align:center;
            padding:30px 20px;
            margin:25px 0;
            border-radius:16px;
            background:#f8f9fa;
        }

        .registration-highlight i{
            font-size:48px;
            color:#28a745;
            display:block;
            margin-bottom:15px;
        }

        .registration-highlight h4{
            font-weight:700;
            margin-bottom:10px;
        }

        .registration-highlight p{
            color:#666;
            margin-bottom:0;
            line-height:1.7;
        }
        /* Price Section */
        .price-section {
            text-align: center;
            margin: 40px 0;
        }

        .price-label {
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-bottom: 15px;
        }

        .hex-wrapper {
            position: relative;
            width: 125px;
            height: 132px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            animation: blink 1.2s ease-in-out infinite;
            margin: auto;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.2;
            }
        }

        .hex-wrapper svg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .hex-text {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            line-height: 1;
            color: var(--primary);
        }

        .hex-text .rupee {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1px;
        }

        .hex-text .amount {
            font-size: 3rem;
            font-weight: 900;
        }

        .old-price {
            font-size: 1rem;
            font-weight: 600;
            color: #ff4757;
            text-decoration: line-through;
            margin-top: 4px;
        }

        .price-note {
            color: var(--text-muted);
            margin-top: 15px;
            font-size: 1rem;
        }

        /* Security Badge */
        .security-badges {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .security-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .security-badge i {
            color: #28a745;
            font-size: 20px;
        }

        /* Pay Button */
        .btn-pay {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            border: none;
            border-radius: 50px;
            padding: 12px 14px;
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(185, 122, 44, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            cursor: pointer;
        }

        .btn-pay:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(185, 122, 44, 0.4);
        }

        .btn-pay:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Guarantees */
        .guarantees {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            border-radius: 16px;
            padding: 25px;
            margin-top: 30px;
        }

        .guarantee-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            color: var(--text-dark);
        }

        .guarantee-item i {
            color: #2e7d32;
            font-size: 20px;
        }

        /* User Info Display */
        .user-info-box {
            background: var(--accent);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .user-info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .user-info-item:last-child {
            border-bottom: none;
        }

        .user-info-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .user-info-value {
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Urgency Timer */
        .urgency-timer {
            background: linear-gradient(135deg, #ff4757, #ff6348);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
        }

        .timer-text {
            font-size: 0.9rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .timer-display {
            font-size: 2rem;
            font-weight: 800;
        }

        .footer-cta {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 40px 0;
            text-align: center;
        }

        .copyright-text {
            color: rgba(255, 255, 255, 0.85);
        }

        .copyright-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .progress-bar-container {
                display: grid;
            }

            .btn-pay {
                font-size: 0.8rem;
            }

            .payment-card {
                padding: 30px 20px;
            }

            .payment-title {
                font-size: 1.5rem;
            }

            .progress-steps {
                flex-direction: row;
                gap: 4px;
            }

            .step-arrow {
                transform: rotate(90deg);
                display: none;
            }

            .step-circle {
                width: 14px;
                height: 14px;
                font-size: 13px;
                line-height: 13px;
            }

            .step-label {
                font-size: 0.8rem;
            }

            .step {
                gap: 4px;
            }

            .benefits-list {
                padding: 16px;
            }

            .footer-cta {
                padding: 8px 0;
            }

            .copyright-text {
                font-size: 12px;
            }
        }
    </style>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-18166729960"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-18166729960');
</script>
<body>

    <!-- Progress Bar -->
    <div class="progress-bar-container">
        <div class="brand-logo">
            <img src="https://thesommnathbhattacharyaa.in/public/uploads/dark_logo/darklogo-1769084998.png"
                alt="system logo" height="50" class="header-dark-logo">
        </div>
        <div class="progress-steps">
            <div class="step completed">
                <div class="step-circle"><i class="bi bi-check"></i></div>
                <span class="step-label">Registration</span>
            </div>
            <div class="step-arrow">→</div>
            <div class="step completed">
                <div class="step-circle"><i class="bi bi-check"></i></div>
                <span class="step-label">Confirmation</span>
            </div>
            <div class="step-arrow">→</div>
            <div class="step active">
                <div class="step-circle">3</div>
                <span class="step-label">Complete</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="payment-card">
                        <h1 class="payment-title">You are booking a LIVE Interactive Webinar</h1>
                        <p class="payment-subtitle">Secure your seat and start your transformation journey</p>
                        <button class="btn-pay mb-4" id="payNowBtn">
                            <i class="bi bi-patch-check-fill"></i> Confirm My Seat
                        </button>

                        <!-- Urgency Timer -->
                        <div class="urgency-timer">
                            <div class="timer-text">
                                <i class="bi bi-alarm"></i>  Complete Registration Within:
                            </div>
                            <div class="timer-display" id="paymentTimer">09:59</div>
                        </div>

                        <!-- User Info -->
                        <div class="user-info-box" id="userInfoBox" style="display: none;">
                            <h5 style="color: var(--primary); margin-bottom: 15px;">Your Registration Details</h5>
                            <div class="user-info-item">
                                <span class="user-info-label">Name:</span>
                                <span class="user-info-value" id="displayName"></span>
                            </div>
                            <div class="user-info-item">
                                <span class="user-info-label">Whatsapp:</span>
                                <span class="user-info-value" id="displayWhatsapp"></span>
                            </div>
                        </div>

                        <!-- Benefits List -->
                        <div class="benefits-list">
                            <div class="benefit-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Instant webinar access confirmation</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Limited seats only</span>
                            </div>
                            <div class="benefit-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>No replay guarantee - attend live for maximum benefit</span>
                            </div>
                        </div>

                        <div class="registration-highlight">
                            <i class="bi bi-patch-check-fill"></i>
                            <h4>Your Seat Is Almost Reserved</h4>
                            <p>
                                Complete your registration to secure access to this exclusive LIVE webinar
                                and receive joining instructions instantly.
                            </p>
                        </div>

                        <!-- Security Badges -->
                        <div class="security-badges">
                            <div class="security-badge">
                                <i class="bi bi-shield-check"></i>
                                <span>100% Secure</span>
                            </div>
                            <div class="security-badge">
                                <i class="bi bi-lock-fill"></i>
                                <span>SSL Encrypted</span>
                            </div>
                            <div class="security-badge">
                                <i class="bi bi-credit-card"></i>
                                <span>Verified Registration</span>
                            </div>
                        </div>

                        <!-- Guarantees -->
                        <div class="guarantees">
                            <div class="guarantee-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Instant WhatsApp confirmation</span>
                            </div>

                            <div class="guarantee-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Webinar access details sent immediately</span>
                            </div>

                            <div class="guarantee-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Live Q&A with expert mentor</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <section class="footer-cta">
        <div class="container">
            <p class="copyright-text mb-0 builder-editable" builder-identity="4">
                © 2026 <a href="https://kriscent.in/" target="_blank" class="copyright-link px-1">
                    Kriscent Techno Hub Pvt. Ltd.
                </a> - All Rights Reserved
            </p>
        </div>
    </section>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        const RAZORPAY_KEY = "{{ env('RAZORPAY_KEY') }}";
        //const PAYMENT_AMOUNT = document.querySelector('.amount').innerText;
        const PAYMENT_AMOUNT = 51;
        const WEBINAR_NAME = 'Face Reading, Graphology & Numerology Webinar';

        // Load user data from sessionStorage
        const registrationData = JSON.parse(sessionStorage.getItem('webinarRegistration') || '{}');

        if (registrationData.fullName) {
            document.getElementById('userInfoBox').style.display = 'block';
            document.getElementById('displayName').textContent = registrationData.fullName;
            document.getElementById('displayWhatsapp').textContent = registrationData.whatsappNumber;
            // document.getElementById('displayConcern').textContent = registrationData.mainConcern;
        }

        // ================= TIMER =================
        let totalSeconds = 10 * 60;

        function updatePaymentTimer() {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;

            document.getElementById('paymentTimer').textContent =
                String(minutes).padStart(2, '0') + ':' +
                String(seconds).padStart(2, '0');

            if (totalSeconds > 0) {
                totalSeconds--;
            } else {
                alert('Payment time expired.');
                window.location.href = 'webinar-landing-page.html';
            }
        }

        setInterval(updatePaymentTimer, 1000);
        updatePaymentTimer();


        // ================= PAYMENT =================
        document.getElementById('payNowBtn').addEventListener('click', function() {

            const button = this;
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';

            // STEP 1 → CREATE ORDER FROM LARAVEL
            fetch("{{ route('leads.order') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: PAYMENT_AMOUNT,
                        webinar_name: WEBINAR_NAME
                    })
                })
                .then(res => res.json())
                .then(data => {

                    const options = {

                        key: data.key,
                        amount: data.amount * 100,
                        currency: "INR",
                        order_id: data.order_id,

                        name: "TSBOS Webinar",
                        description: "Face Reading, Graphology & Numerology Webinar",

                        prefill: {
                            name: registrationData.fullName || "",
                            contact: registrationData.mobileNumber || "",
                            email: ""
                        },

                        theme: {
                            color: "#006266"
                        },

                        // ✅ PAYMENT SUCCESS
                        handler: function(response) {

                            fetch("{{ route('leads.payment.success') }}", {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        name: registrationData.fullName,
                                        mobile: registrationData.mobileNumber,
                                        city: registrationData.city,
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        amount: PAYMENT_AMOUNT
                                    })
                                })
                                .then(res => res.json())
                                .then(r => {

                                    alert('Payment Successful! Webinar details sent on WhatsApp ✅');

                                    sessionStorage.removeItem('webinarRegistration');

                                    window.location.href = "{{ route('webinars') }}";
                                });
                        },

                        modal: {
                            ondismiss: function() {
                                button.disabled = false;
                                button.innerHTML =
                                    '<i class="bi bi-shield-check"></i> Pay ₹51 & Confirm Seat';
                            }
                        }
                    };

                    const rzp = new Razorpay(options);

                    rzp.on('payment.failed', function(response) {
                        alert('Payment Failed : ' + response.error.description);
                        button.disabled = false;
                        button.innerHTML = '<i class="bi bi-shield-check"></i> Pay ₹51 & Confirm Seat';
                    });

                    rzp.open();
                })
                .catch(() => {
                    alert('Server error. Try again.');
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-shield-check"></i> Pay ₹51 & Confirm Seat';
                });

        });


        // Prevent Back
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    </script>

</body>

</html>
