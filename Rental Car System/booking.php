<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$stmt = $pdo->query("SELECT * FROM cars WHERE status = 'available' ORDER BY name");
$cars = $stmt->fetchAll();

$selected_car_id = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Car</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
        .container {
            max-width: 700px;
            margin: 2rem auto;
            background: #111;
            padding: 3rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 51, 102, 0.1);
        }
        h2 {
            color: #ff3366;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #ddd;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #222;
            border-radius: 10px;
            font-size: 1rem;
            background: #1a1a1a;
            color: #fff;
            transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ff3366;
        }
        .form-group select option {
            background: #1a1a1a;
        }
        .btn-primary {
            width: 100%;
            background: linear-gradient(45deg, #ff0057, #ff3366);
            color: #fff;
            padding: 0.9rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 51, 102, 0.3);
        }
        .car-preview {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #1a1a1a;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 51, 102, 0.1);
        }
        .car-preview img {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }
        .car-preview .info {
            flex: 1;
        }
        .car-preview .info h4 {
            color: #ff3366;
        }
        .car-preview .info p {
            color: #888;
            font-size: 0.9rem;
        }
        .total-display {
            background: rgba(255, 51, 102, 0.1);
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            margin-top: 1rem;
            border: 1px solid rgba(255, 51, 102, 0.2);
        }
        .total-display h3 {
            color: #ff3366;
            font-size: 1.5rem;
        }
        @media (max-width: 768px) {
            nav { padding: 1rem 2rem; flex-direction: column; gap: 1rem; }
            .container { padding: 1.5rem; margin: 1rem; }
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

    <div class="container">
        <h2><i class="fas fa-car"></i> Book Your Car</h2>
        
        <div id="carPreview" class="car-preview" style="display:none;">
            <img id="previewImage" src="" alt="Car">
            <div class="info">
                <h4 id="previewName">Car Name</h4>
                <p id="previewPrice">₱0.00 / day</p>
            </div>
        </div>

        <form action="process_booking.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="car">Choose a Car</label>
                <select name="car_id" id="car" required onchange="updatePreview()">
                    <option value="">-- Select a Car --</option>
                    <?php foreach ($cars as $car): ?>
                        <option value="<?php echo $car['id']; ?>" 
                                data-name="<?php echo htmlspecialchars($car['name']); ?>" 
                                data-price="<?php echo $car['price_per_day']; ?>" 
                                data-image="<?php echo $car['image']; ?>"
                                <?php echo ($selected_car_id == $car['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($car['name']); ?> - ₱<?php echo number_format($car['price_per_day'], 2); ?>/day
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="start">Start Date & Time</label>
                <input type="datetime-local" name="start" id="start" required onchange="calculateTotal()">
            </div>

            <div class="form-group">
                <label for="end">End Date & Time</label>
                <input type="datetime-local" name="end" id="end" required onchange="calculateTotal()">
            </div>

            <div id="totalDisplay" class="total-display" style="display:none;">
                <p>Rental Duration: <strong id="daysDisplay">0</strong> day(s)</p>
                <h3>Total: ₱<span id="totalAmount">0.00</span></h3>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-check-circle"></i> Confirm Booking
            </button>
        </form>
    </div>

    <script>
        const carSelect = document.getElementById('car');
        const previewDiv = document.getElementById('carPreview');
        const previewImage = document.getElementById('previewImage');
        const previewName = document.getElementById('previewName');
        const previewPrice = document.getElementById('previewPrice');
        const startInput = document.getElementById('start');
        const endInput = document.getElementById('end');
        const totalDisplay = document.getElementById('totalDisplay');
        const daysDisplay = document.getElementById('daysDisplay');
        const totalAmount = document.getElementById('totalAmount');

        const now = new Date();
        const minDate = now.toISOString().slice(0, 16);
        startInput.min = minDate;
        endInput.min = minDate;

        function updatePreview() {
            const selected = carSelect.options[carSelect.selectedIndex];
            if (selected && selected.value) {
                const name = selected.dataset.name;
                const price = parseFloat(selected.dataset.price);
                const image = selected.dataset.image || 'img/default-car.jpg';
                
                previewImage.src = image;
                previewName.textContent = name;
                previewPrice.textContent = '₱' + price.toFixed(2) + ' / day';
                previewDiv.style.display = 'flex';
            } else {
                previewDiv.style.display = 'none';
            }
            calculateTotal();
        }

        function calculateTotal() {
            const start = new Date(startInput.value);
            const end = new Date(endInput.value);
            const selected = carSelect.options[carSelect.selectedIndex];
            
            if (!startInput.value || !endInput.value || !selected || !selected.value) {
                totalDisplay.style.display = 'none';
                return;
            }

            if (end <= start) {
                totalDisplay.style.display = 'none';
                return;
            }

            const diffTime = end - start;
            const days = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
            const price = parseFloat(selected.dataset.price);
            const total = days * price;

            daysDisplay.textContent = days;
            totalAmount.textContent = total.toFixed(2);
            totalDisplay.style.display = 'block';
        }

        function validateForm() {
            const start = new Date(startInput.value);
            const end = new Date(endInput.value);
            const selected = carSelect.options[carSelect.selectedIndex];

            if (!selected || !selected.value) {
                alert('Please select a car.');
                return false;
            }

            if (!startInput.value || !endInput.value) {
                alert('Please select start and end dates.');
                return false;
            }

            if (end <= start) {
                alert('End date must be after start date.');
                return false;
            }

            return true;
        }

        carSelect.addEventListener('change', updatePreview);
        startInput.addEventListener('change', calculateTotal);
        endInput.addEventListener('change', calculateTotal);

        // Update preview on page load if car_id is set
        if (<?php echo $selected_car_id; ?> > 0) {
            updatePreview();
        }
    </script>
</body>
</html>