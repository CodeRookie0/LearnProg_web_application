<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'database.php';

function getAdminStatistics() {
    $conn = connectDB();

    $admin_statistics = array();

    $currentMonth = date('m');
    $currentYear = date('Y');
    $currentDay = date('d');

    $firstDayOfMonth = date('Y-m-01', strtotime("$currentYear-$currentMonth-$currentDay"));
    $todayDate = date('Y-m-d', strtotime("$currentYear-$currentMonth-$currentDay"));

    $sql = "SELECT 
                (SELECT COUNT(*) FROM user WHERE usr_registration_date BETWEEN '$firstDayOfMonth' AND '$todayDate') AS new_usr_count,
                (SELECT COUNT(*) FROM user_lesson_progress WHERE ulp_completion_date BETWEEN '$firstDayOfMonth' AND '$todayDate' AND ulp_completed = 1) AS completed_lessons,
                (SELECT COUNT(*) FROM user WHERE usr_last_login_date = '$todayDate') AS users_logged_in_today,
                (SELECT COUNT(*) FROM user_course WHERE ucr_completion_date BETWEEN '$firstDayOfMonth' AND '$todayDate') AS completed_courses";

    $result = $conn->query($sql);

    if ($result) {
        $admin_statistics = $result->fetch_assoc();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();

    return $admin_statistics;
}

function getAllUsersData() {
    $conn = connectDB();

    $sql = "SELECT u.usr_user_id, u.usr_username, u.usr_email, u.usr_password, u.usr_user_type_id, u.usr_registration_date, u.usr_last_login_date, t.ut_user_type_name, COUNT(l.ulp_lesson_id) AS number_completed_lessons
            FROM user u
            LEFT JOIN user_type t ON u.usr_user_type_id = t.ut_user_type_id
            LEFT JOIN user_lesson_progress l ON u.usr_user_id = l.ulp_user_id
            GROUP BY u.usr_user_id";
    $result = $conn->query($sql);

    $users = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = array(
                'id' => $row['usr_user_id'],
                'username' => $row['usr_username'],
                'email' => $row['usr_email'],
                'password' => $row['usr_password'],
                'type_id' => $row['usr_user_type_id'],
                'type_name' => $row['ut_user_type_name'],
                'completed_lessons' => $row['number_completed_lessons'],
                'registration_date' => $row['usr_registration_date'],
                'last_login_date' => $row['usr_last_login_date']
            );
            $users[] = $user;
        }
    } else {
        echo "No users found";
    }
    $conn->close();

    return $users;
}

function getMonthUsers() {
    $conn = connectDB();

    $firstDayOfMonth = date('Y-m-01');
    $today = date('j');

    $sql = "SELECT usr_registration_date FROM user WHERE usr_registration_date >= '$firstDayOfMonth' AND usr_registration_date <= CURRENT_DATE()";
    $result = $conn->query($sql);

    $new_users_per_day = array_fill(1, $today, 0);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $registrationDate = date('j', strtotime($row['usr_registration_date']));
            $new_users_per_day[$registrationDate]++;
        }
    }
    $conn->close();

    return $new_users_per_day;
}

function getMonthActiveUsers() {
    $conn = connectDB();

    $firstDayOfMonth = date('Y-m-01');
    $today = date('j');

    $sql = "SELECT usr_last_login_date FROM user WHERE usr_last_login_date >= '$firstDayOfMonth' AND usr_last_login_date <= CURRENT_DATE()";
    $result = $conn->query($sql);

    $active_users_per_day = array_fill(1, $today, 0);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $lastLoginDate = date('j', strtotime($row['usr_last_login_date']));
            $active_users_per_day[$lastLoginDate]++;
        }
    }
    $conn->close();

    return $active_users_per_day;
}

function getMonthCompletedLessons() {
    $conn = connectDB();

    $firstDayOfMonth = date('Y-m-01');
    $today = date('j');

    $sql = "SELECT ulp_completion_date FROM user_lesson_progress WHERE ulp_completion_date >= '$firstDayOfMonth' AND ulp_completion_date <= CURRENT_DATE() AND ulp_completed=1";
    $result = $conn->query($sql);

    $completed_lessons_per_day = array_fill(1, $today, 0);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $completionDate = date('j', strtotime($row['ulp_completion_date']));
            $completed_lessons_per_day[$completionDate]++;
        }
    }
    $conn->close();

    return $completed_lessons_per_day;
}

