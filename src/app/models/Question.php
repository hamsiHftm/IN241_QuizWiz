<?php

class Question
{
    private $questionText;
    private $answers = array();

    public function __construct($text)
    {
        $this->questionText = $text;
        $this->answers = array();
    }

    public function getQuestionText() {
        return $this->questionText;
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