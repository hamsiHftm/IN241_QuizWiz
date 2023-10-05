<?php
require '../controllers/AuthController.php';

// Login button action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"])) {

    // Retrieve user-entered values
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = AuthController::loginUser($username, $password);
    if ($result['success'] === true) {
        echo "<script>
                       console.log('User logged-in successfully.');
                        window.location.href = 'HomePage.php';
                    </script>";
    } else {
        echo "<script>alert('" . $result['message'] . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
    <link rel="stylesheet" href="../../assets/css/LoginAndRegistrationStyle.css">
</head>
<body>
<div class="qw-card-layout d-flex align-items-center justify-content-center">
    <div class="qw-card-container">
        <div class="row qw-card-layout">
            <div class="col-6 qw-blue-container">
                <div class="qw-card-layout d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <img class="qw-card-icon-layout" src="../../assets/img/quiz_wiz_logo.svg">
                        <p>Ready to quiz? Login now and put your knowledge to the test!</p>
                        <p>Don't have an account yet? No worries, switch to our Sign Up page to join the quiz fun!"</p>
                        <a class="qw-red-button" href="RegisterPage.php">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="qw-card-layout d-flex align-items-center justify-content-center">
                    <div style="width: 90%; height: 80%">
                        <h2>LOGIN</h2>
                        <form class="qw-form col d-flex flex-column justify-content-between" method="POST"
                              action="LoginPage.php">

                            <div class="form-group">
                                <label for="usernameInput">Username / Email *</label>
                                <input type="text" class="form-control qw-form-text-box" id="usernameInput" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="passwordInput">Password *</label>
                                <input type="password" class="form-control qw-form-text-box" name="password" id="passwordInput" required>
                            </div>
                            <div>
                                <button class="qw-red-button" type="submit">Login</button>
                            </div>

                            <div>
                                <a href="ForgetPasswordPage.php">Forget password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>