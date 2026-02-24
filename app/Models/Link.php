<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /** @use HasFactory<\Database\Factories\LinkFactory> */
    use HasFactory;
    protected $fillable = [
        'link_category_id',
        'title',
        'url',
        'image',
        'is_active',
    ];

    public function category(){
        return $this->belongsTo(LinkCategory::class);
    }
}
