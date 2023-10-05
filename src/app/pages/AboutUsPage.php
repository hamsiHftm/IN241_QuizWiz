<?php
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
                <h1>About us</h1>
                <p>Quiz Wiz is a website created as part of a school project by two passionate software developers <strong>Kavi Kanagalingam</strong> and <strong>Hamsiga Rajaratnam</strong>. Our journey began with a simple idea and a shared love for quizzing.</p>

                <p>For an engaging and diverse collection of questions, we rely on the <a href="https://opentdb.com" target="_blank">Open Trivia DB</a>, an open API that provides a vast array of quiz questions. These questions form the backbone of our quizzes, ensuring a challenging and stimulating experience for our users. </p>
                <p>In addition to the Open Trivia DB, we have developed our own Quiz Wiz database to manage user information and provide a personalized experience. As software development students at a higher technical college, we are dedicated to honing our skills and delivering a high-quality quiz platform.</p>

                <p>Join us on this exciting journey of knowledge and fun!</p>
            </div>
        </div>
    </div>
    <?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>
