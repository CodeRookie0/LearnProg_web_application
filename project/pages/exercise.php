<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Exercise Page</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <style>
        .code-editor {
            width: 100%;
            height: 300px;
            resize: none;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            white-space: pre-wrap;
            line-height: 1.7;
        }
        .console-output {
            background-color: #000;
            color: #a0a0a0; 
            border-radius: 5px; 
            min-width:310px;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(70px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animated-element {
            animation: fadeInUp 0.8s ease forwards; 
        }
    </style>
</head>
<body class="d-flex flex-column">

    <?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['lesson_id'])) {
        $lesson_id = $_SESSION['lesson_id'];
    } else {
        echo "lesson_id not set in session.";
    }
    include '../include/navbar.php'; 
    ?>

    <?php include '../content/ex-header.php'; ?>
    
    <?php 
        include '../data-repositories/lesson-functions.php'; 
        $tasks = getLessonTasks($lesson_id);
    ?>
    <?php include '../content/ex-card.php'; ?>
    
    <?php include '../include/footer.php'; ?>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SB Forms JS-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>