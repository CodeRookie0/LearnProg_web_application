<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'database.php';

function getLessons() {
    $conn = connectDB();
    
    $sql = "SELECT `les_lesson_id`, `les_course_id`, `les_lesson_title`, `les_lesson_content`, `les_lesson_order`, `les_lesson_order`, `les_points` FROM `lesson` WHERE 1";
    $result = $conn->query($sql);
    
    $lessons = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
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
    
    $conn->close();
    
    return $lessons;
}

function getLessonContent($lesson_id) {
    $conn = connectDB();

    $sql = "SELECT les_lesson_title, les_lesson_content FROM lesson WHERE les_lesson_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lesson_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $lesson_content = array();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lesson_content = array(
            'title' => $row['les_lesson_title'],
            'content' => $row['les_lesson_content']
        );
    }

    $stmt->close();
    $conn->close();

    return $lesson_content;
}

function getAllLessonFiles() {
    $conn = connectDB();

    $sql = "SELECT * FROM lesson_file";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $lesson_files = array();
    while ($row = $result->fetch_assoc()) {
        $lesson_file = array(
            'id' => $row['lsf_lessons_file_id'],
            'lesson_id' => $row['lsf_lesson_id'],
            'name' => $row['lsf_file_name'],
            'alt_text' => $row['lsf_alt_text'],
            'path' => $row['lsf_file_path']
        );
        $lesson_files[]=$lesson_file;
    }

    $stmt->close();
    $conn->close();

    return $lesson_files;
}

function getLessonFiles($lesson_id) {
    $conn = connectDB();

    $sql = "SELECT lsf_file_path, lsf_alt_text, lsf_file_name FROM lesson_file WHERE lsf_lesson_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lesson_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $lesson_files = array();
    while ($row = $result->fetch_assoc()) {
        $lesson_files[$row['lsf_file_name']] = array(
            'path' => $row['lsf_file_path'],
            'alt_text' => $row['lsf_alt_text']
        );
    }

    $stmt->close();
    $conn->close();

    return $lesson_files;
}

function getAllLessonTasks() {
    $conn = connectDB();

    $sql = "SELECT tsk.*, tt.tt_task_type_name
            FROM task tsk
            LEFT JOIN task_type tt ON tsk.tsk_task_type_id = tt.tt_task_type_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $tasks = array();
    while ($row = $result->fetch_assoc()) {
        $tasks[] = array(
            'id' => $row['tsk_task_id'],
            'lesson_id' => $row['tsk_lesson_id'],
            'type' => $row['tsk_task_type_id'],
            'type_name' => $row['tt_task_type_name'],
            'description' => $row['tsk_task_description'],
            'solution' => $row['tsk_task_solution'],
            'options' => $row['tsk_task_options']
        );
    }

    $stmt->close();
    $conn->close();

    return $tasks;
}

function getTaskTypes() {
    $conn = connectDB();

    $sql = "SELECT `tt_task_type_id`, `tt_task_type_name` FROM `task_type`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $task_types = array();
    while ($row = $result->fetch_assoc()) {
        $task_types[] = array(
            'id' => $row['tt_task_type_id'],
            'name' => $row['tt_task_type_name']
        );
    }

    $stmt->close();
    $conn->close();

    return $task_types;
}

function getLessonTasks($lesson_id) {
    $conn = connectDB();

    $sql = "SELECT tsk_task_id, tsk_task_type_id, tsk_task_description, tsk_task_solution , tsk_task_options FROM task WHERE tsk_lesson_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lesson_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $tasks = array();
    while ($row = $result->fetch_assoc()) {
        $tasks[] = array(
            'id' => $row['tsk_task_id'],
            'type' => $row['tsk_task_type_id'],
            'description' => $row['tsk_task_description'],
            'solution' => $row['tsk_task_solution'],
            'options' => $row['tsk_task_options']
        );
    }

    $stmt->close();
    $conn->close();

    return $tasks;
}

function getLessonPoints($lesson_id) {
    $conn = connectDB();
    
    $sql_points = "SELECT les_points FROM lesson WHERE les_lesson_id = ?";
    $stmt_points = $conn->prepare($sql_points);
    $stmt_points->bind_param("i", $lesson_id);
    $stmt_points->execute();
    $result_points = $stmt_points->get_result();

    if ($result_points->num_rows > 0) {
        $row_points = $result_points->fetch_assoc();
        $points = $row_points['les_points'];
    } else {
        $points = 0;
    }

    $stmt_points->close();
    $conn->close();

    return $points;
}

function processLessonContent($lesson_id) {
    $lesson_content = getLessonContent($lesson_id);
    $lesson_files = getLessonFiles($lesson_id);
    $content = $lesson_content['content'];

    if (!empty($content)) {
        $warning_tag = "<p class=\"warning\">";
        $replace_warning_tag = "<p class='alert alert-warning' role='alert'>";
        $content = str_replace($warning_tag, $replace_warning_tag, $content);

        if (!empty($lesson_files)) {
            foreach ($lesson_files as $file_name => $file_info) {
                $img_tag = "<p><img lsf_file_name='$file_name' /></p>";
                $replace_img_tag = "<div class='mt-3 mb-3 border p-0 d-inline-block'><img src='{$file_info['path']}' alt='{$file_info['alt_text']}' class='img-fluid' /></div>";
                $content = str_replace($img_tag, $replace_img_tag, $content);
            }
        }

        $lesson_content['content'] = $content;

        return $lesson_content;
    } else {
        return "Nie można pobrać treści lekcji lub plików.";
    }
}


?>