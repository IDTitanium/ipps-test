<?php

namespace App\Listeners;

use App\Enums\AchievementType;
use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Helpers\AchievementMapper;
use App\Models\Comment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentWrittenListener implements ShouldQueue
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
    public function handle(CommentWritten $event): void
    {
        $this->checkForNewAchievementUnlocked($event->comment);
        $this->checkForNewBadgeUnlocked($event->comment);
    }

    /**
     * Check for new achievement unlocked
     *
     * @return void
     */
    private function checkForNewAchievementUnlocked(Comment $comment): void {
        $user = $comment->user()->first();

        $achievement = AchievementMapper::getByCount($user->getTotalCommentsAttribute(), AchievementType::COMMENT->value);

        if ($achievement) {
            event(new AchievementUnlocked($user, $achievement));
        }
    }

    /**
     * Check for new badge unlocked
     *
     * @return void
     */
    private function checkForNewBadgeUnlocked(Comment $comment): void {

    }

}
