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
                                <p>Ready to embark on a quizzing adventure? Sign up for Quiz Wiz and unlock a world of knowledge.</p>
                            </div>
                            <div>
                                <p>Already have an account? Easily switch to our LogIn page and continue your quiz journey with us!</p>
                            </div>
                            <div>
                                <a class="qw-red-button" href="login.php">Login</a>
                            </div>
                        </div>
                </div>
                <div class="col-6" style="padding: 2em">
                    <h2>SIGNUP</h2>
                    <form action="register.php" method="post" class="qw-form col d-flex flex-column justify-content-between">
                        <div class="form-group">
                            <label for="nameInput">Name</label>
                            <input type="text" class="form-control" id="nameInput" name="name" aria-describedby="nameInputHelp" placeholder="Enter name">
                            <small id="nameInputHelp" class="form-text text-muted">Enter your full name. (eg. Hans Muster)</small>
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
                            <input type="text" class="form-control" id="usernameInput" name="username" aria-describedby="usernameInput" placeholder="Username/Email" required>
                            <small id="usernameInput" class="form-text text-muted">You can enter your username or email</small>
                        </div>

                        <div class="form-group">
                            <label for="passwordInput">Password *</label>
                            <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="repeatPasswordInput">Repeat Password *</label>
                            <input type="password" class="form-control" id="repeatPasswordInput" name="repeatPassword" placeholder="Repeat Password" required>
                        </div>
                        <div>
                            <button class="qw-red-button" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php

require_once '../services/QuizWizDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user-inputted values
    $name = $_POST["name"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeatPassword"];

    // Check if passwords match
    if ($password !== $repeatPassword) {
        // TODO add alert for invalid password
        echo '<div class="alert alert-danger" role="alert">';
        echo 'Passwords do not match!';
        echo '</div>';
    } else {

        // Passwords match, continue processing

        // Now you can use these variables as needed, for example, to perform database operations or validation.

        // For demonstration purposes, let's just print the values:
        echo "Name: " . $name . "<br>";
        echo "Date of Birth: " . $dateOfBirth . "<br>";
        echo "Username / Email: " . $username . "<br>";
        echo "Password: " . $password . "<br>";
        echo "Repeat Password: " . $repeatPassword . "<br>";
    }

    exit;
}


?>