<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'uuid', 'title', 'description', 'price', 'price_unit', 'tags',
    ];

    protected $dates = [
        'published_at', 'created_at', 'modified_at',
    ];
}
