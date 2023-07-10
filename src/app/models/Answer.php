<?php

class Answer
{
    private $answerText;
    private $correctAnswer;

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
}