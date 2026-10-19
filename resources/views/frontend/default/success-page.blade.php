<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - Webinar Confirmed</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
            background: linear-gradient(135deg, var(--accent) 0%, #e8f5f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        /* Success Container */
        .success-container {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }
        
        /* Success Card */
        .success-card {
            background: white;
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .success-card::before {
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
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Success Icon */
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4caf50, #81c784);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: scaleIn 0.5s ease-out 0.3s both;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .success-icon i {
            font-size: 50px;
            color: white;
        }
        
        /* Title */
        .success-title {
            font-size: 2.5rem;
            color: var(--primary);
            text-align: center;
            margin-bottom: 15px;
        }
        
        .success-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        
        /* Webinar Details Box */
        .webinar-details {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            color: white;
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
        }
        
        .detail-item i {
            font-size: 24px;
            color: var(--secondary);
        }
        
        .detail-text {
            flex: 1;
        }
        
        .detail-label {
            font-size: 0.85rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .detail-value {
            font-size: 1.2rem;
            font-weight: 700;
            margin-top: 3px;
        }
        
        /* Important Box */
        .important-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .important-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #856404;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .important-title i {
            font-size: 24px;
        }
        
        .important-text {
            color: #856404;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        
        .important-text:last-child {
            margin-bottom: 0;
        }
        
        .important-text i {
            margin-right: 8px;
            color: #ff9800;
        }
        
        /* Tips Section */
        .tips-section {
            background: var(--accent);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .tips-title {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .tips-title i {
            color: var(--primary-light);
        }
        
        .tip-item {
            display: flex;
            align-items: start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .tip-item:last-child {
            border-bottom: none;
        }
        
        .tip-item i {
            color: var(--primary-light);
            font-size: 20px;
            margin-top: 2px;
        }
        
        .tip-item span {
            flex: 1;
            color: var(--text-dark);
            font-size: 1rem;
        }
        
        /* Contact Section */
        .contact-section {
            background: white;
            border: 2px solid var(--accent);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .contact-title {
            font-size: 1.3rem;
            color: var(--primary);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .contact-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 15px;
            background: var(--accent);
            border-radius: 12px;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: var(--primary-light);
            color: white;
            transform: translateY(-2px);
        }
        
        .contact-item i {
            font-size: 20px;
        }
        
        .contact-item span {
            font-weight: 600;
        }
        
        /* Button */
        .btn-back {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            border: none;
            border-radius: 50px;
            padding: 16px 48px;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(185, 122, 44, 0.3);
            text-decoration: none;
            display: inline-block;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(185, 122, 44, 0.4);
            color: white;
        }
        
        /* Footer Text */
        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        
        .footer-text i {
            color: #e74c3c;
            animation: heartbeat 1.5s infinite;
        }
        
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.2); }
            50% { transform: scale(1); }
        }
        
        
        /* Responsive */
        @media (max-width: 768px) {
            .success-card {
                padding: 30px 20px;
            }
            
            .success-title {
                font-size: 1.8rem;
            }
            
            .success-subtitle {
                font-size: 1rem;
            }
            
            .webinar-details {
                padding: 20px;
            }
            
            .detail-value {
                font-size: 1.1rem;
            }
        }

        /* Countdown Timer */
        .countdown-box{
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            border-radius: 18px;
            padding: 28px 20px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(185, 122, 44, 0.25);
        }

        .countdown-title{
            color: #fff;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.5px;
        }

        .countdown-wrapper{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .countdown-item{
            background: rgba(255,255,255,0.18);
            backdrop-filter: blur(8px);
            border-radius: 14px;
            padding: 16px 12px;
            min-width: 90px;
        }

        .countdown-item span{
            display: block;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }

        .countdown-item small{
            display: block;
            margin-top: 8px;
            color: rgba(255,255,255,0.9);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .countdown-separator{
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-top: -12px;
        }

        @media(max-width:576px){

            .countdown-item{
                min-width: 70px;
                padding: 14px 8px;
            }

            .countdown-item span{
                font-size: 1.5rem;
            }

            .countdown-separator{
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>    
    <div class="success-container">
        <div class="container px-3">
            <div class="success-card">
                
                <!-- Success Icon -->
                <div class="success-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                
                <!-- Title -->
                <h1 class="success-title">You're Registered! 🎉</h1>
                <p class="success-subtitle">Your webinar registration has been received successfully.</p>

                <!-- Countdown Timer -->
                <div class="countdown-box">
                    <div class="countdown-title">
                        <i class="bi bi-alarm-fill"></i>
                        Webinar Starts In
                    </div>

                    <div class="countdown-wrapper">

                        <div class="countdown-item">
                            <span id="days">00</span>
                            <small>Days</small>
                        </div>

                        <div class="countdown-separator">:</div>

                        <div class="countdown-item">
                            <span id="hours">00</span>
                            <small>Hours</small>
                        </div>

                        <div class="countdown-separator">:</div>

                        <div class="countdown-item">
                            <span id="minutes">00</span>
                            <small>Minutes</small>
                        </div>

                        <div class="countdown-separator">:</div>

                        <div class="countdown-item">
                            <span id="seconds">00</span>
                            <small>Seconds</small>
                        </div>

                    </div>
                </div>
                
                <!-- Webinar Details -->
                <div class="webinar-details">
                    <div class="detail-item">
                        <i class="bi bi-calendar-check"></i>
                        <div class="detail-text">
                            <div class="detail-label">Webinar Date</div>
                            <div class="detail-value">15 June 2025</div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-envelope-check"></i>
                        <div class="detail-text">
                            <div class="detail-label">Communication</div>
                            <div class="detail-value">Details will be shared via Email/WhatsApp</div>
                        </div>
                    </div>
                </div>
                
                <!-- Important Box -->
                <div class="important-box">
                    <div class="important-title">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>Important</span>
                    </div>
                    <div class="important-text">
                        <i class="bi bi-check-circle"></i>
                        If you have already paid, please wait for the joining details on WhatsApp.
                    </div>
                    <div class="important-text">
                        <i class="bi bi-credit-card"></i>
                        If payment is pending, complete it before the webinar to confirm your access.
                    </div>
                </div>
                
                <!-- Before Webinar Tips -->
                <div class="tips-section">
                    <h3 class="tips-title">
                        <i class="bi bi-lightbulb"></i>
                        Before the Webinar
                    </h3>
                    <div class="tip-item">
                        <i class="bi bi-clock"></i>
                        <span>Join 5–10 minutes early to ensure smooth entry</span>
                    </div>
                    <div class="tip-item">
                        <i class="bi bi-wifi"></i>
                        <span>Keep a stable internet connection for uninterrupted learning</span>
                    </div>
                    <div class="tip-item">
                        <i class="bi bi-star"></i>
                        <span>Stay till the end for bonus insights and special resources</span>
                    </div>
                </div>
                
                <!-- Contact Section -->
                <div class="contact-section">
                    <h4 class="contact-title">Need Help? Contact Our Support Team</h4>
                    <div class="contact-items">
                        <a href="tel:+919752391555" class="contact-item">
                            <i class="bi bi-telephone-fill"></i>
                            <span>+91 97523 91555</span>
                        </a>
                        <a href="mailto:thesommnathbhattacharyaa@gmail.com" class="contact-item">
                            <i class="bi bi-envelope-fill"></i>
                            <span>thesommnathbhattacharyaa@gmail.com</span>
                        </a>
                        <a href="https://wa.me/919752391555" class="contact-item" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                            <span>WhatsApp Support</span>
                        </a>
                    </div>
                </div>
                
                <!-- Back Button -->
                <a href="https://thesommnathbhattacharyaa.in/join-webinar" class="btn-back">
                    <i class="bi bi-arrow-left-circle"></i> Back to Webinar Details
                </a>
                
                <!-- Footer Text -->
                <div class="footer-text">
                    See you at the webinar <i class="bi bi-rocket-takeoff-fill"></i>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Countdown Target Date
        const targetDate = new Date("June 15, 2026 20:00:00").getTime();

        function updateCountdown() {

            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {

                document.getElementById("days").innerHTML = "00";
                document.getElementById("hours").innerHTML = "00";
                document.getElementById("minutes").innerHTML = "00";
                document.getElementById("seconds").innerHTML = "00";

                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));

            const hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );

            const minutes = Math.floor(
                (distance % (1000 * 60 * 60)) / (1000 * 60)
            );

            const seconds = Math.floor(
                (distance % (1000 * 60)) / 1000
            );

            document.getElementById("days").innerHTML =
                String(days).padStart(2, '0');

            document.getElementById("hours").innerHTML =
                String(hours).padStart(2, '0');

            document.getElementById("minutes").innerHTML =
                String(minutes).padStart(2, '0');

            document.getElementById("seconds").innerHTML =
                String(seconds).padStart(2, '0');
        }

        // Run Countdown
        setInterval(updateCountdown, 1000);

        // Initial Call
        updateCountdown();
    </script>
</body>

</html>
