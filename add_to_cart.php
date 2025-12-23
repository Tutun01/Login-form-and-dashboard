<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    exit("No data received");
}

$id  = (int)$data['id'];
$qty = (int)$data['qty'];

if ($id <= 0 || $qty <= 0) {
    http_response_code(400);
    exit("Invalid data");
}

$_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;

echo "OK";
