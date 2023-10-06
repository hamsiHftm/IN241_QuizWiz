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

// assigning in variable to display in the html code
$highScore = $user->getScoredHighScore();
$nrOfPlayedGames = $user->getNrOfPlayedGames();
$dateOfBirth = $user->getDateOfBirth();

// retrieving quiz records, to display in the table
$records = $dbController->getQuizRecordsFromUser($user->getDBId());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
    <link rel="stylesheet" href="../../assets/css/ProfilePageStyle.css">
</head>
<body>
<?php require_once '../components/HeaderComponent.php'; ?>
<div class="container-sm">
    <div class="qw-content">
        <div>
            <h1>Hi <?php echo $user->getFirstname() . ' ' . $user->getLastname() ?>!</h1>
            <hr class="my-4">
            <div>
                <span>Your Highest Score: <span class="badge bg-danger"><?php echo $highScore ?></span></span> &#160;
                <span>Total Games Played: <span class="badge bg-danger"><?php echo $nrOfPlayedGames ?></span></span>
            </div>
        </div>
        <div class="row qw-profile-row">
            <div class="col">
                <div class="qw-profile-card">
                    <h4>Personal Information</h4>
                    <form class="qw-form col d-flex flex-column justify-content-between" method="POST"
                          action="SaveUserInfoProfilePage.php">
                        <div class="form-group">
                            <label for="firstnameInput">Firstname</label>
                            <input type="text" class="form-control qw-form-text-box" id="firstnameInput" name="firstname"
                                   value="<?php echo $user->getFirstname() ?>">
                        </div>
                        <div class="form-group">
                            <label for="lastnameInput">Lastname</label>
                            <input type="text" class="form-control qw-form-text-box" id="lastnameInput" name="lastname"
                                   value="<?php echo $user->getLastname() ?>">
                        </div>
                        <div class="form-group">
                            <label for="dateOfBirthInput">Password</label>
                            <input type="date" class="form-control  qw-form-text-box" name="dateOfBirth"
                                   id="dateOfBirthInput" <?php if (!is_null($dateOfBirth)) echo 'value="' . date('Y-m-d', strtotime($dateOfBirth)) . '"'; ?>>
                        </div>
                        <div>
                            <button class="qw-red-button" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col">
                <div class="qw-profile-card">
                    <h4>Password Change</h4>
                    <form class="qw-form col d-flex flex-column justify-content-between" method="POST"
                          action="ChangePasswordProfilePage.php">

                        <div class="form-group">
                            <label for="oldPasswordInput">Old password *</label>
                            <input type="password" class="form-control qw-form-text-box" id="oldPasswordInput" name="oldPassword"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="newPasswordInput">New password *</label>
                            <input type="password" class="form-control qw-form-text-box" id="newPasswordInput" name="newPassword"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="repeatNewPasswordInput">Repeat new password *</label>
                            <input type="password" class="form-control qw-form-text-box" name="repeatNewPassword"
                                   id="repeatNewPasswordInput"
                                   required>
                        </div>
                        <div>
                            <button class="qw-red-button" type="submit">Change password</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="row">
            <?php
            if (!empty($records)) {
                echo '<div class="qw-profile-card">';
                echo '<h4>Game Scores List</h4><br>';
                echo '<table class="table"><thead><tr>';
                echo '<th class="text-center" scope="col">ID</th>';
                echo '<th class="text-start" scope="col">Category</th>';
                echo '<th class="text-center" scope="col">Difficulty</th>';
                echo '<th class="text-center" scope="col">Total Score</th></tr></thead><tbody>';
                $counter = 1;
                foreach ($records as $record) {
                    echo '<tr>';
                    echo '<th class="text-center" scope="row">' . $counter . '</th>';
                    echo '<td class="text-start">' . htmlspecialchars($record['category_name']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($record['difficulty']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($record['total_score']) . '</td>';
                    echo '</tr>';
                    $counter++;
                }
                echo '</tbody></table></div>';
            }
            ?>
        </div>
    </div>
</div>
<?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>


