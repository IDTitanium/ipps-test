<?php

namespace App\Helpers;

class BadgeMapper
{
    /**
     * Get list of badges
     */
    public static function badges(): array {
        return config('badges');
    }

    /**
     * Get badges by count of achievements
     *
     * @param int $achievementCount
     *
     * @return string|null
     */
    public static function getByCount(int $achievementCount): string|null {
        return static::badges()[$achievementCount] ?? null;
    }
}
