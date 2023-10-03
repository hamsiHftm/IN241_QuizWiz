<?php
require '../../config.php';
require '../services/QuizWizDB.php';
require '../controllers/LocalStorageController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"])) {

    // Retrieve user-entered values
    $username = $_POST["username"];
    $password = $_POST["password"];
    $db_host = $GLOBALS['DB_HOST'];
    $db_port = $GLOBALS['DB_PORT'];
    $dbname = $GLOBALS['DB_NAME'];
    $db_user = $GLOBALS['DB_USERNAME'];
    $db_password = $GLOBALS['DB_PASSWORD'];
    $db = new QuizWizDB($db_host, $db_port, $dbname, $db_user, $db_password);

    $user = $db->loginUser($username, $password);
    if ($user !== null) {
        LocalStorageController::storeData(LocalStorageController::LOGGED_USER_DATA, $user->toArray());
        echo "<script>
                       console.log('User logged-in successfully.');
                        window.location.href = 'home.php';
                    </script>";
    } else {
        echo "<script>
                console.log('User registration failed');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>QuizWiz</title>
    <link rel="icon" href="../../assets/img/logo_icon.svg">
    <!-- Adding bootstrap library -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.css">
    <script src="../../assets/bootstrap/js/bootstrap.js"></script>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="../../assets/css/quizWiz.css">
    <!-- added google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
</head>
<body>
<div class="qw-card-layout d-flex align-items-center justify-content-center">
    <div class="qw-card-container">
        <div class="row qw-card-layout">
            <div class="col-6 qw-blue-container">
                <div class="qw-card-inner-layout">
                    <div>
                        <img class="qw-card-icon-layout" src="../../assets/img/quiz_wiz_logo.svg">
                    </div>
                    <div>
                        <p>Ready to quiz? Login now and put your knowledge to the test!</p>
                    </div>
                    <div>
                        <p>Don't have an account yet? No worries, switch to our Sign Up page to join the quiz fun!"</p>
                    </div>
                    <div>
                        <a class="qw-red-button" href="register.php">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-6" style="padding: 2em">
                <h2>LOGIN</h2>
                <form class="qw-form col d-flex flex-column justify-content-between" method="POST" action="login.php">

                    <div class="form-group">
                        <label for="usernameInput">Username / Email</label>
                        <input type="text" class="form-control" id="usernameInput" name="username" aria-describedby="usernameInput" placeholder="Username/Email">
                        <small id="usernameInput" class="form-text text-muted">You can enter your username or email</small>
                    </div>
                    <div class="form-group">
                        <label for="passwordInput">Password</label>
                        <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Password">
                    </div>
                    <div>
                        <button class="qw-red-button" type="submit">Login</button>
                    </div>

                    <div>
                        <a href="forget_password.php">Forget password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>