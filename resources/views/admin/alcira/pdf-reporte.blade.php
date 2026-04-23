<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Envíos</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            color: #333;
            margin: 20px;
        }

        /* Marca de agua */
        .watermark {
            position: fixed;
            top: 45%;
            left: 41%;
            width: 125%;
            opacity: 0.6; 
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        h2 {
            text-align: center;
            color: #1a73e8;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        p { margin: 4px 0; position: relative; z-index: 1; }

        table {
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: linear-gradient(to bottom, #f0f0f0, #d9d9d9); font-weight: bold; }
        tbody tr:nth-child(even) { background: #f9f9f9; }

        .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #555; z-index: 1; }
        .info-label { font-weight: bold; color: #1a73e8; }
    </style>
</head>
<body>

@php
    $path = public_path('imagenes/hostal/MarcaDeAgua.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
@endphp

@foreach($envios as $envio)
    <img src="{{ $base64 }}" class="watermark">
    <br><br><br><br>

    <h2 style="color: #1a73e8; text-decoration: underline; font-size: 21px; font-weight: bold;">
        ENVIO DE CATERING - {{ $envio->estado }} - ({{ $envio->donde }})
    </h2>
    <h2 style="font-weight: bold; color: #1a73e8;">HOSTAL TUKOS LA CASA REAL</h2>

    <table>
        <tr>
            <th style="font-weight: bold; width: 150px;">DELIVERY / CHOFER</th>
            <th style="font-weight: bold; color: #1a73e8; width: 250px;">{{ $envio->chofer }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; width: 150px;">FECHA</th>
            <th style="font-weight: bold; color: #1a73e8; width: 250px;">{{ $envio->fecha_envio }}</th>
        </tr>
    </table>

    <br>
    <p style="font-weight: bold; color: #1a73e8;">DETALLE DE ENVIO</p>
    <table>
        <thead>
            <tr>
                <th style="width:5%; font-weight: bold;">#</th>
                <th style="width:45%; font-weight: bold;">Producto</th>
                <th style="width:20%; font-weight: bold;">Cantidad</th>
                <th style="width:30%; font-weight: bold;">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($envio->items as $index => $item)
                <tr>
                    <td style="font-weight: bold;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $item->producto }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->observaciones ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <p style="font-weight: bold; color: #1a73e8;">OBSERVACIONES GENERALES</p>
    <p>........................................................................................................................................................................
        ........................................................................................................................................................................
    </p>
    <br>
    <p style="font-weight: bold;">NOMBRE COMPLETO:</p>
    <p style="font-weight: bold;">..................................................................................................................................</p>
    <br>
    <p style="font-weight: bold;">FIRMA:</p>
    <p style="font-weight: bold;">..................................................................................................................................</p>
    <br>
    <p style="font-weight: bold;">FIRMA DELIVERY / CHOFER ({{ $envio->chofer }}):</p>
    <p style="font-weight: bold;">..................................................................................................................................</p>

    <div style="page-break-after: always;"></div>
@endforeach

</body>
</html>
