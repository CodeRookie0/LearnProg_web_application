<?php
$config_file = "con.fig.php"; 
$step = isset($_POST['step']) ? intval($_POST['step']) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LearnProg - Installation</title>
    <link rel="icon" href="./my_project/image/logo-icon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="./my_project/css/style.css" rel="stylesheet" />
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body class="bg-light">
    <header class="bg-dark text-white py-3">
        <div class="container text-center">
            <h1>Application Installation Instructions</h1>
        </div>
    </header>
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                    <?php
                        function form_install_1(){
                            echo "<div class='container mt-4'>
                                    <div class='alert alert-info text-center fs-5' role='alert'>
                                        You must obtain this information from the server administrator
                                    </div>
                                </div>";
                            echo "<form method='post' name='instalacja'>
                                    <div class='mb-3'>
                                        <label for='host' class='form-label fs-5'>The name or address of the server</label>
                                        <input type='text' id='host' name='host' class='form-control' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='dbname' class='form-label fs-5'>Database name</label>
                                        <input type='text' id='dbname' name='dbname' class='form-control' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='user' class='form-label fs-5'>User Name</label>
                                        <input type='text' id='user' name='user' class='form-control' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='passwd' class='form-label fs-5'>Password</label>
                                        <input type='password' id='passwd' name='passwd' class='form-control' required>
                                    </div>
                                    <input type='hidden' name='step' value='2'>
                                    <p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary fs-5' type='submit'>Step 2</button></p>
                                </form>
                                ";
                        }    
                        function step2(){
                            global $config_file;
                            $file = fopen($config_file, "w");
                            if (!$file) {
                                die("I can not open the file $config_file");
                            }
                        
                            $host = $_POST['host'];
                            $user = $_POST['user'];
                            $password = $_POST['passwd'];
                            $dbname = $_POST['dbname'];
                        
                            $conn = mysqli_connect($host, $user, $password, $dbname);
                            if (!$conn) {
                                header("Location: install.php");
                                die("Database connection error: " . mysqli_connect_error());
                            }
                        
                            $date_of_creation = date('Y-m-d');
                        
                            $config = "<?php
                            define('DB_SERVER', '$host');
                            define('DB_USERNAME', '$user');
                            define('DB_PASSWORD', '$password');
                            define('DB_NAME', '$dbname');

                            \$base_url = \"https://www.manticore.uni.lodz.pl/~maria_sh/php_project/\";
                            \$nazwa_aplikacji = \"LearnProg\";
                            \$date_of_creation = \"$date_of_creation\";
                            \$brand = \"ByteByByte\";
                            \$adres = \"Rewolucji 1905 r.\";
                            \$adres2 = \"Łódź, 90-000\";
                            \$phone = \"432953384\";

                            \$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                            if (!\$conn) {
                                if(file_exists('con.fig.php')){
                                    header('Location: install.php');
                                    exit;             
                                }
                                else{
                                    echo 'Connection error';
                                }       
                            }
                            ?>\n";
                        
                            if (!fwrite($file, $config)) { 
                                die("I can't save to file ($file)"); 
                            }
                        
                            fclose($file); 
                        
                            echo "<h2 class='card-title text-center'>Step 2 completed</h2>";
                            echo "<div class='container mt-4'>
                                    <div class='alert alert-success text-center fs-5' role='alert'>
                                        Configuration file created
                                    </div>
                                </div>";
                            echo "<form method='post'>
                                    <input type='hidden' name='step' value='3'>
                                      <p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary fs-5' type=' submit'>Step 3</button></p>
                                </form>";
                        }    
                        function step3() {
                            global $conn, $create;
                            include "con.fig.php";
                            if (file_exists("sql/sql.php")) {
                                include("sql/sql.php");
                                echo "Creating database tables: ". DB_NAME .".<br>\n";
                                mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
                                for ($i = 0; $i < count($create); $i++) {
                                    mysqli_query($conn, $create[$i]);
                                }
                                echo "<div class='container mt-4'>
                                        <div class='alert alert-success text-center fs-5' role='alert'>
                                            The database structure has been created.
                                        </div>
                                    </div>";
                                echo "<form method='post'>
                                        <input type='hidden' name='step' value='4'>
                                          <p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary fs-5' type=' submit'>Step 4</button></p>
                                    </form>";
                            } else {
                                echo "The file sql/sql.php is missing";
                            }
                        }
                        function step4(){
                            global $conn, $insert;
                            include "con.fig.php";
                            if (file_exists("sql/insert.php")) {
                                include("sql/insert.php");
                                echo "<p>Insert data into database tables: ". DB_NAME .".</p>\n";
                                mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
                                for ($i = 0; $i < count($insert); $i++) {
                                    mysqli_query($conn, $insert[$i]);
                                }
                        
                                echo "<div class='container mt-4'>
                                        <div class='alert alert-success text-center fs-5' role='alert'>
                                            The data has been successfully imported to the database.
                                        </div>
                                    </div>";
                                echo "<form method='post'>
                                        <input type='hidden' name='step' value='5'>
                                        <p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary fs-5' type=' submit'>Step 5</button></p>
                                    </form>";
                            } else {
                                echo "The file sql/insert.php is missing";
                            }
                        }
                        function step5() {
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['step']) && $_POST['step'] == '5') {
                                echo "<h2 class='card-title text-center'>Step 5</h2>";
                                processRegistration();
                            } else {
                                echo "<h2 class='card-title text-center'>Step 5</h2>";
                                renderRegistrationForm();
                            }
                        }
                        function renderRegistrationForm($errors = []) {
                            session_start();
                            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
                            $useremail = isset($_SESSION['email']) ? $_SESSION['email'] : '';
                            
                            if (!empty($errors)) {
                                echo "<div class='container mt-4'>
                                        <div class='alert alert-danger text-center fs-5' role='alert'>
                                            <b>".implode("<br>", $errors)."</b>
                                        </div>
                                    </div>";
                            }
                            echo "<form method='post' name='rejestracja_admina'>
                                    <div class='mb-3'>
                                        <label for='imie' class='form-label fs-5'>Username</label>
                                        <input type='text' name='username' class='form-control' value='$username' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='email' class='form-label fs-5'>E-mail</label>
                                        <input type='email' name='email' class='form-control' value='$useremail' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='password' class='form-label fs-5'>Password</label>
                                        <input type='password' name='password' class='form-control' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='passwordAgain' class='form-label fs-5'>Repeat password</label>
                                        <input type='password' name='passwordAgain' class='form-control' required>
                                    </div>
                                    <div class='mb-3'>
                                        <input type='hidden' name='usertype' class='form-control' value='2' required>
                                    </div>
                                    <input type='hidden' name='step' value='5'>
                                    <p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary fs-5' type=' submit'>Step 6</button></p>
                                </form>
                            </div>";
                        }
                        
                        function processRegistration() {
                            include('con.fig.php');
                            $errors = [];
                            try {
                                $username = $_POST['username'];
                                $useremail = $_POST['email'];
                                $userpassword = $_POST['password'];
                                $userpasswordagain = $_POST['passwordAgain'];
                                $usertype = $_POST['usertype'];
                        
                                $_SESSION['username'] = $username;
                                $_SESSION['email'] = $useremail;
                        
                                if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
                                    $errors[] = "Nieprawidłowy adres email.";
                                }
                        
                                $uppercase = preg_match('@[A-Z]@', $userpassword);
                                $lowercase = preg_match('@[a-z]@', $userpassword);
                                $number = preg_match('@[0-9]@', $userpassword);
                                $specialChars = preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $userpassword);
                                $password_length = strlen($userpassword);
                        
                                if (!$uppercase || !$lowercase || !$number || !$specialChars || $password_length < 8) {
                                    $errors[] = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
                                }
                        
                                if ($userpassword !== $userpasswordagain) {
                                    $errors[] = "The password and repeated password must match!";
                                }
                        
                                if (!empty($errors)) {
                                    throw new Exception("Errors occurred while processing the form.");
                                }
                        
                                $hashed_password = password_hash($userpassword, PASSWORD_DEFAULT);
                                
                                $user_insert = $conn->prepare("INSERT INTO user (usr_username, usr_email, usr_password, usr_user_type_id) VALUES (?, ?, ?, ?)");
                                $user_insert->bind_param("sssi", $username, $useremail, $hashed_password, $usertype);
            
                                if ($user_insert->execute()) {
                                    $user_id = $user_insert->insert_id;
                                    $stmt_notification = $conn->prepare("INSERT INTO notification (ntf_user_id) VALUES (?)");
                                    $stmt_notification->bind_param("i", $user_id);
                                    $stmt_notification->execute();
                                } else {
                                    throw new Exception("Error registering user.");
                                }
                        
                                $user_insert->close();
                                $stmt_notification->close();
                                $conn->close();
                        
                                session_unset();
                                session_destroy();
                        
                                echo "<div class='container mt-4'>
                                        <div class='alert alert-success text-center fs-5' role='alert'>
                                            Administrator account registration completed successfully.
                                        </div>
                                    </div>";
                                echo "<form method='post'>
                                        <input type='hidden' name='step' value='6'>
                                        <p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary fs-5' type=' submit'>Step 6</button></p>
                                    </form>";
                            } catch (Exception $e) {
                                renderRegistrationForm($errors);
                            }
                        }
                        function step6(){
                            global $config_file, $step;
                            echo "<h2 class='card-title text-center'>Installation almost complete :)</h2>";
                            echo "<h4 class='mt-4'>Final touches:</h4>";
                            echo "<ol class='mt-4'>";
                            echo "<li class='mt-4 fs-5'>Change access rights to con.fig.php<br>e.g. <code>chmod o-w " . $config_file . " </code></li>";
                            echo "<li class='mt-4 fs-5'>When you are sure that the application works properly, remember to remove <code>install.php</code><br>e.g. <code>rm install.php</code>.</li>";
                            echo "</ol>";
                            echo "<p class='mt-4 fs-5'>The web application is already installed and ready to run, the link below will take you to it</p>";
                            echo "<p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary' onclick=\"window.location.href='./my_project/pages/index.php'\">Home Page</button></p>";
                        }
                
                        switch($step) {
                            case 2:
                                step2();
                                break;
                            
                            case 3:
                                step3();
                                break;
                            
                            case 4:
                                step4();
                                break;
                            
                            case 5:
                                step5();
                                break;

                            case 6:
                                step6();
                                break;
                            
                            default:
                                echo "<h2 class='card-title text-center'>Step 1</h2>";
                                echo "<ol class='mt-4'>";
                                    if(file_exists($config_file)){
                                        if(is_writable($config_file)){
                                            $step = 1;
                                            form_install_1();
                                        } else {
                                            echo "<li class='mt-4 fs-5'>Change file permissions <code>".$config_file."</code><br>np. <code>chmod o+w ".$config_file."</code></li>";
                                            echo "<p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary' onClick='window.location.href=window.location.href'>Refresh page</button></p>";
                                        }
                                    }else{
                                        echo "<li class='mt-4 fs-5'>Create file <code>".$config_file."</code><br>e.g. <code>touch ".$config_file."</code></li>";
                                        echo "<p class='mt-4 text-center fs-5'><button class='btn btn-outline-primary' onClick='window.location.href=window.location.href'>Refresh page</button></p>";
                                    }
                                    break;
                                echo "</ol>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p class="m-0">Copyright &copy; LearnProg 2024</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>