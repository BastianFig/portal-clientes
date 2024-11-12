
@extends('layouts.admin')
@section('content')
    <style>
        #sidebar{
            display: none;
        }

        .c-wrapper{
            margin-left: 0px;
        }

        .c-header.c-header-fixed.px-3{
            display: none;s
        }

        .fase-container {
            margin-bottom: 20px;
        }

        .fase {
            margin-bottom: 10px;
        }

        .progress-bar {
            height: 20px;
            background-color: #019ed5; /* Cambia el color si lo necesitas */
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

    <div class="row">
        @foreach ($proyectosAgrupados->groupBy('id_vendedor') as $vendedorId => $proyectosPorVendedor)
            @php
                $totalProyectos = $totalProyectosPorVendedor[$vendedorId] ?? 0;
                $fases = [
                    'Fase Diseño', 
                    'Fase Propuesta Comercial', 
                    'Fase Contable', 
                    'Fase Comercial', 
                    'Fase Fabricación', 
                    'Fase Despachos', 
                    'Fase Postventa'
                ];
            @endphp

            <div class="col-md-3 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-head p-3 cdh">
                        <h3>{{ $proyectosPorVendedor->first()->vendedor_nombre }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="fase-container">
                            @foreach ($fases as $fase)
                                @php
                                    $proyectoFase = $proyectosPorVendedor->firstWhere('fase', $fase);
                                    $totalFase = $proyectoFase->total_fase ?? 0;
                                    $porcentaje = $totalProyectos > 0 ? ($totalFase / $totalProyectos) * 100 : 0;
                                @endphp

                                <div class="fase">
                                    <p><strong>{{ $fase }} - {{ $totalFase }} proyectos</strong></p>
                                    <div class="d-flex">
                                        <div class="progress-bar mr-2" style="width: {{ $porcentaje }}%">
                                        </div>
                                        <span>{{ number_format($porcentaje, 0) }}%</span>
                                    </div>
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
        @endforeach
    </div>
@endsection
