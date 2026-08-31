<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequest;
use App\Models\Curso;
use App\Models\Programa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMINISTRADOR');
    }

    public function index(): View
    {
        return view('cursos.index', ['curso' => Curso::with('programa')->paginate(15)]);
    }

    public function create(): View
    {
        return view('cursos.create', ['programas' => Programa::all()]);
    }

    public function store(CursoRequest $request): RedirectResponse
    {
        Curso::create($request->validated());

        return redirect()->route('cursos.index')
            ->with('msg', 'El registro se ha guardado con éxito.');
    }

    public function edit(Curso $curso): View
    {
        return view('cursos.edit', ['curso' => $curso, 'programas' => Programa::all()]);
    }

    public function update(CursoRequest $request, Curso $curso): RedirectResponse
    {
        $curso->update($request->validated());

        return redirect()->route('cursos.index')
            ->with('msg', 'El registro se ha actualizado con éxito.');
    }

    public function destroy(Curso $curso): RedirectResponse
    {
        $curso->delete();

        return redirect()->route('cursos.index')
            ->with('msg', 'El registro se ha eliminado.');
    }
}
