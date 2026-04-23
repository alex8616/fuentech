<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Inventario Activos Fijos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td {
            padding: 10px;
            background-color: #fff;
            border: none; /* Elimina el borde */
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .elegant-img {
            width: 20%;
            height: auto;
            margin: 5px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .elegant-img:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        #tabla-articulos {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            font-family: Arial, sans-serif;
        }

        #tabla-articulos th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 10px;
        }

        #tabla-articulos td {
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        #tabla-articulos tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #tabla-articulos tr:hover {
            background-color: #f1f1f1;
        }

    </style>
</head>
<body>
    @php
        // Agrupar artículos por categoría
        $articulosPorCategoria = $articulos->groupBy('categori_recursos_id');
    @endphp

    <center><h3>INVENTARIO DE ACTIVOS FIJOS</h3></center><br>

    @foreach($articulosPorCategoria as $categoriaId => $articulosCategoria)
        <h3><u>{{ $articulosCategoria->first()->categoriarecurso->nombre ?? 'Sin Categoría' }}</u></h3>
        <table style="border-collapse: collapse; width: 100%; table-layout: fixed;">
            <tr>
                <td style="width: 5%; vertical-align: top; padding: 10px;">
                    @foreach($articulosCategoria as $articulo)
                        <p style="margin: 0;"> <strong>{{ $articulo->inventario->sum('totalgeneral') ?? 'N/A' }} </strong></p>
                    @endforeach
                </td>
                <td style="width: 30%; vertical-align: top; padding: 10px;">
                    @foreach($articulosCategoria as $articulo)
                        <p style="margin: 0;">{{ $articulo->nombre }}</p>
                    @endforeach
                </td>
                <td style="width: 45%; vertical-align: top; padding: 10px;">
                    @foreach($articulosCategoria as $articulo)
                        <p style="margin: 0;">{{ $articulo->descripcion }}</p>
                    @endforeach
                </td>
                <td style="width: 20%; vertical-align: top; padding: 10px;">
                    @foreach($articulosCategoria as $articulo)
                        <p style="margin: 0;">{{ $articulo->clasificacion }}</p>
                    @endforeach
                </td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td colspan="4" style="width: 20%; vertical-align: top; padding: 10px;">
                    @if($articulo->imagen)
                        @foreach(explode(',', $articulo->imagen) as $imagen)
                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/inventario/' . $imagen))) }}" class="elegant-img" />
                        @endforeach
                    @endif
                </td>
            </tr>
        </table>
    @endforeach
    <div style="page-break-after:always;"></div>
    
    <table id="tabla-articulos">
        <tr>
            <th style="text-align: center">Pertenece</th>
            <th style="text-align: center">Detalle</th>
        </tr>
        @foreach($articulosPorCategoria as $categoriaId => $articulosCategoria)
            <tr>
                <td style="width: 15%; vertical-align: top; padding: 10px;">
                    <p style="margin: 0;"> 
                        <strong>{{ $articulosCategoria->first()->categoriarecurso->nombre ?? 'Sin Categoría' }}</strong>
                    </p>
                </td>
                <td style="width: 30%; vertical-align: top; padding: 10px;">
                    <p style="margin: 0;">
                        @foreach($articulosCategoria as $index => $articulo)
                            {{ $articulo->nombre }} - {{ $articulo->descripcion }}{{ $loop->last ? '.' : ',' }}
                        @endforeach
                    </p>
                </td>
            </tr>
        @endforeach
    </table>

</body>
</html>