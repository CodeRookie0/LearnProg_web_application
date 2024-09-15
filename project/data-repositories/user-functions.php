<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'database.php';

function getUsersData() {
    $conn = connectDB();

    $sql = "SELECT u.usr_user_id, u.usr_username, u.usr_email, u.usr_password, u.usr_user_type_id, u.usr_registration_date, u.usr_last_login_date, t.ut_user_type_name, COUNT(l.ulp_lesson_id) AS number_completed_lessons
        FROM user u
        LEFT JOIN user_type t ON u.usr_user_type_id = t.ut_user_type_id
        LEFT JOIN user_lesson_progress l ON u.usr_user_id = l.ulp_user_id
        GROUP BY u.usr_user_id";
        
    $result = $conn->query($sql);
    $users_data= array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_data = array(
                'id' => $row['usr_user_id'],
                'username' => $row['usr_username'],
                'email' => $row['usr_email'],
                'password' => $row['usr_password'],
                'type_id' => $row['usr_user_type_id'],
                'type_name' => $row['ut_user_type_name'],
                'completed_lessons' => $row['number_completed_lessons'],
                'registration_date' => $row['usr_registration_date'],
                'last_login_date' => $row['usr_last_login_date']
            );
            $users_data[] = $user_data;
        }
    } else {
        echo "No users found";
    }
    $conn->close();

    return $users_data;
}

function getUserData($user_id) {
    $conn = connectDB();

    $sql = "SELECT u.usr_user_id, u.usr_username, u.usr_email, u.usr_password, u.usr_user_type_id, u.usr_registration_date, n.ntf_notification_frequency, t.ut_user_type_name
            FROM user u
            LEFT JOIN notification n ON u.usr_user_id = n.ntf_user_id
            LEFT JOIN user_type t ON u.usr_user_type_id = t.ut_user_type_id
            WHERE u.usr_user_id = $user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_data = array(
                'id' => $row['usr_user_id'],
                'username' => $row['usr_username'],
                'email' => $row['usr_email'],
                'password' => $row['usr_password'],
                'type_id' => $row['usr_user_type_id'],
                'type_name' => $row['ut_user_type_name'],
                'registration_date' => $row['usr_registration_date'],
                'notification_frequency' => $row['ntf_notification_frequency']
            );
        }
    } else {
        echo "No user found with this ID";
    }
    $conn->close();

    return $user_data;
}

function updateUserData($username, $email, $notificationFrequency, $password, $passwordConfirm, $userId) {
    $conn = connectDB();
    $previous_url = $_SERVER['HTTP_REFERER'];
    
    $sql = "SELECT usr_user_id FROM user WHERE usr_email = ? AND usr_user_id!= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email,$userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Email address is already registered.";
        header("Location: ../pages/signup.php");
        exit;
    }  

    $sql = "SELECT usr_user_id FROM user WHERE usr_username = ? AND usr_user_id!= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username,$userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Username is already taken.";
        header("Location: ../pages/signup.php");
        exit;
    }

    if (!empty($password)) {
        if($password === $passwordConfirm){
            if (!isStrongPassword($password)) {
                $_SESSION['error_message'] = 'Password must contain at least 8 characters including uppercase, lowercase, numbers, and special characters.';
                header("Location: $previous_url");
                exit;
            }

            $sql = "UPDATE user SET usr_username = ?, usr_email = ? WHERE usr_user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssi', $username, $email, $userId);
        
            if ($stmt->execute()) {
                $sql = "UPDATE notification SET ntf_notification_frequency = ? WHERE ntf_user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $notificationFrequency, $userId);
                $stmt->execute();

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE user SET usr_password = ? WHERE usr_user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $hashedPassword, $userId);
                $stmt->execute();

                $_SESSION['success_message'] = 'User data updated successfully!';
                header("Location: $previous_url");
                exit;
            } else {
                $_SESSION['error_message'] = 'Error updating user data.';
                header("Location: $previous_url");
                exit;
            }
        } else{
            $_SESSION['error_message'] = 'Passwords do not match.';
            header("Location: $previous_url");
            exit;
        }
    } else{
        $sql = "UPDATE user SET usr_username = ?, usr_email = ? WHERE usr_user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $username, $email, $userId);
    
        if ($stmt->execute()) {
            $sql = "UPDATE notification SET ntf_notification_frequency = ? WHERE ntf_user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $notificationFrequency, $userId);
            $stmt->execute();
            $_SESSION['success_message'] = 'User data updated successfully!';
            header("Location: $previous_url");
            exit;
        } else {
            $_SESSION['error_message'] = 'Error updating user data.';
            header("Location: $previous_url");
            exit;
        }
    } 
    $stmt->close();
    $conn->close();
}

function isStrongPassword($password) {
    return strlen($password) >= 8 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password) &&
           preg_match('/[0-9]/', $password) &&
           preg_match('/[^a-zA-Z0-9]/', $password);
}
?>

