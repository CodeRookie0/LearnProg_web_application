<div class="card mb-4" id="users_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Users
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
						echo '</tr>';
					}
				?>
            </tbody>
        </table>
    </div>
</div>
<div class="card mb-4" id="course_progress_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        User Course Progress
    </div>
    <div class="card-body">
        <table id="tableUserCourseProgress">
            <thead>
                <tr>
                    <th>User Id</th>
					<th>Course Id</th>
					<th>Start date</th>
					<th>Completion date</th>
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
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card mb-4" id="lesson_progress_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        User Lesson Progress
    </div>
    <div class="card-body">
        <table id="tableUserLessonProgress">
            <thead>
                <tr>
                    <th>User Id</th>
					<th>Lesson Id</th>
					<th>Completed</th>
					<th>Completion date</th>
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
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card mb-4" id="courses_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Courses
      </div>
    <div class="card-body">
        <table id="tableCourses">
            <thead>
                <tr>
					<th>Id</th>
					<th>Name</th>
					<th>Short description</th>
					<th>Full description</th>
					<th>Level</th>
					<th>Status</th>
					<th>Image path</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $courses = getCourses();
                    foreach ($courses as $course) {
                        echo '<tr>';
                        echo '<td>'.$course['id'].'</td>';
                        echo '<td>'.$course['name'].'</td>';
                        echo '<td>'.$course['short_description'].'</td>';
                        echo '<td>'.$course['full_description'].'</td>';
                        echo '<td>'.$course['level'].'</td>';
                        echo '<td>'.$course['status'].'</td>';
                        echo '<td>'.$course['image_path'].'</td>';
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card mb-4" id="course_topics_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Course Topics
    </div>
    <div class="card-body">
        <table id="tableCourseTopics">
            <thead>
                <tr>
                    <th>Id</th>
					<th>Course Id</th>
					<th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $topics = getTopics();
                    foreach ($topics as $topic) {
                        echo '<tr>';
                        echo '<td>'.$topic['topic_id'].'</td>';
                        echo '<td>'.$topic['course_id'].'</td>';
                        echo '<td>'.$topic['topic_name'].'</td>';
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card mb-4" id="lessons_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Lessons
    </div>
    <div class="card-body">
        <table id="tableLessons">
            <thead>
                <tr>
                    <th>Id</th>
					<th>Course Id</th>
					<th>Title</th>
					<th>Content</th>
					<th>Order</th>
					<th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $lessons = getLessons();
                    foreach ($lessons as $lesson) {
                        echo '<tr>';
                        echo '<td>'.$lesson['id'].'</td>';
                        echo '<td>'.$lesson['course_id'].'</td>';
                        echo '<td>'.$lesson['title'].'</td>';
                        echo '<td>'.(strlen(htmlspecialchars($lesson['content'])) > 450 ? substr(htmlspecialchars($lesson['content']), 0, 450) . '...' : htmlspecialchars($lesson['content'])).'</td>';
                        echo '<td>'.$lesson['order'].'</td>';
                        echo '<td>'.$lesson['points'].'</td>';
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4" id="lesson_files_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Lesson Files
    </div>
    <div class="card-body">
        <table id="tableLessonFiles">
            <thead>
                <tr>
                    <th>Id</th>
					<th>Lesson Id</th>
					<th>Name</th>
					<th>alt Text</th>
					<th>File Path</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $lesson_files = getAllLessonFiles();
                    foreach ($lesson_files as $lesson_file) {
                        echo '<tr>';
                        echo '<td>'.$lesson_file['id'].'</td>';
                        echo '<td>'.$lesson_file['lesson_id'].'</td>';
                        echo '<td>'.$lesson_file['name'].'</td>';
                        echo '<td>'.$lesson_file['alt_text'].'</td>';
                        echo '<td>'.$lesson_file['path'].'</td>';
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4" id="task_types_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Task types
    </div>
    <div class="card-body">
        <table id="tableTaskTypes">
            <thead>
                <tr>
                    <th>Id</th>
					<th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $task_types = getTaskTypes(); 
                    foreach ($task_types as $task_type) {
                        echo '<tr>';
                        echo '<td>'.$task_type['id'].'</td>';
                        echo '<td>'.$task_type['name'].'</td>';
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4" id="tasks_table">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Tasks
    </div>
    <div class="card-body">
        <table id="tableTasks">
            <thead>
                <tr>
                    <th>Id</th>
					<th>Lesson Id</th>
					<th>Type</th>
					<th>Description</th>
					<th>Options</th>
					<th>Solution</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $tasks = getAllLessonTasks(); 
                    foreach ($tasks as $task) {
                        echo '<tr>';
                        echo '<td>'.$task['id'].'</td>';
                        echo '<td>'.$task['lesson_id'].'</td>';
                        echo '<td>'.$task['type_name'].'</td>';
                        echo '<td>'.htmlspecialchars($task['description']).'</td>';
                        echo '<td>'.htmlspecialchars($task['options']).'</td>';
                        echo '<td>'.htmlspecialchars($task['solution']).'</td>';
						echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>