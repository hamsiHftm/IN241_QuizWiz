<?php

class Quiz
{
    private $category;
    private $questions;
    private $questionType;
    private $currentPoints;
    private $isPlaying;
    private $difficulty;

    public function __construct($category, $difficulty, $questionType)
    {
        $this->category = $category;
        $this->difficulty = $difficulty;
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

    public function getDifficulty() {
        return $this->difficulty;
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

    public function setPlayingMode($isPlaying):void {
        $this->isPlaying = $isPlaying;
    }

    public function getPlayingMode(): bool {
        return $this->isPlaying;
    }

    public function addPoints($difficulty) {
        if ($this->isPlaying) {
            if ($difficulty === 'easy') {
                $this->currentPoints += 250;
            } elseif ($difficulty === 'medium') {
                $this->currentPoints += 500;
            } elseif ($difficulty === 'hard') {
                $this->currentPoints += 1000;
            }
        }
    }

}