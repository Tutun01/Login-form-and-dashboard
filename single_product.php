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
</head>
<body>

<header>
    <h1>Tech Store</h1>
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

        <button class="buyBtn">Buy Now</button>
    </div>
</main>

</body>
</html>

<?php $connect->close(); ?>