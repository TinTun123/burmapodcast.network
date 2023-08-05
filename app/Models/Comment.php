<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'episode_id',
        'name',
        'content',
        'user_level',
        'user_id',
        'audience_id'
    ];

    public function episode() {

        return $this->belongsTo(Episode::class);

    }

    public function replies() {

        return $this->morphMany(Replie::class, 'replyable');
    }

    public function audience() {

        return $this->belongsTo(Audience::class);

    }

    public function user() {

        return $this->belongsTo(User::class);

    }
}
