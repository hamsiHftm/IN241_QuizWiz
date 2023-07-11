<?php

class Question
{
    private $questionText;
    private $options = array();

    public function __construct($text)
    {
        $this->questionText = $text;
    }

    public function getQuestionText() {
        return $this->questionText;
    }

    public function addAnswer($answer) {
        $this->options[] = $answer;
    }

}