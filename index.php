<?php
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tena Hospital - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>TENA <span>HOSPITAL</span></h1>
                </div>
                <nav class="nav">
                    <ul>
                        <li><a href="index.php" data-icon="home">Home</a></li>
                        <li><a href="login.php" data-icon="login">Patient Login</a></li>
                        <li><a href="register.php" data-icon="register">Register</a></li>
                        <li><a href="admin/admin_login.php" data-icon="admin">Admin Login</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="hero">
            <h2 data-icon="hospital">Welcome to Tena Hospital</h2>
            <p>Your Health, Our Priority</p>
            <div style="margin: 30px 0;">
                <a href="register.php" class="btn btn-secondary">Register Now</a>
                <a href="login.php" class="btn">Patient Login</a>
            </div>
        </div>

        <div class="features">
            <div class="feature-box">
                <h3 data-icon="booking">Easy Booking</h3>
                <p>Book appointments online easily</p>
            </div>
            <div class="feature-box">
                <h3 data-icon="doctors">Expert Doctors</h3>
                <p>Professional medical staff</p>
            </div>
            <div class="feature-box">
                <h3 data-icon="service">24/7 Service</h3>
                <p>Always here to help you</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Tena Hospital. All rights reserved.</p>
            <p>Contact: 0712 345 678 | Email: info@tenahospital.com</p>
        </div>
    </div>
</body>
</html>
