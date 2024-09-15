<?php
session_start();

$response = array('status' => 'error', 'message' => '');

require_once '../data-repositories/database.php';
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {
        case 'addCourse':
            addCourse($conn);
            break;

        case 'updateCourse':
            updateCourse($conn);
            break;

        case 'getCourse':
            getCourse($conn);
            break;

        case 'deleteCourse':
            deleteCourse($conn);
            break;
        case 'addTopic':
            addCourseTopic($conn);
            break;

        case 'updateTopic':
            updateCourseTopic($conn);
            break;

        case 'getTopic':
            getCourseTopic($conn);
            break;

        case 'deleteTopic':
            deleteCourseTopic($conn);
            break;

        default:
            $response['message'] = "Invalid action.";
            echo json_encode($response);
            exit();
    }
} else {
    $response['message'] = "Invalid request method.";
    echo json_encode($response);
    exit();
}

function addCourse($conn) {
    $response = array('status' => 'error', 'message' => '');

    $courseName = isset($_POST['courseName']) ? $_POST['courseName'] : '';
    $fullDescription = isset($_POST['fullDescription']) ? $_POST['fullDescription'] : '';
    $shortDescription = isset($_POST['shortDescription']) ? $_POST['shortDescription'] : '';
    $level = isset($_POST['level']) ? $_POST['level'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $imagePath = isset($_POST['imagePath']) ? $_POST['imagePath'] : '';

    if (empty($courseName) || empty($fullDescription) || empty($shortDescription) || empty($level) || empty($status) || empty($imagePath)) {
        $response['message'] = 'Please provide all required fields.';
    } else {
        $level = mysqli_real_escape_string($conn, $level);
        $status = mysqli_real_escape_string($conn, $status);
        $imagePath = mysqli_real_escape_string($conn, $imagePath);
        $normalizedCourseName = str_replace(' ', '', $courseName);

        $stmt = $conn->prepare("SELECT * FROM course WHERE REPLACE(crs_course_name, ' ', '') = ?");
        $stmt->bind_param("s", $normalizedCourseName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response['message'] = "Course name must be unique. Entered course name already exists.";
        } else {
            if (!file_exists($imagePath)) {
                $response['message'] = 'Invalid image path or file.';
            } else {
                $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                $allowedExtensions = array('jpeg', 'jpg', 'png', 'gif');
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    $response['message'] = 'Invalid image path or file.';
                } else {
                    $sql = "INSERT INTO course (crs_course_name, crs_full_description, crs_short_description, crs_level, crs_status, crs_image_path) 
                            VALUES ('$courseName', '$fullDescription', '$shortDescription', '$level', '$status', '$imagePath')";
                    if (mysqli_query($conn, $sql)) {
                        $response['status'] = 'success';
                        $response['message'] = 'Course added successfully.';
                    } else {
                        $response['message'] = 'Error adding course: ' . mysqli_error($conn);
                    }
                }
            }
        }
    }

    echo json_encode($response);
    exit();
}

function updateCourse($conn) {
    $response = array('status' => 'error', 'message' => '');

    if (isset($_POST['courseId'], $_POST['courseName'], $_POST['shortDescription'], $_POST['fullDescription'], $_POST['level'], $_POST['status'], $_POST['imagePath'])) {
        $courseId = $_POST['courseId'];
        $courseName = $_POST['courseName'];
        $shortDescription = $_POST['shortDescription'];
        $fullDescription =  $_POST['fullDescription'];
        $level =  $_POST['level'];
        $status =  $_POST['status'];
        $imagePath =  $_POST['imagePath'];

        if (empty($courseId) || empty($courseName) || empty($shortDescription) || empty($fullDescription) || empty($level) || empty($status) || empty($imagePath)) {
            $response['message'] = 'Complete all required fields.';
        } else {
            $level = mysqli_real_escape_string($conn, $level);
            $status = mysqli_real_escape_string($conn, $status);
            $imagePath = mysqli_real_escape_string($conn, $imagePath);
            $normalizedCourseName = str_replace(' ', '', $courseName);

            $stmt = $conn->prepare("SELECT * FROM course WHERE REPLACE(crs_course_name, ' ', '') = ? AND crs_course_id != ?");
            $stmt->bind_param("si", $normalizedCourseName, $courseId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $response['message'] = "Course name must be unique. Entered course name already exists.";
            } else {
                if (!file_exists($imagePath)) {
                    $response['message'] = 'Invalid image path or file.';
                } else {
                    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                    $allowedExtensions = array('jpeg', 'jpg', 'png', 'gif');
                    if (!in_array(strtolower($extension), $allowedExtensions)) {
                        $response['message'] = 'Invalid image path or file.';
                    } else if ($level === 'Active') {
                        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM lesson WHERE les_course_id = ?");
                        $stmt->bind_param("i", $courseId);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $lessonCount = $row['count'];

                            if ($lessonCount < 3) {
                                $response['message'] = 'For a course to be active, it must have at least 3 lessons.';
                            } else {
                                updateCourseData($conn, $courseId, $courseName, $fullDescription, $shortDescription, $level, $status, $imagePath, $response);
                            }
                        } else {
                            $response['message'] = 'Error occurred while checking lessons for the course.';
                        }
                    } else {
                        updateCourseData($conn, $courseId, $courseName, $fullDescription, $shortDescription, $level, $status, $imagePath, $response);
                    }
                }
            }
        }
    } else {
        $response['message'] = 'Complete all required fields.';
    }

    echo json_encode($response);
    exit();
}

