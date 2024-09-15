<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Congratulations Page</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(150px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animated-element {
            animation: fadeInUp 1s ease forwards; 
        }
    </style>
</head>
<body>
    <?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }
    else{
        $user_id = $_SESSION['id'];
    }

    if (!isset($_SESSION['lesson_id'])) {
        $_SESSION['error_message'] = 'Lesson ID is missing.';
        header("Location: error.php");
        exit;
    }
    else{
        $lesson_id = $_SESSION['lesson_id'];
    }
    
    if (isset($_GET['course_id'])) {
        $course_id = $_GET['course_id'];
    } else {
        if(isset($_SESSION['course_id'])){
            $course_id = $_SESSION['course_id'];
        }
        else{
            $_SESSION['error_message'] = 'Course ID is missing in the URL.';
            header("Location: error.php");
            exit;
        }
    }

    include "../data-repositories/user-progress-functions.php";
    include '../data-repositories/lesson-functions.php';
    include '../data-repositories/course-functions.php';

    setLessonCompleted($user_id,$lesson_id);
    $lesson_progress=getUserCourseLessonProgress($user_id,$course_id);
    $points = getLessonPoints($lesson_id);
    $course_totals=getTotalCourseInfo($course_id);
    
    foreach ($lesson_progress as $lesson) {
        if($lesson['completion']===1){
            $completed_lessons ++;
        }
    }
    include '../include/navbar.php'; 
    ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <section class="py-5">
        <div class="container pt-5 pb-5 my-5 rounded shadow-lg animated-element" style="background-color: #f8f9fa; max-width:900px;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center">
                        <h1 class="fw-bolder mb-3 text-dark">Congratulations!</h1>
                        <div>
                            <i class="fs-1 bi bi-award-fill points-icon text-success"></i>
                            <p class="fs-4 points-text text-success">You've earned <span class="fw-bold"><?php echo $points; ?></span> points!</p>
                        </div>
                        <?php 
                            if ($completed_lessons == $course_totals['total_lessons']){
                                echo "<p class=\"lead fw-normal text-muted mb-4\">Congratulations! You've successfully completed all lessons in this course. Well done!</p>";
                                $result = setCourseCompleted($user_id, $course_id);
                                if ($result === true) {
                                    echo "<a href=\"course-progress.php?course_id=$course_id\" class=\"btn btn-primary btn-lg\">Finish Course</a>";
                                        exit;
                                } else {
                                    echo "Error: $result";
                                }
                            }
                            else{
                                echo "<p class=\"lead fw-normal text-muted mb-4\">Well done! You've successfully completed this lesson. We hope you found it helpful.</p>";
                                if (isset($_SESSION['lesson_id'])) {
                                    $_SESSION['lesson_id']++;
                                    echo "<a href=\"lesson.php\" class=\"btn btn-primary btn-lg\">Start Next Lesson</a>";
                                    exit();
                                } else {
                                    echo "<a href=\"course-progress.php\" class=\"btn btn-primary btn-lg\">Start Next Lesson</a>";
                                    exit();
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include '../include/footer.php'; ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SB Forms JS-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>