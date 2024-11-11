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
            background-color: #019ed5; /* Puedes cambiar el color */
            text-align: center;
            color: white;
            line-height: 20px;
            border-radius: 5px;
        }

        .cdh{
            background-color: #019ed5;
            color:white;
        }
    </style>

    <div class="row"> <!-- Contenedor de la fila para las tarjetas -->
        @foreach ($proyectosAgrupados->groupBy('id_vendedor') as $vendedorId => $proyectosPorVendedor)
            @php
                $totalProyectos = $totalProyectosPorVendedor[$vendedorId] ?? 0; // Control de error en caso de no tener proyectos
                // Ordenar los proyectos por las fases según el orden definido
            @endphp

            @if($totalProyectos > 0) <!-- Asegurarse de que haya proyectos para mostrar -->
                <div class="col-md-4 col-lg-4 mb-4"> <!-- Columna para la tarjeta -->
                    <div class="card">
                        <div class="card-head p-3 cdh">
                            <h3>{{ $proyectosPorVendedor->first()->vendedor_nombre }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="fase-container">
                                @foreach ($proyectosPorVendedor as $proyecto)
                                    @php
                                        $porcentaje = ($proyecto->total_fase / $totalProyectos) * 100;
                                    @endphp
                                    <div class="fase">
                                        @if($proyecto->fase == 'Fase Diseño')
                                            <p><strong>Fase Diseño</strong></p>
                                            <div class="d-flex">
                                                <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                                </div>
                                                <span>{{ number_format($porcentaje, 0) }}%</span>
                                            </div>
                                            <p>{{ $proyecto->total_fase }} proyectos</p>
                                        @elseif($proyecto->fase == 'Fase Propuesta Comercial')
                                            <p><strong>Fase Propuesta Comercial</strong></p>
                                            <div class="d-flex">
                                                <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                                </div>
                                                <span>{{ number_format($porcentaje, 0) }}%</span>
                                            </div>
                                            <p>{{ $proyecto->total_fase }} proyectos</p>
                                        @elseif($proyecto->fase == 'Fase Contable')
                                            <p><strong>Fase Contable</strong></p>
                                            <div class="d-flex">
                                                <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                                </div>
                                                <span>{{ number_format($porcentaje, 0) }}%</span>
                                            </div>
                                            <p>{{ $proyecto->total_fase }} proyectos</p>
                                        @elseif($proyecto->fase == 'Fase Acuerdo Comercial')
                                            <p><strong>Fase Acuerdo Comercial</strong></p>
                                            <div class="d-flex">
                                                <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                                </div>
                                                <span>{{ number_format($porcentaje, 0) }}%</span>
                                            </div>
                                            <p>{{ $proyecto->total_fase }} proyectos</p>
                                        @elseif($proyecto->fase == 'Fase Fabricacion')
                                            <p><strong>Fase Fabricación</strong></p>
                                            <div class="d-flex">
                                                <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                                </div>
                                                <span>{{ number_format($porcentaje, 0) }}%</span>
                                            </div>
                                            <p>{{ $proyecto->total_fase }} proyectos</p>
                                        @elseif($proyecto->fase == 'Fase Despachos')
                                            <p><strong>Fase Despachos</strong></p>
                                            <div class="d-flex">
                                                <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                                </div>
                                                <span>{{ number_format($porcentaje, 0) }}%</span>
                                            </div>
                                            <p>{{ $proyecto->total_fase }} proyectos</p>
                                        @elseif($proyecto->fase == 'Fase Postventa')
                                            <p><strong>Fase Postventa</strong></p>
                                            <div class="d-flex">
                                                <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                                </div>
                                                <span>{{ number_format($porcentaje, 0) }}%</span>
                                            </div>
                                            <p>{{ $proyecto->total_fase }} proyectos</p>
                                        @endif
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
