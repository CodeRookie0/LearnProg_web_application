<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$response = array('status' => 'error', 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['action'])) {
        $response['message'] = "Missing action parameter.";
        echo json_encode($response);
        exit();
    }

    require_once '../data-repositories/database.php';
    $conn = connectDB();

    switch ($_POST['action']) {
        case 'addUser':
            addUser($conn, $response);
            break;
        case 'updateUser':
            updateUser($conn, $response);
            break;
        case 'getUser':
            getUser($conn, $response);
            break;
        case 'deleteUser':
            deleteUser($conn, $response);
            break;
        case 'addUserCourseProgress':
            addUserCourseProgress($conn, $response);
            break;
        case 'updateUserCourseProgress':
            updateUserCourseProgress($conn, $response);
            break;
        case 'getUserCourseProgress':
            getUserCourseProgress($conn, $response);
            break;
        case 'deleteUserCourseProgress':
            deleteUserCourseProgress($conn, $response);
            break;
        case 'addUserLessonProgress':
            addUserLessonProgress($conn, $response);
            break;
        case 'updateUserLessonProgress':
            updateUserLessonProgress($conn, $response);
            break;
        case 'getUserLessonProgress':
            getUserLessonProgress($conn, $response);
            break;
        case 'deleteUserLessonProgress':
            deleteUserLessonProgress($conn, $response);
            break;
        default:
            $response['message'] = "Invalid action.";
            break;
    }

    mysqli_close($conn);
} else {
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);
exit();

function addUser($conn, &$response) {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['userType'])) {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $userType = intval($_POST['userType']);

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password);
        $password_length = strlen($password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || $password_length < 8) {
            $response['message'] = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
        } elseif (empty($username) || empty($email)) {
            $response['message'] = "Username and Email are required.";
        } else {
            $stmt = $conn->prepare("SELECT usr_user_id FROM user WHERE usr_username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $response['message'] = "Username is already taken.";
            } else {
                $stmt = $conn->prepare("SELECT usr_user_id FROM user WHERE usr_email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $response['message'] = "Email address is already registered.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO user (usr_username, usr_email, usr_password, usr_user_type_id) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("sssi", $username, $email, $hashed_password, $userType);

                    if ($stmt->execute()) {
                        $user_id = $stmt->insert_id;
                        $stmt_notification = $conn->prepare("INSERT INTO notification (ntf_user_id) VALUES (?)");
                        $stmt_notification->bind_param("i", $user_id);
                        $stmt_notification->execute();

                        $response['status'] = 'success';
                    } else {
                        $response['message'] = "Error registering user.";
                    }
                }
            }
        }
    } else {
        $response['message'] = "Invalid data submitted.";
    }
}

