<?php

use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameAdminController;
use App\Http\Controllers\Admin\MatchAdminController;
use App\Http\Controllers\Admin\MemberAdminController;
use App\Http\Controllers\Admin\PageAdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\RewardAdminController;
use App\Http\Controllers\Admin\SessionAdminController;
use App\Http\Controllers\Admin\TournamentAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Admin|admin|SuperAdmin'])
    ->prefix('admin/gamecenter')
    ->name('admin.gamecenter.')
    ->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('games', GameAdminController::class)->except(['show']);
        Route::resource('tournaments', TournamentAdminController::class)->except(['show']);
        Route::resource('matches', MatchAdminController::class)->except(['show']);
        Route::resource('members', MemberAdminController::class)->except(['show'])->parameters(['members' => 'user']);
        Route::patch('/members/{user}/status', [MemberAdminController::class, 'toggleStatus'])->name('members.status');

        Route::get('/sessions', [SessionAdminController::class, 'index'])->name('sessions.index');
        Route::get('/sessions/create', [SessionAdminController::class, 'create'])->name('sessions.create');
        Route::post('/sessions', [SessionAdminController::class, 'store'])->name('sessions.store');

        Route::get('/rewards', [RewardAdminController::class, 'index'])->name('rewards.index');
        Route::post('/rewards', [RewardAdminController::class, 'store'])->name('rewards.store');
        Route::patch('/rewards/{rule}', [RewardAdminController::class, 'update'])->name('rewards.update');
        Route::patch('/rewards/{rule}/toggle', [RewardAdminController::class, 'toggle'])->name('rewards.toggle');

        Route::resource('posts', PostAdminController::class)->except(['show']);
        Route::resource('pages', PageAdminController::class)->except(['show']);

        Route::get('/messages', [ContactAdminController::class, 'index'])->name('messages.index');
        Route::patch('/messages/{message}', [ContactAdminController::class, 'markRead'])->name('messages.update');
    });
