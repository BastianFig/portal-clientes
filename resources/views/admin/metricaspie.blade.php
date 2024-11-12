<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h2>Distribución de Proyectos en Porcentaje por Fase para Cada Vendedor</h2>
    <div class="chart-container">
        @foreach($proyectosConPorcentaje->groupBy('vendedor_nombre') as $vendedor => $proyectos)
            <div class="chart-item">
                <h3>{{ $vendedor }}</h3>
                <canvas id="chart_{{ Str::slug(Str::lower($vendedor), '_') }}"></canvas> <!-- ID en minúsculas -->
            </div>
        @endforeach
    </div>

    <script>
        // Ejecutar el código JavaScript después de que el DOM esté completamente cargado
        const proyectosConPorcentaje = @json($proyectosConPorcentaje);
        
        const datosPorVendedor = proyectosConPorcentaje.reduce((acc, proyecto) => {
            const { vendedor_nombre: vendedor, fase, porcentaje_fase: porcentaje } = proyecto;
            if (!acc[vendedor]) acc[vendedor] = { labels: [], data: [] };
            acc[vendedor].labels.push(fase);
            acc[vendedor].data.push(porcentaje);
            return acc;
        }, {});

        Object.entries(datosPorVendedor).forEach(([vendedor, { labels, data }]) => {
            // Convertimos el nombre del vendedor a minúsculas para coincidir con el ID en el HTML
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
                            backgroundColor: labels.map(() => '#' + Math.floor(Math.random() * 16777215).toString(16)), 
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