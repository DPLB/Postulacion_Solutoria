@extends('menu')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            {{ Session::forget('success') }}
        </div>
    @endif

    <div class="card" style="margin-top: 20px;">
        <div class="card-header">
            <h3>Introducción</h3>
        </div>
        <div class="card-body">
            <p>En esta tarea se realizaron las siguientes actividades:</p>
            <ul>
                <li>Se solicitó un token de consulta a través de una API de Solutoria, utilizando las credenciales
                    proporcionadas por el solicitante.</li>
                <li>Con el token generado, se procedió a consumir la API de Solutoria que contiene la información histórica
                    de la UF. Se extrajeron los datos y se importaron a una base de datos MySQL.</li>
                <li>Se creó un CRUD utilizando el framework Laravel y AJAX para realizar las operaciones de creación,
                    lectura, actualización y eliminación de los datos de la UF almacenados en la base de datos.</li>
                <li>Se implementó un filtro de fecha desde-hasta en la vista del CRUD para mostrar los datos de la UF
                    correspondientes al rango de fechas seleccionado.</li>
                <li>Se creó un gráfico utilizando la librería Chart.js que muestra la evolución histórica de la UF. El
                    gráfico permite filtrar los datos por fecha y mostrarlos en diferentes formatos (línea, barras, entre
                    otros).</li>
            </ul>
            <p>En resumen, la tarea consistió en consumir una API, importar los datos a una base de datos, crear un CRUD y
                un gráfico con filtro de fecha desde-hasta. Se utilizó el framework Laravel y AJAX para el CRUD y la
                librería Chart.js para el gráfico.</p>
        </div>
    </div>
@endsection
