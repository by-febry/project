<?php
// Include your database connection
include 'connection.php';
session_start();  // Start the session to access session data

// Initialize the profile picture variable
$profilePicture = 'default_profile_picture.jpg'; // Set a default image for guests

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch user details, including profile picture
    $userId = $_SESSION['user_id'];
    $query = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($profilePicture);
    $stmt->fetch();
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Batangas - Shop</title>
    <link rel="stylesheet" href="shop.css">
</head>
<style>
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

html, body {
    height: 100%;
    background-color: rgb(244, 244, 244); /* #f4f4f4 */
    color: rgb(51, 51, 51); /* #333 */
}

body {
    display: flex;
    flex-direction: column;
}

/* Wrapper for content */
.wrapper {
    flex: 1; /* Allows the wrapper to grow and fill the available space */
}

/* Navigation Bar */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #8B0000; /* Dark Red background */
    padding: 10px 20px;
    color: rgb(255, 255, 255); /* White text color */
    font-size: 25px;
}

/* Logo Section in the Header */
header .logo img {
    max-height: 80px;  /* Adjust this value based on header height */
}

/* Navigation Links */
header nav {
    margin-left: auto; /* Pushes the navigation links to the right */
}

header nav ul {
    list-style: none;   /* Removes bullet points from list */
    display: flex;      /* Displays list items in a row */
}

/* Individual List Items */
header nav ul li {
    margin-right: 30px; /* Space between menu items */
}

/* Links in Navigation */
header nav ul li a {
    text-decoration: none; /* Removes underline from links */
    color: rgb(255, 255, 255); /* White text color */
    font-weight: bold;
}

/* Hover Effect on Links */
header nav ul li a:hover {
    color: rgb(0, 0, 0); /* Changes text color to black when hovered */
}


/* Container for each image */
.image-item {
    width: 300px;
    background-color: rgb(255, 255, 255); /* Container box background */
    border-radius: 10px;
    margin: 20px;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Image Gallery Layout */
.image-gallery {
    display: flex;
    justify-content: space-evenly;
    flex-wrap: wrap;
    margin-top: 50px;
}

.image-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.image-item h3 {
    margin-top: 10px;
    font-size: 18px;
    color: rgb(51, 51, 51); /* Title color */
}

/* Button Styling */
.view-more-container {
    text-align: center;
    margin-top: 100px;
}

.view-more-btn {
    padding: 10px 20px;
    background-color: #8B0000;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}

.view-more-btn:hover {
    background-color: #a62b2b; /* Slightly lighter red on hover */
}

/* Footer Section */
footer {
    background-color: #8B0000; /* #C72C41 */
    color: rgb(255, 255, 255); /* #fff */
    padding: 20px 0;
    text-align: center;
    width: 100%;
    /* Stick the footer to the bottom */
    margin-top: auto;
}

.footer-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.footer-content p {
    margin-bottom: 10px;
}

.footer-links {
    margin-top: 10px;
}

.footer-links a {
    color: rgb(0, 0, 0); 
    text-decoration: none;
    margin: 0 10px;
}

.footer-links a:hover {
    text-decoration: underline;
}

.login-circle {
    position: relative;
    cursor: pointer;
}

.user-icon {
    /* Adjust styles for the default icon or profile image here */
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #ccc; /* Default background for empty user icon */
}

.dropdown-menu {
    display: none; /* Hidden by default */
    position: absolute;
    top: 30px; /* Position it just below the circle */
    right: 0; /* Align to the right of the circle */
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
    z-index: 10; /* Ensure dropdown appears above other elements */
}

.login-circle:hover .dropdown-menu {
    display: block; /* Show dropdown on hover */
}

.dropdown-menu a {
    display: block;
    padding: 10px;
    color: black;
    text-decoration: none;
    font-size: 20px;
}

.dropdown-menu a:hover {
    background-color: #8B0000;
    color: white;
}

</style>
<body>

    <!-- Wrapper for content -->
    <div class="wrapper">

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
                  <?php if ($profilePicture): ?>
                   <img src="<?php echo $profilePicture; ?>" alt="User Icon" class="user-icon" />
                 <?php else: ?>
              <div class="user-icon"></div> <!-- Default icon if no profile picture -->
                 <?php endif; ?>
    
    <!-- Dropdown Menu -->
        <div class="dropdown-menu">
             <a href="dashboard.php">Dashboard</a>
             <a href="logout.php">Sign Out</a>
             <?php if (isset($_SESSION['user_id'])): ?>
                <a href="account.php">Account Information</a></li>
                <?php else: ?>
                <a href="login.php">Account Information</a></li>
                <?php endif; ?>    
        </div>
        
    </header>
        <!-- Image Gallery with individual containers -->
        <div class="image-gallery">
            <div class="image-item">
                <img src="img/bakahan.jpg" alt="Bakahan Festival">
                <h3>Bakahan Festival</h3>
            </div>
            <div class="image-item">
                <img src="img/tapusan.jpg" alt="Tapusan Festival">
                <h3>Tapusan Festival</h3>
            </div>
            <div class="image-item">
                <img src="img/lambayok.webp" alt="Lambayok Festival">
                <h3>Lambayok Festival</h3>
            </div>
        </div>

        <!-- View More Button -->
<div class="view-more-container">
    <a href="viewmore.php" class="view-more-btn">View More</a>
</div>


    </div> <!-- End of Wrapper -->

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
