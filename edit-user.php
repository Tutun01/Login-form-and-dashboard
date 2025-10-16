<?php
require_once "database.php";
session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<h2>Access denied.</h2>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "<h2>No user ID provided.</h2>";
    exit;
}

$id = intval($_GET['id']);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!empty($name) && !empty($email)) {
        $update = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = mysqli_prepare($connect, $update);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: admin_dashboard.php?success=1");
        exit;
    } else {
        $error = "All fields are required.";
    }
}


$query = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    echo "<h2>User not found.</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="CSS/editUser.css">
</head>
<body>
    <h2 class="title-admin">Edit User</h2>

    <?php if (isset($error)): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" class="edit-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <button type="submit" class="save-btn">Save Changes</button>
        <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
    </form>
</body>
</html>
