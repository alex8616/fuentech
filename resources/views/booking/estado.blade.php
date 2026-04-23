<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Reserva - TUKO'S La Casa Real</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --color-primario: #1A1A1A;
            --color-secundario: #C5A572;
            --color-terciario: #2C2C2C;
            --color-texto: #FFFFFF;
            --color-texto-claro: #E0E0E0;
            --color-fondo: #121212;
            --color-blanco: #FFFFFF;
            --color-exito: #28a745;
            --color-pendiente: #ffc107;
            --color-cancelado: #dc3545;
            --color-confirmado: #28a745;
        }

        body {
            background: linear-gradient(135deg, var(--color-fondo) 0%, var(--color-primario) 100%);
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Contenedor principal */
        .container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }

        /* Tarjeta de reserva */
        .reserva-card {
            background: var(--color-terciario);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(197, 165, 114, 0.3);
            animation: fadeInUp 0.6s ease;
        }

        /* Header de la tarjeta */
        .reserva-header {
            background: linear-gradient(135deg, var(--color-primario) 0%, var(--color-terciario) 100%);
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(197, 165, 114, 0.3);
            position: relative;
        }

        .reserva-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-secundario), transparent);
        }

        .reserva-icon {
            font-size: 3rem;
            color: var(--color-secundario);
            margin-bottom: 15px;
        }

        .reserva-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            color: var(--color-blanco);
            margin-bottom: 10px;
        }

        .reserva-subtitle {
            color: var(--color-texto-claro);
            font-size: 0.9rem;
        }

        /* Estado badge */
        .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 15px;
        }

        .estado-pendiente {
            background: rgba(255, 193, 7, 0.2);
            color: var(--color-pendiente);
            border: 1px solid var(--color-pendiente);
        }

        .estado-confirmada {
            background: rgba(40, 167, 69, 0.2);
            color: var(--color-exito);
            border: 1px solid var(--color-exito);
        }

        .estado-cancelada {
            background: rgba(220, 53, 69, 0.2);
            color: var(--color-cancelado);
            border: 1px solid var(--color-cancelado);
        }

        /* Cuerpo de la tarjeta */
        .reserva-body {
            padding: 30px;
        }

        /* Información de reserva */
        .info-group {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .info-group:hover {
            background: rgba(197, 165, 114, 0.1);
            transform: translateX(5px);
        }

        .info-icon {
            width: 45px;
            height: 45px;
            background: rgba(197, 165, 114, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-secundario);
            font-size: 1.3rem;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--color-secundario);
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--color-blanco);
            font-family: 'Cormorant Garamond', serif;
        }

        .info-value code {
            background: rgba(0, 0, 0, 0.3);
            padding: 4px 8px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.9rem;
        }

        /* Fechas destacadas */
        .fechas-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .fecha-card {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .fecha-card:hover {
            background: rgba(197, 165, 114, 0.1);
        }

        .fecha-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--color-secundario);
            margin-bottom: 8px;
        }

        .fecha-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--color-blanco);
        }

        .fecha-value i {
            margin: 0 8px;
            color: var(--color-secundario);
            font-size: 0.8rem;
        }

        /* Timeline de estado */
        .timeline {
            margin: 30px 0;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: rgba(197, 165, 114, 0.3);
        }

        .timeline-item {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            position: relative;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            background: var(--color-terciario);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(197, 165, 114, 0.3);
            z-index: 1;
        }

        .timeline-icon.active {
            border-color: var(--color-secundario);
            background: var(--color-secundario);
            color: var(--color-primario);
        }

        .timeline-icon.completed {
            border-color: var(--color-exito);
            background: var(--color-exito);
            color: white;
        }

        .timeline-content {
            flex: 1;
            padding-bottom: 10px;
        }

        .timeline-title {
            font-weight: 600;
            color: var(--color-blanco);
            margin-bottom: 5px;
        }

        .timeline-desc {
            font-size: 0.8rem;
            color: var(--color-texto-claro);
        }

        /* Acciones */
        .acciones {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            padding: 14px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-primario {
            background: var(--color-secundario);
            color: var(--color-primario);
        }

        .btn-primario:hover {
            background: var(--color-blanco);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(197, 165, 114, 0.3);
        }

        .btn-secundario {
            background: transparent;
            border: 1px solid var(--color-secundario);
            color: var(--color-secundario);
        }

        .btn-secundario:hover {
            background: var(--color-secundario);
            color: var(--color-primario);
            transform: translateY(-2px);
        }

        /* Footer de la tarjeta */
        .reserva-footer {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid rgba(197, 165, 114, 0.2);
        }

        .reserva-footer p {
            font-size: 0.75rem;
            color: var(--color-texto-claro);
        }

        .reserva-footer i {
            color: var(--color-secundario);
            margin: 0 3px;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 550px) {
            .fechas-container {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .acciones {
                flex-direction: column;
            }
            
            .reserva-header h1 {
                font-size: 1.5rem;
            }
            
            .info-group {
                padding: 12px;
            }
            
            .info-value {
                font-size: 0.9rem;
            }
        }

        /* Print styles */
        @media print {
            .acciones,
            .reserva-footer {
                display: none;
            }
            
            body {
                background: white;
                padding: 0;
            }
            
            .reserva-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="reserva-card">
            <!-- Header -->
            <div class="reserva-header">
                <div class="reserva-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h1>Estado de tu Reserva</h1>
                <p class="reserva-subtitle">TUKO'S La Casa Real</p>
                
                @php
                    $estadoClase = match($reserva->estado) {
                        'pendiente' => 'estado-pendiente',
                        'confirmada', 'confirmado' => 'estado-confirmada',
                        'cancelada', 'cancelado' => 'estado-cancelada',
                        default => 'estado-pendiente'
                    };
                    
                    $estadoIcono = match($reserva->estado) {
                        'pendiente' => 'fa-clock',
                        'confirmada', 'confirmado' => 'fa-check-circle',
                        'cancelada', 'cancelado' => 'fa-times-circle',
                        default => 'fa-info-circle'
                    };
                @endphp
                
                <div class="estado-badge {{ $estadoClase }}">
                    <i class="fas {{ $estadoIcono }}"></i>
                    {{ strtoupper($reserva->estado) }}
                </div>
            </div>

            <!-- Body -->
            <div class="reserva-body">
                <!-- Código de reserva -->
                <div class="info-group">
                    <div class="info-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Código de reserva</div>
                        <div class="info-value">
                            <code>{{ $reserva->codigo_reserva }}</code>
                        </div>
                    </div>
                </div>

                <!-- Datos del cliente -->
                <div class="info-group">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Nombre del huésped</div>
                        <div class="info-value">{{ $reserva->nombre }}</div>
                    </div>
                </div>

                <!-- Fechas -->
                <div class="fechas-container">
                    <div class="fecha-card">
                        <div class="fecha-label">
                            <i class="fas fa-calendar-plus"></i> CHECK-IN
                        </div>
                        <div class="fecha-value">
                            {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d/m/Y') }}
                            <div style="font-size: 0.75rem; color: var(--color-texto-claro); margin-top: 5px;">
                                {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('l') }}
                            </div>
                        </div>
                    </div>
                    <div class="fecha-card">
                        <div class="fecha-label">
                            <i class="fas fa-calendar-minus"></i> CHECK-OUT
                        </div>
                        <div class="fecha-value">
                            {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}
                            <div style="font-size: 0.75rem; color: var(--color-texto-claro); margin-top: 5px;">
                                {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('l') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline de estado -->
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon {{ $reserva->estado != 'cancelada' ? 'active' : '' }}">
                            <i class="fas fa-{{ $reserva->estado != 'cancelada' ? 'check' : 'times' }}"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Reserva realizada</div>
                            <div class="timeline-desc">{{ \Carbon\Carbon::parse($reserva->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    
                    @if($reserva->estado != 'cancelada')
                    <div class="timeline-item">
                        <div class="timeline-icon {{ $reserva->estado == 'confirmada' ? 'completed' : '' }}">
                            <i class="fas fa-{{ $reserva->estado == 'confirmada' ? 'check' : 'clock' }}"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Confirmación</div>
                            <div class="timeline-desc">
                                {{ $reserva->estado == 'confirmada' ? 'Reserva confirmada' : 'Pendiente de confirmación' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-hotel"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Estancia</div>
                            <div class="timeline-desc">
                                {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->diffInDays(\Carbon\Carbon::parse($reserva->fecha_salida)) }} noches
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="timeline-item">
                        <div class="timeline-icon active">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Reserva cancelada</div>
                            <div class="timeline-desc">
                                Si tienes dudas, contáctanos
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Acciones -->
                <div class="acciones">
                    <a href="#" class="btn btn-secundario">
                        <i class="fas fa-download"></i> Descargar comprobante
                    </a>
                    <a href="#" class="btn btn-primario">
                        <i class="fas fa-headset"></i> Contactar soporte
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="reserva-footer">
                <p>
                    <i class="fas fa-envelope"></i> reservas@tukos.com | 
                    <i class="fas fa-phone"></i> +52 123 456 7890 |
                    <i class="fab fa-whatsapp"></i> +52 123 456 7890
                </p>
                <p style="margin-top: 10px;">
                    <i class="fas fa-print"></i> Puedes imprimir esta página para tener tu reserva a la mano
                </p>
            </div>
        </div>
    </div>

    <script>
        // Función para imprimir
        function imprimirReserva() {
            window.print();
        }
        
        // Función para descargar comprobante (simulada)
        function descargarComprobante() {
            alert('Descargando comprobante de reserva...');
        }
        
        // Animación de entrada adicional
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.reserva-card');
            card.style.animation = 'fadeInUp 0.6s ease';
        });
    </script>
</body>
</html>