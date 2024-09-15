<div class="card mb-4">
	<div class="card-header">
		<i class="fas fa-table me-1"></i>
		Users
	</div>
	<div class="card-body">
		<table id="tableUsers">
			<thead>
				<tr>
					<th>Username</th>
					<th>Email</th>
					<th>Type</th>
					<th>Completed lessons</th>
					<th>Registration</th>
					<th>Last Login</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Username</th>
					<th>Email</th>
					<th>Type of User</th>
					<th>Completed lessons</th>
					<th>Registration Date</th>
					<th>Last Login Date</th>
				</tr>
			</tfoot>
			<tbody>
				<?php 
					$users = getAllUsersData();
					foreach ($users as $user) {
						echo '<tr>';
						echo '<td>'.$user['username'].'</td>';
						echo '<td>'.$user['email'].'</td>';
						echo '<td>'.$user['type_name'].'</td>';
						echo '<td>'.$user['completed_lessons'].'</td>';
						echo '<td>'.$user['registration_date'].'</td>';
						echo '<td>'.$user['last_login_date'].'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
</div>