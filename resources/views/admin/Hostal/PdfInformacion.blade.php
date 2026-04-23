<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Inventario Activos Fijos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td {
            padding: 3px;
            background-color: #fff;
            border: none; /* Elimina el borde */
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .elegant-img {
            width: 20%;
            height: auto;
            margin: 5px;
            border-radius: 3px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .elegant-img:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        #tabla-articulos {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            font-family: Arial, sans-serif;
        }

        #tabla-articulos th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 3px;
        }

        #tabla-articulos td {
            border: 1px solid #ddd;
            padding: 3px;
            vertical-align: top;
        }

        #tabla-articulos tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #tabla-articulos tr:hover {
            background-color: #f1f1f1;
        }

        P{
            font-size: 14px;
        }

        strong{
            font-size: 13px;
        }

    </style>
</head>
<body>
    <center><h3>HOSPEDAJE {{ $habitacion->Nombre_habitacion }}</h3></center>

    <table style="border-collapse: collapse; width: 100%; table-layout: fixed;">
        <tr>
            <td style="width: 25%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    <p style="margin: 0;">
                        {{ $habitacion->Nombre_habitacion }} - {{ $detalle->CodigoHospedaje }}<br>
                    </p>
                @endforeach
            </td>
            <td style="width: 4%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">Bs</td>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    <p style="margin: 0;">
                        {{ $detalle->CambioBolivianos }}<br>
                    </p>
                @endforeach
            </td>
            <td style="width: 4%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">$us</td>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    <p style="margin: 0;">
                        {{ $detalle->CambioDolar }}<br>
                    </p>
                @endforeach
            </td>
        </tr>
    </table>

    @foreach($habitacion->hospedajehabitacion as $detalle)
        @if($detalle->autos->isNotEmpty())
            @foreach($detalle->autos as $auto)
            <table style="border-collapse: collapse; width: 100%; table-layout: fixed;">
                <tr>
                    <td style="vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                        <strong>Movilidad</strong>
                    </td>
                    <td style="vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                        <p style="margin: 0;">
                            {{ $auto->comentario }} - {{ $auto->placa }}<br>
                        </p>
                    </td>
                </tr>
            </table>
            @endforeach
        @endif
    @endforeach

    @foreach($habitacion->hospedajehabitacion as $detalle)
        @if($detalle->prestamos->isNotEmpty())
            <table style="border-collapse: collapse; width: 100%; table-layout: fixed;">
                <tr>
                    <td style="vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                        <strong>Prestamos</strong>
                    </td>
                    <td style="vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                        @foreach($detalle->prestamos as $prestamo)
                        <p style="margin: 0;">
                            {{ $prestamo->nombre_objeto }} - {{ $prestamo->comentario }}<br>
                        </p>
                        @endforeach
                    </td>
                </tr>
            </table>
        @endif
    @endforeach

    <table style="border-collapse: collapse; width: 100%; table-layout: fixed;">      
        <tr>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>APELLIDOS</strong>
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    @foreach($detalle->detallehospedajes as $detalleHospedaje)
                        @if(isset($detalleHospedaje->cliente))
                            <p style="margin: 0;">
                                {{ $detalleHospedaje->cliente->Apellido_cliente }}<br>
                            </p>
                        @endif
                    @endforeach
                @endforeach
            </td>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>NOMBRE</strong>    
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    @foreach($detalle->detallehospedajes as $detalleHospedaje)
                        @if(isset($detalleHospedaje->cliente))
                            <p style="margin: 0;">
                                {{ $detalleHospedaje->cliente->Nombre_cliente }}<br>
                            </p>
                        @endif
                    @endforeach
                @endforeach
            </td>
        </tr>

        <tr>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>NACIONALIDAD</strong>
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    @foreach($detalle->detallehospedajes as $detalleHospedaje)
                        @if(isset($detalleHospedaje->cliente))
                            <p style="margin: 0;">
                                {{ $detalleHospedaje->cliente->Nacionalidad_cliente }}<br>
                            </p>
                        @endif
                    @endforeach
                @endforeach
            </td>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>PROFESION</strong>    
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    @foreach($detalle->detallehospedajes as $detalleHospedaje)
                        @if(isset($detalleHospedaje->cliente))
                            <p style="margin: 0;">
                                {{ $detalleHospedaje->cliente->Profesion_cliente }}<br>
                            </p>
                        @endif
                    @endforeach
                @endforeach
            </td>
        </tr>

        <tr>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>INGRESO</strong>
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                <p style="margin: 0;">
                    {{ \Carbon\Carbon::parse($detalle->ingreso_hospedaje)->format('Y-m-d') }}<br>
                </p>
                @endforeach
            </td>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>SALIDA</strong>    
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                <p style="margin: 0;">
                    {{ \Carbon\Carbon::parse($detalle->salida_hospedaje)->format('Y-m-d') }}<br>
                </p>
                @endforeach
            </td>
        </tr>

        <tr>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>HORA DE LLEGADA</strong>
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                <p style="margin: 0;">
                    {{ $detalle->hora_ingreso_hospedaje }}<br>
                </p>
                @endforeach
            </td>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>DESTINO</strong>    
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                <p style="margin: 0;">
                    {{ $detalle->destino_hospedaje }}<br>
                </p>
                @endforeach
            </td>
        </tr>

        <tr>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>PROCEDENTE DE</strong>
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                <p style="margin: 0;">
                    {{ $detalle->procedencia_hospedaje }}<br>
                </p>
                @endforeach
            </td>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>N DE TELEFONO</strong>    
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    @foreach($detalle->detallehospedajes as $detalleHospedaje)
                        @if(isset($detalleHospedaje->cliente))
                            <p style="margin: 0;">
                                {{ $detalleHospedaje->cliente->Celular_cliente }}<br>
                            </p>
                        @endif
                    @endforeach
                @endforeach
            </td>
        </tr>

        <tr>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>C.I. PASAPORTE</strong>
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    @foreach($detalle->detallehospedajes as $detalleHospedaje)
                        @if(isset($detalleHospedaje->cliente))
                            <p style="margin: 0;">
                                {{ $detalleHospedaje->cliente->Documento_cliente }}<br>
                            </p>
                        @endif
                    @endforeach
                @endforeach
            </td>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>EDAD</strong>    
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    @foreach($detalle->detallehospedajes as $detalleHospedaje)
                        @if(isset($detalleHospedaje->cliente))
                            <p style="margin: 0;">
                                {{ $detalleHospedaje->cliente->FechaNacimiento_cliente }} = {{ $detalleHospedaje->cliente->Edad_cliente }}<br>
                            </p>
                        @endif
                    @endforeach
                @endforeach
            </td>
        </tr>
        
        <tr>
            <td style="width: 15%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>ESTADO CIVIL</strong>
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    @foreach($detalle->detallehospedajes as $detalleHospedaje)
                        @if(isset($detalleHospedaje->cliente))
                            <p style="margin: 0;">
                                {{ $detalleHospedaje->cliente->EstadoCivil_cliente }}<br>
                            </p>
                        @endif
                    @endforeach
                @endforeach
            </td>
            <td style="width: 17%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                <strong>RECEPCIONISTA</strong>    
            </td>
            <td style="width: 35%; vertical-align: top; padding: 3px; border-bottom: 1px dashed #9AA6B2;">
                @foreach($habitacion->hospedajehabitacion as $detalle)
                    <p style="margin: 0;">
                        {{ $detalle->user->name }}<br>
                    </p>
                @endforeach
            </td>
        </tr>
    </table>
</body>
</html>