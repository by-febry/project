<?php
// Include your database connection
include 'connection.php';

// Fetch all users from the database
$query = "SELECT id, username, email, role FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <div class="logo">Admin Panel</div>
        <nav>
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Admin Interface -->
    <main>
        <h1>Admin Interface</h1>

        <!-- Account Management -->
        <section>
            <h2>Manage Accounts</h2>
            
            <!-- Form to Add New User -->
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

            <!-- Display Existing Users -->
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
                                <!-- Edit and Delete buttons -->
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
    </main>

    <!-- Footer -->
    <footer>
        <p>Admin Interface &copy; 2024</p>
    </footer>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
