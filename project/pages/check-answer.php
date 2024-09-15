<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Check Answer Page</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/style.css" rel="stylesheet" />
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
        }

        footer {
            width: 100%;
        }
    </style>
</head>
<body>
<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include '../include/navbar.php'; 
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

	<?php include '../content/cha-middle.php'; ?>
    

	<?php include '../include/footer.php'; ?>
<!-- SB Forms JS-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>