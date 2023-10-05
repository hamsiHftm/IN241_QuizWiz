<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
</head>
<body>
<?php require_once '../components/HeaderComponent.php'; ?>
<div class="container-sm">
    <div class="qw-content d-flex justify-content-center">
        <div class="text-center">
            <h1>Sorry! Something went wrong!</h1>
            <br>
            <p>An issue has arisen, preventing the retrieval of information from the database or API, and we are
                actively investigating the situation to identify and resolve any other underlying problems.</p>
            <p>Please retry your request, or consider exploring alternative functionalities for the time being. </p>
            <p>Rest assured, our dedicated team is committed to rectifying these issues as swiftly as possible to ensure
                a seamless user experience. </p>
            <p>We sincerely appreciate your understanding and patience during this period. Thank you for your continued
                support.</p>
        </div>
    </div>
</div>
<?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>
