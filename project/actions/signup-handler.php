<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../data-repositories/database.php';
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);

    $stmt = $conn->prepare("SELECT usr_user_id FROM user WHERE usr_username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Username is already taken.";
        header("Location: ../pages/signup.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT usr_user_id FROM user WHERE usr_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Email address is already registered.";
        header("Location: ../pages/signup.php");
        exit;
    }

    $uppercase = preg_match('@[A-Z]@', $_POST['password']);
    $lowercase = preg_match('@[a-z]@', $_POST['password']);
    $number    = preg_match('@[0-9]@',$_POST['password']);
    $specialChars = preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $_POST['password']);
    $password_length = strlen($_POST['password']);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || $password_length < 8) {
        $_SESSION['error_message'] = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
        header("Location: ../pages/signup.php");
        exit;
    }

    if ($_POST['password'] != $_POST['confirm_password']) {
        $_SESSION['error_message'] = "Passwords do not match.";
        header("Location: ../pages/signup.php");
        exit;
    }

    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO user (usr_username, usr_email, usr_password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        $stmt_notification = $conn->prepare("INSERT INTO notification (ntf_user_id) VALUES (?)");
        $stmt_notification->bind_param("i", $user_id);
        $stmt_notification->execute();

        $_SESSION['success_message'] = "User registered successfully.";
        header("Location: ../pages/login.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Error registering user.";
        header("Location: ../pages/signup.php");
        exit;
    }
}
?>
