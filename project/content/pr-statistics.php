<?php
$num_courses_completed = getNumCoursesCompleted($user_id);
$total_course_duration = getTotalCourseDuration($user_id);
$average_course_duration = $num_courses_completed > 0 ? $total_course_duration / $num_courses_completed : 0;
$courses_stat = calculateCoursesStats($courses,$lessons,$user_courses,$user_lesson_progress);
?>

<div class="container">
    <h2 class="text-center mb-4">Course Statistics</h2>
    <div class="row d-flex align-items-stretch">
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white text-center p-3 h-100">
                <div class="card-body">
                    <h3 class="card-title mb-3">Number of Courses</h3>
                    <p class="card-text display-5"><?php echo count($user_courses); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white text-center p-3 h-100">
                <div class="card-body">
                    <h3 class="card-title mb-3">Courses Completed</h3>
                    <p class="card-text display-5"><?php echo $num_courses_completed; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-gradient bg-danger text-white text-center p-3 h-100">
                <div class="card-body">
                    <h3 class="card-title mb-3">Average Course Duration</h3>
                    <p class="card-text display-5"><?php echo $average_course_duration; ?> days</p>
                </div>
            </div>
        </div>
    </div>
    <h3 class="text-center mt-3 mb-4">Statistics by Course</h3>
    <?php foreach ($courses_stat as $course_stat): ?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h3 class="card-title text-primary mb-3"><?php
                            $course_name = strstr($course_stat['name'], ':', true);
                            echo $course_name;
                            ?></h3>
                        <p class="card-text text-secondary">Course Started: <?php echo $course_stat['start_date']; ?></p>
                        <p class="card-text text-secondary">Completed Lessons: <?php echo $course_stat['completed_lessons']; ?>/<?php echo $course_stat['total_lessons']; ?></p>
                        <p class="card-text text-secondary">Points Scored: <?php echo $course_stat['completed_points']; ?>/<?php echo $course_stat['total_points']; ?> pts.</p>
                    </div>
                    <div class="col-md-8">
                        <?php echo generateCourseChart($course_stat['id'], $user_lesson_progress, $lessons); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>