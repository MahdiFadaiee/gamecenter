<?php

namespace App\Providers;

use App\Support\AdminMenuPermissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, string $ability) {
            if (!in_array($ability, AdminMenuPermissions::names(), true) || !$user->hasAnyRole(['Admin', 'admin'])) return null;
            $newMenuPermissions = array_diff(AdminMenuPermissions::names(), [
                'view admin dashboard', 'manage admins', 'manage members',
            ]);
            $configured = $user->roles()->whereIn('name', ['Admin', 'admin'])
                ->whereHas('permissions', fn ($query) => $query->whereIn('name', $newMenuPermissions))->exists();
            return $configured ? null : true;
        });
    }
}
