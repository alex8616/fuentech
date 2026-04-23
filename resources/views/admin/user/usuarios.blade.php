@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header" style="width: 100%; background-color: #1d2736">
                <div class="row" style="width: 100%;">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title" style="color: white; font-weight: bold;">Registros De Usuarios</h3>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align: right;">
                        <a class="btn" id="adduser" style="padding-left: 25px;">
                            + Add User
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <table class="table table-vcenter card-table" id="table-user">
                        <thead>
                            <tr>
                            <th>Nombre Usuario</th>
                            <th>Correo</th>
                            <th>Direccion IP</th>
                            <th>Fecha</th>
                            <th>Estado</th>
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
    MostrarTablaUsuarios()

    function MostrarTablaUsuarios(){
        $.ajax({
            url: '/api/get-usuario',
            type: 'GET',
            success: function(data) {  
                $('#table-user tbody').empty();                
                $.each(data, function(index, user) {
                    var estado = user.estado == "true" ? '<span class="badge bg-lime text-lime-fg">Habilitado</span>' : '<span class="badge bg-red text-red-fg">Deshabilitado</span>';
                    var row = '<tr>' +
                        '<td hidden>' + user.id + '</td>' +
                        '<td>' + user.name + '</td>' +
                        '<td>' + user.email + '</td>' +
                        '<td>' + user.DirecionIpPrincipal + '</td>' +
                        '<td>' + formatDate(user.created_at) + '</td>' +
                        '<td>' + estado + '</td>' +
                        '</tr>';
                    
                    $('#table-user tbody').append(row);
                });

                agregarEventosUserTable();

                $('#table-user tbody').on('click', 'tr', function() {
                    var id = $(this).find('td:first').text();
                    $.ajax({
                        url: '/api/get-user-seleccionado/' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            InformacionUser(data);
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

    function agregarEventosUserTable() {
        $('#table-user tbody tr').hover(function() {
            $(this).addClass('hovered');
        }, function() {
            $(this).removeClass('hovered');
        });
        $('#table-user tbody tr').click(function() {
            $('#table-user tbody tr').removeClass('tableproducseleccionado');
            $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
        });
    }


    function InformacionUser(data){
        var TotalProduct = document.getElementById('form_tabs');

        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">VENTA ${data.id}</h3>
                        <div class="card-actions"> <a href="#" class="btn" data-print-id="${data.id}" id="EditarUser">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>
                        <a href="#" class="btn" data-movimientocaja-id="${data.id}" id="DeleteMovimientoCaja" data-bs-toggle="modal" data-bs-target="#modal-danger">
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
                                    <label class="col-8 col-form-label" style="color: #61677A">${formatDate(data.created_at)}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.name}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Direccion IP</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${((data.DirecionIpPrincipal))} </label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Email</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.email} </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $('#EditarUser').on('click', function() {
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
                                        <input type="text" class="form-control" id="UpdateNombre" name="UpdateNombre" value="${data.name}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="UpdateDireccionIp" name="UpdateDireccionIp" value="${data.DirecionIpPrincipal}">
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

            var estadoActual = data.estado;
            $('#UpdateEstado').val(estadoActual);  

            var IdUpdate = `${data.id}`;
            $('#EditBtnGuardar').off('click').on('click', function(event) {
                var EditDireccionIp = $("#UpdateDireccionIp").val();
                var EditEstado = $("#UpdateEstado").val();
                var EditNombre = $("#UpdateNombre").val();

                var datosRecogidos = {
                    id: IdUpdate,
                    direccion: EditDireccionIp,
                    estado: EditEstado,
                    nombre: EditNombre,
                };

                $.ajax({
                    url: '/api/actualizar-usuario',
                    type: 'POST',
                    data: datosRecogidos,
                    success: function (impresora) {
                        CanvasTime();
                        MostrarTablaUsuarios()
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
        document.getElementById('adduser').addEventListener('click', function() {
            var formTabsDiv = document.getElementById('form_tabs');
            formTabsDiv.innerHTML = `
            <form id="form-register-product">
                <div class="card-header">
                    <h3 class="card-title">NUEVO USUARIO</h3>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Pin</label>
                            <div class="col d-flex gap-2">
                                <input type="text" class="form-control text-center" id="PinUser1" maxlength="1">
                                <input type="text" class="form-control text-center" id="PinUser2" maxlength="1">
                                <input type="text" class="form-control text-center" id="PinUser3" maxlength="1">
                                <input type="text" class="form-control text-center" id="PinUser4" maxlength="1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Nombre Completo Usuario</label>
                            <div class="col">
                                <input type="text" class="form-control" id="NameUser" name="NameUser">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Direccion IP Principal</label>
                            <div class="col">
                                <input type="text" class="form-control" id="DireccionIp" name="DireccionIp">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Correo Electronico</label>
                            <div class="col">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="CorreoUser">
                                    <span class="input-group-text">
                                        @tukos.com
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-12 col-form-label required">Contrasenia</label>
                            <div class="col">
                                <input type="text" class="form-control" id="ContraseniaUser" name="ContraseniaUser">
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="btn-registrar-usuario">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;

            $('#btn-registrar-usuario').off('click').on('click', function(event) {
                var PinUser1 = $("#PinUser1").val();
                var PinUser2 = $("#PinUser2").val();
                var PinUser3 = $("#PinUser3").val();
                var PinUser4 = $("#PinUser4").val();
                var NameUser = $("#NameUser").val();
                var DireccionIp = $("#DireccionIp").val();
                var CorreoUser = $("#CorreoUser").val();
                var ContraseniaUser = $("#ContraseniaUser").val();
                
                var formData = new FormData();
                formData.append('PinUser1', PinUser1);
                formData.append('PinUser2', PinUser2);
                formData.append('PinUser3', PinUser3);
                formData.append('PinUser4', PinUser4);
                formData.append('NameUser', NameUser);
                formData.append('DireccionIp', DireccionIp);
                formData.append('CorreoUser', CorreoUser);
                formData.append('ContraseniaUser', ContraseniaUser);

                $.ajax({
                    url: '/api/registrar-usuario',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (usuario) {
                        CanvasTime()
                        MostrarTablaUsuarios()
                        MostrarMensaje("Se registro exitosamente ", "success");
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });
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
