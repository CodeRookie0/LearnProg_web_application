<?php
    $notification_frequency='';
    switch ($user_data['notification_frequency']){
        case 3:
            $notification_frequency='Twice a week';
            break;
        case 7:
            $notification_frequency='Once a week';
            break;
        case 14:
            $notification_frequency='Every 2 weeks';
            break;
        default:
            $notification_frequency = 'Disabled';
            break;
    }
    $num_courses_completed = 0;
    foreach ($user_courses as $course) {
        if (!empty($course['completion_date'])) {
            $num_courses_completed++;
        }
    }
?>
<h2 class="text-center">Overview</h2>
<p><strong>Username:</strong> <?php echo $user_data['username'];?></p>
<p><strong>Email:</strong> <?php echo $user_data['email'];?></p>
<hr>
<p><strong>Notification frequency:</strong> <?php echo $notification_frequency;?></p>
<p><strong>Registration date:</strong> <?php echo $user_data['registration_date'];?></p>
<hr>
<p><strong>Number of courses:</strong> <?php echo count($user_courses);?></p>
<p><strong>Number of courses completed:</strong> <?php echo $num_courses_completed;?></p>
<button class="btn btn-primary" onclick=switchToSettingsTab()>Edit profile</button>