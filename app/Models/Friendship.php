<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = ['user_first','user_second'];

    public function user_first(): User
    {
        return User::find($this->user_first);
    }


    public function user_second(): User
    {
        return User::find($this->user_second);
    }
}
