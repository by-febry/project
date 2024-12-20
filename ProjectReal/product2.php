

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
    <title>Product Details</title>
    <link rel="stylesheet" href="product.css">
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
        <div class="product-container">
            <div class="product-image">
                <img src="palayok.jfif" alt="Product Image" id="main-product-image">
            </div>
            <div class="product-details">
                <h1>Palayok</h1>
                <p>used in lambayok festival</p>
                <p class="availability">Availability: <span id="availability">In Stock</span></p>
                <div class="bidding-section">
                    <label for="bid-amount">Bid Amount:</label>
                    <input type="number" id="bid-amount" placeholder="Enter your bid" min="0" />
                    <button class="bid-button">Place a Bid</button>
                </div>
                    <h2>Bidders</h2>
                    <ul id="bidder-list">
                        <!-- Bidders will be appended here -->
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>Footer</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
