<?php
session_start();

require_once 'database.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];

$sql= "SELECT * FROM products";
$result = $connect->query($sql); 

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
    <img class="logo-picture" src="images/logo.png" alt="logo">
    <h1 class="title-h1">Welcome to the Home Page</h1>
</header>

<main>
    <h2>Hello, <?= htmlspecialchars($email) ?>!</h2>
    <p>You have successfully logged in.</p>
    <p>You can add content for registered users here — links, dashboard, etc.</p>
    <a href="logout.php" class="logout">Log Out</a>
</main>

<main>
    <h2>Tech Blog</h2>
    <div class="slider-container">
        <button class="slide-btn prev">&#10094;</button>
        <div class="slider">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "
                    <div class='blog-card'>
                        <img src='" . htmlspecialchars($row['image_url']) . "' alt='Product image'>
                        <h3>" . htmlspecialchars($row['name']) . "</h3>
                        <p>" . htmlspecialchars($row['description']) . "</p>
                        <p><strong>Price:</strong> $" . number_format($row['price'], 2) . "</p>
                        <p><strong>In stock:</strong> " . $row['stock'] . "</p>
                        <a href='single_product.php?id=" . $row['id'] . "' class='buyBtn'>Buy Now</a>
                    </div>
                    ";
                }
            } else {
                echo "<p>No products available.</p>";
            }
            $connect->close();
            ?>
        </div>
        <button class="slide-btn next">&#10095;</button>
    </div>
</main>

 <script src="JS/slider.js"></script>
</body>
</html>
