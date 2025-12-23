<?php
session_start();

require_once 'database.php';

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}


if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id = $id";
$result = $connect->query($sql);

if ($result->num_rows == 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?> | Tech Store</title>
    <link rel="stylesheet" href="CSS/single_product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header>
    <img class="logo-picture" src="images/logo.png" alt="logo">
    <h1 class="title-h1">Market</h1>
    <a href="basket.php">
        <i class="fa-solid fa-cart-shopping basket-icon"></i>
    </a>
</header>

<main class="product-container">
    <div class="product-image">
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product image">
    </div>

    <div class="product-info">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>

        <p class="brand-category">
            <strong>Brand:</strong> <?php echo htmlspecialchars($product['brand']); ?> <br>
            <strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?>
        </p>

        <p class="price-stock">
            <strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?> <br>
            <strong>In stock:</strong> <?php echo number_format($product['stock']); ?>
        </p>

        <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>

        <button class="buyBtn" onclick="openPopup()">Buy Now</button>

        <div 
    id="popup" 
    class="popup" 
    data-price="<?php echo (float)$product['price']; ?>"
>
    <div class="popup-content">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>

        <strong>Price:</strong>
        $<span id="totalPrice">
            <?php echo number_format($product['price'], 2); ?>
        </span>
        <br><br>

        <strong>Quantity:</strong>
        <input
            type="number"
            id="quantity"
            min="0"
            max="<?php echo (int)$product['stock']; ?>"
            value="0"
        >
        <br><br>

        <button 
        class="buyButton"
        id="buyButton"
        data-id="<?php echo (int)$product['id']; ?>"
    >
        Buy
    </button>        
        <button class="closeBtn" id="closePopup">Close</button>
        </div>
    </div>
</div>
</main>

   <script src="JS/buy-popup.js"></script>

</body>
</html>

<?php $connect->close(); ?>