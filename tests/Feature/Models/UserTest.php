<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Symfony\Component\String\u;

class UserTest extends TestCase
{
    // Use the RefreshDatabase trait to reset the database after each test.
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_insert_database()
    {
        $user = User::factory()->make()->toArray();
        $user["password"] = "password";
        User::create($user);

        $this->assertDatabaseHas("users", $user);
    }

    public function test_user_relationship_with_post()
    {
        $count = rand(1, 10);
//        $user = User::factory()->has(Post::factory()->count($count))->create();
        $user = User::factory()->hasPosts($count)->create();

        $this->assertCount($count, $user->posts);
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }
}
