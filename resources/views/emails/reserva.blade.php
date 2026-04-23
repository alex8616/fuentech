<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial; background:#f5f5f5; padding:20px;">

@php
    $detalle = $reserva->detalles->first();
    $habitacion = $detalle->tipoHabitacion->nombre ?? 'Habitación';
    $personas = $reserva->adultos;

    $mensaje = "Hola, tengo una reserva en TUKO'S.\n".
               "Habitación: ".$habitacion."\n".
               "Personas: ".$personas."\n".
               "Código: ".$reserva->codigo_reserva;
@endphp

<div style="max-width:600px; margin:auto; background:white; padding:25px; border-radius:10px;">

    <h2 style="color:#c5a572;">¡Gracias por tu reserva! 🏨</h2>

    <p>Hola <b>{{ $reserva->nombre }}</b>,</p>

    <p>Hemos recibido tu solicitud de reserva correctamente.</p>

    <hr>

    <h3>📋 Detalles de tu reserva</h3>

    <p><b>Código de reserva:</b> {{ $reserva->codigo_reserva }}</p>

    <p><b>Habitación:</b> {{ $habitacion }}</p>

    <p><b>Personas:</b> {{ $personas }} adulto(s)</p>

    <p><b>Fechas:</b> {{ $reserva->fecha_ingreso }} → {{ $reserva->fecha_salida }}</p>

    <p><b>Estado actual:</b> 
        <span style="color:#c5a572;"><b>{{ strtoupper($reserva->estado) }}</b></span>
    </p>

    <hr>

    <p>Puedes consultar el estado de tu reserva en cualquier momento:</p>

    <a href="{{ url('apihostal/reserva/estado/'.$reserva->codigo_reserva) }}"
       style="display:inline-block;background:#c5a572;color:white;padding:12px 20px;text-decoration:none;border-radius:5px;">
        Ver estado de reserva
    </a>

    <hr>

    <h3>📞 Contacto</h3>

    <p>Si tienes alguna consulta, puedes comunicarte con nosotros:</p>

    <p>
        <b>📱 WhatsApp:</b><br>
        <a href="https://wa.me/59179431192?text={{ urlencode($mensaje) }}"
           style="display:inline-block;background:#25D366;color:white;padding:10px 15px;border-radius:5px;text-decoration:none;">
            Enviar mensaje por WhatsApp
        </a>
    </p>

    <p><b>☎ Teléfono:</b> 26230689</p>

    <p><b>📍 Dirección:</b> Calle Hoyos #29</p>

    <hr>

    <p style="text-align:center;">
        Gracias por elegir <b>TUKO'S LA CASA REAL</b> ✨
    </p>

</div>

</body>
</html>