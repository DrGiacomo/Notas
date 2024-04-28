<?php

namespace App\Http\Controllers;

use App\Models\nota;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $nota=Nota::all();
        return view('notas.index',['notas'=>$nota]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('notas.create', ['estudiante' =>Estudiante::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nota1' => 'required|max:10',
            'nota2' => 'required|max:255',
            'nota3' => 'required|max:233',
            'definitiva' => 'nullable',
            'id_estudiantes' => 'required',

        ]);

        $nota1 = $request->input('nota1');
        $nota2 = $request->input('nota2');
        $nota3 = $request->input('nota3');
        $definitiva=($nota1+$nota2+$nota3)/3;

        $nota = new Nota();
        $nota->nota1=$nota1;
        $nota->nota2=$nota2;
        $nota->nota3=$nota3;
        $nota->definitiva=$definitiva;
        $nota->id_estudiantes=$request->input('id_estudiantes');
        $nota->save();

        return view("notas.message",['msg'=>"El resgitro a sido guaraddo con exitos"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(nota $nota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $nota=Nota::find($id);
        return view('notas.edit',['nota'=>$nota, 'estudiante'=>Estudiante::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'nota1' => 'required|max:10',
            'nota2' => 'required|max:255',
            'nota3' => 'required|max:255',
            'id_estudiantes' => 'required',

        ]);

        $nota = Nota::find($id);

        $nota1 = $request->input('nota1');
        $nota2 = $request->input('nota2');
        $nota3 = $request->input('nota3');
        $definitiva=($nota1+$nota2+$nota3)/3;


        $nota->nota1=$nota1;
        $nota->nota2=$nota2;
        $nota->nota3=$nota3;
        $nota->definitiva=$definitiva;
        $nota->id_estudiantes=$request->input('id_estudiantes');
        $nota->save();

        return view("notas.message",['msg'=>"El resgistro a sido guarado con exitos"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Nota::destroy($id);
        return redirect('notas');
    }
}
