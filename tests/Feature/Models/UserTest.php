<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Symfony\Component\String\u;

class UserTest extends TestCase
{
    // Use the RefreshDatabase trait to reset the database after each test.
//    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_insert_data()
    {
        $user = User::factory()->make()->toArray();
        $user["password"] = "password";
        User::create($user);

        $this->assertDatabaseHas("users", $user);
    }
}
