@extends('layouts.panel')

@section('content')



<main>
     <div class="container py-4">
       <h2>Listado de programas</h2>
       @include('partials.aviso')

       <a href="{{url('programas/create')}}" class="btn btn-primary btn-sm">Nuevo registro</a>
       <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Accion</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programas as $programa)
            <tr>
                <td>{{ $programa->id}}</td>
                <td>{{ $programa->nom_programa}}</td>
                <td><a href="{{url('programas/'.$programa->id.'/edit')}}" class="btn btn-warning btn-sn">Editar</a></td>
                <td><form action="{{ url('programas/'.$programa->id)}}" method="post">
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

       {{ $programas->links() }}
     </div>


</main>
@endsection
