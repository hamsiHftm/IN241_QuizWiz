<?php

class Question
{
    private string $questionText;
    private string $difficulty;
    private array $answers;
    private bool $solvedCorrectly;

    public function __construct($text, $difficulty)
    {
        $this->questionText = $text;
        $this->difficulty = $difficulty;
        $this->answers = array();
        $this->solvedCorrectly = false;
    }

    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    public function getQuestionDifficulty(): string
    {
        return $this->difficulty;
    }

    public function getAnswers(): array
    {
        shuffle($this->answers);
        return $this->answers;
    }

    public function isSolvedCorrectly(): bool
    {
        return $this->solvedCorrectly;
    }

    public function addAnswer($option): void
    {
        $this->answers[] = $option;
    }

    public function setSolvedCorrectly($solvedCorrectly): void
    {
        $this->solvedCorrectly = $solvedCorrectly;
    }

    public function toArray(): array
    {
        $answerArray = [];
        foreach ($this->answers as $answer) {
            $answerArray[] = $answer->toArray();
        }

        return [
            'questionText' => $this->questionText,
            'difficulty' => $this->difficulty,
            'answers' => $answerArray,
            'solvedCorrectly' => $this->solvedCorrectly,
        ];
    }

    public static function fromArray(array $data): self
    {
        $question = new self($data['questionText'], $data['difficulty']);
        $question->setSolvedCorrectly($data['solvedCorrectly']);

        foreach ($data['answers'] as $answerData) {
            $question->addAnswer(Answer::fromArray($answerData));
        }

        return $question;
    }


}