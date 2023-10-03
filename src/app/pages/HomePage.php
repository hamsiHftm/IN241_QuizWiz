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
                    require_once '../controllers/LocalStorageController.php';
                    $array_user = LocalStorageController::parseData(LocalStorageController::LOGGED_USER_DATA);

                    if ($array_user !== null && array_key_exists("id", $array_user)) {
                        echo '<a class="qw-red-button" href="quiz_start.php">Take Quiz!</a>';
                    }
                ?>
            </div>
        </div>
    </div>
    <?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>

<script>
    var localStorageData = localStorage.getItem('<?php echo $array_user; ?>');
    // Use AJAX to send the data to the server-side PHP script
    $.ajax({
        type: 'POST',
        url: 'process_localstorage.php', // Replace with the actual path to your PHP script
        data: { localStorageData: localStorageData },
        success: function(response) {
            console.log(response);
        }
    });
</script>