function updateCourseData($conn, $courseId, $courseName, $fullDescription, $shortDescription, $level, $status, $imagePath, &$response) {
    $sql = "UPDATE course SET crs_course_name = ?, crs_full_description = ?, crs_short_description = ?, crs_level = ?, crs_status = ?, crs_image_path = ? WHERE crs_course_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $courseName, $fullDescription, $shortDescription, $level, $status, $imagePath, $courseId);

    if (mysqli_stmt_execute($stmt)) {
        $response['status'] = 'success';
        $response['message'] = "Course data updated successfully.";
    } else {
        $response['message'] = "Failed to update course data: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function getCourse($conn) {
    if (isset($_POST['courseId'])) {
        $courseId = $_POST['courseId'];

        $sql = "SELECT c.crs_course_id, c.crs_course_name, c.crs_short_description, c.crs_full_description, c.crs_level, c.crs_status, c.crs_image_path
                FROM course c
                WHERE c.crs_course_id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $courseId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Course not found.']);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo json_encode(['error' => 'Missing courseId parameter.']);
    }

    exit();
}

function deleteCourse($conn) {
    $response = array('status' => 'error', 'message' => '');

    if (isset($_POST['courseId'])) {
        $courseId = $_POST['courseId'];

        $sql = "DELETE FROM course WHERE crs_course_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $courseId);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 'success';
            $response['message'] = "Course deleted successfully.";
        } else {
            $response['message'] = "Error deleting course: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        $response['message'] = "Invalid request.";
    }

    echo json_encode($response);
    exit();
}

function addCourseTopic($conn) {
    $response = array('status' => 'error', 'message' => '');

    $courseId = isset($_POST['courseId']) ? $_POST['courseId'] : '';
    $topicName = isset($_POST['topicName']) ? $_POST['topicName'] : '';

    if (empty($courseId) || empty($topicName)) {
        $response['message'] = 'Please provide all required fields.';
    } else {
        $courseId = mysqli_real_escape_string($conn, $courseId);
        $topicName = mysqli_real_escape_string($conn, $topicName);
        
        $checkCourseQuery = "SELECT * FROM course WHERE crs_course_id = '$courseId'";
        $courseResult = mysqli_query($conn, $checkCourseQuery);

        if (!$courseResult) {
            $response['message'] = 'Error executing course query: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($courseResult) == 0) {
            $response['message'] = 'The provided course ID does not exist.';
        } else {
            $sql = "INSERT INTO `topic`(`top_topic_name`, `top_course_id`) VALUES (?,?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'si', $topicName, $courseId);

            if (mysqli_stmt_execute($stmt)) {
                $response['status'] = 'success';
                $response['message'] = "Course topic added successfully.";
            } else {
                $response['message'] = "Error adding course topic: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }
    
    echo json_encode($response);
    exit();
}

function updateCourseTopic($conn) {
    $response = array('status' => 'error', 'message' => '');

    if (isset($_POST['topicId'],$_POST['courseId'], $_POST['topicName'])) {
        $topicId = $_POST['topicId'];
        $courseId = $_POST['courseId'];
        $topicName = $_POST['topicName'];

        if (empty($topicId) || empty($courseId) || empty($topicName)) {
            $response['message'] = 'Complete all required fields.';
        } else {
            $courseId = mysqli_real_escape_string($conn, $courseId);
            $topicName = mysqli_real_escape_string($conn, $topicName);

            $checkCourseQuery = "SELECT * FROM course WHERE crs_course_id = '$courseId'";
            $courseResult = mysqli_query($conn, $checkCourseQuery);

            if (!$courseResult) {
                $response['message'] = 'Error executing course query: ' . mysqli_error($conn);
            } elseif (mysqli_num_rows($courseResult) == 0) {
                $response['message'] = 'The provided course ID does not exist.';
            } else {
                $sql = "UPDATE `topic` SET top_course_id = ?, top_topic_name = ? WHERE top_topic_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, 'isi', $courseId, $topicName, $topicId);

                if (mysqli_stmt_execute($stmt)) {
                    $response['status'] = 'success';
                    $response['message'] = "Course topic data updated successfully.";
                } else {
                    $response['message'] = "Failed to update course topic data: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            }
        }
    } else {
        $response['message'] = 'Complete all required fields.';
    }

    echo json_encode($response);
    exit();
}

function getCourseTopic($conn) {
    if (isset($_POST['topicId'])) {
        $topicId = $_POST['topicId'];

        $sql = "SELECT `top_topic_id`, `top_topic_name`, `top_course_id`
                FROM `topic`
                WHERE `top_topic_id`= ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $topicId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Course topic not found.']);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo json_encode(['error' => 'Missing topicId parameter.']);
    }

    exit();
}

function deleteCourseTopic($conn) {
    $response = array('status' => 'error', 'message' => '');

    if (isset($_POST['topicId'])) {
        $topicId = $_POST['topicId'];

        $sql = "DELETE FROM topic WHERE top_topic_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $topicId);

        if (mysqli_stmt_execute($stmt)) {
            $response['status'] = 'success';
            $response['message'] = "Course topic deleted successfully.";
        } else {
            $response['message'] = "Error deleting course topic: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        $response['message'] = "Invalid request.";
    }

    echo json_encode($response);
    exit();
}
?>