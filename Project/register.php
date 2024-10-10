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
    <link rel="stylesheet" href="login_register.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <div class="logo">Logo</div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="shop.html">Shop</a></li>
                <li><a href="#">About</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
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
                <input type="password" id="password" name="password" required>

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
        <p>Footer</p>
    </footer>
</body>
</html>
<script src="script.js"></script>