<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'show_id',
        'body',
        'title'
    ];

    public function answers () {
        return $this->hasMany(Answer::class, 'forum_id');
    }
}
