<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_id = isset($_POST['car_id']) ? (int)$_POST['car_id'] : 0;
    $start = $_POST['start'];
    $end = $_POST['end'];

    $stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ? AND status = 'available'");
    $stmt->execute([$car_id]);
    $car = $stmt->fetch();

    if (!$car) {
        die("Car not available.");
    }

    $start_date = new DateTime($start);
    $end_date = new DateTime($end);
    $interval = $start_date->diff($end_date);
    $total_days = max(1, $interval->days);
    $total_amount = $total_days * $car['price_per_day'];

    $stmt = $pdo->prepare("
        INSERT INTO bookings (user_id, car_id, car_name, start_date, end_date, total_days, price_per_day, total_amount, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");
    
    $stmt->execute([
        $_SESSION['user']['id'],
        $car_id,
        $car['name'],
        $start,
        $end,
        $total_days,
        $car['price_per_day'],
        $total_amount
    ]);

    $stmt = $pdo->prepare("UPDATE cars SET status = 'rented' WHERE id = ?");
    $stmt->execute([$car_id]);

    header("Location: thankyou.php?car=" . urlencode($car['name']) . "&days=" . $total_days . "&total=" . $total_amount . "&image=" . urlencode($car['image']));
    exit();
}
?>