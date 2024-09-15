<?php
session_start();

require_once '../data-repositories/database.php';
$conn = connectDB();

if ( !isset($_POST['username'], $_POST['password']) ) {
	$_SESSION['error_message'] = 'Please fill both the username and password fields!';
    header("Location: ../pages/login.php");
    exit;
}

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

if ($stmt = $conn->prepare('SELECT usr_user_id, usr_password, usr_user_type_id FROM user WHERE usr_username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();

	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password_hash, $user_type_id);
        $stmt->fetch();
        if (password_verify($password, $password_hash)) {

            $updateStmt = $conn->prepare('UPDATE user SET usr_last_login_date = CURRENT_DATE WHERE usr_user_id = ?');
            $updateStmt->bind_param('i', $id);
            $updateStmt->execute();

            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $username;
            $_SESSION['id'] = $id;
            if ($user_type_id == 2) {
                header("Location: ../pages/admin-dashboard.php");
            } else {
                header("Location: ../pages/profile.php");
            }
            exit;
        } else {
            $_SESSION['error_message'] = 'Incorrect username and/or password!';
            header("Location: ../pages/login.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = 'Incorrect username and/or password!';
        header("Location: ../pages/login.php");
        exit;
    }

	$stmt->close();
}
?>