<?php

    global $connect;
    session_start();
    require_once 'database.php';

    $sql= "SELECT * FROM products";
    $result = $connect->query($sql);

?>

<html>
    <head>
        <title>Shop</title>
        <link rel="stylesheet" href="CSS/shop.css">
        <link rel="stylesheet" href="CSS/navbar.css">
    </head>

    <body>

    <header>
        <img class="logo-picture" src="images/logo.png" alt="logo">
        <h1 class="title-h1">Shop</h1>
        <nav class="navbar">
            <a href="homepage.php">Homepage</a>
            <a href="about.php">About us</a>
            <a href="shop.php">Shop</a>
            <a href="basket.php" class="basket-link">Cart</a>
        </nav>
    </header>

        <main class="layout">

            <aside class="sidebar">
                <h3 class="sidebar-title">Filter products</h3>
                <select name="category" id="category">
                    <option value="">All</option>
                    <option value="hardware">Hardware</option>
                    <option value="software">Software</option>
                </select>
            </aside>

            <main class="content-card">

                <main>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                         <div class='blog-card' data-category='" . strtolower($row['category']) . "'>
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

                </main>

            </main>


        </main>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="JS/shop.js"></script>
    </body>
</html>
