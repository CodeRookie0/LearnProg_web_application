<div class="row">
	<?php 
		$admin_statistics = getAdminStatistics();
	?>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-primary text-white mb-4">
			<div class="card-body">Number of new users</div>
			<div class="card-footer d-flex align-items-center justify-content-between">
				<span class="h4 mb-0 fw-bold text-white"><?php echo $admin_statistics['new_usr_count'] ?></span>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-warning text-white mb-4">
			<div class="card-body">Number of completed lessons</div>
			<div class="card-footer d-flex align-items-center justify-content-between">
				<span class="h4 mb-0 fw-bold text-white"><?php echo $admin_statistics['completed_lessons'] ?></span>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-success text-white mb-4">
			<div class="card-body">Number of completed courses</div>
			<div class="card-footer d-flex align-items-center justify-content-between">
				<span class="h4 mb-0 fw-bold text-white"><?php echo $admin_statistics['completed_courses'] ?></span>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-md-6">
		<div class="card bg-danger text-white mb-4">
			<div class="card-body">Users logged in (today)</div>
			<div class="card-footer d-flex align-items-center justify-content-between">
				<span class="h4 mb-0 fw-bold text-white"><?php echo $admin_statistics['users_logged_in_today'] ?></span>
			</div>
		</div>
	</div>
</div>