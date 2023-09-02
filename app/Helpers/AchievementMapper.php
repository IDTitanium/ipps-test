<?php

namespace App\Helpers;

use App\Enums\AchievementType;

class AchievementMapper
{
    /**
     * Get the lists of all achievements
     */
    public static function achievements(): array {
        return config('achievements');
    }

    /**
     * Get the achievement by the type and count
     *
     * @param int $countOfAchievement
     * @param string $type
     *
     * @return string|null
     */
    public static function getByCount(int $countOfAchievement, string $type): string|null {
        return static::achievements()[$type][$countOfAchievement] ?? null;
    }
}
