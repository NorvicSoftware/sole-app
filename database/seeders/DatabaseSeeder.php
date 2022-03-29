<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Image;
use App\Models\Note;
use App\Models\Profile;
use App\Models\Publisher;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('image');
        Storage::makeDirectory('image');
        $this->call(GenreSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(UserSeeder::class);
        User::factory(10)->create();
        Publisher::factory(5)->create();
//        Author::factory(10)->create();
//        Profile::factory(10)->create();
//        Book::factory(20)->create();
        Author::factory()->has(Book::factory()->count(3))->create();
        Author::factory()->has(Book::factory()->count(2))->create();
        Author::factory()->has(Book::factory()->count(2))->create();
        Author::factory()->has(Book::factory()->count(1))->create();
        Profile::factory(4)->create();
        Image::factory(2)->create();
        Note::factory(10)->create();
        Rating::factory()->hasAttached(Book::factory()->count(2), ['user_id' => 1])->create();
//        Book::factory()->hasRatings(1, ['user_id' => 1])->create();
        // \App\Models\User::factory(10)->create();
    }
}
