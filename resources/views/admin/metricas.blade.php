@extends('layouts.admin')

@section('content')
    <style>
        .fase-container {
            margin-bottom: 20px;
        }

        .fase {
            margin-bottom: 10px;
        }

        .progress-bar {
            height: 20px;
            background-color: #4caf50; /* Puedes cambiar el color */
            text-align: center;
            color: white;
            line-height: 20px;
            border-radius: 5px;
        }
    </style>

    <div class="row"> <!-- Contenedor de la fila para las tarjetas -->
        @foreach ($proyectosAgrupados->groupBy('id_vendedor') as $vendedorId => $proyectosPorVendedor)
            @php
                $totalProyectos = $totalProyectosPorVendedor[$vendedorId] ?? 0; // Control de error en caso de no tener proyectos
            @endphp

            @if($totalProyectos > 0) <!-- Asegurarse de que haya proyectos para mostrar -->
                <div class="col-md-4 col-lg-4 mb-4"> <!-- Columna para la tarjeta -->
                    <div class="card">
                        <div class="card-head">
                            <h3>{{ $proyectosPorVendedor->first()->vendedor_nombre }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="fase-container">
                                @foreach ($proyectosPorVendedor as $proyecto)
                                    @php
                                        $porcentaje = ($proyecto->total_fase / $totalProyectos) * 100;
                                    @endphp
                                    <div class="fase">
                                        <p><strong>Fase: {{ $proyecto->fase }}</strong></p>
                                        <div class="progress-bar" style="width: {{ $porcentaje }}%">
                                            <span>{{ number_format($porcentaje, 2) }}%</span>
                                        </div>
                                        <p>{{ $proyecto->total_fase }} proyectos</p>
                                    </div>
                                @endforeach
                            </div>
                            <p><strong>Total Proyectos:</strong> {{ $totalProyectos }}</p>
                        </div>
                        <div class="card-footer">
                            <!-- Aquí puedes agregar algún botón o enlace si es necesario -->
                        </div>
                    </div>
                </div>
            @else
                <p>No hay proyectos para este vendedor.</p> <!-- Mensaje de error si no hay proyectos -->
            @endif
        @endforeach
    </div> <!-- Fin de la fila -->
@endsection
