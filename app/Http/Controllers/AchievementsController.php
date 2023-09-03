<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\AchievementRepository;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function __construct(public AchievementRepository $achievementRepository)
    {
    }

    public function index(User $user)
    {
        $unlockedAchievements = $this->achievementRepository->getUnlockedAchievements($user);
        $nextAvailableAchievements = $this->achievementRepository->getNextAvalaibleAchievements($user);


        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => optional($user->currentBadge())->name,
            'next_badge' => optional($user->nextBadge())->name,
            'remaining_to_unlock_next_badge' => $user->remainingToUnlockNextBadge()
        ]);
    }
}
