<?php

namespace Tests\Unit;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;
use Tests\TestCase;
use Tests\Helpers\CommentWrittenEventTestHelper;
use Illuminate\Support\Facades\Event;

class CommentWrittenListenerTest extends TestCase
{
    /**
     * Can listen for comment written event
     */
    public function test_can_listen_for_comment_written_event(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        CommentWrittenEventTestHelper::fire();

        Event::assertDispatched(CommentWritten::class);

        Event::assertListening(CommentWritten::class, CommentWrittenListener::class);
    }

    /**
     * Can trigger event when achievement is unlocked
     */
    public function test_can_trigger_event_when_achievement_is_unlocked(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        $comment = Comment::factory(1)->create();

        $event = new CommentWritten($comment->first());

        $listener = new CommentWrittenListener();

        $listener->handle($event);

        Event::assertDispatched(function (AchievementUnlocked $event) {
            return $event->achievement_name === config('achievements.comment.1');
        });
    }

    /**
     * Event not triggered when achievement level is not reached
     */
    public function test_event_not_dispatched_when_achievement_level_is_not_reached(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        $comment = Comment::factory(2)->singleUser()->create();

        $event = new CommentWritten($comment->first());

        $listener = new CommentWrittenListener();

        $listener->handle($event);

        Event::assertNotDispatched(AchievementUnlocked::class);
    }

    public function test_event_dispatched_when_badge_level_is_reached(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        $comment = Comment::factory(4)->singleUser()->create();

        $event = new CommentWritten($comment->first());

        $listener = new CommentWrittenListener();

        $listener->handle($event);

        Event::assertDispatched(BadgeUnlocked::class);
    }

    public function test_event_not_dispatched_when_badge_level_is_not_reached(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        $comment = Comment::factory(3)->singleUser()->create();

        $event = new CommentWritten($comment->first());

        $listener = new CommentWrittenListener();

        $listener->handle($event);

        Event::assertNotDispatched(BadgeUnlocked::class);
    }

    /**
     * Can store user achievement in the database
     */
    public function test_can_store_user_achievement_in_the_database(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        $comment = Comment::factory()->create();

        $event = new CommentWritten($comment);

        $listener = new CommentWrittenListener();

        $listener->handle($event);

        $achievement = Achievement::where('name', config('achievements.comment.1'))->first();

        Event::assertDispatched(function (AchievementUnlocked $event) {
            return $event->achievement_name === config('achievements.comment.1');
        });

        $this->assertDatabaseHas('achievement_user', [
            'user_id' => $comment->user_id,
            'achievement_id' => $achievement->id
        ]);
    }
}
