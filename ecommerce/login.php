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
                    header("Location: adminpannel.php"); // Redirect to admin dashboard
                } else {
                    header("Location: home.php"); // Redirect to user dashboard
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
