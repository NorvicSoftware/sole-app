<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class RatingBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'author.id' => 'required|integer|exists:authors,id',
            'rating.id' => 'required|integer|exists:ratings,id',
            'user.id' => 'required|integer|exists:users,id',
        ]);
        try {
            $book = Book::findOrFail($request->book['id']);
            $book ->ratings()->attach($request->rating['id'], ['user_id' => $request->user['id']]);
            return response()->json(['status' => true, 'message' => 'La puntuación del libro ' . $book ->title .' fue creado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al crear el registro' . $exc]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book->ratings()->where('user_id', '=', auth()->user()->id)->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'author.id' => 'required|integer|exists:authors,id',
            'rating.id' => 'required|integer|exists:ratings,id',
            'user.id' => 'required|integer|exists:users,id',
        ]);
        try {
            $book = Book::findOrFail($request->book['id']);
            $book->ratings()->detach();
            $book->ratings()->attach($request->rating['id'], ['user_id' => $request->user['id']]);
            return response()->json(['status' => true, 'message' => 'La puntuación del libro ' . $book->title .' fue creado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al crear el registro' . $exc]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
