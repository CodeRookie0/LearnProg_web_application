<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['success_message'] = "User successfully logged out.";
    header("Location: ../pages/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Logout</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
</head>
<body>
    <?php include '../include/navbar.php'; ?>

    <div class="container ">
        <div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 175px);">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body p-5 ">
                        <div class="text-center mb-5">
                            <h5 class="card-title text-center">Confirm Logout</h5>
                            <p class="card-text text-center">Are you sure you want to logout?</p>
                        </div>
                        <form method="post">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="logout">Logout</button>
                                <a href="javascript:history.go(-1)" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../include/footer.php'; ?>
    
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SB Forms JS-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>