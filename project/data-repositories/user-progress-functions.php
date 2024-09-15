<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'database.php';

function getUserCourses($user_id) {
    $conn = connectDB();
    $user_courses = array();

    $sql = "SELECT ucr_user_id, ucr_course_id, ucr_start_date, ucr_completion_date FROM user_course WHERE ucr_user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $user_course = array(
            "user_id" => $row["ucr_user_id"],
            "course_id" => $row["ucr_course_id"],
            "start_date" => $row["ucr_start_date"],
            "completion_date" => $row["ucr_completion_date"]
        );
        $user_courses[] = $user_course;
    }

    $stmt->close();
    $conn->close();

    return $user_courses;
}

function getUserLessonProgress($user_id) {
    $conn = connectDB();
    $user_lesson_progress = array();

    $sql = "SELECT ulp_user_id, ulp_lesson_id, ulp_completed, ulp_completion_date FROM user_lesson_progress WHERE ulp_user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $progress = array(
            "user_id" => $row["ulp_user_id"],
            "lesson_id" => $row["ulp_lesson_id"],
            "completed" => $row["ulp_completed"],
            "completion_date" => $row["ulp_completion_date"]
        );
        $user_lesson_progress[] = $progress;
    }

    $stmt->close();
    $conn->close();

    return $user_lesson_progress;
}

function getUserCourseLessonProgress($user_id, $course_id) {
    $conn = connectDB();

    $sql = "SELECT l.les_lesson_id, l.les_lesson_title, l.les_lesson_order, l.les_points, ulp.ulp_completed, ulp.ulp_completion_date 
            FROM lesson l
            LEFT JOIN user_lesson_progress ulp ON l.les_lesson_id = ulp.ulp_lesson_id AND ulp.ulp_user_id = ?
            WHERE l.les_course_id = ?
            ORDER BY l.les_lesson_order ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user_course_lesson_progress = array();

    while ($row = $result->fetch_assoc()) {
        $lesson = array(
            'id' => $row['les_lesson_id'],
            'title' => $row['les_lesson_title'],
            'order' => $row['les_lesson_order'],
            'points' => $row['les_points'],
            'completion' => $row['ulp_completed'],
            'completion_date' => $row['ulp_completion_date']
        );
        $user_course_lesson_progress [] = $lesson;
    }

    $stmt->close();
    $conn->close();

    return $user_course_lesson_progress;
}

function getUsersCoursePogress() {
    $conn = connectDB();
    
    $sql = "SELECT `ucr_user_id`, `ucr_course_id`, `ucr_start_date`, `ucr_completion_date` FROM `user_course`";
    $result = $conn->query($sql);
    
    $courses_progress = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $course_progress = array(
                "user_id" => $row["ucr_user_id"],
                "course_id" => $row["ucr_course_id"],
                "start_date" => $row["ucr_start_date"],
                "completion_date" => $row["ucr_completion_date"]
            );
            $courses_progress[] = $course_progress;
        }
    }
    
    $conn->close();
    
    return $courses_progress;
}

function getUsersLessonPogress() {
    $conn = connectDB();
    
    $sql = "SELECT `ulp_user_id`, `ulp_lesson_id`, `ulp_completed`, `ulp_completion_date` FROM `user_lesson_progress`";
    $result = $conn->query($sql);
    
    $lessons_progress = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $lesson_progress = array(
                "user_id" => $row["ulp_user_id"],
                "lesson_id" => $row["ulp_lesson_id"],
                "completed" => $row["ulp_completed"],
                "completion_date" => $row["ulp_completion_date"]
            );
            $lessons_progress[] = $lesson_progress;
        }
    }
    
    $conn->close();
    
    return $lessons_progress;
}

function enrollUserInCourse($user_id, $course_id) {
    $conn = connectDB();

    $start_date = date("Y-m-d"); 
    $completion_date = null;

    $sql = "INSERT INTO user_course (ucr_user_id, ucr_course_id, ucr_start_date, ucr_completion_date) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $user_id, $course_id, $start_date, $completion_date);

    if ($stmt->execute()) {
        header("Location: ../pages/course-progress.php?course_id=" . $course_id);
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

function setLessonCompleted($user_id, $lesson_id) {
    $completion_date = date('Y-m-d H:i:s');
    $is_completed=1;
    $conn = connectDB();
    
    $sql = "INSERT INTO user_lesson_progress (ulp_user_id, ulp_lesson_id, ulp_completed, ulp_completion_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $user_id, $lesson_id, $is_completed, $completion_date);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function setCourseCompleted($user_id, $course_id) {
    $completion_date = date('Y-m-d H:i:s');
    $conn = connectDB();
    
    $sql = "UPDATE `user_course` SET `ucr_completion_date` = ? WHERE `ucr_user_id` = ? AND `ucr_course_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $completion_date, $user_id, $course_id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $error = $stmt->error;
        $stmt->close();
        $conn->close();
        return $error;
    }
}

function getNumCoursesCompleted($user_id) {
    $num_courses_completed = 0;
    $user_courses = getUserCourses($user_id);

    foreach ($user_courses as $user_course) {
        if ($user_course['completion_date'] !== null) {
            $num_courses_completed++;
        }
    }

    return $num_courses_completed;
}

function getTotalCourseDuration($user_id) {
    $total_course_duration = 0;
    $user_courses = getUserCourses($user_id);

    foreach ($user_courses as $user_course) {
        if ($user_course['completion_date'] !== null) {
            $start_date = new DateTime($user_course['start_date']);
            $completion_date = new DateTime($user_course['completion_date']);
            $course_duration = $start_date->diff($completion_date)->days;
            $total_course_duration += $course_duration;
        }
    }

    return $total_course_duration;
}

function calculateCoursesStats($courses,$lessons,$user_courses,$user_lesson_progress) {
    $conn = connectDB();
    $courses_stat = array();

    foreach ($user_courses as $user_course) {
        $course_id = $user_course['course_id'];
        $course_name = null;
    
        foreach ($courses as $course) {
            if ($course['id'] == $course_id) {
                $course_name = $course['name'];
                break;
            }
        }
    
        if ($course_name!=null) {
            $courses_stat[$course_id] = array(
                'id' => $course_id,
                'name' => $course_name,
                'start_date' => $user_course['start_date'],
                'completed_points' => 0,
                'completed_lessons' => 0,
                'total_points' => 0,
                'total_lessons' => 0
            );
            foreach ($user_lesson_progress as $user_lesson_progress_item) {
                if ($user_lesson_progress_item['completed'] == 1) {
                    $lesson_id = $user_lesson_progress_item['lesson_id'];
                    foreach ($lessons as $lesson) {
                        if ($lesson['id'] == $lesson_id && $lesson['course_id'] == $course_id) {
                            $courses_stat[$course_id]['completed_points'] += $lesson['points'];
                            $courses_stat[$course_id]['completed_lessons']++;
                        }
                    }
                }
            }
            foreach ($lessons as $lesson) {
                if ($lesson['course_id'] == $course_id) {
                    $courses_stat[$course_id]['total_points'] += $lesson['points'];
                    $courses_stat[$course_id]['total_lessons']++;
                }
            }
        }
    }

    $courses_stat = array_filter($courses_stat);
    $conn->close();
    return $courses_stat;
}
?>