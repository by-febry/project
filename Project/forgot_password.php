<?php
session_start();
include 'connection.php'; // Include your database connection file

// Initialize message variable
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, generate a password reset token
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $expires = date("U") + 1800; // Token expires in 30 minutes

        // Insert token into the database
        $insertQuery = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ssi", $email, $token, $expires);
        $insertStmt->execute();

        // Prepare the reset link
        $resetLink = "http://yourdomain.com/reset_password.php?token=" . $token; // Replace with your actual domain

        // Send the email
        $to = $email;
        $subject = "Password Reset Request";
        $body = "Click here to reset your password: " . $resetLink;
        $headers = "From: noreply@yourdomain.com"; // Replace with your domain

        if (mail($to, $subject, $body, $headers)) {
            $message = "Check your email for the password reset link.";
        } else {
            $message = "Failed to send email.";
        }
    } else {
        $message = "No account found with that email.";
    }
}
?>

<!-- Below you would typically output the message to the user in the HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="login_register.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="shop.html">Shop</a></li>
                <li><a href="#">About</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Forgot Password</h1>
        <p>Enter your email address and we will send you instructions to reset your password.</p>
        <form action="" method="post" class="forgot-password-form">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <button type="submit">Send Reset Instructions</button>
        </form>
        <p><?php echo $message; ?></p> <!-- Display the message here -->
    </main>

    <footer>
        <p>Footer</p>
    </footer>
</body>
</html>
