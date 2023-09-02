<?php

namespace Tests\Helpers;

use App\Events\LessonWatched;
use App\Models\Lesson;
use App\Models\User;

class LessonWatchedEventTestHelper
{
    /**
     * Create a lesson and Fire the lesson watched event
     *
     * @return void
     */
    public static function fire(): void {
        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();

        $user->watched()->sync([$lesson->id]);

        event(new LessonWatched($lesson, $user));
    }
}
