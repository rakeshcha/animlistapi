<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;
    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'mal_id', 'url', 'slug', 'title', 'title_english', 'title_japanese',
        'synopsis', 'type', 'source', 'episodes', 'status', 'airing', 
        'aired_from', 'aired_to', 'duration', 'rating', 'score', 
        'scored_by', 'rank', 'popularity', 'members', 'favorites', 
        'season', 'year',
    ];

    public function images()
    {
        return $this->hasMany(AnimeImage::class);
    }

    public function titles()
    {
        return $this->hasMany(AnimeTitle::class);
    }

    public function producers()
    {
        return $this->hasMany(AnimeProducer::class);
    }

    public function licensors()
    {
        return $this->hasMany(AnimeLicensor::class);
    }

    public function studios()
    {
        return $this->hasMany(AnimeStudio::class);
    }

    public function genres()
    {
        return $this->hasMany(AnimeGenre::class);
    }

    public function demographics()
    {
        return $this->hasMany(AnimeDemographic::class);
    }

    public function trailers()
    {
        return $this->hasMany(AnimeTrailer::class);
    }
}
