<?php
require_once '../app/models/Quiz.php';
require_once '../app/models/Answer.php';
require_once '../app/models/Question.php';
session_start();

// Get the value of param1 from the query parameter
$questionNr = null;
if (isset($_GET['nr'])) {
    $questionNr = intval($_GET['nr']);
}

$currentQuestion = null;
// Check if the quiz object exists in the session
if (isset($_SESSION['quiz'])) {
    $quiz = $_SESSION['quiz'];

    if ($quiz instanceof Quiz) {
        $currentQuestion = $quiz->getQuestions()[$questionNr - 1];
    }
}

if ($questionNr == 10) {
    if (isset($_SESSION['quiz'])) {
        unset($_SESSION['quiz']);
    }
}
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
    <div class="container">
        <div class="qw-question-container">
            <div class="progress">
                <div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <div class="qw-question">
                <?php echo $currentQuestion->getQuestionText() ?>
            </div>
            <div class="container qw-options-container">
                <div class="row row-cols-2">
                <?php
                foreach ($currentQuestion->getAnswers() as $answer) {
                    echo '<div class="qw-option">' . $answer->getAnswerText() . '</div>';
                }
                ?>
                </div>
            </div>
            <button class="qw-red-button">Submit</button>
        </div>

    </div>
</body>
</html>

