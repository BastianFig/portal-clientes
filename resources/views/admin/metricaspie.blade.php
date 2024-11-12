<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h2>Distribución de Proyectos en Porcentaje por Fase para Cada Vendedor</h2>
<div class="chart-container">
    @foreach($proyectosConPorcentaje->groupBy('vendedor_nombre') as $vendedor => $proyectos)
        <div class="card">
            <h3>{{ $vendedor }}</h3>
            <canvas id="chart_{{ Str::slug(Str::lower($vendedor), '_') }}" class="chart-item"></canvas>
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
    .chart-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 columnas */
        gap: 20px;
        margin: 20px;
    }
    .chart-item {
        width: 100%;
        height: 300px;
    }
</style>