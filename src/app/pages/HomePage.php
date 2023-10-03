<?php
     require_once '../controllers/AuthController.php';
    // Start the session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
</head>
<body>
    <?php require_once '../components/HeaderComponent.php'; ?>
    <div class="container-sm">
        <div class="qw-content">
            <div>
                <h1>Welcome to Quiz Wiz!</h1>
                <p> Get ready to challenge your mind and expand your knowledge with our exciting quizzes. Start quizzing now and unlock your intellectual potential!</p>

                <?php
                    if (AuthController::isLoggedIn()) {
                        echo '<a class="qw-red-button" href="QuizStartPage.php">Take Quiz!</a>';
                    }
                ?>
            </div>
        </div>
    </div>
    <?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>


