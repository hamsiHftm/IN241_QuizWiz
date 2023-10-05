<?php
require_once '../controllers/APIController.php';

// retrieving the playingMode from Quiz-Object to hide the navigation-bar
$apiController = new APIController();
$quiz = $apiController->retrievingQuizFromSession();
$isPlaying = false;
if ($quiz) {
    $isPlaying = $quiz->getPlayingMode();
}

?>

<footer class="d-flex flex-wrap justify-content-between align-items-center mt-auto qw-footer qw-blue-container">
    <div class="col-md-4 d-flex align-items-center">
        <span>© 2023 Quiz Wiz</span>
    </div>
    <div>
        <?php
        if (!$isPlaying) {
            echo '<a class="footer-link" href="../pages/ImpressumPage.php">Impressum</a>';
        }
        ?>
    </div>
</footer>