function getMonthCompletedCourses() {
    $conn = connectDB();

    $firstDayOfMonth = date('Y-m-01');
    $today = date('j');

    $sql = "SELECT ucr_completion_date FROM user_course WHERE ucr_completion_date IS NOT NULL AND ucr_completion_date >= '$firstDayOfMonth' AND ucr_completion_date <= CURRENT_DATE()";
    $result = $conn->query($sql);

    $completed_courses_per_day = array_fill(1, $today, 0);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $completionDate = date('j', strtotime($row['ucr_completion_date']));
            $completed_courses_per_day[$completionDate]++;
        }
    }
    $conn->close();
    
    return $completed_courses_per_day;
}

function getAverageCompletionTimePerMonth() {
    $conn = connectDB();

    $average_completion_time_per_month = [];

    for ($month = 1; $month <= date('m'); $month++) {
        $firstDayOfMonth = date('Y-m-01', mktime(0, 0, 0, $month, 1, date('Y')));
        $lastDayOfMonth = date('Y-m-t', mktime(0, 0, 0, $month, 1, date('Y')));
        
        $sql = "SELECT DATEDIFF(ucr_completion_date, ucr_start_date) AS completion_time
                FROM user_course
                WHERE ucr_completion_date IS NOT NULL
                AND ucr_start_date >= '$firstDayOfMonth'
                AND ucr_start_date <= '$lastDayOfMonth'";
        
        $result = $conn->query($sql);
        $total_completion_time = 0;
        $total_courses_completed = 0;
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total_completion_time += $row['completion_time'];
                $total_courses_completed++;
            }
            $average_completion_time = $total_courses_completed > 0 ? $total_completion_time / $total_courses_completed : 0;
            
            $average_completion_time_per_month[date('F', mktime(0, 0, 0, $month, 1, date('Y')))] = $average_completion_time;
        } else {
            $average_completion_time_per_month[date('F', mktime(0, 0, 0, $month, 1, date('Y')))] = null;
        }
    
    }
    $conn->close();
    return $average_completion_time_per_month;
}

function calculateCourseEngagement() {
    $conn = connectDB();

    $courses_query = "SELECT crs_course_id, crs_course_name FROM course";
    $courses_result = $conn->query($courses_query);

    $course_engagement = array();

    if ($courses_result->num_rows > 0) {
        while ($course = $courses_result->fetch_assoc()) {
            $course_id = $course['crs_course_id'];

            $total_users_query = "SELECT COUNT(DISTINCT ucr_user_id) AS total_users FROM user_course WHERE ucr_course_id = '$course_id'";
            $total_users_result = $conn->query($total_users_query);
            $row_total_users = $total_users_result->fetch_assoc();
            $total_users = $row_total_users['total_users'];

            $incomplete_users_query = "SELECT COUNT(DISTINCT ucr_user_id) AS incomplete_users FROM user_course WHERE ucr_course_id = '$course_id' AND ucr_start_date IS NOT NULL AND ucr_completion_date IS NULL";
            $incomplete_users_result = $conn->query($incomplete_users_query);
            $row_incomplete_users = $incomplete_users_result->fetch_assoc();
            $incomplete_users = $row_incomplete_users['incomplete_users'];

            $completed_users_query = "SELECT COUNT(DISTINCT ucr_user_id) AS completed_users FROM user_course WHERE ucr_course_id = '$course_id' AND ucr_start_date IS NOT NULL AND ucr_completion_date IS NOT NULL";
            $completed_users_result = $conn->query($completed_users_query);
            $row_completed_users = $completed_users_result->fetch_assoc();
            $completed_users = $row_completed_users['completed_users'];

            $course_engagement[$course_id] = array(
                "course_id" => $course['crs_course_id'],
                "course_name" => $course['crs_course_name'],
                "total_users" => $total_users,
                "incomplete_users" => $incomplete_users,
                "completed_users" => $completed_users
            );
        }
    }

    $conn->close();
    return $course_engagement;
}

?>