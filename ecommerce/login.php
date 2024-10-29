<?php
session_start(); // Start the session
include 'connection.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) { // Ensure passwords are hashed
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            
            // Check user role
            if ($user['role'] === 'admin') {
                header("Location: adminpannel.php"); // Redirect to admin panel
            } else {
                header("Location: home.php"); // Redirect to home.php for regular users
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }
}

$conn->close(); // Close the database connection
?>
