<?php
    $isLogged = $GLOBALS['IS_USER_LOGGED'];
?>
<header class="qw-header qw-blue-container">
    <nav class="navbar navbar-expand-lg">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="../pages/home.php">
            <img style="width: 150px" src="../../assets/img/quiz-wiz-logo-with-slogan.png" alt="QuizWiz"/>
        </a>

        <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
            <ul class="navbar-nav">
                <?php
                    if ($GLOBALS['IS_USER_LOGGED']) {
                        echo '<li class="nav-item active">
                    <a class="header-link" href="../pages/quiz_start.php">Quiz</a>
                </li>';
                    }
                ?>

                <li class="nav-item">
                    <a class="header-link" href="../pages/about_us.php">About us</a>
                </li>

                <?php
                if (!$GLOBALS['IS_USER_LOGGED']) {
                    echo '<li class="nav-item active">
                    <a class="header-link" href="../pages/register.php">Register</a>
                </li>';

                    echo '<li class="nav-item active">
                    <a class="header-link" href="../pages/login.php">Login</a>
                </li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>