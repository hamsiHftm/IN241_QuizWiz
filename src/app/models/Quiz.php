<?php

require_once 'Difficulty.php';
require_once 'QuestionType.php';
require_once 'Category.php';
class Quiz
{
    private ?Category $category;
    private ?array $questions;
    private QuestionType $questionType;
    private ?int $currentPoints;
    private ?bool $isPlaying;
    private Difficulty $difficulty;

    public function __construct($category, $difficulty, $questionType)
    {
        $this->category = $category;
        $this->difficulty = $difficulty;
        $this->questionType = $questionType;
        $this->currentPoints = 0;
        $this->questions = array();
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function getQuestionType(): QuestionType
    {
        return $this->questionType;
    }

    public function getCurrentPoints(): int
    {
        return $this->currentPoints;
    }

    public function getPlayingMode(): bool {
        return $this->isPlaying;
    }


    public function getDifficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function addQuestion($question): void
    {
        $this->questions[] = $question;
    }

    public function setCurrentPoints($currentPoints): void {
        $this->currentPoints = $currentPoints;
    }

    public function setPlayingMode($isPlaying):void {
        $this->isPlaying = $isPlaying;
    }

    public function addPoints($difficulty): void
    {
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

    public function toArray(): array
    {
        $questionArray = [];
        foreach ($this->questions as $question) {
            $questionArray[] = $question->toArray();
        }
        return [
            'category' => $this->category?->toArray(),
            'questions' => $questionArray,
            'questionType' => $this->questionType->value,
            'currentPoints' => $this->currentPoints,
            'isPlaying' => $this->isPlaying,
            'difficulty' => $this->difficulty->value,
        ];
    }

    public static function fromArray(array $data): self
    {
        $category = isset($data['category']) ? Category::fromArray($data['category']) : null;
        $difficulty = Difficulty::fromString($data['difficulty']);
        $questionType = QuestionType::fromString($data['questionType']);

        $quiz = new self($category, $difficulty, $questionType);

        if (isset($data['questions']) && is_array($data['questions'])) {
            foreach ($data['questions'] as $questionData) {
                $quiz->addQuestion(Question::fromArray($questionData));
            }
        }
        $quiz->setCurrentPoints($data['currentPoints']);
        $quiz->setPlayingMode($data['isPlaying']);

        return $quiz;
    }



}