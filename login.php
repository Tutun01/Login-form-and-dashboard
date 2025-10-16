<?php
require_once "database.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
      
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
           
            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: homepage.php");
                }
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>Incorrect password.</p>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>No account found with that email.</p>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<p style='color:red; text-align:center;'>Please enter both email and password.</p>";
    }
}
?>

<html>
  <a href="index.html" id="login" style="display:block; background-color:#0078d7; color:#fff; text-decoration:none; padding:10px 20px; border-radius:6px; font-weight:600; text-align:center; width:fit-content; margin:20px auto 0; cursor:pointer;">Login</a>
</html>
