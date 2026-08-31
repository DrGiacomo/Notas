@extends('layouts.panel')

@section('content')

<main>
    <div class="container py-4">
        <h2>Listado de Notas</h2>

        @include('partials.aviso')

        @role('ADMINISTRADOR|PROFESOR')
            <a href="{{ route('notas.create') }}" class="btn btn-primary btn-sm">Nuevo registro</a>
        @endrole

        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Estudiante</th>
                    <th>Nota 1</th>
                    <th>Nota 2</th>
                    <th>Nota 3</th>
                    <th>Definitiva</th>
                    @role('ADMINISTRADOR|PROFESOR')
                        <th colspan="2">Acciones</th>
                    @endrole
                </tr>
            </thead>
            <tbody>
                @forelse ($notas as $nota)
                    <tr>
                        <td>{{ $nota->id }}</td>
                        <td>{{ $nota->estudiantes?->Nombre ?? '—' }}</td>
                        <td>{{ $nota->nota1 }}</td>
                        <td>{{ $nota->nota2 }}</td>
                        <td>{{ $nota->nota3 }}</td>
                        <td>{{ $nota->definitiva }}</td>
                        {{-- Antes esto era un @continue dentro del <tr>: dejaba la fila sin cerrar. --}}
                        @role('ADMINISTRADOR|PROFESOR')
                            <td>
                                <a href="{{ route('notas.edit', $nota) }}" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                            <td>
                                <form action="{{ route('notas.destroy', $nota) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('¿Está usted seguro de querer borrar estos datos?')"
                                            class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        @endrole
                    </tr>
                @empty
                    <tr><td colspan="8">Todavía no hay notas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $notas->links() }}
    </div>
</main>
@endsection
