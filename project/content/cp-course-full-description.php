<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../data-repositories/course-functions.php";

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

$full_description = getCourseFullDescription($course_id);
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Description of the course</span>
    </div>
    <div class="card-body"><?php echo stripslashes($full_description); ?></div>
</div>