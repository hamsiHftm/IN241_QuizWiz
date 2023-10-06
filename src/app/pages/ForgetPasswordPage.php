<?php
require_once '../controllers/DBController.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Login button action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"])) {
    // Retrieve user-entered values
    $username = $_POST["username"];
    $newPassword = $_POST["newPassword"];
    $repeatNewPassword = $_POST["repeatNewPassword"];

    // checking if newPassword and repeatPassword are equal
    if ($newPassword == $repeatNewPassword) {
        // changing password in DB
        $dbController = new DBController();
        $result = $dbController->changePasswordWithoutVerification($username, $newPassword);
        echo "<script>alert('" . $result['message'] . "');</script>";

        if ($result['success']) {
            // redirecting to Login page
            echo "<script>window.location.href = 'LoginPage.php'</script>";
        }
    } else {
        echo "<script>alert('Password does not match');</script>";
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
                        <a class="qw-red-button" href="LoginPage.php">Back</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="qw-card-layout d-flex align-items-center justify-content-center">
                    <div style="width: 90%; height: 80%">
                        <h2>Reset Password</h2>
                        <form class="qw-form col d-flex flex-column justify-content-between" method="POST" action="ForgetPasswordPage.php">
                            <div class="form-group">
                                <label for="usernameInput">Username / Email *</label>
                                <input type="text" class="form-control qw-form-text-box" name="username" id="usernameInput" required>
                            </div>

                            <div class="form-group">
                                <label for="passwordInput">Password *</label>
                                <input type="password" class="form-control  qw-form-text-box" name="newPassword" id="passwordInput" required>
                            </div>
                            <div class="form-group">
                                <label for="repeatPasswordInput">Repeat Password *</label>
                                <input type="password" class="form-control  qw-form-text-box" name="repeatNewPassword" id="repeatPasswordInput" required>
                            </div>
                            <div>
                                <button class="qw-red-button" type="submit">Reset Password</button>
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