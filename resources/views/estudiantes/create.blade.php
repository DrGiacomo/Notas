@extends('layouts.panel')

@section('content')




    <div class="container py-4">
        <h2>Registrar Curso</h2>

        <form action="{{ url('estudiantes') }}" method="post">
            @include('partials.aviso')

            @csrf
            <div class="md-3 row">
                <label for="Nombre" class="col-sm-2 col-form-label">Nombre del estudiante:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control"  name="Nombre"  id="Nombre" value="{{old('Nombre')}}" required>
               </div>
          </div>
          <div class="md-3 row">
                <label for="apellidos" class="col-sm-2 col-form-label">Apellido del estudiante:</label>
              <div class="col-sm-5">
                    <input type="text" class="form-control"  name="apellidos"  id="apellidos" value="{{old('apellidos')}}" required>
              </div>
          </div>
          <div class="md-3 row">
            <label for="id_profesores" class="col-sm-2 col-form-label">Docente:</label>
            <div class="col-sm-5">
                <select name="id_profesores" id="id_profesores" class="form-control" required>
                   <option value="">Seleccionar profesor</option>
                   @foreach ($profesor  as $profesor )
                   <option value="{{$profesor->id }}">{{$profesor->Nombre }}</option>"
                   @endforeach
                </select>
            </div>
              <a href="{{ url('estudiantes') }}"  class="btn btn-secondary">Regresar</a>
              <button type="submit" class="btn btn-success">Guardar</button>
    </div>





    </form>
    </div>
@endsection
