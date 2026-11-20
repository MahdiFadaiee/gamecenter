<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentRegistration extends Model
{
    protected $fillable = ['tournament_id', 'user_id', 'status', 'placement', 'registered_at'];
    protected $casts = ['registered_at' => 'datetime'];

    public function tournament(): BelongsTo { return $this->belongsTo(Tournament::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
