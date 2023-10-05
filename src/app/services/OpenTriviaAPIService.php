<?php

/**
 * OpenTriviaAPIService functional class
 *
 */

class OpenTriviaAPIService
{
    private string $baseURL;

    public function __construct($url)
    {
        $this->baseURL = $url;
    }

    /**
     * Fetches trivia categories from an external API.
     *
     * This method makes a GET request to the API endpoint to retrieve trivia categories.
     *
     * @return array An array of trivia categories if the request is successful, or an empty array if there is an error.
     */
    public function getCategories(): array
    {
        $url = $this->baseURL . '/api_category.php';

        try {
            // Make a GET request to the API endpoint and retrieve the response
            $response = file_get_contents($url);

            // Process the response (e.g., JSON decoding, error handling, etc.)
            $data = json_decode($response, true);

            if ($data && isset($data['trivia_categories'])) {
                return $data['trivia_categories'];
            }
            return [];
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Retrieve questions from an external API based on specified parameters.
     *
     * @param int $amount The number of questions to retrieve.
     * @param int $categoryID The ID of the category for the questions.
     * @param string $difficulty The difficulty level of the questions.
     * @param string $questionType The type of questions to retrieve.
     *
     * @return array|null An array of retrieved questions or an empty array if none found, null for exceptions.
     */
    public function getQuestions(int $amount, int $categoryID, string $difficulty, string $questionType): ?array
    {
        try {
            $url = $this->baseURL . '/api.php';
            $params = array(
                'amount' => $amount,
                'category' => $categoryID
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

            if ($data && isset($data['results'])) {
                return $data['results'];
            }
            return [];
        } catch (Exception $e) {
            return [];
        }
    }
}