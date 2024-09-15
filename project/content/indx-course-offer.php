<section class="bg-light py-5 border-bottom" id="course-section">
	<div class="container px-5 my-5">
		<div class="text-center mb-5">
			<h2 class="fw-bolder">Unlock the Power of C++</h2>
			<p class="lead mb-0">
				Embark on an extraordinary journey of mastering C++ with our free
				courses!
			</p>
		</div>
		<div class="row gx-5 justify-content-center">
        <?php
            require_once '../data-repositories/course-functions.php';
            $courses = getCoursesWithTopics();
            foreach ($courses as $course) {
                        echo '<div class="col-lg-6 col-xl-4">';
                        echo '<div class="card h-100 mb-5 mb-xl-0">';
                        echo '<div class="card-body p-5 d-flex flex-column">';

                        echo '<div class="small text-uppercase fw-bold text-muted">'.explode(':', $course["name"])[0];
                        if ($course["status"] !== 'Active') {
                            echo ' (' . $course["status"] . ')';
                        }
                        echo '</div>';
                        echo '<div class="mb-3">
                                  <span class="display-4 fw-bold">$0</span>
                                  <span class="text-muted">/ mo.</span>
                              </div>
                              <ul class="list-unstyled mb-4">';
                        foreach ($course["topics"] as $topic) {
                            echo '<li class="mb-2">';
                            echo '<i class="bi bi-check text-primary"></i>'.$topic;
                            echo '</li>';
                        }
                        echo '</ul>';
                        echo '<div class="mt-auto d-grid">';
                if ($course["status"] !== 'Active') {
                    echo '<button class="btn btn-outline-primary" disabled>Choose course</button>';
                } else {
                    echo '<button class="btn btn-outline-primary" onclick=window.location.href="../pages/course-details.php?course_id=' . $course["id"] . '">Choose course</button>';
                }
                echo '</div>';
                echo '</div></div></div>';
            }

            ?>
        </div>
    </div>
</section>