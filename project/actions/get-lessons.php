<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['courseId'])) {
    $courseId = $_POST['courseId'];

    require_once '../data-repositories/database.php';
    $conn = connectDB();

    $courseId = mysqli_real_escape_string($conn, $courseId);

    $sql = "SELECT * FROM lesson WHERE les_course_id = '$courseId'";
    $result = mysqli_query($conn, $sql);

    $lessons = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $lesson = array(
                "id" => $row["les_lesson_id"],
                "course_id" => $row["les_course_id"],
                "title" => $row["les_lesson_title"],
                "content" => $row["les_lesson_content"],
                "order" => $row["les_lesson_order"],
                "points" => $row["les_points"]
            );
            $lessons[] = $lesson;
        }
    }

    mysqli_close($conn);
    
    echo json_encode($lessons);
} else {
    echo json_encode([]);
}
?>
