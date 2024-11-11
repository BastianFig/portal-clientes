@extends('layouts.admin')
@section('content')
    @foreach ($proyectos as $proyecto)
        <div class="card">
            <div class="card-head">
                <h2>{{ $proyecto->vendedor_nombre }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Fases:</strong> {{ $proyecto->fases }}</p>
                <p><strong>Total Proyectos:</strong> {{ $proyecto->total_proyectos }}</p>
            </div>
            <div class="card-footer">
                <!-- Aquí puedes agregar algún botón o enlace si es necesario -->
            </div>
        </div>
    @endforeach
@endsection