<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Main anime table	
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mal_id')->unique();
            $table->string('url');
            $table->string('title');
            $table->string('title_english')->nullable();
            $table->string('title_japanese')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('type');
            $table->string('source');
            $table->integer('episodes');
            $table->string('status');
            $table->boolean('airing');
            $table->string('aired_from')->nullable();
            $table->string('aired_to')->nullable();
            $table->string('duration');
            $table->string('rating');
            $table->float('score', 4, 2);
            $table->integer('scored_by');
            $table->integer('rank');
            $table->integer('popularity');
            $table->integer('members');
            $table->integer('favorites');
            $table->string('season')->nullable();
            $table->integer('year')->nullable();
            $table->timestamps();
        });

        // Images table	
        Schema::create('anime_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->string('image_url');
            $table->string('small_image_url')->nullable();
            $table->string('large_image_url')->nullable();
            $table->string('type'); // e.g., jpg, webp
            $table->timestamps();
        });

        // Titles table	
        Schema::create('anime_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->string('type'); // e.g., Default, Synonym, Japanese, English
            $table->string('title');
            $table->timestamps();
        });

        // Producers table
        Schema::create('anime_producers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->unsignedBigInteger('mal_id')->unique();
 	        $table->string('type'); 
            $table->string('name');
            $table->string('url');
            $table->timestamps();
        });

        // Licensors table
        Schema::create('anime_licensors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->unsignedBigInteger('mal_id')->unique();
 	        $table->string('type'); 
            $table->string('name');
            $table->string('url');
            $table->timestamps();
        });

        // Studios table
        Schema::create('anime_studios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->unsignedBigInteger('mal_id')->unique();
 	        $table->string('type'); 
            $table->string('name');
            $table->string('url');
            $table->timestamps();
        });

        // Genres table
        Schema::create('anime_genres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->unsignedBigInteger('mal_id')->unique();
 	        $table->string('type'); 	
            $table->string('name');
            $table->string('url');
            $table->timestamps();
        });

        // Demographics table
        Schema::create('anime_demographics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->unsignedBigInteger('mal_id')->unique();
 	        $table->string('type'); 
            $table->string('name');
            $table->string('url');
            $table->timestamps();
        });

        // Trailers table
        Schema::create('anime_trailers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anime_id')->constrained('animes')->onDelete('cascade');
            $table->string('youtube_id');
            $table->string('url');
            $table->string('embed_url');
            $table->string('image_url');
            $table->string('small_image_url')->nullable();
            $table->string('medium_image_url')->nullable();
            $table->string('large_image_url')->nullable();
            $table->string('maximum_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anime_trailers');
        Schema::dropIfExists('anime_demographics');
        Schema::dropIfExists('anime_genres');
        Schema::dropIfExists('anime_studios');
        Schema::dropIfExists('anime_licensors');
        Schema::dropIfExists('anime_producers');
        Schema::dropIfExists('anime_titles');
        Schema::dropIfExists('anime_images');
        Schema::dropIfExists('animes');
    }
};
