<?php

class Answer
{
    private string $answerText;
    private string $correctAnswer;

    public function __construct($text, $correctAnswer)
    {
        $this->answerText = $text;
        $this->correctAnswer = $correctAnswer;
    }

    public function getAnswerText(): string
    {
        return $this->answerText;
    }

    public function isCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    public function toArray(): array
    {
        return [
            'text' => $this->answerText,
            'correctAnswer' => $this->correctAnswer
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['text'], $data['correctAnswer']);
    }

}