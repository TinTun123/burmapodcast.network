<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replie extends Model
{
    use HasFactory;

    protected $fillable = [
        'replyable_id',
        'replyable_type',
        'content',
        'user_id',
        'audience_id'
    ];

    public function audience() {
        return $this->belongsTo(Audience::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function answer () {
        return $this->morphTo(Answer::class);
    }

    public function comment() {
        return $this->morphTo(Comment::class);
    }
}
