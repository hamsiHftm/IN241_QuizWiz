<?php
require_once '../models/Quiz.php';
require_once '../models/Category.php';
require_once '../models/Question.php';
require_once '../controllers/DBController.php';
require_once '../controllers/AuthController.php';

session_start();

// Retrieving current user
$user = AuthController::getUser();

// Retrieving the result for last question to calculate the  score
$isAnswerCorrect = 0;
if (isset($_GET['score'])) {
    $isAnswerCorrect = intval($_GET['score']);
}

$quiz = null;
// Check if the quiz object exists in the session and retrieving quiz from the session
if (isset($_SESSION['quiz'])) {
    $quiz = $_SESSION['quiz'];

    if ($quiz instanceof Quiz) {
        // calculating score for last question
        if ($isAnswerCorrect === 1) {
            $quiz->addPoints($quiz->getQuestions()[9]->getQuestionDifficulty());
            $quiz->setPlayingMode(false);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbController = new DBController();

    $success = $dbController->saveQuizResult($quiz, $user);
    if ($success) {
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
                <span>Category: <strong><?php echo $quiz->getCategory()->getName(); ?></strong></span>
            </div>
            <div>
                <span>Difficulty: <strong><?php echo $quiz->getDifficulty(); ?></strong></span>
            </div>
            <div>
                <span>Total Points: <strong><?php echo $quiz->getCurrentPoints(); ?></strong></span>
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


