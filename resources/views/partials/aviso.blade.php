{{-- Sustituye a las cinco vistas *.message: ahora los controladores redirigen
     con ->with('msg', ...) en vez de devolver HTML tras un POST. --}}
@if (session('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
