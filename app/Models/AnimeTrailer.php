<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimeTrailer extends Model
{
    use HasFactory;
    protected $hidden = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'anime_id', 'youtube_id', 'url', 'embed_url', 
        'image_url', 'small_image_url', 'medium_image_url', 
        'large_image_url', 'maximum_image_url',
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
}
