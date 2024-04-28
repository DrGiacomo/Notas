@extends('layouts.panel')

@section('content')

<main>
     <div class="container py-4">
       <h2>Listado de cursos </h2>
       <a href="{{url('cursos/create')}}" class="btn btn-primary btn-sm">Nuevo registro</a>
       <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Matricula</th>
                <th>Nombre</th>
                <th>Programa</th>
                <th>Accion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($curso as $curso)
            <tr>
                <td>{{ $curso->id}}</td>
                <td>{{ $curso->N_curso}}</td>
                <td>{{ $curso->Nombre}}</td>
                <td>{{ $curso->programa->nom_programa}}</td>
                <td><a href="{{url('cursos/'.$curso->id.'/edit')}}" class="btn btn-warning btn-sn">Editar</a></td>
                <td><form action="{{ url('cursos/'.$curso->id)}}" method="post">
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
