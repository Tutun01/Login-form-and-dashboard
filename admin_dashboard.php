<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<h2 style='color:red; text-align:center;'>Access denied. Admins only.</h2>";
    exit;
}
echo "<h2>Welcome, Admin " . htmlspecialchars($_SESSION['name']) . "!</h2>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
    <h2>Welcome, Admin <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <a href="logout.php" class="logout">Log Out</a>
</body>
</html>
