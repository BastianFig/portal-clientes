@extends('layouts.admin')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="d-flex">
        @foreach($proyectosConPorcentaje->groupBy('vendedor_nombre') as $vendedor => $proyectos)
        <div class="col-md-3 col-lg-3 mb-3">
            <div class="card">
                <div class="card-head p-3 cdh text-center">
                    <h3>{{ $vendedor }}</h3>
                </div>
                <div class="card-body">
                    <canvas id="chart_{{ Str::slug(Str::lower($vendedor), '_') }}" class="chart-item"></canvas>
                </div>
                <div class="card-footer">
                    <h4><strong>Total Proyectos:</strong> {{ $totalProyectosPorVendedor  }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <script>
        // Fases y colores asignados
        const fasesColores = {
            'Fase Diseño': '#FF6384',
            'Fase Propuesta Comercial': '#36A2EB',
            'Fase Contable': '#FFCE56',
            'Fase Comercial': '#4BC0C0',
            'Fase Fabricación': '#9966FF',
            'Fase Despachos': '#FF9F40',
            'Fase Postventa': '#FF6384'
        };

        const proyectosConPorcentaje = @json($proyectosConPorcentaje);

        const datosPorVendedor = proyectosConPorcentaje.reduce((acc, proyecto) => {
            const { vendedor_nombre: vendedor, fase, porcentaje_fase: porcentaje } = proyecto;
            if (!acc[vendedor]) acc[vendedor] = { labels: [], data: [], backgroundColors: [] };
            acc[vendedor].labels.push(fase);
            acc[vendedor].data.push(porcentaje);
            acc[vendedor].backgroundColors.push(fasesColores[fase]);
            return acc;
        }, {});

        Object.entries(datosPorVendedor).forEach(([vendedor, { labels, data, backgroundColors }]) => {
            const canvasId = `chart_${vendedor.toLowerCase().replace(/\s+/g, '_')}`;
            const canvasElement = document.getElementById(canvasId);

            if (canvasElement) {
                const ctx = canvasElement.getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: backgroundColors // Colores consistentes para cada fase
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: (tooltipItem) => `${tooltipItem.label}: ${tooltipItem.raw.toFixed(2)}%`
                                }
                            }
                        }
                    }
                });
            } else {
                console.warn(`Elemento <canvas> con id "${canvasId}" no encontrado`);
            }
        });
    </script>
    <style>
        .chart-item {
            width: 100%;
            height: 500px;
        }
        #sidebar{
            display: none;
        }

        .c-wrapper{
            margin-left: 0px !important;
        }

        .c-header.c-header-fixed.px-3{
            display: none;
        }

        .c-main{
            padding-top: 1rem !important;
        }
        .cdh {
            background-color: #019ed5;
            color: white;
        }
    </style>


@endsection