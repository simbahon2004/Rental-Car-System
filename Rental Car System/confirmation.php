<?php
$car = isset($_GET['car']) ? htmlspecialchars($_GET['car']) : '';
$days = isset($_GET['days']) ? (int) $_GET['days'] : '';
$price = isset($_GET['price']) ? (float) $_GET['price'] : '';
$total = isset($_GET['total']) ? (float) $_GET['total'] : '';
$start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : '';
$end = isset($_GET['end']) ? htmlspecialchars($_GET['end']) : '';

try {
    $formattedStart = $start ? (new DateTime($start))->format('F j, Y - H:i A') : '';
    $formattedEnd = $end ? (new DateTime($end))->format('F j, Y - H:i A') : '';
} catch (Exception $e) {
    $formattedStart = $formattedEnd = '';
}

$carImages = [
  "XPeng P7+" => "img/Xpeng P7.webp",
  "Kia K4" => "img/Kia-K4.webp",
  "Chevrolet Blazer EV" => "img/chevrolet-blazer-ev.webp",
  "Polestar 4" => "img/polestar-4.jpg",
  "Acura ZDX" => "img/acura-zdx-.jpg",
  "Xiaomi SU7" => "img/xiaomi_su7.webp",
  "Dodge Charger" => "img/dodge-charger.jpg",
  "BMW X7" => "img/OIP.jpg",
  "Toyota Land Cruiser" => "img/oyota-Toyota-.jpg"
];

$carImage = isset($carImages[$car]) ? $carImages[$car] : "img/default-placeholder.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmation</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #000;
      color: #fff;
      margin: 0;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      background-color: #111;
    }

    .navbar h2 {
      font-size: 24px;
      font-weight: 600;
      margin: 0;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      gap: 30px;
      margin: 0;
      padding: 0;
    }

    .navbar a {
      text-decoration: none;
      color: #fff;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .navbar a:hover {
      color: #ff3366;
    }

    h3 {
      text-align: center;
      font-size: 28px;
      margin: 40px 0 20px;
      color: #ff3366;
    }

    .confirmation-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px;
      background-color: #111;
      margin: 20px auto;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(255, 0, 87, 0.1);
      width: 80%;
      max-width: 900px;
    }

    .car-image {
      max-width: 500px;
      width: 100%;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .details {
      text-align: center;
    }

    .details p {
      font-size: 18px;
      margin: 10px 0;
      color: #ccc;
    }

    .details h4 {
      font-size: 24px;
      font-weight: 600;
      color: #ff3366;
    }

    .back-btn {
      margin-top: 20px;
      background-color: #ff3366;
      color: white;
      padding: 12px 25px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    .back-btn:hover {
      background-color: #ff0057;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <h2>Car Rentals</h2>
    <ul>
      <li><a href="landing.php">HOME</a></li>
      <li><a href="booking.php">BOOKINGS</a></li>
      <li><a href="#">CUSTOMER</a></li>
      <li><a href="#">Contact Us</a></li>
    </ul>
  </div>

  <h3>Booking Confirmation</h3>

  <div class="confirmation-container">
    <img class="car-image" src="<?php echo $carImage; ?>" alt="<?php echo $car; ?>">

    <div class="details">
      <?php if ($car && $days && $price && $total && $start && $end): ?>
        <h4>Thank you for your booking!</h4>
        <p>Car: <strong><?php echo $car; ?></strong></p>
        <p>Rental Duration: <strong><?php echo $days; ?> day<?php echo ($days > 1 ? 's' : ''); ?></strong></p>
        <p>Start: <strong><?php echo $formattedStart; ?></strong></p>
        <p>End: <strong><?php echo $formattedEnd; ?></strong></p>
        <p>Rate per Day: <strong>₱<?php echo number_format($price, 2); ?></strong></p>
        <p>Total: <strong>₱<?php echo number_format($total, 2); ?></strong></p>
      <button class="back-btn" onclick="window.location.href='booking.php?car=<?php echo urlencode($car); ?>&price=<?php echo $price; ?>&days=<?php echo $days; ?>'">Back to Car Listings</button>
      <?php else: ?>
        <h4>Invalid Booking</h4>
        <p>Missing booking details. Please go back and try again.</p>
        <button class="back-btn" onclick="window.location.href='booking.php'">Return to Booking</button>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
