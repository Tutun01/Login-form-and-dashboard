<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'database.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

if (empty($_SESSION['cart'])) {
    die('Cart is empty');
}

$lineItems = [];

foreach ($_SESSION['cart'] as $productId => $quantity) {
    $productId = (int)$productId;
    $quantity = (int)$quantity;

    $result = $connect->query("SELECT name, price FROM products WHERE id = $productId");
    if (!$result || $result->num_rows === 0) continue;

    $product = $result->fetch_assoc();

    $lineItems[] = [
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => $product['name'],
            ],
            'unit_amount' => (int) round($product['price'] * 100), // CENTS
        ],
        'quantity' => $quantity,
    ];
}

$session = \Stripe\Checkout\Session::create([
    'mode' => 'payment',
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'success_url' => 'http://localhost:8888/PHP/Ternary/success.php',
    'cancel_url' => 'http://localhost:8888/PHP/Ternary/basket.php',
]);

header("Location: " . $session->url);
exit;
