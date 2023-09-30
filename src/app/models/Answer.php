<?php

class Answer
{
    private $answerText;
    private $correctAnswer;
    private $isUserSelected;

    public function __construct($text, $correctAnswer)
    {
        $this->answerText = $text;
        $this->correctAnswer = $correctAnswer;
    }

    public function getAnswerText() {
        return $this->answerText;
    }

    public function isCorrectAnswer() {
        return $this->correctAnswer;
    }

    public function setUserSelected($isSelected): void
    {
        $this->isUserSelected = $isSelected;
    }

    public function isUserSelected() {
        return $this->isUserSelected;
    }
}