function updateUser($conn, &$response) {
    if (isset($_POST['userId'], $_POST['username'], $_POST['email'], $_POST['userType'], $_POST['registrationDate'])) {
        $userId = $_POST['userId'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $userType = $_POST['userType'];
        $registrationDate = $_POST['registrationDate'];

        if (empty($userId) || empty($username) || empty($email) || empty($userType) || empty($registrationDate)) {
            $response['message'] = 'All fields except password are required and cannot be blank. Complete all required fields.';
        } else {
            $stmt = $conn->prepare("SELECT usr_user_id FROM user WHERE usr_username = ? AND usr_user_id != ?");
            $stmt->bind_param("si", $username, $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $response['message'] = "Username is already taken.";
            } else {
                $stmt = $conn->prepare("SELECT usr_user_id FROM user WHERE usr_email = ? AND usr_user_id != ?");
                $stmt->bind_param("si", $email, $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $response['message'] = "Email address is already registered.";
                } else {
                    $stmt = $conn->prepare("SELECT uc.ucr_start_date FROM user_course uc WHERE uc.ucr_user_id = ? AND uc.ucr_start_date < ?");
                    $stmt->bind_param("is", $userId, $registrationDate);
                    $stmt->execute();
                    $result_course = $stmt->get_result();

                    $stmt = $conn->prepare("SELECT ulp.ulp_completion_date FROM user_lesson_progress ulp WHERE ulp.ulp_user_id = ? AND ulp.ulp_completion_date < ?");
                    $stmt->bind_param("is", $userId, $registrationDate);
                    $stmt->execute();
                    $result_lesson = $stmt->get_result();

                    if ($result_course->num_rows > 0 || $result_lesson->num_rows > 0) {
                        $response['message'] = "The registration date cannot be changed. The user started or finished the course or lesson earlier than the specified date.";
                    } else {
                        if (isset($_POST['password']) && isset($_POST['passwordConfirm']) && $_POST['password'] !== '' && $_POST['passwordConfirm'] !== '') {
                            $password = $_POST['password'];
                            $passwordConfirm = $_POST['passwordConfirm'];

                            if ($password !== $passwordConfirm) {
                                $response['message'] = "Passwords do not match.";
                            } else {
                                $uppercase = preg_match('@[A-Z]@', $password);
                                $lowercase = preg_match('@[a-z]@', $password);
                                $number = preg_match('@[0-9]@', $password);
                                $specialChars = preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password);
                                $password_length = strlen($password);

                                if (!$uppercase || !$lowercase || !$number || !$specialChars || $password_length < 8) {
                                    $response['message'] = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
                                } else {
                                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                    $stmt = $conn->prepare("UPDATE user SET usr_username = ?, usr_email = ?, usr_user_type_id = ?, usr_registration_date = ?, usr_password = ? WHERE usr_user_id = ?");
                                    $stmt->bind_param("ssissi", $username, $email, $userType, $registrationDate, $hashed_password, $userId);

                                    if ($stmt->execute()) {
                                        $response['status'] = 'success';
                                        $response['message'] = "User data and password have been successfully updated";
                                    } else {
                                        $response['message'] = "Failed to update user data: " . $stmt->error;
                                    }
                                }
                            }
                        } else {
                            $stmt = $conn->prepare("UPDATE user SET usr_username = ?, usr_email = ?, usr_user_type_id = ?, usr_registration_date = ? WHERE usr_user_id = ?");
                            $stmt->bind_param("ssisi", $username, $email, $userType, $registrationDate, $userId);

                            if ($stmt->execute()) {
                                $response['status'] = 'success';
                                $response['message'] = "User data updated successfully";
                            } else {
                                $response['message'] = "Failed to update user data: " . $stmt->error;
                            }
                        }
                    }
                }
            }
        }
    } else {
        $response['message'] = 'All fields except password are required and cannot be blank. Complete all required fields.';
    }
}

