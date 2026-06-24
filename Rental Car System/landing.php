<?php
session_start();
require_once 'db.php';

$stmt = $pdo->query("SELECT COUNT(*) as total FROM cars WHERE status = 'available'");
$carCount = $stmt->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Rental Car System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0a0a0a;
            color: #fff;
            overflow-x: hidden;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5rem;
            background: rgba(10, 10, 10, 0.95);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
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
            position: relative;
        }
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #ff3366;
            transition: width 0.3s;
        }
        nav ul li a:hover::after { width: 100%; }
        nav ul li a:hover { color: #ff3366; }
        .nav-auth {
            display: flex;
            gap: 1rem;
        }
        .nav-auth .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login {
            border: 2px solid #ff3366;
            color: #ff3366;
        }
        .btn-login:hover {
            background: #ff3366;
            color: #fff;
        }
        .btn-register {
            background: #ff3366;
            color: #fff;
        }
        .btn-register:hover {
            background: #ff0057;
            transform: scale(1.05);
        }
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8rem 5rem 4rem;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a0a0a 100%);
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            right: -200px;
            top: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 51, 102, 0.1), transparent 70%);
            border-radius: 50%;
        }
        .hero-text {
            max-width: 50%;
            z-index: 1;
        }
        .hero-text h1 {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        .hero-text h1 span {
            color: #ff3366;
        }
        .hero-text p {
            color: #aaa;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.8;
        }
        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 2rem;
        }
        .hero-stats .stat {
            text-align: center;
        }
        .hero-stats .stat h3 {
            font-size: 2.5rem;
            color: #ff3366;
        }
        .hero-stats .stat p {
            font-size: 0.9rem;
            color: #888;
            margin: 0;
        }
        .hero-image {
            position: relative;
            z-index: 1;
        }
        .hero-image img {
            width: 450px;
            height: 450px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid rgba(255, 51, 102, 0.3);
            box-shadow: 0 0 60px rgba(255, 51, 102, 0.2);
        }
        .hero-image .glow {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 51, 102, 0.2), transparent 70%);
            top: -25px;
            left: -25px;
            z-index: -1;
            animation: pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 1; }
        }
        .btn-primary {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: linear-gradient(45deg, #ff0057, #ff3366);
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 51, 102, 0.3);
        }
        .features {
            padding: 5rem;
            background: #0a0a0a;
        }
        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
        }
        .features h2 span {
            color: #ff3366;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-card {
            background: #111;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid rgba(255, 51, 102, 0.1);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            border-color: #ff3366;
            box-shadow: 0 10px 30px rgba(255, 51, 102, 0.2);
        }
        .feature-card i {
            font-size: 3rem;
            color: #ff3366;
            margin-bottom: 1rem;
        }
        .feature-card h3 {
            margin-bottom: 0.5rem;
        }
        .feature-card p {
            color: #888;
            font-size: 0.95rem;
        }
        .footer {
            background: #111;
            padding: 3rem 5rem;
            text-align: center;
            border-top: 1px solid rgba(255, 51, 102, 0.1);
        }
        .footer p {
            color: #888;
            margin: 0.5rem 0;
        }
        .footer a {
            color: #ff3366;
            text-decoration: none;
        }
        @media (max-width: 768px) {
            nav { padding: 1rem 2rem; flex-direction: column; gap: 1rem; }
            nav ul { flex-wrap: wrap; justify-content: center; }
            .hero { flex-direction: column; padding: 6rem 2rem 2rem; text-align: center; }
            .hero-text { max-width: 100%; }
            .hero-text h1 { font-size: 2.5rem; }
            .hero-image img { width: 300px; height: 300px; }
            .hero-stats { justify-content: center; }
            .features { padding: 2rem; }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-logo">Rental<span>Car</span></div>
        <ul>
            <li><a href="landing.php">Home</a></li>
            <li><a href="landing.php#features">Features</a></li>
            <li><a href="cars.php">Cars</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="nav-auth">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="booking.php" class="btn btn-register">Book Now</a>
                <a href="logout.php" class="btn btn-login">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-login">Login</a>
                <a href="register.php" class="btn btn-register">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <section class="hero" id="home">
        <div class="hero-text">
            <h1>Drive Your <span>Dream Car</span> Today</h1>
            <p>Experience luxury and performance with our premium fleet. Affordable rates, easy booking, and exceptional service.</p>
            <a href="<?php echo isset($_SESSION['user']) ? 'booking.php' : 'register.php'; ?>" class="btn-primary">
                <i class="fas fa-car"></i> Get Started
            </a>
            <div class="hero-stats">
                <div class="stat">
                    <h3><?php echo $carCount; ?></h3>
                    <p>Available Cars</p>
                </div>
                <div class="stat">
                    <h3>500+</h3>
                    <p>Happy Customers</p>
                </div>
                <div class="stat">
                    <h3>4.9★</h3>
                    <p>Rating</p>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <div class="glow"></div>
            <img src="img/car.jpg" alt="Luxury Car" />
        </div>
    </section>

    <section class="features" id="features">
        <h2>Why Choose <span>Us</span></h2>
        <div class="feature-grid">
            <div class="feature-card">
                <i class="fas fa-map-marked-alt"></i>
                <h3>Free GPS</h3>
                <p>Every rental comes with a free GPS navigation system.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-truck"></i>
                <h3>Delivery & Pickup</h3>
                <p>We deliver to your location and pick up when you're done.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Insurance Options</h3>
                <p>Choose from comprehensive insurance plans.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-tags"></i>
                <h3>Long-Term Discounts</h3>
                <p>Significant discounts for weekly and monthly rentals.</p>
            </div>
        </div>
    </section>

    <footer class="footer" id="contact">
        <p>&copy; 2025 Rental Car System. All rights reserved.</p>
        <p>Contact: <a href="tel:+09851489361">+09851489361</a></p>
        <p>Email: <a href="mailto:asimbahon7@example.com">asimbahon7@example.com</a></p>
    </footer>
</body>
</html>