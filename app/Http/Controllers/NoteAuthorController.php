<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Note;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
Use App\Repositories\Exports\ExcelNotes;
use App\Repositories\AuthorRepository;

class NoteAuthorController extends Controller
{
    protected $authors;

    public function __construct(AuthorRepository $authors){
        $this->authors = $authors;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $author = Author::findOrFail($id);
        return response()->json(['author' => $author, 'notes' => $author->note()->where('user_id', '=', auth()->user()->id)->get()]);
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
            'author.id' => 'required|integer|exists:authors,id',
            'user.id' => 'required|integer|exists:users,id',
        ]);
        try {
            $author = Author::findOrFail($request->author['id']);
            $author->note()->create(['description' => $request->description, 'writing_date' => $request->writing_date, 'user_id' => $request->user['id']]);
            return response()->json(['status' => true, 'message' => 'La nota del autor ' . $author->full_name .' fue creado exitosamente' ]);
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
            'writing_date' => 'date|date_format:Y-m-d',
            'author.id' => 'required|integer|exists:authors,id',
            'user.id' => 'required|integer|exists:users,id',
        ]);
        try {
            $note = Note::findOrFail($id);
            $note->description = $request->description;
            $note->writing_date = $request->writing_date;
            $note->save();
            return response()->json(['status' => true, 'message' => 'La nota del autor ' . $request->author['full_name'] . ' fue actualizado exitosamente' ]);
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
        $data = $this->authors->getAuthorNotes($id);
        $pdf = PDF::loadView('authors.notes.pdf', $data);
        return $pdf->stream();
    }

    public function generateExcel($id){
        $data = $this->authors->getAuthorNotes($id);
        return Excel::download(new ExcelNotes($data), 'NotasDeAutor.xlsx');
    }
}
