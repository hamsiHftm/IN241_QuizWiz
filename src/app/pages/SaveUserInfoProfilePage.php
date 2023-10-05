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
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$dateOfBirth = $_POST["dateOfBirth"];

// updating user infos
$dbController = new DBController();
$result = $dbController->updateUserInformation($user->getUsername(), $firstname, $lastname, $dateOfBirth);

if ($result['success']) {
    // Save the updated user instance back into the session
    $user->setFirstname($firstname);
    $user->setLastname($lastname);
    AuthController::updateUser($user);
    echo "<script>alert('User Updated!!');</script>";
} else {
    echo "<script>alert('" . $result['message'] . "');</script>";
}

// redirecting to profile page
echo "<script>window.location.href = 'ProfilePage.php';</script>";