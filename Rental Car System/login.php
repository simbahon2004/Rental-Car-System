<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: booking.php");
    exit();
}

require_once 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $passwordInput = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($passwordInput, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ];
        header("Location: booking.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - Rental Car System</title>
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
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
        }
        .login-box {
            background: #111;
            padding: 3rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 0 40px rgba(255, 51, 102, 0.15);
            max-width: 450px;
            width: 100%;
            border: 1px solid rgba(255, 51, 102, 0.1);
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 0.5rem;
            color: #ff3366;
            font-size: 2rem;
        }
        .login-box .subtitle {
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
        .login-btn {
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
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 51, 102, 0.3);
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
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #888;
        }
        .register-link a {
            color: #ff3366;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover { text-decoration: underline; }
        @media (max-width: 768px) {
            nav { padding: 1rem 2rem; flex-direction: column; gap: 1rem; }
            .login-box { padding: 2rem 1.5rem; }
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

    <div class="login-container">
        <div class="login-box">
            <h2>Welcome Back</h2>
            <p class="subtitle">Login to your account</p>

            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="login" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>