<?php
session_start();
$response = array('status' => 'error', 'message' => '');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["lessonId"]) && isset($_POST["sourceCourseId"]) && isset($_POST["targetCourseId"]) && isset($_POST["targetOrder"])) {
        require_once '../data-repositories/database.php';
        $conn = connectDB();
        $lessonId = $_POST["lessonId"];
        $sourceCourseId = $_POST["sourceCourseId"];
        $targetCourseId = $_POST["targetCourseId"];
        $targetOrder = $_POST["targetOrder"];

        $query = "SELECT les_lesson_order FROM lesson WHERE les_lesson_id = $lessonId";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $sourceOrder = $row["les_lesson_order"];

                $updateQuerySource = "UPDATE lesson SET les_lesson_order = les_lesson_order - 1 WHERE les_course_id = $sourceCourseId AND les_lesson_order > $sourceOrder";
                $updateResultSource = mysqli_query($conn, $updateQuerySource);
                
                if ($updateResultSource) {
                    $updateQueryTarget = "UPDATE lesson SET les_lesson_order = les_lesson_order + 1 WHERE les_course_id = $targetCourseId AND les_lesson_order >= $targetOrder";
                    $updateResultTarget = mysqli_query($conn, $updateQueryTarget);
                    if ($updateResultTarget) {
                        $updateQueryLesson = "UPDATE lesson SET les_lesson_order = $targetOrder, les_course_id = $targetCourseId WHERE les_lesson_id = $lessonId";
                        $updateResultLesson = mysqli_query($conn, $updateQueryLesson);
                        if ($updateResultLesson) {
                            $response['status'] = 'success';
                            $response['message'] = 'Lesson ID ' . $lessonId . ' previously located in course ID ' . $sourceCourseId . ' at position '. $sourceOrder .' has been moved to course ' . $targetCourseId . ' at position ' . $targetOrder . '.';
                        } else {
                            $response['message'] = 'Error updating lesson: ' . mysqli_error($conn);
                        }
                    } else {
                        $response['message'] = 'Error updating lesson order in target course: ' . mysqli_error($conn);
                    }
                } else {
                    $response['message'] = 'Error updating lesson order in source course: ' . mysqli_error($conn);
                }
            } else {
                $response['message'] = 'Lesson with the provided ID was not found.';
            }
        } else {
            $response['message'] = 'Query error: ' . mysqli_error($conn);
        }
    }
}


echo json_encode($response);
exit();
?>