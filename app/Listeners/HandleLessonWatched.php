<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\WatchedType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Queue\InteractsWithQueue;

class HandleLessonWatched
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        
        $ttlWatched = $event->user->watched()->;
        dd($ttlWatched);
        $achievement = WatchedType::where("watched",$ttlWatched)->first();
        if(!is_null($achievement)){
            Achievement::create([
                "user_id" => $event->user->id,
                "achievable_id" => $achievement->id,
                "achievable_type" => get_class($achievement)
            ]);
            AchievementUnlocked::dispatch($event->user,$achievement->title);
        }
        
        
        
    }
}
