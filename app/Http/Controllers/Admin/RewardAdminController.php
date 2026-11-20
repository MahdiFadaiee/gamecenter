<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardAward;
use App\Models\RewardRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RewardAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.rewards.index', [
            'rules' => RewardRule::orderBy('threshold_minutes')->get(),
            'awards' => RewardAward::with(['user', 'rule'])->latest('issued_at')->paginate(20),
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        RewardRule::create($this->validated($request));
        return back()->with('status', 'قانون جایزه ساخته شد.');
    }
    public function update(Request $request, RewardRule $rule): RedirectResponse
    {
        $rule->update($this->validated($request));
        return back()->with('status', 'قانون جایزه ذخیره شد.');
    }
    public function toggle(RewardRule $rule): RedirectResponse
    {
        $rule->update(['active' => ! $rule->active]);
        return back()->with('status', 'وضعیت قانون تغییر کرد.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'threshold_hours' => ['required', 'numeric', 'min:1', 'max:100000'],
            'reward_hours' => ['required', 'numeric', 'min:0.25', 'max:100000'],
        ]);
        return [
            'name' => $data['name'],
            'threshold_minutes' => (int) round((float) $data['threshold_hours'] * 60),
            'reward_minutes' => (int) round((float) $data['reward_hours'] * 60),
            'active' => $request->boolean('active'),
        ];
    }
}
