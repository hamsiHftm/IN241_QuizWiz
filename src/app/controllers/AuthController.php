<?php

require_once 'DBController.php';

class AuthController
{
    /**
     * Register a new user with the provided information.
     *
     * This static function registers a new user by calling the 'registerNewUser' method of the 'DBController' class.
     * It handles the case where the first name, last name, or date of birth might be empty strings by converting them to null values.
     *
     * @param string $username The username of the new user.
     * @param string $password The password of the new user.
     * @param string|null $firstname The first name of the new user (or null if empty).
     * @param string|null $lastname The last name of the new user (or null if empty).
     * @param string|null $dateOfBirth The date of birth of the new user (or null if empty).
     *
     * @return array An associative array containing the result of the registration attempt.
     *               It includes 'success' (boolean) indicating whether the registration was successful
     *               and 'message' (string) providing a message describing the outcome.
     */
    public static function registerUser(string $username, string $password, ?string $firstname, ?string $lastname, ?string $dateOfBirth): array
    {
        // checking if firstname, lastname and dataOfBirth are empty string, when yes changing to null
        $firstname = (empty($firstname)) ? null : $firstname;
        $lastname = (empty($lastname)) ? null : $lastname;
        $dateOfBirth = (empty($dateOfBirth)) ? null : $dateOfBirth;

        $dbController = new DBController();
        return $dbController->registerNewUser($username, $password, $firstname, $lastname, $dateOfBirth);
    }

    /**
     * Authenticate a user for login and set the session data.
     *
     * This static function authenticates a user by calling the 'getUserForLogin' method of the 'DBController' class.
     * If authentication is successful, it starts a session and stores user data in the session.
     *
     * @param string $username The username of the user attempting to log in.
     * @param string $password The password provided during the login attempt.
     *
     * @return array An associative array indicating the login result.
     *               It includes 'success' (boolean) indicating whether the login was successful
     *               and 'message' (string) providing a message describing the outcome.
     */
    public static function loginUser(string $username, string $password): array
    {
        // Verify user credentials
        $dbController = new DBController();
        $result = $dbController->getUserForLogin($username, $password);
        if ($result['user'] !== null) {
            // Start the session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            // store user data
            $_SESSION['user'] = $result['user']->toArray();
            return ['success' => true, 'message' => 'successfully logged in'];
        } else {
            return ['success' => false, 'message' => $result['message']];
        }
    }

    /**
     * Log out the currently authenticated user and destroy the session.
     *
     * This static function is responsible for logging out the user by destroying their session and unsetting user data.
     * It then unsets the 'user' session variable, effectively logging the user out, and destroys the entire session.
     */
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

    /**
     * Check if a user is currently logged in.
     *
     * This static function determines whether a user is logged in by checking for the presence of a 'user' session variable.
     *
     * @return bool Returns true if a user is logged in, otherwise false.
     */
    public static function isLoggedIn(): bool
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Check if a session is already started and a user is logged in
        return isset($_SESSION['user']);
    }

    /**
     * Get the currently authenticated user.
     *
     * This static function retrieves the user data from the session if the user is logged in.
     *
     * @return User|null Returns a User object if a user is logged in, otherwise returns null.
     */
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

    /**
     * Update the user data in the session.
     *
     * @param User $user The User object to update in the session.
     *
     * @return void
     */
    public static function updateUser(User $user): void
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Update the user data in the session
        $_SESSION['user'] = $user->toArray();

        // Optionally, you can regenerate the session ID for security
        session_regenerate_id(true);
    }

}

