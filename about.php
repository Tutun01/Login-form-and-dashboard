<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <title>About us</title>
        <link rel="stylesheet" href="CSS/about.css">
        <link rel="stylesheet" href="CSS/navbar.css">
    </head>
    <body>

    <header>
        <img class="logo-picture" src="images/logo.png" alt="logo">
        <h1 class="title-h1">About us</h1>
        <nav class="navbar">
            <a href="homepage.php">Homepage</a>
            <a href="about.php">About us</a>
            <a href="shop.php">Shop</a>
            <a href="basket.php" class="basket-link">Cart</a>
        </nav>
    </header>

    <div class="mainDiv">
        <div class="first-section">
            <h2 class="title-h2">Who are we?</h2>
            <p class="first-text"><span style="font-weight: bold"> PC Market</span> is an online technology store focused on high-quality computer hardware and software solutions. <br>
                    We help customers build, upgrade, and optimize their PCs with carefully selected components from trusted brands.
            </p>

            <div class="image-content">
                <img src="images/who-we-are.jpeg" alt="PC hardware">
            </div>

        </div>

        <div class="second-section">
            <h2 class="title-h2">What we offer?</h2>
            <p class="second-text">Whether you're a gamer, content creator, developer, or everyday user, our goal is simple —
                to provide reliable products, competitive prices, and a smooth shopping experience.</p>
        </div>

        <div class="third-section">
            <h2 class="title-h2">Why choose us?</h2>
            <p class="third-text"> Carefully selected hardware and software <br>
                Competitive and transparent pricing <br>
                Fast and secure checkout <br>
                Reliable customer support <br>
                Products suitable for gaming, work, and everyday us
            </p>
        </div>

    </div>

    </body>
</html>
