<?php
session_start();
require_once 'db.php';

$stmt = $pdo->query("SELECT * FROM cars ORDER BY name");
$cars = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Our Cars - Rental Car System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #0a0a0a;
            color: #fff;
            min-height: 100vh;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5rem;
            background: rgba(10, 10, 10, 0.95);
            border-bottom: 1px solid rgba(255, 51, 102, 0.2);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
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
        nav ul li a.active { color: #ff3366; }
        nav ul li a.active::after { width: 100%; }
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
        .nav-auth {
            display: flex;
            gap: 1rem;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 8rem 2rem 2rem;
        }
        .container h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .container h1 span {
            color: #ff3366;
        }
        .container .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 3rem;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        .car-card {
            background: #111;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 51, 102, 0.1);
            transition: all 0.3s;
        }
        .car-card:hover {
            transform: translateY(-10px);
            border-color: #ff3366;
            box-shadow: 0 10px 30px rgba(255, 51, 102, 0.2);
        }
        .car-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .car-card .info {
            padding: 1.5rem;
        }
        .car-card .info h3 {
            color: #fff;
            margin-bottom: 0.3rem;
        }
        .car-card .info .brand {
            color: #ff3366;
            font-size: 0.9rem;
        }
        .car-card .info .price {
            color: #ff3366;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        .car-card .info .status {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-available {
            background: rgba(0, 204, 136, 0.2);
            color: #00cc88;
        }
        .status-rented {
            background: rgba(255, 51, 102, 0.2);
            color: #ff3366;
        }
        .status-maintenance {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }
        .btn-book {
            display: inline-block;
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(45deg, #ff0057, #ff3366);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        .btn-book:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(255, 51, 102, 0.3);
        }
        .btn-book.disabled {
            background: #333;
            cursor: not-allowed;
        }
        .btn-book.disabled:hover {
            transform: none;
            box-shadow: none;
        }
        .no-cars {
            text-align: center;
            padding: 3rem;
            color: #888;
            font-size: 1.2rem;
        }
        .no-cars i {
            font-size: 3rem;
            color: #ff3366;
            display: block;
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            nav { padding: 1rem 2rem; flex-direction: column; gap: 1rem; }
            .container { padding: 6rem 1rem 1rem; }
            .car-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-logo">Rental<span>Car</span></div>
        <ul>
            <li><a href="landing.php">Home</a></li>
            <li><a href="cars.php" class="active">Cars</a></li>
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

    <div class="container">
        <h1>Our <span>Fleet</span></h1>
        <p class="subtitle">Choose from our premium selection of vehicles</p>
        
        <?php if (count($cars) > 0): ?>
            <div class="car-grid">
                <?php foreach ($cars as $car): ?>
                    <div class="car-card">
                        <img src="<?php echo $car['image'] ?: 'img/default-car.jpg'; ?>" alt="<?php echo htmlspecialchars($car['name']); ?>">
                        <div class="info">
                            <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                            <p class="brand"><?php echo htmlspecialchars($car['brand'] ?: 'Luxury Vehicle'); ?></p>
                            <p class="price">₱<?php echo number_format($car['price_per_day'], 2); ?> <span style="font-size:0.8rem;color:#888;">/ day</span></p>
                            <span class="status status-<?php echo $car['status']; ?>">
                                <?php echo ucfirst($car['status']); ?>
                            </span>
                            <?php if ($car['status'] == 'available'): ?>
                                <a href="booking.php?car_id=<?php echo $car['id']; ?>" class="btn-book">
                                    <i class="fas fa-calendar-check"></i> Book Now
                                </a>
                            <?php else: ?>
                                <a href="#" class="btn-book disabled">
                                    <i class="fas fa-times-circle"></i> Not Available
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-cars">
                <i class="fas fa-car-side"></i>
                <p>No cars available at the moment. Please check back later.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>