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
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center; color:gray;">No users found in the database.</p>
        <?php endif; ?>
    </div>
</body>
</html>
