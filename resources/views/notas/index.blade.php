@extends('layouts.panel')

@section('content')



<main>
     <div class="container py-4">
       <h2>Listado de Notas </h2>
       <a href="{{url('notas/create')}}" class="btn btn-primary btn-sm">Nuevo registro</a>
       <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Estudiante</th>
                <th>nota1</th>
                <th>nota2</th>
                <th>nota3</th>
                <th>definitiva</th>
                <th>Accion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notas as $nota)
            <tr>
                <td>{{ $nota->id}}</td>
                <td>{{ $nota->estudiantes->Nombre}}</td>
                <td>{{ $nota->nota1}}</td>
                <td>{{ $nota->nota2}}</td>
                <td>{{ $nota->nota3}}</td>
                <td>{{ $nota->definitiva}}</td>
                @if(Auth::user()->hasRole('ESTUDIANTE'))
                @continue
                @else
                <td><a href="{{url('notas/'.$nota->id.'/edit')}}" class="btn btn-warning btn-sn">Editar</a></td>
                <td><form action="{{ url('notas/'.$nota->id)}}" method="post">
                    {{ method_field("DELETE") }}
                    @csrf
                    <button type="submit" onclick="return confirm('¿Esta usted seguro de querer borrar estos datos?')"
                    class="btn btn-danger btn-sn">Eliminar</button>
                    </form>
                </td>


@endif
            </tr>
            @endforeach
        </tbody>
    </table>
     </div>


</main>
@endsection