function getUser($conn, &$response) {
    if (isset($_POST['userId'])) {
        $userId = $_POST['userId'];

        $stmt = $conn->prepare("SELECT u.usr_user_id, u.usr_username, u.usr_email, u.usr_user_type_id, u.usr_registration_date FROM user u WHERE u.usr_user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $response = $result->fetch_assoc();
        } else {
            $response['message'] = 'User not found';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Missing userId parameter';
    }
}

function deleteUser($conn, &$response) {
    if (isset($_POST['userId'])) {
        $userId = $_POST['userId'];

        $deleteNotificationsSql = "DELETE FROM notification WHERE ntf_user_id = $userId";
        if (mysqli_query($conn, $deleteNotificationsSql)) {
            $deleteUserSql = "DELETE FROM user WHERE usr_user_id = $userId";
            if (mysqli_query($conn, $deleteUserSql)) {
                $response['message'] = "User deleted successfully";
                $response['status'] = 'success';
            } else {
                $response['message'] = "Error deleting user: " . mysqli_error($conn);
            }
        } else {
            $response['message'] = "Error deleting user notifications: " . mysqli_error($conn);
        }
    } else {
        $response['message'] = "Invalid request";
    }
}

function addUserCourseProgress($conn, &$response) {
    if (isset($_POST['userId'], $_POST['courseId'], $_POST['startDate'])) {
        $userId = $_POST['userId'];
        $courseId = $_POST['courseId'];
        $startDate = $_POST['startDate'];
        $completionDate = isset($_POST['completionDate']) && !empty($_POST['completionDate']) ? $_POST['completionDate'] : NULL;

        if (!checkUserExists($conn, $userId)) {
            $response = ['message' => "User ID does not exist.", 'status' => 'error'];
            return;
        }

        $course = checkCourseExists($conn, $courseId);
        if (!$course) {
            $response = ['message' => "Course ID does not exist.", 'status' => 'error'];
            return;
        }

        if ($course['crs_status'] !== "Active") {
            $response = ['message' => "This course cannot be started or completed as its status is not Active.", 'status' => 'error'];
            return;
        }
        
        if($completionDate!=NULL){
            $checkLessonCompletionSql = "
                SELECT COUNT(*) AS total_lessons,
                    COALESCE(SUM(IF(ulp_completed = 1, 1, 0)), 0) AS completed_lessons
                FROM lesson
                LEFT JOIN user_lesson_progress ON lesson.les_lesson_id = user_lesson_progress.ulp_lesson_id
                                            AND user_lesson_progress.ulp_user_id = ?
                WHERE lesson.les_course_id = ?
            ";
            $stmt = $conn->prepare($checkLessonCompletionSql);
            $stmt->bind_param('ii', $userId, $courseId);
            $stmt->execute();
            $result = $stmt->get_result();
            $lessonCompletionInfo = $result->fetch_assoc();
            $totalLessons = $lessonCompletionInfo['total_lessons'];
            $completedLessons = $lessonCompletionInfo['completed_lessons'];
            
            if ($totalLessons != $completedLessons) {
                $response['message'] = "All lessons of this course must be completed by the user before setting the completion date.";
                $response['status'] = 'error';
                return;
            }
        }

        $checkSql = "SELECT * FROM user_course WHERE ucr_user_id = ? AND ucr_course_id = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param('ii', $userId, $courseId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response['message'] = "Course progress for this user and course already exists.";
            $response['status'] = 'error';
        } else {
            $insertSql = "INSERT INTO user_course (ucr_user_id, ucr_course_id, ucr_start_date, ucr_completion_date) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param('iiss', $userId, $courseId, $startDate, $completionDate);

            if ($stmt->execute()) {
                $response['message'] = "User course progress added successfully.";
                $response['status'] = 'success';
            } else {
                $response['message'] = "Error adding user course progress: " . $conn->error;
                $response['status'] = 'error';
            }
        }
    } else {
        $response['message'] = "Invalid request. Missing parameters.";
        $response['status'] = 'error';
    }
}

function updateUserCourseProgress($conn, &$response) {
    if (isset($_POST['userId'], $_POST['courseId'], $_POST['completionDate'], $_POST['startDate'])) {
        $userId = $_POST['userId'];
        $courseId = $_POST['courseId'];
        $startDate = $_POST['startDate'];
        $completionDate = isset($_POST['completionDate']) && !empty($_POST['completionDate']) ? $_POST['completionDate'] : NULL;

        if($completionDate!=NULL){
            $checkLessonCompletionSql = "
                SELECT COUNT(*) AS total_lessons,
                    COALESCE(SUM(IF(ulp_completed = 1, 1, 0)), 0) AS completed_lessons
                FROM lesson
                LEFT JOIN user_lesson_progress ON lesson.les_lesson_id = user_lesson_progress.ulp_lesson_id
                                            AND user_lesson_progress.ulp_user_id = ?
                WHERE lesson.les_course_id = ?
            ";
            $stmt = $conn->prepare($checkLessonCompletionSql);
            $stmt->bind_param('ii', $userId, $courseId);
            $stmt->execute();
            $result = $stmt->get_result();
            $lessonCompletionInfo = $result->fetch_assoc();
            $totalLessons = $lessonCompletionInfo['total_lessons'];
            $completedLessons = $lessonCompletionInfo['completed_lessons'];
            
            if ($totalLessons != $completedLessons) {
                $response['message'] = "All lessons of this course must be completed by the user before setting the completion date.";
                $response['status'] = 'error';
                return;
            }
        }

        $userCourse = checkUserCourseExists($conn, $userId, $courseId);

        if ($userCourse) {
            $updateSql = "UPDATE user_course SET ucr_completion_date = ?, ucr_start_date = ? WHERE ucr_user_id = ? AND ucr_course_id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param('ssii', $completionDate, $startDate, $userId, $courseId);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = "User course progress updated successfully";
            } else {
                $response['message'] = "Failed to update user course progress: " . $stmt->error;
            }
        } else {
            $response['message'] = "User course progress not found";
        }
    } else {
        $response['message'] = "Invalid request. Missing parameters.";
    }
}

