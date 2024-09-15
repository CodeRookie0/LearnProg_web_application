<?php
require_once '../data-repositories/lesson-functions.php';
$lessons = getLessons();

if(isset($_GET['course_id'])) {
    $selected_course_id = $_GET['course_id'];

    $filtered_lessons = array_filter($lessons, function($lesson) use ($selected_course_id) {
        return $lesson['course_id'] == $selected_course_id;
    });

    $lessons_count = count($filtered_lessons);

    if ($lessons_count > 0) {
        echo '<div class="card mb-4 position-relative">';
        echo '<div class="card-header d-flex justify-content-between align-items-center">';
        echo '<span>Course content</span>';
        echo '<span>'.$lessons_count.' lessons</span>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<ul class="list-unstyled mb-0" id="lessonsList">';
        foreach ($filtered_lessons as $index => $lesson) {
            $lesson_number = $index + 1;
            echo '<li class="mb-2"><i class="bi bi-book me-3"></i><a href="javascript:void(0)">';
            echo $lesson_number . '. ' . stripslashes($lesson['title']);
            echo '</a></li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</div>';
    } else {
        echo 'No lessons found for this course.';
    }
} else {
    echo 'No course selected.';
}
?>