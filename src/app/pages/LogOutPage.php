<?php
require_once '../controllers/AuthController.php';

// Call the logout function from AuthController
AuthController::logoutUser();

// Redirect the user to a login or home page
header('Location: HomePage.php');
exit();

