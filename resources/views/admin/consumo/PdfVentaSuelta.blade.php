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
        <p class="centrado" style="font-size: 20px; text-align: center">TICKET DE VENTA SUELTA
        </p>
        <p class="centrado">
            Fecha: {{ $consumos->fecha_venta }}
        </p>

        @if($consumos->cliente == null)
        @else
            <p>Cliente: {{ $consumos->cliente->NombreCliente}}</p>
        @endif

        @if($consumos->Comentario == null)
        @else
            <p>{{ $consumos->Comentario}}</p>
        @endif

        @if($consumos->detalleconsumos->isEmpty())
            <p>No hay consumos registrados para esta venta.</p>
        @else
            <table style="width:  80%">
                <tbody>
                    @foreach($consumos->detalleconsumos as $detalle)
                        @if($detalle->eliminado == "false")
                            <tr>
                                <th>{{ $detalle->cantidad }}</th>
                                <th>{{ $detalle->producto->NombreProducto }}</th>
                                <th style="text-align: right">{{ $detalle->precio }}</th>
                                <th style="text-align: right">{{ $detalle->total }}</th>
                            </tr>
                            @if(!$detalle->modificadordetalleconsumo->isEmpty())
                                @foreach($detalle->modificadordetalleconsumo as $modificadore)
                                <tr>
                                    <th></th>
                                    <th colspan="3">
                                        <table style="width:  80%;">
                                            <tr>
                                                <th>{{ $modificadore->cantidad }}</th>
                                                <th>{{ $modificadore->detallemodificador->producto->NombreProducto }}</th>
                                                <th style="text-align: center">{{ $modificadore->precio }}</th>
                                                <th style="text-align: right">{{ $modificadore->total }}</th>
                                            </tr>
                                        </table>
                                    </th>                            
                                </tr>
                                @endforeach
                            @endif
                        @else
                            <tr>
                                <th><strike style="color: #7F8487">{{ $detalle->cantidad }}</strike></th>
                                <th><strike style="color: #7F8487">{{ $detalle->producto->NombreProducto }} <br> ({{ $detalle->comentarioeliminado }})</strike></th>
                                <th style="text-align: right"><strike style="color: #7F8487">{{ $detalle->precio }}</strike></th>
                                <th style="text-align: right"><strike style="color: #7F8487">{{ $detalle->total }}</strike></th>
                            </tr>
                            @if(!$detalle->modificadordetalleconsumo->isEmpty())
                                @foreach($detalle->modificadordetalleconsumo as $modificadore)
                                <tr>
                                    <th></th>
                                    <th colspan="3">
                                        <table style="width:  80%;">
                                            <tr>
                                                <th><strike style="color: #7F8487">{{ $modificadore->cantidad }}</strike></th>
                                                <th><strike style="color: #7F8487">{{ $modificadore->detallemodificador->producto->NombreProducto }}</strike></th>
                                                <th style="text-align: center"><strike style="color: #7F8487">{{ $modificadore->precio }}</strike></th>
                                                <th style="text-align: right"><strike style="color: #7F8487">{{ $modificadore->total }}</strike></th>
                                            </tr>
                                        </table>
                                    </th>                            
                                </tr>
                                @endforeach
                            @endif
                        @endif                        
                    @endforeach
                </tbody>
            </table>
        @endif
        @if($consumos->descuentoconsumos->isEmpty())
            <span style="width:  80%; display: block; font-weight: bold; text-align: justify;">
                TOTAL:
                <span style="float: right;">{{$consumos->total}}</span>
            </span>
        @else
            <span style="width:  80%; display: block; font-weight: bold; text-align: justify;">
                SUB TOTAL:
                <span style="float: right;">{{$consumos->subTotal}}</span>
            </span>
            <table style="width:  80%">
                <tbody>
                    @foreach($consumos->descuentoconsumos as $descuento)
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
            <span style="width:  80%; display: block; font-weight: bold; text-align: justify;">
                TOTAL:
                <span style="float: right;">{{$consumos->total}}</span>
            </span>
        @endif

        @if($consumos->pagosconsumos->isEmpty())
            
        @else
            <hr>
            <span style="width:  80%; display: block; font-weight: bold; text-align: justify;">
                PAGADO:
            </span>
            <table style="width:  80%">
                <tbody>
                    @foreach($consumos->pagosconsumos as $pagosconsumo)
                        <tr>                    
                            <td>
                                {{ $pagosconsumo->TipoPago }}
                            </td>
                            <td>{{ $pagosconsumo->TotalPago }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <p class="centrado" style="text-align: center">¡GRACIAS POR SU COMPRA!
    </div>
</body>

</html>
