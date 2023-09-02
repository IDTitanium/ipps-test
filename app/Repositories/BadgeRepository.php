<?php

namespace App\Repositories;

use App\Models\Badge;
use App\Models\User;

class BadgeRepository
{
    /**
     * Create a badge for a user by badge name
     *
     * @param User $user
     * @param string $badgeName
     *
     * @return void
     */
    public function createUserBadgeByName(User $user, string $badgeName): void
    {
        $badge = $this->getBadgeByName($badgeName);

        $user->badges()->attach([$badge->id]);
    }

    /**
     * Get the badge by name
     *
     * @param string $badgeName
     *
     * @return Badge
     */
    public function getBadgeByName(string $badgeName): Badge
    {
        return Badge::where('name', $badgeName)->first();
    }
}
