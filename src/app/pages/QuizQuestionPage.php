<?php
require_once '../models/Quiz.php';
require_once '../models/Answer.php';
require_once '../models/Question.php';
session_start();

// TODO prvent from going back
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
                <div class="progress-bar qw-progress-bar" style="width: <?php echo $questionNr*10 ?>%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div class="qw-question-container">
            <!-- Question Block -->
            <div class="qw-question container-fluid">
                <?php echo $currentQuestion->getQuestionText() ?>
            </div>
            <!-- Answer block -->
            <div class="container qw-options-container">
                <div class="row row-cols-2">
                <?php

                foreach ($currentQuestion->getAnswers() as $answer) {
                    echo '<div class="qw-option" onClick="selectAnswer(this)" data-correct="'. $answer->isCorrectAnswer() . '">' . $answer->getAnswerText() . '</div>';
                }
                ?>
                </div>
            </div>
        </div>

        <div class="qw-question-score-container d-flex justify-content-between">
            <div class="qw-score d-flex align-items-center justify-content-center">
                <span>Current Score: <strong>9870</strong></span>
            </div>

            <div class="qw-button-container d-flex align-items-center justify-content-center">
                <button onclick="evaluate_solution(this)" class="qw-red-button">Check</button>
                <button id="next-question-btn" onclick="go_to_next_question()" style="display:none;" class="qw-red-button">Next</button>
            </div>
        </div>
        <br>
        <div id="solution-alert" class="alert alert-warning" style="display: none">
            Please select a answer before submitting the answer!
        </div>

    </div>
    <script>
        // add styling when a answer is selected
        function selectAnswer(curr_element) {
            let elements = document.getElementsByClassName("qw-option");
            for(let i = 0; elements.length > i; i++) {
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
                // Find and highlight the correct answer
                let options = document.getElementsByClassName("qw-option");
                for (let i = 0; i < options.length; i++) {
                    if (!is_correct && options[i].dataset.correct === "1") {
                        options[i].classList.add('qw-option-correct-border');
                    }
                    // Set the evaluated attribute for all options
                    options[i].dataset.evaluated = "true";
                }
                btn_elm.style.display = "none";
                document.getElementById('next-question-btn').style.display = 'block';
                document.getElementById('solution-alert').style.display = 'none';
            } else {
                document.getElementById('solution-alert').style.display = 'block';
            }
        }

        function go_to_next_question() {
            var urlParams = new URLSearchParams(window.location.search);
            var quizNr = parseInt(urlParams.get('nr')) || 1; // Default to 1 if nr is not present or not a valid number

            // Increment the quiz number
            quizNr++;

            // If the quiz number reaches 11, reset it to 1
            if (quizNr > 10) {
                window.location.href = 'ScorePage.php';
            } else {
                // Reload the page with the updated quiz number
                window.location.href = 'QuizQuestionPage.php?nr=' + quizNr;
            }
        }
    </script>

    <?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>




