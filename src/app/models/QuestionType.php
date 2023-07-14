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
}