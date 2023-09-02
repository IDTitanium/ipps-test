<?php

namespace App\Repositories;

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
}
