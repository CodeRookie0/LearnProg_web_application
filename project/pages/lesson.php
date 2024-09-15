<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Lesson</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <style>
        .gradient-bg {
            background: linear-gradient(to right, #fff, #007bff, #fff);
            color: #fff;
        }
        .btn:hover .bi-arrow-left-circle{
            color: #007bff;
            transition: color 0.2s ease;
        }
        th,td
        {
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['lesson_id'])) {
        if (isset($_GET['course_id'])) {
            $course_id = $_GET['course_id'];
            header("Location: course-progress.php?course_id=".$course_id);
        }
        else{
            header("Location: courses.php");
            exit;
        }
    }
    else {
        include '../data-repositories/lesson-functions.php';
        echo "<script>console.log('Lesson ID: " . $_SESSION['lesson_id'] . "');</script>";
        $lesson_id = $_SESSION['lesson_id'];
        $lesson_content = processLessonContent($lesson_id);
    }
    include '../include/navbar.php'; 
    ?>

    <div class="container mt-5 pe-5 ps-5" style="max-width: 1250px; border-left: 1px solid #6c757d; border-right: 1px solid #6c757d;">
        <header class="mb-4">
            <h2 class="text-center pt-4 pb-4 ps-5 pe-5 gradient-bg"><?php echo $lesson_content['title'] ?></h2>
            <a href="javascript:history.go(-1)" class="btn p-0" style="margin-top: -8rem; border: none;"><i class="bi bi-arrow-left-circle fs-1"></i></a>
        </header>
        <section class="mb-5" style="margin-top: -1.5rem;">
            <?php 
                echo $lesson_content['content'];
                $tasks = getLessonTasks($lesson_id);
            ?>
            <div class="d-flex justify-content-center mt-5">
                <?php 
                if(!count($tasks)>0){
                    $button_text="Finish Lesson!";
                    $button_href='lesson-completion.php';
                }
                else{
                    $button_text="Get Started with Practice Tasks!";
                    $button_href='exercise.php';
                }
                ?>
                <a href=<?php echo $button_href ?> class="btn btn-primary btn-lg"><?php echo $button_text; ?></a>
            </div>
        </section>
    </div>

	<?php include '../include/footer.php'; ?>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SB Forms JS-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>