function getUserCourseProgress($conn, &$response) {
    if (isset($_POST['userId'], $_POST['courseId'])) {
        $userId = $_POST['userId'];
        $courseId = $_POST['courseId'];

        $stmt = $conn->prepare("SELECT ucr_user_id, ucr_course_id, ucr_start_date, ucr_completion_date FROM user_course WHERE ucr_user_id = ? AND ucr_course_id = ?");
        $stmt->bind_param("ii", $userId, $courseId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $response = $result->fetch_assoc();
        } else {
            $response['message'] = 'No course progress found for the user.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Missing userId or courseId parameter';
    }
}

function deleteUserCourseProgress($conn, &$response) {
    if (isset($_POST['userId']) && isset($_POST['courseId'])) {
        $userId = $_POST['userId'];
        $courseId = $_POST['courseId'];

        if (!empty($userId) && !empty($courseId)) {
            $checkSql = "SELECT l.les_lesson_id FROM user_lesson_progress ul
                        LEFT JOIN lesson l ON l.les_lesson_id = ul.ulp_lesson_id
                        WHERE ul.ulp_user_id = ? AND ul.ulp_completed = 1 AND l.les_course_id = ?";
            
            if ($stmt = $conn->prepare($checkSql)) {
                $stmt->bind_param("ii", $userId, $courseId);
                $stmt->execute();
                $result_check = $stmt->get_result();

                if ($result_check->num_rows > 0) {
                    $response['message'] = "Progress of user ID $userId in course ID $courseId cannot be deleted. User has completed the lessons of this course. First delete the user's progress in the lessons of this course.";
                } else {
                    $deleteSql = "DELETE FROM user_course WHERE ucr_user_id = ? AND ucr_course_id = ?";
                    if ($stmt = $conn->prepare($deleteSql)) {
                        $stmt->bind_param("ii", $userId, $courseId);
                        if ($stmt->execute()) {
                            $response['status'] = 'success';
                            $response['message'] = "Progress of user ID $userId in course ID $courseId deleted successfully";
                        } else {
                            $response['message'] = "Error deleting progress of user ID $userId in course ID $courseId: " . $stmt->error;
                        }
                    } else {
                        $response['message'] = "Error preparing delete statement: " . $conn->error;
                    }
                }
                $stmt->close();
            } else {
                $response['message'] = "Error preparing check statement: " . $conn->error;
            }
        } else {
            $response['message'] = "Invalid userId or courseId";
        }
    } else {
        $response['message'] = "Invalid request";
    }
}

function addUserLessonProgress($conn, &$response) {
    if (isset($_POST['userId'], $_POST['lessonId'], $_POST['completionDate'])) {
        $userId = $_POST['userId'];
        $lessonId = $_POST['lessonId'];
        $completed=1;
        $completionDate = $_POST['completionDate'];

        if (!checkUserExists($conn, $userId)) {
            $response = ['message' => "User ID does not exist.", 'status' => 'error'];
            return;
        }

        $lesson = checkLessonExists($conn, $lessonId);
        if (!$lesson) {
            $response = ['message' => "Lesson ID does not exist.", 'status' => 'error'];
            return;
        }

        $lessonOrder = $lesson['les_lesson_order'];
        $courseId = $lesson['les_course_id'];

        $userCourse = checkUserCourseExists($conn, $userId, $courseId);

        if (!$userCourse) {
            $response['message'] = "Cannot add lesson progress. The course to which this lesson belongs has not been started by the user. Please add course progress first, then you can add lesson progress.";
            $response['status'] = 'error';
            return;
        }

        $courseStartDate = $userCourse['ucr_start_date'];

        if ($completionDate < $courseStartDate) {
            $response['message'] = "Completion date cannot be earlier than the course start date.";
            $response['status'] = 'error';
            return;
        }

        $checkPreviousLessonCompletionDateSql = "
            SELECT ulp_completion_date
            FROM lesson
            LEFT JOIN user_lesson_progress ON lesson.les_lesson_id = user_lesson_progress.ulp_lesson_id 
            AND user_lesson_progress.ulp_user_id = ?
            WHERE lesson.les_course_id = ? 
            AND lesson.les_lesson_order < ?
            ORDER BY lesson.les_lesson_order DESC
            LIMIT 1
        ";
        $stmt = $conn->prepare($checkPreviousLessonCompletionDateSql);
        $stmt->bind_param('iii', $userId, $courseId, $lessonOrder);
        $stmt->execute();
        $result = $stmt->get_result();
        $previousLessonCompletionDate = $result->fetch_assoc()['ulp_completion_date'];

        if ($previousLessonCompletionDate && $completionDate < $previousLessonCompletionDate) {
            $response['message'] = "Completion date cannot be earlier than the previous lesson's completion date.";
            $response['status'] = 'error';
            return;
        }

        $checkPreviousLessonsSql = "
            SELECT COUNT(*) AS incomplete_lessons
            FROM lesson
            LEFT JOIN user_lesson_progress ON lesson.les_lesson_id = user_lesson_progress.ulp_lesson_id 
            AND user_lesson_progress.ulp_user_id = ?
            WHERE lesson.les_course_id = ? 
            AND lesson.les_lesson_order < ?
            AND (user_lesson_progress.ulp_completed IS NULL OR user_lesson_progress.ulp_completed = 0)
        ";

        $stmt = $conn->prepare($checkPreviousLessonsSql);
        $stmt->bind_param('iii', $userId, $courseId, $lessonOrder);
        $stmt->execute();
        $result = $stmt->get_result();
        $incompleteLessons = $result->fetch_assoc()['incomplete_lessons'];
        
        if ($incompleteLessons > 0) {
            $response['message'] = "There are incomplete previous lessons for this user and this course. Please complete all previous lessons before marking this one as complete.";
            $response['status'] = 'error';
            return;
        }

        $lesson = $result->fetch_assoc();
        $courseId = $lesson['les_course_id'];

        $checkSql = "SELECT * FROM user_lesson_progress WHERE ulp_user_id = ? AND ulp_lesson_id = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param('ii', $userId, $lessonId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response['message'] = "Lesson progress for this user and lesson already exists.";
            $response['status'] = 'error';
        } else {
            $insertSql = "INSERT INTO user_lesson_progress (ulp_user_id, ulp_lesson_id, ulp_completed, ulp_completion_date) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param('iiis', $userId, $lessonId, $completed, $completionDate);

            if ($stmt->execute()) {
                $checkAllLessonsSql = "
                    SELECT COUNT(*) AS total_lessons 
                    FROM lesson 
                    WHERE les_course_id = ?
                ";
                $stmt = $conn->prepare($checkAllLessonsSql);
                $stmt->bind_param('i', $courseId);
                $stmt->execute();
                $result = $stmt->get_result();
                $totalLessons = $result->fetch_assoc()['total_lessons'];

                $checkCompletedLessonsSql = "
                    SELECT COUNT(*) AS completed_lessons 
                    FROM user_lesson_progress 
                    WHERE ulp_user_id = ? AND ulp_completed = 1 AND ulp_lesson_id IN (
                        SELECT les_lesson_id 
                        FROM lesson 
                        WHERE les_course_id = ?
                    )
                ";
                $stmt = $conn->prepare($checkCompletedLessonsSql);
                $stmt->bind_param('ii', $userId, $courseId);
                $stmt->execute();
                $result = $stmt->get_result();
                $completedLessons = $result->fetch_assoc()['completed_lessons'];

                if ($totalLessons == $completedLessons) {
                    $updateCourseCompletionSql = "
                        UPDATE user_course 
                        SET ucr_completion_date = CURDATE() 
                        WHERE ucr_user_id = ? AND ucr_course_id = ?
                    ";
                    $stmt = $conn->prepare($updateCourseCompletionSql);
                    $stmt->bind_param('ii', $userId, $courseId);
                    $stmt->execute();

                    $response['message'] = "User lesson progress added successfully. All lessons completed. Course marked as completed.";
                } else {
                    $response['message'] = "User lesson progress added successfully.";
                }
                $response['status'] = 'success';
            } else {
                $response['message'] = "Error adding user lesson progress: " . $conn->error;
                $response['status'] = 'error';
            }
        }
    } else {
        $response['message'] = "Invalid request. Missing parameters.";
        $response['status'] = 'error';
    }
}

