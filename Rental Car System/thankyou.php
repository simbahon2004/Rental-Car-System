<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #0a0a0a;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5rem;
            background: rgba(10, 10, 10, 0.95);
            border-bottom: 1px solid rgba(255, 51, 102, 0.2);
        }
        .nav-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #ff3366;
        }
        .nav-logo span { color: #fff; }
        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        nav ul li a:hover { color: #ff3366; }
        .confirmation-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
        }
        .confirmation-box {
            background: #111;
            padding: 3rem 2.5rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 51, 102, 0.2);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        .success-icon {
            font-size: 4rem;
            color: #00cc88;
            margin-bottom: 1rem;
        }
        .confirmation-box h2 {
            color: #ff3366;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .confirmation-box .subtitle {
            color: #888;
            margin-bottom: 2rem;
        }
        .booking-details {
            background: #1a1a1a;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            text-align: left;
        }
        .booking-details .detail {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .booking-details .detail:last-child {
            border-bottom: none;
        }
        .booking-details .label {
            color: #888;
        }
        .booking-details .value {
            color: #fff;
            font-weight: 600;
        }
        .booking-details .value.highlight {
            color: #ff3366;
            font-size: 1.2rem;
        }
        .btn-primary {
            display: inline-block;
            padding: 0.9rem 2.5rem;
            background: linear-gradient(45deg, #ff0057, #ff3366);
            color: #fff;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 51, 102, 0.3);
        }
        @media (max-width: 768px) {
            nav { padding: 1rem 2rem; flex-direction: column; gap: 1rem; }
            .confirmation-box { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-logo">Rental<span>Car</span></div>
        <ul>
            <li><a href="landing.php">Home</a></li>
            <li><a href="cars.php">Cars</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="booking.php">Book Now</a></li>
        </ul>
    </nav>

    <div class="confirmation-container">
        <div class="confirmation-box">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Booking Confirmed!</h2>
            <p class="subtitle">Your rental booking has been successfully processed.</p>

            <div class="booking-details">
                <div class="detail">
                    <span class="label">Car</span>
                    <span class="value" id="carName">-</span>
                </div>
                <div class="detail">
                    <span class="label">Duration</span>
                    <span class="value" id="bookingDays">-</span>
                </div>
                <div class="detail">
                    <span class="label">Total Amount</span>
                    <span class="value highlight" id="totalAmount">-</span>
                </div>
            </div>

            <a href="booking.php" class="btn-primary">
                <i class="fas fa-car"></i> Book Another Car
            </a>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        document.getElementById('carName').textContent = urlParams.get('car') || '-';
        document.getElementById('bookingDays').textContent = urlParams.get('days') + ' day(s)' || '-';
        document.getElementById('totalAmount').textContent = '₱' + (parseFloat(urlParams.get('total')) || 0).toFixed(2);
    </script>
</body>
</html>