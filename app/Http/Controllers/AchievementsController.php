<?php

namespace App\Http\Controllers;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\BadgeType;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Models\WatchedType;
use App\Models\WrittenType;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class AchievementsController extends Controller
{
    
    public function index(User $user)
    {
        $nextAvailableAchievements = $this->getNextAvailableAchievement($user);
        $unlockedAchievement = $this->getUnlockedAchievements($user);
        $currentBadge = $this->getCurrentBadge($user);
        $lockedBadges = $this->getLockedBadges($currentBadge);
        $nextBadge = $lockedBadges->first();
        $remaining = $nextBadge->achievement - count($unlockedAchievement);

        
        return response()->json([
            'unlocked_achievements' => $unlockedAchievement,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge->title,
            'next_badge' => $nextBadge->title,
            'remaing_to_unlock_next_badge' => $remaining
        ]);
    }
    private function getUnlockedAchievements(User $user)
    {
        $unlockedAchievement = [];
        $data = $user->achievements()->with(["achievable" => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                WatchedType::class,
                WrittenType::class
            ]);
        }])->get();
        foreach ($data as $achievement) {
            array_push($unlockedAchievement, $achievement->achievable->title);
        }
        
        return $unlockedAchievement;
    }
    private function getCurrentBadge(User $user){
        $badge = $user->badges()->with('badgeType')->orderBy("created_at","desc")->first();
        if(is_null($badge)){
            $firstBadge = BadgeType::query()->orderBy("achievement","asc")->first();
            return $firstBadge;
        }
        return $badge->badgeType;
    }
    private function getLockedBadges($currentBadge){
        $badges = BadgeType::where("achievement", ">", $currentBadge->achievement)->orderBy("achievement","asc");
        return $badges;
    }
    
    private function getNextAvailableAchievement(User $user){
        $data = [];
        $watched = 0;
        $written = 0;
        $currentWatch = $user->achievements()->where("achievable_type", WatchedType::class)->orderBy("created_at","desc")->first();
        if(!is_null($currentWatch)){
            $currentWatch->loadMorph("achievable",[WatchedType::class]);
            $watched = $currentWatch->achievable->watched;
        }
        
        $nextWatchedAchievement = WatchedType::where("watched" ,">",$watched)->orderBy("watched","asc")->first();
        if(!is_null($nextWatchedAchievement)){
            array_push($data,$nextWatchedAchievement->title);
        }

        $currentWritten = $user->achievements()->where("achievable_type", WrittenType::class)->orderBy("created_at","desc")->first();
        if(!is_null($currentWritten)){
            $currentWritten->loadMorph("achievable",[WrittenType::class]);
            $written = $currentWritten->achievable->written;
        }
        $nextWrittenAchievement = WrittenType::where("written", ">", $written)->orderBy("written", "asc")->first();
        if(!is_null($nextWrittenAchievement)){
            array_push($data,$nextWrittenAchievement->title);
        }


        return $data;

    }
    
    public function lessonWatched(Request $request, User $user, Lesson $lesson)
    {
        DB::table("lesson_user")->insert([
            "user_id" => $user->id,
            "lesson_id" => $lesson->id,
            "watched" => true
        ]);
        LessonWatched::dispatch($lesson, $user);
    }
    public function commentWritten(Request $request, User $user)
    {
        $data = $request->validate([
            "user_id" => "required",
            "body" => "required"
        ]);
        $comment = Comment::create($data);

        CommentWritten::dispatch($comment);
    }
}
