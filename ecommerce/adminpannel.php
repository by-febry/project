<?php
session_start();
include 'connection.php'; // Include the database connection

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch user role to check if it's admin
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($user['role'] !== 'admin') {
        header("Location: home.php"); // Redirect to home if not an admin
        exit();
    }
} else {
    header("Location: login.php"); // Redirect if user not found
    exit();
}

// Fetch all users from the database
$query = "SELECT id, username, email, role FROM users";
$result = $conn->query($query);

// Fetch transactions from the database
$transactionQuery = "SELECT t.id, u.username, t.total_price AS amount, t.transaction_date AS created_at, t.status 
                     FROM Transactions t
                     JOIN users u ON t.user_id = u.id";
$transactionResult = $conn->query($transactionQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            background-color: #8B0000;
            color: white;
            border-right: 2px solid #ccc;
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
            padding: 20px 10px; /* Adjust padding for spacing */
        }

        .menu-list a {
            display: flex;
            align-items: center;
            padding: 10px;
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .menu-list a i {
            font-size: 24px; /* Increased icon size */
            margin-right: 10px; /* Space between icon and text */
            transition: margin-right 0.3s;
        }

        .menu.collapsed .menu-list a i {
            margin-right: 0; /* Remove margin when collapsed */
        }

        .menu-list a:hover {
            background-color: #a52a2a;
        }

        /* Hide text when collapsed */
        .menu.collapsed .menu-list a span {
            display: none; /* Hide text when menu is collapsed */
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

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        th, td {
            border: 2px solid black;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #8B0000;
            color: white;
        }

        td {
            color: black;
        }
    </style>
</head>
<body>

    <!-- Menu Section -->
    <div class="menu" id="menu">
        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <div class="menu-list">
            <a href="javascript:void(0)" onclick="loadContent('manageAccounts')">
                <i class="fas fa-users"></i><span>Manage Accounts</span>
            </a>
            <a href="javascript:void(0)" onclick="loadContent('transactions')">
                <i class="fas fa-money-check-alt"></i><span>Transactions</span>
            </a>
            </a>
            <a href="javascript:void(0)" onclick="loadContent('logout')">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </a>
        </div>
    </div>
    <!-- Content Section -->
    <div class="content" id="content">
        <h1>Welcome to the Dashboard</h1>
        <p>Select an option from the menu to load content.</p>
    </div>

    <script>
        // Function to toggle the menu width
        function toggleMenu() {
            var menu = document.getElementById("menu");
            menu.classList.toggle("collapsed");
        }
        
        // Function to load content dynamically based on the menu option selected
        function loadContent(page) {
            var contentDiv = document.getElementById("content");


            // Change the content based on the selected page
            switch (page) {
              case 'manageAccounts':
                    contentDiv.innerHTML = `
                        <h1>Manage Accounts</h1>
                        <section>
                            <form action="process.php" method="POST">
                                <input type="hidden" name="action" value="add">
                                <input type="text" name="username" placeholder="Username" required>
                                <input type="email" name="email" placeholder="Email" required>
                                <input type="password" name="password" placeholder="Password" required>
                                <select name="role" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <button type="submit">Add User</button>
                            </form>
                            <h3>Existing Users</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['role']; ?></td>
                                        <td>
                                            <form action="process.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="edit">
                                                <input type="hidden" name="userId" value="<?php echo $row['id']; ?>">
                                                <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
                                                <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
                                                <select name="role" required>
                                                    <option value="user" <?php echo $row['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                                    <option value="admin" <?php echo $row['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                </select>
                                                <button type="submit">Edit</button>
                                            </form>
                                            <form action="process.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="userId" value="<?php echo $row['id']; ?>">
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </section>
                    `;
                    break;
                case 'transactions':
                    contentDiv.innerHTML = `
                        <h1>Transactions</h1>
                        <section>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($transactionRow = $transactionResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $transactionRow['id']; ?></td>
                                        <td><?php echo $transactionRow['username']; ?></td>
                                        <td><?php echo $transactionRow['amount']; ?></td>
                                        <td><?php echo $transactionRow['created_at']; ?></td>
                                        <td><?php echo $transactionRow['status']; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </section>
                    `;
                    break;
                    case 'logout':
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = 'logout.php';
            }
            break;
                default:
                    contentDiv.innerHTML = "<h1>Welcome to the Dashboard</h1><p>Select an option from the menu to load content.</p>";
            }
        }

        
    </script>

</body>
</html>
