<?php
session_start();


$urlRequired = [
    "/Blog-Website/auth/login.php",
    "/Blog-Website/auth/register.php",
    "/Blog-Website/auth/otp.php",
];

if (isset($_SESSION['user_id']) && in_array($_SERVER['REQUEST_URI'], $urlRequired)) {
    header('Location: /Blog-Website/index.php');
    exit();
} else if (!isset($_SESSION['user_id']) && !in_array($_SERVER['REQUEST_URI'], $urlRequired)) {
    header('Location: /Blog-Website/auth/login.php');
    exit();
}
?>
