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
        <p class="centrado" style="font-size: 20px; text-align: center">Consumos De {{$habitacion->Nombre_habitacion}}</p>
        <table>
            <tr>
                <th>CANT</th>
                <th>PRODUCTO</th>
                <th>PRECIO</th>
                <th>TOTAL</th>
                <th>PAGADO</th>
            </tr>
            @php
                $sumSI = 0; // Total pagado
                $sumNO = 0; // Total no pagado
            @endphp

            @foreach($habitacion->hospedajehabitacion as $detalle)
                @foreach($detalle->servicioconsumos as $servicioconsumo)
                    @foreach($servicioconsumo->consumo as $consu)
                        @foreach($consu->detalleconsumos as $detalleconsumo)
                            <tr>
                                <td style="text-align: center">{{ $detalleconsumo->cantidad }}</td>
                                <td>{{ $detalleconsumo->producto->NombreProducto }}</td>
                                <td>{{ $detalleconsumo->precio }}</td>
                                <td>{{ $detalleconsumo->total }}</td>
                                <td>
                                    @if($consu->pagosconsumos->isNotEmpty())
                                        si
                                    @else
                                        no
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right"><strong>SUBTOTAL</strong></td>
                    <td colspan="2">{{ $servicioconsumo->subTotal }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right"><strong>TOTAL PAGADO</strong></td>
                <td colspan="2">{{ $servicioconsumo->totalpagado }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right"><strong>TOTAL NO PAGADO</strong></td>
                <td colspan="2">{{ $servicioconsumo->total }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
