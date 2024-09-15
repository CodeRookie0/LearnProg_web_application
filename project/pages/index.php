<?php
  if (!file_exists("../../con.fig.php")) {
    if(file_exists("../../install.php")){
      header("Location: ../../install.php");
      exit;
    }
    else{
      echo "Connection error";
      exit;
    }
  }

  include "../../con.fig.php";

  if (!$conn) {
    if(file_exists("../../con.fig.php")){
      header("Location: ../../install.php");
      exit;
    }
    else{
      echo "Connection error";
      exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Home Page</title>
    <link rel="icon" href="../image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../css/style.css" rel="stylesheet" />
</head>
<body>
    <?php include '../include/navbar.php'; ?>
    
    <?php 
        $pageTitle = "Embark on Your C++ Journey with LearnProg";
        $pageDescription = "Welcome to LearnProg, your premier online resource for mastering
						C++. Whether you're a novice or an expert coder, we're here to guide
						you every step of the way. Start coding today!";
        include '../include/header.php'; 
    ?>
    
    <?php include '../content/indx-features.php'; ?>
    
    <?php include '../content/indx-course-offer.php'; ?>
    
    <?php include '../content/indx-testimonials.php'; ?>
    
    <?php include '../include/contact-form.php'; ?>
    
    <?php include '../include/footer.php'; ?>
    
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SB Forms JS-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
