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
                <div class="qw-card-inner-layout">
                    <div>
                        <img class="qw-card-icon-layout" src="../../assets/img/quiz_wiz_logo.svg">
                    </div>
                    <div>
                        <a class="qw-red-button" href="LoginPage.php">Back</a>
                    </div>
                </div>
            </div>
            <div class="col-6" style="padding: 2em">
                <h2>Reset Password</h2>
                <form class="qw-form col d-flex flex-column justify-content-between">
                    <div class="form-group">
                        <label for="usernameInput">Username / Email</label>
                        <input type="text" class="form-control" id="usernameInput" aria-describedby="usernameInput" placeholder="Username/Email">
                        <small id="usernameInput" class="form-text text-muted">You can enter your username or email</small>
                    </div>

                    <div class="form-group">
                        <label for="passwordInput">Password</label>
                        <input type="password" class="form-control" id="passwordInput" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="repeatPasswordInput">Repeat Password</label>
                        <input type="password" class="form-control" id="repeatPasswordInput" placeholder="Repeat Password">
                    </div>
                    <div>
                        <button class="qw-red-button" type="submit">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>