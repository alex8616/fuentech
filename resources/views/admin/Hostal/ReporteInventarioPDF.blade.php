<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.7rem;
            padding: 15px;
        }

        td, th {
            border: 1px solid rgb(190, 190, 190);
            padding: 10px 20px;
            margin: 0;
        }

        th {
            background-color: rgb(235, 235, 235);
        }

        td {
            padding: 2px;
        }

        tr:nth-child(even) td {
            background-color: white;
            padding: 10px;
        }

        tr:nth-child(odd) td {
            background-color: white;
            padding: 10px;
        }

        caption {
            padding: 10px;
        }
    </style>

</head>
<body>
@php
    // Agrupar artículos por categoría
    $articulosPorCategoria = $articulos->groupBy('categori_recursos_id');
@endphp

@foreach($articulosPorCategoria as $categoriaId => $articulosCategoria)
    <h3 style="text-align: center">Categoría: {{ $articulosCategoria->first()->categoriarecurso->nombre ?? 'Sin Categoría' }}</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Color</th>
                <th>Ubicacion</th>
                <th>Estado</th>
                <th>Clasificacion</th>
                <th>Marca</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articulosCategoria as $articulo)
                <tr>
                    <td>{{ $articulo->codigo }}</td>
                    <td>{{ $articulo->nombre }}</td>
                    <td>{{ $articulo->descripcion }}</td>
                    <td>{{ $articulo->inventario->sum('totalgeneral') ?? 'N/A' }}</td>
                    <td>{{ $articulo->color }}</td>
                    <td>{{ $articulo->categoriarecurso->nombre }}</td>
                    <td>{{ $articulo->estado }}</td>
                    <td>{{ $articulo->clasificacion }}</td>
                    <td>{{ $articulo->marca }}</td>
                    <td>{{ $articulo->observaciones }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="page-break-after:always;"></div>
@endforeach

</body>
</html>


