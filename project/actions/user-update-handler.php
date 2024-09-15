<?php
session_start();

require_once '../data-repositories/user-functions.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['id'];
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $notificationFrequency = intval($_POST['notificationFrequency']);
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    
    updateUserData($username, $email, $notificationFrequency, $password, $passwordConfirm, $userId);
}

?>