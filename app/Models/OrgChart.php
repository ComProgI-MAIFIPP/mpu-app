<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgChart extends Model
{
    protected $fillable = [
        'image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
