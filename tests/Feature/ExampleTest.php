<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        
        
        $response = $this->get("/users/2/achievements",[
            "accept" => 'application/json'
        ]);
        $response->dump();

        $response->assertStatus(200);
    }
    
}
