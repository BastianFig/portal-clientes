<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h2>Distribución de Proyectos por Fase para Cada Vendedor</h2>
    <div class="chart-container">
        @foreach($proyectosAgrupados->groupBy('vendedor_nombre') as $vendedor => $proyectos)
            <div class="chart-item">
                <h3>{{ $vendedor }}</h3>
                <canvas id="chart_{{ Str::slug($vendedor) }}"></canvas>
            </div>
        @endforeach
    </div>

    <script>
        // Datos agrupados de proyectos por vendedor en JSON
        const proyectosAgrupados = @json($proyectosAgrupados);
        
        // Extraer fases de los proyectos
        const fases = [
            'Fase Diseño',
            'Fase Propuesta Comercial',
            'Fase Contable',
            'Fase Comercial',
            'Fase Fabricación',
            'Fase Despachos',
            'Fase Postventa'
        ];

        // Agrupar los datos por vendedor para crear el conjunto de datos de cada gráfico
        const datosPorVendedor = proyectosAgrupados.reduce((acc, proyecto) => {
            const { vendedor_nombre: vendedor, fase, total_fase: totalFase } = proyecto;
            if (!acc[vendedor]) acc[vendedor] = { labels: [], data: [] };
            acc[vendedor].labels.push(fase);
            acc[vendedor].data.push(totalFase);
            return acc;
        }, {});

        // Configuración y creación de gráficos
        Object.entries(datosPorVendedor).forEach(([vendedor, { labels, data }]) => {
            const ctx = document.getElementById(`chart_${vendedor.replace(/\s+/g, '-')}`).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: labels.map(() => '#' + Math.floor(Math.random()*16777215).toString(16)), // Colores aleatorios
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: (tooltipItem) => `${tooltipItem.label}: ${tooltipItem.raw}`
                            }
                        }
                    }
                }
            });
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