function updateUserLessonProgress($conn, &$response) {
    if (isset($_POST['userId'], $_POST['lessonId'], $_POST['completionDate'])) {
        $userId = $_POST['userId'];
        $lessonId = $_POST['lessonId'];
        $completionDate = $_POST['completionDate'];

        $lessonOrderSql = "SELECT les_lesson_order, les_course_id FROM lesson WHERE les_lesson_id = ?";
        $stmt = $conn->prepare($lessonOrderSql);
        $stmt->bind_param('i', $lessonId);
        $stmt->execute();
        $result = $stmt->get_result();

        $lessonDetails = $result->fetch_assoc();
        $lessonOrder = $lessonDetails['les_lesson_order'];
        $courseId = $lessonDetails['les_course_id'];

        $checkUserCourseSql = "SELECT ucr_start_date FROM user_course WHERE ucr_user_id = ? AND ucr_course_id = ?";
        $stmt = $conn->prepare($checkUserCourseSql);
        $stmt->bind_param('ii', $userId, $courseId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $response['message'] = "Cannot update lesson progress. The course to which this lesson belongs has not been started by the user. Please add course progress first, then you can update lesson progress.";
            $response['status'] = 'error';
            return;
        }

        $courseStartDate = $result->fetch_assoc()['ucr_start_date'];

        if ($completionDate < $courseStartDate) {
            $response['message'] = "Completion date cannot be earlier than the course start date.";
            $response['status'] = 'error';
            return;
        }

        $checkPreviousLessonCompletionDateSql = "
            SELECT ulp_completion_date
            FROM lesson
            LEFT JOIN user_lesson_progress ON lesson.les_lesson_id = user_lesson_progress.ulp_lesson_id 
            AND user_lesson_progress.ulp_user_id = ?
            WHERE lesson.les_course_id = ? 
            AND lesson.les_lesson_order < ?
            ORDER BY lesson.les_lesson_order DESC
            LIMIT 1
        ";
        $stmt = $conn->prepare($checkPreviousLessonCompletionDateSql);
        $stmt->bind_param('iii', $userId, $courseId, $lessonOrder);
        $stmt->execute();
        $result = $stmt->get_result();
        $previousLessonCompletionDate = $result->fetch_assoc()['ulp_completion_date'];

        if ($previousLessonCompletionDate && $completionDate < $previousLessonCompletionDate) {
            $response['message'] = "Completion date cannot be earlier than the previous lesson's completion date.";
            $response['status'] = 'error';
            return;
        }

        $insertSql = "UPDATE user_lesson_progress SET ulp_completed = 1, ulp_completion_date = ? WHERE ulp_user_id = ? AND ulp_lesson_id = ?";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param('sii', $completionDate, $userId, $lessonId);

        if ($stmt->execute()) {
            $response['message'] = "User lesson progress updated successfully.";
            $response['status'] = 'success';
        } else {
            $response['message'] = "Error updating user lesson progress: " . $conn->error;
            $response['status'] = 'error';
        }
    } else {
        $response['message'] = "Invalid request. Missing parameters.";
        $response['status'] = 'error';
    }
}

