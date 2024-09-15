<?php

require_once '../data-repositories/course-functions.php';
$courses = getCourses();

if(isset($_GET['course_id'])) {
    $selected_course_id = $_GET['course_id'];
}

foreach ($courses as $course) {
    if(isset($selected_course_id) && $course["id"] == $selected_course_id) {
        echo '<header class="mb-4">';
        echo '<h1 class="fw-bolder mb-2">' . stripslashes($course["name"]) . '</h1>';

        $badge_color = '';
        switch ($course["status"]) {
            case 'Active':
                $badge_color = 'bg-success';
                break;
            case 'Inactive':
                $badge_color = 'bg-danger';
                break;
            case 'Upcoming':
                $badge_color = 'bg-warning';
                break;
            default:
                $badge_color = 'bg-dark';
                break;
        }

        echo '<a class="badge '.$badge_color.' text-decoration-none link-light py-2 mb-0" href="#!">' . $course["status"] . '</a>';
        echo '</header>';
        echo '<figure class="mb-2 mt-0 position-relative">';

        $imagePath = $course["image_path"];

        if (strpos($imagePath, '.jpg') !== false || strpos($imagePath, '.png') !== false) {
            $pathParts = pathinfo($imagePath);
            $largeImagePath = $pathParts['dirname'] . '/' . $pathParts['filename'] . '-large.' . $pathParts['extension'];

            echo '<img class="img-fluid rounded" src="' . $largeImagePath . '" alt="'. $course["name"] .'" />';
        } else {
            echo '<img class="img-fluid rounded" src="' . $imagePath . '" alt="'. $course["name"] .'" />';
        }
        
        echo '<div class="overlay"></div>';
        echo '</figure>';
        echo '<section class="mb-5 mt-4">';
        echo '<p class="fs-5 mb-4">' . stripslashes($course["full_description"]) . '</p>';
        echo '</section>';
    }
} 

if (empty($courses)) {
    echo "0 results";
}
?>
