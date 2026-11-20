<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Game;
use App\Models\GameMatch;
use App\Models\Page;
use App\Models\Post;
use App\Models\RewardRule;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('site.home', [
            'games' => Game::query()->where('active', true)->orderByDesc('featured')->latest()->limit(6)->get(),
            'tournaments' => Tournament::visible()->with('game')->orderByRaw("CASE WHEN status = 'open' THEN 0 ELSE 1 END")->orderBy('starts_at')->limit(3)->get(),
            'matches' => GameMatch::with(['tournament', 'playerOne', 'playerTwo'])->whereIn('status', ['scheduled', 'completed'])->latest('scheduled_at')->limit(4)->get(),
            'posts' => Post::published()->latest('published_at')->limit(3)->get(),
            'players' => User::where('status', true)->whereHas('roles', fn ($query) => $query->where('name', 'Member'))->withSum('playSessions', 'duration_minutes')->orderByDesc('play_sessions_sum_duration_minutes')->limit(5)->get(),
        ]);
    }

    public function games(): View
    {
        return view('site.games', ['games' => Game::where('active', true)->orderByDesc('featured')->latest()->paginate(12)]);
    }

    public function game(string $slug): View
    {
        $game = Game::where('active', true)->where('slug', $slug)
            ->with(['tournaments' => fn ($query) => $query->whereIn('status', ['open', 'active'])->orderBy('starts_at')])
            ->firstOrFail();

        return view('site.game', compact('game'));
    }

    public function tournaments(): View
    {
        return view('site.tournaments', [
            'tournaments' => Tournament::visible()->with('game')->withCount('registrations')->orderBy('starts_at')->paginate(9),
        ]);
    }

    public function tournament(string $slug): View
    {
        $tournament = Tournament::visible()->where('slug', $slug)->with([
            'game',
            'registrations' => fn ($query) => $query->where('status', 'registered')->with('user')->latest('registered_at'),
            'matches' => fn ($query) => $query->with(['playerOne', 'playerTwo', 'winner'])->orderBy('scheduled_at'),
        ])->firstOrFail();

        return view('site.tournament', compact('tournament'));
    }

    public function schedule(): View
    {
        $matches = GameMatch::with(['tournament', 'playerOne', 'playerTwo', 'winner'])
            ->whereIn('status', ['scheduled', 'completed'])
            ->orderByRaw("CASE WHEN status = 'scheduled' THEN 0 ELSE 1 END")
            ->orderByDesc('scheduled_at')
            ->paginate(20);

        return view('site.schedule', compact('matches'));
    }

    public function blog(): View
    {
        return view('site.blog', ['posts' => Post::published()->with('author')->latest('published_at')->paginate(9)]);
    }

    public function post(string $slug): View
    {
        $post = Post::published()->with('author')->where('slug', $slug)->firstOrFail();

        return view('site.post', compact('post'));
    }

    public function player(string $username): View
    {
        $player = User::whereHas('roles', fn ($query) => $query->where('name', 'Member'))->where('username', $username)->where('status', true)->with([
            'tournamentRegistrations' => fn ($query) => $query->where('status', 'registered')->with('tournament.game')->latest(),
        ])->firstOrFail();

        $sessions = $player->playSessions()->with('game')->whereNotNull('ended_at')->latest('ended_at')->limit(8)->get();
        $awards = $player->rewardAwards()->with('rule')->latest('issued_at')->limit(8)->get();

        return view('site.player', compact('player', 'sessions', 'awards'));
    }

    public function about(): View
    {
        return view('site.info', [
            'title' => 'درباره ما',
            'eyebrow' => 'GAME CENTER',
            'body' => 'اینجا خانه رقابت، بازی و رفاقت است. بازی محبوبت را انتخاب کن، در جام‌ها شرکت کن و رکوردت را با جامعه بازیکنان گیم‌سنتر به اشتراک بگذار.',
        ]);
    }

    public function services(): View
    {
        return view('site.services', ['rules' => RewardRule::where('active', true)->orderBy('threshold_minutes')->get()]);
    }

    public function team(): View
    {
        return view('site.team', [
            'players' => User::where('status', true)->whereHas('roles', fn ($query) => $query->where('name', 'Member'))->withSum('playSessions', 'duration_minutes')
                ->orderByDesc('play_sessions_sum_duration_minutes')->limit(12)->get(),
        ]);
    }

    public function contact(): View
    {
        return view('site.contact');
    }

    public function sendContact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);
        ContactMessage::create($data);

        return back()->with('status', 'پیامت ثبت شد. به‌زودی با تو تماس می‌گیریم.');
    }

    public function page(string $slug): View
    {
        $page = Page::where('slug', $slug)->where('status', 'published')->firstOrFail();

        return view('site.page', compact('page'));
    }
}
