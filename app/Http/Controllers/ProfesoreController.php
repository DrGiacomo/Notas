<?php

namespace App\Http\Controllers;

use App\Models\profesore;
use App\Models\Curso;
use Illuminate\Http\Request;

class ProfesoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $profesor = Profesore::all();
        return view('profesores.index', ['profesor' => $profesor]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('profesores.create',['cursos' =>Curso::all()]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'Nombre' => 'required|max:255',
            'Apellido' => 'required|max:255',
            'Correo' => 'required|max:255',
            'Telefono' => 'required|max:255',
            'id_cursos' => 'required',


        ]);

        $profesor = new Profesore();
        $profesor->Nombre=$request->input('Nombre');
        $profesor->Apellido=$request->input('Apellido');
        $profesor->Correo=$request->input('Correo');
        $profesor->Telefono=$request->input('Telefono');
        $profesor->id_cursos=$request->input('id_cursos');
        $profesor->save();

        return view("profesores.message",['msg'=>"El resgitro a sido guarado con exitos"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(profesore $profesore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $profesor=Profesore::find($id);
        return view('profesores.edit',['profesor'=>$profesor, 'cursos' =>Curso::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'Nombre' => 'required|max:255',
            'Apellido' => 'required|max:255',
            'Correo' => 'required|max:255',
            'Telefono' => 'required|max:255',
            'id_cursos' => 'required',


        ]);

        $profesor = Profesore::find($id);
        $profesor->Nombre=$request->input('Nombre');
        $profesor->Apellido=$request->input('Apellido');
        $profesor->Correo=$request->input('Correo');
        $profesor->Telefono=$request->input('Telefono');
        $profesor->id_cursos=$request->input('id_cursos');
        $profesor->save();

        return view("profesores.message",['msg'=>"El resgistro a sido guarado con exitos"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Profesore::destroy($id);
        return redirect('profesores');
    }
}
