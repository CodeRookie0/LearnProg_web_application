<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../data-repositories/user-progress-functions.php';
$showReviewQuiz=false;

if (!isset($_SESSION['id'])) {
    header("Location: ../pages/login.php");
    exit;
}
else{
    $user_id=$_SESSION['id'];
}

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
} else {
    if(isset($_SESSION['course_id'])){
        $course_id = $_SESSION['course_id'];
    }
    else{
        $_SESSION['error_message'] = 'Course ID is missing in the URL.';
        header("Location: ../pages/error.php");
        exit;
    }
}

$lesson_progress = getUserCourseLessonProgress($user_id,$course_id);

if (!empty($lesson_progress)) {
    echo '<div class="card mt-4">';
    echo '<ul class="list-group list-group-flush">';
    $first_incomplete_found = false;
    foreach ($lesson_progress as $key => $lesson) {
        $lessonNumber = $key + 1;
        if ($lesson['completion'] == 1) {
            echo '<li class="list-group-item p-3 d-flex justify-content-between align-items-center">';
            echo '<i class="bi bi-bookmark-check-fill text-success me-3"></i>';
            echo $lessonNumber . '. ' . stripslashes($lesson['title']);
            echo '<span class="small ms-auto text-muted">Completed on: ' . date('M j, Y', strtotime($lesson['completion_date'])) . '</span>';
            echo '</li>';
            $showReviewQuiz=true;
        } else {
            if (!$first_incomplete_found) {
                echo '<li class="list-group-item p-3 d-flex justify-content-between align-items-center">';
                echo '<span><i class="bi bi-lightbulb-fill text-warning me-3"></i>' .$lessonNumber . '. '. stripslashes($lesson['title']). '</span>';
                $_SESSION['course_id'] = $_GET['course_id'];
                $_SESSION['lesson_id'] = $lesson['id'];
                echo '<form action="./lesson.php" method="post"><button type="submit" class="btn btn-primary">Start Lesson</button></form></li>';
                $first_incomplete_found = true;
            } else {
                echo '<li class="list-group-item p-3">';
                echo '<i class="bi bi-lock-fill text-danger me-3"></i>' .$lessonNumber . '. '. stripslashes($lesson['title']). '</li>';
            }
        }
    }
    echo '</ul>';
    echo '</div>';
} else {
    echo '<div class="alert alert-info" role="alert">No lessons found for this course.</div>';
}
?>
</header>