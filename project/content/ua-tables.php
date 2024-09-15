<div class="card mb-4">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Users
        <button class="btn btn-primary btn-sm float-end ps-4 pe-4" id="btnAddUser">Add</button>
    </div>
    <div class="card-body">
        <table id="tableUsers">
            <thead>
                <tr>
					<th>Id</th>
					<th>Username</th>
					<th>Email</th>
					<th>Type</th>
					<th>Completed lessons</th>
					<th>Registration</th>
					<th>Last Login</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $users_data = getUsersData();
					foreach ($users_data as $user_data) {
						echo '<tr>';
						echo '<td>'.$user_data['id'].'</td>';
						echo '<td>'.$user_data['username'].'</td>';
						echo '<td>'.$user_data['email'].'</td>';
						echo '<td>'.$user_data['type_name'].'</td>';
						echo '<td>'.$user_data['completed_lessons'].'</td>';
						echo '<td>'.$user_data['registration_date'].'</td>';
						echo '<td>'.$user_data['last_login_date'].'</td>';
                        echo '<td>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser('.$user_data['id'].')">Delete</button>
                                    <button class="btn btn-warning btn-sm" onclick="editUser('.$user_data['id'].')">Edit</button>
                                </div>
                              </td>';
						echo '</tr>';
					}
				?>
            </tbody>
        </table>
    </div>
</div>


<div class="card mb-4">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        User Course Progress
        <button class="btn btn-primary btn-sm float-end ps-4 pe-4" id="btnAddUserCourseProgress">Add</button>
    </div>
    <div class="card-body">
        <table id="tableUserCourseProgress">
            <thead>
                <tr>
                    <th>User Id</th>
					<th>Course Id</th>
					<th>Start date</th>
					<th>Completion date</th>
					<th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $courses_progress = getUsersCoursePogress();
                    foreach ($courses_progress as $course_progress) {
                        echo '<tr>';
                        echo '<td>'.$course_progress['user_id'].'</td>';
                        echo '<td>'.$course_progress['course_id'].'</td>';
                        echo '<td>'.$course_progress['start_date'].'</td>';
                        echo '<td>'.$course_progress['completion_date'].'</td>';
                        echo '<td>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <button class="btn btn-danger btn-sm" onclick="deleteUserCourseProgress('.$course_progress['user_id'].','.$course_progress['course_id'].')">Delete</button>
                                    <button class="btn btn-warning btn-sm" onclick="editUserCourseProgress('.$course_progress['user_id'].','.$course_progress['course_id'].')">Edit</button>
                                </div>
                              </td>';
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>


<div class="card mb-4">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        User Lesson Progress
        <button class="btn btn-primary btn-sm float-end ps-4 pe-4" id="btnAddUserLessonProgress">Add</button>
    </div>
    <div class="card-body">
        <table id="tableUserLessonProgress">
            <thead>
                <tr>
                    <th>User Id</th>
					<th>Lesson Id</th>
					<th>Completed</th>
					<th>Completion date</th>
					<th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $lessons_progress = getUsersLessonPogress();
                    foreach ($lessons_progress as $lesson_progress) {
                        echo '<tr>';
                        echo '<td>'.$lesson_progress['user_id'].'</td>';
                        echo '<td>'.$lesson_progress['lesson_id'].'</td>';
                        echo '<td>'.$lesson_progress['completed'].'</td>';
                        echo '<td>'.$lesson_progress['completion_date'].'</td>';
                        echo '<td>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <button class="btn btn-danger btn-sm" onclick="deleteUserLessonProgress('.$lesson_progress['user_id'].','.$lesson_progress['lesson_id'].')">Delete</button>
                                    <button class="btn btn-warning btn-sm" onclick="editUserLessonProgress('.$lesson_progress['user_id'].','.$lesson_progress['lesson_id'].')">Edit</button>
                                </div>
                              </td>';
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>