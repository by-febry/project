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

        <!-- Cultural Section Management -->
        <section>
            <h2>Manage List Cultural Section</h2>
            <div class="cultural-section-actions">
                <button onclick="location.href='add_cultural.html'">Add</button>
                <button onclick="location.href='edit_cultural.html'">Edit</button>
                <button onclick="location.href='delete_cultural.html'">Delete</button>
            </div>
        </section>

        <!-- Transactions Management -->
        <section>
            <h2>Transactions</h2>
            <div class="transaction-actions">
                <button onclick="location.href='ongoing_transactions.html'">Ongoing Transactions</button>
                <button onclick="location.href='failed_transactions.html'">Failed Transactions</button>
                <button onclick="location.href='completed_transactions.html'">Completed Transactions</button>
            </div>
        </section>

        <!-- Account Management -->
        <section>
            <h2>Manage Accounts</h2>
            <div class="account-actions">
                <button onclick="location.href='existing_accounts.html'">Existing Accounts</button>
                <button onclick="location.href='new_registered_users.html'">New Registered Users</button>
                <button onclick="location.href='approval_verification.html'">Approval of Verification</button>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>Admin Interface &copy; 2024</p>
    </footer>
</body>
</html>
<script src="script.js"></script>