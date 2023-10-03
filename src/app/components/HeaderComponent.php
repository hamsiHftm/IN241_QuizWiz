<?php
require_once '../controllers/AuthController.php';
$user = AuthController::getUser();
?>

<header class="qw-header qw-blue-container">
    <nav class="navbar navbar-expand-lg">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="../pages/HomePage.php">
            <img style="width: 150px" src="../../assets/img/quiz-wiz-logo-with-slogan.png" alt="QuizWiz"/>
        </a>

        <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
            <ul class="navbar-nav">
                <?php
                if ($user !== null) {
                    echo '<li class="nav-item active">
                    <a class="header-link" href="../pages/QuizStartPage.php">Quiz</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="header-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">' .
                        $user->getUsername()
                    .'</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../pages/ProfilePage.php">My Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../pages/LogOutPage.php">Logout</a>
                    </div>
                </li>';
                }
                ?>
                <li class="nav-item">
                    <a class="header-link" href="../pages/AboutUsPage.php">About us</a>
                </li>

                <?php
                if ($user === null) {
                    echo ' <li class="nav-item active">
                    <a class="header-link" href="../pages/RegisterPage.php">Register</a>
                </li>
                <li class="nav-item active">
                    <a class="header-link" href="../pages/LoginPage.php">Login</a>
                </li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>