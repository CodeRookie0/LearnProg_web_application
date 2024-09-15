<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>LearnProg - Tables</title>
        <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet" />
        <style>
            .nav-link {
                cursor: pointer;
            }
        </style>
</head>
<body class="sb-nav-fixed">
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include "../include/dashboard-navbar.php" ;
    include "../data-repositories/user-progress-functions.php" ;
    include "../data-repositories/course-functions.php" ;
    include "../data-repositories/lesson-functions.php" ;
    include "../data-repositories/admin-dashboard-functions.php" ;
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tables</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Tables</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                This page displays comprehensive tables containing data related to users, courses, lessons, and assignments on your educational platform. 
                </div>
            </div>
            <nav class="navbar navbar-expand-lg text-dark p-2 mb-4 rounded" style="background-color: #e3f2fd;">
                <div class="container-fluid">    
                    <a class="navbar-brand fs-5" href="#">L E R N P R O G</a>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse" id="navbarColor01" style="">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" onclick="scrollToSection('users_table')">Users</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="scrollToSection('course_progress_table')">Users Course Progress </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="scrollToSection('lesson_progress_table')">Users Lesson Progress </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="scrollToSection('courses_table')">Courses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="scrollToSection('course_topics_table')">Course Topics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="scrollToSection('lessons_table')">Lessons</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="scrollToSection('lesson_files_table')">Lesson Files</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="scrollToSection('task_types_table')">Task types</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="scrollToSection('tasks_table')">Tasks</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <?php include "../content/at-tables.php"; ?>
        </div>
    </main>
    <?php include "../include/footer.php"; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="../js/scripts.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const tableUsers = document.getElementById('tableUsers');
        if (tableUsers) {
            new simpleDatatables.DataTable(tableUsers);
        }const tableCourses = document.getElementById('tableCourses');
        if (tableCourses) {
            new simpleDatatables.DataTable(tableCourses);
        }const tableCourseTopics = document.getElementById('tableCourseTopics');
        if (tableCourseTopics) {
            new simpleDatatables.DataTable(tableCourseTopics);
        }const tableLessons = document.getElementById("tableLessons");
        if (tableLessons) {
            new simpleDatatables.DataTable(tableLessons);
        }
        const tableLessonFiles = document.getElementById("tableLessonFiles");
        if (tableLessonFiles) {
            new simpleDatatables.DataTable(tableLessonFiles);
        }
        const tableTasks = document.getElementById("tableTasks");
        if (tableTasks) {
            new simpleDatatables.DataTable(tableTasks);
        }
        const tableTaskTypes = document.getElementById("tableTaskTypes");
        if (tableTaskTypes) {
            new simpleDatatables.DataTable(tableTaskTypes);
        }
        const tableUserCourseProgress = document.getElementById("tableUserCourseProgress");
        if (tableUserCourseProgress) {
            new simpleDatatables.DataTable(tableUserCourseProgress);
        }
        const tableUserLessonProgress = document.getElementById("tableUserLessonProgress");
        if (tableUserLessonProgress) {
            new simpleDatatables.DataTable(tableUserLessonProgress);
        }
    });
    function scrollToSection(sectionId) {
        var section = document.getElementById(sectionId);
        if (section) {
            var sectionPosition = section.offsetTop - 50;
            window.scrollTo({ top: sectionPosition, behavior: 'smooth' });
        }
    }
</script>
</body>
</html>