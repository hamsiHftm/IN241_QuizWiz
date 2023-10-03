<?php
include '../../config.php';
require_once '../services/QuizWizDBService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"])) {
    // Retrieve user-entered values
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeatPassword"];

    // Check if passwords match
    if ($password !== $repeatPassword) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Passwords match, continue processing
        // TODO --> Check, if it okey to conn the DB global or only where it's needed
        $db_host = $GLOBALS['DB_HOST'];
        $db_port = $GLOBALS['DB_PORT'];
        $dbname = $GLOBALS['DB_NAME'];
        $db_user = $GLOBALS['DB_USERNAME'];
        $db_password = $GLOBALS['DB_PASSWORD'];
        $db = new QuizWizDBService($db_host, $db_port, $dbname, $db_user, $db_password);

        $result = $db->registerUser($username, $password, $firstname, $lastname, $dateOfBirth);
        if ($result) {
            echo "<script>
                            console.log('User registered successfully.');
                            const success_elm = document.getElementById('success-alert');
                            success_elm.classList.add('qw-show')
                            success_elm.classList.remove('qw-hide')
                      </script>";
        } else {
            echo "<script>
                            console.log('User registration failed.');
                            const failed_elem = document.getElementById('failed-alert');
                            failed_elem.classList.add('qw-show')
                            console.log('added')
                            failed_elem.classList.remove('qw-hide')
                            console.log('removed')
                      </script>";
        }
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&family=Roboto:wght@100;300;400&display=swap"
          rel="stylesheet">
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
                        <p>Ready to embark on a quizzing adventure? Sign up for Quiz Wiz and unlock a world of
                            knowledge.</p>
                    </div>
                    <div>
                        <p>Already have an account? Easily switch to our LogIn page and continue your quiz journey with
                            us!</p>
                    </div>
                    <div>
                        <a class="qw-red-button" href="LoginPage.php">Login</a>
                    </div>
                </div>
            </div>
            <div class="col-6" style="padding: 2em">
                <h2>SIGNUP</h2>
                <form action="RegisterPage.php" method="post"
                      class="qw-form col d-flex flex-column justify-content-between">
                    <div class="form-group">
                        <label for="firstnameInput">Firstname</label>
                        <input type="text" class="form-control" id="firstnameInput" name="firstname"
                               aria-describedby="firstnameInputHelp" placeholder="Enter name" required>
                        <small id="firstnameInputHelp" class="form-text text-muted">Enter your full name. (eg. Hans
                            Muster)</small>
                    </div>

                    <div class="form-group">
                        <label for="lastnameInput">Lastname</label>
                        <input type="text" class="form-control" id="lastnameInput" name="lastname"
                               aria-describedby="nameInputHelp" placeholder="Enter name" required>
                        <small id="lastnameInputHelp" class="form-text text-muted">Enter your full name. (eg. Hans
                            Muster)</small>
                    </div>

                    <div class="form-group">
                        <label for="dateOfBirthInput">Date of Birth</label>
                        <div class='input-group date' id='dateOfBirthInput'>
                            <input type='date' class="form-control" name="dateOfBirth"/>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="usernameInput">Username / Email *</label>
                        <input type="text" class="form-control" id="usernameInput" name="username"
                               aria-describedby="usernameInput" placeholder="Username/Email" required>
                        <small id="usernameInput" class="form-text text-muted">You can enter your username or
                            email</small>
                    </div>

                    <div class="form-group">
                        <label for="passwordInput">Password *</label>
                        <input type="password" class="form-control" id="passwordInput" name="password"
                               placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="repeatPasswordInput">Repeat Password *</label>
                        <input type="password" class="form-control" id="repeatPasswordInput" name="repeatPassword"
                               placeholder="Repeat Password" required>
                    </div>
                    <div>
                        <button class="qw-red-button" type="submit">Register</button>
                    </div>

                    <!-- TODO its not working -->
                    <!-- TODO show, if user already exits not failed -->
                    <div id="success-alert" class="alert alert-success qw-hide" role="alert">
                        Account Successfully created!
                    </div>

                    <div id="failed-alert" class="alert alert-danger qw-hide" role="alert">
                        Account Successfully created!
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

