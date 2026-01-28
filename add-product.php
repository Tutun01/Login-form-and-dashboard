<?php

session_start();
require_once 'database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $category = trim($_POST["category"]);
    $description = trim($_POST["description"]);
    $brand = trim($_POST["brand"]);
    $price = (float)$_POST["price"];
    $stock = (int)$_POST["stock"];
    $release_date = $_POST["release_date"];
    $image_url = trim($_POST["image_url"]);

    $stmt = $connect->prepare(
        "INSERT INTO products (name, category, description, brand, price, stock, release_date, image_url)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssssdiss", $name, $category, $description, $brand, $price, $stock, $release_date, $image_url);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

}
