<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RatingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function (){
    Route::controller(GenreController::class)->group(function (){
        Route::get('/genres', 'index');
        Route::post('/genres', 'store');
        Route::get('/genres/{id}', 'show');
        Route::put('/genres/{id}', 'update');
        Route::delete('/genres/{id}', 'destroy');
    });
    Route::controller(PublisherController::class)->group(function (){
        Route::get('/publishers', 'index');
        Route::post('/publishers', 'store');
        Route::get('/publishers/{id}', 'show');
        Route::put('/publishers/{id}', 'update');
        Route::delete('/publishers/{id}', 'destroy');
    });
    Route::controller(AuthorController::class)->group(function (){
        Route::get('/authors', 'index');
        Route::post('/authors', 'store');
        Route::get('/authors/{id}', 'show');
        Route::put('/authors/{id}', 'update');
        Route::delete('/authors/{id}', 'destroy');
    });
    Route::controller(ProfileController::class)->group(function (){
        Route::get('/authors/{author_id}/profiles', 'index');
        Route::post('/profiles', 'store');
        Route::get('/profiles/{id}', 'show');
        Route::put('/profiles/{id}', 'update');
        Route::delete('/profiles/{id}', 'destroy');
    });

    Route::controller(BookController::class)->group(function (){
        Route::get('/books', 'index');
        Route::post('/books', 'store');
        Route::get('/books/{id}', 'show');
        Route::put('/books/{id}', 'update');
        Route::delete('/books/{id}', 'destroy');
    });

    Route::controller(NoteController::class)->group(function (){
        Route::get('/books/{id}/notes', 'index');
        Route::post('/notes', 'store');
        Route::get('/notes/{id}', 'show');
        Route::put('/notes/{id}', 'update');
        Route::delete('/notes/{id}', 'destroy');
    });

    Route::controller(RatingController::class)->group(function (){
        Route::get('/ratings', 'index');
        Route::post('/ratings', 'store');
        Route::get('/ratings/{id}', 'show');
        Route::put('/ratings/{id}', 'update');
        Route::delete('/ratings/{id}', 'destroy');
    });
});
