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
    <title>Explore Batangas - Art Gallery</title>
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

   <!-- Main Content for Cultural Heritage -->
<main>
    <h2>*Cultural Heritage Part*</h2>
    <p>Festival, arts and crafts, and other cultural aspects related to Batangas.</p>
    <div class="cultural-heritage-layout">
        <!-- Gallery Item 1 -->
        <div class="gallery-item">
            <div class="gallery-content">
                <img src="lambayok.webp" alt="Gallery Item 1" />
                <div class="gallery-text">
                    <label class="gallery-label">Lambayok Festival</label>
                    <p>The Lambayok Festival is an annual celebration in San Juan, Batangas, Philippines, that highlights the town’s three main sources of livelihood: "Lambanog" (local coconut wine), "Palayok" (clay pots), and "Karagatan" (the sea). The festival showcases the town's rich cultural heritage through parades, street dances, and various contests. It's held every December and serves as a way to promote local products and tourism.</p>
                    <a href="#" class="products-btn">Products</a> 
                </div>
            </div>
        </div>

        <!-- Gallery Item 2 -->
        <div class="gallery-item">
            <div class="gallery-content">
                <img src="bakahan.jpg" alt="Gallery Item 2" />
                <div class="gallery-text">
                    <label class="gallery-label">Bakahan Festival</label>
                    <p>The Bakahan Festival is an annual event in San Juan, Batangas, Philippines, celebrating the town's cattle industry. Typically held in April, the festival features livestock parades, cattle shows, street dancing, and various competitions. It aims to promote agricultural practices, raise awareness about livestock farming, and highlight the community's cultural heritage. The festival fosters a sense of pride among locals and attracts tourists to the region.</p>
                    <a href="#" class="products-btn">Products</a> <!-- Added Products button -->
                </div>
            </div>
        </div>
        <div class="gallery-item">
            <div class="gallery-content">
                <img src="tapusan.jpg" alt="Gallery Item 3" />
                <div class="gallery-text">
                    <label class="gallery-label">Tapusan Festival</label>
                    <p>The Tapusan Festival is an annual celebration held in Batangas, Philippines, typically in January. It honors the tradition of "tapusan," which means "to end" in Filipino, marking the conclusion of the Christmas season and the feast of the Santo Niño (Child Jesus). The festival features colorful street parades, cultural performances, and various competitions, showcasing the rich heritage and traditions of the local community. It aims to foster unity among residents and highlight the significance of faith and gratitude in their lives.</p>
                    <a href="#" class="products-btn">Products</a> <!-- Added Products button -->
                </div>
            </div>
        </div>
    </div>
</main>


    

    <!-- Footer -->
    <footer>
        <p>Footer</p>
    </footer>
</body>
</html>
<script src="script.js"></script>