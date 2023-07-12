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
    private $token;

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


    public function getQuestions($amount, $type, $categoryId, $difficulty) {
        $url = $this->baseURL . 'api.php?amount=' . $amount . '&category=' . $categoryId . '&difficulty=' . $difficulty . '&type=' . $type;

        // Make a GET request to the API endpoint and retrieve the response
        $response = file_get_contents($url);

        // Process the response (e.g., JSON decoding, error handling, etc.)
        $data = json_decode($response, true);

        if ($data) {
            return $data['results'];
        }
        return [];
    }
}