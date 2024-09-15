<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../data-repositories/database.php';
$conn = connectDB();

if (!isset($_SESSION['id'])) {
    header("Location: ../pages/login.php");
    exit;
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
} else {
    $_SESSION['error_message'] = 'Course ID is missing in the URL.';
    header("Location: ../pages/error.php");
    exit;
}

$user_id = $_SESSION['id'];
$course_id = $course_id;

include "../data-repositories/user-progress-functions.php";
enrollUserInCourse($user_id, $course_id);

?>
