<?php

namespace App\Http\Controllers;

use App\Models\estudiante;
use App\Models\profesore;
use App\Models\Curso;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $estudiante=Estudiante::all();
        return view('estudiantes.index',['estudiante'=>$estudiante]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('estudiantes.create', ['profesor' =>profesore::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'Nombre' => 'required|max:10',
            'apellidos' => 'required|max:255',
            'id_profesores' => 'required',
            //

        ]);

        $estudiante = new Estudiante();
        $estudiante->Nombre=$request->input('Nombre');
        $estudiante->apellidos=$request->input('apellidos');
        $estudiante->id_profesores=$request->input('id_profesores');
        // 
        $estudiante->save();

        return view("estudiantes.message",['msg'=>"El resgitro a sido guaraddo con exitos"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(estudiante $estudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $estudiante=Estudiante::find($id);
        return view('estudiantes.edit',['estudiante'=>$estudiante, 'profesores'=>Profesore::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'Nombre' => 'required|max:10',
            'apellidos' => 'required|max:255',
            'id_profesores' => 'required',
            // 'id_cursos' => 'required',

        ]);

        $estudiante = Estudiante::find($id);
        $estudiante->Nombre=$request->input('Nombre');
        $estudiante->apellidos=$request->input('apellidos');
        $estudiante->id_profesores=$request->input('id_profesores');
        // $estudiante->id_cursos=$request->input('id_cursos');
        $estudiante->save();

        return view("estudiantes.message",['msg'=>"El resgistro a sido guarado con exitos"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Estudiante::destroy($id);
        return redirect('estudiantes');
    }
}
