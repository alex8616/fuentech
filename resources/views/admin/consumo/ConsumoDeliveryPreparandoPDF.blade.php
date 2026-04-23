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
        <p class="centrado" style="font-size: 20px; text-align: center">TICKET DE DELIVERY
        </p>
        <p class="centrado">
            Fecha: {{$consumos[0]->fecha_venta}}
        </p>
        @if($consumos[0]->Comentario != null)
            <span style="font-size: 15px;">{{ $consumos[0]->Comentario}}</span>
        @endif
            <span style="width: 100%; font-size: 15px; display: block;"><strong>DELIVERY # {{$consumos[0]->id}}
            <span style="font-size: 15px;">{{$consumos[0]->fecha_venta}}</span>
            <span style="font-size: 15px;">Tardara {{$consumos[0]->DeliveryTiempo}} minutos</span><br>
        
        @if($consumos[0]->cliente == null)
        @else
            <span style="width: 100%; font-size: 15px; display: block; font-weight: lighter">Cliente: {{ $consumos[0]->cliente->NombreCliente}} {{ $consumos[0]->cliente->TelefonoCliente}} </span>
            <span style="width: 100%; font-size: 15px; display: block; font-weight: lighter">{{ $consumos[0]->cliente->BarrioCliente}} - {{ $consumos[0]->cliente->CalleCliente}} - {{ $consumos[0]->cliente->NumeroCliente}}</span>
        @endif
        
        @if($consumos[0]->detalleconsumos->isEmpty())
            <p>No hay consumos registrados para esta venta.</p>
        @else
            <table style="width: 100%">
                <tbody>
                    @foreach($consumos[0]->detalleconsumos as $detalle)
                        @if($detalle->eliminado == "false")
                            <tr>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>{{ $detalle->producto->NombreProducto }}</td>
                                <td style="text-align: right">{{ $detalle->precio }}</td>
                                <td style="text-align: right">{{ $detalle->total }}</td>
                            </tr>
                            @if(!$detalle->modificadordetalleconsumo->isEmpty())
                                @foreach($detalle->modificadordetalleconsumo as $modificadore)
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td>{{ $modificadore->cantidad }}</td>
                                                <td>{{ $modificadore->detallemodificador->producto->NombreProducto }}</td>
                                                <td style="text-align: center">{{ $modificadore->precio }}</td>
                                                <td style="text-align: right">{{ $modificadore->total }}</td>
                                            </tr>
                                        </table>
                                    </td>                            
                                </tr>
                                @endforeach
                            @endif
                        @else
                            <tr>
                                <td><strike style="color: #7F8487">{{ $detalle->cantidad }}</strike></td>
                                <td><strike style="color: #7F8487">{{ $detalle->producto->NombreProducto }} <br> ({{ $detalle->comentarioeliminado }})</strike></td>
                                <td style="text-align: right"><strike style="color: #7F8487">{{ $detalle->precio }}</strike></td>
                                <td style="text-align: right"><strike style="color: #7F8487">{{ $detalle->total }}</strike></td>
                            </tr>
                            @if(!$detalle->modificadordetalleconsumo->isEmpty())
                                @foreach($detalle->modificadordetalleconsumo as $modificadore)
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td><strike style="color: #7F8487">{{ $modificadore->cantidad }}</strike></td>
                                                <td><strike style="color: #7F8487">{{ $modificadore->detallemodificador->producto->NombreProducto }}</strike></td>
                                                <td style="text-align: center"><strike style="color: #7F8487">{{ $modificadore->precio }}</strike></td>
                                                <td style="text-align: right"><strike style="color: #7F8487">{{ $modificadore->total }}</strike></td>
                                            </tr>
                                        </table>
                                    </td>                            
                                </tr>
                                @endforeach
                            @endif
                        @endif                        
                    @endforeach
                </tbody>
            </table>
        @endif
        @if($consumos[0]->descuentoconsumos->isEmpty())
            <span style="width: 100%; display: block; font-weight: bold; background: black; text-align: justify; color: white">
                DELIVERY:
                <span style="float: right;">{{$consumos[0]->DeliveryCosto}}</span>
            </span>
            <span style="width: 100%; display: block; font-weight: bold; background: black; text-align: justify; color: white">
                TOTAL:
                <span style="float: right;">{{$consumos[0]->total}}</span>
            </span>
        @else
            <span style="width: 100%; display: block; font-weight: bold; background: black; text-align: justify; color: white">
                DELIVERY:
                <span style="float: right;">{{$consumos[0]->DeliveryCosto}}</span>
            </span>
            <span style="width: 100%; display: block; font-weight: bold; background: black; text-align: justify; color: white">
                SUB TOTAL:
                <span style="float: right;">{{$consumos[0]->subTotal}}</span>
            </span>
            <table style="width: 100%">
                <tbody>
                    @foreach($consumos[0]->descuentoconsumos as $descuento)
                        <tr>                    
                            <td>
                            @if($descuento->TipoDescuento == "porcentaje")
                                {{ $descuento->TipoDescuento }} %
                            @else
                                Fijo
                            @endif
                            </td>
                            <td>{{ $descuento->MontoDescuento }}</td>
                            <td style="text-align: right">{{ $descuento->TotalDescuento }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span style="width: 100%; display: block; font-weight: bold; background: black; text-align: justify; color: white">
                TOTAL:
                <span style="float: right;">{{$consumos[0]->total}}</span>
            </span>
        @endif
        <p class="centrado" style="text-align: center">¡GRACIAS POR SU COMPRA!
    </div>
</body>

</html>
