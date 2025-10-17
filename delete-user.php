<?php

session_start();
require_once 'database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo "Access denied.";
    exit;
}

if (!isset($_POST['id'])) {
    http_response_code(400);
    echo "Missing user ID.";
    exit;
}

$id = intval($_POST['id']);

var_dump($id);

$query = "DELETE FROM users WHERE ID = ? ";
$stmt = mysqli_prepare($connect, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

  
    if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "SUCCESS";
        } else {
            echo "User not found or already deleted.";
        }

        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo "Database error.";
}

mysqli_close($connect);
?>