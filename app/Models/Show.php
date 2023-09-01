<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_img',
        'state'
    ];

    public function seasons() {
        return $this->hasMany(Seasons::class, 'show_id');
    }

    public function forum() {
        return $this->hasMany(Forum::class, 'show_id');
    }
}
