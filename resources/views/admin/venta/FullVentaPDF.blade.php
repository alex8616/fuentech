<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <style>
        table {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid black;
        font-size: 0.7rem;
        border: 1px solid #000000;
        padding: 15px;
        }

        td, th {
        border: 1px solid rgb(190,190,190);
        padding: 10px 20px;
        margin: 0;
        }

        th {
        background-color: rgb(235,235,235);
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
    
    <table>
        <thead>
            <tr>
                <th colspan="2" style="background: black; color: white;">INFORME GENERAL</th>
            </tr>
            <tr>
                <th>VENTAS</th>
                <th>TOTAL GENERAL</th>                
            </tr>
        </thead>        
        <tbody>
            <tr>
                <td>
                    <table>
                        @if(count($productosCantidadMesas) > 0)
                            <tr>
                                <td colspan="2" style="font-weight: bold;">MESAS</td>
                            </tr>
                            @foreach ($productosCantidadMesas as $producto => $cantidad)
                            <tr>
                                <td>{{ $producto }}</td>
                                <td style="width: 15%">{{ $cantidad }}</td>
                            </tr>
                            @endforeach
                        @endif

                        @if(count($productosCantidadMostrador) > 0)
                        <tr>
                            <td colspan="2" style="font-weight: bold;">MOSTRADOR</td>
                        </tr>
                        @foreach ($productosCantidadMostrador as $producto => $cantidad)
                            <tr>
                                <td>{{ $producto }}</td>
                                <td style="width: 15%">{{ $cantidad }}</td>
                            </tr>
                        @endforeach
                        @endif

                        @if(count($productosCantidadDelivery) > 0)
                        <tr>
                            <td colspan="2" style="font-weight: bold;">DELIVERY</td>
                        </tr>
                        @foreach ($productosCantidadDelivery as $producto => $cantidad)
                        <tr>
                            <td>{{ $producto }}</td>
                            <td style="width: 15%">{{ $cantidad }}</td>
                        </tr>
                        @endforeach
                        @endif

                        @if(count($productosCantidadHabitacion) > 0)
                        <tr>
                            <td colspan="2" style="font-weight: bold;">HABITACION</td>
                        </tr>
                        @foreach ($productosCantidadHabitacion as $producto => $cantidad)
                        <tr>
                            <td>{{ $producto }}</td>
                            <td style="width: 15%">{{ $cantidad }}</td>
                        </tr>
                        @endforeach
                        @endif

                        @if(count($productosCantidadSalone) > 0)
                        <tr>
                            <td colspan="2" style="font-weight: bold;">SALONES</td>
                        </tr>
                        @foreach ($productosCantidadSalone as $producto => $cantidad)
                            <tr>
                                <td>{{ $producto }}</td>
                                <td style="width: 15%">{{ $cantidad }}</td>
                            </tr>
                        @endforeach
                        @endif
                        
                        @if(count($productosCantidadPedidoYa) > 0)
                        <tr>
                            <td colspan="2" style="font-weight: bold;">PEDIDOSYA - DINKI</td>
                        </tr>
                        @foreach ($productosCantidadPedidoYa as $producto => $cantidad)
                        <tr>
                            <td>{{ $producto }}</td>
                            <td style="width: 15%">{{ $cantidad }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td colspan="2" style="font-weight: bold;">TOTAL PRODUCTOS</td>
                        </tr>
                        @foreach ($productosCantidad as $producto => $cantidad)
                        <tr>
                            <td>{{ $producto }}</td>
                            <td style="width: 15%">{{ $cantidad }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td style="font-weight: bold;">TOTAL</td>
                            <td style="font-weight: bold;">{{ $totalProductosVendidos }}</td>
                        </tr>
                    </table>
                </td>                
            </tr>
        </tbody>
    </table>  

    @if(count($productosCantidadMesas) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">VENTAS EN MESAS</th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumomesas as $consumo)
                <tr>
                    <td>{{  $consumo->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($consumo->TipoConsumo != "ServicioPedido")
                            {{ $consumo->TipoConsumo }}
                        @else
                            {{ $consumo->TipoConsumo }} - {{ $consumo->TipoServicioPedido }}
                        @endif
                    </td>
                    <td>
                        @foreach($consumo->detalleconsumos as $detalle)
                            <ul>
                                <li>{{ $detalle->producto->NombreProducto }} - {{ $detalle->cantidad }} - {{ number_format($detalle->precio, 2) }}</li>
                            </ul>
                        @endforeach
                    </td>
                    <td>{{ $consumo->total }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">
                    {{ number_format($totalMesas, 2)}}
                </td>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(count($productosCantidadMostrador) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">VENTAS EN MOSTRADOR</th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumomostradores as $consumo)
                <tr>
                    <td>{{  $consumo->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($consumo->TipoConsumo != "ServicioPedido")
                            {{ $consumo->TipoConsumo }}
                        @else
                            {{ $consumo->TipoConsumo }} - {{ $consumo->TipoServicioPedido }}
                        @endif
                    </td>
                    <td>
                        @foreach($consumo->detalleconsumos as $detalle)
                            <ul>
                                <li>{{ $detalle->producto->NombreProducto }} - {{ $detalle->cantidad }} - {{ number_format($detalle->precio, 2) }}</li>
                            </ul>
                        @endforeach
                    </td>
                    <td>{{ $consumo->total }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">
                    {{ number_format($totalMostrador, 2)}}
                </td>
            </tr>
        </tfoot>
    </table>
    @endif
    
    @if(count($productosCantidadDelivery) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">VENTAS EN DELIVERY</th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumodeliverys as $consumo)
                <tr>
                    <td>{{  $consumo->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($consumo->TipoConsumo != "ServicioPedido")
                            {{ $consumo->TipoConsumo }}
                        @else
                            {{ $consumo->TipoConsumo }} - {{ $consumo->TipoServicioPedido }}
                        @endif
                    </td>
                    <td>
                        @foreach($consumo->detalleconsumos as $detalle)
                            <ul>
                                <li>{{ $detalle->producto->NombreProducto }} - {{ $detalle->cantidad }} - {{ number_format($detalle->precio, 2) }}</li>
                            </ul>
                        @endforeach
                    </td>
                    <td>{{ $consumo->total }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">
                    {{ number_format($totalDelivery, 2)}}
                </td>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(count($productosCantidadHabitacion) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">VENTAS EN HABITACION</th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumohabitacions as $consumo)
                <tr>
                    <td>{{  $consumo->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($consumo->TipoConsumo != "ServicioPedido")
                            {{ $consumo->TipoConsumo }}
                        @else
                            {{ $consumo->TipoConsumo }} - {{ $consumo->TipoServicioPedido }}
                        @endif
                    </td>
                    <td>
                        @foreach($consumo->detalleconsumos as $detalle)
                            <ul>
                                <li>{{ $detalle->producto->NombreProducto }} - {{ $detalle->cantidad }} - {{ number_format($detalle->precio, 2) }}</li>
                            </ul>
                        @endforeach
                    </td>
                    <td>{{ $consumo->total }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">
                    {{ number_format($totalHabitacion, 2)}}
                </td>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(count($productosCantidadSalone) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">VENTAS EN SALON</th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumosalones as $consumo)
                <tr>
                    <td>{{  $consumo->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($consumo->TipoConsumo != "ServicioPedido")
                            {{ $consumo->TipoConsumo }}
                        @else
                            {{ $consumo->TipoConsumo }} - {{ $consumo->TipoServicioPedido }}
                        @endif
                    </td>
                    <td>
                        @foreach($consumo->detalleconsumos as $detalle)
                            <ul>
                                <li>{{ $detalle->producto->NombreProducto }} - {{ $detalle->cantidad }} - {{ number_format($detalle->precio, 2) }}</li>
                            </ul>
                        @endforeach
                    </td>
                    <td>{{ $consumo->total }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">
                    {{ number_format($totalSalone, 2)}}
                </td>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(count($productosCantidadPedidoYa) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">PEDIDOS YA - DINKI</th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumopedidosya as $consumo)
                <tr>
                    <td>{{  $consumo->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($consumo->TipoConsumo != "ServicioPedido")
                            {{ $consumo->TipoConsumo }}
                        @else
                            {{ $consumo->TipoConsumo }} - {{ $consumo->TipoServicioPedido }}
                        @endif
                    </td>
                    <td>
                        @foreach($consumo->detalleconsumos as $detalle)
                            <ul>
                                <li>{{ $detalle->producto->NombreProducto }} - {{ $detalle->cantidad }} - {{ number_format($detalle->precio, 2) }}</li>
                            </ul>
                        @endforeach
                    </td>
                    <td>{{ $consumo->total }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">
                    {{ number_format($totalPedidoYa, 2)}}
                </td>
            </tr>
        </tfoot>
    </table>
    @endif

</body>
</html>
