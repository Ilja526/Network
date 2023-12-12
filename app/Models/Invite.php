<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = ['user_from','user_to'];

    public function user_from(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function user_to(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
