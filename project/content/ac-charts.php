<div class="row">
	<div class="col-xl-6">
		<div class="card mb-4" id="number_of_new_users">
			<div class="card-header">
				<i class="fas fa-chart-area me-1"></i>Number of new users
			</div>
			<div class="card-body p-5">
					<?php if (isset($new_users_per_day['error'])) : ?>
						<p class="card-text"><?php echo $new_users_per_day['error']; ?></p>
					<?php else : ?>
						<canvas id="new_users_chart" width="100%" height="40" data-new-users-per-day="<?php echo htmlspecialchars(json_encode($new_users_per_day)); ?>"></canvas>
					<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
		<div class="card mb-4" id="number_of_active_users">
			<div class="card-header">
				<i class="fas fa-chart-area me-1"></i>
				Number of active users
			</div>
			<div class="card-body p-5">
				<?php if (isset($active_users_per_day['error'])) : ?>
					<p class="card-text"><?php echo $active_users_per_day['error']; ?></p>
				<?php else : ?>
					<canvas id="active_users_chart" width="100%" height="40" data-active_users_per_day="<?php echo htmlspecialchars(json_encode($active_users_per_day)); ?>"></canvas>
				<?php endif; ?>
				</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xl-6">
		<div class="card mb-4" id="number_of_completed_lessons">
			<div class="card-header">
				<i class="fas fa-chart-bar me-1"></i>
				Number of completed lessons
			</div>
			<div class="card-body p-5">
				<?php if (isset($completed_lessons_per_day['error'])) : ?>
					<p class="card-text"><?php echo $completed_lessons_per_day['error']; ?></p>
				<?php else : ?>
					<canvas id="completed_lessons_chart" width="100%" height="40"  data-completed_lessons_per_day="<?php echo htmlspecialchars(json_encode($completed_lessons_per_day)); ?>"></canvas>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
		<div class="card mb-4" id="number_of_completed_courses">
			<div class="card-header">
				<i class="fas fa-chart-bar me-1"></i>
				Number of completed courses
			</div>
			<div class="card-body p-5">
				<?php if (isset($completed_courses_per_day['error'])) : ?>
					<p class="card-text"><?php echo $completed_courses_per_day['error']; ?></p>
				<?php else : ?>
					<canvas id="completed_courses_chart" width="100%" height="40"  data-completed_courses_per_day="<?php echo htmlspecialchars(json_encode($completed_courses_per_day)); ?>"></canvas>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xl-6">
		<div class="card mb-4" id="avarage_course_completion_time">
			<div class="card-header">
				<i class="fas fa-chart-area me-1"></i>
				Average course completion time
			</div>
			<div class="card-body p-5">
				<canvas id="avarage_completion_time_chart" width="100%" height="40" data-average_completion_time_per_month="<?php echo htmlspecialchars(json_encode($average_completion_time_per_month)); ?>"></canvas>
			</div>
		</div>
	</div>
	<div class="col-xl-6">
		<div class="card mb-4" id="course_engagement_rate">
			<div class="card-header">
				<i class="fas fa-chart-bar me-1"></i>
				Course engagement
			</div>
			<div class="card-body p-5">
				<?php if (isset($average_completion_time_per_month['error'])) : ?>
					<p class="card-text"><?php echo $average_completion_time_per_month['error']; ?></p>
				<?php else : ?>
					<canvas id="course_engagement_chart" width="100%" height="40"  data-course_engagement="<?php echo htmlspecialchars(json_encode($course_engagement)); ?>"></canvas>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>