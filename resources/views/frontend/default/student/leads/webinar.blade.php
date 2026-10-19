<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Registration - Webinar @ ₹51</title>
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

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 60px 0 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--accent);
            font-family: 'Poppins', sans-serif;
        }

        /* Main Content */
        .main-content {
            padding: 60px 0;
        }

        .section-title {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 30px;
            text-align: center;
        }

        /* Learning Cards */
        .learning-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .learning-item {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-left: 4px solid var(--primary-light);
        }

        .learning-item i {
            color: var(--primary);
            font-size: 28px;
            margin-bottom: 12px;
        }

        .learning-item h4 {
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .registration-info{
            text-align:center;
            padding:30px 20px;
        }

        .registration-info i{
            font-size:50px;
            color:#28a745;
            margin-bottom:15px;
            display:block;
        }

        .registration-info h4{
            font-weight:700;
            margin-bottom:10px;
        }

        .registration-info p{
            color:#666;
            margin-bottom:0;
        }

        /* Why It Matters */
        .why-matters-box {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .matter-item {
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 20px;
            background: var(--accent);
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .matter-item i {
            color: #ff4757;
            font-size: 24px;
            margin-top: 3px;
        }

        .matter-item-content h5 {
            color: var(--primary);
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .matter-item-content p {
            color: var(--text-muted);
            margin: 0;
        }

        /* Authority Box */
        .authority-box {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 40px;
        }

        .authority-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--secondary);
            display: block;
            line-height: 1;
        }

        .stat-label {
            font-size: 1rem;
            margin-top: 10px;
            opacity: 0.95;
        }

        /* Offer Box */
        .offer-box {
            background: white;
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .offer-box::before {
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

        .offer-title {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 30px;
        }

        .countdown-timer {
            background: linear-gradient(135deg, #ff4757, #ff6348);
            color: white;
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        .timer-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .timer-display {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .timer-unit {
            text-align: center;
        }

        .timer-value {
            font-size: 3rem;
            font-weight: 800;
            display: block;
            line-height: 1;
        }

        .timer-label-small {
            font-size: 0.8rem;
            text-transform: uppercase;
            margin-top: 8px;
            opacity: 0.9;
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
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            margin-top: 6px;
        }

        .hex-text .amount {
            font-size: 3rem;
            font-weight: 900;
            line-height: 1;
        }

        .old-price {
            font-size: 1rem;
            font-weight: 600;
            color: #ff4757;
            text-decoration: line-through;
            margin-top: 4px;
        }

        .price-line {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 2px;
        }


        .btn-payment {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            border: none;
            border-radius: 50px;
            padding: 12px 14px;
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(185, 122, 44, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            text-decoration: none;
        }

        .btn-payment:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(185, 122, 44, 0.4);
            color: white;
        }

        .limited-seats {
            background: #fff3cd;
            border: 2px dashed #ffc107;
            border-radius: 12px;
            padding: 15px;
            margin-top: 20px;
            display: inline-block;
        }

        .limited-seats i {
            color: #ff4757;
            font-size: 18px;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            height:240px;
        }

        .testimonial-text {
            font-size: 1rem;
            color: var(--text-dark);
            font-style: italic;
            margin-bottom: 15px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .author-info h5 {
            font-size: 0.95rem;
            color: var(--primary);
            margin: 0;
        }

        .stars {
            color: var(--secondary);
            font-size: 0.85rem;
        }

        /* Footer */
        .footer-cta {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            padding: 20px 0;
            text-align: center;
        }

        .footer-cta h3 {
            color: white;
            font-size: 2rem;
            margin-bottom: 30px;
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
        /* Tablet */
        @media (max-width: 992px) {
            .learning-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .progress-bar-container {
                display: grid;
                padding: 8px;
            }

            .hero-section,
            .main-content {
                padding: 30px 0 30px;
            }

            .hero-title {
                font-size: 1.5rem;
            }

            .section-title,
            .footer-cta h3,
            .offer-title {
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

            .btn-payment {
                font-size: 0.8rem;
            }

            .testimonial-card {
                padding: 18px;
            }

            .why-matters-box {
                padding: 14px;
            }

            .matter-item {
                padding: 12px
            }

            .authority-box {
                padding: 18px;
            }

            .timer-display {
                gap: 15px;
            }

            .timer-value {
                font-size: 2rem;
            }

            .authority-stats {
                gap: 30px;
            }

            .stat-number {
                font-size: 2rem;
            }

            .offer-box {
                padding: 30px 20px;
            }

            .footer-cta {
                padding: 8px 0;
            }

            .copyright-text {
                font-size: 12px;
            }
        }

        /* Mobile */
        @media (max-width: 576px) {
            .learning-grid {
                grid-template-columns: 1fr;
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
            <div class="step active">
                <div class="step-circle">2</div>
                <span class="step-label">Confirmation</span>
            </div>
            <div class="step-arrow">→</div>
            <div class="step">
                <div class="step-circle">3</div>
                <span class="step-label">Complete</span>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content">
            <h1 class="hero-title">You're One Step Away from<br>Understanding Your Life Patterns</h1>
            <p class="hero-subtitle">Complete your registration to secure your seat in this transformative webinar</p>
            <!-- CTA Button -->
            <a href="{{ route('leads.payment') }}" class="btn-payment">
                Secure My Seat Now
            </a>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">

            <!-- What You'll Learn -->
            <div class="mb-5">
                <h2 class="section-title">What You'll Learn in This Live Session</h2>
                <div class="learning-grid">
                    <div class="learning-item">
                        <i class="bi bi-person-circle"></i>
                        <h4>Face Reading</h4>
                        <p>Decode facial features to understand personality and potential</p>
                    </div>
                    <div class="learning-item">
                        <i class="bi bi-pen"></i>
                        <h4>Graphology</h4>
                        <p>Analyze handwriting and signatures for hidden insights</p>
                    </div>
                    <div class="learning-item">
                        <i class="bi bi-123"></i>
                        <h4>Name Numerology</h4>
                        <p>Discover how your name influences your destiny</p>
                    </div>
                    <div class="learning-item">
                        <i class="bi bi-phone"></i>
                        <h4>Mobile Numerology</h4>
                        <p>Learn the vibrations of your phone number</p>
                    </div>
                    <div class="learning-item">
                        <i class="bi bi-briefcase"></i>
                        <h4>Career Insights</h4>
                        <p>Align your career with your natural strengths</p>
                    </div>
                    <div class="learning-item">
                        <i class="bi bi-heart"></i>
                        <h4>Relationship Guidance</h4>
                        <p>Understand compatibility and relationship patterns</p>
                    </div>
                </div>
            </div>

            <!-- Why It Matters -->
            <div class="mb-5">
                <h2 class="section-title">Why This Matters</h2>
                <div class="why-matters-box">
                    <div class="matter-item">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div class="matter-item-content">
                            <h5>Wrong Name = Financial Blockage</h5>
                            <p>Your name's vibrations can create invisible barriers to wealth and success</p>
                        </div>
                    </div>
                    <div class="matter-item">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div class="matter-item-content">
                            <h5>Wrong Signature = Relationship Issues</h5>
                            <p>Your signature reveals and influences how you connect with others</p>
                        </div>
                    </div>
                    <div class="matter-item">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div class="matter-item-content">
                            <h5>Face Patterns = Personality Flaws</h5>
                            <p>Facial features can indicate hidden weaknesses holding you back</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Authority -->
            <div class="authority-box">
                <h3 style="color: white; margin-bottom: 10px;">Learn from an Expert</h3>
                <p style="opacity: 0.95; font-size: 1.1rem;">With proven track record of transforming lives</p>
                <div class="authority-stats">
                    <div class="stat">
                        <span class="stat-number">20+</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">60,000+</span>
                        <span class="stat-label">People Trained</span>
                    </div>
                </div>
            </div>

            <!-- Offer Box -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="offer-box">
                        <h2 class="offer-title">Complete Your Registration</h2>

                        <!-- Countdown Timer -->
                        <div class="countdown-timer">
                            <div class="timer-label">
                                <i class="bi bi-alarm"></i> Registration Window Closes In:
                            </div>
                            <div class="timer-display">
                                <div class="timer-unit">
                                    <span class="timer-value" id="minutes">14</span>
                                    <span class="timer-label-small">Minutes</span>
                                </div>
                                <div class="timer-unit">
                                    <span class="timer-value">:</span>
                                </div>
                                <div class="timer-unit">
                                    <span class="timer-value" id="seconds">59</span>
                                    <span class="timer-label-small">Seconds</span>
                                </div>
                            </div>
                        </div>

                        <div class="registration-info">
                            <i class="bi bi-patch-check-fill"></i>
                            <h4>Registration Almost Complete</h4>
                            <p>
                                Your seat will be reserved for this exclusive LIVE session.
                                Complete the next step to receive your webinar access details.
                            </p>
                        </div>

                        <!-- Limited Seats -->
                        <div class="limited-seats">
                            <i class="bi bi-fire"></i>
                            <strong>Limited Seats Only</strong> – Jaldi Book Karein Before 05 July • 8 PM
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="">
                <h2 class="section-title">What Students Say</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="testimonial-card">
                            <p class="testimonial-text">
                                "Sir se session lene ke baad humne name correction karaya aur new mobile number liya. Within a month positive results dikhne lage. Career me growth hui, health improve hui aur relationship me bhi positive changes aaye. Positive thoughts aur confidence bhi bahut improve hua."
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar">R</div>
                                <div class="author-info">
                                    <h5>Rahul Sharma</h5>
                                    <div class="stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testimonial-card">
                            <p class="testimonial-text">
                                "Sir se signature analysis karaya through Signature Astrology and Graphology. Sir ne signature design karke diya jisse hume na keval legal case se chutkara mila balki business me tarakki hui aur income bhi triple ho gayi."
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar">P</div>
                                <div class="author-info">
                                    <h5>Priya Verma</h5>
                                    <div class="stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer CTA -->
    <section class="footer-cta">
        <div class="container">
            <h3>Don't Miss This Life-Changing Opportunity</h3>
            <a href="{{ route('leads.payment') }}" class="btn-payment">
                Complete Registration
            </a>
        </div>
    </section>

    <!-- Footer CTA -->
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

    <script>
        // Countdown Timer
        let totalSeconds = 15 * 60; // 15 minutes

        function updateTimer() {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;

            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');

            if (totalSeconds > 0) {
                totalSeconds--;
            } else {
                totalSeconds = 15 * 60; // Reset to 15 minutes
            }
        }

        // Update timer every second
        setInterval(updateTimer, 1000);
        updateTimer();

        // Scroll to top on load
        window.scrollTo(0, 0);
    </script>

</body>

</html>
