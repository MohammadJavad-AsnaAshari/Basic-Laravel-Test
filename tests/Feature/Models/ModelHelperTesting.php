<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait ModelHelperTesting
{
    public function test_insert_data()
    {
        $model = $this->model();
        $table = $this->model()->getTable();

        $comment = $model::factory()->make()->toArray();
        if ($model instanceof User)
            $comment["password"] = "password";

        $model::create($comment);

        $this->assertDatabaseHas($table, $comment);
    }

    abstract protected function model(): Model;
}
