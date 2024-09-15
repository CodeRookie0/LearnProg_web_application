<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <a class="navbar-brand ps-3" href="admin-dashboard.php"><span style="background-color: white; color: black; padding: 0 5px">L E A R N P R O G</span></a>
  <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
    <i class="fas fa-bars"></i>
  </button>
  <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
  <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user fa-fw"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="../pages/admin-profile.php">Profile</a></li>
        <li> <hr class="dropdown-divider" /> </li>
        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
      </ul>
    </li>
  </ul>
</nav>
<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
        <div class="nav">
          <div class="sb-sidenav-menu-heading">Main</div>
          <a class="nav-link" href="admin-dashboard.php">
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt"></i>
            </div>
            Dashboard
          </a>
          <div class="sb-sidenav-menu-heading">Tools</div>
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon">
              <i class="fas fa-columns"></i>
            </div>
            Admin Tools
            <div class="sb-sidenav-collapse-arrow">
              <i class="fas fa-angle-down"></i>
            </div>
          </a>
          <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link" href="../pages/user-admin.php">User Admin</a>
              <a class="nav-link" href="../pages/course-admin.php">Course Admin</a>
              <a class="nav-link" href="../pages/lesson-admin.php">Lesson Admin</a>
            </nav>
          </div>
          <div class="sb-sidenav-menu-heading">Analytics</div>
          <a class="nav-link" href="../pages/admin-tables.php">
            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Tables
          </a>
          <a class="nav-link" href="../pages/admin-charts.php">
            <div class="sb-nav-link-icon">
              <i class="fas fa-chart-area"></i>
            </div>
            Charts
          </a>
          <div class="sb-sidenav-menu-heading">User View</div>
          <a class="nav-link" href="../pages/index.php">
              <div class="sb-nav-link-icon">
                  <i class="fas fa-home"></i>
              </div>
              Home Page
          </a>
        </div>
      </div>
      <div class="sb-sidenav-footer">
        <div class="small mb-1">Logged in as:</div>
        <?php
          if (!isset($_SESSION['id'])) {
            header("Location: ../pages/login.php");
            exit;
          }
          else{
            $user_id=$_SESSION['id'];
          }

          include "../data-repositories/user-functions.php";
          $user_data= getUserData($user_id);

          if ($user_data['type_name']!='Admin'){
            header("Location: ../pages/login.php");
            exit;
          }
          else{
            echo $user_data['username'];
          }
        ?>
      </div>
    </nav>
  </div>