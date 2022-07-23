<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($author_id)
    {
//        $profiles = Profile::with(['author'])->where('author_id', '=', $author_id)->first();
//        $profiles = Author::with(['profile'])->where('id', '=', $author_id)->first();
//        $image = null;
//        if($profiles->image){
//            $image = Storage::url($profiles->image['url']);
//        }
//        return response()->json(['author' => $profiles, 'image' => $image]);
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
            'career' => 'required|max:75',
            'website' => 'max:75',
            'email' => 'email|max:75',
            'author.id' => 'required|integer|exists:authors,id',
        ]);
        try {
            $profile = new Profile();
            $profile->career = $request->career;
            $profile->biography = $request->biography;
            $profile->website = $request->website;
            $profile->email = $request->email;
            $profile->author_id = $request->author['id'];
            $profile->save();
            return response()->json(['status' => true, 'message' => 'El perfil del autor ' . $request->author['full_name'] . ' fue creado exitosamente' ]);
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
//        $profiles = Profile::with(['author'])->where('id', '=', $id)->get();
//        return response()->json($profiles);
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
            'career' => 'required|max:75',
            'website' => 'max:75',
            'email' => 'email|max:75',
            'author.id' => 'required|integer|exists:authors,id',
        ]);
        try {
            $profile = Profile::findOrFail($id);
            $profile->career = $request->career;
            $profile->biography = $request->biography;
            $profile->website = $request->website;
            $profile->email = $request->email;
            $profile->author_id = $request->author['id'];
            $profile->save();
            return response()->json(['status' => true, 'message' => 'El perfil del autor ' . $request->author['full_name'] . ' fue actualizado exitosamente' ]);
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
//        try{
//            $profile = Profile::findOrFail($id);
//            $profile->delete();
//            return response()->json(['status' => true, 'message' => 'El perfil del autor fue eliminado exitosamente' ]);
//        } catch (\Exception $exc){
//            return response()->json(['status' => false, 'message' => 'Error al eliminar el registro']);
//        }
    }
}
