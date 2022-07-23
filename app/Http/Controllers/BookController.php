<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $count = 0;
        foreach ($books as $book) {
            $books[$count]->ratings = $book->ratings;
            $count++;
        }
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
        $validated = $request->validate([
            'title' => 'required|max:75|unique:books',
            'subtitle' => 'min:3|max:250',
            'language' => 'min:3|max:35',
            'page' => 'integer|digits_between:2,4',
            'published' => 'date|date_format:Y-m-d',
            'genre.id' => 'required|integer|exists:genres,id',
            'publisher.id' => 'required|integer|exists:publishers,id',
            'authors' => 'required|array',
            'authors.*.id' => 'required|integer',
        ]);
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
            $image_name = $this->loadImage($request);
            if($image_name != ''){
                $book->image()->create(['url' => 'images/'. $image_name]);
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
        $book = Book::with(['genre', 'publisher', 'authors'])->where('id', '=', $id)->first();
        $image = null;
        if($book->image){
            $image = Storage::url($book->image['url']);
        }
        return response()->json(['book' => $book, 'image' => $image]);
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
            'title' => 'required|max:75|unique:books,title,' . $id,
            'subtitle' => 'min:3|max:250',
            'language' => 'min:3|max:35',
            'page' => 'integer|digits_between:2,4',
            'published' => 'date|date_format:Y-m-d',
            'genre.id' => 'required|integer|exists:genres,id',
            'publisher.id' => 'required|integer|exists:publishers,id',
            'authors' => 'required|array',
            'authors.*.id' => 'required|integer',
        ]);
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
            $image_name = $this->loadImage($request);
            if($image_name != ''){
                $book->image()->update(['url' => 'images/'. $image_name]);
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

    public function loadImage($request){
        $image_name = '';
        if($request->hasFile('image')) {
            $destination_path = 'public/images';
            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $request->file('image')->storeAs($destination_path, $image_name);
        }
        return $image_name;
    }
}
