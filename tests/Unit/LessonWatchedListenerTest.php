<?php

namespace Tests\Unit;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Listeners\LessonWatchedListener;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tests\Helpers\LessonWatchedEventTestHelper;

class LessonWatchedListenerTest extends TestCase
{
    /**
     * Can listen for lesson watched event
     */
    public function test_can_listen_for_lesson_watched_event(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        LessonWatchedEventTestHelper::fire();

        Event::assertDispatched(LessonWatched::class);

        Event::assertListening(LessonWatched::class, LessonWatchedListener::class);
    }

    /**
     * Can trigger event when achievement is unlocked
     */
    public function test_can_trigger_event_when_achievement_is_unlocked(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        /**
         * Create the lesson and attached it to a user
         */
        $lesson = Lesson::factory()->create();

        $user = User::factory()->create();

        $user->watched()->sync([$lesson->id]);

        /**
         * Create an instance of the event and manually trigger the listener
         */
        $event = new LessonWatched($lesson, $user);

        $listener = new LessonWatchedListener();

        $listener->handle($event);

        /**
         * Check if AchievementUnlocked event was fired with the right properties
         */
        Event::assertDispatched(function (AchievementUnlocked $event) use($user) {
            return $event->achievement_name === config('achievements.watched.1')
                    && $event->user === $user;
        });
    }

    /**
     * Event not triggered when achievement level is not reached
     */
    public function test_event_not_dispatched_when_achievement_level_is_not_reached(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        /**
         * Create the lesson and attached it to a user
         */
        $lessons = Lesson::factory(2)->create();

        $user = User::factory()->create();

        $user->watched()->sync($lessons->pluck('id')->toArray());


        /**
         * Create an instance of the event and manually trigger the listener
         */
        $event = new LessonWatched($lessons->first(), $user);

        $listener = new LessonWatchedListener();

        $listener->handle($event);

        /**
         * Check if AchievementUnlocked event was fired
         */
        Event::assertNotDispatched(AchievementUnlocked::class);
    }

    /**
     * Event is dispatched when badge level is reached
     */
    public function test_badge_unlocked_event_dispatched_when_badge_level_is_reached(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        /**
         * Create four lessons and attached it to a user
         */
        $lessons = Lesson::factory(4)->create();

        $user = User::factory()->create();

        $user->watched()->sync($lessons->pluck('id')->toArray());

        /**
         * Create an instance of the event and manually trigger the listener
         */
        $event = new LessonWatched($lessons->first(), $user);

        $listener = new LessonWatchedListener();

        $listener->handle($event);

        /**
         * Check if BadgeUnlocked event was fired
         */
        Event::assertDispatched(BadgeUnlocked::class);
    }

    /**
     * Event is not dispatched when badge level is reached
     */
    public function test_badge_unlocked_event_not_dispatched_when_badge_level_is_not_reached(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        /**
         * Create three lessons and attached it to a user
         */
        $lessons = Lesson::factory(3)->create();

        $user = User::factory()->create();

        $user->watched()->sync($lessons->pluck('id')->toArray());

        /**
         * Create an instance of the event and manually trigger the listener
         */
        $event = new LessonWatched($lessons->first(), $user);

        $listener = new LessonWatchedListener();

        $listener->handle($event);

        /**
         * Check if BadgeUnlocked event was fired
         */
        Event::assertNotDispatched(BadgeUnlocked::class);
    }

    /**
     * Can store user achievement in the database
     */
    public function test_can_store_user_achievement_in_the_database(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        /**
         * Create the lesson and attached it to a user
         */
        $lesson = Lesson::factory()->create();

        $user = User::factory()->create();

        $user->watched()->sync([$lesson->id]);

        /**
         * Create an instance of the event and manually trigger the listener
         */
        $event = new LessonWatched($lesson, $user);

        $listener = new LessonWatchedListener();

        $listener->handle($event);

        /**
         * Check if AchievementUnlocked event was fired with the right properties
         */
        Event::assertDispatched(function (AchievementUnlocked $event) use($user) {
            return $event->achievement_name === config('achievements.watched.1')
                    && $event->user === $user;
        });

        $achievement = Achievement::where('name', config('achievements.watched.1'))->first();

        $this->assertDatabaseHas('achievement_user', [
            'user_id' => $user->id,
            'achievement_id' => $achievement->id
        ]);
    }

    /**
     * Can store badge in the database when badge is unlocked
     */
    public function test_can_store_badge_in_the_database(): void
    {
        Event::fake();

        Event::assertNothingDispatched();

        /**
         * Create four lessons and attached it to a user
         */
        $lessons = Lesson::factory(4)->create();

        $user = User::factory()->create();

        $user->watched()->sync($lessons->pluck('id')->toArray());

        /**
         * Create an instance of the event and manually trigger the listener
         */
        $event = new LessonWatched($lessons->first(), $user);

        $listener = new LessonWatchedListener();

        $listener->handle($event);

        /**
         * Check if BadgeUnlocked event was fired
         */
        Event::assertDispatched(BadgeUnlocked::class);

        $badge = Badge::where('name', config('badges.4'))->first();

        $this->assertDatabaseHas('badge_user', [
            'user_id' => $user->id,
            'badge_id' => $badge->id
        ]);
    }
}
