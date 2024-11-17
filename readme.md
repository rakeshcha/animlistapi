# MyAnimeList API Integration with Laravel

This Laravel application fetches data from the MyAnimeList API and stores the API responses in a local database. It also provides a RESTful API to access and manage the stored data.

## Features
- Fetch Data from MyAnimeList API: Retrieve anime-related information such as titles, genres, producers, studios, and more
- Database Storage: Store the fetched data in a structured database for optimized querying and retrieval.
- RESTful API: Expose the stored data through a robust REST API.
- Eloquent Relationships: Leverage Laravel's ORM to establish relationships between data entities.
- Pagination and Filtering: Easily paginate and filter API responses.

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/rakeshcha/animlistapi.git
   cd animlistapi
2. Install vandor packages
   ```bash
   composer install    
3. Create .env file: by copying .env.example and renaming then update the database  connection dtails
   ```bash
4. Regenerate your App key
   ```bash
   php artisan key:generate  
5. Migrate database schema
   ```bash
   php artisan migrate
6. To Run Server
   ```bash
   php artisan serve 