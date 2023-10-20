<?php

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LayoutViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_layout_view_rendered_when_user_is_admin()
    {
        $admin = User::factory()->state(["type" => "admin"])->create();

        $this->actingAs($admin);

        $view = $this->view("layouts.layout");

        $view->assertSee('<a href="/admin/dashboard">Admin Panel</a>', false);
    }

    public function test_layout_view_rendered_when_user_is_not_admin()
    {
        $user = User::factory()->state(["type" => "user"])->create();

        $this->actingAs($user);

        $view = $this->view("layouts.layout");

        $view->assertDontSee('<a href="/admin/dashboard">Admin Panel</a>', false);
    }
}
