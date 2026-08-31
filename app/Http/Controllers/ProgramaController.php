<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramaRequest;
use App\Models\Programa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProgramaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:ADMINISTRADOR');
    }

    public function index(): View
    {
        return view('programas.index', ['programas' => Programa::paginate(15)]);
    }

    public function create(): View
    {
        return view('programas.create');
    }

    public function store(ProgramaRequest $request): RedirectResponse
    {
        Programa::create($request->validated());

        return redirect()->route('programas.index')
            ->with('msg', 'El registro se ha guardado con éxito.');
    }

    public function edit(Programa $programa): View
    {
        return view('programas.edit', ['programa' => $programa]);
    }

    public function update(ProgramaRequest $request, Programa $programa): RedirectResponse
    {
        $programa->update($request->validated());

        return redirect()->route('programas.index')
            ->with('msg', 'El registro se ha actualizado con éxito.');
    }

    public function destroy(Programa $programa): RedirectResponse
    {
        $programa->delete();

        return redirect()->route('programas.index')
            ->with('msg', 'El registro se ha eliminado.');
    }
}
