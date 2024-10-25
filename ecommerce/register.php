<?php
// Include the database connection
include 'connection.php';

// Initialize message variable
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];  // Added confirm password

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
    } else {
        // Validate if email already exists
        $checkEmail = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmail);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already registered. Please try another one.";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database with default role 'user'
            $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $username, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message = "Registration successful!";
            } else {
                $message = "Error: " . $stmt->error;
            }
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
    <title>Register - Explore Batangas</title>
    <link rel="stylesheet" href="css/login_register.css">
</head>
<body>
    <!-- Navigation Bar -->
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
        <div class="login-circle">
            <!-- Trigger area for dropdown -->
            <div class="user-icon"></div>
        
        </div>
    </header>

    <!-- Main Content for Register -->
    <main>
        <h1>Register</h1>
        <div class="form-container">
            <form action="register.php" method="POST">

                <label for="username">Username:</label>
                <input type="username" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" pattern="(?=.*\d)[A-Za-z\d]{8,}" title="Password must be at least 8 characters long and contain at least one number." required>
                <small>Password must be at least 8 characters long and include at least one number.</small>
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>

                <button type="submit">Register</button>

                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
            <?php echo $message; ?>
        </div>
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
</html>
<script src="script.js"></script>