<?php

class Question
{
    private $category;
    private $questionText;
    private $answers = array();

    public function __construct($category, $text)
    {
        $this->category = $category;
        $this->questionText = $text;
    }

    public function getQuestionText() {
        return $this->questionText;
    }

    public function addAnswer($answer) {
        $this->answers[] = $answer;
    }

}