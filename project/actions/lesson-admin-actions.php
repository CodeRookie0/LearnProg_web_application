<?php
session_start();

$response = array('status' => 'error', 'message' => '');

require_once '../data-repositories/database.php';
$conn = connectDB();
if (!$conn) {
    $response['message'] = 'Connection failed: ' . mysqli_connect_error();
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {
        case 'addLesson':
            addLesson($conn);
            break;

        case 'editLesson':
            editLesson($conn);
            break;

        case 'getLesson':
            getLesson($conn);
            break;

        case 'deleteLesson':
            deleteLesson($conn);
            break;

        case 'addLessonFile':
            addLessonFile($conn);
            break;
    
        case 'editLessonFile':
            editLessonFile($conn);
            break;
    
        case 'getLessonFile':
            getLessonFile($conn);
            break;
    
        case 'deleteLessonFile':
            deleteLessonFile($conn);
            break;

        case 'addTask':
            addTask($conn);
            break;
    
        case 'editTask':
            editTask($conn);
            break;
    
        case 'getTask':
            getTask($conn);
            break;
    
        case 'deleteTask':
            deleteTask($conn);
            break;
    

        default:
            $response['message'] = "Invalid action.";
            echo json_encode($response);
            exit();
    }
}

mysqli_close($conn);
exit();

