<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>LearnProg - Course Admin</title>
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
    include '../data-repositories/course-functions.php';
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Course Admin</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Admin Tools</li>
                <li class="breadcrumb-item active">Course Admin</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    On this page, you can manage courses, course topics, and the lessons assigned to these courses on your learning platform. 
                    You can add, edit and delete courses and topics, change the order of lessons and the affiliation of lessons to courses.
                </div>
            </div>
            <?php include "../content/ca-tables.php"; ?>
        </div>
    </main>
    <?php include "../include/footer.php"; ?>
</div>
<?php include "../content/ca-modals.php"; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="../js/drag-drop-lessons.js"></script>
<script src="../js/scripts.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const tableCourses = document.getElementById('tableCourses');
        if (tableCourses) {
            new simpleDatatables.DataTable(tableCourses);
        }const tableCourseTopics = document.getElementById('tableCourseTopics');
        if (tableCourseTopics) {
            new simpleDatatables.DataTable(tableCourseTopics);
        }
    });

    $(document).ready(function() {
        $('#btnAddCourse').click(function() {
            $('#addCourseModal').modal('show');
        });
        $('#addCourseForm').submit(function(e) {
            e.preventDefault();
            var formData = {
                action: 'addCourse',
                courseName: $('#courseName').val(),
                fullDescription: $('#fullDescription').val(),
                shortDescription: $('#shortDescription').val(),
                level: $('#level').val(),
                status: $('#status').val(),
                imagePath: $('#imagePath').val()
            };
            $.ajax({
                url: '../actions/course-admin-actions.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('Course added successfully');
                        $('#addCourseModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while adding course: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while adding course');
                    console.error(error);
                }
            });
        });

        $('#editCourseForm').submit(function(event) {
            event.preventDefault();
            var courseId = $('#editCourseId').val();
            var courseName = $('#editCourseName').val();
            var shortDescription = $('#editShortDescription').val();
            var fullDescription = $('#editFullDescription').val();
            var level = $('#editLevel').val();
            var status = $('#editStatus').val();
            var imagePath = $('#editImagePath').val();
        
            var courseData = {
                action: 'updateCourse',
                courseId: courseId,
                courseName: courseName,
                shortDescription: shortDescription,
                fullDescription: fullDescription,
                level: level,
                status: status,
                imagePath: imagePath
            };
            $.ajax({
                url: '../actions/course-admin-actions.php',
                method: 'POST',
                data: courseData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('Course data was updated successfully');
                        $('#editCourseModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while updating course data: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating course data');
                    console.error(error);
                }
            });
        });

        $('#btnAddCourseTopic').click(function() {
            $('#addCourseTopicModal').modal('show');
        });
        $('#addCourseTopicForm').submit(function(e) {
            e.preventDefault();
            var formData = {
                action: 'addTopic',
                courseId: $('#courseTopicId').val(),
                topicName: $('#topicName').val()
            };
            $.ajax({
                url: '../actions/course-admin-actions.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('Course topic added successfully');
                        $('#addCourseTopicModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while adding course topic: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while adding course topic');
                    console.error(error);
                }
            });
        });

        $('#editCourseTopicForm').submit(function(event) {
            event.preventDefault();
            var topicId = $('#editTopicId').val();
            var courseId = $('#editCourseTopicId').val();
            var topicName = $('#editTopicName').val();
        
            var topicData = {
                action: 'updateTopic',
                topicId: topicId,
                courseId: courseId,
                topicName: topicName
            };
            $.ajax({
                url: '../actions/course-admin-actions.php',
                method: 'POST',
                data: topicData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('Course topic data was updated successfully');
                        $('#editCourseTopicModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while updating course topic data: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating course topic data');
                    console.error(error);
                }
            });
        });
    });

    function editCourse(courseId) {
        $.ajax({
            url: '../actions/course-admin-actions.php',
            method: 'POST',
            data: { action: 'getCourse',courseId: courseId },
            success: function(response) {
                var course = JSON.parse(response);

                $('#editCourseId').val(course.crs_course_id);
                $('#editCourseName').val(course.crs_course_name);
                $('#editShortDescription').val(course.crs_short_description);
                $('#editFullDescription').val(course.crs_full_description);
                $('#editLevel').val(course.crs_level);
                $('#editStatus').val(course.crs_status);
                $('#editImagePath').val(course.crs_image_path);
                $('#editCourseModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('An error occurred while fetching course data');
                console.error(error);
            }
        });
    }

    function deleteCourse(courseId) {
        if (confirm('Are you sure you want to delete this course?')) {
            $.ajax({
                url: '../actions/course-admin-actions.php',
                method: 'POST',
                data: { action: 'deleteCourse',courseId: courseId },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                    alert('Course deleted successfully');
                    location.reload(); 
                    } else if (data.status === 'error') {
                        alert('An error occurred while deleting course: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while deleting course');
                    console.error(error);
                }
            });
        }
    }

    function editCourseTopic(topicId) {
        $.ajax({
            url: '../actions/course-admin-actions.php',
            method: 'POST',
            data: { action: 'getTopic',topicId: topicId },
            success: function(response) {
                var topic = JSON.parse(response);

                $('#editTopicId').val(topic.top_topic_id);
                $('#editCourseTopicId').val(topic.top_course_id);
                $('#editTopicName').val(topic.top_topic_name);
                $('#editCourseTopicModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('An error occurred while fetching course topic data');
                console.error(error);
            }
        });
    }

    function deleteCourseTopic(topicId) {
        if (confirm('Are you sure you want to delete this course topic?')) {
            $.ajax({
                url: '../actions/course-admin-actions.php',
                method: 'POST',
                data: { action: 'deleteTopic',topicId: topicId },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                    alert('Course topic deleted successfully');
                    location.reload(); 
                    } else if (data.status === 'error') {
                        alert('An error occurred while deleting course topic: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while deleting course topic');
                    console.error(error);
                }
            });
        }
    }
</script>    
</body>
</html>