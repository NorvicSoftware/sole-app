<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Repositories\AuthorRepository;

class AuthorController extends Controller
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
    public function index()
    {
        return response()->json($this->authors->getAuthorsRatings());
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
            'full_name' => 'required|max:75',
            'birth_date' => 'date|date_format:Y-m-d',
            'country' => 'max:75',
            'image' => 'nullable|sometimes|image',
        ]);
        DB::beginTransaction();
        try {
            $author = new Author();
            $author->full_name = $request->full_name;
            $author->birth_date = $request->birth_date;
            $author->country = $request->country;
            $author->save();
            $image_name = $this->loadImage($request);
            if($image_name != ''){
                $author->image()->create(['url' => 'images/'. $image_name]);
            }
            DB::commit();
            return response()->json(['status' => true, 'message' => 'El autor ' . $author->full_name . ' fue creado exitosamente' ]);
        } catch (\Exception $exc){
            DB::rollBack();
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
        $author = Author::with(['profile'])->where('id', '=', $id)->first();
        $image = null;
        if($author->image){
            $image = Storage::url($author->image['url']);
        }
        return response()->json(['author' => $author, 'image' => $image]);
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
            'full_name' => 'required|max:75',
            'birth_date' => 'date|date_format:Y-m-d',
            'country' => 'max:75',
            'image' => 'nullable|sometimes|image',
        ]);
        try {
            $author = Author::findOrFail($id);
            $author->full_name = $request->full_name;
            $author->birth_date = $request->birth_date;
            $author->country = $request->country;
            $author->save();
            $image_name = $this->loadImage($request);
            if($image_name != ''){
                if($author->image != null){
                    $author->image()->update(['url' => 'images/'. $image_name]);
                }
                else {
                    $author->image()->create(['url' => 'images/'. $image_name]);
                }
            }
            return response()->json(['status' => true, 'message' => 'El autor ' . $author->full_name . ' fue actualizado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al editar el registro' . $exc]);
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
            $author = Author::findOrFail($id);
            $author->delete();
            if($author->image()){
                $author->image()->delete();
            }
            return response()->json(['status' => true, 'message' => 'El autor ' . $author->full_name . ' fue eliminado exitosamente' ]);
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
