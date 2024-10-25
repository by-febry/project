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

body {
    background-color: rgb(244, 244, 244); /* #f4f4f4 */
    color: rgb(51, 51, 51); /* #333 */
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


/* Product Gallery */
.row {
    display: flex;
    justify-content: space-evenly;
    flex-wrap: wrap;
    margin-top: 20px;
}

.thumbnail {
    background-color: rgb(255, 255, 255); /* #fff */
    border: 1px solid rgb(221, 221, 221); /* #ddd */
    padding: 25px;
    margin:10px;
 
    width: 100%;
    text-align: center;
    transition: transform 0.3s ease;
}

.thumbnail:hover {
    transform: translateY(-10px);
}

.thumbnail img {
    width: 100%;
    height: 200px; /* Set a fixed height for all thumbnails */
    object-fit: cover; /* Ensure image fits the thumbnail */
}

.caption h3 {
    margin: 10px 0;
}

/* Button Spacing */
.caption p {
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
}

.btn-primary, .btn-default {
    flex: 1;
    margin: 0 5px; /* Add margin to separate the buttons */
    padding: 10px;
    cursor: pointer;
    text-decoration: none; /* Remove underline from buttons */
}

.btn-primary {
    background-color: #008000; /* #C72C41 */
    color: rgb(255, 255, 255); /* #fff */
    border: none;
}

.btn-primary:hover {
    background-color: rgb(255, 215, 0); /* #FFD700 */
    color: #008000; /* #C72C41 */
}

.btn-default {
    background-color: rgb(221, 221, 221); /* #ddd */
    color: rgb(51, 51, 51); /* #333 */
    border: none;
}

.btn-default:hover {
    background-color: rgb(187, 187, 187); /* #bbb */
}

/* Footer Section */
footer {
    background-color: #8B0000; /* #C72C41 */
    color: rgb(255, 255, 255); /* #fff */
    padding: 20px 0;
    text-align: center;
    position: relative;
    width: 100%;
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

.footer-content .social-icons {
    list-style: none;
    display: flex;
    padding: 0;
}

.footer-content .social-icons li {
    margin: 0 10px;
}

.footer-content .social-icons li a img {
    width: 24px;
    height: 24px;
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

/* Price styling */
.price {
    font-size: 18px;  /* Maintain the larger font size for price */
    font-weight: bold;
    color: #008000;  /* Green color for the price */
    margin: 10px 0;
}

/* Quantity left styling */
.quantity-left {
    font-size: 12px;  /* Smaller font size for the quantity */
    color: #808080;   /* Gray color */
    font-weight: normal;
    float: right;     /* Align to the right */
    margin-top: -.3px; /* Adjust the vertical alignment slightly */
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

    <!-- Product Thumbnails -->
    <div class="row">
        <!-- Thumbnail 1 -->
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="img/lambanog_product.webp" alt="Lambanog">
                <div class="caption">
                    <h3>Lambanog</h3>
                    <p class="price">$20.00 <span class="quantity-left">Quantity Left: 10</span></p>

                    <p>
                        <a href="P1.php" class="btn btn-primary" role="button">Buy</a> 
                        <a href="#" class="btn btn-default" role="button">Add to Cart</a>
                    </p>
                </div>
            </div>
             <!-- Thumbnail 2 -->
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="img/palayok.jpg" alt="Palayok">
                <div class="caption">
                    <h3>Palayok</h3>
                    <p class="price">$20.00 <span class="quantity-left">Quantity Left: 10</span></p>

                    <p>
                        <a href="P2.php" class="btn btn-primary" role="button">Buy</a> 
                        <a href="#" class="btn btn-default" role="button">Add to Cart</a>
                    </p>
                </div>
            </div>
        </div>
        </div>

       

        <!-- Thumbnail 3 -->
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="img/handwoven basket.jpg" alt="Handwoven Basket">
                <div class="caption">
                    <h3>Handwoven Basket</h3>
                    <p class="price">$20.00 <span class="quantity-left">Quantity Left: 10</span></p>

                    <p>
                        <a href="P3.php" class="btn btn-primary" role="button">Buy</a> 
                        <a href="#" class="btn btn-default" role="button">Add to Cart</a>
                    </p>
                </div>
            </div>
            <!-- Thumbnail 4 -->
         <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="img/kapeng Barako.jpg" alt="Kapeng Barako">
                <div class="caption">
                    <h3>Kapeng Barako</h3>
                    <p class="price">$20.00 <span class="quantity-left">Quantity Left: 10</span></p>

                    <p>
                        <a href="P4.php" class="btn btn-primary" role="button">Buy</a> 
                        <a href="#" class="btn btn-default" role="button">Add to Cart</a>
                    </p>
                </div>
            </div>
        </div>
        </div>
         
        
         <!-- Thumbnail 5 -->
         <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="img/bagoong-balayan.jpg" alt="Bagoong Balayan">
                <div class="caption">
                    <h3>Bagoong Balayan</h3>
                    <p class="price">$20.00 <span class="quantity-left">Quantity Left: 10</span></p>

                    <p>
                        <a href="P5.php" class="btn btn-primary" role="button">Buy</a> 
                        <a href="#" class="btn btn-default" role="button">Add to Cart</a>
                    </p>
                </div>
            </div>
             <!-- Thumbnail 6 -->
         <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="img/Dried Fish.jpg" alt="Dried Fish (Tuyo)">
                <div class="caption">
                    <h3>Dried Fish (Tuyo)</h3>
                    <p class="price">$20.00 <span class="quantity-left">Quantity Left: 10</span></p>

                    <p>
                        <a href="P6.php" class="btn btn-primary" role="button">Buy</a> 
                        <a href="#" class="btn btn-default" role="button">Add to Cart</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

      

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
