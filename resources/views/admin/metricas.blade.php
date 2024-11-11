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
    @foreach ($proyectosAgrupados->groupBy('id_vendedor') as $vendedorId => $proyectosPorVendedor)
        @php
            // Obtener el total de proyectos del vendedor
            $totalProyectos = $totalProyectosPorVendedor[$vendedorId];
        @endphp

        <div class="card">
            <div class="card-head">
                <h2>{{ $proyectosPorVendedor->first()->vendedor_nombre }}</h2>
            </div>
            <div class="card-body">
                <div class="fase-container">
                    @foreach ($proyectosPorVendedor as $proyecto)
                        @php
                            // Calcular el porcentaje de proyectos en esta fase
                            $porcentaje = ($proyecto->total_fase / $totalProyectos) * 100;
                        @endphp
                        <div class="fase">
                            <p><strong>Fase: {{ $proyecto->fase_actual }}</strong></p>
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
    @endforeach
@endsection

