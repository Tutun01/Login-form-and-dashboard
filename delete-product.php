<?php

session_start();
require_once 'database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);

    $stmt = $connect->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    $stmt->execute();
    header("Location: admin_dashboard.php");
    exit;
}
