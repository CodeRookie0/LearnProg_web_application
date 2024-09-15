<?php
include 'data-repositories/user-progress-functions.php';
include 'data-repositories/course-functions.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
    $_SESSION['error_message'] = 'Course ID is missing in the URL.';
    header("Location: ../pages/error.php");
    exit;
}

$total_completed_points = 0;
$completed_lessons = 0;
$start_date = null;

$lesson_progress = getUserCourseLessonProgress($user_id,$course_id);
$user_courses = getUserCourses($user_id);
$course_info= getTotalCourseInfo($course_id);

foreach ($lesson_progress as $lesson) {
    if($lesson['completion']===1){
        $completed_lessons ++;
        $total_completed_points +=$lesson['points'];
    }
}
foreach ($user_courses as $user_course) {
    if ($user_course['course_id'] == $course_id) {
        $start_date = $user_course['start_date'];
        $completion_date=$user_course['completion_date'];
        break;
    }
}

?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Progress</span>
        <div>
            <a class="badge bg-warning text-decoration-none link-light py-2" href="#!"><?php echo $total_completed_points;?> / <?php echo $course_info['total_points']; ?> pts.</a>
        </div>
    </div>
    <div class="card-body">
        <p>Completed lessons : <?php echo $completed_lessons; ?>/<?php echo $course_info['total_lessons']; ?></p>
        <p>Started the course : <?php echo $start_date; ?></p>
        <?php if ($completed_lessons == $course_info['total_lessons']) : ?>
            <p>Completion date: <?php echo $completion_date; ?></p>
        <?php endif; ?>
    </div>
</div>
