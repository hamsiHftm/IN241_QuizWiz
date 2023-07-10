<?php

class QuestionList
{
    private $category;
    private $questions = array();

    private $mode;
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