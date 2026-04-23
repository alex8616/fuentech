<!DOCTYPE html>
<html>

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
    </style>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="ticket" style="font-size: 12px">
        <p class="centrado" style="font-size: 20px; text-align: center">Fecha {{ \Carbon\Carbon::parse($consumos->fecha_venta)->format('Y-m-d') }}</p>
        <table>
            <tr>
                <th>CANT</th>
                <th>PRODUCTO</th>
                <th>PRECIO</th>
                <th>TOTAL</th>
                <th>PAGADO</th>
            </tr>
            @foreach($consumos->detalleconsumos as $detalle)
            <tr>
                <td>{{ $detalle->cantidad }}</td>
                <td>{{ $detalle->producto->NombreProducto }}</td>
                <td>{{ $detalle->precio }}</td>
                <td>{{ $detalle->total }}</td>
                <td>
                    @if($consumos->pagosconsumos->isNotEmpty())
                        si
                    @else
                        no
                    @endif
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right">TOTAL</td>
                <td colspan="2">{{ $consumos->total }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
