<?php
require_once '../controllers/AuthController.php';
require_once '../controllers/DBController.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieving current user
$user = AuthController::getUser();

// Retrieve user-entered values
$oldPassword = $_POST["oldPassword"];
$newPassword = $_POST["newPassword"];
$repeatNewPassword = $_POST["repeatNewPassword"];

// checking if newPassword and repeatPassword are same
if ($newPassword == $repeatNewPassword) {
    // changing password in DB
    $dbController = new DBController();
    $result = $dbController->changePassword($user->getUsername(), $oldPassword, $newPassword);
    echo "<script>alert('" . $result['message'] . "');</script>";
} else {
    echo "<script>alert('Password does not match');</script>";
}

// redirecting to profile page
echo "<script>window.location.href = 'ProfilePage.php'</script>";

