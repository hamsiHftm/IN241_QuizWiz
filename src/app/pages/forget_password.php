<?php
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
                        <a class="qw-red-button" href="login.php">Back</a>
                    </div>
                </div>
            </div>
            <div class="col-6" style="padding: 2em">
                <h2>Reset Password</h2>
                <form class="qw-form col d-flex flex-column justify-content-between">
                    <div class="form-group">
                        <label for="usernameInput">Username / Email</label>
                        <input type="text" class="form-control" id="usernameInput" aria-describedby="usernameInput" placeholder="Username/Email">
                        <small id="usernameInput" class="form-text text-muted">You can enter your username or email</small>
                    </div>

                    <div class="form-group">
                        <label for="passwordInput">Password</label>
                        <input type="password" class="form-control" id="passwordInput" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="repeatPasswordInput">Repeat Password</label>
                        <input type="password" class="form-control" id="repeatPasswordInput" placeholder="Repeat Password">
                    </div>
                    <div>
                        <button class="qw-red-button" type="submit">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>