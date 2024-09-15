<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>LearnProg - Lesson Admin</title>
        <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include "../include/dashboard-navbar.php" ;
    include '../data-repositories/lesson-functions.php';
    $task_types = getTaskTypes();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Lesson Admin</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Admin Tools</li>
                <li class="breadcrumb-item active">Lesson Admin</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                On this page you can manage lessons on your learning platform. 
                You can add, delete and edit lessons, lesson files and tasks.
                </div>
            </div>
            <?php include "../content/la-tables.php"; ?>
        </div>
    </main>
    <?php include "../include/footer.php"; ?>
</div>
<?php include "../content/la-modals.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="../js/scripts.js"></script>
<script>
window.addEventListener("DOMContentLoaded", (event) => {
    const tableLessons = document.getElementById("tableLessons");
    if (tableLessons) {
        new simpleDatatables.DataTable(tableLessons);
    }
    const tableLessonFiles = document.getElementById("tableLessonFiles");
    if (tableLessonFiles) {
        new simpleDatatables.DataTable(tableLessonFiles);
    }
    const tableTasks = document.getElementById("tableTasks");
    if (tableTasks) {
        new simpleDatatables.DataTable(tableTasks);
    }
});

$(document).ready(function () {
    $("#btnAddLesson").click(function () {
        $("#contentContainer").empty();
        $("#addLessonModal").modal("show");
    });

    $("#addLessonForm").submit(function (e) {
        e.preventDefault();

        var formData = {
            action: 'addLesson',
            courseId: $("#courseId").val(),
            title: $("#title").val(),
            order: $("#order").val(),
            points: $("#points").val()
        };

        var dynamicInputs = $("#contentContainer textarea");
        var content = "";
        dynamicInputs.each(function (index) {
            var inputName = $(this).attr("name");
            var inputValue = $(this).val();

            if (inputName.startsWith("paragraph")) {
                content += "<p>" + inputValue + "</p>";
            } else if (inputName.startsWith("header4")) {
                content += "<h4>" + inputValue + "</h4>";
            } else if (inputName.startsWith("header3")) {
                content += "<h3>" + inputValue + "</h3>";
            } else if (inputName.startsWith("warning")) {
                content += '<p class="warning">' + inputValue + "</p>";
            } else if (inputName.startsWith("orderedlist")) {
                var items = inputValue.split(";");
                content += "<ol>";
                items.forEach(function (item) {
                    content += "<li>" + item + "</li>";
                });
                content += "</ol>";
            } else if (inputName.startsWith("unorderedlist")) {
                var items = inputValue.split(";");
                content += "<ul>";
                items.forEach(function (item) {
                    content += "<li>" + item + "</li>";
                });
                content += "</ul>";
            } else {
                content += "<p><img lsf_file_name='" + inputValue + "' /></p>";
            }
        });

        formData.content = content;

        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: formData,
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Lesson added successfully");
                    $("#addLessonModal").modal("hide");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while adding lesson: " + data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while adding lesson");
                console.error(error);
            }
        });
    });

    $("#editLessonForm").submit(function (event) {
        event.preventDefault();

        var lessonId = $("#editLessonId").val();
        var courseId = $("#editLessonCourseId").val();
        var title = $("#editTitle").val();
        var order = $("#editOrder").val();
        var points = $("#editPoints").val();
        var content = $("#editContent").val();

        var lessonData = {
            action: 'editLesson',
            lessonId: lessonId,
            courseId: courseId,
            title: title,
            order: order,
            points: points,
            content: content
        };

        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: lessonData,
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Lesson data was updated successfully");
                    $("#editLessonModal").modal("hide");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while updating lesson data: " +
                            data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while updating lesson data");
                console.error(error);
            }
        });
    });

    $("#btnAddLessonFile").click(function () {
        $("#addLessonFileModal").modal("show");
    });

    $("#addLessonFileForm").submit(function (e) {
        e.preventDefault();
        var formData = {
            action: 'addLessonFile',
            lessonId: $("#lessonId").val(),
            fileName: $("#fileName").val(),
            altText: $("#altText").val(),
            filePath: $("#filePath").val()
        };
        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: formData,
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Lesson file added successfully");
                    $("#addLessonFileModal").modal("hide");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while adding lesson file: " + data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while adding lesson file");
                console.error(error);
            }
        });
    });

    $("#editLessonFileForm").submit(function (event) {
        event.preventDefault();

        var fileId = $("#editLessonFileId").val();
        var lessonId = $("#editFileLessonId").val();
        var fileName = $("#editFileName").val();
        var altText = $("#editAltText").val();
        var filePath = $("#editFilePath").val();

        var lessonFileData = {
            action: 'editLessonFile',
            fileId: fileId,
            lessonId: lessonId,
            fileName: fileName,
            altText: altText,
            filePath: filePath
        };

        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: lessonFileData,
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Lesson file data was updated successfully");
                    $("#editLessonFileModal").modal("hide");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while updating lesson file data: " +
                            data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while updating lesson file data");
                console.error(error);
            }
        });
    }); 
    
    $("#btnAddTask").click(function () {
        $("#addTaskModal").modal("show");
    });

    $("#addTaskForm").submit(function (e) {
        e.preventDefault();
        var formData = {
            action: 'addTask',
            lessonId: $("#taskLessonId").val(),
            taskType: $("#taskType").val(),
            taskDescription: $("#taskDescription").val(),
            taskOptions: $("#taskOptions").val(),
            taskSolution: $("#taskSolution").val()
        };
        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: formData,
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Task added successfully");
                    $("#addTaskModal").modal("hide");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while adding task: " + data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while adding task");
                console.error(error);
            }
        });
    });

    $("#editTaskForm").submit(function (event) {
        event.preventDefault();

        var taskId = $("#editTaskId").val();
        var lessonId = $("#editTaskLessonId").val();
        var taskType = $("#editTaskType").val();
        var taskDescription = $("#editTaskDescription").val();
        var taskOptions = $("#editTaskOptions").val();
        var taskSolution = $("#editTaskSolution").val();

        var taskData = {
            action: 'editTask',
            taskId: taskId,
            lessonId: lessonId,
            taskType: taskType,
            taskDescription: taskDescription,
            taskOptions: taskOptions,
            taskSolution: taskSolution
        };

        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: taskData,
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Task was updated successfully");
                    $("#editTaskModal").modal("hide");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while updating task: " +
                            data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while updating task");
                console.error(error);
            }
        });
    }); 
});

