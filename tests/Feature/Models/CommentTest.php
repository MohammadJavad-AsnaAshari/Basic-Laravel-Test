<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_insert_database()
    {
        $comment = Comment::factory()->make()->toArray();
        Comment::create($comment);

        $this->assertDatabaseHas("comments", $comment);
    }

    public function test_comment_relationship_with_post()
    {
        $comment = Comment::factory()->hasCommentable(Post::factory())->create();

        $this->assertInstanceOf(Post::class, $comment->commentable);
        $this->assertTrue(isset($comment->commentable->id));
    }

    public function test_comment_relationship_with_user()
    {
        $comment = Comment::factory()->for(User::factory())->create();

        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertTrue(isset($comment->user->id));
    }
}
