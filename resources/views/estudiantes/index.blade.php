@extends('layouts.panel')

@section('content')



<main>
     <div class="container py-4">
       <h2>Listado de Estudiantes </h2>
       <a href="{{url('estudiantes/create')}}" class="btn btn-primary btn-sm">Nuevo registro</a>

       

       <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Profesor</th>
                <th>Curso</th>
                <th>Accion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiante as $estudiantes)
            <tr>
                <td>{{ $estudiantes->id}}</td>
                <td>{{ $estudiantes->Nombre}}</td>
                <td>{{ $estudiantes->apellidos}}</td>
                <td>{{ $estudiantes->profesores->Nombre}}</td>
                <td>{{ $estudiantes->profesores->cursos->Nombre}}</td>
                <td><a href="{{url('estudiantes/'.$estudiantes->id.'/edit')}}" class="btn btn-warning btn-sn">Editar</a></td>
                <td><form action="{{ url('estudiantes/'.$estudiantes->id)}}" method="post">
                    {{ method_field("DELETE") }}
                    @csrf
                    <button type="submit" onclick="return confirm('¿Esta usted seguro de querer borrar estos datos?')"
                    class="btn btn-danger btn-sn">Eliminar</button>
                    </form>
                </td>



            </tr>
            @endforeach
        </tbody>
    </table>
     </div>


</main>
@endsection
