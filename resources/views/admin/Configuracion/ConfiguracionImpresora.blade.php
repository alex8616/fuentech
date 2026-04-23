@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header" style="width: 100%; background-color: #1d2736">
                <div class="row" style="width: 100%;">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title" style="color: white; font-weight: bold;">Registros De Impresora</h3>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align: right;">
                        <a class="btn" id="addprint" style="padding-left: 25px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <table class="table table-vcenter card-table" id="table-print">
                        <thead>
                            <tr>
                            <th>Nombre Impresora</th>
                            <th>Direccion IP</th>
                            <th>Estado</th>
                            <th>Fecha</th>
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
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script>
    MostrarTablaPrint()

    function MostrarTablaPrint(){
        $.ajax({
            url: 'api/get-list-print',
            type: 'GET',
            success: function(data) {  
                $('#table-print tbody').empty();                
                $.each(data, function(index, impresora) {
                    var estado = impresora.Activo === "true" ? '<span class="badge bg-lime text-lime-fg" id="btnCambiarEstado">Habilitado</span>' : '<span class="badge bg-red text-red-fg" id="btnCambiarEstado">Deshabilitado</span>';
                    var row = '<tr>' +
                        '<td hidden>' + impresora.id + '</td>' +
                        '<td>' + impresora.NombreImpresora + '</td>' +
                        '<td>' + impresora.DireccionIpLocal + '</td>' +
                        '<td>' + estado + '</td>' +
                        '<td>' + formatDate(impresora.created_at) + '</td>' +
                        '</tr>';
                    
                    $('#table-print tbody').append(row);
                });

                agregarEventosPrintTabla();

                $('#table-print tbody').on('click', 'tr', function() {
                    var id = $(this).find('td:first').text();
                    $.ajax({
                        url: '/api/get-print-seleccionado/' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            InformacionPrint(data);
                            //DeleteMovimiento()
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

    function agregarEventosPrintTabla() {
        $('#table-print tbody tr').hover(function() {
            $(this).addClass('hovered');
        }, function() {
            $(this).removeClass('hovered');
        });
        $('#table-print tbody tr').click(function() {
            $('#table-print tbody tr').removeClass('tableproducseleccionado');
            $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
        });
    }


    function InformacionPrint(data){
        var TotalProduct = document.getElementById('form_tabs');
        var estado = data[0].Activo === "true" ? '<span class="badge bg-lime text-lime-fg" id="btnCambiarEstado">Habilitado</span>' : '<span class="badge bg-red text-red-fg" id="btnCambiarEstado">Deshabilitado</span>';

        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">VENTA ${data[0].id}</h3>
                        <div class="card-actions"> <a href="#" class="btn" data-print-id="${data[0].id}" id="EditarImpresora">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>
                        <a href="#" class="btn" data-movimientocaja-id="${data[0].id}" id="DeleteMovimientoCaja" data-bs-toggle="modal" data-bs-target="#modal-danger">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </a>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${formatDate(data[0].created_at)}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Nombre Impresora</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].NombreImpresora}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Direccion IP</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${((data[0].DireccionIpLocal))} </label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${estado} </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $('#EditarImpresora').on('click', function() {
            TotalProduct.innerHTML = ``;
            TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> EDITANDO ${data[0].NombreImpresora}</h3>
                        <div class="card-actions">
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="UpdateDireccionIp" name="UpdateDireccionIp" value="${data[0].DireccionIpLocal}">
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

            var estadoActual = data[0].Activo;
            $('#UpdateEstado').val(estadoActual);  

            var IdUpdate = `${data[0].id}`;
            $('#EditBtnGuardar').off('click').on('click', function(event) {
                var EditDireccionIp = $("#UpdateDireccionIp").val();
                var EditEstado = $("#UpdateEstado").val();

                var datosRecogidos = {
                    id: IdUpdate,
                    direccion: EditDireccionIp,
                    estado: EditEstado,
                };

                $.ajax({
                    url: '/api/actualizar-impresora',
                    type: 'POST',
                    data: datosRecogidos,
                    success: function (impresora) {
                        CanvasTime();
                        MostrarTablaPrint()
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
        document.getElementById('addprint').addEventListener('click', function() {
            LoginUser()
            var formTabsDiv = document.getElementById('form_tabs');
            formTabsDiv.innerHTML = `
            <form id="form-register-product">
                <div class="card-header">
                    <h3 class="card-title">NUEVA IMPRESORA</h3>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Impresora</label>
                            <div class="col" >
                                <div class="form-selectgroup" id="ListPrint">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Direccion IP / Enlace</label>
                            <div class="col">
                                <input type="text" class="form-control" id="DireccionIp" name="DireccionIp" placeholder="Ej. 192.168.0.1">
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="btn-registrar-print">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;
            
            $('#btn-registrar-print').off('click').on('click', function(event) {
                var NombreImpresora = $("input[name='printer']:checked").val();
                var DireccionIp = $("#DireccionIp").val();
                
                var formData = new FormData();
                formData.append('Print', NombreImpresora);
                formData.append('DireccionIp', DireccionIp);

                $.ajax({
                    url: '/api/registrar-impresora',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (configuracion) {
                        console.log("Impresora Agregado Exitosamente", configuracion);
                        $("#DireccionIp").val("");
                        MostrarTablaPrint()
                        MostrarMensaje("Se registro exitosamente ", "success");
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });
        });
    });

    function LoginUser(){
        const url = 'api/user';
        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            credentials: 'same-origin' 
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                SolicituIP(data.user)
            } else {
                console.log('No hay usuario logueado.');
            }
        })
        .catch(error => {
            console.error('Error al obtener el usuario logueado:', error);
        });
    }

    function SolicituIP(DireccionIp) {
        const URL = 'https://' + DireccionIp + '/device-list-print';
        $.ajax({
            url: URL,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log('Respuesta del servidor:', data);
                if (data.printers && data.printers.length > 0) {
                    CargarImpresora(data.printers);
                } else {
                    console.log('No hay impresoras.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener las impresoras:', error);
            }
        });
    }

    function CargarImpresora(printers) {
        var listPrintDiv = $('#ListPrint');
        listPrintDiv.empty(); // Limpia el contenido anterior

        printers.forEach(function(printer, index) {
            var printerLabel = `
                <label class="form-selectgroup-item">
                    <input type="radio" name="printer" value="` + printer + `" class="form-selectgroup-input">
                    <span class="form-selectgroup-label">
                        <svg width="256px" height="256px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M192 234.666667h640v64H192z" fill="#424242"></path>
                                <path d="M85.333333 533.333333h853.333334v-149.333333c0-46.933333-38.4-85.333333-85.333334-85.333333H170.666667c-46.933333 0-85.333333 38.4-85.333334 85.333333v149.333333z" fill="#616161"></path>
                                <path d="M170.666667 768h682.666666c46.933333 0 85.333333-38.4 85.333334-85.333333v-170.666667H85.333333v170.666667c0 46.933333 38.4 85.333333 85.333334 85.333333z" fill="#424242"></path>
                                <path d="M853.333333 384m-21.333333 0a21.333333 21.333333 0 1 0 42.666667 0 21.333333 21.333333 0 1 0-42.666667 0Z" fill="#00E676"></path>
                                <path d="M234.666667 85.333333h554.666666v213.333334H234.666667z" fill="#90CAF9"></path>
                                <path d="M800 661.333333h-576c-17.066667 0-32-14.933333-32-32s14.933333-32 32-32h576c17.066667 0 32 14.933333 32 32s-14.933333 32-32 32z" fill="#242424"></path>
                                <path d="M234.666667 661.333333h554.666666v234.666667H234.666667z" fill="#90CAF9"></path>
                                <path d="M234.666667 618.666667h554.666666v42.666666H234.666667z" fill="#42A5F5"></path>
                                <path d="M341.333333 704h362.666667v42.666667H341.333333zM341.333333 789.333333h277.333334v42.666667H341.333333z" fill="#1976D2"></path>
                            </g>
                        </svg>
                        ` + printer + `
                    </span>
                </label>
            `;
            listPrintDiv.append(printerLabel);
        });
    }

    function formatDate(dateString) {
        var fechaOriginal = new Date(dateString);
        var dia = fechaOriginal.getDate();
        var mes = fechaOriginal.getMonth() + 1; // Los meses en JavaScript son base cero (0-11)
        var anio = fechaOriginal.getFullYear();
        return dia + '-' + mes + '-' + anio;
    }

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
