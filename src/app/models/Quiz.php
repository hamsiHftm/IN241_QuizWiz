<?php

class Quiz
{
    private $category;
    private $questions;
    private $questionType;
    private $currentPoints;

    public function __construct($category, $questionType)
    {
        $this->category = $category;
        $this->questionType = $questionType;
        $this->currentPoints = 0;
        $this->questions = array();
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getQuestionType()
    {
        return $this->questionType;
    }

    public function getCurrentPoints(): int
    {
        return $this->currentPoints;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function addQuestion($question): void
    {
        $this->questions[] = $question;
    }

    public function addPoints() {
        # TODO calculate points --> Strategy has to be defined
    }

}