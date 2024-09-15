<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
	<meta name="description" content="" />
	<meta name="author" content="" />
    <title>LearnProg - Charts</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
	<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet"/>
	<link href="../css/style.css" rel="stylesheet" />
	<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous" ></script>
</head>
<body class="sb-nav-fixed">
	<?php 
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        include "../include/dashboard-navbar.php" ;
        include '../data-repositories/admin-dashboard-functions.php' ;
    ?>
	<div id="layoutSidenav_content">
		<main>
			<div class="container-fluid px-4">
				<h1 class="mt-4">Charts</h1>
				<div class="row">
					<div class="col-md-6 text-end">
						<ol class="breadcrumb mb-4">
							<li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
							<li class="breadcrumb-item active">Charts</li>
						</ol>
					</div>
					<div class="col-md-6">
						<div class="small text-secondary mb-2 text-end">
                        <span>Data for the month: <?php echo date('F'); ?>. Last update: <?php echo date('d-m-Y H:i'); ?></span>
						</div>
					</div>
				</div>
				<?php include "../content/ad-cards.php"; ?>
		        <?php 
					$new_users_per_day = getMonthUsers();
                    $active_users_per_day = getMonthActiveUsers();
                    $completed_lessons_per_day = getMonthCompletedLessons();
                    $completed_courses_per_day = getMonthCompletedCourses();
                    $average_completion_time_per_month = getAverageCompletionTimePerMonth();
                    $course_engagement = calculateCourseEngagement();
				?>
		        <?php include "../content/ac-charts.php"; ?>
			</div>
		</main>
		<?php include "../include/footer.php" ?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous" ></script>
	<script src="../js/scripts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous" ></script>
	<script src="../js/charts-area-admin-charts.js"></script>
	<script src="../js/charts-bar-admin-charts.js"></script>
	<script src="../js/charts-multi-bar-charts.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous" ></script>
</body>
</html>