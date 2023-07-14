<?php
    $isLogged = $GLOBALS['IS_USER_LOGGED'];
?>
<header class="qw-header qw-blue-container">
    <nav class="navbar navbar-expand-lg">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img src="<?php echo $_SERVER['DOCUMENT_ROOT'] . '/app/assets/img/quiz_wiz_logo.svg'; ?>" alt="QuizWiz"/>
        </a>

        <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo03">
            <ul class="navbar-nav">
                <?php
                    if ($GLOBALS['IS_USER_LOGGED']) {
                        echo '<li class="nav-item active">
                    <a class="header-link" href="/pages/quiz_start.php">Quiz</a>
                </li>';
                    }
                ?>

                <li class="nav-item">
                    <a class="header-link" href="/pages/about_us.php">About us</a>
                </li>

                <?php
                if (!$GLOBALS['IS_USER_LOGGED']) {
                    echo '<li class="nav-item active">
                    <a class="header-link" href="#">Register</a>
                </li>';

                    echo '<li class="nav-item active">
                    <a class="header-link" href="#">Login</a>
                </li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>