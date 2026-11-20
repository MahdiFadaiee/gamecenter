<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GameAdminController extends Controller
{
    public function index(): View { return view('admin.games.index', ['games' => Game::latest()->paginate(20)]); }
    public function create(): View { return view('admin.games.form', ['game' => new Game]); }
    public function store(Request $request): RedirectResponse
    {
        $game = Game::create($this->validated($request));
        return redirect()->route('admin.gamecenter.games.edit', $game)->with('status', 'بازی ثبت شد.');
    }
    public function edit(Game $game): View { return view('admin.games.form', compact('game')); }
    public function update(Request $request, Game $game): RedirectResponse
    {
        $game->update($this->validated($request, $game));
        return back()->with('status', 'اطلاعات بازی ذخیره شد.');
    }
    public function destroy(Game $game): RedirectResponse
    {
        $game->update(['active' => false]);
        return redirect()->route('admin.gamecenter.games.index')->with('status', 'بازی از سایت خارج شد.');
    }

    private function validated(Request $request, ?Game $game = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'alpha_dash', 'max:180', Rule::unique('games', 'slug')->ignore($game?->id)],
            'genre' => ['nullable', 'string', 'max:80'],
            'platform' => ['nullable', 'string', 'max:80'],
            'developer' => ['nullable', 'string', 'max:120'],
            'image' => ['nullable', 'string', 'max:500'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:20000'],
        ]);
        $data['featured'] = $request->boolean('featured');
        $data['active'] = $request->boolean('active');
        return $data;
    }
}
