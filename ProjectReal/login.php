<?php
// Include the database connection
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login_register.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <div class="logo">Logo</div>
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
            
            <!-- Dropdown Menu -->
            <div class="dropdown-menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Sign Out</a>
            </div>
        </div>
        
    </header>


    <main>
        <h1>Login</h1>
        <form action="login.php" method="POST" class="login-form">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Login</button>
            <p><a href="forgot_password.php">Forgot Password?</a></p>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
       
        </form>
        
        
    </main>

    <!-- Footer -->
    <footer>
        <p>Footer</p>
    </footer>
</body>
<script src="script.js"></script>
</html>
