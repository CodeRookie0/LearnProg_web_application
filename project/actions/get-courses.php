<?php
require_once '../data-repositories/database.php';
$conn = connectDB();

$sql = "SELECT * FROM course";
$result = mysqli_query($conn, $sql);

$courses = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
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

mysqli_close($conn);

echo json_encode($courses);
?>
