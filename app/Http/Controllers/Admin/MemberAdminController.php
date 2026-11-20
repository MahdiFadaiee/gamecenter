<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class MemberAdminController extends Controller
{
    public function index(Request $request): View
    {
        $members = User::role('Member')->when($request->filled('q'), fn ($q) => $q->where(fn ($sub) => $sub->where('name', 'like', '%'.$request->q.'%')->orWhere('email', 'like', '%'.$request->q.'%')->orWhere('username', 'like', '%'.$request->q.'%')))->latest()->paginate(20)->withQueryString();
        return view('admin.members.index', compact('members'));
    }
    public function create(): View { return view('admin.members.form', ['user' => new User]); }
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['password'] = Hash::make($data['password']);
        $data['status'] = $request->boolean('status');
        $user = User::create($data);
        $user->assignRole(Role::findOrCreate('Member', 'web'));
        return redirect()->route('admin.gamecenter.members.index')->with('status', 'عضو جدید ثبت شد.');
    }
    public function edit(User $user): View
    {
        abort_unless($user->hasRole('Member'), 404);
        return view('admin.members.form', compact('user'));
    }
    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->hasRole('Member'), 404);
        $data = $this->validated($request, $user);
        unset($data['password']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }
        $data['status'] = $request->boolean('status');
        $user->update($data);
        return back()->with('status', 'اطلاعات عضو ذخیره شد.');
    }
    public function toggleStatus(User $user): RedirectResponse
    {
        abort_unless($user->hasRole('Member'), 404);
        $user->update(['status' => ! $user->status]);
        return back()->with('status', 'وضعیت عضویت تغییر کرد.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'username' => ['required', 'alpha_dash', 'min:3', 'max:32', Rule::unique('users', 'username')->ignore($user?->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'mobile' => ['nullable', 'string', 'max:30', Rule::unique('users', 'mobile')->ignore($user?->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:12', 'confirmed'],
        ]);
    }
}
