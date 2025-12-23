<?php
session_start();

require_once 'database.php';

if (empty($_SESSION['cart'])) {
    echo "<h2>Your basket is empty.</h2>";
    exit;
}

$totalSum = 0;

echo "<h2>Your Basket</h2>";

foreach ($_SESSION['cart'] as $productId => $quantity) {

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

    <div style="border:1px solid #ccc; padding:15px; margin-bottom:10px;">
        <strong>Product:</strong> <?= htmlspecialchars($product['name']) ?><br>
        <strong>Price:</strong> $<?= number_format($product['price'], 2) ?><br>
        <strong>Quantity:</strong> <?= $quantity ?><br>
        <strong>Total:</strong> $<?= number_format($itemTotal, 2) ?>
    </div>

    <?php
}

echo "<h3>Grand Total: $" . number_format($totalSum, 2) . "</h3>";
