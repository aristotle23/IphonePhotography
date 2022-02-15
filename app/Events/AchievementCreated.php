<?php

namespace App\Events;

use App\Models\Achievement;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AchievementCreated
{
    use Dispatchable, SerializesModels;

    public $achievement;
    

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Achievement $achievement)
    {
        $this->achievement = $achievement;
        
    }

   
}
