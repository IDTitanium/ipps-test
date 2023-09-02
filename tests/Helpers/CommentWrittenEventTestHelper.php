<?php

namespace Tests\Helpers;

use App\Events\CommentWritten;
use App\Models\Comment;

class CommentWrittenEventTestHelper
{
    /**
     * Create a comment and Fire the comment written event
     *
     * @return void
     */
    public static function fire(): void {
        $comment = Comment::factory(1)->create();
        event(new CommentWritten($comment->first()));
    }
}
