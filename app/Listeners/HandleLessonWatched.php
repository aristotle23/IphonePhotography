<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\WatchedType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

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
        
        
        $pivot = DB::table("lesson_user")
                        ->selectRaw("distinct(lesson_id)")
                        ->where("user_id",$event->user->id)
                        ->where("watched",true)
                        ->get();
        $ttlWatched = count($pivot);
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
