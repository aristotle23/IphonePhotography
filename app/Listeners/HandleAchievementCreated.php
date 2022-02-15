<?php

namespace App\Listeners;

use App\Events\AchievementCreated;
use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\BadgeType;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleAchievementCreated
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
     * @param  \App\Events\AchievementCreated  $event
     * @return void
     */
    public function handle(AchievementCreated $event)
    {
        $user = User::find($event->achievement->user_id);
        $ttlAchievement = $user->achievements()->count();
        $badge = BadgeType::where("achievement", $ttlAchievement)->first();
        if (!is_null($badge)) {
            Badge::create([
                "user_id" => $user->id,
                "badge_type_id" => $badge->id
            ]);
            
            BadgeUnlocked::dispatch($user,$badge->title);
        }
        if ($user->badges()->count() == 0){
            $firstBadge = BadgeType::query()->orderBy("achievement","asc")->first();
            $user->badges()->create([
                "badge_type_id" => $firstBadge->id
            ]);
        }
    }
}
