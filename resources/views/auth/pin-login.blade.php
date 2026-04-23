<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Incio De Session PIN</title>
    @php
        $backgroundImage = rand(0, 1) ? 'collage.png' : 'collage2.png';
    @endphp

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.8);
            background-image: url("{{ asset('imagenes/hostal/'. $backgroundImage) }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 5;
        }
        .login-container {
            position: absolute;
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            padding: 20px;
            padding-left: 60px;
            padding-right: 60px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .login-box {
            text-align: center;
        }
        .pin-inputs {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .pin {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 24px;
            margin: 0 5px;
            border: 2px solid #ccc;
            border-radius: 4px;
        }
        .pin:focus {
            outline: none;
            border-color: #007BFF;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-auto-rows: 200px;
            width: 100vw;
            height: 100vh;
            gap: 5px;
            position: relative;
        }
        .grid-item {
            position: relative;
            overflow: hidden;
            border: 2px solid white;
        }
        .grid-item img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .grid-item-small {
            grid-row: span 1;
        }
        .grid-item-medium {
            grid-row: span 2;
        }
        .grid-item-large {
            grid-row: span 3;
        }
        .mirror {
            transform: scaleY(-1);
            position: absolute;
            top: 100%;
            width: 100%;
        }
        #clock {
            position: fixed;
            bottom: 10px;
            left: 10px;
            color: white;
            font-size: 27px;
            font-family: Arial, sans-serif;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 15px 40px;
            border-radius: 5px;
            text-align: left;
            z-index: 10;
        }
        #clock time {
            font-size: 90px;
            font-weight: bold;
            display: block;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="grid" id="imageGrid"></div>
    <div class="login-container">
        <div class="login-box">
            <h2>INGRESAR PIN</h2>
            <div class="pin-inputs">
                <input type="password" maxlength="1" class="pin" id="pin1" autofocus>
                <input type="password" maxlength="1" class="pin" id="pin2">
                <input type="password" maxlength="1" class="pin" id="pin3">
                <input type="password" maxlength="1" class="pin" id="pin4">
            </div>
            <div id="error-message" style="color:red;"></div>
        </div>
    </div>

    <!-- Contenedor para la hora -->
    <div id="clock">
        <time id="time"></time>
        <span id="date"></span><br>
    </div>

    <script>
        // Función para obtener el nombre del día de la semana en español
        function getDayName(dayNumber) {
            const days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            return days[dayNumber];
        }

        // Función para obtener el nombre del mes en español
        function getMonthName(monthNumber) {
            const months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            return months[monthNumber];
        }

        // Actualizar la hora y fecha en tiempo real
        function updateClock() {
            const now = new Date();

            // Formatear la hora
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const timeString = `${hours} : ${minutes}`;
            document.getElementById('time').textContent = timeString;

            // Formatear la fecha
            const dayName = getDayName(now.getDay());
            const day = now.getDate();
            const monthName = getMonthName(now.getMonth());
            const fullDate = `${dayName}, ${day} de ${monthName}`;
            document.getElementById('date').textContent = fullDate;
        }

        setInterval(updateClock, 1000); // Actualiza cada segundo
        updateClock(); // Llama a la función para mostrar la hora inmediatamente

        const pinInputs = document.querySelectorAll('.pin');
        const errorMessage = document.getElementById('error-message');
        pinInputs[0].focus();
        pinInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < pinInputs.length - 1) {
                    pinInputs[index + 1].focus();
                }
                if (Array.from(pinInputs).every(input => input.value.length === 1)) {
                    const enteredPin = Array.from(pinInputs).map(input => input.value).join('');
                    fetch('/pin-login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                        },
                        body: JSON.stringify({ pin: enteredPin })
                    })
                    .then(response => {
                        if (response.status === 422) {
                            return response.json();
                        } else {
                            window.location.href = '/Restaurante';
                        }
                    })
                    .then(data => {
                        if (data) {
                            errorMessage.textContent = data.message;
                            pinInputs.forEach(input => input.value = '');
                            pinInputs[0].focus();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        errorMessage.textContent = 'Hubo un error en el servidor. Intenta de nuevo.';
                    });
                }
            });
        });

    </script>
</body>
</html>