function editLesson(lessonId) {
    $.ajax({
        url: "../actions/lesson-admin-actions.php",
        method: "POST",
        data: { action: 'getLesson',lessonId: lessonId },
        success: function (response) {
            var lesson = JSON.parse(response);

            $("#editLessonId").val(lesson.les_lesson_id);
            $("#editLessonCourseId").val(lesson.les_course_id);
            $("#editTitle").val(lesson.les_lesson_title);
            $("#editOrder").val(lesson.les_lesson_order);
            $("#editPoints").val(lesson.les_points);
            $("#editContent").val(lesson.les_lesson_content);

            $("#editLessonModal").modal("show");
        },
        error: function (xhr, status, error) {
            alert("An error occurred while fetching lesson data");
            console.error(error);
        }
    });
}

function deleteLesson(lessonId) {
    if (confirm("Are you sure you want to delete this lesson?")) {
        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: { action: 'deleteLesson',lessonId: lessonId },
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Lesson deleted successfully");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while deleting lesson: " +
                            data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while deleting lesson");
                console.error(error);
            }
        });
    }
}

function editLessonFile(fileId) {
    $.ajax({
        url: "../actions/lesson-admin-actions.php",
        method: "POST",
        data: { action: 'getLessonFile',fileId: fileId },
        success: function (response) {
            var lessonFile = JSON.parse(response);

            $("#editLessonFileId").val(lessonFile.lsf_lessons_file_id);
            $("#editFileLessonId").val(lessonFile.lsf_lesson_id);
            $("#editFileName").val(lessonFile.lsf_file_name);
            $("#editAltText").val(lessonFile.lsf_alt_text);
            $("#editFilePath").val(lessonFile.lsf_file_path);

            $("#editLessonFileModal").modal("show");
        },
        error: function (xhr, status, error) {
            alert("An error occurred while fetching lesson file data");
            console.error(error);
        }
    });
}

function deleteLessonFile(fileId) {
    if (confirm("Are you sure you want to delete this lesson file?")) {
        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: { action: 'deleteLessonFile',fileId: fileId },
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Lesson file deleted successfully");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while deleting lesson file: " +
                            data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while deleting lesson file");
                console.error(error);
            }
        });
    }
}

