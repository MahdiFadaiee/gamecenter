<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    protected $fillable = ['game_id', 'name', 'slug', 'cover_image', 'status', 'description', 'max_participants', 'prize', 'starts_at', 'ends_at'];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime'];

    public function game(): BelongsTo { return $this->belongsTo(Game::class); }
    public function registrations(): HasMany { return $this->hasMany(TournamentRegistration::class); }
    public function matches(): HasMany { return $this->hasMany(GameMatch::class); }
    public function players() { return $this->belongsToMany(User::class, 'tournament_registrations')->withPivot(['status', 'placement', 'registered_at'])->withTimestamps(); }
    public function scopeVisible($query) { return $query->whereIn('status', ['open', 'active', 'completed']); }
}
