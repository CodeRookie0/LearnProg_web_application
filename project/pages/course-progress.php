<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Course Progress</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../css/style.css" rel="stylesheet" />
    <style>
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <?php include '../include/navbar.php'; ?>
	
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <?php include '../content/cp-header.php'; ?>
                <?php include '../content/cp-course-lessons.php'; ?>
            </div>
            <div class="col-lg-4">
                <?php include '../content/cp-course-full-description.php'; ?>
                <?php include '../content/cp-progress-card.php'; ?>
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