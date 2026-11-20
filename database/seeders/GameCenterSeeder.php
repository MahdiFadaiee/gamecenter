<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use App\Models\GameMatch;
use App\Models\Page;
use App\Models\PlaySession;
use App\Models\Post;
use App\Models\RewardRule;
use App\Models\Tournament;
use App\Models\TournamentRegistration;
use App\Models\User;
use App\Services\PlaytimeRewardService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class GameCenterSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            ['title' => 'Counter-Strike 2', 'slug' => 'counter-strike-2', 'genre' => 'تیراندازی تاکتیکی', 'platform' => 'PC', 'developer' => 'Valve', 'image' => 'site/gamecenter/assets/img/products/product01.jpg', 'summary' => 'تیمی بازی کن و برای جام بعدی آماده شو.', 'featured' => true, 'active' => true],
            ['title' => 'Valorant', 'slug' => 'valorant', 'genre' => 'تیراندازی تاکتیکی', 'platform' => 'PC', 'developer' => 'Riot Games', 'image' => 'site/gamecenter/assets/img/products/product02.jpg', 'summary' => 'ایجنتت را انتخاب کن و با تیم رقابت کن.', 'featured' => true, 'active' => true],
            ['title' => 'EA SPORTS FC', 'slug' => 'ea-sports-fc', 'genre' => 'ورزشی', 'platform' => 'PlayStation', 'developer' => 'EA SPORTS', 'image' => 'site/gamecenter/assets/img/products/product03.jpg', 'summary' => 'رقابت فوتبالی دوستانه یا جدی؛ انتخاب با توست.', 'featured' => false, 'active' => true],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(['slug' => $game['slug']], $game);
        }

        $memberRole = Role::findOrCreate('Member', 'web');
        $profiles = [
            ['username' => 'arin', 'name' => 'آرین', 'email' => 'arin@example.test', 'bio' => 'علاقه‌مند به بازی‌های تیمی و جام‌های آخر هفته.', 'minutes' => 5400, 'game' => 'counter-strike-2'],
            ['username' => 'maryam', 'name' => 'مریم', 'email' => 'maryam@example.test', 'bio' => 'بازیکن ولورانت؛ همیشه آماده‌ی یک رقابت دوستانه.', 'minutes' => 7200, 'game' => 'valorant'],
            ['username' => 'reza', 'name' => 'رضا', 'email' => 'reza@example.test', 'bio' => 'هوادار فوتبال و رقابت‌های EA SPORTS FC.', 'minutes' => 4800, 'game' => 'ea-sports-fc'],
            ['username' => 'sara', 'name' => 'سارا', 'email' => 'sara@example.test', 'bio' => 'برای بازی خوب و رقابت سالم اینجام.', 'minutes' => 3600, 'game' => 'counter-strike-2'],
        ];

        $players = [];
        foreach ($profiles as $profile) {
            $user = User::firstOrCreate(
                ['email' => $profile['email']],
                [
                    'name' => $profile['name'],
                    'username' => $profile['username'],
                    'bio' => $profile['bio'],
                    'status' => true,
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(64)),
                ]
            );
            $user->assignRole($memberRole);
            $players[$profile['username']] = $user;

            $remaining = $profile['minutes'];
            $sessionIndex = 1;
            while ($remaining > 0) {
                $duration = min(240, $remaining);
                $startedAt = now()->subDays($sessionIndex)->setTime(14 + ($sessionIndex % 3), 0);
                PlaySession::updateOrCreate(
                    ['note' => 'demo:'.$profile['username'].':'.$sessionIndex],
                    [
                        'user_id' => $user->id,
                        'game_id' => Game::where('slug', $profile['game'])->value('id'),
                        'started_at' => $startedAt,
                        'ended_at' => $startedAt->copy()->addMinutes($duration),
                        'duration_minutes' => $duration,
                    ]
                );
                $remaining -= $duration;
                $sessionIndex++;
            }
        }

        $openTournament = Tournament::updateOrCreate(
            ['slug' => 'weekend-arena-cup'],
            [
                'game_id' => Game::where('slug', 'counter-strike-2')->value('id'),
                'name' => 'جام آخر هفته آرنا',
                'status' => 'open',
                'description' => 'برای جام آخر هفته ثبت‌نام کن و با بازیکنان گیم‌سنتر رقابت کن.',
                'prize' => 'جایزه ویژه گیم‌سنتر',
                'max_participants' => 32,
                'starts_at' => now()->addDays(7)->setTime(18, 0),
                'ends_at' => now()->addDays(7)->setTime(22, 0),
                'cover_image' => 'site/gamecenter/assets/img/products/product04.jpg',
            ]
        );

        $completedTournament = Tournament::updateOrCreate(
            ['slug' => 'midweek-fc-cup'],
            [
                'game_id' => Game::where('slug', 'ea-sports-fc')->value('id'),
                'name' => 'کاپ دوستانه‌ی فوتبال',
                'status' => 'completed',
                'description' => 'یک رقابت دوستانه‌ی نمایشی از مسابقه‌های برگزارشده.',
                'prize' => 'عنوان قهرمانی',
                'max_participants' => 16,
                'starts_at' => now()->subDays(4)->setTime(17, 0),
                'ends_at' => now()->subDays(4)->setTime(21, 0),
                'cover_image' => 'site/gamecenter/assets/img/products/product05.jpg',
            ]
        );

        foreach (['arin', 'sara'] as $username) {
            TournamentRegistration::updateOrCreate(
                ['tournament_id' => $openTournament->id, 'user_id' => $players[$username]->id],
                ['status' => 'registered', 'registered_at' => now()->subDay()]
            );
        }

        GameMatch::updateOrCreate(
            [
                'tournament_id' => $openTournament->id,
                'round' => 'مرحله‌ی گروهی',
                'player_one_id' => $players['arin']->id,
                'player_two_id' => $players['sara']->id,
            ],
            [
                'scheduled_at' => $openTournament->starts_at,
                'status' => 'scheduled',
                'score_one' => null,
                'score_two' => null,
                'winner_id' => null,
            ]
        );

        GameMatch::updateOrCreate(
            [
                'tournament_id' => $completedTournament->id,
                'round' => 'فینال',
                'player_one_id' => $players['reza']->id,
                'player_two_id' => $players['maryam']->id,
            ],
            [
                'scheduled_at' => now()->subDays(4)->setTime(20, 0),
                'status' => 'completed',
                'score_one' => 2,
                'score_two' => 1,
                'winner_id' => $players['reza']->id,
            ]
        );

        $rule = RewardRule::updateOrCreate(
            ['name' => 'پاداش هر ۱۰۰ ساعت بازی'],
            ['threshold_minutes' => 6000, 'reward_minutes' => 600, 'active' => true]
        );
        $rewardService = app(PlaytimeRewardService::class);
        foreach ($players as $player) {
            $rewardService->issueEligibleAwards($player);
        }

        $category = Category::updateOrCreate(['slug' => 'gaming-news'], ['name' => 'اخبار بازی', 'type' => 'blog', 'status' => true]);
        Post::updateOrCreate(
            ['slug' => 'welcome-to-gamecenter'],
            [
                'category_id' => $category->id,
                'title' => 'به گیم‌سنتر خوش آمدی',
                'excerpt' => 'خانه‌ی بازی، رقابت و جایزه‌های زمان بازی.',
                'body' => 'در گیم‌سنتر پروفایل بساز، بازی‌های مجموعه را ببین و برای جام‌های پیش‌رو ثبت‌نام کن. زمان بازی ثبت‌شده‌ات را دنبال کن تا جایزه‌های خودکار را دریافت کنی.',
                'status' => 'published',
                'published_at' => now(),
            ]
        );
        Page::updateOrCreate(
            ['slug' => 'about'],
            ['title' => 'درباره گیم‌سنتر', 'body' => 'گیم‌سنتر فضایی برای بازی، رقابت سالم و گردهمایی بازیکنان است.', 'status' => 'published']
        );
    }
}
