<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TournamentAdminController extends Controller
{
    public function index(): View { return view('admin.tournaments.index', ['tournaments' => Tournament::with('game')->withCount('registrations')->latest('starts_at')->paginate(20)]); }
    public function create(): View { return view('admin.tournaments.form', ['tournament' => new Tournament, 'games' => Game::orderBy('title')->get()]); }
    public function store(Request $request): RedirectResponse
    {
        $tournament = Tournament::create($this->validated($request));
        return redirect()->route('admin.gamecenter.tournaments.edit', $tournament)->with('status', 'جام جدید ساخته شد.');
    }
    public function edit(Tournament $tournament): View { return view('admin.tournaments.form', ['tournament' => $tournament, 'games' => Game::orderBy('title')->get()]); }
    public function update(Request $request, Tournament $tournament): RedirectResponse
    {
        $tournament->update($this->validated($request, $tournament));
        return back()->with('status', 'اطلاعات جام ذخیره شد.');
    }
    public function destroy(Tournament $tournament): RedirectResponse
    {
        $tournament->update(['status' => 'completed']);
        return redirect()->route('admin.gamecenter.tournaments.index')->with('status', 'جام بسته شد.');
    }

    private function validated(Request $request, ?Tournament $tournament = null): array
    {
        return $request->validate([
            'game_id' => ['nullable', 'integer', Rule::exists('games', 'id')],
            'name' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'alpha_dash', 'max:180', Rule::unique('tournaments', 'slug')->ignore($tournament?->id)],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'status' => ['required', Rule::in(['draft', 'open', 'active', 'completed'])],
            'description' => ['nullable', 'string', 'max:10000'],
            'max_participants' => ['nullable', 'integer', 'min:2', 'max:10000'],
            'prize' => ['nullable', 'string', 'max:180'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);
    }
}
