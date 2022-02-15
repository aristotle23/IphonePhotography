<?php

namespace App\Providers;

use App\Events\AchievementCreated;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Listeners\HandleAchievementCreated;
use App\Listeners\HandleCommentWritten;
use App\Listeners\HandleLessonWatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            HandleCommentWritten::class
        ],
        LessonWatched::class => [
            HandleLessonWatched::class
        ],
        AchievementUnlocked::class => [
            //
        ],
        AchievementCreated::class => [
            HandleAchievementCreated::class
        ]
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
