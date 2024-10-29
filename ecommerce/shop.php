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
    <link rel="stylesheet" href="shop.css">
</head>
<style>
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
        display: flex;
        flex-direction: column;
        min-height: 100vh;
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

    /* Logo Section */
    header .logo img {
        max-height: 80px;
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
        color: rgb(0, 0, 0); /* Change text color to black when hovered */
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
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a,p {
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
        margin-top: auto; /* Ensure it stays at the bottom */
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




    </style>
<body>


    <!-- Navigation Bar -->
    <header>
    <div class="logo">
        <img src="img/Screenshot 2024-10-13 151839.png" alt="Logo" />
    </div>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="#">Library</a></li>
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
