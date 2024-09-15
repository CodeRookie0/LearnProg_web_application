<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'database.php';

function getCourses() {
    $conn = connectDB();
    
    $sql = "SELECT crs_course_id, crs_course_name, crs_short_description, crs_full_description, crs_level, crs_status, crs_image_path FROM course";
    $result = $conn->query($sql);
    
    $courses = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $course = array(
                "id" => $row["crs_course_id"],
                "name" => $row["crs_course_name"],
                "short_description" => $row["crs_short_description"],
                "full_description" => $row["crs_full_description"],
                "level" => $row["crs_level"],
                "status" => $row["crs_status"],
                "image_path" => $row["crs_image_path"]
            );
            $courses[] = $course;
        }
    }
    
    $conn->close();
    
    return $courses;
}

function getCoursesWithTopics() {
    $courses = getCourses(); 
    
    $conn = connectDB();
    
    foreach ($courses as &$course) {
        $course_id = $course["id"];
        $topics_query = "SELECT top_topic_name FROM topic WHERE top_course_id = $course_id";
        $topics_result = $conn->query($topics_query);
        $topics = array();
        if ($topics_result->num_rows > 0) {
            while ($topic_row = $topics_result->fetch_assoc()) {
                $topics[] = $topic_row["top_topic_name"];
            }
        }
        $course["topics"] = $topics;
    }
    
    $conn->close();
    
    return $courses;
}

function getTopics() {
    $conn = connectDB();

    $sql = "SELECT `top_topic_id` AS topic_id, `top_topic_name` AS topic_name, `top_course_id` AS course_id FROM `topic`";
    $result = $conn->query($sql);
    $topics = array(); 

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $topics[] = $row;
        }
    } else {
        echo "No results.";
    }

    $conn->close();

    return $topics;
}

function getTotalCourseInfo($course_id) {
    $conn = connectDB();

    $sql = "SELECT COUNT(*) AS total_lessons, SUM(les_points) AS total_points FROM lesson WHERE les_course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $total_lessons = $row['total_lessons'];
    $total_points = $row['total_points'];

    $stmt->close();
    $conn->close();

    return array(
        'total_points' => $total_points,
        'total_lessons' => $total_lessons
    );
}

function getCourseFullDescription($course_id) {
    $conn = connectDB();

    $sql = "SELECT crs_full_description FROM course WHERE crs_course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $stmt->bind_result($full_description);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    return $full_description;
}

function getCourseStatus($course_id) {
    $conn = connectDB();
    
    $course_id = mysqli_real_escape_string($conn, $course_id);
    
    $sql = "SELECT crs_status FROM course WHERE crs_course_id = '$course_id'";
    $result = $conn->query($sql);
    
    $status = null;
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['crs_status'];
    }
    
    $conn->close();
    
    return $status;
}
?>