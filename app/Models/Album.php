<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'visibility',
        'active',
        'user_id',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'album_media');
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->where('active', true);
        });
    }
}
