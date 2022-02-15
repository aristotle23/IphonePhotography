<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\BadgeType;
use App\Models\User;
use App\Models\WrittenType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleCommentWritten
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
     * @param  \App\Events\CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $user = $event->comment->user;
        
        $ttlComment = $user->comments()->count();
        
        $achievement = WrittenType::where("written",$ttlComment)->first();
        
        if(!is_null($achievement)){
            Achievement::create([
                "user_id" => $user->id,
                "achievable_id" => $achievement->id,
                "achievable_type" => get_class($achievement)
            ]);
            AchievementUnlocked::dispatch($user,$achievement->title);
        }
       
        
    }
}
