<?php

namespace App\Listeners;

use App\Enums\AchievementType;
use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Helpers\AchievementMapper;
use App\Helpers\BadgeMapper;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LessonWatchedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LessonWatched $event): void
    {
        $this->checkForNewAchievementUnlocked($event->lesson, $event->user);
        $this->checkForNewBadgeUnlocked($event->lesson, $event->user);
    }

    /**
     * Check for new achievement unlocked
     */
    private function checkForNewAchievementUnlocked(Lesson $lesson, User $user): void
    {
        $achievement = AchievementMapper::getByCount($user->total_watched, AchievementType::WATCHED->value);

        if ($achievement) {
            event(new AchievementUnlocked($achievement, $user));
        }
    }

    /**
     * Check for new badge unlocked
     */
    private function checkForNewBadgeUnlocked(Lesson $lesson, User $user): void
    {
        $totalAchievements = $user->total_comments + $user->total_watched;

        $badge = BadgeMapper::getByCount($totalAchievements);

        if ($badge) {
            event(new BadgeUnlocked($badge, $user));
        }
    }
}
