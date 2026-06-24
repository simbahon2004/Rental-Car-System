<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'db.php';

$error = "";
$success = "";
$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid request (CSRF token mismatch).";
    } else {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } elseif (strlen($password) < 8) {
            $error = "Password must be at least 8 characters long.";
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error = "Email is already registered.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                if ($stmt->execute([$name, $email, $hashedPassword])) {
                    $success = "Registration successful! Redirecting to login...";
                    $name = $email = "";
                    echo "<script>
                        setTimeout(() => {
                            window.location.href = 'login.php';
                        }, 3000);
                    </script>";
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register - Rental Car System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a0a0a 100%);
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
        .register-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
        }
        .register-box {
            background: #111;
            padding: 3rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 0 40px rgba(255, 51, 102, 0.15);
            max-width: 450px;
            width: 100%;
            border: 1px solid rgba(255, 51, 102, 0.1);
        }
        .register-box h2 {
            text-align: center;
            margin-bottom: 0.5rem;
            color: #ff3366;
            font-size: 2rem;
        }
        .register-box .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 2rem;
            font-size: 0.9rem;
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
        .form-group input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #222;
            border-radius: 10px;
            font-size: 1rem;
            background: #1a1a1a;
            color: #fff;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #ff3366;
        }
        .register-btn {
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
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 51, 102, 0.3);
        }
        .password-feedback {
            color: #ff3366;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }
        .error-message {
            color: #ff3366;
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.8rem;
            background: rgba(255, 51, 102, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(255, 51, 102, 0.2);
        }
        .success-message {
            color: #00cc88;
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.8rem;
            background: rgba(0, 204, 136, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(0, 204, 136, 0.2);
        }
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #888;
        }
        .login-link a {
            color: #ff3366;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover { text-decoration: underline; }
        @media (max-width: 768px) {
            nav { padding: 1rem 2rem; flex-direction: column; gap: 1rem; }
            .register-box { padding: 2rem 1.5rem; }
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
        </ul>
    </nav>

    <div class="register-container">
        <div class="register-box">
            <h2>Create Account</h2>
            <p class="subtitle">Join us and start renting</p>

            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required value="<?php echo htmlspecialchars($name); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password (min. 8 chars)" required>
                    <div id="passwordFeedback" class="password-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Repeat your password" required>
                    <div id="confirmFeedback" class="password-feedback"></div>
                </div>
                <button type="submit" class="register-btn">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </form>

            <div class="login-link">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm-password');
        const passwordFeedback = document.getElementById('passwordFeedback');
        const confirmFeedback = document.getElementById('confirmFeedback');

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            passwordFeedback.textContent = password.length < 8 ? "Password must be at least 8 characters long." : "";
        });

        confirmPasswordInput.addEventListener('input', () => {
            confirmFeedback.textContent = passwordInput.value !== confirmPasswordInput.value ? "Passwords do not match." : "";
        });
    </script>
</body>
</html>