<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfesorRequest;
use App\Models\Curso;
use App\Models\Profesor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfesoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMINISTRADOR');
    }

    public function index(): View
    {
        return view('profesores.index', ['profesor' => Profesor::with('cursos')->paginate(15)]);
    }

    public function create(): View
    {
        return view('profesores.create', ['cursos' => Curso::all()]);
    }

    public function store(ProfesorRequest $request): RedirectResponse
    {
        Profesor::create($request->validated());

        return redirect()->route('profesores.index')
            ->with('msg', 'El registro se ha guardado con éxito.');
    }

    public function edit(Profesor $profesore): View
    {
        return view('profesores.edit', ['profesor' => $profesore, 'cursos' => Curso::all()]);
    }

    public function update(ProfesorRequest $request, Profesor $profesore): RedirectResponse
    {
        $profesore->update($request->validated());

        return redirect()->route('profesores.index')
            ->with('msg', 'El registro se ha actualizado con éxito.');
    }

    public function destroy(Profesor $profesore): RedirectResponse
    {
        $profesore->delete();

        return redirect()->route('profesores.index')
            ->with('msg', 'El registro se ha eliminado.');
    }
}
