@extends('layouts.panel')
@section('content')

<main>
     <div class="container py-4">
       <h2>Listado de profesores</h2>
       <a href="{{url('profesores/create')}}" class="btn btn-primary btn-sm">Nuevo registro</a>
       <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Curso</th>
                <th>Accion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($profesor as $profesores)
            <tr>
                <td>{{ $profesores->id}}</td>
                <td>{{ $profesores->Nombre}}</td>
                <td>{{ $profesores->Apellido}}</td>
                <td>{{ $profesores->Correo}}</td>
                <td>{{ $profesores->Telefono}}</td>
                <td>{{ $profesores->cursos->Nombre}}</td>
                <td><a href="{{url('profesores/'.$profesores->id.'/edit')}}" class="btn btn-warning btn-sn">Editar</a></td>
                <td><form action="{{ url('profesores/'.$profesores->id)}}" method="post">
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
