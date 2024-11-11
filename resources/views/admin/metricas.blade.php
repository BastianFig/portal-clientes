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
            background-color: #019ed5;
            text-align: center;
            color: white;
            line-height: 20px;
            border-radius: 5px;
        }

        .cdh {
            background-color: #019ed5;
            color: white;
        }

        .separator {
            width: 100%;
            height: 2px;
            background-color: rgba(128, 128, 128, 0.2);
            margin: 20px 0;
        }
    </style>

    @php
        // Definir todas las fases posibles
        $fases = [
            'Fase Diseño', 
            'Fase Propuesta Comercial', 
            'Fase Contable', 
            'Fase Acuerdo Comercial', 
            'Fase Fabricación', 
            'Fase Despachos', 
            'Fase Postventa'
        ];
        $proyectosAgrupados = collect($proyectosAgrupados); // Convertir a colección para usar first()
    @endphp

    <div class="row">
        @foreach ($proyectosAgrupados as $vendedorId => $proyectosPorVendedor)
            @php
                $totalProyectos = $totalProyectosPorVendedor[$vendedorId] ?? 0;
            @endphp

            @if ($totalProyectos > 0)
                <div class="col-md-4 col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-head p-3 cdh">
                            <h3>{{ collect($proyectosPorVendedor)->first()['vendedor_nombre'] }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="fase-container">
                                @foreach ($fases as $fase)
                                    @php
                                        $proyecto = collect($proyectosPorVendedor)->firstWhere('fase', $fase);
                                        $totalFase = $proyecto ? $proyecto['total_fase'] : 0;
                                        $porcentaje = $totalProyectos > 0 ? ($totalFase / $totalProyectos) * 100 : 0;
                                    @endphp
                                    <div class="fase">
                                        <p><strong>{{ $fase }}</strong></p>
                                        <div class="d-flex">
                                            <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                            </div>
                                            <span>{{ number_format($porcentaje, 0) }}%</span>
                                        </div>
                                        <p>{{ $totalFase }} proyectos</p>
                                        <div class="separator"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <h4><strong>Total Proyectos:</strong> {{ $totalProyectos }}</h4>
                        </div>
                    </div>
                </div>
            @else
                <p>No hay proyectos para este vendedor.</p>
            @endif
        @endforeach
    </div>
@endsection
