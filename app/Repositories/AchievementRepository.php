<?php

namespace App\Repositories;

use App\Enums\AchievementType;
use App\Models\Achievement;
use App\Models\User;

class AchievementRepository
{
    /**
     * Create achievement by name
     *
     * @param User $user
     * @param string $achievementName
     * @param string $achievementType
     *
     * @return void
     */
    public function createUserAchievementByName(User $user, string $achievementName, string $achievementType): void
    {
        $achievement = $this->getAchievementByNameAndType($achievementName, $achievementType);

        $user->achievements()->attach([$achievement->id]);
    }

    /**
     * Get achievement by name and type
     *
     * @param string $achievementName
     * @param string $achievementType
     *
     * @return Achievement
     */
    public function getAchievementByNameAndType(string $achievementName, string $achievementType): Achievement
    {
        return Achievement::where('name', $achievementName)->where('type', $achievementType)->first();
    }

    /**
     * Get unlocked achievements
     *
     * @param User $user
     *
     * @return array
     */
    public function getUnlockedAchievements(User $user): array
    {
        return $user->achievements()->get()->pluck('name')->toArray();
    }

    /**
     * Get next available achievements
     *
     * @param User $user
     *
     * @return array
     */
    public function getNextAvalaibleAchievements(User $user): array
    {
        $results = [];

        foreach (AchievementType::cases() as $type) {
            $currentAchievementForType = $this->getCurrentTypeAchievementForUser($user, $type->value);
            $nextAchivement = Achievement::where('id', '>', $currentAchievementForType?->id ?? 0)
                                ->where('type', $type->value)->first();

            if (!is_null($nextAchivement)) {
                $results[] = $nextAchivement->name;
            }
        }

        return $results;
    }

    /**
     * Get current type of achievement for user
     *
     * @param User $user
     * @param string $achievementType
     *
     * @return Achievement|null
     */
    private function getCurrentTypeAchievementForUser(User $user, string $achievementType): ?Achievement
    {
        return $user->achievements()->where('type', $achievementType)->first();
    }
}
