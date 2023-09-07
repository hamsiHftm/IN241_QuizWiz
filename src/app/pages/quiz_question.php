<?php
require_once '../models/Quiz.php';
require_once '../models/Answer.php';
require_once '../models/Question.php';
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


// Check if an "evaluate_question" button was clicked
if (isset($_POST['evaluate_question'])) {
    // Process the evaluation here if needed
    // ...

    // After processing, set a session variable to indicate an evaluation has been made
    $_SESSION['evaluation_made'] = true;

    // Redirect to the same page to show the "Next" button
    header("Location: quiz_question.php?nr=". $questionNr);
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>QuizWiz</title>
    <link rel="icon" href="../../assets/img/logo_icon.svg">
    <!-- Adding bootstrap library -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.css">
    <script src="../../assets/bootstrap/js/bootstrap.js"></script>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="../../assets/css/quizWiz.css">
    <!-- added google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="qw-progress-container">
            <div class="d-flex align-items-center justify-content-center">
                5 / 10
            </div>
            <div class="progress">
                <div class="progress-bar w-50" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

        <div class="qw-question-container">
            <div class="qw-question container-fluid">
                <?php echo $currentQuestion->getQuestionText() ?>
            </div>
            <div class="container qw-options-container">
                <div class="row row-cols-2">
                <?php
                foreach ($currentQuestion->getAnswers() as $answer) {
                    echo '<button type="submit" name="evaluate_question" value="' . $answer->getAnswerText() . '" class="qw-option">' . $answer->getAnswerText() . '</button>';
                }
                ?>
                </div>
            </div>

            <?php
            // Check if an evaluation has been made (after the form submission)
            if (isset($_SESSION['evaluation_made']) && $_SESSION['evaluation_made'] === true) {
                // Show the "Next" button after an evaluation is made
                echo '<div class="qw-button-container d-flex align-items-center justify-content-center">';
                echo '<button id="next-question-btn" type="submit" name="go_to_next_question" class="qw-red-button">Next</button>';
                echo '</div>';

                // Reset the session variable to allow showing the "Next" button again for the next question
                $_SESSION['evaluation_made'] = false;
            }
            ?>
<!--            -->
<!--            <div class="qw-button-container d-flex align-items-center justify-content-center">-->
<!--                <button type="submit" name="go_to_next_question" class="qw-red-button">Next</button>-->
<!--            </div>-->
        </div>
        <?php
        if (isset($_POST['evaluate_question'])) {
            $selectedValue = $_POST['evaluate_question'];
            // Do something with the selected value, e.g., store it in a database, perform some action, etc.
            // For this example, we'll just echo the value back as the response.
            echo $selectedValue;
        }
        ?>

    </div>
</body>
</html>




