<?php

namespace Tests\Unit;

use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
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
}
