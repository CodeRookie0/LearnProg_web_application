<div class="card mb-4">
    <div class="card-header p-3">
        <i class="fas fa-table me-1"></i>
        Courses
        <button class="btn btn-primary btn-sm float-end ps-4 pe-4" id="btnAddCourse">Add</button>
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
                    <th>Action</th>
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
                        echo '<td>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <button class="btn btn-danger btn-sm" onclick="deleteCourse('.$course['id'].')">Delete</button>
                                    <button class="btn btn-warning btn-sm" onclick="editCourse('.$course['id'].')">Edit</button>
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
        Course Topics
        <button class="btn btn-primary btn-sm float-end ps-4 pe-4" id="btnAddCourseTopic">Add</button>
    </div>
    <div class="card-body">
        <table id="tableCourseTopics">
            <thead>
                <tr>
                    <th>Id</th>
					<th>Course Id</th>
					<th>Name</th>
                    <th>Action</th>
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
                        echo '<td>
                                <div class="btn-group-vertical" style="width: 100%;">
                                    <button class="btn btn-danger btn-sm" onclick="deleteCourseTopic('.$topic['topic_id'].')">Delete</button>
                                    <button class="btn btn-warning btn-sm" onclick="editCourseTopic('.$topic['topic_id'].')">Edit</button>
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
        <i class="fas fa-table-columns me-1"></i>
        Courseware Control 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col p-3" id='courses-container-col1'></div>
            <div class="col p-3" id='courses-container-col2'></div>
        </div>
    </div>
</div>