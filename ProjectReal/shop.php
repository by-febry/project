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
    <link rel="stylesheet" href="shops.css">
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
        </div>
    </div>
        
    </header>

    <!-- Main Content -->
    <main>
        <h1>Shop</h1>
        <div class="product-gallery">
            <div class="product-item">
                <img src="lambanog_product.webp" alt="Product 1">
                <h2>Lambanog</h2>
                <a href="product1.php">
                    <button class="bid-button">Check this out</button>  
                </a>
            </div>
            <div class="product-item">
                <img src="palayok.jfif" alt="Product 2">
                <h2>Palayok</h2>
                <a href="product2.php">
                    <button class="bid-button">Check this out</button>
                </a>
            </div>
            <div class="product-item">
                <img src="product3.jpg" alt="Product 3">
                <h2>Product Title 3</h2>
                <a href="product3.php">
                    <button class="bid-button">Check this out</button>
                </a>
            </div>
            <!-- Add more products as needed -->
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Footer</p>
    </footer>
</body>
</html>
<script src="script.js"></script>