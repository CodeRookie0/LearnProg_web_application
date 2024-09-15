<h2 class="mb-3">My Courses</h2>
<div class="row row-cols-1 row-cols-lg-2 g-4">
    <?php
        $user_courses_info = array();
        foreach ($user_courses as $user_course) {
            $course_info = array(
                'id' => $user_course['course_id'],
                'start_date' => $user_course['start_date'],
                'completion_date' => $user_course['completion_date']
            );
            foreach ($courses as $course) {
                if($course['id']==$course_info['id']){
                    $course_info['image_path']=$course['image_path'];
                    $course_info['level']=$course['level'];
                    $course_info['status']=$course['status'];
                    $course_info['name']=$course['name'];
                    $course_info['short_description']=$course['short_description'];
                    break;
                }
            }
            $user_courses_info[] = $course_info;
        }
        if (empty($user_courses_info)) {
            echo '<div class="col mb-5">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title mb-3">No courses found.</h5>';
            echo '</div>';
            echo '</div>';
        } else {
            foreach($user_courses_info as $course_info){
                echo '<div class="col mb-5">';
                echo '<div class="card h-100 shadow border-0">';
                $imagePath = $course_info["image_path"];
                $status = $course_info['status'];
                if (strpos($imagePath, '.jpg') !== false || strpos($imagePath, '.png') !== false) {
                    $pathParts = pathinfo($imagePath);
                    $largeImagePath = $pathParts['dirname'] . '/' . $pathParts['filename'] . '-large.' . $pathParts['extension'];
                    echo '<img class="card-img-top" src="' . $largeImagePath . '" alt="'. $course_info["name"] .'" />';
                } else {
                    echo '<img class="card-img-top" src="' . $imagePath . '" alt="'. $course_info["name"] .'" />';
                }
                echo '<div class="card-body">';
                echo '<div class="badge bg-primary bg-gradient rounded-pill mb-2 p-2">'.$course_info['level'].'</div>';
                $status_class = '';
                switch ($status) {
                    case 'Inactive':
                        $status_class = 'bg-danger';
                        break;
                    case 'Upcoming':
                        $status_class = 'bg-warning';
                        break;
                    default:
                        $status_class = 'bg-success';
                        break;
                }
                echo '<div class="badge ' . $status_class . ' bg-gradient rounded-pill mb-2 ms-2 py-2">' . $course_info["status"] . '</div>';
                echo '<h5 class="card-title">'.strstr($course_info['name'], ':', true).'</h5>';
                echo '<p class="card-text">'.$course_info['short_description'].'</p>';
                if($course_info['completion_date']!=null){
                    echo '<p class="card-text"><small class="text-muted">Completion date: '.$course_info['completion_date'].'</small></p>';
                    echo '<button class="btn btn-outline-primary" disabled>View Certificate</button>';
                    echo '<p class="tcard-text mt-3"><small class="text-muted">Certificates will be available soon. Stay tuned!<small></p>';
                }
                else{
                    echo '<p class="card-text"><small class="text-muted">Start date: '.$course_info['start_date'].'</small></p>';
                    echo '<a href="../pages/course-progress.php?course_id=' . $course_info['id'] . '" class="btn btn-primary stretched-link">Continue Course</a>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
    ?>
</div>
<h2 class="mb-3">Other Courses</h2>
<div class="row row-cols-1 row-cols-lg-2 g-4">
    <?php
        foreach($courses as $course){
            $courseId = $course['id'];
            $courseExists = false;
            foreach($user_courses_info as $user_course) {
                if ($user_course['id'] == $courseId) {
                    $courseExists = true;
                    break;
                }
            }
            if (!$courseExists) {
                echo '<div class="col mb-5">';
                echo '<div class="card h-100 shadow border-0">';
                $imagePath = $course["image_path"];
                if (strpos($imagePath, '.jpg') !== false || strpos($imagePath, '.png') !== false) {
                    $pathParts = pathinfo($imagePath);
                    $largeImagePath = $pathParts['dirname'] . '/' . $pathParts['filename'] . '-large.' . $pathParts['extension'];
                    echo '<img class="card-img-top" src="' . $largeImagePath . '" alt="'. $course["name"] .'" />';
                } else {
                    echo '<img class="card-img-top" src="' . $imagePath . '" alt="'. $course["name"] .'" />';
                }
                echo '<div class="card-body">';
                echo '<div class="badge bg-primary bg-gradient rounded-pill mb-2 p-2">'.$course['level'].'</div>';
                $status_class = '';
                switch ($course["status"]) {
                    case 'Inactive':
                        $status_class = 'bg-danger';
                        break;
                    case 'Upcoming':
                        $status_class = 'bg-warning';
                        break;
                    default:
                        $status_class = 'bg-success';
                        break;
                }
                echo '<div class="badge ' . $status_class . ' bg-gradient rounded-pill mb-2 ms-2 py-2">' . $course["status"] . '</div>';
                echo '<h5 class="card-title">'.strstr($course['name'], ':', true).'</h5>';
                echo '<p class="card-text">'.$course['short_description'].'</p>';
                if ($course["status"] !== 'Active') {
                    echo '<button class="btn btn-outline-primary" disabled>Start course</button>';
                }else{
                    echo '<button class="btn btn-primary" onclick=window.location.href="../pages/course-details.php?course_id=' . $course["id"] . '">Start Course</button>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
    ?>
</div>