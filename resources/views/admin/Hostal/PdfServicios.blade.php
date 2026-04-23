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
        <p class="centrado" style="font-size: 20px; text-align: center">Servicio De {{$habitacion->Nombre_habitacion}}</p>
        <table>
            <tr>
                <th>CANT</th>
                <th>TIPO</th>
                <th>PRECIO</th>
                <th>TOTAL</th>
                <th>PAGADO</th>
            </tr>
            @php
                $sumSI = 0; // Total pagado
                $sumNO = 0; // Total no pagado
            @endphp

            @foreach($habitacion->hospedajehabitacion as $detalle)
                @foreach($detalle->servicios as $servicio)
                    @foreach($servicio->detalleservicio as $serv)
                        <tr>
                            <td style="text-align: center">{{ $serv->cantidad }}</td>
                            <td>{{ $serv->TipoServicio }}</td>
                            <td>{{ number_format($serv->precio, 2) }}</td>
                            <td>{{ number_format($serv->total, 2) }}</td>
                            <td>{{ $serv->pagado == 'true' ? 'Sí' : 'No' }}</td>
                        </tr>
                        @php
                            if ($serv->pagado == 'true') {
                                $sumSI += $serv->total;
                            } else {
                                $sumNO += $serv->total;
                            }
                        @endphp
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right"><strong>SUBTOTAL</strong></td>
                    <td colspan="2">{{ number_format($detalle->TotalServicio, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right"><strong>TOTAL PAGADO</strong></td>
                <td colspan="2">{{ number_format($sumSI, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right"><strong>TOTAL NO PAGADO</strong></td>
                <td colspan="2">{{ number_format($sumNO, 2) }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
