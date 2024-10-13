<?php
// Include your database connection
include 'connection.php';
session_start();  // Start the session to access session data

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch user details, including profile picture and username
    $userId = $_SESSION['user_id'];
    $query = "SELECT username, profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($username, $profilePicture);
    $stmt->fetch();
    $stmt->close();
   
} else {
    
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Batangas</title>
    <link rel="stylesheet" href="style.css">
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
                <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                      <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                     <li><a href="login.php">Login</a></li>
                        <?php endif; ?>

                 </ul>
        </nav>
        <div class="login-circle">
    <!-- Profile Picture -->
    <?php if (isset($profilePicture) && !empty($profilePicture)): ?>
        <img src="<?php echo $profilePicture; ?>" alt="User Icon" class="user-icon" />
    <?php else: ?>
        <div class="user-icon"></div> <!-- Default icon if no profile picture -->
    <?php endif; ?>

    <!-- Username next to profile picture -->
    <?php if (isset($username)): ?>
        <span class="username"><?php echo htmlspecialchars($username); ?></span>
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
        <h1>Explore Batangas</h1>
        <div class="gallery">
            <div class="item">
                <img src="bakahan.jpg" alt="Bakahan Festival" >
                <div class="info">Bakahan Festival</div>
            </div>
            <div class="item">
                <img src="lambayok.webp" alt="Lambayok Festival" >
                <div class="info">Lambayok Festival</div>
            </div>
            <div class="item">
                <img src="tapusan.jpg" alt="Tapusan Festival">
                <div class="info">Tapusan Festival</div>
            </div>
        </div>
        
        <a href="viewmore.php" class="view-more">
            <button class="feature">Explore More!</button>
        </a>
    </main>

  
</body>
  <!-- Footer -->
  <footer>
    <p>Footer</p>
</footer>
<script src="script.js"></script>
</html>
