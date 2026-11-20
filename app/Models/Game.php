<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = ['title', 'slug', 'genre', 'platform', 'developer', 'image', 'summary', 'description', 'featured', 'active'];
    protected $casts = ['featured' => 'boolean', 'active' => 'boolean'];

    public function tournaments(): HasMany { return $this->hasMany(Tournament::class); }
    public function playSessions(): HasMany { return $this->hasMany(PlaySession::class); }
}
