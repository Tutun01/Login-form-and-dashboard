<?php
session_start();

require_once 'database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<h2>Access denied. Admins only.</h2>";
    exit;
}

$query = "SELECT * FROM users";
$result = mysqli_query($connect, $query);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
    <h2 class="title-admin">Welcome, Admin <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <a href="logout.php" class="logout">Log Out</a>

    <div id="allUser">
       <?php if (count($rows) > 0): ?>
            <table border="1" style="margin: 20px auto; color: white; border-collapse: collapse;">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Edit</th>
                </tr>
                <?php for ($i = 0; $i < count($rows); $i++): ?>
                    <tr>
                        <td><?= htmlspecialchars($rows[$i]['name']) ?></td>
                        <td><?= htmlspecialchars($rows[$i]['email']) ?></td>
                        <td>
                            <a href="edit-user.php?id=<?= urlencode($rows[$i]['ID']) ?>" class="edit-btn">Edit</a>
                            <form method="POST" action="delete-user.php" class="delete-form" onsubmit="return deleteUser(event, this);">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($rows[$i]['ID']) ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center; color:gray;">No users found in the database.</p>
        <?php endif; ?>
    </div>

    <div id="addNewUser">
        <form method="POST" action="add-user.php">
        <input type="text" name="name" placeholder="Enter name for a new user" required>
        <input type="email" name="email" placeholder="Enter email for a new user" required>
        <input type="password" name="password" placeholder="Enter password for a new user" required>
        <input type="text" name="role" placeholder="Enter role for a new user" required>
        <button type="submit" id="submitBtn">Add User</button>
    </form>
    </div>
    <script src="delete-user.js"></script>
</body>
</html>
