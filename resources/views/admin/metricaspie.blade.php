@extends('layouts.admin')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="d-flex">
        @foreach($proyectosConPorcentaje->groupBy('vendedor_nombre') as $vendedor => $proyectos)
        <div class="col-md-3 col-lg-3 mb-3">
            <div class="card">
                <div class="card-head p-3 cdh text-center">
                    <h3>{{ ucfirst(strtolower(explode(' ', trim($vendedor))[0])) }}</h3>
                </div>
                <div class="card-body">
                    <canvas id="chart_{{ Str::slug(Str::lower($vendedor), '_') }}" class="chart-item"></canvas>
                </div>
                <div class="card-footer text-center">
                    <h4><strong>Total Proyectos:</strong> {{ $totalProyectosPorVendedor[$proyectos->first()->id_vendedor] ?? 0 }}</h4>
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
        const totalProyectosPorVendedor = @json($totalProyectosPorVendedor); // Asegúrate de tener esta variable

        const datosPorVendedor = proyectosConPorcentaje.reduce((acc, proyecto) => {
            const { vendedor_nombre: vendedor, fase, porcentaje_fase: porcentaje } = proyecto;
            if (!acc[vendedor]) acc[vendedor] = { labels: [], data: [], backgroundColors: [], cantidadProyectos: [] };
            
            const totalProyectos = totalProyectosPorVendedor[proyecto.id_vendedor] || 0;
            const cantidadProyectosPorFase = Math.round((porcentaje / 100) * totalProyectos);

            acc[vendedor].labels.push(fase);
            acc[vendedor].data.push(porcentaje);
            acc[vendedor].backgroundColors.push(fasesColores[fase]);
            acc[vendedor].cantidadProyectos.push(cantidadProyectosPorFase);

            return acc;
        }, {});

        Object.entries(datosPorVendedor).forEach(([vendedor, { labels, data, backgroundColors, cantidadProyectos }]) => {
            const canvasId = `chart_${vendedor.toLowerCase().replace(/\s+/g, '_')}`;
            const canvasElement = document.getElementById(canvasId);

            if (canvasElement) {
                const ctx = canvasElement.getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels.map((label, index) => `${label}: ${Math.round(data[index])}% - ${cantidadProyectos[index]} proyectos`),
                        datasets: [{
                            data: data,
                            backgroundColor: backgroundColors
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { 
                                position: 'bottom',
                                labels: {
                                    generateLabels: (chart) => {
                                        return chart.data.labels.map((label, i) => ({
                                            text: label,
                                            fillStyle: chart.data.datasets[0].backgroundColor[i],
                                            strokeStyle: chart.data.datasets[0].backgroundColor[i],
                                            index: i
                                        }));
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (tooltipItem) => {
                                        const fase = labels[tooltipItem.dataIndex];
                                        const porcentaje = Math.round(tooltipItem.raw);
                                        return `${fase}: ${porcentaje}%`;
                                    }
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
