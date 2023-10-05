<?php

require_once '../../config.php';
require_once '../services/QuizWizDBService.php';

class DBController
{
    private QuizWizDBService $dbService;

    public function __construct()
    {
        $this->dbService = new QuizWizDBService($GLOBALS['DB_HOST'], $GLOBALS['DB_PORT'], $GLOBALS['DB_NAME'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD']);
    }

    /**
     * Registers a new user in the system.
     *
     * This function attempts to register a new user with the provided username, password, first name, last name, and date of birth.
     * It first checks if a user with the same username already exists in the database. If a user exists, it returns an error message.
     * If the username is unique, it attempts to save the user's information to the database.
     *
     * @param string $username The username of the new user.
     * @param string $password The password of the new user.
     * @param string $firstname The first name of the new user.
     * @param string $lastname The last name of the new user.
     * @param string $dateOfBirth The date of birth of the new user.
     *
     * @return array An associative array containing the result of the registration attempt.
     *               - 'success': A boolean indicating whether the registration was successful.
     *               - 'message': A message describing the outcome of the registration process.
     *                 If registration is successful, the message will indicate success.
     *                 If a user with the same username already exists, the message will indicate a failure due to an existing user.
     *                 If there is a database error, it will include details of the exception in the message.
     */
    public function registerNewUser(string $username, string $password, string $firstname, string $lastname, string $dateOfBirth): array
    {
        try {
            // connecting to DB
            $this->dbService->connect();

            // checking if user already exits
            $user = $this->dbService->getUserByUsername($username);
            if ($user !== null) {
                return ['success' => false, 'message' => 'User already exists!'];
            }

            // saving user
            $isUserSaved = $this->dbService->saveUser($username, $password, $firstname, $lastname, $dateOfBirth);

            if ($isUserSaved) {
                return ['success' => true, 'message' => 'User successfully registered!'];
            } else {
                return ['success' => false, 'message' => 'User registration failed!'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'User registration failed!. Exception: ' . $e->getMessage()];
        } finally {
            $this->dbService->closeConnection();
        }
    }

    /**
     * Authenticate a user for login and retrieve their information.
     *
     * This function is responsible for authenticating a user during the login process.
     * It connects to the database, checks if the provided username exists, and verifies the password.
     *
     * @param string $username The username of the user attempting to log in.
     * @param string $password The password provided during the login attempt.
     *
     * @return array|null An associative array containing either the user's information if authentication is successful or an error message.
     *               - 'user': An instance of the User class representing the authenticated user (or null if authentication fails).
     *               - 'message': A message describing the outcome of the login attempt.
     *                 If login is successful, the message indicates success.
     *                 If the username does not exist, the message indicates a non-existent user.
     *                 If the password is incorrect, the message indicates an incorrect password.
     *                 If there is a database error, it includes details of the exception in the message.
     */
    public function getUserForLogin(string $username, string $password): ?array
    {
        try {
            // connecting to DB
            $this->dbService->connect();

            // checking if user exits, when not returning a error message
            $getUserResult = $this->dbService->getUserByUsername($username);
            if ($getUserResult === null) {
                return ['user' => null, 'message' => 'User does not exist!'];
            }

            $result = $this->dbService->getUserByUsernameAndPassword($username, $password);

            if ($result !== null) {
                $user = new User(
                    $result['id'],
                    $result['username'],
                    $result['first_name'],
                    $result['last_name'],
                    $result['date_of_birth']
                );
                return ['user' => $user, 'message' => 'User logged in successfully!'];
            } else {
                return ['user' => null, 'message' => 'Wrong password!'];
            }
        } catch (PDOException $e) {
            return ['user' => null, 'message' => 'Failed! Exception: ' . $e->getMessage()];
        } finally {
            $this->dbService->closeConnection();
        }
    }

    /**
     * Save a Quiz result in the database.
     *
     * This method saves the result of a Quiz, including the user's score and category information.
     *
     * @param Quiz $quiz The Quiz object containing the result to be saved.
     * @param User $user The User object representing the user who played the Quiz.
     *
     * @return bool True if the Quiz result was successfully saved, false otherwise.
     */
    public function saveQuizResult($quiz, $user): bool
    {
        $isQuizSaved = false;
        try {
            // connecting to DB
            $this->dbService->connect();

            // first saving category and getting DB id to save in the quiz table
            // Otherwise saving quiz without category id
            $categoryId = null;
            $category = $quiz->getCategory();
            $isCategorySaveSuccess = $this->dbService->saveCategory($category->getId(), $category->getName());
            if ($isCategorySaveSuccess) {
                $result = $this->dbService->getCategoryByIdentifierAndName($category->getId(), $category->getName());
                if ($result !== null) {
                    $categoryId = $result['id'];
                }
            }
            // saving quiz
            $isQuizSaved = $this->dbService->saveQuiz($user->getDBId(), $quiz->getDifficulty()->value, $categoryId, $quiz->getCurrentPoints());
        } catch (PDOException $e) {
            $isQuizSaved = false;
        } finally {
            $this->dbService->closeConnection();
        }
        return $isQuizSaved;
    }

    /**
     * Get the top scored quiz records in descending order of total score with a specified limit.
     *
     * This method retrieves the top scored quiz records from the database by calling the 'getQuizRecordsInDecOrderScore'
     * method of the 'DBService' class. It connects to the database, retrieves the records, and then closes the connection.
     *
     * @param int $limit The maximum number of top scored quiz records to retrieve (default is 10).
     *
     * @return array|null An array of associative arrays representing top scored quiz records or null if an error occurs.
     *                    Each associative array contains the following keys:
     *                    - 'id' (int): The unique identifier of the quiz record.
     *                    - 'username' (string): The username of the player who took the quiz.
     *                    - 'name' (string): The name of the category to which the quiz belongs.
     *                    - 'difficulty' (string): The difficulty level of the quiz.
     *                    - 'total_score' (int): The total score achieved in the quiz.
     *
     * @throws PDOException If there are any database-related errors, they will be caught and set result as null.
     */
    public function getTopScoredQuizRecords(int $limit = 10): ?array
    {
        try {
            // connecting to DB
            $this->dbService->connect();
            return $this->dbService->getQuizRecordsInDecOrderScore($limit);
        } catch (PDOException $e) {
            return null;
        } finally {
            $this->dbService->closeConnection();
        }
    }

    /**
     * Fetch user quiz records and update the User object with the retrieved information.
     *
     * This method connects to the database, retrieves user information and quiz data,
     * and updates the provided User object with the fetched data, including high score
     * and the number of played games.
     *
     * @param User $user The User object to update with quiz records.
     *
     * @return User|null The updated User object with quiz records, or null in case of an error.
     */
    public function updateUserQuizInfos(User $user): ?User
    {
        try {
            // connecting to DB
            $this->dbService->connect();

            // getting user information and setting in user object
            $getUserResult = $this->dbService->getUserByUsername($user->getUsername());
            if ($getUserResult !== null) {
                $user->setDBId($getUserResult['id']);
                $user->setDateOfBirth($getUserResult['date_of_birth']);
            }

            // getting quiz infos
            $result = $this->dbService->getAllQuizFromUserWithCategoryInDecOrderScore($user->getDBId());
            $highScore = 0;
            $numberOfPlayedGames = 0;
            if (!empty($result)) {
                $highScore = $result[0]['total_score'];
                $numberOfPlayedGames = count($result);
            }
            $user->setScoredHighScore($highScore);
            $user->setNrOfPlayedGames($numberOfPlayedGames);
            return $user;
        } catch (PDOException $e) {
            return $user;
        } finally {
            $this->dbService->closeConnection();
        }
    }

    /**
     * Update user information in the database.
     *
     * This method connects to the database, updates user information, and returns an array
     * indicating the success or failure of the update operation.
     *
     * @param string $username The username of the user to update.
     * @param string $firstname The updated first name (or null to keep it unchanged).
     * @param string $lastname The updated last name (or null to keep it unchanged).
     * @param string $dateOfBirth The updated date of birth (or null to keep it unchanged).
     *
     * @return array An associative array indicating the success or failure of the update operation.
     *               Example: ['success' => true, 'message' => 'User updated!!']
     */
    public function updateUserInformation(string $username, string $firstname, string $lastname, string $dateOfBirth): array
    {
        try {
            // connecting to DB
            $this->dbService->connect();

            // checking if firstname, lastname and dataOfBirth are empty string, when yes changing to null
            $firstname = (empty($firstname)) ? null : $firstname;
            $lastname = (empty($lastname)) ? null : $lastname;
            $dateOfBirth = (empty($dateOfBirth)) ? null : $dateOfBirth;

            // saving user
            $isUserSaved = $this->dbService->updateUserProfile($username, $firstname, $lastname, $dateOfBirth);

            if ($isUserSaved) {
                return ['success' => true, 'message' => 'User updated!!'];
            } else {
                return ['success' => false, 'message' => 'User update failed!'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'User update failed!. Exception: ' . $e->getMessage()];
        } finally {
            $this->dbService->closeConnection();
        }
    }

    /**
     * Change the password for a user.
     *
     * This method allows a user to change their password by verifying the current password,
     * hashing the new password, and updating it in the database.
     *
     * @param string $username The username of the user.
     * @param string $currentPassword The current password.
     * @param string $newPassword The new password.
     *
     * @return array An associative array indicating the success or failure of the password change operation.
     *               Example: ['success' => true, 'message' => 'Password updated successfully']
     */
    public function changePassword(string $username, string $currentPassword, string $newPassword): array
    {
        try {
            // Connect to the database
            $this->dbService->connect();

            // Retrieve the user's current password from the database
            $user = $this->dbService->getUserByUsername($username);

            // Verify if the user exists and the current password is correct
            if ($user !== null && password_verify($currentPassword, $user['password'])) {
                // Hash the new password for security
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the user's password in the database
                $isPasswordUpdated = $this->dbService->updateUserPassword($username, $hashedNewPassword);

                if ($isPasswordUpdated) {
                    return ['success' => true, 'message' => 'Password updated successfully'];
                } else {
                    return ['success' => false, 'message' => 'Failed to update password'];
                }
            } else {
                return ['success' => false, 'message' => 'Current password is incorrect'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Password change failed. Exception: ' . $e->getMessage()];
        } finally {
            $this->dbService->closeConnection();
        }
    }

    public function getQuizRecordsFromUser(int $userId): ?array
    {
        try {
            // connecting to DB
            $this->dbService->connect();
            return $this->dbService->getAllQuizFromUserWithCategoryInDecOrderScore($userId);
        } catch (PDOException $e) {
            return null;
        } finally {
            $this->dbService->closeConnection();
        }
    }
}

