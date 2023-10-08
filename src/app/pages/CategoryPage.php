<?php
require_once '../controllers/AuthController.php';
require_once '../controllers/APIController.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// deleting Quiz Session, when available
$apiController = new APIController();
$apiController->deleteQuizFromSession();

// retrieving top 10 scored high scores
$categoryDetails = $apiController->getCategoriesWithDetails();
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
            <h1>Categories</h1>
            <p> Explore our diverse range of categories, each brimming with a wide variety of intriguing questions and challenges to test your knowledge and skills.</p>
        </div>
        <div>
            <?php
            if (!(empty($categoryDetails))) {
                echo '<table class="table"><thead><tr>';
                echo '<th class="text-center" scope="col">ID</th>';
                echo '<th class="text-start" scope="col">Name</th>';
                echo '<th class="text-start" scope="col">Total questions</th>';
                echo '<th class="text-center" scope="col">Total questions in easy</th>';
                echo '<th class="text-center" scope="col">Total questions in medium</th>';
                echo '<th class="text-center" scope="col">Total questions in hard</th>';
                echo '</tr></thead><tbody>';

                $counter = 1;
                foreach ($categoryDetails as $detail) {
                    echo '<tr>';
                    echo '<th class="text-center" scope="row">' . $counter . '</th>';
                    echo '<td class="text-start">' . htmlspecialchars($detail['name']) . '</td>';
                    echo '<td class="text-start">' . htmlspecialchars($detail['total_question_count']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($detail['total_easy_question_count']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($detail['total_medium_question_count']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($detail['total_hard_question_count']) . '</td>';
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


