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

        $data = $model::factory()->make()->toArray();
        if ($model instanceof User)
            $data["password"] = "password";

        $model::create($data);

        $this->assertDatabaseHas($table, $data);
    }

    abstract protected function model(): Model;
}
