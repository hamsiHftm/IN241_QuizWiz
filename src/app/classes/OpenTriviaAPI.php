<?php

/**
 * OpenTriviaAPI functional class
 *
 * Includes methods to retrieve and interact with data from OpenTrivia
 * 1. getCategories --> get all the quiz topic
 */
class OpenTriviaAPI
{
    private $baseURL;
    private $session_token;

    public function __construct($url, $set_session_token = false)
    {
        $this->baseURL = $url;
        if ($set_session_token) {
            // TODO generate session token
            error_log('session token for quiz created for this user');
        }
    }

    public function getSessionToken() {
        return $this->session_token;
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


    public function getQuestions() {
        $url = $this->baseURL . 'api.php';
        return [];
    }
}