<?php
require_once '../data-repositories/course-functions.php';
$courses = getCourses();

if(isset($_GET['course_id'])) {
    $selected_course_id = $_GET['course_id'];
}
foreach ($courses as $course) {
    if ($course['id'] == $selected_course_id) {
        $level = $course['level'];

        echo '<div class="card mb-4">';
        echo '<div class="card-header d-flex justify-content-between align-items-center">';
        echo '<span>Who is this course for?</span>';
        echo '<div>';
        echo '<a class="badge bg-primary text-decoration-none link-light py-2" href="#!">' . $level . '</a>';
        echo '</div>';
        echo '</div>';
        echo '<div class="card-body">';
        echo 'The "' . stripslashes($course['name']) . '" course is';
        
        switch ($level) {
            case 'Beginner':
                echo ' perfect for for beginners who want to master the basics of programming in C++ and build a solid foundation in their coding adventure.';
                break;
            case 'Intermediate':
                echo ' designed for intermediate learners who already have some experience with C++ programming and want to deepen their understanding and skills.';
                break;
            case 'Advanced':
                echo ' targeted at advanced learners who are proficient in C++ programming and want to explore advanced topics and techniques.';
                break;
            default:
                echo ' suitable for learners of all levels.';
                break;
        }
        echo '</div>';
        echo '</div>';
        break;
    }
}
?>