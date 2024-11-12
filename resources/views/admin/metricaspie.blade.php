<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h2>Distribución de Proyectos en Porcentaje por Fase para Cada Vendedor</h2>
    <div class="chart-container">
        @foreach($proyectosConPorcentaje->groupBy('vendedor_nombre') as $vendedor => $proyectos)
            <div class="chart-item">
                <h3>{{ $vendedor }}</h3>
                <canvas id="chart_{{ Str::slug($vendedor, '_') }}"></canvas>
            </div>
        @endforeach
    </div>

    <script>
        // Datos agrupados de proyectos con porcentaje por vendedor en JSON
        const proyectosConPorcentaje = @json($proyectosConPorcentaje);
        
        // Agrupar los datos por vendedor para crear el conjunto de datos de cada gráfico
        const datosPorVendedor = proyectosConPorcentaje.reduce((acc, proyecto) => {
            const { vendedor_nombre: vendedor, fase, porcentaje_fase: porcentaje } = proyecto;
            if (!acc[vendedor]) acc[vendedor] = { labels: [], data: [] };
            acc[vendedor].labels.push(fase);
            acc[vendedor].data.push(porcentaje);
            return acc;
        }, {});

        // Configuración y creación de gráficos
        Object.entries(datosPorVendedor).forEach(([vendedor, { labels, data }]) => {
            // Reemplazamos caracteres no válidos en el ID
            const canvasId = `chart_${vendedor.replace(/\s+/g, '_')}`;
            const canvasElement = document.getElementById(canvasId);
            
            // Verificamos que el elemento canvas existe antes de intentar crear el gráfico
            if (canvasElement) {
                const ctx = canvasElement.getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: labels.map(() => '#' + Math.floor(Math.random() * 16777215).toString(16)), // Colores aleatorios
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