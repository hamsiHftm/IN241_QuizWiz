<?php
require_once '../models/Quiz.php';
require_once '../models/Category.php';
require_once '../models/Question.php';
require_once '../controllers/DBController.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/APIController.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieving current user
$user = AuthController::getUser();

// Retrieving the result for last question to calculate the  score
$isAnswerCorrect = 0;
if (isset($_GET['score'])) {
    $isAnswerCorrect = intval($_GET['score']);
}

// retrieving quiz from session
$apiController = new APIController();
$quiz = $apiController->retrievingQuizFromSession();

// if quiz is null, then displaying error page
if ($quiz === null or !($quiz instanceof Quiz)) {
    echo "<script>window.location.href = 'ErrorPage.php';</script>";
}

// calculating score for last question
if ($isAnswerCorrect === 1) {
    $quiz->getQuestions()[9]->setSolvedCorrectly(true);
    $quiz->setPlayingMode(false);
    $apiController->updateQuizInSession($quiz);
}

// retrieving attribute
$categoryName = $quiz->getCategory()->getName();
$difficulty = $quiz->getDifficulty()->value;
$points = $quiz->getCurrentPoints();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbController = new DBController();

    $success = $dbController->saveQuizResult($quiz, $user);
    if ($success) {

        $apiController->deleteQuizFromSession();
        echo "<script>
                       console.log('Quiz Result Saved!!!');
                        window.location.href = 'HomePage.php';
                    </script>";
    } else {
        echo "<script>alert('Quiz Result cannot be saved');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
    <link rel="stylesheet" href="../../assets/css/ScoreBoardStyle.css">
</head>
<body>
<?php require_once '../components/HeaderComponent.php'; ?>
<div class="container-sm d-flex justify-content-center align-items-center">
    <div class="qw-score-card">
        <div>
            <div class="text-center">
                <h1>SCOREBOARD</h1>
            </div>
            <hr class="m-4">
            <div class="qw-score-board-list d-flex justify-content-center">
                <div>
                    <div><p>Category: &#160;<strong><?php echo $categoryName; ?></strong></p></div>
                    <div><p>Difficulty: &#160;<strong><?php echo $difficulty; ?></strong></p></div>
                    <div><p>Total Points: &#160;<strong><?php echo $points; ?></strong></p></div>
                </div>
            </div>
            <hr class="m-4">
            <form class="qw-form col d-flex flex-column justify-content-between" method="POST" action="ScorePage.php">
                <div class="d-flex justify-content-evenly">
                    <button class="qw-red-button" type="submit">Save result</button>
                    <a class="qw-red-button" href="HomePage.php">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>


