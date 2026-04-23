@extends('layouts.my-dashboard-layout')

@section('content')
<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-kardex" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">MOVIMIENTOS KARDEX</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-controlstock" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">KARDEX</a>
                </li>
            </ul>
            </div>
            <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active show" id="tabs-kardex" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-10">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">MOVIMIENTOS KARDEX</h3>
                                </div>
                                <div class="col-12 col-sm-2">
                                    <a class="card-title" style="color: white; font-weight: bold;" id="btn-exportar-pdf-movimientos">Exportar PDF</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="row">
                                        <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                                            <div class="row" style="background: #F5F7F8;">
                                                <div class="col-md-12">
                                                    <div class="row" style="padding-bottom: 10px">
                                                        <div class="col-md-2">
                                                            <select name="DateKardex" id="DateKardex" class="form-control">
                                                                <option value="DiarioKardex">Diario</option>
                                                                <option value="MensualKardex">Mensual</option>
                                                                <option value="AnualKardex">Anual</option>
                                                                <option value="RangoKardex">Rango</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1" id="DiaKardexContainer">
                                                            <select name="DiaKardex" id="DiaKardex" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="MesKardexContainer">
                                                            <select name="MesKardex" id="MesKardex" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="AnioKardexContainer">
                                                            <select name="AnioKardex" id="AnioKardex" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="FechaInicioContainerKardex">
                                                            <input type="date" name="fechaInicioKardex" id="fechaInicioKardex" class="form-control">
                                                        </div>
                                                        <div class="col-md-2" id="FechaFinContainerKardex">
                                                            <input type="date" name="fechaFinKardex" id="fechaFinKardex" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select name="ProductoKardexSelect" id="ProductoKardexSelect" class="form-control">
                                                                <option value="TodoProducto">Productos</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <select name="TipoKardexSelect" id="TipoKardexSelect" class="form-control">
                                                                <option value="TodoTipos">Todo</option>
                                                                <option value="Ingreso">Ingreso</option>
                                                                <option value="Salida">Salida</option>
                                                                <option value="Faltante">Faltante</option>
                                                                <option value="Sobrante">Sobrante</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12" style="width: 100%; margin: 0px; border-bottom: 1px solid #E6E6E6; border-left: 1px solid #E6E6E6; border-right: 1px solid #E6E6E6;">
                                            <div class="row">
                                                <div class="col-10 col-md-12" style="border-top: 2px solid #E6E6E6;">
                                                    <div class="row" style="padding-top: 8px;">
                                                        <div class="row" style="width: 100%;">
                                                            <div class="col-md-8" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487; font-weight: bold;">Del 
                                                                    <span style="color: #2C3333; font-weight: bold;" id="FechaInicio">19/06/24</span> 00:00 hs al 
                                                                    <span style="color: #2C3333; font-weight: bold;" id="FechaFinal">19/06/24</span> 00:00 hs
                                                                    <span style="color: #2C3333; font-weight: bold;" id="CantidadRegistroDatos">1 registros</span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-2" style="border-bottom: 1px solid #E6E6E6; border-right: 2px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487;">Ingreso <br>
                                                                    <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="IngresoKardex"></span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-2" style="border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487;">Salida <br>
                                                                    <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="SalidaKardex"></span>
                                                                </span>                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                    <div class="card">
                                                        <div class="table-responsive" id="tabla-gasto">
                                                            <table class="table table-vcenter card-table">
                                                                <thead>
                                                                    <tr>
                                                                    <th></th>
                                                                    <th>Fecha</th>
                                                                    <th>Detalle</th>
                                                                    <th>Tipo De Venta</th>
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Stock Anterior</th>
                                                                    <th>Stock Actual</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tabs-controlstock" role="tabpanel">                        
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">KARDEX</h3>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right;">
                                    <a class="btn" id="exportproductos" style="padding-left: 25px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="row">
                                        <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                                            <div class="row" style="background: #F5F7F8;">
                                                <div class="col-10 col-md-11" style="padding-bottom: 12px;">
                                                    <div class="row" style="background: #F5F7F8;">
                                                        <div class="col-md-4">
                                                            <input type="text" placeholder="Producto . . ." class="form-control" id="SarchProducto"/>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select name="" id="" class="form-control" id="MostrarStockMenores">
                                                                <option value="MostrarTodo">Mostrar Todo</option>
                                                                <option value="5">Menor a 5</option>
                                                                <option value="6">Menor a 6</option>
                                                                <option value="7">Menor a 7</option>
                                                                <option value="8">Menor a 8</option>
                                                                <option value="9">Menor a 9</option>
                                                                <option value="10">Menor a 10</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="badge bg-blue" style="padding: 10px">PDF</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                    <div class="card">
                                                        <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                                                            <span>PRODUCTOS</span>
                                                        </div>
                                                        <div class="table-responsive" id="tabla-stockproducto">
                                                            <table class="table table-vcenter card-table">
                                                                <thead>
                                                                    <tr>
                                                                    <th>Producto</th>
                                                                    <th>Stock Minimo</th>
                                                                    <th>Total Stock</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4" style="margin: 0px; padding: 0px;">
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


