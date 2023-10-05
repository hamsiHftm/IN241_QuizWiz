<?php
require_once '../controllers/AuthController.php';
require_once '../controllers/DBController.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// retrieving user and other information
$dbController = new DBController();
$user = $dbController->updateUserQuizInfos(AuthController::getUser());

$highScore = $user->getScoredHighScore();
$nrOfPlayedGames = $user->getNrOfPlayedGames();
$dateOfBirth = $user->getDateOfBirth();

$records = $dbController->getQuizRecordsFromUser($user->getDBId());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
    <link rel="stylesheet" href="../../assets/css/LoginAndRegistrationStyle.css">
</head>
<body>
<?php require_once '../components/HeaderComponent.php'; ?>
<div class="container-sm">
    <div class="qw-content">
        <div>
            <h1>Hi <?php echo $user->getFirstname() . ' ' . $user->getLastname()?>!</h1>
            <hr class="my-4">
            <p>Your best score: <strong><?php echo $highScore ?></strong></p>
            <p>Number of played games: <strong><?php echo $nrOfPlayedGames ?></strong></p>
        </div>
            <div class="row">
                <div class="col">
                    <form class="qw-form col d-flex flex-column justify-content-between" method="POST" action="SaveUserInfoProfilePage.php">
                        <div class="form-group">
                            <label for="firstnameInput">Firstname</label>
                            <input type="text" class="form-control" id="firstnameInput" name="firstname" value="<?php echo $user->getFirstname()?>">
                        </div>
                        <div class="form-group">
                            <label for="lastnameInput">Lastname</label>
                            <input type="text" class="form-control" id="lastnameInput" name="lastname" value="<?php echo $user->getLastname()?>">
                        </div>
                        <div class="form-group">
                            <label for="dateOfBirthInput">Password</label>
                            <input type="date" class="form-control" name="dateOfBirth" id="dateOfBirthInput" <?php if (!is_null($dateOfBirth)) echo 'value="' . date('Y-m-d', strtotime($dateOfBirth)) . '"'; ?>>                        </div>
                        <div>
                            <button class="qw-red-button" type="submit">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col">
                    <form class="qw-form col d-flex flex-column justify-content-between" method="POST" action="ChangePasswordProfilePage.php">

                        <div class="form-group">
                            <label for="oldPasswordInput">Old password</label>
                            <input type="password" class="form-control" id="oldPasswordInput" name="oldPassword" required>
                        </div>
                        <div class="form-group">
                            <label for="newPasswordInput">New password</label>
                            <input type="password" class="form-control" id="newPasswordInput" name="newPassword" required>
                        </div>
                        <div class="form-group">
                            <label for="repeatNewPasswordInput">Repeat new password</label>
                            <input type="password" class="form-control" name="repeatNewPassword" id="repeatNewPasswordInput" required>
                        </div>
                        <div>
                            <button class="qw-red-button" type="submit">Change password</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <h3>Played games</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Category</th>
                        <th scope="col">Difficulty</th>
                        <th scope="col">Total Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $counter = 1;
                    foreach ($records as $record) {
                        echo '<tr>';
                        echo '<th scope="row">' . $counter . '</th>';
                        echo '<td>' . htmlspecialchars($record['category_name']) . '</td>';
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


