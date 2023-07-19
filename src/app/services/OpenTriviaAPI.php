<?php

/**
 * OpenTriviaAPI functional class
 *
 * Includes methods to retrieve and interact with data from OpenTrivia
 * 1. getCategories --> get all the quiz topic
 */

include __DIR__ . '/../models/Quiz.php';
include __DIR__ . '/../models/Question.php';
include __DIR__ . '/../models/Answer.php';

class OpenTriviaAPI
{
    private $baseURL;
    private $token;

    # TODO token
    public function __construct($url, $token)
    {
        $this->baseURL = $url;
        $this->token = $token;
    }

    public function getToken() {
        return $this->token;
    }

    public function generateToken() {
        $url = $this->baseURL . '/api_token.php?command=request';
        $response = file_get_contents($url);

        $data = json_decode($response, true);
        if ($data and $data['response_code'] == 0) {
            $this->token = $data['token'];
            return $this->token;
        }
        return null;
    }

    public function resetToken() {
        $url = $this->baseURL . '/api_token.php?command=reset&token=' . $this->token;
        $response = file_get_contents($url);

        $data = json_decode($response, true);
        if ($data and $data['response_code'] == 0) {
            $this->token = $data['token'];
            return $this->token;
        }
        return null;
    }

    public function getCategories() {
        $url = $this->baseURL . '/api_category.php';
        // Make a GET request to the API endpoint and retrieve the response
        $response = file_get_contents($url);

        // Process the response (e.g., JSON decoding, error handling, etc.)
        $data = json_decode($response, true);

        if ($data) {
            return $data['trivia_categories'];
        }
        return [];
    }

    public function getQuestions($amount, $category, $difficulty, $questionType) {
        $url = $this->baseURL . '/api.php';
        $params = array(
            'amount' => $amount,
            'category' => $category
        );

        if (!empty($this->token)) {
            $params['token'] = $this->token;
        }
        if ($difficulty !== Difficulty::Mixed->value) {
            $params['difficulty'] = $difficulty;
        }

        if ($questionType !== QuestionType::Mixed->value) {
            $params['type'] = $questionType;
        }

        // Build the query string
        $queryString = http_build_query($params);
        // Append the query string to the URL
        $urlWithParams = $url . '?' . $queryString;

        // Make a GET request to the API endpoint and retrieve the response
        $response = file_get_contents($urlWithParams);
        // Process the response (e.g., JSON decoding, error handling, etc.)
        $data = json_decode($response, true);
        $quiz = null;
        if ($data) {
            $response_code = $data['response_code'];
            switch ($response_code) {
                case 0:
                    $quiz = $this->extract_quiz_from_response($category, $difficulty, $questionType, $data['results']);
                    break;
                case 1:
                    # TODO return notification to change the difficult to other or chose mixed, otherwis change the category, because not enough question available
                    break;
                case 3:
                    # TODO create new token and save to the user and request again the question
                    break;
                case 4:
                    # TODO regenerate Token, because all question are called. So ressetting token is necessary
                    break;
                default:
                    # TODO Notfictation something went wrong notification
                    break;
            }

        }
        return $quiz;
    }

    private function extract_quiz_from_response($category, $difficulty, $questionType, $results) {
        $quiz = new Quiz($category, $difficulty, $questionType);
        foreach ($results as $result) {
            $question = new Question($result['question']);
            $question->addAnswer(new Answer($result['correct_answer'], true));

            foreach ($result['incorrect_answers'] as $incorrect_answer) {
                $question->addAnswer(new Answer($incorrect_answer, false));
            }
            $quiz->addQuestion($question);
        }
        return $quiz;
    }
}