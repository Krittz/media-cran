<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumMedia extends Pivot
{
    protected $table = 'album_media';

    protected $fillable = [
        'album_id',
        'media_id',
    ];
}
