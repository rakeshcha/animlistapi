<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimeTitle extends Model
{
    use HasFactory;
    protected $hidden = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'anime_id', 'type', 'title',
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
}
