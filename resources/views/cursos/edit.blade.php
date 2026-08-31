@extends('layouts.panel')

@section('content')

<main>
    <div class="container py-4">
        <h2>Registrar Curso</h2>

        <form action="{{ route('cursos.update', $curso) }}" method="post">
            @include('partials.aviso')
            @method("PUT")
            @csrf

               <div class="md-3 row">
                  <label for="matricula" class="col-sm-2 col-form-label">Numero de matricula:</label>
                  <div class="col-sm-5">
                       <input type="text" class="form-control"  name="N_curso"  id="N_curso" value="{{$curso->N_curso}}" required>
                    </div>
                </div>


                <div class="md-3 row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre del curso:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control"  name="Nombre"  id="Nombre" value="{{ $curso->Nombre }}" required>
                    </div>
                </div>


                <div class="md-3 row">
                    <label for="id_programa" class="col-sm-2 col-form-label">Programa:</label>
                    <div class="col-sm-5">
                        <select name="id_programa" id="id_programañ" class="form-control" required>
                            <option value="">Seleccionar Programa</option>
                                @foreach ($programas as $programa )
                                    <option value="{{$programa->id}}"  @if ($programa->id == $curso->id_programa) {{ 'selected' }}@endif>
                                        "{{$programa->nom_programa }}"
                                    </option>"
                                @endforeach
                        </select>

                    </div>
                </div>

                <a href="{{ url('cursos') }}"  class="btn btn-secondary">Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>

        </form>

    </div>
</main>
@endsection
