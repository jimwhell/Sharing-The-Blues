<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'cover_url', 'title', 'yearReleased', 'album' 
    ];
}
