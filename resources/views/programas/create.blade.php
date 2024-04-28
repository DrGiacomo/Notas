@extends('layouts.panel')
@section('content')


    <div class="container py-4">
        <h2>Registrar Programa</h2>

        <form action="{{ url('programas') }}" method="post">
            @csrf

             <div class="md-3 row">
                  <label for="nombre" class="col-sm-2 col-form-label">Nombre del programa:</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control"  name="nom_programa"  id="nom_programa" value="{{old('nom_programa')}}" required>
                  </div>
              </div>
              <a href="{{ url('programas') }}"  class="btn btn-secondary">Regresar</a>
              <button type="sumit" class="btn btn-success">Guardar</button>
    </div>
    </form>
    </div>
@endsection
