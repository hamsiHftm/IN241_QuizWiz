<?php

enum Difficulty: string
{
    case Easy = 'easy';
    case Medium = 'medium';
    case Hard = 'hard';
    case Mixed = 'mixed';

    public static function values(): array
    {
        return [
            self::Easy,
            self::Medium,
            self::Hard,
            self::Mixed
        ];
    }

    public static function fromString(string $difficultyString): ?Difficulty
    {
        return match ($difficultyString) {
            'easy' => self::Easy,
            'medium' => self::Medium,
            'hard' => self::Hard,
            'mixed' => self::Mixed,
            default => null,
        };
    }
}