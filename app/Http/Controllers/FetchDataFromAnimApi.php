<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\AnimeImage;
use App\Models\AnimeTitle;
use App\Models\AnimeProducer;
use App\Models\AnimeLicensor;
use App\Models\AnimeStudio;
use App\Models\AnimeGenre;
use App\Models\AnimeDemographic;
use App\Models\AnimeTrailer;
use Illuminate\Support\Facades\Http;

class FetchDataFromAnimApi extends Controller
{

	public function fetchAndStore()
	{
		$baseUrl      = 'https://api.jikan.moe/v4/top/anime';
		$totalRows    = 100; // Total rows to fetch
		$rowsPerPage  = 25; // Rows per API page
		$totalPages   = ceil($totalRows / $rowsPerPage);
		$fetchedCount = 0;

		for ($page = 1; $page <= $totalPages; $page++) {
			$response = Http::get($baseUrl, array('page' => $page));

			// Check if the API call was successful
			if (! $response->successful()) {
				return response()->json(array('message' => 'Failed to fetch data from the API.'), 500);
			}

			$data = $response->json('data');

			foreach ($data as $anime) {
				$this->storeAnimeData($anime);
				++$fetchedCount;
				if ($fetchedCount >= $totalRows) {
					break;
				}
			}
		}

		return response()->json(array('message' => 'Data successfully fetched and stored.'), 200);
	}

	private function storeAnimeData($anime)
	{

		// Check if the Anime already exists using `mal_id`
		$animeCheck = Anime::where('mal_id', $anime['mal_id'])->first();
		if (! $animeCheck) {
			// Store the main anime record
			$animeRecord = Anime::Create(
				array(
					'mal_id'         => $anime['mal_id'],
					'url'            => $anime['url'],
					'title'          => $anime['title'],
					'title_english'  => $anime['title_english'] ?? null,
					'title_japanese' => $anime['title_japanese'] ?? null,
					'synopsis'       => $anime['synopsis'] ?? null,
					'type'           => $anime['type'],
					'source'         => $anime['source'] ?? null,
					'episodes'       => $anime['episodes'] ?? 0,
					'status'         => $anime['status'],
					'airing'         => $anime['airing'],
					'aired_from'     => $anime['aired']['from'] ?? null,
					'aired_to'       => $anime['aired']['to'] ?? null,
					'duration'       => $anime['duration'] ?? null,
					'rating'         => $anime['rating'] ?? null,
					'score'          => $anime['score'] ?? 0,
					'scored_by'      => $anime['scored_by'] ?? 0,
					'rank'           => $anime['rank'] ?? 0,
					'popularity'     => $anime['popularity'] ?? 0,
					'members'        => $anime['members'] ?? 0,
					'favorites'      => $anime['favorites'] ?? 0,
					'season'         => $anime['season'] ?? null,
					'year'           => $anime['year'] ?? null,
				)
			);
		}

		// Store related data
		$this->storeImages($animeRecord->id, $anime['images']);
		$this->storeTitles($animeRecord->id, $anime['titles']);
		$this->storeProducers($animeRecord->id, $anime['producers']);
		$this->storeLicensors($animeRecord->id, $anime['licensors']);
		$this->storeStudios($animeRecord->id, $anime['studios']);
		$this->storeGenres($animeRecord->id, $anime['genres']);
		$this->storeDemographics($animeRecord->id, $anime['demographics']);
		$this->storeTrailer($animeRecord->id, $anime['trailer']);
	}

	private function storeImages($animeId, $images)
	{
		foreach ($images as $type => $imageSet) {
			AnimeImage::create(
				array(
					'anime_id'        => $animeId,
					'type'            => $type,
					'image_url'       => $imageSet['image_url'],
					'small_image_url' => $imageSet['small_image_url'] ?? null,
					'large_image_url' => $imageSet['large_image_url'] ?? null,
				)
			);
		}
	}

