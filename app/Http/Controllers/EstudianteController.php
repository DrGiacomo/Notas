<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstudianteRequest;
use App\Models\Estudiante;
use App\Models\Profesor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMINISTRADOR|PROFESOR');
    }

    public function index(): View
    {
        return view('estudiantes.index', [
            'estudiante' => Estudiante::with('profesores.cursos')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('estudiantes.create', ['profesor' => Profesor::all()]);
    }

    public function store(EstudianteRequest $request): RedirectResponse
    {
        Estudiante::create($request->validated());

        return redirect()->route('estudiantes.index')
            ->with('msg', 'El registro se ha guardado con éxito.');
    }

    public function edit(Estudiante $estudiante): View
    {
        return view('estudiantes.edit', [
            'estudiante' => $estudiante,
            'profesores' => Profesor::all(),
        ]);
    }

    public function update(EstudianteRequest $request, Estudiante $estudiante): RedirectResponse
    {
        $estudiante->update($request->validated());

        return redirect()->route('estudiantes.index')
            ->with('msg', 'El registro se ha actualizado con éxito.');
    }

    public function destroy(Estudiante $estudiante): RedirectResponse
    {
        $estudiante->delete();

        return redirect()->route('estudiantes.index')
            ->with('msg', 'El registro se ha eliminado.');
    }
}
