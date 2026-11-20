<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RewardRule extends Model
{
    protected $fillable = ['name', 'threshold_minutes', 'reward_minutes', 'active'];
    protected $casts = ['active' => 'boolean'];

    public function awards(): HasMany { return $this->hasMany(RewardAward::class); }
}
