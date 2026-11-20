<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameMatch;
use App\Models\PlaySession;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'members' => User::role('Member')->count(),
                'games' => Game::where('active', true)->count(),
                'tournaments' => Tournament::whereIn('status', ['open', 'active'])->count(),
                'playedMinutes' => PlaySession::sum('duration_minutes'),
            ],
            'sessions' => PlaySession::with(['user', 'game'])->latest('started_at')->limit(8)->get(),
            'matches' => GameMatch::with(['tournament', 'playerOne', 'playerTwo'])->where('status', 'scheduled')->orderBy('scheduled_at')->limit(5)->get(),
        ]);
    }
}
