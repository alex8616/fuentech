<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Planilla De Asistencia</title>
    <link href="minimal-table.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    @php
      $i=1;
    @endphp
    @foreach($personals as $personal)
    <table id="cabezera">
      <tr>
        <td>
          <div style="text-align: center; width: 100px">
          <strong>HOSTAL TUKO'S</strong><br>
          "LA CASA REAL" <br>
          POTOSI - BOLIVIA <br>
          </div>
        </td>
        <td style="text-align: right;">FOJA {{ $i++ }}</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;"><strong style="font-size: 20px;">CONTROL DE ASISTENCIA ( {{ strtoupper($monthText) }} - {{ $year }})</strong></td>
      </tr>
        <tr>
            <td style="font-size: 13px;">
                <strong>NOMBRE:</strong> {{ $personal->Nombre_Completo }}    
            </td>            
            <td style="font-size: 13px;">
                <strong>C.I.:</strong>{{ $personal->Dni }}
            </td>
        </tr>
        <tr>
            <td style="font-size: 13px;">
                <strong>CARGO:</strong> {{ $personal->Cargo }}                
            </td>
        </tr>
    </table>
    @if($personal->Tiempo == 'MEDIO')
    <table id="tbplanilla">
        <thead>
            <tr>
                <th rowspan="2" style="width: 80px;">FECHA</th>
                <th rowspan="2" style="width: 50px;">DIA</th>
                <th colspan="2">INGRESO</th>
                <th colspan="2">SALIDA</th>
                <th rowspan="2">OBSERVACION</th>
            </tr>
            <tr>
              <th>HORA</th>
              <th>FIRMA</th>
              <th>HORA</th>
              <th>FIRMA</th>
            </tr>
        </thead>
        <tbody>    
        @foreach($days as $day)
            <tr>
                <td style="text-align: center;">{{ $day['date'] }}</td>
                <td>{{ $day['dayOfWeek'] }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach        
        </tbody>
    </table>
    @else
    <table id="tbplanilla">
      <thead>
          <tr>
              <th rowspan="2" style="width: 80px;">FECHA</th>
              <th rowspan="2" style="width: 50px;">DIA</th>
              <th colspan="2">INGRESO</th>
              <th colspan="2">SALIDA</th>
              <th colspan="2">INGRESO</th>
              <th colspan="2">SALIDA</th>
              <th rowspan="2">OBSERVACION</th>
          </tr>
          <tr>
            <th>HORA</th>
            <th>FIRMA</th>
            <th>HORA</th>
            <th>FIRMA</th>
            <th>HORA</th>
            <th>FIRMA</th>
            <th>HORA</th>
            <th>FIRMA</th>
          </tr>
      </thead>
      <tbody>    
      @foreach($days as $day)
          <tr>
              <td style="text-align: center;">{{ $day['date'] }}</td>
              <td>{{ $day['dayOfWeek'] }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>
      @endforeach        
      </tbody>
  </table>
    @endif
    <table style="width: 30%; float: right;">
      <tr>
        <td>PERMISOS</td>
        <td style="width: 80px;"></td>          
      </tr>
      <tr>
        <td>FALTAS</td>
        <td style="width: 80px;"></td>          
      </tr>
      <tr>
        <td>DIAS TRABAJADOS</td>
        <td style="width: 80px;"></td>
      </tr>
      <tr>
        <td>TOTAL DIAS</td>
        <td style="width: 80px;"></td>
      </tr>
    </table>
    <div style="page-break-after:always;"></div>
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