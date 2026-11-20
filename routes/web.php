<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('site.home');
Route::get('/up', static function () {
    try {
        DB::connection()->getPdo();

        return response()->json(['status' => 'ok']);
    } catch (\Throwable $exception) {
        report($exception);

        return response()->json(['status' => 'unavailable'], 503);
    }
})->name('health');

Route::get('/games', [SiteController::class, 'games'])->name('site.games');
Route::get('/games/{slug}', [SiteController::class, 'game'])->name('site.game');
Route::get('/tournaments', [SiteController::class, 'tournaments'])->name('site.tournaments');
Route::get('/tournaments/{slug}', [SiteController::class, 'tournament'])->name('site.tournament');
Route::get('/schedule', [SiteController::class, 'schedule'])->name('site.schedule');
Route::get('/blog', [SiteController::class, 'blog'])->name('site.blog');
Route::get('/blog/{slug}', [SiteController::class, 'post'])->name('site.post');
Route::get('/players/{username}', [SiteController::class, 'player'])->name('site.player');
Route::get('/about-us', [SiteController::class, 'about'])->name('site.about');
Route::get('/services', [SiteController::class, 'services'])->name('site.services');
Route::get('/team', [SiteController::class, 'team'])->name('site.team');
Route::get('/contact', [SiteController::class, 'contact'])->name('site.contact');
Route::post('/contact', [SiteController::class, 'sendContact'])->middleware('throttle:10,1')->name('site.contact.send');
Route::get('/pages/{slug}', [SiteController::class, 'page'])->name('site.page');

Route::middleware(['auth', 'role:Member|Admin|admin|SuperAdmin'])->prefix('member')->name('member.')->group(function (): void {
    Route::get('/', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::post('/sessions', [MemberController::class, 'startSession'])->name('sessions.start');
    Route::post('/sessions/{session}/finish', [MemberController::class, 'finishSession'])->name('sessions.finish');
    Route::post('/tournaments/{tournament}/register', [MemberController::class, 'registerTournament'])->name('tournaments.register');
    Route::post('/rewards/{award}/redeem', [MemberController::class, 'redeemAward'])->name('rewards.redeem');
    Route::get('/profile', [MemberController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile', [MemberController::class, 'updateProfile'])->name('profile.update');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
