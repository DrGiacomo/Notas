@extends('layouts.panel')

@section('content')


    <div class="container py-4">
        <h2>Registrar Curso</h2>

        <form action="{{ url('cursos') }}" method="post">

            @csrf
            <div class="md-3 row">
                <label for="matricula" class="col-sm-2 col-form-label">Numero del curso: </label>
                <div class="col-sm-5">
                     <input type="number" class="form-control"  name="N_curso"  id="N_curso" value="{{ old('N_curso') }}" required>
                  </div>
              </div>


              <div class="md-3 row">
                  <label for="nombre" class="col-sm-2 col-form-label">Nombre del curso:</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control"  name="Nombre"  id="Nombre" value="{{old('Nombre')}}" required>
                  </div>
              </div>

              <div class="md-3 row">
                  <label for="nivel" class="col-sm-2 col-form-label">Nivel:</label>
                  <div class="col-sm-5">
                      <select name="id_programa" id="id_programa" class="form-control" required>
                         <option value="">Seleccionar programa</option>
                         @foreach ($programas as $programa)
                         <option value="{{$programa->id }}">
                            "{{$programa->nom_programa}}"</option>
                         @endforeach
                      </select>

                  </div>
              </div>



              <a href="{{ url('cursos') }}"  class="btn btn-secondary">Regresar</a>
              <button type="sumit" class="btn btn-success">Guardar</button>
    </div>
    </form>
    </div>

@endsection


