<?php

namespace App\Http\Controllers;

use App\Models\Anime; 
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    /**
     * Display the specified anime by slug.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        // Paginate the results, default 25 items per page
        $perPage = 25;
    
        // Query the anime table with slug and related titles
        $animes = Anime::with([
            'images',
            'titles',
            'producers',
            'licensors',
            'studios',
            'genres',
            'demographics',
            'trailers'
        ])
        ->where('title', 'LIKE', "%$slug%") 
        ->orWhereHas('titles', function ($query) use ($slug) {
            $query->where('title', 'LIKE', "%$slug%"); 
        })
        ->paginate($perPage); 
    
        // Check if the query returned results
        if ($animes->isEmpty()) {
            return response()->json([
                'message' => 'No anime found.',
            ], 404);
        }
    
        // Return paginated anime data
        return response()->json($animes, 200);
    }
    
}
