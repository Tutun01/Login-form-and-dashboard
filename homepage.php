<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
   <link rel="stylesheet" href="CSS/homepage.css">
</head>
<body>

<header>
    <h1>Welcome to the Home Page</h1>
</header>

<main>
    <h2>Hello, <?= htmlspecialchars($email) ?>!</h2>
    <p>You have successfully logged in.</p>
    <p>You can add content for registered users here — links, dashboard, etc.</p>

    <a href="logout.php" class="logout">Log Out</a>
</main>

</body>
</html>
