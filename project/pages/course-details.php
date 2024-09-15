<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Course Details</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <style>
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <?php 
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        include '../include/navbar.php'; 
        include '../data-repositories/course-functions.php';
        $course_id = $_GET['course_id'];
        $course_status = getCourseStatus($course_id);
    ?>
	
    <div class="container mt-5">
        <div class="row">
            <!-- Course description-->
            <div class="col-lg-8">
                <article>
                    <?php include '../content/cd-intro.php'; ?>
                </article>

                <?php include '../content/cd-learn-section.php'; ?>
                
            </div>
            <!-- Side widgets-->
            <div class="col-lg-4">
                <?php include '../content/cd-target.php'; ?>
                
                <?php 
                if($course_status === 'Active'){
                    include '../content/cd-course-content.php'; 
                    
                    include '../data-repositories/user-progress-functions.php'; 
                    
                    echo '<div class="card-footer d-flex justify-content-end">';

                    if(isset($_SESSION['id'])) {
                        $user_id=$_SESSION['id'];
                        $course_exists = false;

                        $user_courses = getUserCourses($user_id);
                        foreach ($user_courses as $user_course) {
                            if ($user_course['course_id'] == $course_id) {
                                $course_exists = true;
                                break;
                            }
                        }
                    
                        if ($course_exists) {
                            $button_text = "Continue the course";
                            $button_link = "../pages/course-progress.php?course_id=" . $course_id;
                        } else {
                            $button_text = "Start the course";
                            $button_link = "../actions/course-registration-handler.php?course_id=" . $course_id;
                        }
                    } else {
                        $button_text = "Start the course";
                        $button_link = "./login.php";
                    }
                }
                echo '</div>';
                
                if($course_status === 'Active'){
                    echo '<div class="card-footer d-flex justify-content-end">';
                    echo '<a class="btn btn-block btn-primary mb-5" href="' . $button_link . '">' . $button_text . '</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

	<?php include '../include/footer.php'; ?>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SB Forms JS-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>