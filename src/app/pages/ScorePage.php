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
    $quiz->addPoints($quiz->getQuestions()[9]->getQuestionDifficulty());
    $quiz->setPlayingMode(false);
}

// retrieving attribute
$categoryName = $quiz->getCategory()->getName();
$difficulty = $quiz->getDifficulty()->value;
$points = $quiz->getCurrentPoints();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbController = new DBController();

    $success = $dbController->saveQuizResult($quiz, $user);
    if ($success) {

        // deleting quiz instance, when quiz result saved
        if (isset($_SESSION['quiz'])) {
            unset($_SESSION['quiz']); // This line removes the 'quiz' session variable
        }
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
</head>
<body>
<?php require_once '../components/HeaderComponent.php'; ?>
<div class="container-sm">
    <div class="qw-content">
        <div>
            <h1>Scoreboard</h1>
            <div>
                <span>Category: <strong><?php echo $categoryName; ?></strong></span>
            </div>
            <div>
                <span>Difficulty: <strong><?php echo $difficulty ?></strong></span>
            </div>
            <div>
                <span>Total Points: <strong><?php echo $points ?></strong></span>
            </div>

            <form class="qw-form col d-flex flex-column justify-content-between" method="POST" action="ScorePage.php">
                <div>
                    <button class="qw-red-button" type="submit">Save result</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>


