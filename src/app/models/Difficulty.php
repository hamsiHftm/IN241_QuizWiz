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
}