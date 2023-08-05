<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'answer',
        'user_id',
        'audience_id'
    ];

    public function replies() {
        return $this->morphMany(Replie::class, 'replyable');
    }

    public function forum() {

        return $this->belongsTo(Forum::class);
        
    }

    public function audience() {

        return $this->belongsTo(Audience::class);

    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function delete() {
        $this->replies()->delete();

        return parent::delete();
    }

}
