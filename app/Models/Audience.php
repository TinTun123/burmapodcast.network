<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function comments() {
        return $this->hasMany(Comment::class, 'audience_id');
    }

    public function answers() {
        return $this->hasMany(Answer::class, 'audience_id');
    }

    public function replies() {
        return $this->hasMany(Replie::class, 'audience_id');
    }
}
