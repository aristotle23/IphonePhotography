<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Models\WatchedType;
use Database\Factories\CommentFactory;
use Database\Factories\LessonFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $lessons = Lesson::factory()
            ->count(20)
            ->create();
        User::factory()->count(2)->create();
        
       

        DB::table("watched_types")->insert([
            ["title" => "First lesson watched", "watched" => 1],
            ["title" => "five lesson watched", "watched" => 5],
            ["title" => "Ten lesson watched", "watched" => 10],
            ["title" => "Twenty Five lesson watched", "watched" => 25],
            ["title" => "Fifty lesson watched", "watched" => 50]
        ]);
        
        DB::table("written_types")->insert([
            ["title" => "First comment written", "written" => 1],
            ["title" => "three comment written", "written" => 3],
            ["title" => "five comment written", "watched" => 5],
            ["title" => "Ten comment written", "watched" => 10],
            ["title" => "Twenty comment written", "watched" => 20],
        ]);
        
        DB::table("badge_types")->insert([
            ["title" => "Beginner", "achievement" => 0],
            ["title" => "Intermediate", "achievement" => 4],
            ["title" => "Advanced", "achievement" => 8],
            ["title" => "Master", "achievement" => 10]
        ]);
        
    }
}
