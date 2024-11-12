<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h2>Distribución de Proyectos por Fase</h2>
    <canvas id="proyectosPieChart"></canvas>

    <script>
        // Procesar datos de proyectosAgrupados en formato adecuado para el gráfico
        const proyectosAgrupados = @json($proyectosAgrupados);
        const fases = [...new Set(proyectosAgrupados.map(proyecto => proyecto.fase))]; // Extraer fases
        const vendedores = [...new Set(proyectosAgrupados.map(proyecto => proyecto.vendedor_nombre))]; // Extraer vendedores

        // Crear datasets para cada vendedor
        const datasets = vendedores.map(vendedor => {
            const data = fases.map(fase => {
                const proyecto = proyectosAgrupados.find(p => p.fase === fase && p.vendedor_nombre === vendedor);
                return proyecto ? proyecto.total_fase : 0;
            });
            return {
                label: vendedor,
                data: data,
                backgroundColor: '#' + Math.floor(Math.random()*16777215).toString(16), // Color aleatorio para cada vendedor
            };
        });

        // Configuración del gráfico de pastel
        const ctx = document.getElementById('proyectosPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: fases,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: (tooltipItem) => {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>