<div class="modal modal-blur fade" id="ModalIngreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingreso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="text" class="form-control convertirnumero" id="CantidadIngreso">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Proveedor</label>
                        <select class="form-control" id="ProveedorKardex">
                        </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea class="form-control convertirmayuscula" rows="5" id="DescripcionIngreso"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal" id="CerrarIngresoInventario">Cerrar</button>
                <button type="button" class="btn btn-primary" id="RegistrarIngresoKardex">Registrar Ingreso</button>
            </div>
        </div>
    </div>
</div>


<div class="modal modal-blur fade" id="ModalFaltante" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Faltante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="mb-3">
                        <label class="form-label">Accion</label>
                        <select class="form-control" id="TipoAccion">
                            <option value="Sobrante">Sobrante</option>
                            <option value="Faltante">Faltante</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="text" class="form-control convertirnumero" id="CantidadFaltante">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Responsable</label>
                        <select class="form-control" id="ResponsableFaltante">
                        </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea class="form-control convertirmayuscula" rows="5" id="DescripcionFaltante"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal" id="CerrarFaltanteInventario">Cerrar</button>
                <button type="button" class="btn btn-primary" id="RegistrarFaltanteKardex">Registrar Ingreso</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="ModalSolucion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Solucion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <textarea type="text" class="form-control" id="DescripcionSolucion"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal" id="CerrarFaltanteInventario">Cerrar</button>
                <button type="button" class="btn btn-primary" id="RegistrarSolucionKardex">Registrar Solucion</button>
            </div>
        </div>
    </div>
</div>


<div class="modal modal-blur fade" id="ModalSolucionPDF" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Solucion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" width="100%" height="500px" src="" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src='https://unpkg.com/fullcalendar-scheduler@5.8.0/main.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/locales-all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('utilidades/js/kardex.js') }}" defer></script>
<script src="{{ asset('utilidades/js/controlstock.js') }}" defer></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script> -->

<style>
    .selected {
        border: 15px solid green;
        background: red;
    }
    .hovered{
        background-color: #fd7;
    }
    #tabla-gasto tbody tr:hover {
        background-color: #ffeeba;
    }
    #tabla-gasto tbody tr.selected-row {
        background-color: #ffeeba;
    }

    #tabla-categoria-gasto tbody tr:hover {
        background-color: #ffeeba;
    }
    #tabla-categoria-gasto tbody tr.selected-row {
        background-color: #ffeeba;
    }
    
    /* Estilos generales */
    .product-item, .selected-product {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .product-item:hover {
        background-color: #f1f1f1;
    }

    .selected-product {
        background-color: #fd7;
    }
</style>
@livewireStyles
<script>
    $(document).ajaxStart(function() {
        cargarProveedores()
        mostrarCargandoDatos();
    });

    $(document).ajaxStop(function() {
        ocultarCargandoDatos();
    });

    $(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
        ocultarCargandoDatos();
        if (!navigator.onLine) {
            mostrarMensajeSinConexion();
        } else {
            console.error("Error:", thrownError);
        }
    });

    window.addEventListener('offline', function() {
        mostrarMensajeSinConexion();
    });

    window.addEventListener('online', function() {
        ocultarMensajeSinConexion();
    });


    $(document).ready(function() {
        CanvasTime()
        function getBaseUrl() {
            var url = window.location.href;
            var baseUrl = url.split('#')[0];
            return baseUrl;
        }

        function updateUrl(tabId) {
            var newUrl = getBaseUrl() + tabId;
            window.history.replaceState(null, null, newUrl);
        }

        $(window).on('load', function() {
            updateUrl('#tabs-kardex');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
        });
    });

    function cargarProveedores(){
        $.ajax({
            url: '/api/get-proveedor',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const proveedorSelect = $('#ProveedorKardex');
                proveedorSelect.empty();
                proveedorSelect.append('<option value="">Seleccionar Proveedor</option>');
                $.each(data, function(index, proveedor) {
                    proveedorSelect.append('<option value="' + proveedor.id + '">' + proveedor.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar los proveedores:', error);
                alert('Ocurrió un error al cargar los proveedores');
            }
        });
    }
</script>
@livewireScripts
