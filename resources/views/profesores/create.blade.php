@extends('layouts.panel')
@section('content')


    <div class="container py-4">
        <h2>Registrar Profesor</h2>

        <form action="{{ url('profesores') }}" method="post">

            @csrf
             <div class="md-3 row">
                  <label for="nombre" class="col-sm-2 col-form-label">Nombre del profesor:</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control"  name="Nombre"  id="Nombre" value="{{old('Nombre')}}" required>
                 </div>
            </div>
            <div class="md-3 row">
                  <label for="nombre" class="col-sm-2 col-form-label">Apellido del profesor:</label>
                <div class="col-sm-5">
                      <input type="text" class="form-control"  name="Apellido"  id="Apellido" value="{{old('Apellido')}}" required>
                </div>
            </div>
            <div class="md-3 row">
                  <label for="nombre" class="col-sm-2 col-form-label">Correo del profesor:</label>
                  <div class="col-sm-5">
                      <input type="email" class="form-control"  name="Correo"  id="Correo" value="{{old('Correo')}}" required>
                  </div>
            </div>
            <div class="md-3 row">
                  <label for="nombre" class="col-sm-2 col-form-label">Telefono del profesor:</label>
                  <div class="col-sm-5">
                      <input type="number" class="form-control"  name="Telefono"  id="Telefono" value="{{old('Telefono')}}" required>
                  </div>
            </div>
            <div class="md-3 row">
                <label for="id_cursos" class="col-sm-2 col-form-label">Cursos:</label>
                <div class="col-sm-5">
                    <select name="id_cursos" id="id_cursos" class="form-control" required>
                       <option value="">Seleccionar curso</option>
                       @foreach ($cursos  as $cursos )
                       <option value="{{$cursos->id }}">{{$cursos->Nombre }}</option>"
                       @endforeach
                    </select>
                </div>
              <a href="{{ url('profesores') }}"  class="btn btn-secondary">Regresar</a>
              <button type="sumit" class="btn btn-success">Guardar</button>
             </div>
    </form>
    </div>
@endsection
