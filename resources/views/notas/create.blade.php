@extends('layouts.panel')

@section('content')




    <div class="container py-4">
        <h2>Registrar Curso</h2>

        <form action="{{ url('notas') }}" method="post">

            @csrf
            <div class="md-3 row">
                <label for="nota1" class="col-sm-2 col-form-label">Nota 1: </label>
                <div class="col-sm-5">
                     <input type="number" step="any" class="form-control"  name="nota1"  id="nota1" value="{{ old('nota1') }}" required>
                  </div>
              </div>


              <div class="md-3 row">
                  <label for="nota2" class="col-sm-2 col-form-label">Nota 2:</label>
                  <div class="col-sm-5">
                      <input type="number" step="any" class="form-control"  name="nota2"  id="nota2" value="{{old('nota2')}}" required>
                  </div>
              </div>

              <div class="md-3 row">
                  <label for="nota3" class="col-sm-2 col-form-label">Nota 2:</label>
                  <div class="col-sm-5">
                      <input type="number" step="any"class="form-control"  name="nota3"  id="nota3" value="{{old('nota3')}}" required>
                  </div>
              </div>

              <div class="md-3 row">
                  <label for="definitiva" class="col-sm-2 col-form-label">definitiva:</label>
                  <div class="col-sm-5">
                      <input type="number" step="any"class="form-control"  name="definitiva"  id="definitiva" value="{{old('definitiva')}}" disabled>
                  </div>
              </div>

              <div class="md-3 row">
                  <label for="id_estudiante" class="col-sm-2 col-form-label">Alumno:</label>
                  <div class="col-sm-5">
                      <select name="id_estudiantes" id="id_estudiantes" class="form-control" required>
                         <option value="">Seleccionar alumno</option>
                         @foreach ($estudiante as $estudiante)
                         <option value="{{$estudiante->id }}">
                            {{$estudiante->Nombre}}</option>
                         @endforeach
                      </select>

                  </div>
              </div>



              <a href="{{ url('notas') }}"  class="btn btn-secondary">Regresar</a>
              <button type="sumit" class="btn btn-success">Guardar</button>
    </div>





    </form>
    </div>
@endsection
