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
                    <th colspan="5" style="background: black; color: white;">INFORME GENERAL</th>
                </tr>
                <tr>
                    <th>Tipo</th>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>        
            <tbody>
                {{-- Iterar sobre los hospedajes --}}
                @foreach ($hospedajes as $hospedaje)
                    @php
                        $cliente = count($hospedaje['detallehospedajes']) > 0 ? $hospedaje['detallehospedajes'][0]['cliente'] : null;
                    @endphp
                    <tr>
                        <td>Hospedaje</td>
                        <td>{{ $hospedaje['CodigoHospedaje'] ?? '' }}</td>
                        <td>{{ $cliente ? $cliente['Nombre_cliente'] . ' ' . $cliente['Apellido_cliente'] : 'Sin cliente' }}</td>
                        <td>{{ $hospedaje['CategoriaHabitacion'] ?? '' }} - Habitación #{{ $hospedaje['habitacion_id'] ?? '' }}</td>
                        <td>{{ $hospedaje['Total'] ?? '0.00' }}</td>
                    </tr>
                @endforeach

                {{-- Iterar sobre los grupohospedajes --}}
                @foreach ($grupohospedajes as $grupo)
                    @foreach ($grupo['hospedajes'] as $hospedaje)
                        @php
                            $cliente = $hospedaje['detallehospedajes'] && count($hospedaje['detallehospedajes']) > 0 ? $hospedaje['detallehospedajes'][0]['cliente'] : null;
                            $mostrarGuia = $hospedaje['GuiaTuristica'] === "true" ? 'Guía' : ($hospedaje['TotalHospedaje'] ?? '0.00');
                        @endphp
                        <tr>
                            <td>Grupo</td>
                            <td>{{ $grupo['TourName'] ?? '' }}</td>
                            <td>{{ $cliente ? $cliente['NombreCompleto_cliente'] : 'Sin cliente' }}</td>
                            <td>{{ $hospedaje['CategoriaHabitacion'] ?? '' }} - Habitación #{{ $hospedaje['habitacion_id'] ?? '' }}</td>
                            <td>{{ $mostrarGuia }}</td>
                        </tr>
                    @endforeach
                @endforeach

                {{-- Iterar sobre las reservashospedaje --}}
                @foreach ($reservashospedaje as $reserva)
                    @php
                        $cliente = $reserva['hospedajehabitacion']['detallehospedajes'] && count($reserva['hospedajehabitacion']['detallehospedajes']) > 0
                                ? $reserva['hospedajehabitacion']['detallehospedajes'][0]['cliente']
                                : null;
                    @endphp
                    <tr>
                        <td>Reserva</td>
                        <td>{{ $reserva['CodigoReserva'] ?? '' }}</td>
                        <td>{{ $cliente ? $cliente['NombreCompleto_cliente'] : 'Sin cliente' }}</td>
                        <td>{{ $reserva['CategoriaHabitacion'] ?? '' }} - Habitación #{{ $reserva['hospedajehabitacion']['habitacion_id'] ?? '' }}</td>
                        <td>{{ $reserva['hospedajehabitacion']['TotalHospedaje'] ?? '0.00' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="font-weight: bold; font-size: 14px; text-align: right" colspan="4">TOTAL HOSPEDAJES</td>
                    <td style="font-weight: bold; font-size: 14px">{{ $TotalHospedajes }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; font-size: 14px; text-align: right" colspan="4">TOTAL GRUPOS</td>
                    <td style="font-weight: bold; font-size: 14px">{{ $TotalGrupos }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; font-size: 14px; text-align: right" colspan="4">TOTAL RESERVAS</td>
                    <td style="font-weight: bold; font-size: 14px">{{ $TotalReservas }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; font-size: 14px; text-align: right" colspan="4">TOTAL GENERAL</td>
                    <td style="font-weight: bold; font-size: 14px">{{ $TotalGeneral }}</td>
                </tr>
            </tfoot>
        </table>

    @if(count($hospedajes) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">HOSPEDAJES</th>
            </tr>
            <tr>
                <th>Código</th>
                <th>Cliente</th>
                <th>Habitación</th>
                <th>Total</th>
            </tr>
        </thead>        
        <tbody>
            {{-- Iterar sobre los hospedajes --}}
            @foreach ($hospedajes as $hospedaje)
                @php
                    $cliente = count($hospedaje['detallehospedajes']) > 0 ? $hospedaje['detallehospedajes'][0]['cliente'] : null;
                @endphp
                <tr>
                    <td>{{ $hospedaje['CodigoHospedaje'] ?? '' }}</td>
                    <td>{{ $cliente ? $cliente['Nombre_cliente'] . ' ' . $cliente['Apellido_cliente'] : 'Sin cliente' }}</td>
                    <td>{{ $hospedaje['CategoriaHabitacion'] ?? '' }} - Habitación #{{ $hospedaje['habitacion_id'] ?? '' }}</td>
                    <td>{{ $hospedaje['Total'] ?? '0.00' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="font-weight: bold; font-size: 14px; text-align: right" colspan="3">TOTAL HOSPEDAJES</td>
                <td style="font-weight: bold; font-size: 14px">{{ $TotalHospedajes }}</td>
            </tr>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(count($grupohospedajes) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">GRUPO HOSPEDAJES</th>
            </tr>
            <tr>
                <th>Código</th>
                <th>Cliente</th>
                <th>Habitación</th>
                <th>Total</th>
            </tr>
        </thead>                
        <tbody>
            {{-- Iterar sobre los grupohospedajes --}}
            @foreach ($grupohospedajes as $grupo)
                @foreach ($grupo['hospedajes'] as $hospedaje)
                    @php
                        $cliente = $hospedaje['detallehospedajes'] && count($hospedaje['detallehospedajes']) > 0 ? $hospedaje['detallehospedajes'][0]['cliente'] : null;
                        $mostrarGuia = $hospedaje['GuiaTuristica'] === "true" ? 'Guía' : ($hospedaje['TotalHospedaje'] ?? '0.00');
                    @endphp
                    <tr>
                        <td>{{ $grupo['TourName'] ?? '' }}</td>
                        <td>{{ $cliente ? $cliente['NombreCompleto_cliente'] : 'Sin cliente' }}</td>
                        <td>{{ $hospedaje['CategoriaHabitacion'] ?? '' }} - Habitación #{{ $hospedaje['habitacion_id'] ?? '' }}</td>
                        <td>{{ $mostrarGuia }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="font-weight: bold; font-size: 14px; text-align: right" colspan="3">TOTAL GRUPOS</td>
                <td style="font-weight: bold; font-size: 14px">{{ $TotalGrupos }}</td>
            </tr>
            </tr>
        </tfoot>
    </table>
    @endif

    @if(count($reservashospedaje) > 0)
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background: black; color: white;">RESERVAS</th>
            </tr>
            <tr>
                <th>Código</th>
                <th>Cliente</th>
                <th>Habitación</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- Iterar sobre las reservashospedaje --}}
            @foreach ($reservashospedaje as $reserva)
                @php
                    $cliente = $reserva['hospedajehabitacion']['detallehospedajes'] && count($reserva['hospedajehabitacion']['detallehospedajes']) > 0
                            ? $reserva['hospedajehabitacion']['detallehospedajes'][0]['cliente']
                            : null;
                @endphp
                <tr>
                    <td>{{ $reserva['CodigoReserva'] ?? '' }}</td>
                    <td>{{ $cliente ? $cliente['NombreCompleto_cliente'] : 'Sin cliente' }}</td>
                    <td>{{ $reserva['CategoriaHabitacion'] ?? '' }} - Habitación #{{ $reserva['hospedajehabitacion']['habitacion_id'] ?? '' }}</td>
                    <td>{{ $reserva['hospedajehabitacion']['TotalHospedaje'] ?? '0.00' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="font-weight: bold; font-size: 14px; text-align: right" colspan="3">TOTAL RESERVAS</td>
                <td style="font-weight: bold; font-size: 14px">{{ $TotalReservas }}</td>
            </tr>
            </tr>
        </tfoot>
    </table>
    @endif
</body>
</html>
