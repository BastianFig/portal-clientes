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
        @php
            $ordenFases = [
                'Diseño',
                'Propuesta Comercial',
                'Contable',
                'Acuerdo Comercial',
                'Fabricación',
                'Despachos',
                'Postventa'
            ];
        @endphp

        @foreach ($proyectosAgrupados->groupBy('id_vendedor') as $vendedorId => $proyectosPorVendedor)
            @php
                $totalProyectos = $totalProyectosPorVendedor[$vendedorId] ?? 0;
                // Ordenar los proyectos por las fases según el orden definido
                $proyectosPorVendedor = $proyectosPorVendedor->sortBy(function ($proyecto) use ($ordenFases) {
                    return array_search($proyecto->fase, $ordenFases);
                });
            @endphp

            @if($totalProyectos > 0)
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
            @else
                <p>No hay proyectos para este vendedor.</p>
            @endif
        @endforeach

    </div> <!-- Fin de la fila -->
@endsection
