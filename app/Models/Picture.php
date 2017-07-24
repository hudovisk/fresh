<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Picture extends Model
{

    protected $fillable = [
        'advertisement_id', 'path'
    ];

    public function advertisement() {
        $this->belongsTo(Advertisement::class );
    }

    public function getFullUrlAttribute() {
        return isset($this->attributes['path']) ? Storage::url($this->attributes['path']) : null;
    }

}
