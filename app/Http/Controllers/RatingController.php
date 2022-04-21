<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::orderBy('number_star', 'asc')->get();
        return response()->json($ratings);
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
            $rating = new Rating();
            $rating->number_star = $request->number_star;
            $rating->save();
            return response()->json(['status' => true, 'message' => 'La puntuación ' . $rating->number_star . ' fue creado exitosamente' ]);
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
        $rating = Rating::find($id);
        return response()->json($rating);
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
            $rating = Rating::findOrFail($id);
            $rating->number_star = $request->number_star;
            $rating->save();
            return response()->json(['status' => true, 'message' => 'La puntuación ' . $rating->number_star . ' fue actualizado exitosamente' ]);
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
            $rating = Rating::findOrFail($id);
            $rating->delete();
            return response()->json(['status' => true, 'message' => 'La puntuación ' . $rating->number_star . ' fue eliminado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al eliminar el registro']);
        }
    }
}
