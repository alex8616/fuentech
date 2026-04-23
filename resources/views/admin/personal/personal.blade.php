@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header" style="width: 100%; background-color: #1d2736">
                <div class="row" style="width: 100%;">
                    <div class="col-12 col-sm-6">
                        <h3 class="card-title" style="color: white; font-weight: bold;">
                            Usuarios Activos <span id="PersonalActivo" style="font-size: 20px">(0)</span>
                        </h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="card-title" style="color: white; font-weight: bold;">
                            Usuarios Inactivos <span id="PersonalInactivo" style="font-size: 20px">(0)</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-header" style="width: 100%; background-color: #1d2736">
                <div class="row" style="width: 100%;">
                    <div class="col-12 col-sm-4">
                        <h3 class="card-title" style="color: white; font-weight: bold;">Registros De Usuarios</h3>
                    </div>
                    <div class="col-12 col-sm-8" style="text-align: right;">
                        <a class="btn" style="padding-left: 25px;" data-bs-toggle="modal" data-bs-target="#modal-formulario-asistencia">
                            Formulario Asistencia
                        </a>
                        <a class="btn" style="padding-left: 25px;" data-bs-toggle="modal" data-bs-target="#modal-reporte-asistencia">
                            Reporte Asistencia
                        </a>
                        <a class="btn" id="addpersonal" style="padding-left: 25px;">
                            + Add personal
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <table class="table table-vcenter card-table" id="table-Personal">
                        <thead>                            
                            <tr>
                            <th>NOMBRE</th>
                            <th>DNI</th>
                            <th>CARGO</th>  
                            <th>FECHA</th>
                            <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card" id="form_tabs">
            <div class="card-header">
                <h3 class="card-title">. . .</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal modal-blur fade" id="modal-formulario-asistencia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="modal-body">
                <form action="{{ route('admin.personal.AsistenciaHoja') }}" method="get" target="_blank">
                    @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="col-12 col-form-label required">SELECCIONA EL MES</label>
                                    <div class="col">
                                        <input type="month" id="AsistenciaMes" name="AsistenciaMes" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <br>
                    <button type="submit" class="btn btn-success" tabindex="4" style="width: 100%;" >CONSULTAR </button> 
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-reporte-asistencia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="modal-body">
                <form action="{{ route('admin.personal.HorarioAsistencia') }}" method="get" target="_blank">
                    @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="col-12 col-form-label required">SELECCIONA EL MES</label>
                                    <div class="col">
                                        <input type="month" id="ReporteMes" name="ReporteMes" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="col-12 col-form-label required">SELECCIONA UNA PERSONA</label>
                                    <div class="col">
                                        <select id="personaSelect" name="persona_id" class="form-control" required>
                                            <option value="">Cargando personas...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <br>
                    <button type="submit" class="btn btn-success" tabindex="4" style="width: 100%;" >CONSULTAR </button> 
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<style>
    .tableproducseleccionado{
        background-color: #fd7;
    }
    .tableingredienteseleccionado{
        background-color: #fd7;
    }

    video {
        margin-top: -1020px;
        width: 58%;
        padding: 50px;
        padding-top: 170px;
        margin-left: 10px;
        position: absolute;
    }

    #contador {
        font-size: 2rem;
        font-weight: bold;
        color: #ff3e3e; /* Color rojo */
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
        background-color: rgba(255, 255, 255, 0.8); /* Fondo claro */
        padding: 10px 20px;
        border-radius: 8px;
        z-index: 2;  /* Asegura que el contador esté sobre la guía */
        position: absolute;
        top: 10px; /* Ajusta la posición */
        left: 90%;
        transform: translateX(-50%);
    }

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('Face/face-api.min.js')}}"></script>
<script>
    MostrarTablaPersonal()
    MostrarPersonas()
    actualizarContadorPersonas();

    function actualizarContadorPersonas() {
        $.ajax({
            url: 'api/get-personas-activas',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#PersonalActivo').text(`(${response.activos})`);
                $('#PersonalInactivo').text(`(${response.inactivos})`);
            },
            error: function (xhr, status, error) {
                console.error('Error al obtener datos de personas activas/inactivas:', error);
            }
        });
    }
    
    function MostrarPersonas() {
        $.ajax({
            url: 'api/get-personas', 
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#personaSelect');
                select.empty();
                select.append('<option value="todos">Todos</option>');
                $.each(data, function(index, persona) {
                    select.append('<option value="' + persona.id + '">' + persona.Nombre_Completo + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar las personas:', error);
            }
        });
    }

    function MostrarTablaPersonal(){
        $.ajax({
            url: '/get-personal',
            type: 'GET',
            success: function(data) {  
                $('#table-Personal tbody').empty();                
                $.each(data, function(index, personal) {
                    var estado = personal.estado == "true" ? '<span class="badge bg-lime text-lime-fg">Habilitado</span>' : '<span class="badge bg-red text-red-fg">Deshabilitado</span>';
                    var row = '<tr>' +
                        '<td hidden>' + personal.id + '</td>' +
                        '<td>' + personal.Nombre_Completo + '</td>' +
                        '<td>' + personal.Dni + '</td>' +
                        '<td>' + personal.Cargo + '</td>' +
                        '<td>' + formatDate(personal.created_at) + '</td>' +
                        '<td>' + estado + '</td>' +
                        '</tr>';
                    
                    $('#table-Personal tbody').append(row);
                });

                agregarEventospersonalTable();

                $('#table-Personal tbody').on('click', 'tr', function() {
                    var id = $(this).find('td:first').text();
                    $.ajax({
                        url: '/get-personal-seleccionado/' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            Informacionpersonal(data);
                        },
                        error: function(error) {
                            console.error('Error al recuperar datos de la impresora:', error);
                        }
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function formatDate(dateString) {
        var fechaOriginal = new Date(dateString);
        var dia = fechaOriginal.getDate();
        var mes = fechaOriginal.getMonth() + 1;
        var anio = fechaOriginal.getFullYear();
        return dia + '-' + mes + '-' + anio;
    }

    function agregarEventospersonalTable() {
        $('#table-Personal tbody tr').hover(function() {
            $(this).addClass('hovered');
        }, function() {
            $(this).removeClass('hovered');
        });
        $('#table-Personal tbody tr').click(function() {
            $('#table-Personal tbody tr').removeClass('tableproducseleccionado');
            $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
        });
    }

    function Informacionpersonal(data){
        var TotalProduct = document.getElementById('form_tabs');

        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">${data.id}</h3>
                        <div class="card-actions"> <a href="#" class="btn" data-print-id="${data.id}" id="Editarpersonal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>    
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${formatDate(data.created_at)}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.Nombre_Completo}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Documento DNI</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.Dni} </label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Cargo</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.Cargo} </label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Tiempo</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.Tiempo} </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $('#Editarpersonal').on('click', function() {
            TotalProduct.innerHTML = ``;
            TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> EDITANDO ${data.name}</h3>
                        <div class="card-actions">
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                 <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="UpdateNombre" name="UpdateNombre" value="${data.Nombre_Completo}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Documento DNI</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="UpdateDni" name="UpdateDni" value="${data.Dni}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Cargo</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="UpdateCargo" name="UpdateCargo" value="${data.Cargo}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Tiempo</label>
                                    <div class="col">
                                        <select id="UpdateTiempo" class="form-control">
                                            <option value="COMPLETO">COMPLETO</option>
                                            <option value="MEDIO">MEDIO</option>
                                        </select>
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                    <div class="col">
                                        <select id="UpdateEstado" class="form-control">
                                            <option value="true">Habilitado</option>
                                            <option value="false">Deshabilitado</option>
                                        </select>
                                    </div>
                                </div><br>
                                <button id="EditBtnGuardar" class="btn btn-primary ms-auto">Actualizar</button>
                                <button id="EditBtnCancelar" class="btn btn-danger ms-auto">Cancelar</button>
                            </div>
                        </div>                                                                                                
                    </div>
                </div>
            </div>`; 

            var tiempoactual = data.Tiempo;
            $('#UpdateTiempo').val(tiempoactual);  

            var estadoActual = data.estado;
            $('#UpdateEstado').val(estadoActual);  

            var IdUpdate = `${data.id}`;
            $('#EditBtnGuardar').off('click').on('click', function(event) {
                var UpdateCargo = $("#UpdateCargo").val();
                var UpdateDni = $("#UpdateDni").val();
                var UpdateNombre = $("#UpdateNombre").val();
                var UpdateEstado = $("#UpdateEstado").val();
                var UpdateTiempo = $("#UpdateTiempo").val();
                const token = $('meta[name="csrf-token"]').attr('content');

                var datosRecogidos = {
                    id: IdUpdate,
                    UpdateCargo: UpdateCargo,
                    UpdateDni: UpdateDni,
                    UpdateNombre: UpdateNombre,
                    UpdateEstado: UpdateEstado,
                    UpdateTiempo: UpdateTiempo
                };

                $.ajax({
                    url: '/actualizar-personal',
                    type: 'POST',
                    data: datosRecogidos,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (impresora) {
                        CanvasTime();
                        MostrarTablaPersonal()
                        MostrarMensaje("Se Actualizo El Producto Exitosamente", "success");
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });
            $('#EditBtnCancelar').off('click').on('click', function(event) {
                CanvasTime();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addpersonal').addEventListener('click', function() {
            var formTabsDiv = document.getElementById('form_tabs');
            formTabsDiv.innerHTML = `
            <form id="form-register-product">
                <div class="card-header">
                    <h3 class="card-title">NUEVO USUARIO</h3>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Nombre Completo</label>
                            <div class="col">
                                <input type="text" class="form-control" id="NombreCliente" name="NombreCliente">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Documento</label>
                            <div class="col">
                                <input type="text" class="form-control" id="Dni" name="Dni">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">CARGO</label>
                            <div class="col">
                                <input type="text" class="form-control" id="Cargo" name="Cargo">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Pin</label>
                            <div class="col">
                                <input type="text" class="form-control" id="PinCliente" name="PinCliente">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Trabajo</label>
                            <div class="col">
                                <select name="Tiempo" id="Tiempo" class="form-control">
                                    <option value="MEDIO">MEDIO TIEMPO</option>
                                    <option value="COMPLETO">TIEMPO COMPLETO</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <p><span>Click Para <a href="#" id="agregarImagen"> Agregar Photo</a></span></p>
                            <div class="col">
                                <input type="text" class="form-control" name="example-text-input" id="ImagenCliente" hidden>
                                <img id="vistaPrevia" alt="Vista Previa de la Imagen" style="display:none;" class="img-fluid"><br>                                   
                            </div>
                        </div>
                         <div class="mb-3">
                            <div id="preview"></div>
                        </div>
                    </div>                    
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="registrarBtn">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;

            function limpiarImagenes() {
                const imagenesPrevias = document.querySelectorAll('.imagenPrevia');
                imagenesPrevias.forEach((imagen) => {
                    document.body.removeChild(imagen);
                });

                const vistaPreviaImg = document.getElementById('vistaPrevia');
                vistaPreviaImg.style.display = 'none';

                const imagenClienteInput = document.getElementById('ImagenCliente');
                imagenClienteInput.value = '';
            }

            const agregarImagen = document.getElementById('agregarImagen');
            const vistaPreviaImg = document.getElementById('vistaPrevia');

            agregarImagen.addEventListener('click', (e) => {
                e.preventDefault();
                limpiarImagenes();

                abrirCamara()
                    .then((fotoDataURL) => {
                        vistaPreviaImg.src = fotoDataURL;
                        vistaPreviaImg.style.display = 'block';
                        const imagenClienteInput = document.getElementById('ImagenCliente');
                        imagenClienteInput.value = fotoDataURL;
                    })
                    .catch((error) => {
                        console.error('Error al abrir la cámara:', error);
                        alert('Error al acceder a la cámara. Por favor, verifica los permisos.');
                    });
            });

            function abrirCamara() {
                return new Promise((resolve, reject) => {
                    const constraints = { video: true };

                    navigator.mediaDevices.getUserMedia(constraints)
                        .then((stream) => {
                            const guia = document.createElement('div');
                            guia.id = 'guia';
                            guia.style.position = 'absolute';
                            guia.style.width = '300px';
                            guia.style.height = '400px';
                            guia.style.borderRadius = '10px';
                            guia.style.boxSizing = 'border-box';
                            guia.style.pointerEvents = 'none';
                            guia.style.top = '50%';
                            guia.style.left = '50%';
                            guia.style.transform = 'translate(-50%, -50%)';

                            const contador = document.createElement('div');
                            contador.id = 'contador';
                            guia.appendChild(contador);

                            document.body.appendChild(guia);

                            const video = document.createElement('video');
                            document.body.appendChild(video);
                            video.srcObject = stream;
                            video.play();

                            let tiempoRestante = 6;
                            const contadorInterval = setInterval(() => {
                                contador.textContent = tiempoRestante + 's';
                                tiempoRestante--;

                                if (tiempoRestante < 0) {
                                    clearInterval(contadorInterval);

                                    const canvas = document.createElement('canvas');
                                    canvas.width = video.videoWidth;
                                    canvas.height = video.videoHeight;
                                    const context = canvas.getContext('2d');
                                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                                    const fotoDataURL = canvas.toDataURL('image/png');
                                    video.pause();
                                    stream.getTracks().forEach(track => track.stop());
                                    document.body.removeChild(video);
                                    document.body.removeChild(guia);
                                    resolve(fotoDataURL);
                                }
                            }, 1000);
                        })
                        .catch((error) => {
                            reject(error);
                        });
                });
            }

            
            $('#registrarBtn').click(function(e) {
                e.preventDefault();
            
                // Ocultar el botón
                $('#registrarBtn').prop('disabled', true).text('Registrando...');
            
                const nombreCliente = $('#NombreCliente').val();
                const dniCliente = $('#Dni').val();
                const pinCliente = $('#PinCliente').val();
                const imagenCliente = $('#ImagenCliente').val();
                const cargoCliente = $('#Cargo').val();
                const tiempoCliente = $('#Tiempo').val();
                const token = $('meta[name="csrf-token"]').attr('content');
            
                extraerDescriptoresFacial(imagenCliente)
                    .then((descriptores) => {
                        console.log('Descriptores faciales extraídos:', descriptores);
                        $.ajax({
                            url: '/Registrar-personal',
                            type: 'POST',
                            data: {
                                _token: token,
                                nombre: nombreCliente,
                                pin: pinCliente,
                                imagen: imagenCliente,
                                descriptores: descriptores,
                                dni: dniCliente,
                                cargo: cargoCliente,
                                tiempo: tiempoCliente,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $('#registrarBtn').prop('disabled', false).text('Registrar');
                                $('#add-form').trigger('reset');
                                limpiarImagenes();
                                preview.innerHTML = "";
                                MostrarMensaje("Se ha registrado con éxito.", "Success")
                                MostrarTablaPersonal()
                                CanvasTime()
                            },
                            error: function(error) {
                                // Mostrar el botón de nuevo en caso de error
                                $('#registrarBtn').prop('disabled', false).text('Registrar');
            
                                toastr.error("Error en la solicitud AJAX.", "Mensaje de error", {
                                    "iconClass": 'toast-error'
                                });
                            }
                        });
                    })
                    .catch((error) => {
                        // Mostrar el botón de nuevo si hay un error al extraer descriptores faciales
                        $('#registrarBtn').prop('disabled', false).text('Registrar');
            
                        toastr.error("Error al extraer descriptores faciales.", "Mensaje de error", {
                            "iconClass": 'toast-error'
                        });
                    });
            });

            
            function extraerDescriptoresFacial(imagenBase64) {
                return new Promise(async (resolve, reject) => {
                    try {
                        // Convierte la imagen base64 en un objeto Image
                        const image = new Image();
                        image.src = imagenBase64;

                        image.onload = async () => {
                            console.log('Imagen cargada correctamente');

                            // Carga el modelo face-api.js
                            await faceapi.nets.faceRecognitionNet.loadFromUri('Face/models');
                            await faceapi.nets.faceLandmark68Net.loadFromUri('Face/models');
                            await faceapi.nets.ssdMobilenetv1.loadFromUri('Face/models');

                            console.log('Modelos cargados correctamente');

                            // Detecta rostros y landmarks en la imagen
                            const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors();

                            console.log('Rostros detectados:', detections);

                            // Extrae los descriptores faciales
                            const descriptors = detections.map((detection) => detection.descriptor);

                            console.log('Descriptores faciales extraídos:', descriptors);

                            resolve(descriptors);
                        };
                    } catch (error) {
                        reject(error);
                    }
                });
            }

            });
    });

    function CanvasTime(){
        var TotalProduct = document.getElementById('form_tabs');
        TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <h3 class="card-title" style="color: #424769">Sin Seleccionar Nada, En Espera ...</h3>
                    </div>
                    <div class="img-responsive img-responsive-21x21 card-img-bottom" style="background-image: url('/utilidades/svg/espera.svg')"></div>
                </div>
            </div>
        `;        
    }
</script>

@livewireStyles

@livewireScripts
