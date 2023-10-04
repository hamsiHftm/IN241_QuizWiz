<?php

require_once 'DBController.php';

class AuthController
{
    public static function registerUser($username, $password, $firstname, $lastname, $dateOfBirth): bool
    {
        // Validate input (e.g., check if username is unique, etc.)
        // You can add your validation logic here
        // TODO check, if any validation needed here

        // creating user in DB
        $dbController = new DBController();
        return $dbController->registerNewUser($username, $password, $firstname, $lastname, $dateOfBirth);
    }

    public static function loginUser($username, $password): bool
    {
        // Verify user credentials
        $dbController = new DBController();
        $user = $dbController->getUserForLogin($username, $password);
        if ($user !== null) {
            // Start the session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            // store user data
            $_SESSION['user'] = $user->toArray();
            return true;
        } else {
            return false; // Authentication failed
        }
    }

    public static function logoutUser(): void
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Unset user data and destroy the session
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function isLoggedIn(): bool
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Check if a session is already started and a user is logged in
        return isset($_SESSION['user']);
    }

    public static function getUser(): ?User
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Get user data from the session if the user is logged in
        if (isset($_SESSION['user'])) {
            // Create a User object from the session data using the fromArray method
            return User::fromArray($_SESSION['user']);
        } else {
            return null;
        }
    }
}

