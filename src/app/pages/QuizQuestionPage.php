<?php
require_once '../models/Quiz.php';
require_once '../models/Answer.php';
require_once '../models/Question.php';
require_once '../controllers/APIController.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieving the current question nr from params
$questionNr = null;
if (isset($_GET['nr'])) {
    $questionNr = intval($_GET['nr']);
}

// Retrieving the result for previous question to calculate the current score
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

// retrieving currentQuestion from quiz based on query params
$currentQuestion = $quiz->getQuestions()[$questionNr - 1];
if ($questionNr > 1 && $isAnswerCorrect === 1) {
    $quiz->getQuestions()[$questionNr - 2]->setSolvedCorrectly(true);
    //$quiz->addPoints($quiz->getQuestions()[$questionNr - 2]->getQuestionDifficulty());
    // updating quiz in session
    $apiController->updateQuizInSession($quiz);
}
$currentPoints = $quiz->getCurrentPoints();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
    <link rel="stylesheet" href="../../assets/css/QuizQuestionsStyles.css">

</head>
<body>
<?php require_once '../components/HeaderComponent.php'; ?>
<div class="container">
    <!-- Progress bar container -->
    <div class="qw-progress-container">
        <div class="d-flex align-items-center justify-content-center">
            <?php echo $questionNr ?> / 10
        </div>
        <div class="progress">
            <div class="progress-bar qw-progress-bar" style="width: <?php echo $questionNr * 10 ?>%" role="progressbar"
                 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <div class="qw-question-container">
        <!-- Question Block -->
        <div class="qw-question container-fluid">
            <?php echo $currentQuestion->getQuestionText() ?>
        </div>
        <!-- Answer block -->
        <div class="qw-options-container">
            <?php

            $answers = $currentQuestion->getAnswers();

            for ($i = 0; $i < count($answers); $i += 2) {
                echo '<div class="row qw-option-row">';
                for ($j = $i; $j < min($i + 2, count($answers)); $j++) {
                    $answer = $answers[$j];
                    echo '<div class="qw-option col" onClick="selectAnswer(this)" data-correct="' . $answer->isCorrectAnswer() . '">' . $answer->getAnswerText() . '</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- button and score blocks -->
    <div class="qw-question-score-container d-flex justify-content-between">
        <div class="qw-score d-flex align-items-center justify-content-center">
            <span>Current Score: <span class="badge bg-danger"><?php echo $currentPoints ?></span></span>
        </div>

        <div class="qw-button-container d-flex align-items-center justify-content-center">
            <button onclick="evaluate_solution(this)" class="qw-red-button">Check</button>
            <button id="next-question-btn" onclick="go_to_next_question()" style="display:none;" class="qw-red-button">
                Next
            </button>
        </div>
    </div>
    <br>
    <div id="solution-alert" class="alert alert-warning" style="display: none">
        Please select a answer before submitting the answer!
    </div>

</div>
<script>
    // add styling when answer is selected, which will be used for evaluating the answer
    function selectAnswer(curr_element) {
        let elements = document.getElementsByClassName("qw-option");
        for (let i = 0; elements.length > i; i++) {
            // To prevent clicking after evaluation.
            if (elements[i].dataset.evaluated === 'true') {
                break;
            }
            if (curr_element.textContent === elements[i].textContent) {
                elements[i].classList.add("qw-option-selected");
            } else {
                elements[i].classList.remove("qw-option-selected");
            }
        }
    }

    // evaluate solution
    function evaluate_solution(btn_elm) {
        let sel_elm = document.getElementsByClassName("qw-option-selected");
        let is_correct = false;
        if (sel_elm && sel_elm[0]) {
            if (sel_elm[0].dataset.correct === "1") {
                sel_elm[0].classList.add('qw-option-correct');
                is_correct = true;
            } else {
                sel_elm[0].classList.add('qw-option-wrong');
            }
            // Find and highlight the correct answer, if the user selected it wrong
            let options = document.getElementsByClassName("qw-option");
            for (let i = 0; i < options.length; i++) {
                if (!is_correct && options[i].dataset.correct === "1") {
                    options[i].classList.add('qw-option-correct-border');
                }
                // Set the evaluated attribute for all options
                options[i].dataset.evaluated = "true";
                options[i].dataset.isCorrect = is_correct.toString();
            }
            // hiding check button and showing next button
            btn_elm.style.display = "none";
            document.getElementById('next-question-btn').style.display = 'block';
            document.getElementById('solution-alert').style.display = 'none';
        } else {
            document.getElementById('solution-alert').style.display = 'block';
        }
    }

    // navigating to next question
    function go_to_next_question() {
        var urlParams = new URLSearchParams(window.location.search);
        var quizNr = parseInt(urlParams.get('nr')) || 1; // Default to 1 if nr is not present or not a valid number

        // Increment the quiz number
        quizNr++;

        // setting header params score
        // if the user evaluates correctly then the score = 1 otherwise score = 0
        let is_correct = 0;
        let option = document.getElementsByClassName("qw-option")[0];
        if (option.dataset.isCorrect === 'true') {
            is_correct = 1
        }

        // If the quiz number reaches 11, reset it to 1
        if (quizNr > 10) {
            // adding score params in scorePage to calculate the last question result
            window.location.href = 'ScorePage.php?score=' + is_correct;
        } else {
            // Reload the page with the updated quiz number
            window.location.href = 'QuizQuestionPage.php?nr=' + quizNr + '&score=' + is_correct;
        }
    }
</script>

<?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>




