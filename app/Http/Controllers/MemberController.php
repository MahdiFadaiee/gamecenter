<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\PlaySession;
use App\Models\RewardAward;
use App\Models\RewardRule;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use App\Services\PlaytimeRewardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();
        $minutes = $user->playedMinutes();
        $rule = RewardRule::where('active', true)->orderBy('threshold_minutes')->first();
        $toNextReward = $rule ? $rule->threshold_minutes - ($minutes % $rule->threshold_minutes) : null;
        return view('member.dashboard', [
            'user' => $user,
            'playedMinutes' => $minutes,
            'rewardRule' => $rule,
            'toNextReward' => $toNextReward,
            'progress' => $rule ? (int) floor((($minutes % $rule->threshold_minutes) / $rule->threshold_minutes) * 100) : 0,
            'activeSession' => $user->playSessions()->whereNull('ended_at')->with('game')->latest('started_at')->first(),
            'sessions' => $user->playSessions()->with('game')->latest('started_at')->limit(8)->get(),
            'awards' => $user->rewardAwards()->with('rule')->latest('issued_at')->limit(8)->get(),
            'games' => Game::where('active', true)->orderBy('title')->get(),
            'tournaments' => Tournament::where('status', 'open')->with('game')->orderBy('starts_at')->limit(4)->get(),
        ]);
    }

    public function startSession(Request $request): RedirectResponse
    {
        $data = $request->validate(['game_id' => ['nullable', 'integer', Rule::exists('games', 'id')->where('active', true)]]);
        $user = $request->user();
        if ($user->playSessions()->whereNull('ended_at')->exists()) {
            return back()->withErrors(['session' => 'یک نشست بازی در حال اجراست؛ ابتدا همان را پایان بده.']);
        }
        PlaySession::create(['user_id' => $user->id, 'game_id' => $data['game_id'] ?? null, 'started_at' => now()]);
        return back()->with('status', 'زمان بازی ثبت شد.');
    }

    public function finishSession(Request $request, PlaySession $session, PlaytimeRewardService $rewards): RedirectResponse
    {
        abort_unless($session->user_id === $request->user()->id && $session->ended_at === null, 404);
        $session->ended_at = now();
        $session->duration_minutes = intdiv(max(0, $session->started_at->diffInSeconds($session->ended_at)), 60);
        $session->save();
        $issued = $rewards->issueEligibleAwards($request->user());
        return back()->with('status', $issued ? "نشست پایان یافت و {$issued} جایزه برایت فعال شد." : 'نشست بازی پایان یافت.');
    }

    public function registerTournament(Request $request, Tournament $tournament): RedirectResponse
    {
        DB::transaction(function () use ($request, $tournament): void {
            $locked = Tournament::whereKey($tournament->id)->lockForUpdate()->firstOrFail();
            abort_unless($locked->status === 'open', 422, 'ثبت‌نام این جام بسته است.');
            $existing = TournamentRegistration::where('tournament_id', $locked->id)->where('user_id', $request->user()->id)->first();
            if ($existing?->status === 'registered') {
                return;
            }
            $count = $locked->registrations()->where('status', 'registered')->count();
            abort_if($locked->max_participants && $count >= $locked->max_participants, 422, 'ظرفیت جام تکمیل شده است.');
            TournamentRegistration::updateOrCreate(
                ['tournament_id' => $locked->id, 'user_id' => $request->user()->id],
                ['status' => 'registered', 'registered_at' => now(), 'placement' => null]
            );
        });
        return back()->with('status', 'ثبت‌نامت در جام انجام شد.');
    }

    public function redeemAward(Request $request, RewardAward $award): RedirectResponse
    {
        abort_unless($award->user_id === $request->user()->id && $award->status === 'available', 404);
        $award->update(['status' => 'redeemed', 'redeemed_at' => now()]);
        return back()->with('status', 'جایزه برای استفاده در گیم‌سنتر ثبت شد.');
    }

    public function editProfile(Request $request): View
    {
        return view('member.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'username' => ['required', 'alpha_dash', 'min:3', 'max:32', Rule::unique('users', 'username')->ignore($user->id)],
            'mobile' => ['nullable', 'string', 'max:30', Rule::unique('users', 'mobile')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'url', 'max:500'],
        ]);
        $user->update($data);
        return back()->with('status', 'پروفایلت به‌روزرسانی شد.');
    }
}
