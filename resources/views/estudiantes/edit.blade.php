@extends('layout/template')

@section('title', 'ARegistrar | Escuela')

@section('contenido')

<main>
    <div class="container py-4">
        <h2>Registrar Curso</h2>

        <form action="{{ url('estudiantes/'.$estudiante->id) }}" method="post">
            @method("PUT")
            @csrf

               <div class="md-3 row">
                  <label for="Nombre" class="col-sm-2 col-form-label">Numero de matricula:</label>
                  <div class="col-sm-5">
                       <input type="text" class="form-control"  name="Nombre"  id="Nombre" value="{{$estudiante->Nombre}}" required>
                    </div>
                </div>


                <div class="md-3 row">
                    <label for="apellidos" class="col-sm-2 col-form-label">apellido:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control"  name="apellidos"  id="apellidos" value="{{ $estudiante->apellidos }}" required>
                    </div>
                </div>


                <div class="md-3 row">
                    <label for="id_profesores" class="col-sm-2 col-form-label">Profesores</label>
                    <div class="col-sm-5">
                        <select name="id_profesores" id="id_profesores" class="form-control" required>
                            <option value="">Seleccionar Profesores</option>
                                @foreach ($profesores as $profesor )
                                    <option value="{{$profesor->id}}"  @if ($profesor->id == $estudiante->id_profesores) {{ 'selected' }}@endif>
                                        "{{$profesor->Nombre }}"
                                    </option>"
                                @endforeach
                        </select>

                    </div>
                </div>



                <a href="{{ url('estudiantes') }}"  class="btn btn-secondary">Regresar</a>
                <button type="sumit" class="btn btn-success">Guardar</button>

        </form>

    </div>
</main>
@endsection
