<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimeImage extends Model
{
    use HasFactory;
    protected $hidden = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'anime_id', 'type', 'image_url', 'small_image_url', 'large_image_url',
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
}