function getUserLessonProgress($conn, &$response) {
    if (isset($_POST['userId'],$_POST['lessonId'])) {
        $userId = $_POST['userId'];
        $lessonId = $_POST['lessonId'];

        $stmt = $conn->prepare("SELECT ulp_user_id, ulp_lesson_id, ulp_completed, ulp_completion_date FROM user_lesson_progress WHERE ulp_user_id = ? AND ulp_lesson_id = ?");
        $stmt->bind_param("ii", $userId, $lessonId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $response = $result->fetch_assoc();
        } else {
            $response['message'] = 'No lesson progress found for the user.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Missing userId or lessonId parameter';
    }
}

function deleteUserLessonProgress($conn, &$response) {
    if (isset($_POST['userId'], $_POST['lessonId'])) {
        $userId = $_POST['userId'];
        $lessonId = $_POST['lessonId'];

        $courseIdSql = "SELECT les_course_id FROM lesson WHERE les_lesson_id = $lessonId";
        $courseIdResult = mysqli_query($conn, $courseIdSql);

        if ($courseIdResult && mysqli_num_rows($courseIdResult) > 0) {
            $row = mysqli_fetch_assoc($courseIdResult);
            $courseId = $row['les_course_id'];

            $courseCompletionSql = "SELECT * FROM user_course WHERE ucr_user_id = $userId AND ucr_course_id = $courseId AND ucr_completion_date IS NOT NULL";
            $courseCompletionResult = mysqli_query($conn, $courseCompletionSql);

            if ($courseCompletionResult && mysqli_num_rows($courseCompletionResult) > 0) {
                $response['message'] = "Cannot delete lesson progress: User has completed the course associated with this lesson. Please mark the course as incomplete first.";
            } else {
                $deleteSql = "DELETE FROM user_lesson_progress WHERE ulp_user_id = $userId AND ulp_lesson_id = $lessonId";
                if (mysqli_query($conn, $deleteSql)) {
                    $response['message'] = "Progress of user ID " . $userId . " in lesson ID " . $lessonId . " deleted successfully";
                    $response['status'] = 'success';
                } else {
                    $response['message'] = "Error deleting progress of user ID " . $userId . " in lesson ID " . $lessonId . ": " . mysqli_error($conn);
                }
            }
        } else {
            $response['message'] = "Lesson not found";
        }
    } else {
        $response['message'] = "Invalid request";
    }
}

function checkUserExists($conn, $userId) {
    $sql = "SELECT usr_user_id FROM user WHERE usr_user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function checkCourseExists($conn, $courseId) {
    $sql = "SELECT crs_course_id, crs_status FROM course WHERE crs_course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function checkLessonExists($conn, $lessonId) {
    $sql = "SELECT les_lesson_id, les_course_id, les_lesson_order FROM lesson WHERE les_lesson_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $lessonId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function checkUserCourseExists($conn, $userId, $courseId) {
    $sql = "SELECT * FROM user_course WHERE ucr_user_id = ? AND ucr_course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $userId, $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>
