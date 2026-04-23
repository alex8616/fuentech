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
        <p class="centrado" style="font-size: 20px; text-align: center">TICKET DE MOSTRADOR
        </p>
        <p class="centrado">
            Fecha: {{$consumos[0]->fecha_venta}}
        </p>
        @if($consumos[0]->cliente == null)
        @else
            <p>Cliente: {{ $consumos[0]->cliente->NombreCliente}}</p>
        @endif

        @if($consumos[0]->Comentario == null)
        @else
            <p>{{ $consumos[0]->Comentario}}</p>
        @endif

        @if($consumos[0]->detalleconsumos->isEmpty())
            <p>No hay consumos registrados para esta venta.</p>
        @else
            <table>
                
                <tbody>
                    @foreach($consumos[0]->detalleconsumos as $detalle)
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
                                        <table style="width: 100%;">
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
                                        <table style="width: 100%;">
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
                        @endif
                    @endforeach
                </tbody>
            </table>
            <span style="width:  80%; display: block; font-weight: bold; text-align: justify;">
                TOTAL:
                <span style="float: right;">{{$consumos[0]->total}}</span>
            </span>
        @endif
        <p class="centrado">¡GRACIAS POR SU COMPRA!
    </div>
</body>

</html>
