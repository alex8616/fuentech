@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header" style="width: 100%; background-color: #1d2736">
                <div class="row" style="width: 100%;">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title" style="color: white; font-weight: bold;">Ambientes</h3>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align: right;">
                        <a class="btn" id="addprint" style="padding-left: 25px;">
                            + Agregar
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <table class="table table-vcenter card-table" id="table-ambiente">
                        <thead>
                            <tr>
                            <th>Nombre Ambiente</th>
                            <th>DescripcionAmbiente</th>
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
    document.addEventListener("DOMContentLoaded", function() {
        MostrarTablaAmbiente();
    });

    function MostrarTablaAmbiente(){
        $.ajax({
            url: 'api/get-ambientes',
            type: 'GET',
            success: function(data) {  
                $('#table-ambiente tbody').empty();                
                $.each(data, function(index, ambiente) {
                    var row = '<tr>' +
                        '<td hidden>' + ambiente.id + '</td>' +
                        '<td>' + ambiente.NombreAmbiente + '</td>' +
                        '<td>' + ambiente.DescripcionAmbiente + '</td>' +
                        '<td>' + formatDate(ambiente.created_at) + '</td>' +
                        '</tr>';
                    
                    $('#table-ambiente tbody').append(row);
                });

                agregarEventosAmbienteTabla();

                $('#table-ambiente tbody').on('click', 'tr', function() {
                    var id = $(this).find('td:first').text();
                    $.ajax({
                        url: '/api/get-ambiente-seleccionado/' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            InformacionAmbiente(data);
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

    function agregarEventosAmbienteTabla() {
        $('#table-ambiente tbody tr').hover(function() {
            $(this).addClass('hovered');
        }, function() {
            $(this).removeClass('hovered');
        });
        $('#table-ambiente tbody tr').click(function() {
            $('#table-ambiente tbody tr').removeClass('tableproducseleccionado');
            $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
        });
    }

    function InformacionAmbiente(data){
        var TotalProduct = document.getElementById('form_tabs');

        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">AMBIENTE</h3>
                        <div class="card-actions"> <a href="#" class="btn" data-ambiente-id="${data[0].id}" id="EditarAmbiente">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>
                        <a href="#" class="btn" data-ambiente-id="${data[0].id}" id="DeleteAmbiente">
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
                                <label class="col-4 col-form-label" style="font-weight: bold">Nombre Ambiente</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].NombreAmbiente}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Descripcion</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${((data[0].DescripcionAmbiente))} </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $('#EditarAmbiente').on('click', function() {
            TotalProduct.innerHTML = ``;
            TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> EDITANDO ${data[0].NombreAmbiente}</h3>
                        <div class="card-actions">
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Nombre Ambiente</label>
                                    <div class="col">
                                        <input type="text" class="form-control convertmayusculas" id="UpdateNombreAmbiente" name="UpdateNombreAmbiente" value="${data[0].NombreAmbiente}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Descripcion</label>
                                    <div class="col">
                                        <input type="text" class="form-control convertmayusculas" id="UpdateDescripcionAmbiente" name="UpdateDescripcionAmbiente" value="${data[0].DescripcionAmbiente}">
                                    </div>
                                </div><br>
                                <button id="EditBtnGuardar" class="btn btn-primary ms-auto">Actualizar</button>
                                <button id="EditBtnCancelar" class="btn btn-danger ms-auto">Cancelar</button>
                            </div>
                        </div>                                                                                                
                    </div>
                </div>
            </div>`; 

            function convertirMayusculas() {
                const inputs = document.querySelectorAll('.convertmayusculas');
                inputs.forEach(function(input) {
                    input.addEventListener('input', function() {
                        input.value = input.value.toUpperCase();
                    });
                });
            }
            
            convertirMayusculas()

            $('#EditBtnGuardar').off('click').on('click', function(event) {
                var IdUpdate = data[0].id;
                var UpdateNombreAmbiente = $("#UpdateNombreAmbiente").val();
                var UpdateDescripcionAmbiente = $("#UpdateDescripcionAmbiente").val();

                var datosRecogidos = {
                    id: IdUpdate,
                    UpdateDescripcionAmbiente: UpdateDescripcionAmbiente,
                    UpdateNombreAmbiente: UpdateNombreAmbiente,
                };

                $.ajax({
                    url: '/api/actualizar-ambiente',
                    type: 'POST',
                    data: datosRecogidos,
                    success: function (impresora) {
                        CanvasTime();
                        MostrarTablaAmbiente()
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

        $('#DeleteAmbiente').on('click', function() {
            TotalProduct.innerHTML = ``;
            TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> ELIMINAR ${data[0].NombreAmbiente}</h3>
                        <div class="card-actions">
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-12 col-form-label" style="font-weight: bold">Si el ambiente no tiene mesas se podra eliminar caso contrario no</label>
                                </div><br>
                                <button id="EliminarBtnGuardar" class="btn btn-primary ms-auto">Eliminar</button>
                                <button id="EliminarBtnCancelar" class="btn btn-danger ms-auto">Cancelar</button>
                            </div>
                        </div>                                                                                                
                    </div>
                </div>
            </div>`; 

            $('#EliminarBtnGuardar').off('click').on('click', function(event) {
                var IdUpdateDelete = data[0].id;

                var datosRecogidos = {
                    id: IdUpdateDelete,
                };

                $.ajax({
                    url: '/api/eliminar-ambiente',
                    type: 'POST',
                    data: datosRecogidos,
                    success: function (respuesta) {
                        CanvasTime();
                        MostrarTablaAmbiente();
                        MostrarMensaje(respuesta, "success");
                    },
                    error: function (xhr) {
                        var mensajeError = xhr.responseJSON || "Ocurrió un error inesperado.";
                        MostrarMensaje(mensajeError, "error");
                    }
                });
            });

            $('#EliminarBtnCancelar').off('click').on('click', function(event) {
                CanvasTime();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addprint').addEventListener('click', function() {
            var formTabsDiv = document.getElementById('form_tabs');
            formTabsDiv.innerHTML = `
            <form id="form-register-product">
                <div class="card-header">
                    <h3 class="card-title">NUEVO AMBIENTE</h3>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Nombre Ambiente</label>
                            <div class="col">
                                <input type="text" class="form-control convertmayusculas" id="NombreAmbiente" name="NombreAmbiente">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Descripcion Ambiente</label>
                            <div class="col">
                                <input type="text" class="form-control convertmayusculas" id="DescripcionAmbiente" name="DescripcionAmbiente">
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="btn-registrar-ambientes">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;
            
            function convertirMayusculas() {
                const inputs = document.querySelectorAll('.convertmayusculas');
                inputs.forEach(function(input) {
                    input.addEventListener('input', function() {
                        input.value = input.value.toUpperCase();
                    });
                });
            }
            
            convertirMayusculas()
            
            $('#btn-registrar-ambientes').off('click').on('click', function(event) {
                var NombreAmbiente = $("#NombreAmbiente").val();
                var DescripcionAmbiente = $("#DescripcionAmbiente").val();
                
                var formData = new FormData();
                formData.append('NombreAmbiente', NombreAmbiente);
                formData.append('DescripcionAmbiente', DescripcionAmbiente);

                $.ajax({
                    url: '/api/registrar-ambiente',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (configuracion) {
                        CanvasTime()
                        MostrarTablaAmbiente()
                        MostrarMensaje("Se registro exitosamente ", "success");
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });
        });
    });

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
