<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'log_details', 'log_type'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
