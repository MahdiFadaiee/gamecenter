<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardAward extends Model
{
    protected $fillable = ['user_id', 'reward_rule_id', 'milestone', 'reward_minutes', 'status', 'issued_at', 'redeemed_at'];
    protected $casts = ['issued_at' => 'datetime', 'redeemed_at' => 'datetime'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function rule(): BelongsTo { return $this->belongsTo(RewardRule::class, 'reward_rule_id'); }
}
