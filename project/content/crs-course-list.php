<?php
$section_type = "py-5";
require_once '../data-repositories/course-functions.php';
$courses = getCoursesWithTopics();

foreach ($courses as $counter => $course) {
    $section_class = ($counter % 2 == 0) ? 'py-5' : 'py-5 bg-light';
    echo '<section class="' . $section_class . '">';

    echo '<div class="container px-5 my-5">';
    echo '<div class="row gx-5 align-items-center">';
    $image_column_class = ($counter % 2 != 0) ? 'order-first order-lg-last' : '';
    echo '<div class="col-lg-6 ' . $image_column_class . '">';
    echo '<img class="img-fluid rounded mb-5 mb-lg-0" src="' . $course["image_path"] . '" alt="' . $course["name"] . '">';
    echo '</div>';

    echo '<div class="col-lg-6">';
    echo '<h2 class="fw-bolder mb-2">' . stripslashes($course["name"]) . '</h2>';
    echo '<p class="lead fw-normal text-muted mb-3">' . stripslashes($course["short_description"]) . '</p>';
    echo '<div class="badge bg-primary bg-gradient rounded-pill mb-2 me-2 py-2">' . $course["level"] . '</div>';
    
    $status_class = '';
    if ($course["status"] == "Inactive") {
        $status_class = 'bg-danger';
    } else if ($course["status"] == "Upcoming") {
        $status_class = 'bg-warning';
    } else {
        $status_class = 'bg-success';
    }
    echo '<div class="badge ' . $status_class . ' bg-gradient rounded-pill mb-2 py-2">' . $course["status"] . '</div>';

    echo '<h4 class="fw-bolder mb-3">Topics included in the course :</h4>';
    if (!empty($course["topics"])) {
        echo '<div class="row">';
        echo '<div class="col">';
        echo '<ul class="list-unstyled mb-4">';
        $topics_count = 0;
        foreach ($course["topics"] as $topic) {
            if ($topics_count == 4) {
                echo '</ul></div><div class="col"><ul class="list-unstyled mb-4">';
            }
            echo '<li class="mb-2"><i class="bi bi-check2-circle text-primary me-2"></i>' . stripslashes($topic) . '</li>';
            $topics_count++;
        }
        echo '</ul></div>';
        echo '</div>';
    } else {
        echo '<p>No topics found for this course</p>';
    }

    $course_id = $course["id"];
    echo '<div class="d-grid">';
    if ($course["status"] !== 'Active') {
        echo '<button class="btn btn-outline-primary" disabled>Choose course</button>';
    } else {
        echo '<button class="btn btn-outline-primary" onclick=window.location.href="../pages/course-details.php?course_id=' . $course["id"] . '">Choose course</button>';
    }
    echo '</div>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</section>';

    if ($counter % 2 == 0) {
        $section_type = ($section_type == "py-5") ? "py-5 bg-light" : "py-5";
    }
}
?>

