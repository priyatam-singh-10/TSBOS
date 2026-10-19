<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Reading, Graphology & Numerology Webinar </title>
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

    <!-- Event snippet for Submit lead form conversion page -->
    <script>
        gtag('event', 'conversion', {'send_to': 'AW-955857601/c1NBCKaCjbccEMH15McD'});
    </script>


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
            background: #fff;
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

        /* ============ HEADER & NAVIGATION ============ */
        header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar {
            padding: 4px 0;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            font-size: 1.8rem;
        }

        .navbar-nav .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary) !important;
        }

        .navbar-toggler {
            border-color: var(--primary);
            padding: 5px 12px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(0, 98, 102, 0.2);
            outline: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23006266' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .header-cta {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .header-cta .btn {
            padding: 8px 20px;
            font-size: 0.9rem;
        }


        /* Animated Background Pattern */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            position: relative;
            overflow: hidden;
            padding: 80px 0 60px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--accent);
            font-weight: 400;
            margin-bottom: 30px;
            font-family: 'Poppins', sans-serif;
        }

        .trust-bar {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 20px 40px;
            display: inline-flex;
            gap: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
        }

        .trust-item i {
            font-size: 24px;
            color: var(--secondary);
        }

        .trust-item-text {
            text-align: left;
        }

        .trust-item-number {
            font-weight: 700;
            font-size: 1.1rem;
            display: block;
        }

        .trust-item-label {
            font-size: 0.85rem;
            opacity: 0.9;
            display: block;
        }

        .mentor-image-container {
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
            width: fit-content;
            margin: auto;
            padding: 2.5rem;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            margin-top: -25px;
            z-index: 10;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--secondary), var(--secondary-dark));
        }

        .form-title {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 30px;
            text-align: center;
        }
        .form-title2 {
            font-size: 1.6rem;
            color: var(--primary-light);
            margin-bottom: 30px;
            text-align: center;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 6px 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(2, 151, 157, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-dark));
            border: none;
            border-radius: 50px;
            padding: 12px 14px;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(185, 122, 44, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(185, 122, 44, 0.4);
        }

        /* Section Styling */
        .section {
            padding: 40px 0;
        }

        .section-title {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 50px;
            text-align: center;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary), var(--secondary-dark));
            margin: 20px auto 0;
            border-radius: 2px;
        }

        /* Hook Section */
        .hook-section {
            background: var(--accent);
            padding: 40px 0;
        }

        .problem-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
            border-left: 4px solid var(--secondary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .problem-card:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .problem-card i {
            color: var(--primary-light);
            font-size: 28px;
            margin-bottom: 15px;
        }

        .problem-card h4 {
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .problem-card p {
            color: var(--text-muted);
            margin: 0;
        }

        /* Learning Cards */
        .learning-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 100%;
        }

        .learning-card:hover {
            border-color: var(--primary-light);
            transform: translateY(-8px);
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12);
        }

        .learning-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            color: white;
        }

        .learning-card h4 {
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        .learning-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin: 0;
        }

        /* Mentor Section */
        .mentor-section {
            background: linear-gradient(135deg, var(--primary) 0%, #004d50 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .mentor-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(249, 208, 88, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .mentor-section.section {
            margin-bottom: 35px;
        }

        .mentor-section .section-title::after {
            margin: 20px 0;
        }

        .mentor-content {
            position: relative;
            z-index: 2;
        }

        .mentor-stats {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .stat-item {
            flex: 1;
            min-width: 200px;
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
            opacity: 0.9;
            margin-top: 10px;
        }

        .expertise-list {
            list-style: none;
            margin-top: 30px;
            padding-left: 0;
        }

        .expertise-list li {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .expertise-list li i {
            color: var(--secondary);
            font-size: 20px;
        }

        /* Testimonial Cards */
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            position: relative;
            height: 272px;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 80px;
            color: var(--accent);
            font-family: 'Playfair Display', serif;
            line-height: 1;
        }

        .testimonial-text {
            font-size: 1.1rem;
            color: var(--text-dark);
            font-style: italic;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .author-info h5 {
            font-size: 1rem;
            color: var(--primary);
            margin: 0;
        }

        .stars {
            color: var(--secondary);
            font-size: 0.9rem;
        }

        /* Offer Section */
        .offer-section {
            background: var(--accent);
            padding: 40px 0;
        }

        .offer-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: #fff;
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .offer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--primary-light), var(--secondary));
            background-size: 200% 100%;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .offer-features {
            list-style: none;
            margin: 40px 0;
            text-align: left;
        }

        .offer-features li {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.1rem;
        }

        .offer-features li i {
            color: #fff;
            font-size: 24px;
        }

        .urgency-badge {
            background: linear-gradient(135deg, #ff4757, #ff6348);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            display: inline-block;
            margin-top: 20px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
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

        /* FAQ Section */
        .faq-section {
            background: white;
        }

        .accordion-item {
            border: 1px solid var(--primary);
            margin-bottom: 15px;
            /* border-radius: 12px; */
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            border-bottom-right-radius: 12px !important;
            border-bottom-left-radius: 12px !important;
            border-top: 1px solid var(--primary) !important;
        }

        .accordion-button {
            background: white;
            color: var(--primary);
            font-weight: 600;
            font-size: 1.1rem;
            padding: 20px 30px;
            border: none;
        }

        .accordion-button:not(.collapsed) {
            background: var(--accent);
            color: var(--primary);
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border: none;
        }

        .accordion-body {
            padding: 20px 30px;
            color: var(--text-muted);
            line-height: 1.8;
        }

        /* Footer CTA */
        .footer-cta {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 40px 0;
            text-align: center;
        }

        .footer-cta h2 {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .footer-cta .btn-primary-custom {
            max-width: 400px;
            margin: 0 auto;
        }

        /* Checkbox Styling */
        .form-check-input:checked {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
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

        /* Error Message Styling */
        .error-message {
            color: #dc3545;
            font-size: 0.65rem;
            margin-top: 0.25rem;
            min-height: 1.25rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-valid,
        .form-select.is-valid {
            border-color: #28a745;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .hero-section,
            .hook-section {
                padding: 30px 0 30px;
            }

            .hero-title {
                font-size: 1.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .trust-bar {
                flex-direction: column;
                gap: 20px;
                padding: 25px;
            }

            .form-card {
                padding: 30px 20px;
            }

            .form-card {
                margin-top: 20px;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .price-tag {
                font-size: 3.5rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }
            .testimonial-card {
                padding: 16px;                      
            }                             

            .offer-features {
                padding-left: 0;
            }

            .offer-card {
                padding: 12px;
            }

            .btn-primary-custom {
                font-size: 0.8rem;
            }

            .accordion-button {
                padding: 12px 12px;
            }

            .footer-cta h2 {
                color: white;
                font-size: 1.5rem;
            }

            .footer-cta {
                padding: 8px 0;
            }
        }

        /* Scroll Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Webinar Section */
        .webinar-section {
            background: #f8f9fc;
        }

        /* Video */
        .video-box {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            background: #000;
        }

        .video-box video {
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 20px;
        }

        /* Offer Box */
        .offer-box, .video-box {
            background: #fff;
            padding: 35px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(36, 125, 146, 0.15);
            position: relative;
            overflow: hidden;
        }

        /* Title */
        .offer-title {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #247D92;
        }

        /* Timer */
        .countdown-timer {
            background: rgba(36, 125, 146, 0.08);
            border-radius: 16px;
            padding: 40px 20px;
            margin-bottom: 30px;
        }

        .timer-label {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #247D92;
            text-align:center;
        }

        .timer-display {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .timer-unit {
            background: #247D92;
            color: #fff;
            border-radius: 14px;
            padding: 10px 14px;
            min-width: 75px;
            text-align: center;
        }

        .timer-value {
            display: block;
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
        }

        .timer-label-small {
            font-size: 13px;
            opacity: 0.9;
        }

        /* Price */
        .price-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .hex-wrapper {
            position: relative;
            width: 180px;
            margin: auto;
        }

        .hex-wrapper svg {
            width: 100%;
        }

        .hex-text {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .price-line {
            display: flex;
            align-items: flex-start;
            gap: 3px;
        }

        .rupee {
            font-size: 24px;
            font-weight: 700;
            color: #000;
        }

        .amount {
            font-size: 52px;
            line-height: 1;
            font-weight: 800;
            color: #000;
        }

        .old-price {
            font-size: 18px;
            text-decoration: line-through;
            color: #555;
        }

        .price-note {
            margin-top: 15px;
            color: #666;
            font-size: 15px;
        }

        /* Limited Seats */
        .limited-seats {
            background: #fff4f4;
            border: 1px solid #ffd7d7;
            color: #d62828;
            padding: 16px;
            border-radius: 14px;
            font-size: 16px;
            text-align: center;
        }

        /* Mobile */
        @media (max-width: 767px) {

            .offer-box {
                padding: 25px;
            }

            .offer-title {
                font-size: 21px;
            }

            .timer-display {
                justify-content: center;
                gap:6px;
            }
            .timer-value {
                font-size: 18px;
            }
            .timer-label-small {
                font-size: 10px;
            }
            .stat-item {
                min-width: unset;
            }
            .stat-label {
                font-size: 0.8rem;
            }

            .timer-unit {
                min-width: 45px;
                padding: 10px 11px;
            }

            .amount {
                font-size: 42px;
            }
        }

        .whatsapp-input-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
 
    .country-code-wrapper {
        flex: 0 0 auto;
        min-width: 150px;
    }
 
    .whatsapp-number-wrapper {
        flex: 1;
        min-width: 200px;
    }
 
    .form-select {
        border: 1px solid #e0e0e0;
        border-radius: 0.375rem;
        padding: 0.625rem 0.875rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
 
    .form-select:focus {
        border-color: #F5A623;
        box-shadow: 0 0 0 0.2rem rgba(245, 166, 35, 0.25);
    }
 
    .form-select.is-invalid {
        border-color: #dc3545;
    }
 
    .form-select.is-valid {
        border-color: #198754;
    }
 
    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 0.375rem;
        padding: 0.625rem 0.875rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
 
    .form-control:focus {
        border-color: #F5A623;
        box-shadow: 0 0 0 0.2rem rgba(245, 166, 35, 0.25);
    }
 
    .form-control.is-invalid {
        border-color: #dc3545;
    }
 
    .form-control.is-valid {
        border-color: #198754;
    }
 
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
 
    .error-message {
        font-size: 0.875rem;
        margin-top: 0.375rem;
        display: none;
        color: #dc3545;
    }
 
    .error-message.show {
        display: block;
    }
 
    .text-danger {
        color: #dc3545;
    }
 
    .country-code-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
 
    @media (max-width: 576px) {
        .whatsapp-input-group {
            flex-direction: column;
        }
 
        .country-code-wrapper,
        .whatsapp-number-wrapper {
            min-width: 100%;
            width: 100%;
        }
    }

    .whatsapp-input-flex {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
    }
 
    .whatsapp-input-flex .country-code-wrapper {
        flex: 0 0 180px;
    }
 
    .whatsapp-input-flex .whatsapp-number-wrapper {
        flex: 1;
    }
 
    .whatsapp-input-flex .form-label {
        display: block;
        margin-bottom: 0.5rem;
    }
 
    @media (max-width: 768px) {
        .whatsapp-input-flex {
            flex-direction: column;
            align-items: stretch;
        }
 
        .whatsapp-input-flex .country-code-wrapper,
        .whatsapp-input-flex .whatsapp-number-wrapper {
            flex: 1;
        }
 
        .whatsapp-input-flex .whatsapp-number-wrapper {
            margin-top: 1rem;
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
    <!-- ==================== HEADER/NAVBAR ==================== -->
    <header class="header-navbar">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="#home">
                    <div class="brand-logo">
                        <img src="https://thesommnathbhattacharyaa.in/public/uploads/dark_logo/darklogo-1769084998.png"
                            alt="system logo" height="50" class="header-dark-logo">
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#learn">Learn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#mentor">Mentor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#testimonials">Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#faq">FAQ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container hero-content">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 text-center order-2 order-lg-1">    
                    <h5 class="text-warning fw-bold mb-3 d-md-block d-none">
                        Master 6 Powerful Skills in One Webinar
                    </h5>

                    <h1 class="hero-title">
                        Face Reading, Graphology (Hand Writing Analysis, Signature Analysis, Signature Astrology), Name Numerology, Mobile Numerology,
                        Pronology, Event & Relationship Numerology
                    </h1>

                    <p class="text-white mb-4" style="font-size: 1.2rem; opacity: 0.95;">
                        Jaane kaise aapka Face, Naam aur Signature aapki Career, Paisa aur
                        Relationships ko affect karta hai
                    </p>

                    <div class="trust-bar">

                        <div class="trust-item">
                            <i class="bi bi-award-fill"></i>

                            <div class="trust-item-text">
                                <span class="trust-item-number">20+</span>
                                <span class="trust-item-label">Years Experience</span>
                            </div>
                        </div>

                        <div class="trust-item">
                            <i class="bi bi-people-fill"></i>

                            <div class="trust-item-text">
                                <span class="trust-item-number">60,000+</span>
                                <span class="trust-item-label">Students Guided</span>
                            </div>
                        </div>

                        <div class="trust-item">
                            <i class="bi bi-broadcast"></i>

                            <div class="trust-item-text">
                                <span class="trust-item-number">Live</span>
                                <span class="trust-item-label">Interactive Session</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-5 col-md-6 mb-4 mb-md-0 order-1 order-lg-2">
                    <h5 class="text-warning fw-bold mb-3 text-center d-md-none d-block">
                        Master 6 Powerful Skills in One Webinar
                    </h5>
                    <div class="form-card">
                        <h2 class="form-title mb-0">Apni Seat Book Karein</h2>
                        <h4 class="form-title2">Book Your Seat Now</h4>
                        <div class="row">
                            {{-- Success Message --}}
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Laravel Form --}}
                            <form id="registrationForm" method="POST" action="{{ route('leads.store') }}">

                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="fullName" class="form-label">Full Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="fullName"
                                            value="{{ old('fullName') }}" id="fullName" minlength="3" maxlength="50"
                                            pattern="^[A-Za-z\s.]+$" required>
                                        <div class="error-message" id="fullName-error"></div>
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label for="whatsappNumber" class="form-label">WhatsApp Number <span
                                                class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="whatsappNumber"
                                            value="{{ old('whatsappNumber') }}" id="whatsappNumber" minlength="10"
                                            maxlength="10" pattern="[0-9]{10}" required>
                                        <div class="error-message text-danger" id="whatsappNumber-error">
                                            @error('whatsappNumber')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>                                    

                                    <!-- <div class="col-md-6 mb-2">
                                        <label for="city" class="form-label">City <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="city"
                                            value="{{ old('city') }}" id="city" minlength="2" maxlength="50"
                                            pattern="^[A-Za-z\s]+$" required>
                                        <div class="error-message" id="city-error"></div>
                                    </div> -->

                                    <!-- <div class="col-md-12 mb-2">
                                        <label for="mainConcern" class="form-label">
                                            Your Interest <span class="text-danger">*</span>
                                        </label>

                                        <select class="form-select" name="mainConcern" id="mainConcern" required>
                                            <option value="">Select Your Interest</option>
                                            <option value="face-reading">Face Reading</option>
                                            <option value="graphology">Graphology</option>
                                            <option value="name-numerology">Name Numerology</option>
                                            <option value="mobile-numerology">Mobile Numerology</option>
                                            <option value="pronology">Pronology</option>
                                            <option value="event-relationship-numerology">
                                                Event & Relationship Numerology
                                            </option>
                                            <option value="all-above">All of the Above</option>
                                        </select>
                                        <div class="error-message" id="mainConcern-error"></div>
                                    </div> -->
                                </div>

                                <button type="submit" class="btn-primary-custom">
                                    Continue to Book Your Seat
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Webinar Section -->
    <section class="webinar-section py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <!-- Left Side Video -->
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="video-box text-center">
                        <h2 class="offer-title">
                            What You’ll Learn in This Life Changing Webinar
                        </h2>
                        <iframe 
                            width="320"
                            height="476"
                            src="https://www.youtube.com/embed/SntavbMg3q8?autoplay=1&mute=1&loop=1&playlist=SntavbMg3q8"
                            title="6-in-1 Personality Decode Webinar"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen
                            style="max-width:100%; border-radius:20px;">
                        </iframe>
                    </div>
                </div>

                <!-- Right Side Offer Box -->
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="offer-box">
                        <h2 class="offer-title text-center">
                            Complete Your Registration
                        </h2>

                        <!-- Countdown -->
                        <div class="countdown-timer">
                            <div class="timer-label">
                                <i class="bi bi-alarm"></i>
                                Offer Expires In:
                            </div>

                            <div class="timer-display">
                                <div class="timer-unit">
                                    <span class="timer-value" id="days">00</span>
                                    <span class="timer-label-small">Days</span>
                                </div>

                                <div class="timer-unit">
                                    <span class="timer-value" id="hours">00</span>
                                    <span class="timer-label-small">Hours</span>
                                </div>

                                <div class="timer-unit">
                                    <span class="timer-value" id="minutes">00</span>
                                    <span class="timer-label-small">Minutes</span>
                                </div>

                                <div class="timer-unit">
                                    <span class="timer-value" id="seconds">00</span>
                                    <span class="timer-label-small">Seconds</span>
                                </div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="price-section">
                            <p class="price-note">
                                One-time investment for lifetime insights
                            </p>
                        </div>
                        <div class="mb-3">
                            <button class="btn-primary-custom">
                                Book My Seat Now 
                            </button>
                        </div>

                        <!-- Limited Seats -->
                        <div class="limited-seats">
                            <i class="bi bi-fire"></i>
                            <strong>Limited Seats Only</strong> – Register before 15 June 2026 • 8:00 PM
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hook Section -->
    <section class="hook-section" id="learn">
        <div class="container">
            <h2 class="section-title">Aapki Life Me Problems Ka Real Reason Kya Hai?</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="problem-card fade-in">
                        <i class="bi bi-x-circle"></i>
                        <h4>Naam ka Effect</h4>
                        <p>Shayad aapka naam aapki growth rok raha hai</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="problem-card fade-in">
                        <i class="bi bi-alarm"></i>
                        <h4>Signature ka Impact</h4>
                        <p>Shayad aapka signature aapke relationships ko impact kar raha hai</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="problem-card fade-in">
                        <i class="bi bi-eye"></i>
                        <h4>Face Patterns</h4>
                        <p>Shayad aapke face patterns hidden personality flaws reveal kar rahe hain</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <p style="font-size: 1.2rem; font-weight: 600; color: var(--primary);">
                    Most log unknowingly galat patterns follow karte hain.
                </p>
            </div>
        </div>
    </section>

    <!-- What You Will Learn -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">What You Will Learn in This Webinar</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="learning-card fade-in">
                        <div class="learning-icon">
                            <i class="bi bi-pen"></i>
                        </div>
                        <h4>Graphology</h4>
                        <p>Learn Signature Astrology, Handwriting Analysis, and Signature Analysis techniques.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="learning-card fade-in">
                        <div class="learning-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h4>Face Reading</h4>
                        <p>Understand facial expressions and features to analyze personality and behavior traits.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="learning-card fade-in">
                        <div class="learning-icon">
                            <i class="bi bi-123"></i>
                        </div>
                        <h4>Name Numerology</h4>
                        <p>Discover how name numbers influence personality, success, and life opportunities.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="learning-card fade-in">
                        <div class="learning-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                        <h4>Mobile Numerology</h4>
                        <p>Learn the impact of mobile numbers on energy, communication, and daily life.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="learning-card fade-in">
                        <div class="learning-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <h4>Pronology</h4>
                        <p>Explore advanced concepts and hidden patterns connected with personal vibrations.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="learning-card fade-in">
                        <div class="learning-icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h4>Event & Relationship Numerology</h4>
                        <p>Analyze compatibility, relationships, and important life events through numerology.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mentor Section -->
    <section class="mentor-section section" id="mentor">
        <div class="container mentor-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title text-white" style="text-align: left;">
                        Meet Your Mentor
                    </h2>
                    <ul class="expertise-list">
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Expert in Face Reading</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Master of Graphology</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Numerology Specialist</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Occult Sciences Authority</span>
                        </li>
                    </ul>
                    <div class="mentor-stats">
                        <div class="stat-item">
                            <span class="stat-number">20+</span>
                            <span class="stat-label">Years of Experience</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">60K+</span>
                            <span class="stat-label">Students Guided</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mentor-image-container">
                        <img class="builder-editable" width="100%" height="100%" builder-identity="8"
                            src="https://thesommnathbhattacharyaa.in/public/assets/frontend/default/image/profile.webp"
                            alt="logo">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section" id="testimonials">
        <div class="container">
            <h2 class="section-title">Participants Love This Webinar</h2>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="testimonial-card fade-in">
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
                    <div class="testimonial-card fade-in">
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
    </section>

    <!-- Offer Section -->
    <section class="offer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="offer-card fade-in">
                        <h2 class="text-white mb-5">Aapko Kya Milega</h2>
                        <ul class="offer-features">
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Live Interactive Webinar with Q&A</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Practical Learning with Real Examples</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Personal Insights Framework</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Direct Access to Expert Mentor</span>
                            </li>
                        </ul>
                        <div class="urgency-badge">
                            <!-- <i class="bi bi-alarm"></i>  -->
                            <div class="offer-date limited-text">
                                <p class="offer-date">
                                    <i class="bi bi-calendar-event-fill"></i>
                                    15 June 2026 |
                                    <i class="bi bi-alarm-fill"></i>
                                    8:00 PM onwards
                                </p>

                                <p class="limited-text mb-0">
                                    <i class="bi bi-fire"></i>
                                    Limited Seats – Jaldi Book Karein
                                </p>
                            </div>
                        </div>
                        <button class="btn-primary-custom mt-4">
                            Abhi Apni Seat Secure Karein 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section faq-section" id="faq">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq1">
                                    Face reading kya hota hai?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Face reading ek ancient art hai jisme facial features ko analyze karke personality,
                                    behavior, aur future tendencies ko samjha jata hai. Yeh scientifically backed
                                    technique hai jo aapke face ke patterns se aapki life ke different aspects reveal
                                    karti hai.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2">
                                    Numerology kaise kaam karti hai?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Numerology numbers ki vibrations ko study karti hai. Aapke naam, date of birth, aur
                                    mobile number me hidden numbers aapki life path, personality, aur opportunities ko
                                    influence karte hain. Is webinar me hum practical numerology techniques sikhayenge.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3">
                                    Kya yeh beginners ke liye hai?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Bilkul! Yeh webinar specially beginners ke liye designed hai. Aapko koi prior
                                    knowledge ki zarurat nahi hai. Hum basic se start karke step-by-step practical
                                    techniques sikhayenge jo aap turant apply kar sakte hain.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq4">
                                    Webinar kaise join karein?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Registration complete karne ke baad, aapko WhatsApp par webinar link aur joining
                                    details mil jayenge. Live session ke time par bas link par click karein aur join ho
                                    jayein. Very simple process hai.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq5">
                                    Kya recording milegi?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yeh live interactive session hai jiska maximum benefit live attend karne par milta
                                    hai. Recording availability ka decision webinar ke baad liya jayega. Isliye
                                    recommend hai ki aap live attend karein.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <section class="footer-cta">
        <div class="container">
            <h2>Apni Life Ko Decode Karne Ka Moka Miss Mat Karein</h2>
            <p class="text-white mb-4" style="font-size: 1.2rem;">
                Register now and transform your understanding of yourself
            </p>
            <button class="btn-primary-custom">
                Secure My Seat Now 
            </button>
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
        document.addEventListener("DOMContentLoaded", function () {

            // Countdown Target Date
            const targetDate = new Date("June 15, 2026 20:00:00").getTime();

            // Timer Function
            function updateTimer() {

                const now = new Date().getTime();
                const distance = targetDate - now;

                // If expired
                if (distance < 0) {

                    clearInterval(timerInterval);

                    document.getElementById("days").innerHTML = "00";
                    document.getElementById("hours").innerHTML = "00";
                    document.getElementById("minutes").innerHTML = "00";
                    document.getElementById("seconds").innerHTML = "00";

                    return;
                }

                // Calculations
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

                // Display Values
                document.getElementById("days").innerHTML =
                    String(days).padStart(2, '0');

                document.getElementById("hours").innerHTML =
                    String(hours).padStart(2, '0');

                document.getElementById("minutes").innerHTML =
                    String(minutes).padStart(2, '0');

                document.getElementById("seconds").innerHTML =
                    String(seconds).padStart(2, '0');
            }

            // Run first time
            updateTimer();

            // Start interval
            const timerInterval = setInterval(updateTimer, 1000);

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Laravel error
            const serverErrors = {
                whatsappNumber: "{{ $errors->first('whatsappNumber') }}"
            };

            Object.keys(serverErrors).forEach(field => {
                if (serverErrors[field]) {
                    const input = document.getElementById(field);
                    const errorDiv = document.getElementById(field + '-error');

                    if (input && errorDiv) {
                        input.classList.add('is-invalid');
                        errorDiv.textContent = serverErrors[field];
                    }
                }
            });


            // Real-time validation
            const formInputs = document.querySelectorAll('#registrationForm input, #registrationForm select');

            formInputs.forEach(input => {
                input.addEventListener('input', () => validateField(input));
                input.addEventListener('blur', () => validateField(input));
            });

            function validateField(field) {
                const value = field.value.trim();
                const fieldId = field.id;
                const errorDiv = document.getElementById(fieldId + '-error');

                let isValid = true;
                let errorMessage = '';

                field.classList.remove('is-invalid', 'is-valid');

                if (errorDiv) {
                    errorDiv.textContent = '';
                    errorDiv.classList.remove('show');
                }

                switch (fieldId) {

                    case 'fullName':
                        if (!value) {
                            isValid = false;
                            errorMessage = 'Full name required';
                        } else if (!/^[A-Za-z\s.]+$/.test(value)) {
                            isValid = false;
                            errorMessage = 'Only letters allowed';
                        }
                        break;

                    case 'whatsappNumber':
                        if (!/^[0-9]{10}$/.test(value)) {
                            isValid = false;
                            errorMessage = 'Enter valid 10 digit number';
                        }
                        break;

                    // case 'city':
                    //     if (!value) {
                    //         isValid = false;
                    //         errorMessage = 'City required';
                    //     }
                    //     break;

                    // case 'mainConcern':
                    //     if (!value) {
                    //         isValid = false;
                    //         errorMessage = 'Select concern';
                    //     }
                    //     break;
                }

                if (!isValid) {
                    field.classList.add('is-invalid');
                    if (errorDiv) {
                        errorDiv.textContent = errorMessage;
                        errorDiv.classList.add('show');
                    }
                } else {
                    field.classList.add('is-valid');
                }

                return isValid;
            }

            // Prevent numbers
            document.getElementById('fullName').addEventListener('keypress', e => {
                if (/[0-9]/.test(e.key)) e.preventDefault();
            });

            // document.getElementById('city').addEventListener('keypress', e => {
            //     if (/[0-9]/.test(e.key)) e.preventDefault();
            // });

            document.getElementById('whatsappNumber').addEventListener('keypress', e => {
                if (!/[0-9]/.test(e.key)) e.preventDefault();
            });

            // Submit
            document.getElementById('registrationForm').addEventListener('submit', function(e) {

                const fields = [
                    fullName,
                    whatsappNumber,
                    // city,
                    //mainConcern
                ];

                let valid = true;

                fields.forEach(f => {
                    if (!validateField(f)) valid = false;
                });

                // ❌ Stop only if validation fail
                if (!valid) {
                    e.preventDefault();
                    alert("Fix errors first");
                }

                const formData = {
                    fullName: fullName.value,
                    whatsappNumber: whatsappNumber.value,
                    //city: city.value,
                    //mainConcern: mainConcern.value
                };

                sessionStorage.setItem('webinarRegistration', JSON.stringify(formData));
            });
            
            // Scroll Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Smooth scroll for CTA buttons
        document.querySelectorAll('.btn-primary-custom').forEach(button => {
            button.addEventListener('click', function (e) {
                if (!this.closest('form')) {
                    e.preventDefault();
                    document.querySelector('#registrationForm').scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        });
        });
    </script> 
</body>

</html>
