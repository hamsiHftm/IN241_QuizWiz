<?php
     require_once '../controllers/AuthController.php';
     require_once '../controllers/DBController.php';
    // Start the session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

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
                <p> Get ready to challenge your mind and expand your knowledge with our exciting quizzes. Start quizzing now and unlock your intellectual potential!</p>

                <?php
                    if (AuthController::isLoggedIn()) {
                        echo '<a class="qw-red-button" href="QuizStartPage.php">Take Quiz!</a>';
                    }
                ?>
            </div>
            <br>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Category</th>
                        <th scope="col">Difficulty</th>
                        <th scope="col">Total Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $counter = 1;
                    foreach ($topQuizRecords as $record) {
                        echo '<tr>';
                        echo '<th scope="row">' . $counter . '</th>';
                        echo '<td>' . htmlspecialchars($record['username']) . '</td>';
                        echo '<td>' . htmlspecialchars($record['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($record['difficulty']) . '</td>';
                        echo '<td>' . htmlspecialchars($record['total_score']) . '</td>';
                        echo '</tr>';
                        $counter++;
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>


