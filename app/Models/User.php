<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, HasFactory, HasRoles, MustVerifyEmailTrait, Notifiable;

    protected $fillable = ['name', 'username', 'email', 'mobile', 'bio', 'status', 'avatar', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'status' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (self $user): void {
            if ($user->username) {
                return;
            }

            $base = Str::slug($user->name) ?: Str::slug(Str::before((string) $user->email, '@'));
            $base = $base ?: 'player';
            $username = $base;
            $suffix = 2;

            while (static::where('username', $username)->exists()) {
                $username = $base.'-'.$suffix++;
            }

            $user->username = $username;
        });
    }

    public function playSessions(): HasMany { return $this->hasMany(PlaySession::class); }
    public function tournamentRegistrations(): HasMany { return $this->hasMany(TournamentRegistration::class); }
    public function rewardAwards(): HasMany { return $this->hasMany(RewardAward::class); }
    public function posts(): HasMany { return $this->hasMany(Post::class, 'author_id'); }

    public function playedMinutes(): int
    {
        return (int) $this->playSessions()->sum('duration_minutes');
    }
}
