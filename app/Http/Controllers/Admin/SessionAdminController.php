<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\PlaySession;
use App\Models\User;
use App\Services\PlaytimeRewardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class SessionAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.sessions.index', ['sessions' => PlaySession::with(['user', 'game', 'recorder'])->latest('started_at')->paginate(30)]);
    }
    public function create(): View
    {
        return view('admin.sessions.create', ['members' => User::role('Member')->where('status', true)->orderBy('name')->get(), 'games' => Game::where('active', true)->orderBy('title')->get()]);
    }
    public function store(Request $request, PlaytimeRewardService $rewards): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'game_id' => ['nullable', 'integer', 'exists:games,id'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['required', 'date', 'after:started_at'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);
        $user = User::role('Member')->findOrFail($data['user_id']);
        $start = Carbon::parse($data['started_at']);
        $end = Carbon::parse($data['ended_at']);
        $session = PlaySession::create([
            ...$data,
            'recorded_by' => $request->user()->id,
            'duration_minutes' => intdiv($start->diffInSeconds($end), 60),
        ]);
        $issued = $rewards->issueEligibleAwards($user);
        return redirect()->route('admin.gamecenter.sessions.index')->with('status', $issued ? "زمان بازی ثبت شد و {$issued} جایزه به عضو تعلق گرفت." : 'زمان بازی ثبت شد.');
    }
}
