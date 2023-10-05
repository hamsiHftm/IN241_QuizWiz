<?php

enum QuestionType: string
{
    case Multiple = 'multiple';
    case TrueOrFalse = 'boolean';
    case Mixed = 'mixed';

    public static function values(): array
    {
        return [
            self::Multiple,
            self::TrueOrFalse,
            self::Mixed
        ];
    }

    public static function fromString(string $typeString): ?QuestionType
    {
        return match ($typeString) {
            'multiple' => self::Multiple,
            'boolean' => self::TrueOrFalse,
            'mixed' => self::Mixed,
            default => null,
        };
    }
}