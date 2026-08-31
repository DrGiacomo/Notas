@extends('layouts.panel')
@section('content')


    <div class="container py-4">
        <h2>Registrar Programa</h2>

        <form action="{{ route('profesores.update', $profesor) }}" method="post">
            @include('partials.aviso')
            @method("PUT")
            @csrf

        <div class="md-3 row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre del profesor:</label>
            <div class="col-sm-5">
                <input type="text" class="form-control"  name="Nombre"  id="Nombre" value="{{$profesor->Nombre}}" required>
           </div>
      </div>
      <div class="md-3 row">
            <label for="nombre" class="col-sm-2 col-form-label">Apellido del profesor:</label>
          <div class="col-sm-5">
                <input type="text" class="form-control"  name="Apellido"  id="Apellido" value="{{$profesor->Apellido}}" required>
          </div>
      </div>
      <div class="md-3 row">
            <label for="nombre" class="col-sm-2 col-form-label">Correo del profesor:</label>
            <div class="col-sm-5">
                <input type="email" class="form-control"  name="Correo"  id="Correo" value="{{$profesor->Correo}}" required>
            </div>
      </div>
      <div class="md-3 row">
            <label for="nombre" class="col-sm-2 col-form-label">Telefono del profesor:</label>
            <div class="col-sm-5">
                <input type="number" class="form-control"  name="Telefono"  id="Telefono" value="{{$profesor->Telefono}}" required>
            </div>
      </div>
      <div class="md-3 row">
        <label for="id_cursos" class="col-sm-2 col-form-label">curso:</label>
        <div class="col-sm-5">
            <select name="id_cursos" id="id_cursos" class="form-control" required>
                <option value="">Seleccionar Curso</option>
                    @foreach ($cursos as $curso )
                        <option value="{{$curso->id}}"  @if ($curso->id == $profesor->id_cursos) {{ 'selected' }}@endif>
                            "{{$curso->Nombre }}"
                        </option>"
                    @endforeach
            </select>

        </div>
    </div>
              <a href="{{ url('programas') }}"  class="btn btn-secondary">Regresar</a>
              <button type="submit" class="btn btn-success">Guardar</button>
    </div>
    </form>
    </div>
@endsection
