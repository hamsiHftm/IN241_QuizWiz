<?php
// retrieving the playingMode from Quiz-Object to hide the impressum Link
$isPlaying = false;
if (isset($_SESSION['quiz'])) {
    $quiz = $_SESSION['quiz'];
    if ($quiz instanceof Quiz) {
        $isPlaying = $quiz->getPlayingMode();
    }
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

