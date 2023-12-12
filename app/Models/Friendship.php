<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = ['user_first','user_second'];

    public function user_first(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function user_second(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
