<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$login_text = "Login";
$login_link = "../pages/login.php";
$is_admin = false;

if (isset($_SESSION['id'])) {
    $login_text = "Logout";
    $login_link = "../pages/logout.php";

	require_once '../../con.fig.php';
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	if (isset($_SESSION['id'])){
		$user_id = $_SESSION['id'];
		$sql = "SELECT usr_user_type_id FROM user WHERE usr_user_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $user_id);
		$stmt->execute();
		$stmt->bind_result($user_type_id);
		$stmt->fetch();
		$stmt->close();

		if ($user_type_id == 2) {
			$is_admin = true;
		}
		$conn->close();
	}
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container px-5">
		<a class="navbar-brand" href="../pages/index.php"
			><span style="background-color: white; color: black; padding: 0 5px"
				>L E A R N P R O G</span
			>
			<span
				style="background-color: rgba(0, 0, 0, 0); color: white; padding: 0 5px"
				>W E B S I T E</span
			></a
		>
		<button
			class="navbar-toggler"
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#navbarSupportedContent"
			aria-controls="navbarSupportedContent"
			aria-expanded="false"
			aria-label="Toggle navigation"
		>
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="../pages/index.php">Home</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="../pages/courses.php">Courses</a></li>
				<li class="nav-item"><a class="nav-link" href="../pages/about.php">About</a></li>
				<li class="nav-item"><a class="nav-link" href="../pages/faq.php">FAQ</a></li>
				<li class="nav-item"><a class="nav-link" href="../pages/contact.php">Contact</a></li>
				<?php
					if (isset($_SESSION['id'])) {
						echo '<li class="nav-item"><a class="nav-link" href="../pages/profile.php">Profile</a></li>';
						if ($is_admin) {
							echo '<li class="nav-item"><a class="nav-link" href="../pages/admin-dashboard.php">Admin Dashboard</a></li>';
						}
					}
                ?>
				<li class="nav-item"><a class="nav-link active" href="<?php echo $login_link; ?>"><?php echo $login_text; ?></a></li>
			</ul>
		</div>
	</div>
</nav>