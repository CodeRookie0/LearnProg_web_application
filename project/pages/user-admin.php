<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>LearnProg - User Admin</title>
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
    include "../data-repositories/user-progress-functions.php" ;
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User Admin</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Admin Tools</li>
                <li class="breadcrumb-item active">User Admin</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    On this page you can manage users on your educational platform. 
                    You can add, edit and delete users.
                </div>
            </div>
            <?php include "../content/ua-tables.php"; ?>
        </div>
    </main>
    <?php include "../include/footer.php"; ?>
</div>
<?php include "../content/ua-modals.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="../js/scripts.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const tableUsers = document.getElementById('tableUsers');
        if (tableUsers) {
            new simpleDatatables.DataTable(tableUsers);
        }
        const tableUserCourseProgress = document.getElementById('tableUserCourseProgress');
        if (tableUserCourseProgress) {
            new simpleDatatables.DataTable(tableUserCourseProgress);
        }
        const tableUserLessonProgress = document.getElementById('tableUserLessonProgress');
        if (tableUserLessonProgress) {
            new simpleDatatables.DataTable(tableUserLessonProgress);
        }
    });
    $(document).ready(function() {
        $('#btnAddUser').click(function() {
            $('#addUserModal').modal('show');
        });

        $('#addUserForm').submit(function(e) {
            e.preventDefault();

            var formData = {
                action: 'addUser',
                username: $('#username').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                userType: $('#userType').val()
            };

            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('User added successfully');
                        $('#addUserModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while adding user: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while adding user');
                    console.error(error);
                }
            });
        });

        $('#editUserForm').submit(function(event) {
            event.preventDefault();

            var userId = $('#editUserId').val();
            var username = $('#editUsername').val();
            var email = $('#editUserEmail').val();
            var userType = $('#editUserType').val();
            var registrationDate = $('#editUserRegistrationDate').val();
            var password = $('#editPassword').val();
            var passwordConfirm = $('#editPasswordConfirm').val();

            var userData = {
                action: 'updateUser',
                userId: userId,
                username: username,
                email: email,
                userType: userType,
                registrationDate: registrationDate
            };
            if(password !== ''|| passwordConfirm !== ''){
                userData.password=password;
                userData.passwordConfirm=passwordConfirm;
            }

            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: userData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('User data was updated successfully');
                        $('#editUserModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while updating user data: ' + data.message);
                    }

                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating user data');
                    console.error(error);
                }
            });
        });


        $('#btnAddUserCourseProgress').click(function() {
            $('#addUserCourseProgressModal').modal('show');
        });

        $('#addUserCourseProgressForm').submit(function(e) {
            e.preventDefault();

            var formData = {
                action: 'addUserCourseProgress',
                userId: $('#userCourseUserId').val(),
                courseId: $('#userCourseCourseId').val(),
                startDate: $('#userCourseStartDate').val(),
                completionDate: $('#userCourseCompletionDate').val()
            };

            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('User course progress added successfully');
                        $('#addUserCourseProgressModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while adding user course progress: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while adding user course progress');
                    console.error(error);
                }
            });
        });

        $('#editUserCourseProgressForm').submit(function(event) {
            event.preventDefault();

            var userId = $('#editUserCourseUserId').val();
            var courseId = $('#editUserCourseCourseId').val();
            var startDate = $('#editUserCourseStartDate').val();
            var completionDate = $('#editUserCourseCompletionDate').val();

            var courseProgressData = {
                action: 'updateUserCourseProgress',
                userId: userId,
                courseId: courseId,
                startDate: startDate,
                completionDate: completionDate
            };

            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: courseProgressData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('User course progress was updated successfully');
                        $('#editUserCourseProgressModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while updating user course progress: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating user course progress');
                    console.error(error);
                }
            });
        });

        $('#btnAddUserLessonProgress').click(function() {
            $('#addUserLessonProgressModal').modal('show');
        });

        $('#addUserLessonProgressForm').submit(function(e) {
            e.preventDefault();

            var formData = {
                action: 'addUserLessonProgress',
                userId: $('#userLessonUserId').val(),
                lessonId: $('#userLessonLessonId').val(),
                completionDate: $('#userLessonCompletionDate').val()
            };

            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);
                    
                    if (data.status === 'success') {
                        alert('User lesson progress added successfully');
                        $('#addUserLessonProgressModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while adding user lesson progress: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while adding user lesson progress');
                    console.error(error);
                }
            });
        });

        $('#editUserLessonProgressForm').submit(function(event) {
            event.preventDefault();

            var userId = $('#editUserLessonUserId').val();
            var lessonId = $('#editUserLessonLessonId').val();
            var completionDate = $('#editUserLessonCompletionDate').val();

            var lessonProgressData = {
                action: 'updateUserLessonProgress',
                userId: userId,
                lessonId: lessonId,
                completionDate: completionDate
            };

            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: lessonProgressData,
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('User lesson progress was updated successfully');
                        $('#editUserLessonProgressModal').modal('hide');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while updating user lesson progress: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating user lesson progress');
                    console.error(error);
                }
            });
        });
    });

    function editUser(userId) {
        $.ajax({
            url: '../actions/user-admin-actions.php',
            method: 'POST',
            data: { action: 'getUser',userId: userId },
            success: function(response) {
                var user = JSON.parse(response);

                $('#editUserId').val(user.usr_user_id);
                $('#editUsername').val(user.usr_username);
                $('#editUserEmail').val(user.usr_email);
                $('#editUserType').val(user.usr_user_type_id);

                var registrationDate = new Date(user.usr_registration_date);
                var formattedDate = registrationDate.getFullYear() + '-' + 
                        ('0' + (registrationDate.getMonth() + 1)).slice(-2) + '-' + 
                        ('0' + registrationDate.getDate()).slice(-2);
            
                $('#editUserRegistrationDate').val(formattedDate);

                $('#editUserModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('An error occurred while fetching user data');
                console.error(error);
            }
        });
    }

    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user '+userId+'?')) {
            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: { action: 'deleteUser',userId: userId },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('User deleted successfully');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while deleting user: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while deleting user');
                    console.error(error);
                }
            });
        }
    }

    function editUserCourseProgress(userId,courseId) {
        $.ajax({
            url: '../actions/user-admin-actions.php',
            method: 'POST',
            data: { action: 'getUserCourseProgress',userId: userId, courseId: courseId },
            success: function(response) {
                var courseProgress = JSON.parse(response);
                console.log(courseProgress);

                $('#editUserCourseUserId').val(courseProgress.ucr_user_id);
                $('#editUserCourseCourseId').val(courseProgress.ucr_course_id);

                var startDate = new Date(courseProgress.ucr_start_date);
                var formattedStartDate = startDate.getFullYear() + '-' +
                    ('0' + (startDate.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + startDate.getDate()).slice(-2);

                $('#editUserCourseStartDate').val(formattedStartDate);

                if (courseProgress.ucr_completion_date !== null) {
                    var completionDate = new Date(courseProgress.ucr_completion_date);
                    var formattedCompletionDate = completionDate.getFullYear() + '-' +
                        ('0' + (completionDate.getMonth() + 1)).slice(-2) + '-' +
                        ('0' + completionDate.getDate()).slice(-2);

                    $('#editUserCourseCompletionDate').val(formattedCompletionDate);
                }

                $('#editUserCourseProgressModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('An error occurred while fetching user course progress data');
                console.error(error);
            }
        });
    }

    function deleteUserCourseProgress(userId,courseId) {
        if (confirm('Are you sure you want to delete the progress of user ID '+userId+' in course ID '+courseId+'?')) {
            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: { action: 'deleteUserCourseProgress',userId: userId, courseId: courseId },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('User course progress deleted successfully');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while deleting user course progress: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while deleting user course progress');
                    console.error(error);
                }
            });
        }
    }

    function editUserLessonProgress(userId, lessonId) {
        $.ajax({
            url: '../actions/user-admin-actions.php',
            method: 'POST',
            data: { action: 'getUserLessonProgress', userId: userId, lessonId: lessonId },
            success: function(response) {
                var lessonProgress = JSON.parse(response);

                $('#editUserLessonUserId').val(lessonProgress.ulp_user_id);
                $('#editUserLessonLessonId').val(lessonProgress.ulp_lesson_id);

                var completionDate = new Date(lessonProgress.ulp_completion_date);
                var formattedDate = completionDate.getFullYear() + '-' +
                    ('0' + (completionDate.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + completionDate.getDate()).slice(-2);

                $('#editUserLessonCompletionDate').val(formattedDate);

                $('#editUserLessonProgressModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('An error occurred while fetching user lesson progress data');
                console.error(error);
            }
        });
    }

    function deleteUserLessonProgress(userId,lessonId) {
        if (confirm('Are you sure you want to delete the progress of user ID '+userId+' in lesson ID '+lessonId+'?')) {
            $.ajax({
                url: '../actions/user-admin-actions.php',
                method: 'POST',
                data: { action: 'deleteUserLessonProgress',userId: userId, lessonId: lessonId },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.status === 'success') {
                        alert('User lesson progress deleted successfully');
                        location.reload();
                    } else if (data.status === 'error') {
                        alert('An error occurred while deleting user lesson progress: ' + data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while deleting user lesson progress');
                    console.error(error);
                }
            });
        }
    }
</script>    
</body>
</html>