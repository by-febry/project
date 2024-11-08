<?php
// Start the session at the top before any output
session_start();

// Include the database connection file
include 'connection.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user data from the database
    $query = "SELECT profile_picture, username FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    $profile_picture = $user['profile_picture'];
    $username = $user['username']; // Make sure $username is assigned properly here
} else {
    // If the user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Batangas - Shop</title>

    <!-- CSS styles -->
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        html,
        body {
            height: 100%;
            background-color: rgb(244, 244, 244);
            /* #f4f4f4 */
            color: rgb(51, 51, 51);
            /* #333 */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navigation Bar */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #8B0000;
            /* Dark Red background */
            padding: 10px 20px;
            color: rgb(255, 255, 255);
            /* White text color */
            font-size: 25px;
        }

        /* Logo Section */
        header .logo img {
            max-height: 50px;
            margin-top: 10px;
        }

        /* Navigation Links */
        header nav ul {
            list-style: none;
            display: flex;
            align-items: center;
        }

        header nav ul li {
            margin-right: 30px;
        }

        header nav ul li a {
            text-decoration: none;
            color: rgb(255, 255, 255);
            font-weight: bold;
        }

        header nav ul li a:hover {
            color: rgb(0, 0, 0);
            /* Change text color to black when hovered */
        }

        /* Circular Profile Picture or Default Circle */
        .user-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: #333;
            border: 2px solid #333;
        }

        /* Dropdown menu styling */
        .user-menu {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 150px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a,
        p {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .user-menu:hover .dropdown-content {
            display: block;
        }

        /* Username styling under the circle */
        .user-name {
            text-align: center;
            font-size: 12px;
            color: #333;
        }


        /* Footer Section */
        footer {
            background-color: #8B0000;
            color: rgb(255, 255, 255);
            padding: 20px 0;
            text-align: center;
            width: 100%;
            margin-top: auto;
            /* Ensure it stays at the bottom */
        }

        .footer-content p {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgb(0, 0, 0);
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Image Gallery Layout */
        .image-gallery {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .image-item {
            width: 300px;
            background-color: rgb(255, 255, 255);
            border-radius: 10px;
            margin: 20px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
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
            color: rgb(51, 51, 51);
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
            background-color: #a62b2b;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="img/logo3.png" alt="Logo" />
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="library.php">Library</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="#">About</a></li>

                <!-- User Profile Section -->
                <div class="user-menu">
                    <?php if (!empty($profile_picture)): ?>
                        <!-- If profile picture exists, show it -->
                        <img src="uploads/<?php echo $profile_picture; ?>" alt="Profile Picture" class="user-icon">
                    <?php else: ?>
                        <!-- If no profile picture, show default white circle -->
                        <div class="user-icon">
                            <?php
                            $initials = strtoupper($username[0]); // Display first letter of the username
                            echo $initials;
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Dropdown Menu -->
                    <div class="dropdown-content">
                        <p><?php echo $username; ?></p> <!-- Display username inside the dropdown -->
                        <a href="userpanel.php">Dashboard</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Your main content -->
        <div class="image-gallery">
            <div class="image-item">
                <img src="img/bakahan.jpg" alt="Product 1">
                <h3>Product 1</h3>
            </div>
            <div class="image-item">
                <img src="img/lambayok.webp" alt="Product 2">
                <h3>Product 2</h3>
            </div>
            <div class="image-item">
                <img src="img/tapusan.jpg" alt="Product 3">
                <h3>Product 3</h3>
            </div>
        </div>
        <div class="view-more-container">
            <a href="viewmore.php">
                <button class="view-more-btn">View More</button>
            </a>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Explore Batangas. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a> |
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>

</body>

</html>