function addLesson($conn) {
    $response = array('status' => 'error', 'message' => '');
    $courseId  = isset($_POST['courseId']) ? $_POST['courseId'] : '';
    $title  = isset($_POST['title']) ? $_POST['title'] : '';
    $order = isset($_POST['order']) ? $_POST['order'] : '';
    $points = isset($_POST['points']) ? $_POST['points'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    if (empty($courseId) || empty($title) || empty($order) || empty($points)) {
        $response['message'] = 'Please provide all required fields.';
    } elseif (empty($content)) {
        $response['message'] = 'Please provide content for the lesson.';
    } else {
        $courseId = mysqli_real_escape_string($conn, $courseId);
        $title = mysqli_real_escape_string($conn, $title);
        $order = mysqli_real_escape_string($conn, $order);
        $points = mysqli_real_escape_string($conn, $points);

        $checkCourseQuery = "SELECT * FROM course WHERE crs_course_id = '$courseId'";
        $courseResult = mysqli_query($conn, $checkCourseQuery);

        if (!$courseResult) {
            $response['message'] = 'Error executing course query: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($courseResult) == 0) {
            $response['message'] = 'The provided course ID does not exist.';
        } else {
            $query = "SELECT * FROM lesson WHERE les_course_id = '$courseId' AND les_lesson_order = '$order'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                $response['message'] = 'Error executing query: ' . mysqli_error($conn);
            } else {
                if (mysqli_num_rows($result) > 0) {
                    $response['message'] = 'Lesson with the provided course ID and order already exists.';
                } else {
                    $insertQuery = "INSERT INTO lesson (les_course_id, les_lesson_title, les_lesson_content, les_lesson_order, les_points) 
                    VALUES (?, ?, ?, ?, ?)";
        
                    $stmt = mysqli_prepare($conn, $insertQuery);
                    mysqli_stmt_bind_param($stmt, "issii", $courseId, $title, $content, $order, $points);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        $response['status'] = 'success';
                        $response['message'] = 'Lesson added successfully.';
                    } else {
                        $response['message'] = 'Error inserting lesson: ' . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }

    echo json_encode($response);
}

function editLesson($conn) {
    $response = array('status' => 'error', 'message' => '');
    $lessonId = isset($_POST['lessonId']) ? $_POST['lessonId'] : '';
    $courseId = isset($_POST['courseId']) ? $_POST['courseId'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $order = isset($_POST['order']) ? $_POST['order'] : '';
    $points = isset($_POST['points']) ? $_POST['points'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    if (empty($lessonId) || empty($courseId) || empty($title) || empty($order) || empty($points) || empty($content)) {
        $response['message'] = 'Please provide all required fields.';
    } else {
        $lessonId = mysqli_real_escape_string($conn, $lessonId);
        $courseId = mysqli_real_escape_string($conn, $courseId);
        $title = mysqli_real_escape_string($conn, $title);
        $order = mysqli_real_escape_string($conn, $order);
        $points = mysqli_real_escape_string($conn, $points);

        $checkCourseQuery = "SELECT * FROM course WHERE crs_course_id = '$courseId'";
        $courseResult = mysqli_query($conn, $checkCourseQuery);

        if (!$courseResult) {
            $response['message'] = 'Error executing course query: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($courseResult) == 0) {
            $response['message'] = 'The provided course ID does not exist.';
        } else {

            $updateQuery = "UPDATE lesson SET les_course_id = ?, les_lesson_title = ?, les_lesson_content = ?, les_lesson_order = ?, les_points = ? WHERE les_lesson_id = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "issiii", $courseId, $title, $content, $order, $points, $lessonId);

            if (mysqli_stmt_execute($stmt)) {
                $response['status'] = 'success';
                $response['message'] = 'Lesson updated successfully.';
            } else {
                $response['message'] = 'Error updating lesson: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }

    echo json_encode($response);
}

function getLesson($conn) {
    $response = array('status' => 'error', 'message' => '');
    $lessonId = isset($_POST['lessonId']) ? $_POST['lessonId'] : '';

    if (empty($lessonId)) {
        $response['message'] = 'Invalid lesson ID.';
    } else {
        $lessonId = mysqli_real_escape_string($conn, $lessonId);
        $sql = "SELECT * FROM lesson WHERE les_lesson_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $lessonId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $response = array_merge($response, $row);
            $response['status'] = 'success';
        } else {
            $response['message'] = 'Lesson not found';
        }

        mysqli_stmt_close($stmt);
    }

    echo json_encode($response);
}

function deleteLesson($conn) {
    $response = array('status' => 'error', 'message' => '');
    $lessonId = isset($_POST['lessonId']) ? $_POST['lessonId'] : '';

    if (empty($lessonId)) {
        $response['message'] = 'Invalid lesson ID.';
    } else {
        $lessonId = mysqli_real_escape_string($conn, $lessonId);

        $taskCheckQuery = "SELECT * FROM task WHERE tsk_lesson_id = $lessonId";
        $taskCheckResult = mysqli_query($conn, $taskCheckQuery);

        $progressCheckQuery = "SELECT * FROM user_lesson_progress WHERE ulp_lesson_id = $lessonId";
        $progressCheckResult = mysqli_query($conn, $progressCheckQuery);

        $fileCheckQuery = "SELECT * FROM lesson_file WHERE lsf_lesson_id = $lessonId";
        $fileCheckResult = mysqli_query($conn, $fileCheckQuery);

        if ($taskCheckResult && mysqli_num_rows($taskCheckResult) > 0) {
            $response['message'] = "There are tasks associated with this lesson. Please delete them first.";
        } elseif ($progressCheckResult && mysqli_num_rows($progressCheckResult) > 0) {
            $response['message'] = "There are user progress records associated with this lesson. Please handle them first.";
        } elseif ($fileCheckResult && mysqli_num_rows($fileCheckResult) > 0) {
            $response['message'] = "There are lesson files associated with this lesson. Please delete them first.";
        } else {
            $sql = "DELETE FROM lesson WHERE les_lesson_id = $lessonId";

            if (mysqli_query($conn, $sql)) {
                $response['status'] = 'success';
                $response['message'] = "Lesson deleted successfully.";
            } else {
                $response['message'] = "Error deleting lesson: " . mysqli_error($conn);
            }
        }
    }

    echo json_encode($response);
}


function addLessonFile($conn) {
    $response = array('status' => 'error', 'message' => '');

    $lessonId  = isset($_POST['lessonId']) ? $_POST['lessonId'] : '';
    $fileName  = isset($_POST['fileName']) ? $_POST['fileName'] : '';
    $altText  = isset($_POST['altText']) ? $_POST['altText'] : '';
    $filePath = isset($_POST['filePath']) ? $_POST['filePath'] : '';

    if (empty($lessonId) || empty($fileName)  || empty($altText) || empty($filePath) ) {
        $response['message'] = 'Please provide all required fields.';
    } else {
        $lessonId = mysqli_real_escape_string($conn, $lessonId);
        $fileName = mysqli_real_escape_string($conn, $fileName);
        $altText = mysqli_real_escape_string($conn, $altText);
        $filePath = mysqli_real_escape_string($conn, $filePath);

        $checkLessonQuery = "SELECT * FROM lesson WHERE les_lesson_id = '$lessonId'";
        $lessonResult = mysqli_query($conn, $checkLessonQuery);

        if (!$lessonResult) {
            $response['message'] = 'Error executing lesson query: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($lessonResult) == 0) {
            $response['message'] = 'The provided lesson ID does not exist.';
        } else {
            if (!file_exists($filePath)) {
                $response['message'] = 'Invalid file path or file.';
            } else {
                $insertQuery = "INSERT INTO lesson_file (lsf_lesson_id, lsf_file_name, lsf_alt_text, lsf_file_path) 
                VALUES (?, ?, ?, ?)";
            
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, "isss", $lessonId, $fileName, $altText, $filePath);
                        
                if (mysqli_stmt_execute($stmt)) {
                    $response['status'] = 'success';
                    $response['message'] = 'Lesson file added successfully.';
                } else {
                    $response['message'] = 'Error inserting lesson file: ' . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }

    echo json_encode($response);
}

function editLessonFile($conn) {
    $response = array('status' => 'error', 'message' => '');

    $fileId  = isset($_POST['fileId']) ? $_POST['fileId'] : '';
    $lessonId  = isset($_POST['lessonId']) ? $_POST['lessonId'] : '';
    $fileName  = isset($_POST['fileName']) ? $_POST['fileName'] : '';
    $altText  = isset($_POST['altText']) ? $_POST['altText'] : '';
    $filePath = isset($_POST['filePath']) ? $_POST['filePath'] : '';

    if (empty($fileId) || empty($lessonId) || empty($fileName)  || empty($altText) || empty($filePath) ) {
        $response['message'] = 'Please provide all required fields.';
    } else {
        $fileId = mysqli_real_escape_string($conn, $fileId);
        $lessonId = mysqli_real_escape_string($conn, $lessonId);
        $fileName = mysqli_real_escape_string($conn, $fileName);
        $altText = mysqli_real_escape_string($conn, $altText);
        $filePath = mysqli_real_escape_string($conn, $filePath);

        $checkLessonQuery = "SELECT * FROM lesson WHERE les_lesson_id = '$lessonId'";
        $lessonResult = mysqli_query($conn, $checkLessonQuery);

        if (!$lessonResult) {
            $response['message'] = 'Error executing lesson query: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($lessonResult) == 0) {
            $response['message'] = 'The provided lesson ID does not exist.';
        } else {
            if (!file_exists($filePath)) {
                $response['message'] = 'Invalid file path or file.';
            } else {
                $updateQuery = "UPDATE lesson_file SET lsf_lesson_id = ?, lsf_file_name = ?, lsf_alt_text = ?, lsf_file_path = ? WHERE lsf_lessons_file_id = ?";
                $stmt = mysqli_prepare($conn, $updateQuery);
                mysqli_stmt_bind_param($stmt, "isssi", $lessonId, $fileName, $altText, $filePath, $fileId);

                if (mysqli_stmt_execute($stmt)) {
                    $response['status'] = 'success';
                    $response['message'] = 'Lesson file updated successfully.';
                } else {
                    $response['message'] = 'Error updating lesson file: ' . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }

    echo json_encode($response);
}

function getLessonFile($conn) {
    $response = array('status' => 'error', 'message' => '');
    $fileId = isset($_POST['fileId']) ? $_POST['fileId'] : '';

    if (empty($fileId)) {
        $response['message'] = 'Invalid lesson ID.';
    } else {
        $fileId = mysqli_real_escape_string($conn, $fileId);
        $sql = "SELECT * FROM lesson_file WHERE lsf_lessons_file_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $fileId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $response = array_merge($response, $row);
            $response['status'] = 'success';
        } else {
            $response['message'] = 'Lesson file not found';
        }

        mysqli_stmt_close($stmt);
    }

    echo json_encode($response);
}

function deleteLessonFile($conn) {
    $response = array('status' => 'error', 'message' => '');
    $fileId = isset($_POST['fileId']) ? $_POST['fileId'] : '';

    if (empty($fileId)) {
        $response['message'] = 'Invalid lesson file ID.';
    } else {
        $fileId = mysqli_real_escape_string($conn, $fileId);

        $sql = "DELETE FROM lesson_file WHERE lsf_lessons_file_id = $fileId";

        if (mysqli_query($conn, $sql)) {
            $response['status'] = 'success';
            $response['message'] = "Lesson deleted successfully.";
        } else {
            $response['message'] = "Error deleting lesson: " . mysqli_error($conn);
        }
    }

    echo json_encode($response);
}


function addTask($conn) {
    $response = array('status' => 'error', 'message' => '');

    $lessonId  = isset($_POST['lessonId']) ? $_POST['lessonId'] : '';
    $taskType  = isset($_POST['taskType']) ? $_POST['taskType'] : '';
    $taskDescription  = isset($_POST['taskDescription']) ? $_POST['taskDescription'] : '';
    $taskOptions = isset($_POST['taskOptions']) ? $_POST['taskOptions'] : '';
    $taskSolution = isset($_POST['taskSolution']) ? $_POST['taskSolution'] : '';

    if (empty($lessonId) || empty($taskType)  || empty($taskDescription) || empty($taskSolution) ) {
        $response['message'] = 'Please provide all required fields.';
    } else {
        $lessonId = mysqli_real_escape_string($conn, $lessonId);
        $taskType = mysqli_real_escape_string($conn, $taskType);
        $taskDescription = mysqli_real_escape_string($conn, $taskDescription);
        $taskSolution = mysqli_real_escape_string($conn, $taskSolution);

        if (!empty($taskOptions)){
            $taskOptions = mysqli_real_escape_string($conn, $taskOptions);
            $optionsArray = explode(';', $taskOptions);

            if (count($optionsArray) < 2) {
                $response['status'] = 'error';
                $response['message'] = 'Please provide either no options or more than one option.';
                echo json_encode($response);
                exit();
            }

            if (!in_array($taskSolution, $optionsArray)) {
                $response['status'] = 'error';
                $response['message'] = 'The task solution is not provided in the  task options.';
                echo json_encode($response);
                exit();
            }
        } else {
            $taskOptions = NULL;
        }

        if ($taskType == 2) {
            if (!in_array($taskSolution, ['True', 'False'])) {
                $response['status'] = 'error';
                $response['message'] = 'For this task type, the solution must be either "True" or "False".';
                echo json_encode($response);
                exit();
            }
        }

        if (($taskType == 2 || $taskType == 7) && $taskOptions != NULL) {
            $response['status'] = 'error';
            $response['message'] = 'For this task type, options should not be provided.';
            echo json_encode($response);
            exit();
        }
        
        $checkLessonQuery = "SELECT * FROM lesson WHERE les_lesson_id = '$lessonId'";
        $lessonResult = mysqli_query($conn, $checkLessonQuery);

        if (!$lessonResult) {
            $response['message'] = 'Error executing lesson query: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($lessonResult) == 0) {
            $response['message'] = 'The provided lesson ID does not exist.';
        } else {
                $insertQuery = "INSERT INTO task (tsk_lesson_id, tsk_task_type_id, tsk_task_description, tsk_task_options, tsk_task_solution) 
                VALUES (?, ?, ?, ?, ?)";
            
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, "iisss", $lessonId, $taskType, $taskDescription, $taskOptions, $taskSolution);
                        
                if (mysqli_stmt_execute($stmt)) {
                    $response['status'] = 'success';
                    $response['message'] = 'Task added successfully.';
                } else {
                    $response['message'] = 'Error inserting task: ' . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
        }
    }

    echo json_encode($response);
}

function getTask($conn) {
    $response = array('status' => 'error', 'message' => '');
    $taskId = isset($_POST['taskId']) ? $_POST['taskId'] : '';

    if (empty($taskId)) {
        $response['message'] = 'Invalid task ID.';
    } else {
        $taskId = mysqli_real_escape_string($conn, $taskId);
        $sql = "SELECT * FROM task WHERE tsk_task_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $taskId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $response = array_merge($response, $row);
            $response['status'] = 'success';
        } else {
            $response['message'] = 'Task not found';
        }

        mysqli_stmt_close($stmt);
    }

    echo json_encode($response);
}

function editTask($conn) {
    $response = array('status' => 'error', 'message' => '');

    $taskId  = isset($_POST['taskId']) ? $_POST['taskId'] : '';
    $lessonId  = isset($_POST['lessonId']) ? $_POST['lessonId'] : '';
    $taskType  = isset($_POST['taskType']) ? $_POST['taskType'] : '';
    $taskDescription  = isset($_POST['taskDescription']) ? $_POST['taskDescription'] : '';
    $taskOptions = isset($_POST['taskOptions']) ? $_POST['taskOptions'] : '';
    $taskSolution = isset($_POST['taskSolution']) ? $_POST['taskSolution'] : '';

    if (empty($taskId) || empty($lessonId) || empty($taskType)  || empty($taskDescription) || empty($taskSolution) ) {
        $response['message'] = 'Please provide all required fields.';
    } else {
        $taskId = mysqli_real_escape_string($conn, $taskId);
        $lessonId = mysqli_real_escape_string($conn, $lessonId);
        $taskType = mysqli_real_escape_string($conn, $taskType);

        if (!empty($taskOptions)){
            $optionsArray = explode(';', $taskOptions);

            if (count($optionsArray) < 2) {
                $response['status'] = 'error';
                $response['message'] = 'Please provide either no options or more than one option.';
                echo json_encode($response);
                exit();
            }

            if (!in_array($taskSolution, $optionsArray)) {
                $response['status'] = 'error';
                $response['message'] = 'The task solution is not provided in the  task options.';
                echo json_encode($response);
                exit();
            }
        } else {
            $taskOptions = NULL;
        }

        if ($taskType == 2) {
            if (!in_array($taskSolution, ['True', 'False'])) {
                $response['status'] = 'error';
                $response['message'] = 'For this task type, the solution must be either "True" or "False".';
                echo json_encode($response);
                exit();
            }
        }

        if (($taskType == 2 || $taskType == 7) && $taskOptions != NULL) {
            $response['status'] = 'error';
            $response['message'] = 'For this task type, options should not be provided.';
            echo json_encode($response);
            exit();
        }
        
        $checkLessonQuery = "SELECT * FROM lesson WHERE les_lesson_id = '$lessonId'";
        $lessonResult = mysqli_query($conn, $checkLessonQuery);

        if (!$lessonResult) {
            $response['message'] = 'Error executing lesson query: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($lessonResult) == 0) {
            $response['message'] = 'The provided lesson ID does not exist.';
        } else {
            $updateQuery = "UPDATE task SET tsk_lesson_id = ?, tsk_task_type_id = ?, tsk_task_description = ?, tsk_task_options = ?, tsk_task_solution = ? WHERE tsk_task_id = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "iisssi", $lessonId, $taskType, $taskDescription, $taskOptions, $taskSolution, $taskId);
            
            if (mysqli_stmt_execute($stmt)) {
                $response['status'] = 'success';
                $response['message'] = 'Task updated successfully.';
            } else {
                $response['message'] = 'Error updating task: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }
    echo json_encode($response);
}

function deleteTask($conn) {
    $response = array('status' => 'error', 'message' => '');
    $taskId = isset($_POST['taskId']) ? $_POST['taskId'] : '';

    if (empty($taskId)) {
        $response['message'] = 'Invalid lesson task ID.';
    } else {
        $taskId = mysqli_real_escape_string($conn, $taskId);

        $sql = "DELETE FROM task WHERE tsk_task_id = $taskId";

        if (mysqli_query($conn, $sql)) {
            $response['status'] = 'success';
            $response['message'] = "Task deleted successfully.";
        } else {
            $response['message'] = "Error deleting task: " . mysqli_error($conn);
        }
    }

    echo json_encode($response);
}
?>

