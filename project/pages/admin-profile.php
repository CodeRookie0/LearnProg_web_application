<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
	<meta name="description" content="" />
	<meta name="author" content="" />
    <title>LearnProg - Profile</title>
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
        if (!isset($_SESSION['id'])) {
            header("Location: ./login.php");
            exit;
        }
        else{
            $user_id=$_SESSION['id'];
        }
        include "../include/dashboard-navbar.php" ;
        include '../data-repositories/admin-dashboard-functions.php' ;

        $registration_date = new DateTime($user_data['registration_date']);
        $formatted_date = $registration_date->format('F j, Y');
    ?>
	<div id="layoutSidenav_content">
		<main>
			<div class="container-fluid px-4">
				<div class="container-fluid">
                    <div class="row mx-5 mt-5">
                        <div>
                        <?php
                            if (isset($_SESSION['error_message'])) {
                                echo '<div id="error_message" class="alert alert-danger mx-1">' . $_SESSION['error_message'] . '</div>';
                                unset($_SESSION['error_message']);
                            }

                            if (isset($_SESSION['success_message'])) {
                                echo '<div id="success_message" class="alert alert-success mx-1">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']); 
                            }
                        ?>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-2">
                                <div class="d-flex justify-content-center">
                                    <img src="../image/admin-icon.png" class="card-img-top" style="max-width: 370px; max-height: 370px;" alt="User Image">
                                </div>
                            </div>
                            <div class="card mt-2 p-3">
                                <h5 class="card-title"><?php echo $user_data['username'];?></h5>
                                <p class="card-text">Joined: <?php echo $formatted_date;?></p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 h3">Edit Profile</h5>
                                    <form  action="../actions/user-update-handler.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $user_data['id'];?>">
                                        <input type="hidden" name="notificationFrequency" value="<?php echo $user_data['notification_frequency'];?>">
                                        <div class="form-group mb-3">
                                            <label for="username" class="mb-2 ms-1">Username:</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user_data['username'];?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="email" class="mb-2 ms-1">Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email'];?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="password" class="mb-2 ms-1">Password:</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="passwordConfirm" class="mb-2 ms-1">Confirm Password:</label>
                                            <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary mt-2 p-2">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</main>
		<?php include "../include/footer.php" ?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous" ></script>
	<script src="../js/scripts.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous" ></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous" ></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var errorMessage = document.getElementById('error_message');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }

                var successMessage = document.getElementById('success_message');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 2000);
        });
    </script>
</body>
</html>