<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    // Speichert einen neuen Ranglisteneintrag
    public function store(Request $request)
    {
        $leaderboard = Leaderboard::create([
            'player_name' => $request->input('player_name'),
            'time_taken' => $request->input('time_taken'),
            'counter' => $request->input('counter'),
        ]);

        return response()->json($leaderboard, 201);
    }

    // Gibt die Rangliste zurück
    public function index()
    {
        $leaderboard = Leaderboard::orderBy('counter', 'asc')
            ->orderBy('time_taken', 'asc')
            ->get();
        return response()->json($leaderboard);
    }
}
