<?php
session_start(); // Start the session
include 'connection.php'; // Include the database connection

// Fetch user information if logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();
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
    <title>User Dashboard</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        /* Left Menu Section */
        .menu {
            width: 250px;
            background-color: #8B0000; /* Dark Red */
            border-right: 2px solid #ccc;
            color: white;
            transition: width 0.3s;
            overflow: hidden;
        }

        .menu.collapsed {
            width: 60px;
        }

        /* Menu Icon */
        .menu-icon {
            font-size: 24px;
            padding: 20px;
            cursor: pointer;
            text-align: center;
            border-bottom: 2px solid #ccc;
            color: white;
        }

        /* Menu List */
        .menu-list {
            padding: 20px;
        }

        .menu-list a {
            display: flex;
            align-items: center;
            padding: 10px;
            color: white; /* White text for menu options */
            text-decoration: none;
            font-size: 18px;
            transition: font-size 0.3s;
        }

        .menu-list a i {
            margin-right: 10px; /* Adjust spacing for icons */
        }

        .menu-list a:hover {
            background-color: #A52A2A; /* Slightly lighter red for hover */
        }

        /* Right Content Area */
        .content {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        /* Adjust content margin when menu is collapsed */
        .menu.collapsed + .content {
            margin-left: 60px;
        }

        /* Hide text when menu is collapsed, only show icons */
        .menu.collapsed .menu-list a span {
            display: none;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #8B0000; /* Dark Red for header */
            color: black;
            font-weight: bold;
            padding: 10px;
            border: 2px solid #000; /* Thicker border */
        }

        td {
            color: black;
            padding: 10px;
            border: 2px solid #000; /* Thicker border */
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Light grey for alternating rows */
        }

    </style>
    </style>
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
        window.history.back();
    }

    // Function to load content dynamically based on the menu option selected
    function loadContent(page) {
        var contentDiv = document.getElementById("content");

        // Change the content based on the selected page
        switch (page) {
            case 'profile':
                contentDiv.innerHTML = `
                    <h1>Profile</h1>
                    <p><strong>Username:</strong> ${'<?php echo htmlspecialchars($user['username']); ?>'}</p>
                    <p><strong>Email:</strong> ${'<?php echo htmlspecialchars($user['email']); ?>'}</p>
                    <button onclick="loadContent('editProfile')">Edit Profile</button>
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
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Populate this with PHP later -->
                            </tbody>
                        </table>
                    </section>
                `;
                // Fetch and display order history here
                fetchOrderHistory();
                break;
            case 'settings':
                contentDiv.innerHTML = "<h1>Settings</h1><p>Adjust your settings here.</p>";
                break;
            case 'editProfile':
                contentDiv.innerHTML = `
                    <h1>Edit Profile</h1>
                    <form action="editUsername.php" method="POST">
                        <input type="hidden" name="action" value="editProfile">
                        <input type="text" name="username" value="${'<?php echo htmlspecialchars($user['username']); ?>'}" required>
                        <input type="email" name="email" value="${'<?php echo htmlspecialchars($user['email']); ?>'}" required>
                        <button type="submit">Update</button>
                    </form>
                `;
                break;
            default:
                contentDiv.innerHTML = "<h1>Welcome</h1><p>Select an option from the menu to load content.</p>";
        }
    }

    // Function to fetch and display order history
    function fetchOrderHistory() {
        // Example: make an AJAX request to fetch order history from the server
        // For now, I'll just simulate it
        var contentDiv = document.getElementById("content");
        contentDiv.querySelector('tbody').innerHTML = `
            <tr>
                <td>1</td>
                <td>$20.00</td>
                <td>2024-10-25</td>
                <td>Completed</td>
            </tr>
            <tr>
                <td>2</td>
                <td>$15.00</td>
                <td>2024-10-26</td>
                <td>Pending</td>
            </tr>
        `;
    }
</script>


</body>
</html>
