<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'episode_number',
        'title',
        'description',
        'audio_url',
        'img_url'

    ];

    public function users(){
        return $this->belongsToMany(User::class, 'episode_user');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function season() {
        return $this->belongsTo(Seasons::class);
    }
 }
