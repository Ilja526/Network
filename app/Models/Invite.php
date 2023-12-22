<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = ['user_from','user_to'];

    public function user_from(): User
    {
        return User::find($this->user_from);
    }


    public function user_to(): User
    {
        return User::find($this->user_to);
    }
}
