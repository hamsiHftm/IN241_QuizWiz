<?php

require_once '../../config.php';
require_once '../services/OpenTriviaAPIService.php';
require_once '../models/Category.php';
require_once '../models/Quiz.php';
require_once '../models/Question.php';
require_once '../models/Answer.php';

class APIController
{
    private OpenTriviaAPIService $apiService;
    private int $numberOfQuestion;

    public function __construct()
    {
        $this->apiService = new OpenTriviaAPIService($GLOBALS['API_BASE_URL']);
        $this->numberOfQuestion = $GLOBALS['NR_OF_QUESTIONS'];
    }

    /**
     * Retrieve categories from the session or API and return them as an array of Category objects.
     *
     * @return array|null An array of Category objects if categories are found in the session or retrieved from the API, or null if there are no categories.
     */
    public function getCategories(): ?array
    {
        $categoryObjects = [];
        try {
            $categories = null;
            // retrieving array from session if exists otherwise from API
            if (isset($_SESSION['categories'])) {
                $categories = $_SESSION['categories'];
            } else {
                $categories = $this->apiService->getCategories();
                $_SESSION['categories'] = $categories;
            }

            // Convert the associative arrays to Category objects
            foreach ($categories as $category) {
                $categoryObjects[] = new Category($category['id'], $category['name']);
            }
            return $categoryObjects;
        } catch (Exception $e) {
            return $categoryObjects;
        }
    }

    /**
     * Generate a quiz and its questions from API results and store it in the session.
     *
     * @param int $categoryId The ID of the category for the quiz.
     * @param string $categoryName The name of the category for the quiz.
     * @param string $difficulty The difficulty level of the quiz.
     * @param string $type The type of questions in the quiz.
     *
     * @return bool|null True if the quiz was successfully generated and stored in the session, false on failure, null for exceptions.
     */
    public function generateQuizAndQuestions(int $categoryId, string $categoryName, string $difficulty, string $type): ?bool
    {
        try {
            $questionResults = $this->apiService->getQuestions($this->numberOfQuestion, $categoryId, $difficulty, $type);

            if (!empty($questionResults)) {
                $category = new Category($categoryId, $categoryName);
                $quiz = new Quiz($category, Difficulty::fromString($difficulty), QuestionType::fromString($type));

                // generating Quiz from the associative array
                foreach ($questionResults as $data) {
                    $question = new Question($data['question'], $data['difficulty']);
                    $question->addAnswer(new Answer($data['correct_answer'], true));

                    foreach ($data['incorrect_answers'] as $incorrect_answer) {
                        $question->addAnswer(new Answer($incorrect_answer, false));
                    }
                    $quiz->addQuestion($question);
                }
                //adding playing mode to quiz
                $quiz->setPlayingMode(true);

                // converting to array
                $quizArray = $quiz->toArray();
                $_SESSION['quiz'] = $quizArray;
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retrieve the Quiz object from the session.
     *
     * @return Quiz|null The retrieved Quiz object, or null if not found in the session.
     */
    public function retrievingQuizFromSession(): ?Quiz
    {
        $quiz = null;
        // Check if the quiz object exists in the session and retrieving quiz from the session
        if (isset($_SESSION['quiz'])) {
            $quizArray = $_SESSION['quiz'];
            $quiz = Quiz::fromArray($quizArray);
        }
        return $quiz;
    }

    /**
     * Delete the Quiz object from the session if it exists.
     */
    public function deleteQuizFromSession(): void
    {
        // Check if the quiz object exists in the session
        if (isset($_SESSION['quiz'])) {
            unset($_SESSION['quiz']); // Remove the quiz object from the session
        }
    }

    /**
     * Update the quiz data in the session.
     *
     * @param Quiz $quiz The Quiz object to update in the session.
     */
    public function updateQuizInSession(Quiz $quiz): void
    {
        // Convert the Quiz object to an associative array
        $quizArray = $quiz->toArray();

        // Update the quiz data in the session
        $_SESSION['quiz'] = $quizArray;
    }

    /**
     * TODO remove when its not needed
     * Retrieve categories from the session as objects.
     *
     * @return array|null An array of Category objects if categories are found in the session, or null if not found.
     */
    public function getCategoriesFromSession(): ?array
    {
        if (isset($_SESSION['categories'])) {
            $categories = $_SESSION['categories'];
        }
        return null;
    }
}