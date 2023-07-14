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
                <h1>About us</h1>
                <p>Quiz Wiz is a website created as part of a school project by two passionate software developers <strong>Kavi Kanagalingam</strong> and <strong>Hamsiga Rajaratnam</strong>. Our journey began with a simple idea and a shared love for quizzing.</p>

                <p>For an engaging and diverse collection of questions, we rely on the <a href="https://opentdb.com" target="_blank">Open Trivia DB</a>, an open API that provides a vast array of quiz questions. These questions form the backbone of our quizzes, ensuring a challenging and stimulating experience for our users. </p>
                <p>In addition to the Open Trivia DB, we have developed our own Quiz Wiz database to manage user information and provide a personalized experience. As software development students at a higher technical college, we are dedicated to honing our skills and delivering a high-quality quiz platform.</p>

                <p>Join us on this exciting journey of knowledge and fun!</p>
            </div>
        </div>
    </div>
    <?php include '../app/templates/footer.php'; ?>
</body>
</html>
