<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);
Route::get('/users/{user}/watch/{lesson}/lesson', [AchievementsController::class, "lessonWatched"]);
Route::post("/users/comment",[AchievementsController::class,"commentWritten"]);