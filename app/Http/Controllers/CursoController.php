<?php

namespace App\Http\Controllers;

use App\Models\curso;
use App\Models\programa;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datos['curso']=Curso::all();
        return view('cursos.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('cursos.create', ['programas' =>Programa::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'N_curso' => 'required|unique:cursos|max:10',
            'Nombre' => 'required|max:255',
            'id_programa' => 'required',

        ]);

        $curso = new Curso();
        $curso->N_curso=$request->input('N_curso');
        $curso->Nombre=$request->input('Nombre');
        $curso->id_programa=$request->input('id_programa');
        $curso->save();

        return view("cursos.message",['msg'=>"El resgitro a sido guaraddo con exitos"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $curso=Curso::find($id);
        return view('cursos.edit',['curso'=>$curso, 'programas'=>Programa::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'N_curso' => 'required|max:10|unique:cursos,N_curso,' .$id,
            'Nombre' => 'required|max:255',
            'id_programa' => 'required',

        ]);

        $curso = Curso::find($id);
        $curso->N_curso=$request->input('N_curso');
        $curso->Nombre=$request->input('Nombre');
        $curso->id_programa=$request->input('id_programa');
        $curso->save();

        return view("cursos.message",['msg'=>"El resgistro a sido guarado con exitos"]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Curso::destroy($id);
        return redirect('cursos');
    }
}
