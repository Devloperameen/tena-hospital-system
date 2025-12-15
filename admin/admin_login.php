<?php
require_once '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please enter username and password!";
    } else {
        $sql = "SELECT * FROM admin WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            $admin = mysqli_fetch_assoc($result);
            
            // For simplicity, using plain text comparison
            // In real project, use password_hash and password_verify
            if ($password == $admin['password']) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error = "Invalid password!";
            }
        } else {
            $error = "Username not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Tena Hospital</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>TENA <span>HOSPITAL</span> - ADMIN</h1>
                </div>
                <nav class="nav">
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Admin Login</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn" style="width:100%">Login</button>
            </form>

            <p style="text-align:center; margin-top:20px;">
                username: <strong>admin</strong>, password: <strong>admin123</strong>
            </p>
        </div>
    </div>
</body>
</html>