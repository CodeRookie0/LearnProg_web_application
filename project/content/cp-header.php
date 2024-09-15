<header class="mb-4">
    <?php 
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        include '../data-repositories/course-functions.php'; 
        $courses = getCourses();
        
        if(isset($_GET['course_id'])) {
            $course_id = $_GET['course_id'];
            foreach ($courses as $course) {
                if ($course['id'] == $course_id) {
                    if ($course['status'] != 'Active'){
                        $_SESSION['error_message'] = 'This course is currently not active.';
                        header("Location: error.php");
                        exit;
                    } else  {
                    $course_name = strstr($course['name'], ':', true);
                    break;
                    }
                }
            }
        }
    ?>
    <h1 class="fw-bolder mb-2">Welcome to the <?php echo stripslashes($course_name); ?></h1>
