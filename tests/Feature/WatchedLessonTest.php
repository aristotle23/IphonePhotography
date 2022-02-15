<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WatchedLessonTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        
        $lesson =  Lesson::factory()->create();
        
        $response = $this->get("/users/2/watch/{$lesson->id}/lesson",[
            "accept" => "application/json"
        ]);

        $response->assertStatus(200);
    }
}
