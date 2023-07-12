<?php

class Question
{
    private $questionText;
    private $options;

    public function __construct($text)
    {
        $this->questionText = $text;
        $this->options = array();
    }

    public function getQuestionText() {
        return $this->questionText;
    }

    public function addOption($option): void
    {
        $this->options[] = $option;
    }

    public function getOptions(): array
    {
        shuffle($this->options);
        return $this->options;
    }

}