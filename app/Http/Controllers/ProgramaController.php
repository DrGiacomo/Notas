<?php

namespace App\Http\Controllers;

use App\Models\programa;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $programa = Programa::all();
        return view('programas.index', ['programas' => $programa]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('programas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nom_programa' => 'required|max:255',


        ]);

        $programa = new Programa();
        $programa->nom_programa=$request->input('nom_programa');
        $programa->save();

        return view("programas.message",['msg'=>"El resgitro a sido guarado con exitos"]);
    }
        
    /**
     * Display the specified resource.
     */
    public function show(programa $programa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $programa=Programa::find($id);
        return view('programas.edit',['programa'=>$programa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
            $request->validate([
                'nom_programa' => 'required|max:255',


            ]);

            $programa = Programa::find($id);
            $programa->nom_programa=$request->input('nom_programa');
            $programa->save();

            return view("programas.message",['msg'=>"El resgistro a sido guarado con exitos"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Programa::destroy($id);
        return redirect('programas');
    }
}
