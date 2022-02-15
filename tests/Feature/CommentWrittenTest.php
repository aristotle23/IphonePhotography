<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CommentWrittenTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post("/users/comment",['body' => "hello comment","user_id"=>"2"],[
            "accept" => "application/json"
        ]);
        $response->dump();
        $response->assertStatus(200);
    }
}
