<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Planilla De Asistencia</title>
    <link href="minimal-table.css" rel="stylesheet" type="text/css">
  </head>
  <body>
@php $i = 1; @endphp

@foreach ($resultados as $usuarioId => $detallesPorFecha)
    @php
        $persona = $allpersons->firstWhere('id', $usuarioId);
    @endphp

    @if ($persona && $persona->estado === 'true')
        <table id="cabezera">
            <tr>
                <td rowspan="2" style="width: 150px">
                    <img src="{{ $persona->imagen }}" alt="Imagen" width="60%" style="border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                </td>
                <td style="font-size: 13px;">
                    <strong>NOMBRE:</strong> {{ $persona->Nombre_Completo }}
                </td>            
                <td style="font-size: 13px;">
                    <strong>C.I.:</strong> {{ $persona->Dni }}
                </td>
            </tr>
            <tr>
                <td style="font-size: 13px;">
                    <strong>CARGO:</strong> {{ $persona->Cargo }}
                </td>
            </tr>
        </table>

        <table id="tbplanilla">
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Fecha</th>                
                    <th>Operacion</th>
                    <th>H/M Trabajado</th>
                    <th>Observacion</th>
                </tr>
            </thead>
            <tbody>    
                @foreach ($detallesPorFecha as $fecha => $detalle)
                    @if($detalle['nombreDia'] == $persona->Libre)
                        <tr>
                            <td>{{ $detalle['nombreDia'] }}</td>
                            <td colspan="4" style="text-align: center">L I B R E</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $detalle['nombreDia'] }}</td>
                            <td>{{ $fecha }}</td>
                            <td>
                                <table>
                                    <tr>
                                        @foreach ($detalle['detalles'] as $registro)
                                            <td style="padding: 3px;">
                                                @if ($registro->estado === 'ingreso' && $registro->hora_ingreso)
                                                    <strong>Ingreso:</strong> <br> {{ $registro->hora_ingreso }}
                                                @elseif ($registro->estado === 'salida' && $registro->hora_salida)
                                                    <strong>Salida:</strong> <br> {{ $registro->hora_salida }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                            </td>
                            <td>{{ $detalle['totalHorasTrabajadas'] }} horas {{ $detalle['totalMinutosTrabajados'] }} minutos</td>
                            <td style="width: 130px">
                                @foreach ($detalle['detalles'] as $registro)
                                    {{ $registro->RazonHoraExtra ?? '' }}
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <div style="page-break-after: always;"></div>
    @endif
@endforeach
</body>

</html>
<style>
    html {
      font-family: sans-serif;
      margin-top: 20px;
      margin-bottom: 5px;
      margin-left: 25px;
      margin-right: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border: 2px solid black;
      font-size: 0.7rem;
    }

    td, th {
      border: 1px solid black;
      padding: 1px 3px;
    }

    th {
      background-color: #80C2FF;
    }

    td {
	    padding: 5px;
    }

    caption {
      padding: 10px;
    }
    #cabezera td{
      border: none;
    }
    #cabezera{
      border: none;
    }
</style>