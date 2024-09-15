<section class="mb-5 p-4 shadow-sm border">
    <h2 class="fw-bolder mb-3">What You'll Learn:</h2>
    <div class="container">
        <div class="row">
            <?php 
            require_once '../data-repositories/course-functions.php';
            $courses = getCoursesWithTopics();

            if(isset($_GET['course_id'])) {
                $selected_course_id = $_GET['course_id'];
            }
            
            foreach ($courses as $course) {
                if ($course['id'] == $selected_course_id) {
                    $topics_count = count($course['topics']);
                    $topics_per_column = ceil($topics_count / 2);
                    $column_index = 1;
                    
                    echo '<div class="col-md-6">';
                    echo '<ul class="list-unstyled mb-4">';
                    foreach ($course['topics'] as $index => $topic) {
                        if ($index > 0 && $index % $topics_per_column === 0) {
                            echo '</ul>';
                            echo '</div>';
                            echo '<div class="col-md-6">';
                            echo '<ul class="list-unstyled mb-4">';
                            $column_index++;
                        }
                        echo '<li class="mb-0 d-flex align-items-center"><i class="bi bi-check text-primary me-2 fs-4"></i>' . stripslashes($topic) . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    break;
                }
            }
            
            ?>
        </div>
    </div>
</section>