<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Profile</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
    <style>
        .nav-pills .nav-link {
            color: #fff !important;
            background-color: #343a40 !important;
            border-color: #343a40 !important;
            text-align: center !important; 
        }

        .nav-pills .nav-link.active {
            color: #343a40 !important;
            background-color: #fff !important;
            border-color: #343a40 !important;
        }
        .chart-container {
            max-width: 1700px;
        }
        .card {
            border: 1px solid #ced4da;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['id'])) {
            header("Location: ../pages/login.php");
            exit;
        }
        else{
            $user_id=$_SESSION['id'];
        }

        include '../data-repositories/user-functions.php';
        include '../data-repositories/course-functions.php';
        include '../data-repositories/lesson-functions.php';
        include '../data-repositories/user-progress-functions.php';

        $courses=getCourses();
        $lessons=getLessons();
        $user_data=getUserData($user_id);
        $user_courses=getUserCourses($user_id);
        $user_lesson_progress=getUserLessonProgress($user_id);

        $username=$user_data['username'];
        include '../include/navbar.php';
    ?>

    <header class="py-5 bg-image-full" style="background-image: url('../image/dark-waves.jpg');background-size: cover;">
        <div class="text-center my-5">
            <img class="img-fluid rounded-circle mb-4" src="../image/user-icon.png" style="width:150px; height:auto; " alt="User Icon">
            <h1 class="text-white fs-3 fw-bolder">Welcome Back, <?php echo htmlspecialchars($username); ?>!</h1>
            <p class="text-white-50 mb-0">Explore Your Account</p>
        </div>
    </header>
    <section class="py-5">
        <div class="custom-container">
            <div class="row ms-1 me-1">
                <?php
                    if (isset($_SESSION['error_message'])) {
                        echo '<div id="error_message" class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                        unset($_SESSION['error_message']);
                    }

                    if (isset($_SESSION['success_message'])) {
                        echo '<div id="success_message" class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                        unset($_SESSION['success_message']); 
                    }
                ?>
                <div class="col-4" style="max-width:250px;">
                    <div class="nav flex-column nav-pills p-2" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="background-color:#343a40;border-radius: 5px;">
                        <button class="nav-link active mb-3" id="v-pills-overwiew-tab" data-bs-toggle="pill" data-bs-target="#v-pills-overwiew" type="button" role="tab" aria-controls="v-pills-overwiew" aria-selected="true">Overview</button>
                        <button class="nav-link mb-3" id="v-pills-statistics-tab" data-bs-toggle="pill" data-bs-target="#v-pills-statistics" type="button" role="tab" aria-controls="v-pills-statistics" aria-selected="false">Statistics</button>
                        <button class="nav-link mb-3" id="v-pills-courses-tab" data-bs-toggle="pill" data-bs-target="#v-pills-courses" type="button" role="tab" aria-controls="v-pills-courses" aria-selected="false">My Courses</button>
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
                    </div>
                </div>
                <div class="col">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-overwiew" role="tabpanel" aria-labelledby="v-pills-overwiew-tab">
                            <div class="p-3 mb-2 border" >
                                <?php include "../content/pr-overview.php" ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-statistics" role="tabpanel" aria-labelledby="v-pills-statistics-tab">
                            <div class="p-3 mb-2 border" >
                                <?php include "../content/pr-statistics.php" ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-courses" role="tabpanel" aria-labelledby="v-pills-courses-tab">
                            <?php include "../content/pr-courses.php" ?>
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <?php include "../content/pr-settings.php" ?>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../include/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var errorMessage = document.getElementById('error_message');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }

                var successMessage = document.getElementById('success_message');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 2000);
        });
        function switchToSettingsTab() {
            var settingsTabButton = document.getElementById('v-pills-settings-tab');
            if (settingsTabButton) {
                settingsTabButton.click(); 
            }
        }
    </script>
    <?php
    // Function to generate course chart
    function generateCourseChart($courseId, $user_lesson_progress, $lessons) {
        $courseLabels = array();
        $courseData = array();
    
        $firstDate = null;
        $lastDate = null;
    
        foreach ($user_lesson_progress as $user_lesson_progress_item) {
            if ($user_lesson_progress_item['completed'] ==1) {
                $lesson_id = $user_lesson_progress_item['lesson_id'];
                
                foreach ($lessons as $lesson) {
                    if ($lesson['id'] == $lesson_id) {
                        if($lesson['course_id'] == $courseId){
                            $completionDate = $user_lesson_progress_item['completion_date'];
    
                            if ($firstDate === null || strtotime($completionDate) < strtotime($firstDate)) {
                                $firstDate = $completionDate;
                            }
                    
                            if ($lastDate === null || strtotime($completionDate) > strtotime($lastDate)) {
                                $lastDate = $completionDate;
                            }
    
                            if (!in_array($completionDate, $courseLabels)) {
                                $courseLabels[] = $completionDate;
                            }
                        
                            if (isset($courseData[$completionDate])) {
                                $courseData[$completionDate]++;
                            } else {
                                $courseData[$completionDate] = 1;
                            }
                        }
                        break;
                    }
                }
            }
        }
    
        $currentDate = $firstDate;
        while (strtotime($currentDate) <= strtotime($lastDate)) {
            if (!in_array($currentDate, $courseLabels)) {
                $courseLabels[] = $currentDate;
                $courseData[$currentDate] = 0; 
            }
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }
        
        sort($courseLabels);
        ?>
        <div class="chart-container">
            <canvas id="chart_<?php echo $courseId; ?>"></canvas>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx_<?php echo $courseId; ?> = document.getElementById('chart_<?php echo $courseId; ?>').getContext('2d');
                var myChart_<?php echo $courseId; ?> = new Chart(ctx_<?php echo $courseId; ?>, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($courseLabels); ?>,
                        datasets: [{
                            label: 'Lessons Completed',
                            data: <?php echo json_encode(array_values($courseData)); ?>,
                            borderColor: 'rgba(0, 123, 255, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'category',
                                labels: <?php echo json_encode(array_fill(0, count($courseLabels), '')); ?>,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        var lessonCount = myChart_<?php echo $courseId; ?>.data.datasets[0].data[tooltipItem.dataIndex];
                                        return 'Lessons Completed: ' + lessonCount;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
        <?php
    }?>
    <!-- Bootstrap JS (popper.js and bootstrap.js are required for dropdowns, modals, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>