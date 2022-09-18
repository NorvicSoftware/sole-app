<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Note;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
Use App\Repositories\Exports\ExcelBookNotes;
use App\Repositories\BookRepository;

class NoteBookController extends Controller
{
    protected $books;

    public function __construct(BookRepository $books){
        $this->books = $books;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $book = Book::findOrFail($id);
        return response()->json(['book' => $book, 'notes' => $book->note()->where('user_id', '=', auth()->user()->id)->get()]);
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
            'description' => 'required|min:5',
            'writing_date' => 'date|date_format:Y-m-d',
            'book.id' => 'required|integer|exists:books,id',
            'user.id' => 'required|integer|exists:users,id',
        ]);
        try {
            $book = Book::findOrFail($request->book['id']);
            $book->note()->create(['description' => $request->description, 'writing_date' => $request->writing_date, 'user_id' => $request->user['id']]);
            return response()->json(['status' => true, 'message' => 'La nota del libro ' . $book->title .' fue creado exitosamente' ]);
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
        $note = Note::find($id);
        $this->authorize('MyNote', $note);
        return response()->json($note);
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
            'description' => 'required|min:5',
            'writing_date' => 'date',
            'book.id' => 'required|integer|exists:books,id',
            'user.id' => 'required|integer|exists:users,id',
        ]);
        try {
            $note = Note::findOrFail($id);
            $note->description = $request->description;
            $note->writing_date = $request->writing_date;
            $note->save();
            return response()->json(['status' => true, 'message' => 'La nota del libro ' . $request->book['title'] . ' fue actualizado exitosamente' ]);
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
            $note = Note::findOrFail($id);
            $note->delete();
            return response()->json(['status' => true, 'message' => 'La nota fue eliminado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al eliminar el registro']);
        }
    }

    public function generatePDF($id){
        $data = $this->books->getBookNotes($id);
        $pdf = PDF::loadView('books.notes.pdf', $data);
        return $pdf->stream();
    }

    public function generateExcel($id){
        $data = $this->books->getBookNotes($id);
        return Excel::download(new ExcelBookNotes($data), 'NotasDeLibro.xlsx');
    }
}
