<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishers = Publisher::orderBy('name', 'asc')->get();
        return response()->json($publishers);
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
            $publisher = new Publisher();
            $publisher->name = $request->name;
            $publisher->country = $request->country;
            $publisher->website = $request->website;
            $publisher->email = $request->email;
            $publisher->description = $request->description;
            $publisher->save();
            return response()->json(['status' => true, 'message' => 'La editorial ' . $publisher->name . ' fue creado exitosamente' ]);
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
        $publisher = Publisher::find($id);
        return response()->json($publisher);
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
            $publisher = Publisher::findOrFail($id);
            $publisher->name = $request->name;
            $publisher->country = $request->country;
            $publisher->website = $request->website;
            $publisher->email = $request->email;
            $publisher->description = $request->description;
            $publisher->save();
            return response()->json(['status' => true, 'message' => 'La editorial ' . $publisher->name . ' fue actualizado exitosamente' ]);
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
            $publisher = Publisher::findOrFail($id);
            $publisher->delete();
            return response()->json(['status' => true, 'message' => 'El genero ' . $publisher->name . ' fue eliminado exitosamente' ]);
        } catch (\Exception $exc){
            return response()->json(['status' => false, 'message' => 'Error al eliminar el registro']);
        }
    }
}
