<div class="row">
	<div class="col-xl-6">
		<div class="card mb-4">
			<div class="card-header">
				<i class="fas fa-chart-area me-1"></i>
				Number of new users
			</div>
			<div class="card-body">
				<canvas id="new_users_chart" width="100%" height="40" data-new-users-per-day="<?php echo htmlspecialchars(json_encode($new_users_per_day)); ?>">></canvas>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
		<div class="card mb-4">
			<div class="card-header">
				<i class="fas fa-chart-bar me-1"></i>
				Number of completed lessons
			</div>
			<div class="card-body">
				<canvas id="completed_lessons_chart" width="100%" height="40"  data-completed-lessons-per-day="<?php echo htmlspecialchars(json_encode($completed_lessons_per_day)); ?>">></canvas>
			</div>
		</div>
	</div>
</div>