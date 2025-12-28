<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'artist',
        'image',
        'audio',
        'is_visible',
        'play_count',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Track $track) {
            $track->playlists()->detach();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class)->withPivot(['play_count'])->withTimestamps();
    }
}
