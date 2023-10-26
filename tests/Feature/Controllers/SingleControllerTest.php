<?php

namespace Tests\Feature\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SingleControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_method()
    {
//        $this->withoutExceptionHandling();
        $post = Post::factory()->hasComments(rand(0, 3))->create();

        $response = $this->get(route("single", $post->id));

//        $response->assertOk();
        $response->assertStatus(200);
        $response->assertViewIs("single");
        $response->assertViewHasAll([
            "post" => $post,
            "comments" => $post->comments()->latest()->paginate(10)
        ]);
    }

    public function testCommentMethodWhenUserLoggedIn()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $comment = Comment::factory()->state([
            "user_id" => $user->id,
            "commentable_id" => $post->id,
        ])->make()->toArray();

        $response = $this->actingAs($user)
            ->withHeaders([
                "HTTP_X-Requested-with" => "XMLHttpRequest"
            ])
            ->postJson(route("single.comment", $post->id), ["text" => $comment["text"]]);
        $response->assertOk()->assertJson([
            "created" => true
        ]);
        $this->assertDatabaseHas("comments", $comment);
    }

    public function testCommentMethodWhenUserNotLoggedIn()
    {
        $post = Post::factory()->create();

        $comment = Comment::factory()->state([
            "commentable_id" => $post->id,
        ])->make()->toArray();

        unset($comment["user_id"]);

        $response = $this
            ->withHeaders([
                "HTTP_X-Requested-with" => "XMLHttpRequest"
            ])
            ->postJson(route("single.comment", $post->id), ["text" => $comment["text"]]);
        $response->assertUnauthorized();
        $this->assertDatabaseMissing("comments", $comment);
    }
}
