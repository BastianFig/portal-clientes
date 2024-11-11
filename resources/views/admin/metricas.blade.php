@extends('layouts.admin')

@section('content')
    <div class="row">
        @foreach ($proyectos as $proyecto)
            <div class="col-md-4 mb-4"> <!-- Columna para 3 cards -->
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $proyecto->vendedor_nombre }}</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Fase Actual:</strong> {{ $proyecto->fase }}</p>
                        <p><strong>Total de Proyectos:</strong> {{ $proyecto->total_proyectos }}</p>
                        
                        <!-- Barra de Progreso -->
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ $proyecto->fase_porcentaje }}%;" 
                                 aria-valuenow="{{ $proyecto->fase_porcentaje }}" 
                                 aria-valuemin="0" aria-valuemax="100">
                                {{ $proyecto->fase_porcentaje }}%
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- Opcional: Aquí puedes poner más detalles si es necesario -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
