<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Models\Comment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentWrittenListener
{
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


    }

    /**
     * Check for new badge unlocked
     *
     * @return void
     */
    private function checkForNewBadgeUnlocked(Comment $comment): void {

    }

}
