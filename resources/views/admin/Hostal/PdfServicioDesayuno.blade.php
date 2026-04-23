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
    <div class="ticket" style="font-size: 14px">
        <p class="centrado" style="font-size: 20px; text-align: center">Fecha {{ \Carbon\Carbon::parse($detalleservicios->fecha_venta)->format('Y-m-d') }}</p>
        <table>
            <tr>
                <th>CANT</th>
                <th>TIPO</th>
                <th>PRECIO</th>
                <th>TOTAL</th>
                <th>PAGADO</th>
            </tr>
            <tr>
                <td>{{ $detalleservicios->cantidad }}</td>
                <td>{{ $detalleservicios->TipoServicio }}</td>
                <td>{{ $detalleservicios->precio }}</td>
                <td>{{ $detalleservicios->total }}</td>
                <td>{{ $detalleservicios->pagado == 'true' ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right">TOTAL</td>
                <td colspan="2">{{ $detalleservicios->total }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
