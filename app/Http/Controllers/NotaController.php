<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotaRequest;
use App\Models\Estudiante;
use App\Models\Nota;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // El estudiante entra al listado; solo mira. Editar es de profesor para arriba.
        $this->middleware('role:ADMINISTRADOR|PROFESOR')->except('index');
    }

    public function index(): View
    {
        return view('notas.index', ['notas' => Nota::with('estudiantes')->paginate(15)]);
    }

    public function create(): View
    {
        return view('notas.create', ['estudiante' => Estudiante::all()]);
    }

    public function store(NotaRequest $request): RedirectResponse
    {
        Nota::create($this->conDefinitiva($request->validated()));

        return redirect()->route('notas.index')
            ->with('msg', 'El registro se ha guardado con éxito.');
    }

    public function edit(Nota $nota): View
    {
        return view('notas.edit', ['nota' => $nota, 'estudiante' => Estudiante::all()]);
    }

    public function update(NotaRequest $request, Nota $nota): RedirectResponse
    {
        $nota->update($this->conDefinitiva($request->validated()));

        return redirect()->route('notas.index')
            ->with('msg', 'El registro se ha actualizado con éxito.');
    }

    public function destroy(Nota $nota): RedirectResponse
    {
        $nota->delete();

        return redirect()->route('notas.index')
            ->with('msg', 'El registro se ha eliminado.');
    }

    /**
     * @param  array<string,mixed>  $datos
     * @return array<string,mixed>
     */
    private function conDefinitiva(array $datos): array
    {
        $datos['definitiva'] = Nota::calcularDefinitiva(
            (float) $datos['nota1'],
            (float) $datos['nota2'],
            (float) $datos['nota3'],
        );

        return $datos;
    }
}
