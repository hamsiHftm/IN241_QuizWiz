<!DOCTYPE html>
<html>
<head>
    <?php require_once 'app/components/HeadComponent.php'?>
    <link rel="stylesheet" href="assets/css/LandingPageStyle.css">
</head>
<body>
<!-- TODO maybe combine landing page and home page -->
<!-- TODO add navigation URL controller -> when something wrong url redirect to error page, and change the url path in the header -->
<div class="container-fluid landing-page-container">
    <div class="row landing-page-container">
        <div class="col-5">
            <div class="landing-page-container d-flex align-items-center justify-content-center">
                <img class="landing-page-logo" src="assets/img/quiz-wiz-logo-with-slogan.jpg">
            </div>
        </div>
        <div class="col-7 qw-blue-container">
            <div class="landing-page-container d-flex align-items-center justify-content-center">
                <div class="inner-container align-items-center justify-content-center">
                    <p>
                        "Unleash your inner quiz champion and embark on an exhilarating journey of knowledge. Join Quiz Wiz today and let your curiosity guide you to new horizons through the excitement of quizzing!"
                    </p>
                    <a class="qw-red-button" href="app/pages/HomePage.php">Get Started!</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>