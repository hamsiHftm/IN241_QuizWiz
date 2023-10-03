<!DOCTYPE html>
<html>
<head>
    <?php require_once '../components/HeadComponent.php' ?>
    <link rel="stylesheet" href="../../assets/css/LoginAndRegistrationStyle.css">
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
                    <!-- TODO check and notify if already user exits -->

                    <?php
                    require_once '../controllers/AuthController.php';

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["username"])) {
                        echo '
                        <script>
                            let warn_elm = document.getElementById("warn-alert");
                            if (warn_elm) {
                                warn_elm.remove();
                            }
                            let success_elm = document.getElementById("success-alert");
                            if (success_elm) {
                                success_elm.remove();
                            }
                            let error_elm = document.getElementById("error-alert");
                            if (error_elm) {
                                error_elm.remove();
                            }
                        </script>
                        ';
                        // Retrieve user-entered values
                        $firstname = $_POST["firstname"];
                        $lastname = $_POST["lastname"];
                        $dateOfBirth = $_POST["dateOfBirth"];
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $repeatPassword = $_POST["repeatPassword"];

                        // Check if passwords match
                        if ($password !== $repeatPassword) {
                            echo '
                                <div id="warn-alert" class="alert alert-warning d-flex align-items-center" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>
  <div>Password do not match</div></div>';
                        } else {
                            // Passwords match, continue processing
                            $result = AuthController::registerUser($username, $password, $firstname, $lastname, $dateOfBirth);
                            if ($result) {
                                echo "<script>console.log('User registered successfully.');</script>";
                                echo '
                                <div id="success-alert" class="alert alert-success d-flex align-items-center" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>
  <div>User registered successfully</div></div>';
                            } else {
                                echo "<script>console.log('User registration failed.');</script>";
                                echo '
                                <div id="error-alert" class="alert alert-danger d-flex align-items-center" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>
  <div>User registeration failed</div></div>';
                            }
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

