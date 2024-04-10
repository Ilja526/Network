<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupPost extends Model
{
    protected $fillable = ['content', 'image', 'user_id', 'file', 'file_origin_name', 'group_id'];


    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo{
        return $this->belongsTo(Group::class);
    }
}
