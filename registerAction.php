<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($name) && !empty($email) && !empty($password)) {

        
        $checkQuery = "SELECT COUNT(*) AS number FROM `User` WHERE email = ?";
        $stmt = mysqli_prepare($connect, $checkQuery);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($row['number'] > 0) {
            echo "<h2 style='color:red; text-align:center; margin-top:50px;'>You are already registered.</h2>";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            
            $sql = "INSERT INTO `User` (name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

            if (mysqli_stmt_execute($stmt)) {
                echo "<h2 style='color:green; text-align:center; margin-top:50px;'>Registration successful!</h2>";
            } else {
                echo "<h2 style='color:red; text-align:center; margin-top:50px;'>Registration error: " . mysqli_error($connect) . "</h2>";
            }

            mysqli_stmt_close($stmt);
        }

    } else {
        echo "<h3 style='color:red; text-align:center; margin-top:50px;'>Please fill in all fields.</h3>";
    }
} else {
    echo "<h3 style='text-align:center; margin-top:50px;'>Please register using the form.</h3>";
}
?>

<html>
  <a href="index.html" id="login" style="display:block; background-color:#0078d7; color:#fff; text-decoration:none; padding:10px 20px; border-radius:6px; font-weight:600; text-align:center; width:fit-content; margin:20px auto 0; cursor:pointer;">Login</a>
</html>
