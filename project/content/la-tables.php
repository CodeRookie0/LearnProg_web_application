<div class="card mb-4">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Lessons
        <button class="btn btn-primary btn-sm float-end ps-4 pe-4" id="btnAddLesson">Add</button>
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
                    <th>Action</th>
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
                        echo '<td>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <button class="btn btn-danger btn-sm" onclick="deleteLesson('.$lesson['id'].')">Delete</button>
                                    <button class="btn btn-warning btn-sm" onclick="editLesson('.$lesson['id'].')">Edit</button>
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
        Lesson Files
        <button class="btn btn-primary btn-sm float-end ps-4 pe-4" id="btnAddLessonFile">Add</button>
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
                    <th>Action</th>
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
                        echo '<td>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <button class="btn btn-danger btn-sm" onclick="deleteLessonFile('.$lesson_file['id'].')">Delete</button>
                                    <button class="btn btn-warning btn-sm" onclick="editLessonFile('.$lesson_file['id'].')">Edit</button>
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
        Tasks
        <button class="btn btn-primary btn-sm float-end ps-4 pe-4" id="btnAddTask">Add</button>
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
                    <th>Action</th>
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
                        echo '<td>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <button class="btn btn-danger btn-sm" onclick="deleteTask('.$task['id'].')">Delete</button>
                                    <button class="btn btn-warning btn-sm" onclick="editTask('.$task['id'].')">Edit</button>
                                </div>
                              </td>';
                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>