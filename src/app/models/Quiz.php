<?php

class Quiz
{
    private $category;
    private $questions = array();
    private $difficulty;

    private $currentPoints;

    public function __construct($category, $difficulty)
    {
        $this->category = $category;
        $this->difficulty = $difficulty;
        $this->currentPoints = 0;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDifficulty()
    {
        return $this->difficulty;
    }

    public function getCurrentPoints()
    {
        return $this->currentPoints;
    }

    public function addQuestion($question) {
        $this->questions[] = $question;
    }

    public function addPoints() {
        # calculate points --> Strategy has to be defined
    }

}