<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameMatch extends Model
{
    protected $fillable = ['tournament_id', 'round', 'player_one_id', 'player_two_id', 'winner_id', 'scheduled_at', 'score_one', 'score_two', 'status'];
    protected $casts = ['scheduled_at' => 'datetime'];

    public function tournament(): BelongsTo { return $this->belongsTo(Tournament::class); }
    public function playerOne(): BelongsTo { return $this->belongsTo(User::class, 'player_one_id'); }
    public function playerTwo(): BelongsTo { return $this->belongsTo(User::class, 'player_two_id'); }
    public function winner(): BelongsTo { return $this->belongsTo(User::class, 'winner_id'); }
}
