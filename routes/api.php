<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\NoteBookController;
use App\Http\Controllers\NoteAuthorController;
use App\Http\Controllers\RatingAuthorController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RatingBookController;
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
//Route::get('/authors/{id}/notes/generateexcel', [NoteAuthorController::class, 'generateExcel']);

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
        Route::post('/profiles', 'store');
        Route::put('/profiles/{id}', 'update');
    });

    Route::controller(NoteAuthorController::class)->group(function (){
        Route::get('/authors/{id}/notes', 'index');
        Route::post('/authors/notes', 'store');
        Route::get('/authors/notes/{id}', 'show');
        Route::put('/authors/notes/{id}', 'update');
        Route::delete('/authors/notes/{id}', 'destroy');
        Route::get('/authors/{id}/notes/generatepdf', 'generatePDF');
        Route::get('/authors/{id}/notes/generateexcel', 'generateExcel');
    });

    Route::controller(NoteBookController::class)->group(function (){
        Route::get('/books/{id}/notes', 'index');
        Route::post('/books/notes', 'store');
        Route::get('/books/notes/{id}', 'show');
        Route::put('/books/notes/{id}', 'update');
        Route::delete('/books/notes/{id}', 'destroy');
        Route::get('/books/{id}/notes/generatepdf', 'generatePDF');
        Route::get('/books/{id}/notes/generateexcel', 'generateExcel');
    });

//    Route::controller(RatingController::class)->group(function (){
//        Route::get('/ratings', 'index');
//    });

    Route::controller(RatingAuthorController::class)->group(function (){
        Route::post('/authors/ratings', 'store');
        Route::get('/authors/{id}/ratings', 'show');
        Route::put('/authors/ratings/{id}', 'update');
    });


    Route::controller(BookController::class)->group(function (){
        Route::get('/books', 'index');
        Route::post('/books', 'store');
        Route::get('/books/{id}', 'show');
        Route::put('/books/{id}', 'update');
        Route::delete('/books/{id}', 'destroy');
    });

    Route::controller(NoteBookController::class)->group(function (){
        Route::get('/books/{id}/notes', 'index');
        Route::post('/books/notes', 'store');
        Route::put('/books/notes/{id}', 'update');
        Route::delete('/books/notes/{id}', 'destroy');
    });

    Route::controller(RatingBookController::class)->group(function (){
        Route::post('/books/ratings', 'store');
        Route::get('/books/{id}/ratings', 'show');
        Route::put('/books/ratings/{id}', 'update');
    });
});
