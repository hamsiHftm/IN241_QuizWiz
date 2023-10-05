<?php

require_once '../../config.php';

require_once '../services/QuizWizDBService.php';

require_once '../models/Quiz.php';
require_once '../models/Category.php';
require_once '../models/User.php';

class DBController {
    private QuizWizDBService $dbService;

    public function __construct() {
        $this->dbService = new QuizWizDBService($GLOBALS['DB_HOST'], $GLOBALS['DB_PORT'], $GLOBALS['DB_NAME'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD']);
    }

    /**
     * Registers a new user in the system.
     *
     * This function attempts to register a new user with the provided username, password, first name, last name, and date of birth.
     * It first checks if a user with the same username already exists in the database. If a user exists, it returns an error message.
     * If the username is unique, it attempts to save the user's information to the database.
     *
     * @param string $username     The username of the new user.
     * @param string $password     The password of the new user.
     * @param string $firstname    The first name of the new user.
     * @param string $lastname     The last name of the new user.
     * @param string $dateOfBirth  The date of birth of the new user.
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
            $this->dbService->closeConnection();

            if ($isUserSaved) {
                return ['success' => true, 'message' => 'User successfully registered!'];
            } else {
                return ['success' => false, 'message' => 'User registration failed!'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'User registration failed!. Exception: ' . $e->getMessage()];
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
            $this->dbService->closeConnection();

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
            return ['user' => null, 'message' => 'Failed! Exception: '. $e->getMessage()];
        }
    }

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
            $isQuizSaved = $this->dbService->saveQuiz($user->getDBId(), $quiz->getDifficulty(), $categoryId, $quiz->getCurrentPoints());
            $this->dbService->closeConnection();
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            $isQuizSaved = false;
        }
        return $isQuizSaved;
    }

    public function getTopScoredQuizRecords($limit = 10): ?array
    {
        $records = null;
        try {
            // connecting to DB
            $this->dbService->connect();
            $records = $this->dbService->getQuizRecordsInDecOrderScore($limit);
            $this->dbService->closeConnection();
        } catch (PDOException $e) {
            // Handle any database errors here
            echo "Error: " . $e->getMessage();
            $records = null;
        }
        return $records;
    }

}

