<?php
    include '../config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>QuizWiz</title>
    <link rel="icon" href="../app/assets/img/logo_icon.svg">
    <!-- Adding bootstrap library -->
    <link rel="stylesheet" href="../app/assets/bootstrap/css/bootstrap.css">
    <script src="../app/assets/bootstrap/js/bootstrap.js"></script>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="../app/assets/css/quizWiz.css">
    <!-- added google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../app/templates/header.php'; ?>
    <div class="container-sm">
        <div class="qw-content">
            <div>
                <h1>Welcome to Quiz Wiz!</h1>
                <p> Get ready to challenge your mind and expand your knowledge with our exciting quizzes. Start quizzing now and unlock your intellectual potential!</p>

                <?php
                if ($GLOBALS['IS_USER_LOGGED']) {
                    echo '<a class="qw-red-button" href="quiz_start_page.php">Take Quiz!</a>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php include '../app/templates/footer.php'; ?>
</body>
</html>
