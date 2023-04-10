@extends('menu')
@section('styles')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chart Historicos UF</title>
@endsection

@section('content')
    <div class="card" style="margin-top: 20px;">
        <div class="card-body">
            <h1 class="card-title">Gráfico de precios histórico de la UF</h1>
            <canvas id="myChart"></canvas>
            <?php if (empty($fecha)): ?>
            <div style="margin-left: 5px;">
                <input type='date' onchange='startDateFilter(this)' value='{{ $fecha[0] }}' min='{{ $fecha[0] }}'
                    max='{{ $fecha[count($fecha) - 1] }}'>
                <input type='date' onchange='endDateFilter(this)' value='{{ $fecha[count($fecha) - 1] }}'
                    min='{{ $fecha[0] }}' max='{{ $fecha[count($fecha) - 1] }}'>
            </div>
            <?php else: ?>
            <p>No se encontraron datos para formar el gráfico</p>
            <?php endif; ?>
            <br>
        </div>
    </div>
@endsection

<?php if (empty($fecha)): ?>
@section('scripts')
    @parent
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js">
    </script>

    <script>
        // Se definen las variables "valores" y "fechas" con los valores de la BD
        var valores = <?= json_encode($valor) ?>;
        var fechas = <?= json_encode($fecha) ?>;

        // Se define el objeto "data" que especifica los datos del gráfico de línea
        const data = {
            labels: fechas,
            datasets: [{
                label: 'Valor UF',
                data: valores,
                borderColor: 'rgba(188, 208, 127, 1)',
                fill: false,
                datalabels: {
                    align: 'top'
                }
            }]
        };

        // Se define el objeto "config" que especifica la configuración del gráfico de línea
        const config = {
            type: 'line',
            data,
            options: {
                scales: {
                    x: {
                        min: '{{ $fecha[0] }}',
                        max: '{{ $fecha[count($fecha) - 1] }}',
                        type: 'time',
                    }
                },
                locale: 'es',
            }
        };

        // Se crea el objeto Chart y se muestra en el elemento con ID "myChart"
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        // Función que se llama cuando se cambia la fecha de inicio del input
        function startDateFilter(date) {
            const startDate = new Date(date.value);
            myChart.config.options.scales.x.min = startDate;
            myChart.update();
        }

        // Función que se llama cuando se cambia la fecha de fin del input
        function endDateFilter(date) {
            const endDate = new Date(date.value);
            myChart.config.options.scales.x.max = endDate;
            myChart.update();
        }
    </script>
    <?php endif; ?>
@stop
