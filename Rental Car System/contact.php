<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Contact Us</title>
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
        }
        nav ul li a:hover { color: #ff3366; }
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
        .contact-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }
        .contact-info h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .contact-info h1 span {
            color: #ff3366;
        }
        .contact-info .subtitle {
            color: #888;
            margin-bottom: 2rem;
            line-height: 1.8;
        }
        .contact-details {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .contact-detail {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #111;
            border-radius: 12px;
            border: 1px solid rgba(255, 51, 102, 0.1);
            transition: all 0.3s;
        }
        .contact-detail:hover {
            border-color: #ff3366;
            transform: translateX(5px);
        }
        .contact-detail i {
            font-size: 1.5rem;
            color: #ff3366;
            width: 40px;
            text-align: center;
        }
        .contact-detail .info h4 {
            color: #fff;
        }
        .contact-detail .info p {
            color: #888;
        }
        .contact-detail .info a {
            color: #ff3366;
            text-decoration: none;
        }
        .contact-form {
            background: #111;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 51, 102, 0.1);
        }
        .contact-form h2 {
            color: #ff3366;
            margin-bottom: 1.5rem;
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
        .form-group textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #222;
            border-radius: 10px;
            font-size: 1rem;
            background: #1a1a1a;
            color: #fff;
            transition: border-color 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff3366;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(45deg, #ff0057, #ff3366);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 51, 102, 0.3);
        }
        .map-container {
            margin-top: 3rem;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 51, 102, 0.1);
        }
        .map-container iframe {
            width: 100%;
            height: 300px;
            border: none;
        }
        @media (max-width: 768px) {
            nav { padding: 1rem 2rem; flex-direction: column; gap: 1rem; }
            .contact-wrapper { grid-template-columns: 1fr; gap: 2rem; }
            .container { padding: 6rem 1rem 1rem; }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-logo">Rental<span>Car</span></div>
        <ul>
            <li><a href="landing.php">Home</a></li>
            <li><a href="cars.php">Cars</a></li>
            <li><a href="contact.php" style="color:#ff3366;">Contact</a></li>
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
        <div class="contact-wrapper">
            <div class="contact-info">
                <h1>Get In <span>Touch</span></h1>
                <p class="subtitle">Have questions about our cars or booking process? We're here to help. Reach out to us anytime.</p>
                
                <div class="contact-details">
                    <div class="contact-detail">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="info">
                            <h4>Address</h4>
                            <p>123 Rent-A-Car Street, City, Country</p>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <i class="fas fa-phone"></i>
                        <div class="info">
                            <h4>Phone</h4>
                            <p><a href="tel:+09851489361">+09851489361</a></p>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <i class="fas fa-envelope"></i>
                        <div class="info">
                            <h4>Email</h4>
                            <p><a href="mailto:asimbahon7@example.com">asimbahon7@example.com</a></p>
                        </div>
                    </div>
                    <div class="contact-detail">
                        <i class="fas fa-clock"></i>
                        <div class="info">
                            <h4>Business Hours</h4>
                            <p>Mon - Sat: 8:00 AM - 8:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h2><i class="fas fa-paper-plane"></i> Send Us a Message</h2>

                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" placeholder="What is this about?" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" placeholder="Write your message here..." required></textarea>
                    </div>
                    <button type="button" class="btn-submit" onclick="sendMessage()">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509535!2d144.9537353153167!3d-37.81627997975159!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d5df1f8d6a7%3A0x5045675218ce6e0!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sus!4v1650000000000" allowfullscreen loading="lazy"></iframe>
        </div>
    </div>

    <script>
        function sendMessage() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            if (!name || !email || !subject || !message) {
                alert('Please fill in all fields.');
                return;
            }

            alert('Thank you for your message! We will get back to you soon.');
            document.getElementById('contactForm').reset();
        }
    </script>
</body>
</html>