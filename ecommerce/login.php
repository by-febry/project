<?php
// Include the database connection
include 'connection.php';

// Your secret key from Google reCAPTCHA
$secretKey = "6LeOP2AqAAAAABbaTFsAFx7eXSc8-LAfc4clfw0X";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verify CAPTCHA response
    $captcha = $_POST['g-recaptcha-response'];

    if (!$captcha) {
        echo "Please check the reCAPTCHA box.";
        
    }

    // Send the response to Google's verification server
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response, true);

    // Check if reCAPTCHA is successful
    if (intval($responseKeys["success"]) !== 1) {
        echo "CAPTCHA verification failed. Please try again.";
    } else {
        // CAPTCHA was successful, proceed with login
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if the email exists
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Start a session and store user info
                session_start();
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];

                // Redirect based on the role
                if ($user['role'] == 'admin') {
                    header("Location: admin.php"); // Redirect to admin dashboard
                } else {
                    header("Location: dashboard.php"); // Redirect to user dashboard
                }
                exit();
            } else {
                echo "Incorrect password. Please try again.";
            }
        } else {
            echo "No user found with that email.";
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login_register.css">
    <!-- Google reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <!-- Navigation Bar -->
    <header>
    <div class="logo">
                <img src="img/Screenshot 2024-10-13 151839.png" alt="Logo" />
            </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="#">About</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        
    </header>

    <main>
        <h1>Login</h1>
        <form action="login.php" method="POST" class="login-form">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <!-- Google reCAPTCHA widget -->
            <div class="g-recaptcha" data-sitekey="6LeOP2AqAAAAAHQB2xmCuXSJzy1yqinSx01NeCxJ"></div>

            <button type="submit">Login</button>
            <p><a href="forgot_password.php">Forgot Password?</a></p>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </main>

     <!-- Footer -->
     <footer>
        <div class="footer-content">
            <p>&copy; 2024 Explore Batangas. All Rights Reserved.</p>
        </div>
        <div class="footer-links">
            <a href="#">Privacy Policy</a> | 
            <a href="#">Terms of Service</a> | 
            <a href="#">Contact Us</a>
        </div>
    </footer>
</body>
<script src="script.js"></script>
</html>
