<?php

class Question
{
    private $questionText;
    private $difficulty;
    private $answers = array();

    public function __construct($text, $difficulty)
    {
        $this->questionText = $text;
        $this->difficulty = $difficulty;
        $this->answers = array();
    }

    public function getQuestionText() {
        return $this->questionText;
    }

    public function getQuestionDifficulty() {
        return $this->difficulty;
    }

    public function addAnswer($option): void
    {
        $this->answers[] = $option;
    }

    public function getAnswers(): array
    {
        shuffle($this->answers);
        return $this->answers;
    }

}