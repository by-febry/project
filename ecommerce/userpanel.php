<?php
session_start(); // Start the session
include 'connection.php'; // Include the database connection

// Fetch user information if logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // Fetch user information
    $stmt = $conn->prepare("SELECT username, email, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();

    // Fetch order history
    $orderStmt = $conn->prepare("SELECT id, product_name, quantity, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC");
    $orderStmt->bind_param("i", $userId);
    $orderStmt->execute();
    $orderResult = $orderStmt->get_result();

    // Handle profile update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editProfile'])) {
        $newUsername = $_POST['username'];
        $newProfilePicture = $_FILES['profile_picture']['name'];
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($newProfilePicture);
        $uploadOk = 1;

        // Check if file is an image
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);
        if($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size (limit to 2MB)
        if ($_FILES['profile_picture']['size'] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                // Update user profile
                $stmtUpdate = $conn->prepare("UPDATE users SET username = ?, profile_picture = ? WHERE id = ?");
                $stmtUpdate->bind_param("ssi", $newUsername, $targetFile, $userId);
                if ($stmtUpdate->execute()) {
                    echo "Profile updated successfully!";
                } else {
                    echo "Error updating profile.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
} else {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/userpanel.css">
    <title>User Dashboard</title>
</head>
<body>

    <!-- Menu Section -->
    <div class="menu" id="menu">
        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <div class="menu-list">
            <a href="javascript:void(0)" onclick="goBack()" title="Go Back"><i class="fas fa-arrow-left"></i><span>Go Back</span></a>
            <a href="javascript:void(0)" onclick="loadContent('profile')" title="Profile"><i class="fas fa-user"></i><span>Profile</span></a>
            <a href="javascript:void(0)" onclick="loadContent('orderHistory')" title="Order History"><i class="fas fa-shopping-cart"></i><span>Order History</span></a>
            <a href="javascript:void(0)" onclick="loadContent('settings')" title="Settings"><i class="fas fa-cog"></i><span>Settings</span></a>
            <a href="logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content" id="content">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
        <p>Select an option from the menu to load content.</p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Function to toggle the menu width
        function toggleMenu() {
            var menu = document.getElementById("menu");
            menu.classList.toggle("collapsed");
        }

        // Function to go back to the previous page
        function goBack() {
            window.location.href = 'index.php'; // Redirects to index.php
        }

        // Function to load content dynamically based on the menu option selected
        function loadContent(page) {
            var contentDiv = document.getElementById("content");
            var username = '<?php echo htmlspecialchars($user['username']); ?>';
            var email = '<?php echo htmlspecialchars($user['email']); ?>';
            var profilePicture = '<?php echo htmlspecialchars($user['profile_picture']); ?>';
            var userId = '<?php echo htmlspecialchars($userId); ?>';

            // Change the content based on the selected page
            switch (page) {
                case 'profile':
                    contentDiv.innerHTML = `
                        <h1>Profile</h1>
                                <form action="settings/editProfile.php" method="POST">
                                 <h2>Change Username</h2>
                        <input type="username" name="username" value="${username}" required>
                        <input type="file" name="profile_picture" accept=".jpg, .jpeg, .png" required>
                       <form action="settings/editProfile.php" method="POST" enctype="multipart/form-data">

                        `;
                    break;
                case 'orderHistory':
                    contentDiv.innerHTML = `
                        <h1>Order History</h1>
                        <section>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($order = $orderResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $order['id']; ?></td>
                                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </section>
                    `;
                    break;
                case 'settings':
                    contentDiv.innerHTML = `
                        <h1>Settings</h1>
                        <form action="settings/editEmail.php" method="POST">
                            <h2>Change Email</h2>
                            <input type="email" name="email" value="${email}" required>
                            <button type="submit">Update Email</button>
                        </form>
                        <form action="settings/changePassword.php" method="POST">
                            <h2>Change Password</h2>
                            <input type="password" name="old_password" placeholder="Old Password" required>
                            <input type="password" name="new_password" placeholder="New Password" required>
                            <button type="submit">Change Password</button>
                        </form>
                    `;
                    break;
                case 'editProfile':
                    contentDiv.innerHTML = `
                        <h1>Edit Profile</h1>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="${userId}">
                            <label for="username">Username:</label>
                            <input type="text" name="username" value="${username}" required>
                            <label for="profile_picture">Profile Picture:</label>
                            <input type="file" name="profile_picture" accept="image/*">
                            <button type="submit" name="editProfile">Update Profile</button>
                        </form>
                    `;
                    break;
                default:
                    contentDiv.innerHTML = "<h1>Welcome</h1><p>Select an option from the menu to load content.</p>";
            }
        }
    </script>
</body>
</html>
<?php
session_start(); // Start the session
include 'connection.php'; // Include the database connection

// Fetch user information if logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // Fetch user information
    $stmt = $conn->prepare("SELECT username, email, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();

    // Fetch order history
    $orderStmt = $conn->prepare("SELECT id, product_name, quantity, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC");
    $orderStmt->bind_param("i", $userId);
    $orderStmt->execute();
    $orderResult = $orderStmt->get_result();

    // Handle profile update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editProfile'])) {
        $newUsername = $_POST['username'];
        $newProfilePicture = $_FILES['profile_picture']['name'];
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($newProfilePicture);
        $uploadOk = 1;

        // Check if file is an image
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);
        if($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size (limit to 2MB)
        if ($_FILES['profile_picture']['size'] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                // Update user profile
                $stmtUpdate = $conn->prepare("UPDATE users SET username = ?, profile_picture = ? WHERE id = ?");
                $stmtUpdate->bind_param("ssi", $newUsername, $targetFile, $userId);
                if ($stmtUpdate->execute()) {
                    echo "Profile updated successfully!";
                } else {
                    echo "Error updating profile.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
} else {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/userpanel.css">
    <title>User Dashboard</title>
</head>
<body>

    <!-- Menu Section -->
    <div class="menu" id="menu">
        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <div class="menu-list">
            <a href="javascript:void(0)" onclick="goBack()" title="Go Back"><i class="fas fa-arrow-left"></i><span>Go Back</span></a>
            <a href="javascript:void(0)" onclick="loadContent('profile')" title="Profile"><i class="fas fa-user"></i><span>Profile</span></a>
            <a href="javascript:void(0)" onclick="loadContent('orderHistory')" title="Order History"><i class="fas fa-shopping-cart"></i><span>Order History</span></a>
            <a href="javascript:void(0)" onclick="loadContent('settings')" title="Settings"><i class="fas fa-cog"></i><span>Settings</span></a>
            <a href="logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content" id="content">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
        <p>Select an option from the menu to load content.</p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Function to toggle the menu width
        function toggleMenu() {
            var menu = document.getElementById("menu");
            menu.classList.toggle("collapsed");
        }

        // Function to go back to the previous page
        function goBack() {
            window.location.href = 'index.php'; // Redirects to index.php
        }

        // Function to load content dynamically based on the menu option selected
        function loadContent(page) {
            var contentDiv = document.getElementById("content");
            var username = '<?php echo htmlspecialchars($user['username']); ?>';
            var email = '<?php echo htmlspecialchars($user['email']); ?>';
            var profilePicture = '<?php echo htmlspecialchars($user['profile_picture']); ?>';
            var userId = '<?php echo htmlspecialchars($userId); ?>';

            // Change the content based on the selected page
            switch (page) {
                case 'profile':
                    contentDiv.innerHTML = `
                        <h1>Profile</h1>
                                <form action="settings/editProfile.php" method="POST">
                                 <h2>Change Username</h2>
                        <input type="username" name="username" value="${username}" required>
                        <input type="file" name="profile_picture" accept=".jpg, .jpeg, .png" required>
                       <form action="settings/editProfile.php" method="POST" enctype="multipart/form-data">

                        `;
                    break;
                case 'orderHistory':
                    contentDiv.innerHTML = `
                        <h1>Order History</h1>
                        <section>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($order = $orderResult->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $order['id']; ?></td>
                                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </section>
                    `;
                    break;
                case 'settings':
                    contentDiv.innerHTML = `
                        <h1>Settings</h1>
                        <form action="settings/editEmail.php" method="POST">
                            <h2>Change Email</h2>
                            <input type="email" name="email" value="${email}" required>
                            <button type="submit">Update Email</button>
                        </form>
                        <form action="settings/changePassword.php" method="POST">
                            <h2>Change Password</h2>
                            <input type="password" name="old_password" placeholder="Old Password" required>
                            <input type="password" name="new_password" placeholder="New Password" required>
                            <button type="submit">Change Password</button>
                        </form>
                    `;
                    break;
                case 'editProfile':
                    contentDiv.innerHTML = `
                        <h1>Edit Profile</h1>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="${userId}">
                            <label for="username">Username:</label>
                            <input type="text" name="username" value="${username}" required>
                            <label for="profile_picture">Profile Picture:</label>
                            <input type="file" name="profile_picture" accept="image/*">
                            <button type="submit" name="editProfile">Update Profile</button>
                        </form>
                    `;
                    break;
                default:
                    contentDiv.innerHTML = "<h1>Welcome</h1><p>Select an option from the menu to load content.</p>";
            }
        }
    </script>
</body>
</html>
