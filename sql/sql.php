<?php
$create[] = "CREATE TABLE `course` (
  `crs_course_id` int(11) NOT NULL,
  `crs_course_name` varchar(255) NOT NULL,
  `crs_full_description` text NOT NULL,
  `crs_short_description` varchar(255) NOT NULL,
  `crs_level` enum('Beginner','Intermediate','Advanced') NOT NULL DEFAULT 'Beginner',
  `crs_status` enum('Active','Inactive','Upcoming') NOT NULL DEFAULT 'Inactive',
  `crs_image_path` varchar(255) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$create[] = "CREATE TABLE `lesson` (
  `les_lesson_id` int(11) NOT NULL,
  `les_course_id` int(11) NOT NULL,
  `les_lesson_title` varchar(255) NOT NULL,
  `les_lesson_content` text NOT NULL,
  `les_lesson_order` int(11) NOT NULL,
  `les_points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$create[] = "CREATE TABLE `lesson_file` (
  `lsf_lessons_file_id` int(11) NOT NULL,
  `lsf_lesson_id` int(11) DEFAULT NULL,
  `lsf_file_name` varchar(255) NOT NULL,
  `lsf_alt_text` varchar(255) DEFAULT NULL,
  `lsf_file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$create[] = "CREATE TABLE `notification` (
  `ntf_notification_id` int(11) NOT NULL,
  `ntf_user_id` int(11) NOT NULL,
  `ntf_notification_frequency` int(11) NOT NULL DEFAULT 3,
  `ntf_last_notification_sent` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$create[] = "CREATE TABLE `task` (
  `tsk_task_id` int(11) NOT NULL,
  `tsk_lesson_id` int(11) NOT NULL,
  `tsk_task_type_id` int(11) NOT NULL,
  `tsk_task_description` text NOT NULL,
  `tsk_task_options` text DEFAULT NULL,
  `tsk_task_solution` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$create[] = "CREATE TABLE `task_type` (
  `tt_task_type_id` int(11) NOT NULL,
  `tt_task_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$create[] = "CREATE TABLE `topic` (
  `top_topic_id` int(11) NOT NULL,
  `top_topic_name` varchar(255) NOT NULL,
  `top_course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$create[] = "CREATE TABLE `user` (
  `usr_user_id` int(11) NOT NULL,
  `usr_username` varchar(255) NOT NULL,
  `usr_email` varchar(255) NOT NULL,
  `usr_password` varchar(255) NOT NULL,
  `usr_user_type_id` int(11) NOT NULL DEFAULT 1,
  `usr_registration_date` date NOT NULL DEFAULT curdate(),
  `usr_last_login_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$create[] = "CREATE TABLE `user_course` (
  `ucr_user_id` int(11) NOT NULL,
  `ucr_course_id` int(11) NOT NULL,
  `ucr_start_date` date NOT NULL DEFAULT curdate(),
  `ucr_completion_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$create[] = "CREATE TABLE `user_lesson_progress` (
  `ulp_user_id` int(11) NOT NULL,
  `ulp_lesson_id` int(11) NOT NULL,
  `ulp_completed` tinyint(1) NOT NULL DEFAULT 0,
  `ulp_completion_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$create[] = "CREATE TABLE `user_type` (
  `ut_user_type_id` int(11) NOT NULL,
  `ut_user_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$create[]="ALTER TABLE `course`
  ADD PRIMARY KEY (`crs_course_id`);";

$create[]="ALTER TABLE `lesson`
  ADD PRIMARY KEY (`les_lesson_id`),
  ADD KEY `les_course_id` (`les_course_id`);";

$create[]="ALTER TABLE `lesson_file`
  ADD PRIMARY KEY (`lsf_lessons_file_id`),
  ADD KEY `lsf_lesson_id` (`lsf_lesson_id`)";

$create[]="ALTER TABLE `notification`
  ADD PRIMARY KEY (`ntf_notification_id`),
  ADD KEY `ntf_user_id` (`ntf_user_id`);";

$create[]="ALTER TABLE `task`
  ADD PRIMARY KEY (`tsk_task_id`),
  ADD KEY `tsk_lesson_id` (`tsk_lesson_id`),
  ADD KEY `tsk_task_type_id` (`tsk_task_type_id`);";

$create[]="ALTER TABLE `task_type`
  ADD PRIMARY KEY (`tt_task_type_id`);";

$create[]="ALTER TABLE `topic`
  ADD PRIMARY KEY (`top_topic_id`),
  ADD KEY `top_course_id` (`top_course_id`);";

$create[]="ALTER TABLE `user`
  ADD PRIMARY KEY (`usr_user_id`),
  ADD KEY `usr_user_type_id` (`usr_user_type_id`);";

$create[]="ALTER TABLE `user_course`
  ADD KEY `ucr_user_id` (`ucr_user_id`),
  ADD KEY `ucr_course_id` (`ucr_course_id`);";

$create[]="ALTER TABLE `user_lesson_progress`
  ADD KEY `ulp_user_id` (`ulp_user_id`),
  ADD KEY `ulp_lesson_id` (`ulp_lesson_id`);";

$create[]="ALTER TABLE `user_type`
  ADD PRIMARY KEY (`ut_user_type_id`);";

$create[]="ALTER TABLE `course`
  MODIFY `crs_course_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `lesson`
  MODIFY `les_lesson_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `lesson_file`
  MODIFY `lsf_lessons_file_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `notification`
  MODIFY `ntf_notification_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `task`
  MODIFY `tsk_task_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `task_type`
  MODIFY `tt_task_type_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `topic`
  MODIFY `top_topic_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `user`
  MODIFY `usr_user_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `user_type`
  MODIFY `ut_user_type_id` int(11) NOT NULL AUTO_INCREMENT;";

$create[]="ALTER TABLE `lesson`
  ADD CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`les_course_id`) REFERENCES `course` (`crs_course_id`);";

$create[]="ALTER TABLE `lesson_file`
  ADD CONSTRAINT `lesson_file_ibfk_1` FOREIGN KEY (`lsf_lesson_id`) REFERENCES `lesson` (`les_lesson_id`);";

$create[]="ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`ntf_user_id`) REFERENCES `user` (`usr_user_id`);";

$create[]="ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`tsk_lesson_id`) REFERENCES `lesson` (`les_lesson_id`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`tsk_task_type_id`) REFERENCES `task_type` (`tt_task_type_id`);";

$create[]="ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`top_course_id`) REFERENCES `course` (`crs_course_id`);";

$create[]="ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`usr_user_type_id`) REFERENCES `user_type` (`ut_user_type_id`);";

$create[]="ALTER TABLE `user_course`
  ADD CONSTRAINT `user_course_ibfk_1` FOREIGN KEY (`ucr_user_id`) REFERENCES `user` (`usr_user_id`),
  ADD CONSTRAINT `user_course_ibfk_2` FOREIGN KEY (`ucr_course_id`) REFERENCES `course` (`crs_course_id`);";

$create[]="ALTER TABLE `user_lesson_progress`
  ADD CONSTRAINT `user_lesson_progress_ibfk_1` FOREIGN KEY (`ulp_user_id`) REFERENCES `user` (`usr_user_id`),
  ADD CONSTRAINT `user_lesson_progress_ibfk_2` FOREIGN KEY (`ulp_lesson_id`) REFERENCES `lesson` (`les_lesson_id`);";
?>