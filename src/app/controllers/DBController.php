<?php

require_once '../../config.php';

require_once '../services/QuizWizDBService.php';

require_once '../models/Quiz.php';
require_once '../models/Category.php';
require_once '../models/User.php';

class DBController {
    private $dbService;

    public function __construct() {
        $this->dbService = new QuizWizDBService($GLOBALS['DB_HOST'], $GLOBALS['DB_PORT'], $GLOBALS['DB_NAME'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD']);
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



}

