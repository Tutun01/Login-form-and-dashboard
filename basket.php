<?php
session_start();
require_once 'database.php';
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$pageTitle = 'Cart';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="CSS/basket.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/footer.css">
</head>
<body>

<?php
if (empty($_SESSION['cart'])) {
    echo "<h2>Your basket is empty.</h2>";
    exit;
}

$totalSum = 0;
?>

<?php include 'navbar.php'; ?>


<main class="basket-page">

<h2>Your Basket</h2>

<?php foreach ($_SESSION['cart'] as $productId => $quantity): ?>

    <?php
    $productId = (int)$productId;
    $quantity = (int)$quantity;

    $sql = "SELECT name, price FROM products WHERE id = $productId";
    $result = $connect->query($sql);

    if (!$result || $result->num_rows === 0) {
        continue;
    }

    $product = $result->fetch_assoc();
    $itemTotal = $product['price'] * $quantity;
    $totalSum += $itemTotal;
    ?>

    <div class="basket-item" data-total="<?= $itemTotal ?>">
        <div class="item-info">
            <strong>Product:</strong> <?= htmlspecialchars($product['name']) ?><br>
            <strong>Price:</strong> $<?= number_format($product['price'], 2) ?><br>
            <strong>Quantity:</strong> <?= $quantity ?><br>
            <strong>Total:</strong> $<?= number_format($itemTotal, 2) ?>
        </div>

        <button class="deleteBtn">Delete</button>
    </div>

<?php endforeach; ?>

<h3 class="grand-total">
    Grand Total: $<span id="grandTotal"><?= number_format($totalSum, 2) ?></span>
</h3>
    <form action="checkout.php" method="POST">
        <button class="buyBtn" type="submit">Buy</button><br>
    </form>

</main>
<script src="JS/basket.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>