	private function storeTitles($animeId, $titles)
	{
		foreach ($titles as $title) {
			AnimeTitle::create(
				array(
					'anime_id' => $animeId,
					'type'     => $title['type'],
					'title'    => $title['title'],
				)
			);
		}
	}

	private function storeProducers($animeId, $producers)
	{
		foreach ($producers as $producer) {

			// Check if the AnimeProducer already exists using `mal_id`
			$AnimeProducer = AnimeProducer::where('mal_id', $producer['mal_id'])->first();
			if (! $AnimeProducer) {
				AnimeProducer::create(
					array(
						'anime_id' => $animeId,
						'mal_id'   => $producer['mal_id'],
						'type'     => $producer['type'],
						'name'     => $producer['name'],
						'url'      => $producer['url'],
					)
				);
			}
		}
	}

	private function storeLicensors($animeId, $licensors)
	{
		foreach ($licensors as $licensor) {
			// Check if the AnimeProducer already exists using `mal_id`
			$AnimeLicensor = AnimeLicensor::where('mal_id', $licensor['mal_id'])->first();
			if (! $AnimeLicensor) {
				AnimeLicensor::create(
					array(
						'anime_id' => $animeId,
						'mal_id'   => $licensor['mal_id'],
						'type'     => $licensor['type'],
						'name'     => $licensor['name'],
						'url'      => $licensor['url'],
					)
				);
			}
		}
	}

	private function storeStudios($animeId, $studios)
	{
		foreach ($studios as $studio) {
			$AnimeStudio = AnimeStudio::where('mal_id', $studio['mal_id'])->first();
			if (! $AnimeStudio) {
				AnimeStudio::create(
					array(
						'anime_id' => $animeId,
						'mal_id'   => $studio['mal_id'],
						'type'     => $studio['type'],
						'name'     => $studio['name'],
						'url'      => $studio['url'],
					)
				);
			}
		}
	}

	private function storeGenres($animeId, $genres)
	{
		foreach ($genres as $genre) {
			$AnimeGenre = AnimeGenre::where('mal_id', $genre['mal_id'])->first();
			if (! $AnimeGenre) {
				AnimeGenre::create(
					array(
						'anime_id' => $animeId,
						'mal_id'   => $genre['mal_id'],
						'type'     => $genre['type'],
						'name'     => $genre['name'],
						'url'      => $genre['url'],
					)
				);
			}
		}
	}

	private function storeDemographics($animeId, $demographics)
	{
		foreach ($demographics as $demographic) {
			$AnimeDemographic = AnimeDemographic::where('mal_id', $demographic['mal_id'])->first();
			if (! $AnimeDemographic) {
				AnimeDemographic::create(
					array(
						'anime_id' => $animeId,
						'mal_id'   => $demographic['mal_id'],
						'type'     => $demographic['type'],
						'name'     => $demographic['name'],
						'url'      => $demographic['url'],
					)
				);
			}
		}
	}

	private function storeTrailer($animeId, $trailer)
	{
		if ($trailer) {
			// Ensure required fields are not null
			if (
				! empty($trailer['youtube_id']) &&
				! empty($trailer['url']) &&
				! empty($trailer['embed_url']) &&
				! empty($trailer['images']['image_url'])
			) {
				AnimeTrailer::create(
					array(
						'anime_id'          => $animeId,
						'youtube_id'        => $trailer['youtube_id'],
						'url'               => $trailer['url'],
						'embed_url'         => $trailer['embed_url'],
						'image_url'         => $trailer['images']['image_url'],
						'small_image_url'   => $trailer['images']['small_image_url'] ?? null,
						'medium_image_url'  => $trailer['images']['medium_image_url'] ?? null,
						'large_image_url'   => $trailer['images']['large_image_url'] ?? null,
						'maximum_image_url' => $trailer['images']['maximum_image_url'] ?? null,
					)
				);
			}
		}
	}
}
