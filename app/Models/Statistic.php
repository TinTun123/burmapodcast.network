<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'show_id',
        'episode_id',
        'ip_address',
        'audience_id',
        'city',
        'country',
        'action'
    ];

    public function audience()
    {
        return $this->belongsTo(Audience::class);
    }

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
