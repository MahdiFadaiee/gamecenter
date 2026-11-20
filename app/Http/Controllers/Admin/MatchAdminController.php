<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameMatch;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MatchAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.matches.index', ['matches' => GameMatch::with(['tournament', 'playerOne', 'playerTwo', 'winner'])->orderByDesc('scheduled_at')->paginate(20)]);
    }
    public function create(): View { return view('admin.matches.form', $this->formData(new GameMatch)); }
    public function store(Request $request): RedirectResponse
    {
        $match = GameMatch::create($this->validated($request));
        return redirect()->route('admin.gamecenter.matches.edit', $match)->with('status', 'مسابقه به برنامه اضافه شد.');
    }
    public function edit(GameMatch $match): View { return view('admin.matches.form', $this->formData($match)); }
    public function update(Request $request, GameMatch $match): RedirectResponse
    {
        $match->update($this->validated($request));
        return back()->with('status', 'برنامه و نتیجه ذخیره شد.');
    }
    public function destroy(GameMatch $match): RedirectResponse
    {
        $match->delete();
        return redirect()->route('admin.gamecenter.matches.index')->with('status', 'مسابقه حذف شد.');
    }

    private function formData(GameMatch $match): array
    {
        return [
            'match' => $match,
            'tournaments' => Tournament::orderByDesc('starts_at')->get(),
            'members' => User::role('Member')->where('status', true)->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'tournament_id' => ['required', 'integer', Rule::exists('tournaments', 'id')],
            'round' => ['nullable', 'string', 'max:80'],
            'player_one_id' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'player_two_id' => ['nullable', 'integer', 'different:player_one_id', Rule::exists('users', 'id')],
            'scheduled_at' => ['nullable', 'date'],
            'score_one' => ['nullable', 'integer', 'min:0', 'max:999'],
            'score_two' => ['nullable', 'integer', 'min:0', 'max:999'],
            'status' => ['required', Rule::in(['scheduled', 'completed', 'cancelled'])],
        ]);
        $data['winner_id'] = null;
        if ($data['status'] === 'completed' && isset($data['score_one'], $data['score_two']) && $data['score_one'] !== $data['score_two']) {
            $data['winner_id'] = $data['score_one'] > $data['score_two'] ? ($data['player_one_id'] ?? null) : ($data['player_two_id'] ?? null);
        }
        return $data;
    }
}
