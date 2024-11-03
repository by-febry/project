<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle "Add to Cart" request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_name'], $_POST['price'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    // Create a product array
    $product = [
        'name' => $product_name,
        'price' => $price,
        'quantity' => 1 // Default quantity when added
    ];

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    $product_names = array_column($_SESSION['cart'], 'name');
    if (in_array($product['name'], $product_names)) {
        // Increase quantity if product is already in the cart
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['name'] == $product['name']) {
                $cartItem['quantity']++;
                break;
            }
        }
    } else {
        // Add the product to the cart
        $_SESSION['cart'][] = $product;
    }
    header("Location: shop.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Batangas - Shop</title>
    <link rel="stylesheet" href="css/shops.css">
    <script src="script.js" defer></script>
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <div class="logo">
            <img src="img/logo3.png" alt="Logo" />
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Library</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="#">About</a></li>
                <li><a href="cart/view_cart.php">Cart (<span id="cartCount"><?php echo count($_SESSION['cart'] ?? []); ?></span>)</a></li>
                
                <!-- User Profile Section -->
                <div class="user-menu">
                    <?php if (!empty($profile_picture)): ?>
                        <img src="uploads/<?php echo $profile_picture; ?>" alt="Profile Picture" class="user-icon">
                    <?php else: ?>
                        <div class="user-icon">
                            <?php echo strtoupper($username[0]); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="dropdown-content">
                        <p><?php echo htmlspecialchars($username); ?></p>
                        <a href="userpanel.php">Dashboard</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </ul>
        </nav>
    </header>

    <!-- Search Bar -->
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search Festivals..." value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Product Thumbnails -->
    <div class="row">
        <?php
        // Example product array, replace with dynamic data from your database
        $products = [
            ['id' => 1, 'name' => 'Lambanog', 'price' => 20.00, 'image' => 'img/lambanog_product.webp'],
            ['id' => 2, 'name' => 'Palayok', 'price' => 20.00, 'image' => 'img/palayok.jpg'],
            ['id' => 3, 'name' => 'Handwoven Basket', 'price' => 20.00, 'image' => 'img/handwoven basket.jpg'],
            ['id' => 4, 'name' => 'Kapeng Barako', 'price' => 20.00, 'image' => 'img/kapeng Barako.jpg'],
            ['id' => 5, 'name' => 'Bagoong Balayan', 'price' => 20.00, 'image' => 'img/bagoong-balayan.jpg'],
            ['id' => 6, 'name' => 'Dried Fish (Tuyo)', 'price' => 20.00, 'image' => 'img/Dried Fish.jpg'],
        ];

        foreach ($products as $product): ?>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <div class="caption">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="price">$<?php echo number_format($product['price'], 2); ?> <span class="quantity-left">Quantity Left: 10</span></p>
                        <p>
                            <a href="P<?php echo $product['id']; ?>.php" class="btn btn-primary" role="button">Buy</a> 
                            <form method="POST" action="shop.php">
                                <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                <button type="submit" class="btn">Add to Cart</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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
