<?php

session_start();

require_once "database.php";

if(!isset($_POST['name']) || !isset($_POST['email'])  || !isset($_POST['password'])  || !isset($_POST['role']) ) {
    die("All fields must be filled!");
} else {
    
    $firstName = trim($_POST['name']);
    $userEmail = trim($_POST['email']);
    $userPassword = $_POST['password'];
    $userRole = trim($_POST['role']);

    $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($connect, $sql);

    if (!$stmt) {
    die("Statement preparation failed: " . mysqli_error($connect));
    }
    mysqli_stmt_bind_param($stmt, "ssss", $firstName, $userEmail, $userPassword, $userRole);

    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;   
    } else {
        echo "<h2 style='color:red; text-align:center; margin-top:50px;'>Error: " . mysqli_error($connect) . "</h2>";
    }

   
    mysqli_stmt_close($stmt);

    
    mysqli_close($connect);
}