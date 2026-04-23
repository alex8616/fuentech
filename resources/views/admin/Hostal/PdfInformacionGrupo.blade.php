<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reporte Grupo Hospedaje</title>

<style>
    @page { margin: 25px; }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 10px;
        color: #2c3e50;
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 4px;
        vertical-align: top;
    }

    .title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .info-table td {
        border: none;
        padding: 3px 6px;
        font-size: 10px;
    }

    .section-header {
        background: #34495e;
        color: #fff;
        font-weight: bold;
        font-size: 11px;
        padding: 6px;
    }

    .room-container td {
        width: 50%;
        padding: 6px;
    }

    .room-box {
        border: 1px solid #2980b9;
    }

    .room-header {
        background: #ecf0f1;
        font-weight: bold;
        font-size: 10px;
        padding: 5px;
        position: relative;
    }

    .guide-badge {
        color: red;
        font-weight: bold;
        float: right;
    }

    .room-body td {
        font-size: 9px;
        padding: 3px 6px;
        border-bottom: 1px solid #f0f0f0;
    }

    .price-row td {
        font-weight: bold;
        font-size: 10px;
        padding: 5px;
    }

    .text-right {
        text-align: right;
    }

    .totals-table {
        margin-top: 10px;
        width: 50%;
        float: right;
    }

    .totals-table td {
        padding: 4px;
        font-size: 10px;
    }

    .grand-total {
        font-size: 12px;
        font-weight: bold;
        border-top: 1px solid #000;
    }

</style>
</head>

<body>

<div class="title">REPORTE GRUPO HOSPEDAJE</div>

<!-- INFORMACIÓN GENERAL -->
<table class="info-table">
<tr>
    <td><strong>GRUPO:</strong> {{ $grupo->TourName }}</td>
    <td><strong>CÓDIGO:</strong> {{ $grupo->CodigoHospedaje }}</td>
</tr>
<tr>
    <td><strong>INGRESO:</strong> {{ date('Y-m-d', strtotime($grupo->ingreso_hospedaje)) }}</td>
    <td><strong>SALIDA:</strong> {{ date('Y-m-d', strtotime($grupo->salida_hospedaje)) }}</td>
</tr>
<tr>
    <td><strong>PAX:</strong> {{ $grupo->CantidadPersonas }}</td>
    <td><strong>DESTINO:</strong> {{ $grupo->destino_hospedaje }}</td>
</tr>
</table>

<br>

<table class="room-container">

@php
$chunked = collect($grupo->hospedajes)->chunk(2);
@endphp

@foreach($chunked as $row)
<tr>

@foreach($row as $hospedaje)
<td>

@php
    // 🔥 AQUÍ ESTÁ LA LÓGICA CORRECTA
    $esGuia = filter_var($hospedaje->GuiaTuristica ?? false, FILTER_VALIDATE_BOOLEAN);
@endphp

<table class="room-box">
    
    <!-- HEADER -->
    <tr>
        <td colspan="2" class="room-header">
            {{ $hospedaje->habitacion->Nombre_habitacion }}
            - {{ $hospedaje->CategoriaHabitacion }}

            @if($esGuia)
                <span class="guide-badge">
                    GUÍA DEL GRUPO
                </span>
            @endif
        </td>
    </tr>

    <!-- CLIENTES -->
    <tr>
        <td colspan="2">
            <table class="room-body" style="width:100%;">
                
                <tr style="background:#f8f9fa; font-weight:bold;">
                    <td style="width:70%;">Nombre</td>
                    <td style="width:30%;">Documento</td>
                </tr>

                @foreach($hospedaje->detallehospedajes as $detalle)
                <tr>
                    <td>
                        {{ $detalle->cliente->NombreCompleto_cliente }}
                    </td>
                    <td>
                        {{ $detalle->cliente->Documento_cliente }}
                    </td>
                </tr>
                @endforeach

            </table>
        </td>
    </tr>

    <!-- PRECIO -->
    <tr class="price-row">
        <td>Precio Habitación</td>
        <td class="text-right">
            {{ number_format($hospedaje->Precio_habitacion,2) }} Bs.
        </td>
    </tr>

</table>

</td>
@endforeach

@if(count($row) == 1)
<td></td>
@endif

</tr>
@endforeach

</table>

<br>

<!-- TOTALES -->
<table class="totals-table">
<tr>
    <td>TOTAL HOSPEDAJE:</td>
    <td class="text-right">
        {{ number_format($grupo->TotalHospedaje,2) }} Bs.
    </td>
</tr>
<tr>
    <td class="grand-total">TOTAL A PAGAR:</td>
    <td class="text-right grand-total">
        {{ number_format($grupo->TotalHospedaje,2) }} Bs.
    </td>
</tr>
</table>

</body>
</html>