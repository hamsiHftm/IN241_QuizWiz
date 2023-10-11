<?php
require_once '../controllers/AuthController.php';
require_once '../controllers/DBController.php';
require_once '../controllers/APIController.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// deleting Quiz Session, when available
$apiController = new APIController();
$apiController->deleteQuizFromSession();

// retrieving top 10 scored high scores
$dbController = new DBController();
$topQuizRecords = $dbController->getTopScoredQuizRecords();
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
            <h1>Welcome to Quiz Wiz!</h1>
            <p> Get ready to challenge your mind and expand your knowledge with our exciting quizzes. Start quizzing now
                and unlock your intellectual potential!</p>
        </div>

        <?php
        if (AuthController::isLoggedIn()) {
            echo '<br><div><a class="qw-red-button" href="QuizStartPage.php">Take Quiz!</a></div><br><br>';
        }
        ?>
        <div>
            <?php
            if (!(empty($topQuizRecords))) {
                echo '<p>Below is a list of the top <strong>10</strong> players based on their scores:</p>';
                echo '<table class="table"><thead><tr>';
                echo '<th class="text-center" scope="col">ID</th>';
                echo '<th class="text-start" scope="col">Username</th>';
                echo '<th class="text-start" scope="col">Category</th>';
                echo '<th class="text-center" scope="col">Difficulty</th>';
                echo '<th class="text-center" scope="col">Total Score</th>';
                echo '</tr></thead><tbody>';

                $counter = 1;
                foreach ($topQuizRecords as $record) {
                    echo '<tr>';
                    echo '<th class="text-center" scope="row">' . $counter . '</th>';
                    echo '<td class="text-start">' . htmlspecialchars($record['username']) . '</td>';
                    echo '<td class="text-start">' . htmlspecialchars($record['name']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($record['difficulty']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($record['total_score']) . '</td>';
                    echo '</tr>';
                    $counter++;
                }
            }
            echo '</tbody></table>'
            ?>
        </div>
    </div>
</div>
<?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>


