<!DOCTYPE html>
<html>
<head>
    <title>QuizWiz</title>
    <link rel="icon" href="app/assets/img/logo_icon.svg">
    <!-- Adding bootstrap library -->
    <link rel="stylesheet" href="app/assets/bootstrap/css/bootstrap.css">
    <script src="app/assets/bootstrap/js/bootstrap.js"></script>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="app/assets/css/quizWiz.css">
    <!-- added google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
</head>
<body>

<div class="container-fluid landing-page-container">
    <div class="row landing-page-container">
        <div class="col-5">
            <div class="landing-page-container d-flex align-items-center justify-content-center">
                <img class="landing-page-logo" src="app/assets/img/quiz-wiz-logo-with-slogan.jpg">
            </div>
        </div>
        <div class="col-7 qw-blue-container">
            <div class="landing-page-container d-flex align-items-center justify-content-center">
                <div class="inner-container align-items-center justify-content-center">
                    <p>
                        "Unleash your inner quiz champion and embark on an exhilarating journey of knowledge. Join Quiz Wiz today and let your curiosity guide you to new horizons through the excitement of quizzing!"
                    </p>
                    <form action="pages/quiz_start_page.php" method="get">
                        <button type="submit" class="qw-red-button">
                            Get Started!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>