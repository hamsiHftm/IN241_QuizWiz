<!-- Not in use
difference is there is alert, when a user is failed
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
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
                        <a class="qw-red-button" href="RegisterPage.php">Register</a>
                    </div>
                </div>
            </div>
            <div class="col-6" style="padding: 2em">
                <h2>LOGIN</h2>
                <form class="qw-form col d-flex flex-column justify-content-between" method="POST" action="LoginPage.php">

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
                        <a href="ForgetPasswordPage.php">Forget password?</a>
                    </div>
                </form>

                <?php
                require '../controllers/AuthController.php';

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"])) {
                    echo '
                        <script>
                            let error_elm = document.getElementById("error-alert");
                            if (error_elm) {
                                error_elm.remove();
                            }
                        </script>
                        ';
                    // Retrieve user-entered values
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    $user = AuthController::loginUser($username, $password);
                    var_dump(AuthController::getUser());
                    if ($user) {
                        echo "<script>
                       console.log('User logged-in successfully.');
                       //
                      window.location.href = 'HomePage.php';
                    </script>";
                    } else {
                        echo "<script>console.log('Login failed.');</script>";
                        echo '
                                <div id="error-alert" class="alert alert-danger d-flex align-items-center" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>
  <div>Login failed</div></div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>