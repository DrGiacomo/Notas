@extends('layouts.panel')

@section('content')

<main>
    <div class="container py-4">
        <h2>Editar estudiante</h2>

        <form action="{{ route('estudiantes.update', $estudiante) }}" method="post">
            @method('PUT')
            @csrf

            @include('partials.aviso')

            <div class="md-3 row">
                <label for="Nombre" class="col-sm-2 col-form-label">Nombre:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="Nombre" id="Nombre"
                           value="{{ old('Nombre', $estudiante->Nombre) }}" required>
                </div>
            </div>

            <div class="md-3 row">
                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="apellidos" id="apellidos"
                           value="{{ old('apellidos', $estudiante->apellidos) }}" required>
                </div>
            </div>

            <div class="md-3 row">
                <label for="id_profesores" class="col-sm-2 col-form-label">Profesor:</label>
                <div class="col-sm-5">
                    <select name="id_profesores" id="id_profesores" class="form-control" required>
                        <option value="">Seleccionar profesor</option>
                        @foreach ($profesores as $profesor)
                            <option value="{{ $profesor->id }}"
                                @selected(old('id_profesores', $estudiante->id_profesores) == $profesor->id)>
                                {{ $profesor->Nombre }} {{ $profesor->Apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</main>
@endsection
