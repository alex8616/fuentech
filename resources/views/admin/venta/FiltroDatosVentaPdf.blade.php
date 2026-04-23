<head>
    <style>
        * {
            margin: 0;
            padding: 0;
            margin-right: 2;
            padding-right: 2;
            margin-left: 2;
            padding-left: 2;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            font-family: Arial, sans-serif;
            text-align: left;
        }

        .styled-table thead tr {
            background-color: #0A5EB0;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #0A5EB0;
        }

        .styled-table tbody tr:hover {
            background-color: #f1f1f1;
        }

    </style>
    <link rel="stylesheet" href="style.css">
</head>
@php
    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];
@endphp

@if($TipoReporte == "Diario")
    <h1 style="text-align: center">Reporte Dia {{ $dia }}/{{ $mes }}/{{ $anio }}</h1>
    @if($cliente != "TodoCliente")
        <h1 style="text-align: center; font-size: 17px">De {{ $cliente->NombreCliente }}</h1>
    @endif
    @if($metododepago != "TodoMetodoPago")
        <h1 style="text-align: center; font-size: 17px">Con tipo de pago en {{ $metododepago }}</h1>
    @endif
    @if($usuario != "TodoUsuario")
        <h1 style="text-align: center; font-size: 17px">Registrado por el usuario{{ $usuario->name }}</h1>
    @endif
    @if($tipodeventa != "TodoVenta")
        <h1 style="text-align: center; font-size: 17px">Venta en {{ $tipodeventa }}</h1>
    @endif
@elseif($TipoReporte == "Mensual")
    <h1 style="text-align: center">Reporte Mensual {{ $meses[$mes] }}</h1>
    @if($cliente != "TodoCliente")
        <h1 style="text-align: center; font-size: 17px">De {{ $cliente->NombreCliente }}</h1>
    @endif
    @if($metododepago != "TodoMetodoPago")
        <h1 style="text-align: center; font-size: 17px">Con tipo de pago en {{ $metododepago }}</h1>
    @endif
    @if($usuario != "TodoUsuario")
        <h1 style="text-align: center; font-size: 17px">Registrado por el usuario{{ $usuario->name }}</h1>
    @endif
    @if($tipodeventa != "TodoVenta")
        <h1 style="text-align: center; font-size: 17px">Venta en {{ $tipodeventa }}</h1>
    @endif
@elseif($TipoReporte == "Anual")
    <h1 style="text-align: center">Reporte Anual {{ $anio }}</h1>
    @if($cliente != "TodoCliente")
        <h1 style="text-align: center; font-size: 17px">De {{ $cliente->NombreCliente }}</h1>
    @endif
    @if($metododepago != "TodoMetodoPago")
        <h1 style="text-align: center; font-size: 17px">Con tipo de pago en {{ $metododepago }}</h1>
    @endif
    @if($usuario != "TodoUsuario")
        <h1 style="text-align: center; font-size: 17px">Registrado por el usuario{{ $usuario->name }}</h1>
    @endif
    @if($tipodeventa != "TodoVenta")
        <h1 style="text-align: center; font-size: 17px">Venta en {{ $tipodeventa }}</h1>
    @endif
@elseif($TipoReporte == "Rango")
    <h1 style="text-align: center">Reporte Desde {{ $fechaInicio }} Hasta {{ $fechaFin }}</h1>
    @if($cliente != "TodoCliente")
        <h1 style="text-align: center; font-size: 17px">De {{ $cliente->NombreCliente }}</h1>
    @endif
    @if($metododepago != "TodoMetodoPago")
        <h1 style="text-align: center; font-size: 17px">Con tipo de pago en {{ $metododepago }}</h1>
    @endif
    @if($usuario != "TodoUsuario")
        <h1 style="text-align: center; font-size: 17px">Registrado por el usuario{{ $usuario->name }}</h1>
    @endif
    @if($tipodeventa != "TodoVenta")
        <h1 style="text-align: center; font-size: 17px">Venta en {{ $tipodeventa }}</h1>
    @endif
@endif

<br>
<h1>TABLA DE PRODUCTOS</h1>
<table class="styled-table">
    <thead>
        <tr>
            <th>Nombre del Producto</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productosVendidos as $producto)
        <tr>
            <td style="font-size: 12px">{{ $producto['NombreProducto'] }}</td>
            <td style="font-size: 12px">{{ $producto['cantidad'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="page-break-after:always;"></div>

<h1>TABLA DE VENTAS</h1>
<table class="styled-table" sstyle >
    <thead>
        <tr>
            <th>TIPO VENTA</th>
            <th>FECHA</th>
            <th>CLIENTE</th>
            <th>CONSUMO</th>
            <th>PAGO</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td style="font-size: 12px">{{ $venta->TipoConsumo }}</td>
            <td style="font-size: 12px">{{ $venta->fecha_venta }}</td>
            <td style="font-size: 12px">{{ $venta->cliente ? $venta->cliente->NombreCliente : 'Sin cliente' }}</td>
            <td>
                @foreach($venta->detalleconsumos as $detalleconsumo)
                    <table style="width: 100%; margin: 0px; padding: 0px">
                        <tr>
                            <td style="width: 5%; font-size: 12px">{{ $detalleconsumo->cantidad }}</td>
                            <td style="width: 45%; font-size: 12px">{{ $detalleconsumo->producto->NombreProducto }}</td>
                            <td style="width: 25%; font-size: 12px">{{ $detalleconsumo->precio }}</td>
                            <td style="width: 25%; font-size: 12px">{{ $detalleconsumo->total }}</td>
                        </tr>
                    </table>
                @endforeach
            </td>
            <td>
                @foreach($venta->pagosconsumos as $pagosconsumo)
                    <span style="width: 5%; font-size: 12px">{{ $pagosconsumo->TipoPago }}</span><br>
                    <span style="width: 5%; font-size: 12px">{{ $pagosconsumo->TotalPago }}</span><br>
                    
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<table class="styled-table">
    <thead>
        <tr>
            <th>Categoría</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categoriasVendidas as $categoria => $cantidad)
        <tr>
            <td>{{ $categoria }}</td>
            <td>{{ $cantidad }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
