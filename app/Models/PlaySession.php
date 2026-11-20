<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaySession extends Model
{
    protected $fillable = ['user_id', 'game_id', 'recorded_by', 'started_at', 'ended_at', 'duration_minutes', 'note'];
    protected $casts = ['started_at' => 'datetime', 'ended_at' => 'datetime'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function game(): BelongsTo { return $this->belongsTo(Game::class); }
    public function recorder(): BelongsTo { return $this->belongsTo(User::class, 'recorded_by'); }
}
