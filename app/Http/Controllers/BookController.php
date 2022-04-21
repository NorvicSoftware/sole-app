<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with(['genre', 'publisher', 'authors'])->orderBy('title', 'asc')->get();
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $book = new Book();
            $book->title = $request->title;
            $book->subtitle = $request->subtitle;
            $book->language = $request->language;
            $book->page = $request->page;
            $book->published = $request->published;
            $book->description = $request->description;
            $book->genre_id = $request->genre['id'];
            $book->publisher_id = $request->publisher['id'];
            $book->save();
            foreach ($request->authors as $author) {
                $book->authors()->attach($author['id']);
            }
            return response()->json(['status' => true, 'message' => 'El Libro ' . $book->title . ' fue creado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al crear el registro']);
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
        $book = Book::with(['genre', 'publisher', 'authors'])->where('id', '=', $id)->get();
        return response()->json($book);
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
        try {
            $book = Book::findOrFail($id);
            $book->title = $request->title;
            $book->subtitle = $request->subtitle;
            $book->language = $request->language;
            $book->page = $request->page;
            $book->published = $request->published;
            $book->description = $request->description;
            $book->genre_id = $request->genre['id'];
            $book->publisher_id = $request->publisher['id'];
            $book->save();
            $book->authors()->detach();
            foreach ($request->authors as $author) {
                $book->authors()->attach($author['id']);
            }
            return response()->json(['status' => true, 'message' => 'El Libro ' . $book->title . ' fue actualizado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al editar el registro']);
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
        try{
            $book = Book::findOrFail($id);
            $book->delete();
            return response()->json(['status' => true, 'message' => 'El libro ' . $book->title . ' fue eliminado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al eliminar el registro']);
        }
    }
}
