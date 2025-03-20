<?php

use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/leaderboard', [LeaderboardController::class, 'store']);
Route::get('/leaderboard', [LeaderboardController::class, 'index']);
