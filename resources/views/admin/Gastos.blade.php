@extends('layouts.my-dashboard-layout')

@section('content')
<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-gastos" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">GASTOS</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-cant-gastos" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">CATEGORÍAS DE GASTOS</a>
                </li>
            </ul>
            </div>
            <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active show" id="tabs-gastos" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">GASTOS</h3>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right;">
                                    <a class="btn" id="addgastos" style="padding-left: 25px;">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
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
                                                <div class="col-2 col-md-1" style="border-right: 2px solid #E6E6E6;">
                                                    <center>
                                                        <div class="icon-container">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                                                            </svg>
                                                        </div>
                                                    </center>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row" style="padding-bottom: 10px">
                                                        <div class="col-md-3">
                                                            <select name="DateGasto" id="DateGasto" class="form-control">
                                                                <option value="DiarioGasto">Diario</option>
                                                                <option value="MensualGasto">Mensual</option>
                                                                <option value="AnualGasto">Anual</option>
                                                                <option value="RangoGasto">Rango</option>
                                                                <option value="ArqueoGasto">Arqueo</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="DiaGastoContainer">
                                                            <select name="DiaGasto" id="DiaGasto" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3" id="MesGastoContainer">
                                                            <select name="MesGasto" id="MesGasto" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="AnioGastoContainer">
                                                            <select name="AnioGasto" id="AnioGasto" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3" id="FechaInicioContainerGasto">
                                                            <input type="date" name="fechaInicioGasto" id="fechaInicioGasto" class="form-control">
                                                        </div>
                                                        <div class="col-md-3" id="FechaFinContainerGasto">
                                                            <input type="date" name="fechaFinGasto" id="fechaFinGasto" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 col-md-12" style="border-top: 2px solid #E6E6E6;">
                                                    <div class="row" style="padding-top: 8px;" >
                                                        <div class="row" style="width: 100%;">
                                                            <div class="col-md-2">
                                                                <select name="ProveedorGastoSelect" id="ProveedorGastoSelect" class="form-control">
                                                                    <option value="TodoProveedor">Proveedor</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="CategoriaGastoSelect" id="CategoriaGastoSelect" class="form-control">
                                                                    <option value="TodoCategoria">Categoria</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="ComprobanteGasto" id="ComprobanteGasto" class="form-control">
                                                                    <option value="TodoComprobante">Comprobante</option>
                                                                    <option value="Factura">Factura</option>
                                                                    <option value="Recibo">Recibo</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="MetodoPagoVenta" id="MetodoPagoVenta" class="form-control">
                                                                    <option value="TodoMetodoPago">Medio De Pago</option>
                                                                    <option value="Efectivo">Efectivo</option>
                                                                    <option value="Tarjeta">Tarjeta De Credito</option>
                                                                    <option value="Deposito/QR">Deposito - QR</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12" style="width: 100%; margin: 0px; border-bottom: 1px solid #E6E6E6; border-left: 1px solid #E6E6E6; border-right: 1px solid #E6E6E6;">
                                            <div class="row">
                                                <div class="col-10 col-md-12" style="border-top: 2px solid #E6E6E6;">
                                                    <div class="row" style="padding-top: 8px;" >
                                                        <div class="row" style="width: 100%;">
                                                            <div class="col-md-10" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487; font-weight: bold;">Del 
                                                                    <span style="color: #2C3333; font-weight: bold;" id="FechaInicio">19/06/24</span> 00:00 hs al 
                                                                    <span style="color: #2C3333; font-weight: bold;" id="FechaFinal">19/06/24</span> 00:00 hs
                                                                    <span style="color: #2C3333; font-weight: bold;" id="CantidadRegistroDatos">1 registros</span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-2" style="border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487;">Total <br>
                                                                    <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="PrecioTotal"></span>
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
                                                                    <th>Fecha</th>
                                                                    <th>Proveedor</th>
                                                                    <th>Categoria</th>
                                                                    <th>Comentario</th>
                                                                    <th>Importe</th>
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
                <div class="tab-pane" id="tabs-cant-gastos" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">CATEGORÍAS DE GASTOS</h3>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right;">
                                    <a class="btn" id="addcategoriagastos">+ Nuevo Categoria</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="row">
                                        <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                    <div class="card">
                                                        <div class="table-responsive">
                                                            <table class="table table-vcenter card-table" id="tabla-categoria-gasto">
                                                                    <thead>
                                                                        <tr>
                                                                        <th>Nombre</th>
                                                                        <th></th>
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


@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
<script src="{{ asset('utilidades/js/gastos.js') }}" defer></script>
<script src="{{ asset('utilidades/js/categoriagastos.js') }}" defer></script>

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
            updateUrl('#tabs-gastos');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
        });
    });
</script>
@livewireScripts