function editTask(taskId) {
    $.ajax({
        url: "../actions/lesson-admin-actions.php",
        method: "POST",
        data: { action: 'getTask',taskId: taskId },
        success: function (response) {
            var task = JSON.parse(response);

            $("#editTaskId").val(task.tsk_task_id);
            $("#editTaskLessonId").val(task.tsk_lesson_id);
            $("#editTaskType").val(task.tsk_task_type_id).change();
            $("#editTaskDescription").val(task.tsk_task_description);
            $("#editTaskOptions").val(task.tsk_task_options);
            $("#editTaskSolution").val(task.tsk_task_solution);

            $("#editTaskModal").modal("show");
        },
        error: function (xhr, status, error) {
            alert("An error occurred while fetching task data");
            console.error(error);
        }
    });
}

function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        $.ajax({
            url: "../actions/lesson-admin-actions.php",
            method: "POST",
            data: { action: 'deleteTask',taskId: taskId },
            success: function (response) {
                var data = JSON.parse(response);

                if (data.status === "success") {
                    alert("Task deleted successfully");
                    location.reload();
                } else if (data.status === "error") {
                    alert(
                        "An error occurred while deleting task: " +
                            data.message
                    );
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while deleting task");
                console.error(error);
            }
        });
    }
}

var counter = 1;

function addInput() {
    var contentType = document.getElementById("content").value;
    var inputName = contentType + "-" + counter;

    var div = document.createElement("div");
    div.className = "mb-3 d-flex align-items-start";

    var icon;
    var iconClass;
    var newInput;
    var deleteButton;

    newInput = document.createElement("textarea");
    newInput.className = "form-control";
    newInput.setAttribute("rows", "3");

    if (contentType === "paragraph") {
        iconClass = "fas fa-paragraph";
        newInput.placeholder = "Enter paragraph content...";
    } else if (contentType === "header4") {
        iconClass = "fas fa-heading";
        newInput.style.fontSize = "1.2rem";
        newInput.style.fontWeight = "bold";
        newInput.placeholder = "Enter header level 4 content...";
    } else if (contentType === "header3") {
        iconClass = "fas fa-heading";
        newInput.style.fontSize = "1.5rem";
        newInput.style.fontWeight = "bold";
        newInput.placeholder = "Enter header level 3 content...";
    } else if (contentType === "warning") {
        newInput.style.backgroundColor = "rgba(255, 0, 0, 0.2)";
        iconClass = "fas fa-exclamation-triangle";
        newInput.placeholder = "Enter warning content...";
    } else if (
        contentType === "orderedlist" ||
        contentType === "unorderedlist"
    ) {
        iconClass =
            contentType === "orderedlist" ? "fas fa-list-ol" : "fas fa-list-ul";
        newInput.placeholder =
            "Enter list items separated by semicolons (;)...";
    } else {
        iconClass = "fas fa-image";
        newInput = document.createElement("input");
        newInput.className = "form-control";
        newInput.setAttribute("type", "text");
        newInput.placeholder =
            "Enter the lesson file name without extension...";
    }
    icon = document.createElement("i");
    icon.className = iconClass;

    var iconDiv = document.createElement("div");
    iconDiv.className = "d-flex align-items-center me-2 mt-2";
    iconDiv.appendChild(icon);

    newInput.setAttribute("name", inputName);

    deleteButton = document.createElement("button");
    deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
    deleteButton.className = "btn btn-danger ms-2 mt-2";
    deleteButton.onclick = function () {
        div.parentNode.removeChild(div);
    };

    div.appendChild(iconDiv);
    div.appendChild(newInput);
    div.appendChild(deleteButton);

    document.getElementById("contentContainer").appendChild(div);

    counter++;
}

document.getElementById('taskType').addEventListener('change', function() {
    var selectedTypeId = this.value;
    var optionsContainer = document.getElementById('optionsContainer'); 
    var taskOptionsInput = document.getElementById('taskOptions');

    if (selectedTypeId == 2 || selectedTypeId == 7) {
        optionsContainer.style.display = "none";
        taskOptionsInput.value = ""; 
    } else {
        optionsContainer.style.display = "block";
    }
});
</script>    
</body>
</html>