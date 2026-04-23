@extends('layouts.cliente-dashboard')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <input type="file" id="imageUpload" style="display: none;">
            <button onclick="compareWithDatabase()" hidden>Comparar con la Base de Datos</button>
            <div id="results" hidden></div>
            <canvas id="resultCanvas" hidden></canvas>
            <div id="contenido">
                <div class="col-md-6 col-lg-12">
                    <a href="#" class="card card-sponsor" rel="noopener" style="background-image: url(./dashboard/static/personal-data.svg); width: 100%; height: 100%;" aria-label="Sponsor Tabler!">
                        <div class="card-body" style="width: 80%">
                            <!-- Contenido de la tarjeta -->
                        </div>
                    </a>
                </div>
                
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="row" style="width: 100%">                
                <div class="container-xl">
                    <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-body">
                            <p style="color: black; text-align:center; font-weight: bold">REGISTROS REALIZADOS</p>
                            <hr style="background: black; ">
                            <div class="divide-y" id="registros">
                            
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-blur fade" id="modal-hora-extra" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="DetalleID" name="idRegistro" hidden>
                <div class="mb-3">
                    <label class="form-label">Detalle <span class="form-label-description">56/100</span></label>
                    <textarea class="form-control" name="example-textarea-input" id="DetalleTextArea" rows="6" placeholder="Escriba ..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="BtnRegistrarHoraExtra" data-bs-dismiss="modal">Save changes</button>
            </div>
            </div>
        </div>
    </div>


    <div class="modal modal-blur fade" id="modal-ingreso-salida" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">REGISTRAR POR PIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">                
                <div class="mb-3">
                    <label class="form-label">Selecciona Una Opcion</label>
                    <div class="form-selectgroup">
                        <label class="form-selectgroup-item">
                            <input type="radio" name="IngresoSalida" value="Ingreso" class="form-selectgroup-input" checked id="opcionIngreso">
                            <span class="form-selectgroup-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                                INGRESO
                            </span>
                        </label>
                        <label class="form-selectgroup-item">
                            <input type="radio" name="IngresoSalida" value="Salida" class="form-selectgroup-input" id="opcionSalida">
                            <span class="form-selectgroup-label">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                                SALIDA
                            </span>
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ingrese Su PIN</label>
                    <input type="password" class="form-control" name="example-text-input" placeholder="Ingrese PIN" id="PinCliente">
                    <small class="form-hint" id="estadoPin" style="display: none;"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="BtnRegistrarSalidaIngreso" data-bs-dismiss="modal" disabled>Registrar</button>
            </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <style>
        #previo{
            background: red;
            width: 100%
        }
        
        #registros {
            height: 500px;
            overflow-y: auto;
            padding: 10px;
        }

        video{
            margin-top: -920px;
            width: 58%;
            padding: 50px;
            padding-top: 100px;
            margin-left: 70px;
            position: relative;
            border-radius: 10px solid black;
        }

        img {
            vertical-align: middle;
            border-style: none;
            margin-top: -920px;
            width: 58%;
            padding: 50px;
            padding-top: 100px;
            margin-left: 70px;
        }

        canvas {
            position: absolute;
            top: 120px;
            left: 80px;
            margin-top: -980px;
            padding: 50px;
        }
        
        .sweetalert-popup-fullscreen {
            width: 100%;
            height: 80%;
            margin-left: 0;
            background-color: red;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background-color: #777;
        }

        #results {
            font-size: 18px;
            margin-top: 20px;
        }

        #resultCanvas {
            margin-top: 20px;
        }

    </style>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('Face/face-api.min.js')}}"></script>
    <script>
        $('#PinCliente').on('input', function() {
            const pinIngresado = $(this).val();
            $.ajax({
                type: 'GET',
                url: '/get-pin',
                success: function(response) {
                    const pinEsperadoArray = response;
                    const coincide = pinEsperadoArray.some(item => item.Pin === pinIngresado);
                    const estadoPin = $('#estadoPin');
                    if (coincide) {
                        estadoPin.text('PIN correcto').css('color', 'green');
                        $('#BtnRegistrarSalidaIngreso').prop('disabled', false);
                    } else {
                        estadoPin.text('PIN incorrecto').css('color', 'red');
                        $('#BtnRegistrarSalidaIngreso').prop('disabled', true);
                    }

                    // Muestra el span
                    estadoPin.show();
                },
                error: function(error) {
                    console.error('Error al obtener el PIN:', error);
                }
            });
        });
   
        $('#BtnRegistrarSalidaIngreso').click(function() {
            const opcionSeleccionada = $('input[name="IngresoSalida"]:checked').val();
            const pinIngresado = $('#PinCliente').val();
            const token = $('meta[name="csrf-token"]').attr('content');
            const horaActual = obtenerHoraActual();
            const fechaActual = obtenerFechaActual();

            $.ajax({
                type: 'POST',
                url: '/Registrar-Ingreso-Salida-Pin',
                data: {
                    opcion: opcionSeleccionada,
                    pin: pinIngresado,
                    hora_js: horaActual,
                    fecha_js: fechaActual
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    cargarRegistros();
                    mostrarNotificacionExito(response.Nombre_Completo, opcionSeleccionada)
                },
                error: function(error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });

    </script>
    <script>
        function CerrarVentana(){
            window.onload = function() {
                setTimeout(function() {
                    window.close();
                }, 60000);
            };
        }
        
        function obtenerHoraActual() {
            const ahora = new Date();
            return ("0" + ahora.getHours()).slice(-2) + ":" + 
                ("0" + ahora.getMinutes()).slice(-2) + ":" + 
                ("0" + ahora.getSeconds()).slice(-2);
        }
        
        function obtenerFechaActual() {
            const fecha = new Date();
        
            const anio = fecha.getFullYear();
            const mes = ("0" + (fecha.getMonth() + 1)).slice(-2); // Mes comienza en 0
            const dia = ("0" + fecha.getDate()).slice(-2);
        
            return `${anio}-${mes}-${dia}`;
        }


        function actualizarFechaHora() {
            var fechaHora = new Date();
            var opcionesFecha = { day: '2-digit', month: 'long', year: 'numeric' };
            var fechaFormateada = fechaHora.toLocaleDateString('es-ES', opcionesFecha);
            var horaFormateada = ("0" + fechaHora.getHours()).slice(-2) + ":" + ("0" + fechaHora.getMinutes()).slice(-2) + ":" + ("0" + fechaHora.getSeconds()).slice(-2);

            // Actualizar el contenido de los divs correspondientes
            document.getElementById("FechaDiv").innerHTML = fechaFormateada;
            document.getElementById("HoraDiv").innerHTML = horaFormateada;
        }
        setInterval(actualizarFechaHora, 1000);
        actualizarFechaHora();
        CerrarVentana();
    </script>

    <script>
        function cargarRegistros() {
            $.ajax({
                url: '/get-registros',
                type: 'GET',
                dataType: 'json',
                success: function(registros) {
                    $('#registros').empty();
    
                    $.each(registros, function(index, registro) {
                        var cardHtml = `
                            <div style="width: 100%">
                                <div class="row">
                                    <div class="col-auto">
                                        ${registro.hora_ingreso !== null ? `<span class="avatar" style="background: greenyellow;">
        <svg viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="layer1"> <path d="M 8.5 0 C 7.125211 0 6 1.125211 6 2.5 C 6 3.063362 6.1940148 3.580741 6.5117188 4 L 6.5 4 C 5.125211 4 4 5.12521 4 6.5 L 4 10.5 C 4 11.702941 4.8619079 12.715051 5.9980469 12.949219 L 6 12.949219 L 6 18.5 C 6 19.328427 6.671573 20 7.5 20 L 9.5 20 C 10.328427 20 11 19.328427 11 18.5 L 11 18 L 10 18 L 10 18.5 C 10 18.776142 9.776142 19 9.5 19 L 9 19 L 9 12.5 C 9 12.223858 8.776142 12 8.5 12 C 8.223857 12 8 12.223858 8 12.5 L 8 19 L 7.5 19 C 7.223858 19 7 18.776142 7 18.5 L 7 7.5 C 7 7.223858 6.776142 7 6.5 7 C 6.223858 7 6 7.223858 6 7.5 L 6 11.910156 C 5.416196 11.705514 5 11.157682 5 10.5 L 5 6.5 C 5 5.66565 5.66565 5 6.5 5 L 6.5117188 5 C 7.0640038 5 7.5117187 4.552285 7.5117188 4 C 7.5111565 3.782738 7.440395 3.5712219 7.28125 3.3574219 C 7.122104 3.1436229 7 2.841772 7 2.5 C 7 1.665651 7.66565 1 8.5 1 C 9.334346 1 10 1.665651 10 2.5 C 10 2.841772 9.877875 3.1436239 9.71875 3.3574219 C 9.559621 3.5712209 9.4888432 3.782738 9.4882812 4 C 9.4882812 4.552285 9.9359967 5 10.488281 5 L 10.488281 4.9980469 C 10.4924 4.9981438 10.4959 5 10.5 5 L 15.5 5 C 15.776142 5 16 5.223858 16 5.5 C 16 5.776143 15.776142 6 15.5 6 L 10.5 6 C 10.223857 6 10 6.223858 10 6.5 L 10 15 L 11 15 L 11 7 L 15.5 7 C 16.328427 7 17 6.328428 17 5.5 C 17 4.671573 16.328427 4 15.5 4 L 10.5 4 C 10.4959 4 10.492401 4.0018631 10.488281 4.0019531 L 10.488281 4 C 10.805981 3.580741 11 3.063362 11 2.5 C 11 1.125211 9.874789 0 8.5 0 z M 15 13 L 18 16 L 11 16 L 11 17 L 18 17 L 15 20 L 16.5 20 L 20 16.5 L 16.5 13 L 15 13 z " style="fill:#222222; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
    </span>` : ''}
    ${registro.hora_salida !== null ? `<span class="avatar" style="background: red;">
        <svg viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="layer1"> <path d="M 8.5 0 C 7.125211 0 6 1.125211 6 2.5 C 6 3.063362 6.1940148 3.580741 6.5117188 4 L 6.5 4 C 5.125211 4 4 5.12521 4 6.5 L 4 10.5 C 4 11.702941 4.8619079 12.715051 5.9980469 12.949219 L 6 12.949219 L 6 18.5 C 6 19.328427 6.671573 20 7.5 20 L 9.5 20 C 10.328427 20 11 19.328427 11 18.5 L 11 17.914062 L 10 16.914062 L 10 18.5 C 10 18.776142 9.776142 19 9.5 19 L 9 19 L 9 12.5 C 9 12.223858 8.776142 12 8.5 12 C 8.223857 12 8 12.223858 8 12.5 L 8 19 L 7.5 19 C 7.223858 19 7 18.776142 7 18.5 L 7 7.5 C 7 7.223858 6.776142 7 6.5 7 C 6.223858 7 6 7.223858 6 7.5 L 6 11.910156 C 5.416196 11.705514 5 11.157682 5 10.5 L 5 6.5 C 5 5.66565 5.66565 5 6.5 5 L 6.5117188 5 C 7.0640038 5 7.5117187 4.552285 7.5117188 4 C 7.5111565 3.782738 7.440395 3.5712219 7.28125 3.3574219 C 7.122104 3.1436229 7 2.841772 7 2.5 C 7 1.665651 7.66565 1 8.5 1 C 9.334346 1 10 1.665651 10 2.5 C 10 2.841772 9.877875 3.1436239 9.71875 3.3574219 C 9.559621 3.5712209 9.4888432 3.782738 9.4882812 4 C 9.4882812 4.552285 9.9359967 5 10.488281 5 L 10.488281 4.9980469 C 10.4924 4.9981438 10.4959 5 10.5 5 L 15.5 5 C 15.776142 5 16 5.223858 16 5.5 C 16 5.776143 15.776142 6 15.5 6 L 10.5 6 C 10.223857 6 10 6.223858 10 6.5 L 10 16.085938 L 11 15.085938 L 11 7 L 15.5 7 C 16.328427 7 17 6.328428 17 5.5 C 17 4.671573 16.328427 4 15.5 4 L 10.5 4 C 10.4959 4 10.492401 4.0018631 10.488281 4.0019531 L 10.488281 4 C 10.805981 3.580741 11 3.063362 11 2.5 C 11 1.125211 9.874789 0 8.5 0 z M 14.5 13 L 11 16.5 L 14.5 20 L 16 20 L 13 17 L 20 17 L 20 16 L 13 16 L 16 13 L 14.5 13 z " style="fill:#222222; fill-opacity:1; stroke:none; stroke-width:0px;"></path> </g> </g></svg>
    </span>` : ''}
                                    </div>
                                    <div class="col">
                                        <div class="text-truncate">
                                            <strong style="color: black">${registro.personal.Nombre_Completo}</strong>
                                        </div>
                                        <div class="text-muted" style="font-size: 19px">
                                            ${registro.hora_ingreso !== null ? `<p class="card-text"><small class="text-muted">Registro su <span style="color: green; font-weight: bold; text-decoration: underline;">${registro.estado}</span> a ${registro.hora_ingreso}</small></p>` : ''}
                                            ${registro.hora_salida !== null ? `<p class="card-text"><small class="text-muted">Registro su <span style="color: red; font-weight: bold; text-decoration: underline;">${registro.estado}</span> a ${registro.hora_salida}</small></p>` : ''}
                                        </div>
                                    </div>
                                    ${registro.estado === 'salida' && registro.HoraExtra !== 'true' ? `
                                        <div class="col-auto">
                                            <br>
                                            <a href="#" class="open-modal-hora-extra" data-bs-toggle="modal" data-bs-target="#modal-hora-extra" data-id="${registro.id}" data-estado="${registro.estado}" data-hora="${registro.hora_salida}" data-name="${registro.personal.Nombre_Completo}">
                                                <span class="status status-green">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                    ` : ''}
                                    ${registro.estado === 'salida' && registro.HoraExtra == 'true' ? `
                                        <div class="col-auto">
                                            <br>
                                            <span class="badge bg-orange">
                                                Hora Extra
                                            </span>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                        $('#registros').append(cardHtml);
                    });

                    var openModalLinks = document.querySelectorAll('.open-modal-hora-extra');
                    openModalLinks.forEach(function (link) {
                        link.addEventListener('click', function () {
                            var registroId = this.getAttribute('data-id');
                            var registroEstado = this.getAttribute('data-estado');
                            var registroHora = this.getAttribute('data-hora');
                            var registroNombre = this.getAttribute('data-name');
                            document.getElementById('DetalleID').value = registroId;
                            document.getElementById('modalTitle').innerText = `${registroNombre} - ${registroEstado} - ${registroHora}`;
                        });
                    });                    
                },
                error: function(error) {
                    console.error('Error al obtener registros:', error);
                }
            });
        }
        
        $('#BtnRegistrarHoraExtra').on('click', function () {
            var idRegistro = $('#DetalleID').val();
            var detalleTexto = $('#DetalleTextArea').val();
           
            const token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/Hora-Extra',
                type: 'POST',
                data: {
                    _token: token,
                    idRegistro: idRegistro,
                    detalleTexto: detalleTexto,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    cargarRegistros();
                    Swal.fire({
                        position: "bottom-end",
                        icon: "success",
                        title: "Detalle Hora Extra Agregado",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function (error) {
                    console.error('Error al enviar el formulario:', error);
                }
            });
        });

        
        $(document).ready(function() {
            cargarRegistros();
        }); 
    
        function agregarContenido(html) {
            var contenidoElemento = document.getElementById("contenido");
            contenidoElemento.innerHTML = html;
        }
    
        function mostrarNotificacionExito(label, valor) {
            const options = {
                title: `Usuario "${label}" Registrado`,
                text: `¡Su ${valor} Se Registro Exitosamente!`,
                icon: 'success',
                timer: 5000,
                showConfirmButton: false,
                toast: false,
                position: 'center',
                color: 'white',
                background: '#218838',
                customClass: {
                    popup: 'sweetalert-popup-fullscreen'
                }
            };
            Swal.fire(options);
        }  
        
        function mostrarNotificacionError() {
            const options = {
            title: 'ERROR',
            text: '¡NOCE DETECTO NINGUNA PERSONA VUELVE A INTENTARLO!',
            icon: 'error',
            timer: 5000,
            showConfirmButton: false,
            toast: false,
            position: 'center',
            color: 'white',
            background: '#ED2B2A',
            customClass: {
                popup: 'sweetalert-popup-fullscreen'
            }
            };
            Swal.fire(options);
        }
    
        function mostrarNotificacionTarde() {
            // Configuración de la notificación
            const options = {
            title: 'NO REGISTRADO',
            text: '¡NO PUEDES REGISTRAR EN LA MISMA HORA POR LO MENOS DEBES ESPERAR 1 HORA!',
            icon: 'warning',
            timer: 5000,
            showConfirmButton: false,
            toast: false,
            position: 'center',
            color: 'white',
            background: '#F49D1A',
            customClass: {
                popup: 'sweetalert-popup-fullscreen'
            }
            };
            Swal.fire(options);
        }  
    
        const imageUpload = document.getElementById('imageUpload');
        const TomarFotoIngreso = document.getElementById('TomarFotoIngreso');
        const TomarFotoSalida = document.getElementById('TomarFotoSalida');
        const resultsDiv = document.getElementById('results');
        const resultCanvas = document.getElementById('resultCanvas');
        const ctx = resultCanvas.getContext('2d');
        let image;
        Promise.all([
            faceapi.nets.faceRecognitionNet.loadFromUri('Face/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('Face/models'),
            faceapi.nets.ssdMobilenetv1.loadFromUri('Face/models')
        ]).then(start);
    
        async function start() {
            const container = document.createElement('div');
            container.style.position = 'relative';
            document.body.append(container);
    
            let canvas;
    
            TomarFotoIngreso.addEventListener('click', () => {
                TomarFotoIngreso.style.display = 'none';
                const valor = 'ingreso';
                if (image) image.remove();
                if (canvas) canvas.remove();
    
                abrirCamara()
                    .then((fotoDataURL) => {
                        image = new Image();
                        image.onload = () => {
                            container.append(image);
    
                            canvas = faceapi.createCanvasFromMedia(image);
                            container.append(canvas);
    
                            const displaySize = { width: image.width, height: image.height };
                            faceapi.matchDimensions(canvas, displaySize);
    
                            faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
                                .then((detections) => {
                                    const resizedDetections = faceapi.resizeResults(detections, displaySize);
                                    faceapi.draw.drawDetections(canvas, resizedDetections);
                                    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
    
                                    const faceDescriptors = resizedDetections.map(detection => detection.descriptor);
                                    image.descriptors = faceDescriptors;
    
                                    // Lógica para comparar con la base de datos
                                    compareWithDatabase(valor);
    
                                    TomarFotoIngreso.style.display = 'block';                                
    
                                    setTimeout(function() {
                                        image.remove();
                                        canvas.remove();
                                    }, 6000);
    
                                })
                                .catch((error) => {
                                    console.error('Error al procesar las detecciones:', error);
                                    mostrarNotificacionError();
                                });
                        };
    
                        image.src = fotoDataURL;
                    })
                    .catch((error) => {
                        console.error('Error al abrir la cámara:', error);
                        mostrarNotificacionError();
                    });
            });
    
            TomarFotoSalida.addEventListener('click', () => {
                TomarFotoSalida.style.display = 'none';
                const valor = 'salida';
                if (image) image.remove();
                if (canvas) canvas.remove();
    
                abrirCamara()
                    .then((fotoDataURL) => {
                        image = new Image();
                        image.onload = () => {  // Asegúrate de esperar a que la imagen se haya cargado completamente
                            container.append(image);
    
                            canvas = faceapi.createCanvasFromMedia(image);
                            container.append(canvas);
    
                            const displaySize = { width: image.width, height: image.height };
                            faceapi.matchDimensions(canvas, displaySize);
    
                            faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
                                .then((detections) => {
                                    const resizedDetections = faceapi.resizeResults(detections, displaySize);
                                    faceapi.draw.drawDetections(canvas, resizedDetections);
                                    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
    
                                    const faceDescriptors = resizedDetections.map(detection => detection.descriptor);
                                    image.descriptors = faceDescriptors;
    
                                    // Lógica para comparar con la base de datos
                                    compareWithDatabase(valor);
                                    
                                    TomarFotoSalida.style.display = 'block';
    
                                    setTimeout(function() {
                                        image.remove();
                                        canvas.remove();
                                    }, 6000);
                                })
                                .catch((error) => {
                                    console.error('Error al procesar las detecciones:', error);
                                });
                        };
    
                        image.src = fotoDataURL;
                    })
                    .catch((error) => {
                        console.error('Error al abrir la cámara:', error);
                    });
            });
    
        }
    
        function abrirCamara() {
            return new Promise((resolve, reject) => {
                const constraints = { video: true };
    
                navigator.mediaDevices.getUserMedia(constraints)
                    .then((stream) => {
                        const video = document.createElement('video');
                        document.body.appendChild(video);
                        video.srcObject = stream;
                        video.play();
    
                        let tiempoRestante = 3;  // Cambiar a 3 segundos
                        const contadorDiv = document.createElement('div');
                        contadorDiv.style.position = 'fixed';
                        contadorDiv.style.top = '10px';
                        contadorDiv.style.left = '10px';
                        contadorDiv.style.fontSize = '24px';
                        contadorDiv.style.color = 'blue';
                        document.body.appendChild(contadorDiv);
    
                        const contadorInterval = setInterval(() => {
                            contadorDiv.textContent = ``;
                            tiempoRestante--;
    
                            if (tiempoRestante <= 0) {
                                clearInterval(contadorInterval);
    
                                // Resto del código para tomar la foto
                                const canvas = document.createElement('canvas');
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;
                                const context = canvas.getContext('2d');
                                context.drawImage(video, 0, 0, canvas.width, canvas.height);
    
                                const fotoDataURL = canvas.toDataURL('image/png');
                                video.pause();
                                stream.getTracks().forEach(track => track.stop());
                                document.body.removeChild(video);
                                document.body.removeChild(contadorDiv);
                                resolve(fotoDataURL);
                            }
                        }, 1000);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        }
    
        async function compareWithDatabase(valor) {
            if (!image || !image.descriptors) {
                alert('Por favor, toma una foto primero.');
                return;
            }
    
            try {
                // Realizar una solicitud AJAX para obtener los descriptores almacenados
                const response = await fetch('/get-descriptors');
                const data = await response.json();
    
                // Extraer descriptores y nombres de la respuesta
                const storedDescriptors = data.map(user => ({
                    id: user.id,
                    descriptors: user.descriptores.map(val => parseFloat(val)),
                    username: user.Nombre_Completo,
                }));
    
                // Normalizar los descriptores de la imagen
                const normalizedImageDescriptors = image.descriptors.map(descriptor =>
                    new Float32Array(descriptor.map(val => parseFloat(val.toFixed(10))))
                );
    
                // Normalizar los descriptores almacenados
                const normalizedStoredFaceDescriptors = storedDescriptors.map(user =>
                    new faceapi.LabeledFaceDescriptors(user.username, [new Float32Array(user.descriptors)])
                );
    
                // Crear comparador de descriptores faciales
                const faceMatcher = new faceapi.FaceMatcher(normalizedStoredFaceDescriptors, 0.5);
    
                // Encontrar la mejor coincidencia
                const bestMatch = faceMatcher.findBestMatch(normalizedImageDescriptors[0]);
    
                // Obtener el ID del usuario a través de _label
                const userId = storedDescriptors.find(user => user.username === bestMatch._label)?.id;
    
                // Mensajes de consola para depurar
                console.log('bestMatch:', bestMatch);
                console.log('userId:', userId);
    
                // Actualizar resultados
                const resultColor = bestMatch.distance < 0.3 ? 'green' : 'red';
                const message = `Resultado para ${bestMatch.label}: ${bestMatch.toString()}`;
                resultsDiv.innerHTML = `<span style="color: ${resultColor}">${message}</span>`;
    
                // Dibujar resultados en el lienzo
                ctx.clearRect(0, 0, resultCanvas.width, resultCanvas.height);
                ctx.font = '24px Arial';
                ctx.fillStyle = resultColor;
                ctx.fillText(message, 10, 30);
    
                // Mostrar una alerta si la coincidencia es aceptable
                if (bestMatch.distance <= 0.5) { 
                    const token = $('meta[name="csrf-token"]').attr('content');
                    const horaActual = obtenerHoraActual();
                    const fechaActual = obtenerFechaActual();
                    
                    $.ajax({
                        url: '/Registrar-Ingreso-Salida',
                        type: 'POST',
                        data: {
                            _token: token,
                            userId: userId,
                            Estado: valor,
                            hora_js: horaActual,
                            fecha_js: fechaActual
                        },
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        success: function(response) {
                            console.log(response)
                            if ('success' in response) {
                                cargarRegistros();                            
                                mostrarNotificacionExito(bestMatch.label, valor);
                            } else if ('error' in response) {
                                cargarRegistros();
                                mostrarNotificacionError();
                            } else {
                                cargarRegistros();
                                mostrarNotificacionTarde();                                
                            }
                        },
                        error: function(error) {
                            console.error('Error en la solicitud AJAX:', error);
                        }
                    });
                }else{
                    mostrarNotificacionError();
                    setTimeout(function() {
                        image.remove();
                        canvas.remove();
                    }, 6000);
                }
            } catch (error) {
                mostrarNotificacionError();
            }
        }
        
        /*async function compareWithDatabase(valor) {
    if (!image || !image.descriptors) {
        alert('Por favor, toma una foto primero.');
        return;
    }

    try {
        // Obtener coordenadas del usuario
        navigator.geolocation.getCurrentPosition(async function (position) {
            const latitud = position.coords.latitude;
            const longitud = position.coords.longitude;

            // Realizar una solicitud AJAX para obtener los descriptores almacenados
            const response = await fetch('/get-descriptors');
            const data = await response.json();

            // Extraer descriptores y nombres de la respuesta
            const storedDescriptors = data.map(user => ({
                id: user.id,
                descriptors: user.descriptores.map(val => parseFloat(val)),
                username: user.Nombre_Completo,
            }));

            // Normalizar los descriptores de la imagen
            const normalizedImageDescriptors = image.descriptors.map(descriptor =>
                new Float32Array(descriptor.map(val => parseFloat(val.toFixed(10))))
            );

            // Normalizar los descriptores almacenados
            const normalizedStoredFaceDescriptors = storedDescriptors.map(user =>
                new faceapi.LabeledFaceDescriptors(user.username, [new Float32Array(user.descriptors)])
            );

            // Crear comparador de descriptores faciales
            const faceMatcher = new faceapi.FaceMatcher(normalizedStoredFaceDescriptors, 0.5);

            // Encontrar la mejor coincidencia
            const bestMatch = faceMatcher.findBestMatch(normalizedImageDescriptors[0]);

            // Obtener el ID del usuario a través de _label
            const userId = storedDescriptors.find(user => user.username === bestMatch._label)?.id;

            // Mensajes de consola para depurar
            console.log('bestMatch:', bestMatch);
            console.log('userId:', userId);

            // Actualizar resultados
            const resultColor = bestMatch.distance < 0.3 ? 'green' : 'red';
            const message = `Resultado para ${bestMatch.label}: ${bestMatch.toString()}`;
            resultsDiv.innerHTML = `<span style="color: ${resultColor}">${message}</span>`;

            // Dibujar resultados en el lienzo
            ctx.clearRect(0, 0, resultCanvas.width, resultCanvas.height);
            ctx.font = '24px Arial';
            ctx.fillStyle = resultColor;
            ctx.fillText(message, 10, 30);

            // Mostrar una alerta si la coincidencia es aceptable
            if (bestMatch.distance <= 0.5) {
                const token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '/Registrar-Ingreso-Salida',
                    type: 'POST',
                    data: {
                        _token: token,
                        userId: userId,
                        Estado: valor,
                        latitud: latitud,   // Agregar latitud
                        longitud: longitud  // Agregar longitud
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if ('success' in response) {
                            cargarRegistros();                            
                            mostrarNotificacionExito(bestMatch.label, valor);
                        } else if ('error' in response) {
                            cargarRegistros();
                            mostrarNotificacionError();
                        } else {
                            cargarRegistros();
                            mostrarNotificacionTarde();                                
                        }
                    },
                    error: function(error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            } else {
                mostrarNotificacionError();
                setTimeout(function() {
                    image.remove();
                    canvas.remove();
                }, 6000);
            }
        }, function (error) {
            console.error('Error al obtener la geolocalización:', error);
            mostrarNotificacionError();
        });
    } catch (error) {
        mostrarNotificacionError();
    }
}*/

    </script>
@endsection


@livewireStyles

@livewireScripts
