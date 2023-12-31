<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase,
        ModelHelperTesting;

    protected function model(): Model
    {
        return new Post();
    }

    public function test_post_relationship_with_user()
    {
        $post = Post::factory()->for(User::factory())->create();

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertTrue(isset($post->user->id));
    }

    public function test_post_relationship_with_tag()
    {
        $count = rand(1, 10);
        $post = Post::factory()->hasTags($count)->create();

        $this->assertCount($count, $post->tags);
        $this->assertInstanceOf(Tag::class, $post->tags->first());
    }

    public function test_post_relationship_with_comment()
    {
        $count = rand(1, 10);
        $post = Post::factory()->hasComments($count)->create();

        $this->assertCount($count, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments->first());
    }
}
