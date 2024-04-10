<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function users(): BelongsToMany{
      return $this->belongsToMany(User::class);
    }

    public function groupInvites(): HasMany{
        return $this->hasMany(GroupInvite::class);
    }

    public function groupPosts(): HasMany{
        return $this->hasMany(GroupPost::class);
    }
}
