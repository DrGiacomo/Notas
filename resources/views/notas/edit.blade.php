@extends('layouts.panel')

@section('content')



<main>
    <div class="container py-4">
        <h2>Editar notas</h2>

        <form action="{{ route('notas.update', $nota) }}" method="post">
            @include('partials.aviso')
            @method("PUT")
            @csrf

               <div class="md-3 row">
                  <label for="nota1" class="col-sm-2 col-form-label">nota 1:</label>
                  <div class="col-sm-5">
                       <input type="number"step="any" class="form-control"  name="nota1"  id="nota1" value="{{$nota->nota1}}" required>
                    </div>
                </div>


                <div class="md-3 row">
                    <label for="nota2" class="col-sm-2 col-form-label">nota 2:</label>
                    <div class="col-sm-5">
                        <input type="number" step="any"class="form-control"  name="nota2"  id="nota2" value="{{ $nota->nota2 }}" required>
                    </div>
                </div>

                <div class="md-3 row">
                    <label for="nota3" class="col-sm-2 col-form-label">nota 3:</label>
                    <div class="col-sm-5">
                        <input type="number"step="any" class="form-control"  name="nota3"  id="nota3" value="{{ $nota->nota3 }}" required>
                    </div>
                </div>


                <div class="md-3 row">
                    <label for="id_estudiantes" class="col-sm-2 col-form-label">Estudiantes:</label>
                    <div class="col-sm-5">
                        <select name="id_estudiantes" id="id_estudiantes" class="form-control" required>
                            <option value="">Seleccionar alumno</option>
                                @foreach ($estudiante as $estudiante)
                                    <option value="{{$estudiante->id}}"  @if ($estudiante->id == $nota->id_estudiantes) {{ 'selected' }}@endif>
                                        {{$estudiante->Nombre}}
                                    </option>"
                                @endforeach
                        </select>

                    </div>
                </div>

                <a href="{{ url('notas') }}"  class="btn btn-secondary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>

        </form>

    </div>
</main>
@endsection
