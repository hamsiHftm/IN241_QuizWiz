<?php
require_once '../models/Quiz.php';
require_once '../models/Answer.php';
require_once '../models/Question.php';
session_start();

// TODO track user selected answer
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
                <div class="progress-bar" style="width: <?php echo $questionNr*10 ?>%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
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

            <div class="qw-button-container d-flex align-items-center justify-content-center">
                <button onclick="evaluate_solution(this)" class="qw-red-button">Check</button>
            </div>
            <br>
            <div id="solution-alert" class="alert alert-warning" style="display: none">
                Please select a answer before submitting the answer!
            </div>

            <div class="qw-button-container d-flex align-items-center justify-content-center">
                <button id="next-question-btn" style="display: none" onclick="go_to_next_question()"  class="qw-red-button">Next</button>
            </div>

        </div>
    </div>
    <script>
        // add styling when a answer is selected
        function selectAnswer(curr_element) {
            let elements = document.getElementsByClassName("qw-option");
            for(let i = 0; elements.length > i; i++) {
                if (curr_element.textContent === elements[i].textContent) {
                    elements[i].classList.add("qw-option-selected");
                } else {
                    elements[i].classList.remove("qw-option-selected");
                }
            }
        }

        // evaluate solution
        function evaluate_solution(btn_elm) {
            // let elements = document.getElementsByClassName("qw-option");
            // for(let i = 0; elements.length > i; i++) {
            //     let curr_element = elements[i];
            //     if (curr_element.classList.contains("qw-option-selected")) {
            //         if (curr_element[0].dataset.correct === "1") {
            //             curr_element.classList.add('qw-option-correct');
            //         } else {
            //
            //         }
            //     }
            // }

            // Todo prevent from clickable
            let sel_elm = document.getElementsByClassName("qw-option-selected");
            if (sel_elm && sel_elm[0]) {
                if (sel_elm[0].dataset.correct === "1") {
                    sel_elm[0].classList.add('qw-option-correct');
                } else {
                    sel_elm[0].classList.add('qw-option-wrong');
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
                window.location.href = 'score.php';
            } else {
                // Reload the page with the updated quiz number
                window.location.href = 'QuizQuestionPage.php?nr=' + quizNr;
            }
        }
    </script>

    <?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>




