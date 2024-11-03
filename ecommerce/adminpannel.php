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

        .search-container {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-container input[type="text"] {
    width: 200px; /* Smaller width */
    padding: 6px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.search-container button {
    padding: 6px 12px;
    font-size: 14px;
    color: white;
    background-color: #8B0000;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.search-container button:hover {
    background-color: #a52a2a;
}
.add-user-form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .add-user-form h2 {
        color: #8B0000;
        margin-bottom: 15px;
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"],
    .form-group select {
        width: 95%;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: border-color 0.3s;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus,
    .form-group input[type="password"]:focus,
    .form-group select:focus {
        border-color: #8B0000;
    }

    .submit-btn {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        color: white;
        background-color: #8B0000;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #a52a2a;
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
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="userSearch" placeholder="Search by username or email...">
                <button onclick="filterUsers()">Search</button>
            </div>

            
            <h3>Existing Users</h3>
            <!-- Users Table -->
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
                <tbody id="userTable">
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
            <!-- Add User Form with Enhanced Styling -->
<form action="process.php" method="POST" class="add-user-form">
    <h2>Add New User</h2>
    <input type="hidden" name="action" value="add">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Username" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" required>
    </div>
    <div class="form-group">
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <button type="submit" class="submit-btn">Add User</button>
</form>
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

          // JavaScript function to filter users in the table based on search input
          function filterUsers() {
            let input = document.getElementById("userSearch").value.toLowerCase();
            let table = document.getElementById("userTable");
            let rows = table.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let username = rows[i].getElementsByTagName("td")[1];
                let email = rows[i].getElementsByTagName("td")[2];
                
                if (username || email) {
                    let usernameText = username.textContent || username.innerText;
                    let emailText = email.textContent || email.innerText;

                    if (usernameText.toLowerCase().includes(input) || emailText.toLowerCase().includes(input)) {
                        rows[i].style.display = ""; // Show the row
                    } else {
                        rows[i].style.display = "none"; // Hide the row
                    }
                }       
            }
        }

     
        
    </script>

</body>
</html>
