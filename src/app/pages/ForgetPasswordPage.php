<!-- TODO Functinality as well -->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
    <link rel="stylesheet" href="../../assets/css/LoginAndRegistrationStyle.css">
</head>
<body>
<div class="qw-card-layout d-flex align-items-center justify-content-center">
    <div class="qw-card-container">
        <div class="row qw-card-layout">
            <div class="col-6 qw-blue-container">
                <div class="qw-card-layout d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <img class="qw-card-icon-layout" src="../../assets/img/quiz_wiz_logo.svg">
                        <a class="qw-red-button" href="LoginPage.php">Back</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="qw-card-layout d-flex align-items-center justify-content-center">
                    <div style="width: 90%; height: 80%">
                        <h2>Reset Password</h2>
                        <form class="qw-form col d-flex flex-column justify-content-between">
                            <div class="form-group">
                                <label for="usernameInput">Username / Email *</label>
                                <input type="text" class="form-control qw-form-text-box" id="usernameInput" required>
                            </div>

                            <div class="form-group">
                                <label for="passwordInput">Password *</label>
                                <input type="password" class="form-control  qw-form-text-box" id="passwordInput" required>
                            </div>
                            <div class="form-group">
                                <label for="repeatPasswordInput">Repeat Password *</label>
                                <input type="password" class="form-control  qw-form-text-box" id="repeatPasswordInput" required>
                            </div>
                            <div>
                                <button class="qw-red-button" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>