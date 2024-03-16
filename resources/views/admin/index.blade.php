@extends('layouts.my-dashboard-layout')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-12 col-sm-8">
            <div class="card">
                <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-mesas" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Mesas</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-mostrador" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Mostrador</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-delivery" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Delivery</a>
                    </li>
                </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-mesas" role="tabpanel">
                            <div class="card">
                                <div class="card-header" style="width: 100%; background-color: #1d2736">
                                    <div class="row" style="width: 100%">
                                        <div class="col-12 col-sm-8" id="listambientes">

                                        </div>
                                        <div class="col-12 col-sm-4" id="SectOperaciones">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="background-color: #303847; overflow-y: auto; width: 100%;" id="restaurant-grid">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-mostrador" role="tabpanel">
                            <div class="card">
                                <div class="card-header" style="width: 100%; background-color: #1d2736">
                                    <div class="row" style="width: 100%">
                                        <div class="col-12 col-sm-10">
                                            <h2 style="color: white">MOSTRADOR</h2>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <a href="#" class="btn btn-outline-info w-100" id="MbtnPedidoNuevo">
                                            + Nuevo Pedido
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow-y: auto; width: 100%;" id="restaurant-grid">
                                    <div class="card-header">
                                        <h3 class="card-title">EN CURSO</h3>
                                    </div>
                                    <div id="DivMostrador">
                                        <table class="table table-vcenter card-table" id="MostradorTableCurso">
                                        <thead>
                                            <tr>
                                            <th>Id</th>
                                            <th>Hora Inicio</th>
                                            <th>Estado</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th class="w-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        </table>
                                    </div>
                                    <div class="card-header">
                                        <h3 class="card-title">CERRADAS (ÚLTIMAS 5)</h3>
                                    </div>
                                    <div id="DivMostradorCerrados">
                                        <table class="table table-vcenter card-table" id="MostradorTableCerrado">
                                        <thead>
                                            <tr>
                                            <th>Id</th>
                                            <th>Hora Inicio</th>
                                            <th>Estado</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th class="w-1"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-delivery" role="tabpanel">
                            <div class="card">
                                <div class="card-header" style="width: 100%; background-color: #1d2736">
                                    <div class="row" style="width: 100%">
                                        <div class="col-12 col-sm-10">
                                            <h2 style="color: white">DELIVERY</h2>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <a href="#" class="btn btn-outline-info w-100" id="DeliveybtnPedidoNuevo">
                                            + Nuevo Pedido
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow-y: auto; width: 100%;" id="restaurant-grid">
                                    
                                    <div class="card" style="border: 2px solid #445069 !important;">
                                        <div class="card-header">
                                            <h3 class="card-title" style="color: #445069;"> PENDIENTES (0)</h3>
                                        </div>
                                        <div class="table-responsive" style="border: 1px solid #445069 !important;">
                                            <table class="table table-vcenter card-table" id="DeliveyPediente">
                                            <thead>
                                                <tr>
                                                <th style="background-color: #445069; color: white">Id</th>
                                                <th style="background-color: #445069; color: white">Hora Inicio</th>
                                                <th style="background-color: #445069; color: white">Estado</th>
                                                <th style="background-color: #445069; color: white">Cliente</th>
                                                <th style="background-color: #445069; color: white">Total</th>
                                                <th style="background-color: #445069; color: white" class="w-1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            </table>
                                        </div>
                                    </div><br>

                                    <div class="card" style="border: 2px solid #cd7318 !important;">
                                        <div class="card-header">
                                            <h3 class="card-title" style="color: #cd7318;">... EN PREPARACION (0)</h3>
                                        </div>
                                        <div class="table-responsive" style="border: 1px solid #cd7318 !important;">
                                            <table class="table" id="DeliveyPreparacion">
                                            <thead>
                                                <tr>
                                                <th style="background-color: #cd7318; color: white">Id</th>
                                                <th style="background-color: #cd7318; color: white">Hora Inicio</th>
                                                <th style="background-color: #cd7318; color: white">Direccion</th>
                                                <th style="background-color: #cd7318; color: white">Telefono</th>
                                                <th style="background-color: #cd7318; color: white">Cliente</th>
                                                <th style="background-color: #cd7318; color: white">Repartidor</th>
                                                <th style="background-color: #cd7318; color: white">Tiempo</th>
                                                <th style="background-color: #cd7318; color: white">Total</th>
                                                <th style="background-color: #cd7318; color: white" class="w-1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            </table>
                                        </div>
                                    </div><br>


                                    <div class="card" style="border: 2px solid #3652AD !important;">
                                        <div class="card-header">
                                            <h3 class="card-title" style="color: #3652AD;">LISTO PARA ENTREGAR  (0)</h3>
                                        </div>
                                        <div class="table-responsive" style="border: 1px solid #3652AD !important;">
                                            <table class="table table-vcenter card-table" id="DeliveyListoEntregado">
                                            <thead>
                                                <tr>
                                                <th style="background-color: #3652AD; color: white">Id</th>
                                                <th style="background-color: #3652AD; color: white">Hora Inicio</th>
                                                <th style="background-color: #3652AD; color: white">Estado</th>
                                                <th style="background-color: #3652AD; color: white">Cliente</th>
                                                <th style="background-color: #3652AD; color: white">Total</th>
                                                <th style="background-color: #3652AD; color: white" class="w-1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            </table>
                                        </div>
                                    </div><br>
                                    
                                    <div class="card" style="border: 2px solid #F4CE14 !important;">
                                        <div class="card-header">
                                            <h3 class="card-title" style="color: #F4CE14;">ENVIADOS (0)</h3>
                                        </div>
                                        <div class="table-responsive" style="border: 1px solid #F4CE14 !important;">
                                            <table class="table table-vcenter card-table" id="DeliveyEnviados">
                                            <thead>
                                                <tr>
                                                <th style="background-color: #F4CE14; color: white">Id</th>
                                                <th style="background-color: #F4CE14; color: white">Hora Inicio</th>
                                                <th style="background-color: #F4CE14; color: white">Estado</th>
                                                <th style="background-color: #F4CE14; color: white">Cliente</th>
                                                <th style="background-color: #F4CE14; color: white">Total</th>
                                                <th style="background-color: #F4CE14; color: white" class="w-1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            </table>
                                        </div>
                                    </div><br>

                                    <div class="card" style="border: 2px solid #65B741 !important;">
                                        <div class="card-header">
                                            <h3 class="card-title" style="color: #65B741;">ENTREGADOS (0)</h3>
                                        </div>
                                        <div class="table-responsive" style="border: 1px solid #65B741 !important;">
                                            <table class="table table-vcenter card-table" id="DeliveyEntregado">
                                            <thead>
                                                <tr>
                                                <th style="background-color: #65B741; color: white">Id</th>
                                                <th style="background-color: #65B741; color: white">Hora Inicio</th>
                                                <th style="background-color: #65B741; color: white">Estado</th>
                                                <th style="background-color: #65B741; color: white">Cliente</th>
                                                <th style="background-color: #65B741; color: white">Total</th>
                                                <th style="background-color: #65B741; color: white" class="w-1"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            </table>
                                        </div>
                                    </div><br>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4" style="margin: 0px; padding: 0px">
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selecciona la forma</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-primary elegir-forma" data-forma="circulo">Círculo</button>
                    <button class="btn btn-primary elegir-forma" data-forma="cuadrado">Cuadrado</button>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="ModalEditar" aria-labelledby="offcanvasEndLabel" style="width: 40%">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasEndLabel">Mover Mesa Selecionado</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
        <form id="form-cambiar-mesa">
            <div>
                <div class="row">
                    <div class="col-12 col-sm-3" id="div-datos" hidden>
                        <input type="text" class="form-control" id="EditMesaId">
                        <input type="text" class="form-control" id="EditPosicionX">
                        <input type="text" class="form-control" id="EditPosicionY">
                    </div>
                    <div class="col-12 col-sm-12">
                        <div id="div-editar">

                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary" type="button" data-bs-dismiss="offcanvas">
                Cerrar
                </button>
                <button class="btn btn-primary" type="button" id="btnCambiarMesa">
                Cambiar Mesa
                </button>
            </div>
        </form>
        </div>
    </div>

    <div class="modal modal-blur fade" id="ElminarDetalle" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detalle Del Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <input type="text" class="form-control" id="detalleIdInput" hidden>
                    <div class="mb-3">
                        <label class="form-label">¿Seguro desea cancelar este detalle del Pedido?<span class="form-label-description">56/100</span></label>
                        <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Comentario.." id="TextComentario"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="CancelarDetalle">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="ModalCerrarMesa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cerrar Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 5px; padding: 5px;">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                                <h3 class="card-title">DETALLE CONSUMO</h3>
                            </div>
                            <div class="card-body" style="margin: 4px; padding: 4px;">
                                <div id="listConsumo"></div>
                                <div id="lisDescuento"></div>
                            </div>
                            <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                                <div id="listTotal" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                                <h3 class="card-title" style="margin: 0;">PAGO</h3>
                                <button id="addPagos" class="btn btn-danger">+</button>
                            </div>
                            <div id="ListPagos" class="card-body" style="padding: 0px; margin: 0px">
                                
                            </div>
                            <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                                <div id="listVuelto" style="width: 100%">
                                
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarPago">Confirmar</button>
            </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-blur fade" id="ModalCerrarMostrador" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cerrardo Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 5px; padding: 5px;">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                                <h3 class="card-title">DETALLE CONSUMO</h3>
                            </div>
                            <div class="card-body" style="margin: 4px; padding: 4px;">
                                <div id="MostradorlistConsumo"></div>
                                <div id="MostradorlisDescuento"></div>
                            </div>
                            <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                                <div id="MostradorlistTotal" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                                <h3 class="card-title" style="margin: 0;">PAGO</h3>
                                <button id="MostradoraddPagos" class="btn btn-danger">+</button>
                            </div>
                            <div id="MostradorListPagos" class="card-body" style="padding: 0px; margin: 0px">
                                
                            </div>
                            <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                                <div id="MostradorlistVuelto" style="width: 100%">
                                
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarPagoMostrador">Confirmar</button>
            </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="{{ asset('utilidades/js/mesas.js') }}" defer></script>
<script src="{{ asset('utilidades/js/mostrador.js') }}" defer></script>

<style>

    .ui-autocomplete {
        position: absolute; 
        cursor: default; 
        border: 1px solid #ccc;
        background-color: #fff;
    }

    .ui-menu-item {
        padding: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        list-style: none;
        margin-left: -25px;
    }

    .ui-menu-item:hover {
        background-color: #f0f0f0;
    }

    [role="status"] {
        display: none !important;
    }

    #CardOcupado{
        background-color: #ffffff;
        opacity: 0.6;
        background-size: 9px 9px;
        background-image: repeating-linear-gradient(45deg, #ff0000 0, #ff0000 0.8px, #ffffff 0, #ffffff 50%);
    }
    .toastify {
        background: #2ecc71;
        color: #fff;
        font-family: 'Arial', sans-serif;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .toastify-error {
        background: #e74c3c;
        color: #fff;
        font-family: 'Arial', sans-serif;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }   

    #tabla-productos .producto-fila:hover {
        background-color: #D5DAEB;
    }
    #tabla-productos .producto-fila.selected {
        background-color: #D5DAEB;
    }
    .selected {
        background-color: #FF0303;
    }
    .star-label {
        cursor: pointer;
    }
    #checkbox-1:checked + .star-label .icon-1 {
        color: gold;
    }

    .mesa {
        margin: 5px;
        padding-top: 0; /* Eliminar relleno superior */
        padding-bottom: 0; /* Eliminar relleno inferior */
        position: relative; /* Para posicionamiento absoluto */
        aspect-ratio: 1; /* Mantener relación de aspecto 1:1 */
    }

    .mesa a{
        width: 100%;
        height: 100%;
        position: absolute; /* Posicionamiento absoluto */
        top: 50%; /* Centrar verticalmente */
        left: 50%; /* Centrar horizontalmente */
        transform: translate(-50%, -50%); /* Centrar en el centro */
    }

    .mesa a.selected-btn {
        border: 8px solid #206bc4 !important;
    }

    #selected-table {
        background: red;        
    }

    .editmesa.selected-table {
        background-color: #ffcc00;
    }


    .editmesa {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 80px;
        border: 2px solid #ddd; /* Border color for tables */
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .editmesa.selected-table {
        background-color: #ff7b7b; /* Background color for selected table */
        color: #fff; /* Text color for selected table */
        border-color: #ff7b7b; /* Border color for selected table */
    }

    .BtnMover {
        display: block;
        width: 100%;
        height: 100%;
    }

    .BtnMover svg {
        width: 24px;
        height: 24px;
        fill: #333; /* Icon color */
    }

    .row {
        display: flex;
    }

    #div-editar {
        max-width: 600px;
        margin: 0 auto;
    }

    #MostradorTableCurso tbody tr.selected {
        background-color: #ffeeba;
        color: #212529;
    }

    #MostradorTableCerrado tbody tr.selected {
        background-color: #ffeeba;
        color: #212529;
    }

    #DeliveyPreparacion tbody tr.selected {
        background-color: #FFE3BB;
        color: #212529;
    }

</style>
@livewireStyles
<script>
    document.addEventListener('DOMContentLoaded', function() {        
        var DeliveybtnPedidoNuevo = document.getElementById('DeliveybtnPedidoNuevo');
        
        GetDeliveryPreparando();
        DeliveybtnPedidoNuevo.addEventListener('click', function () {
            var MostradorNuevoPedido = document.getElementById('form_tabs');
            MostradorNuevoPedido.innerHTML = `
                <form>
                    <div class="card-header">
                        <div class="row" style="width: 100%">
                            <div class="col-12 col-sm-12">
                                <h3>Nuevo Pedido</h3>
                            </div> 
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <form class="card">
                                <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Telefono</label>
                                    <div class="col">
                                        <input class="form-control" id="DeliveryTelefono">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required">Cliente</label>
                                    <div class="col">
                                        <input class="form-control" id="DeliveryCliente">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <input class="form-control" id="DeliveryClienteId" hidden>
                                    <label class="col-3 col-form-label required">Direccion</label>
                                    <div class="col">
                                        <input class="form-control" id="DeliveryCalle" placeholder="Calle"><br>
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <input class="form-control" id="DeliveryNumero" placeholder="Numero">
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <input class="form-control" id="DeliveryPiso" placeholder="Piso / Depto">
                                            </div><br><br><br>
                                            <div class="col-12 col-sm-12">
                                                <input class="form-control" id="DeliveryBarrio" placeholder="Barrio">
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Repartidor</label>
                                    <div class="col">
                                    <select class="form-select" id="DeliverySeleccionarRepartidor" name="DeliverySeleccionarRepartidor">
                                        
                                    </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Tiempo</label>
                                    <div class="col">
                                    <select class="form-select" id="DeliveryTiempo" name="DeliveryTiempo"> 
                                        <option value=" "></option>
                                        <option value="20 Minutos">20 Minutos</option>
                                        <option value="30 Minutos">30 Minutos</option>
                                        <option value="40 Minutos">40 Minutos</option>
                                        <option value="50 Minutos">50 Minutos</option>
                                        <option value="1 Hora">1 Hora</option>
                                        <option value="1 Hora">1 Hora y Media</option>
                                        <option value="2 Horas">2 Horas</option>
                                        <option value="2 Horas">2 Horas y Media</option>
                                        <option value="3 Horas">3 Horas</option>
                                        <option value="6 Horas">6 Horas</option>
                                        <option value="12 Horas">12 Horas</option>
                                        <option value="24 Horas">24 Horas</option>
                                        <option value="48 Horas">48 Horas</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label pt-0">Costo De Envio</label>
                                    <div class="col">
                                    <input class="form-control" id="DeliveryCostoEnvio"><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label pt-0">Comentario</label>
                                    <div class="col">
                                    <textarea class="form-control" rows="5" id="DeliveryComentario" name="DeliveryComentario"></textarea>
                                    </div>
                                </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-end">
                                    <div>
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" id="RegistrarCliente">
                                            <span class="form-check-label">Registrar Cliente</span>
                                        </label>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" id="btnCrearDelivery">Crear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                    
                </form>
            `;

            $(function() {
                var $deliveryClienteId = $('#DeliveryClienteId');
                var $deliveryCliente = $('#DeliveryCliente');
                var $deliveryCalle = $('#DeliveryCalle');
                var $deliveryNumero = $('#DeliveryNumero');
                var $deliveryPiso = $('#DeliveryPiso');
                var $deliveryBarrio = $('#DeliveryBarrio');
                var $checkbox = $('#RegistrarCliente');
                $('#DeliveryTelefono').autocomplete({
                    minLength: 0,
                    source: function(request, response) {
                        $.ajax({
                            url: '/api/Search-Client',
                            type: 'GET',
                            dataType: "json",
                            data: {
                                search: request.term
                            },
                            success: function(data) {
                                if (data.length === 0) {
                                    $deliveryClienteId.val('');
                                    $deliveryCliente.val('');
                                    $deliveryCalle.val('');
                                    $deliveryNumero.val('');
                                    $deliveryPiso.val('');
                                    $deliveryBarrio.val('');
                                }
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $deliveryClienteId.val(ui.item.id);
                        $deliveryCliente.val(ui.item.NombreCliente);
                        $deliveryCalle.val(ui.item.CalleCliente);
                        $deliveryNumero.val(ui.item.NumeroCliente);
                        $deliveryPiso.val(ui.item.PisoCliente);
                        $deliveryBarrio.val(ui.item.BarrioCliente);
                        return false;
                    }
                });
            });

            
            //para el select repartidor
            $.ajax({
                url: '/api/get-repartidor',
                type: 'GET',
                dataType: 'json',
                success: function (repartidores) {
                    $('#DeliverySeleccionarRepartidor').empty();

                    $('#DeliverySeleccionarRepartidor').append($('<option>', {
                        value: '',
                        text: '',
                        selected: true,
                    }));
                    
                    for (var i = 0; i < repartidores.length; i++) {
                        var repartidore = repartidores[i];
                        $('#DeliverySeleccionarRepartidor').append($('<option>', {
                            value: repartidore.id,
                            text: repartidore.NombreRepartidor
                        }));
                    }
                },
                error: function (error) {
                    console.error('Error al obtener clientes:', error);
                }
            });
            
            $('#btnCrearDelivery').off('click').on('click', function(event) {
                event.preventDefault();
                //var MClienteID = $("#MSeleccionarCliente").val();
                var ClienteID = $("#DeliveryClienteId").val();
                var ClienteTelefono = $("#DeliveryTelefono").val();
                var ClienteNombre = $("#DeliveryCliente").val();
                var ClienteCalle = $("#DeliveryCalle").val();
                var ClienteNumero = $("#DeliveryNumero").val();
                var ClientePiso = $("#DeliveryPiso").val();
                var ClienteBarrio = $("#DeliveryBarrio").val();

                var SelectRepartidor = $("#DeliverySeleccionarRepartidor").val();
                var SelectTiempo = $("#DeliveryTiempo").val();
                var DeliveryCosto = $("#DeliveryCostoEnvio").val();
                var DeliveryComentario = $("#DeliveryComentario").val();

                var RegistrarCliente = $("#RegistrarCliente").prop("checked");

                var token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/api/registrar-consumo-delivery',
                    type: 'POST',
                    data: {
                        _token: token,
                        ClienteID: ClienteID,
                        ClienteTelefono: ClienteTelefono,
                        ClienteNombre: ClienteNombre,
                        ClienteCalle: ClienteCalle,
                        ClienteNumero: ClienteNumero,
                        ClientePiso: ClientePiso,
                        ClienteBarrio: ClienteBarrio,
                        SelectRepartidor: SelectRepartidor,
                        SelectTiempo: SelectTiempo,
                        DeliveryCosto: DeliveryCosto,
                        DeliveryComentario: DeliveryComentario,
                        RegistrarCliente: RegistrarCliente,
                    },
                    success: function(consumo) {
                        console.log(consumo)
                    },
                    
                    error: function(error) {
                        MostrarMensaje("La Mesa Noce Pudo Ocupar","error");
                    }
                });
            });
        });
    });

    
    function ListarDescuentosDelivery(id) {
        var DivDescuento = document.getElementById('DivDeliverySubTotalList');
        
        $.ajax({
            url: '/api/get-descuento/' + id,
            type: 'get',
            success: function (response) {
                DivDescuento.innerHTML = '';
                response.forEach(function (descuento) {
                    var nuevoDescuentoDiv = document.createElement('div');
                    nuevoDescuentoDiv.className = 'row';
                    nuevoDescuentoDiv.style.background = '#F0F0F0';
                    nuevoDescuentoDiv.style.padding = '6px';
                    nuevoDescuentoDiv.style.border = '2px solid white';

                    var tipoDescuentoText = descuento.TipoDescuento === 'porcentaje' ?
                        `Descuento de ${descuento.MontoDescuento} %` :
                        `Descuento de ${descuento.TipoDescuento}`;

                        nuevoDescuentoDiv.innerHTML = `
                            <div class="col-sm-6">
                                <div class="input-group" style="width: 100%">
                                    <span style="font-size: 16px; color: #3D3B40">${tipoDescuentoText}</span>
                                </div>
                            </div>
                            <div class="col-sm-5" style="text-align: right">
                                <span style="font-size: 16px; color: #3D3B40">${descuento.TotalDescuento} Bs.</span>
                            </div>
                            <div class="col-sm-1" style="text-align: right">
                                <button type="button" class="badge bg-red btnDeleteDescuento" data-descuento-id="${descuento.id}">x</button>
                            </div>
                        `;
                        DivDescuento.appendChild(nuevoDescuentoDiv);                    

                    var btnDeleteDescuento = nuevoDescuentoDiv.querySelector('.btnDeleteDescuento');
                    btnDeleteDescuento.addEventListener('click', function () {
                        var descuentoId = btnDeleteDescuento.getAttribute('data-descuento-id');
                        $.ajax({
                            url: '/api/eliminar-descuento/' + descuentoId,
                            type: 'DELETE',
                            success: function (response) {
                                DivDescuento.innerHTML = '';
                                ListarDescuentosDelivery(id)
                                MostrarMensaje('Descuento Eliminado Correctamente','success');
                                //actualiza total
                                $.ajax({
                                    url: '/api/get-mesa-ocupado/' + response.id,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function (consumo) {
                                        var SubTotalProduct = document.getElementById('DivSubTotal');
                                        if (consumo[0].descuentoconsumos.length > 0) {
                                            SubTotalProduct.innerHTML = `
                                                <div class="row" style="background: #243A73; padding: 20px;">
                                                    <div class="col-sm-7">
                                                        <div class="input-group" style="width: 100%">
                                                            <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5" style="text-align: right">
                                                        <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                                                    </div>
                                                </div>
                                            `;
                                        } else {
                                            SubTotalProduct.innerHTML = '';
                                        }
                                        var TotalProduct = document.getElementById('DivTotal');
                                        TotalProduct.innerHTML = `
                                            <div class="row" style="background: #243A73; padding: 20px;">
                                                <div class="col-sm-7">
                                                    <div class="input-group" style="width: 100%">
                                                        <span style="font-size: 20px; color: white">TOTAL</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5" style="text-align: right">
                                                    <span style="font-size: 20px; color: white">${consumo[0].total} Bs.</span>
                                                </div>
                                            </div>
                                        `;
                                    },
                                    error: function (error) {
                                        console.error('Error:', error);
                                    }
                                });
                            },
                            error: function (error) {
                                MostrarMensaje(error,'error');
                            }
                        });
                    });

                });
            },
            error: function (error) {
                MostrarMensaje(error,'error');
            }
        });
    }

    
    function DivTotalConsumoDelivery(ConsumoId) {

        function DescuentoDiv() {
            var btn = document.getElementById('btnPorcentajeDelivery');
            var id = btn.getAttribute('data-id');
            // Haz lo que necesites con el id
            var DivDescuento = document.getElementById('DivPreparandoDeliveryDescuento');
            DivDescuento.innerHTML = 
            `<div class="row" data-index="${id}" style="background: #DDE6ED; padding: 10px; widht: 100%">
                <input type="number" value="${id}" id="IdDescuento" class="form-control" style="width: 100%" hidden>
                <div class="col-sm-6">
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label" style="width: 40%">Descuento: </label>
                        <div class="col">
                        <input type="number" id="DescuentoPorcentaje" class="form-control" style="width: 100%">
                        </div>
                        <label class="col-3 col-form-label" style="width: 10%">%</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label" style="width: 50%">Bs: </label>
                        <div class="col">
                        <input type="number" id="DescuentoMonto" class="form-control" style="width: 100%">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="button" class="badge bg-red-lt" id="btnDescuentoCancelar">Cancelar</button>
                    <button type="button" class="badge bg-green-lt" id="btnDescuentoConfirmar">Confirmar</button>
                </div>
            </div>`;

            document.getElementById('btnDescuentoCancelar').addEventListener('click', function () {
                DivDescuento.innerHTML = '';
            });

            //para los inputs
            document.getElementById('DescuentoPorcentaje').addEventListener('input', function () {
                var porcentaje = parseInt(this.value, 10) || 0;

                if (porcentaje < 1) {
                    porcentaje = '';
                } else if (porcentaje > 100) {
                    porcentaje = 100;
                }

                this.value = porcentaje;

                var montoInput = document.getElementById('DescuentoMonto');
                montoInput.value = ''; // Limpiar el valor del monto
                montoInput.disabled = true; // Desactivar el input de monto

                // Habilitar el input DescuentoMonto si DescuentoPorcentaje está vacío
                if (!this.value.trim()) {
                    montoInput.disabled = false;
                }
            });
            document.getElementById('DescuentoMonto').addEventListener('input', function () {
                var monto = parseFloat(this.value) || 0;

                var porcentajeInput = document.getElementById('DescuentoPorcentaje');
                porcentajeInput.value = ''; // Limpiar el valor del porcentaje
                porcentajeInput.disabled = true; // Desactivar el input de porcentaje

                // Habilitar el input DescuentoPorcentaje si DescuentoMonto está vacío
                if (!this.value.trim()) {
                    porcentajeInput.disabled = false;
                }
            });

            
            document.getElementById('btnDescuentoConfirmar').addEventListener('click', function () {
                var idDescuento = document.getElementById('IdDescuento').value;
                var descuentoPorcentaje = document.getElementById('DescuentoPorcentaje').value;
                var descuentoMonto = document.getElementById('DescuentoMonto').value;
                $.ajax({
                    url: '/api/registrar-descuento',
                    type: 'POST',
                    data: {
                        id: idDescuento,
                        porcentaje: descuentoPorcentaje,
                        monto: descuentoMonto
                    },
                    success: function (response) {
                        DivDescuento.innerHTML = '';
                        ListarDescuentosDelivery(id)
                        MostrarMensaje('Descuento Registrado Correctamente','success');
                        //actualiza total
                        $.ajax({
                            url: '/api/get-delivery-consumo/' + ConsumoId,
                            type: 'GET',
                            dataType: 'json',
                            success: function (consumo) {
                                var SubTotalProduct = document.getElementById('DivSubTotal');
                                if (consumo[0].descuentoconsumos.length > 0) {
                                    SubTotalProduct.innerHTML = `
                                        <div class="row" style="background: #243A73; padding: 20px;">
                                            <div class="col-sm-7">
                                                <div class="input-group" style="width: 100%">
                                                    <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-5" style="text-align: right">
                                                <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                                            </div>
                                        </div>
                                    `;
                                } else {
                                    SubTotalProduct.innerHTML = '';
                                }
                                var TotalProduct = document.getElementById('DivTotal');
                                TotalProduct.innerHTML = `
                                    <div class="row" style="background: #243A73; padding: 20px;">
                                        <div class="col-sm-7">
                                            <div class="input-group" style="width: 100%">
                                                <span style="font-size: 20px; color: white">TOTAL</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-5" style="text-align: right">
                                            <span style="font-size: 20px; color: white">${consumo[0].total} Bs.</span>
                                        </div>
                                    </div>
                                `;
                            },
                            error: function (error) {
                                MostrarMensaje(error,'error');
                            }
                        });
                    },
                    error: function (error) {
                        MostrarMensaje(error,'error');
                    }
                });
            });                                        

        }

        $.ajax({
            url: '/api/get-delivery-consumo/' + ConsumoId,
            type: 'GET',
            dataType: 'json',
            success: function (consumo) {
                var SubTotalProduct = document.getElementById('DivPreparandoDeliverySubTotal');
                var IdConsumo = consumo[0].id;

                if (consumo[0].descuentoconsumos.length > 0) {
                    SubTotalProduct.innerHTML = `
                        <div class="row" style="background: #243A73; padding: 20px;">
                            <div class="col-sm-7">
                                <div class="input-group" style="width: 100%">
                                    <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                </div>
                            </div>
                            <div class="col-sm-5" style="text-align: right">
                                <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                            </div>
                        </div>
                    `;
                } else {
                    SubTotalProduct.innerHTML = '';
                }

                var TotalProduct = document.getElementById('DivPreparandoDeliveryTotal');
                TotalProduct.innerHTML = `
                    <div class="row" style="background: #243A73; padding: 20px;">
                        <div class="col-sm-7">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 20px; color: white">TOTAL</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <span style="font-size: 20px; color: white">${consumo[0].total} Bs.</span>
                        </div>
                    </div>
                `;
                var DivBotones = document.getElementById('DivBotonesFooter');
                DivBotones.innerHTML = `
                    <div class="col-md-6 col-lg-12 d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" id="btnPorcentajeDelivery" data-id="${IdConsumo}" style="text-align: center; padding: 0px; margin: 0px; padding-left: 6px; padding-right: 6px">
                            <span style="font-size: 20px; font-weight: bold;">%</span>
                        </button>

                        <button type="button" data-bs-toggle="modal" data-bs-target="#ModalCerrarMostrador" class="btn btn-danger" data-id="${IdConsumo}" id="btnDeliverySiguiente">Cerrar Mesa</button>
                    </div>
                `;

                // Vuelve a asignar el controlador de eventos al botón de porcentaje
                document.getElementById('btnPorcentajeDelivery').onclick = DescuentoDiv;
                //document.getElementById('btnDeliverySiguiente').onclick = MostradorguardarCambios;

            },
            error: function (error) {
                console.error('Error:', error);
            }
        });

    }

    function agregarDetallesConsumoDelivery(ConsumoId) {
        $.ajax({
            url: '/api/get-delivery-consumo/'+ConsumoId,
            type: 'GET',
            dataType: 'json',
            success: function (consumo) {
                console.log("xxxxx")
                console.log(consumo[0].detalleconsumos)
                DivagregarDetallesConsumoDelivery(consumo[0].detalleconsumos, ConsumoId);
                DivTotalConsumoDelivery(consumo[0].id);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    function DivagregarDetallesConsumoDelivery(detalleconsumos, ConsumoId) {
        $.ajax({
            url: '/api/get-delivery-consumo/' + ConsumoId,
            type: 'GET',
            dataType: 'json',
            success: function (consumo) {
            var DivPedidosDelivery = document.getElementById('DivPreparandoDelivery');
            DivPedidosDelivery.innerHTML = '';
            detalleconsumos.forEach(function (detalle, index) {
            var nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'row producto-row';
            nuevoDiv.style = 'padding: 1px';

                    if(detalle.eliminado == 'true'){
                        nuevoDiv.innerHTML = `
                            <div class="col-md-12 col-lg-12" style="margin: 0px; padding: 0px;">
                                <div class="card" id="CardOcupado">
                                    <div class="card-status-start bg-primary"></div>
                                    <div class="card-header">
                                        <div class="row" style="width: 100%;">
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title">${detalle.cantidad}</h3>
                                            </div>
                                            <div class="col-md-12 col-lg-7"  style="text-align: left;">
                                                <p class="card-title">${detalle.producto.NombreProducto}</p>
                                                <p style="font-size: 12px">${detalle.comentario} CANCELADO: ${detalle.comentarioeliminado}</p>
                                            </div>
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title" style="text-decoration:line-through;">${detalle.precio}</h3>                                                                    
                                            </div>
                                            <div class="col-md-12 col-lg-1" style="text-aling: right;">
                                                <a class="nav-link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }else{
                        nuevoDiv.innerHTML = `
                            <div class="col-md-12 col-lg-12" style="margin: 0px; padding: 0px;">
                                <div class="card">
                                    <div class="card-status-start bg-primary"></div>
                                    <div class="card-header">
                                        <div class="row" style="width: 100%">
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title">${detalle.cantidad}</h3>
                                            </div>
                                            <div class="col-md-12 col-lg-7" style="text-align: left;">
                                                <p class="card-title">${detalle.producto.NombreProducto}</p>
                                                <p style="font-size: 12px">${detalle.comentario}</p>
                                            </div>
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title">${detalle.precio}</h3>                                                                    
                                            </div>
                                            <div class="col-md-12 col-lg-1"  style="text-aling: right;">
                                                <a class="nav-link" data-bs-toggle="modal" data-bs-target="#ElminarDetalle" data-index="${index}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    
                    DivPedidosDelivery.appendChild(nuevoDiv);
                });

                $('#ElminarDetalle').on('show.bs.modal', function (event) {
                    var link = $(event.relatedTarget);
                    var index = link.data('index');
                    var detalle = detalleconsumos[index];
                    var modal = $(this);
                    modal.find('#detalleIdInput').val(detalle && detalle.id || '');
                });

                var botonAceptar = $('#CancelarDetalle');
                var textareaComentario = $('#TextComentario');
                botonAceptar.prop('disabled', true);
                textareaComentario.on('input', function() {
                    botonAceptar.prop('disabled', $(this).val().trim() === '');
                });

                var botonAceptar = $('#CancelarDetalle');
                    $('#CancelarDetalle').off('click').on('click', function (event) {

                    var detalleId = $('#detalleIdInput').val();
                    var comentario = $('#TextComentario').val();
                    
                    $.ajax({
                        url: '/api/delete-detalle-consumo/' + detalleId,
                        type: 'POST',
                        data: { detalleId: detalleId, comentario: comentario },
                        success: function (response) {
                            MostrarMensaje('Se Cancelo su detalle del pedido','success')
                            agregarDetallesConsumo(ConsumoId);
                        },
                        error: function (error) {
                            MostrarMensaje('hubo un problema en borrar','error')
                        }
                    });
                });

            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    

    function GetDeliveryPreparando() {
        $.ajax({
            url: '/api/get-delivery-preparacion',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#DeliveyPreparacion tbody').empty();
    
                $.each(data, function (index, consumo) {
                    var row = `<tr>
                                <td>${consumo.id}</td>
                                <td>${consumo.fecha_venta}</td>
                                <td>
                                    ${consumo.cliente 
                                        ? `${consumo.cliente.CalleCliente} ${consumo.cliente.NumeroCliente} ${consumo.cliente.PisoCliente} ${consumo.cliente.BarrioCliente}` 
                                        : `${consumo.clientetemporal.CalleCliente} ${consumo.clientetemporal.NumeroCliente} ${consumo.clientetemporal.PisoCliente} ${consumo.clientetemporal.BarrioCliente}`
                                    }
                                </td>
                                <td>
                                    ${consumo.cliente 
                                        ? consumo.cliente.TelefonoCliente 
                                        : consumo.clientetemporal.TelefonoCliente 
                                    }
                                </td>
                                <td>
                                    ${consumo.cliente 
                                        ? consumo.cliente.NombreCliente 
                                        : consumo.clientetemporal.NombreCliente 
                                    }
                                </td>
                                <td>${consumo.repartidor_id}</td>
                                <td>${consumo.TipoConsumo}</td>
                                <td>${consumo.total}</td>
                                <td>
                                <button style="background: #3652AD; color: white; border: white 1px solid white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-right-lines" style="width: 24px; height: 24px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-3v-6h3z" /><path d="M3 9v6" /><path d="M6 9v6" /></svg>
                                </button>

                                </td>
                            </tr>`;
                    $('#DeliveyPreparacion tbody').append(row);
                });
    
                var id;
    
                $('#DeliveyPreparacion').off('click').on('click', 'tbody tr', function (event) {
                    event.preventDefault(); 
                    $('#DeliveyPreparacion tbody tr').not(this).removeClass('selected');
                    $(this).toggleClass('selected');
                    if ($(this).hasClass('selected')) {
                        id = $(this).find('td:first').text();
                        GetConsumoDelivery(id);
                        agregarDetallesConsumoDelivery(id);
                        ListarDescuentosDelivery(id);
                        DivTotalConsumoDelivery(id);
                    }
                });
            },
            error: function (error) {
                console.error('Error al obtener datos del servidor:', error);
            }
        });
    }

    

    
    function GetConsumoDelivery(consumo){
        $.ajax({
            url: '/api/get-delivery-consumo/'+consumo,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var MostradorNuevoPedido = document.getElementById('form_tabs');
                    MostradorNuevoPedido.innerHTML = `
                        <form>
                            <div class="card-header" style="background: #cd7318">
                                <div class="row" style="width: 100%">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white">Pedido # ${data[0].id}</h3>
                                    </div> 
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="col-md-12">
                                    <form class="card">
                                        <div class="card-header">
                                            <div>
                                                <p><strong>Hora De Inicio:</strong> ${data[0].fecha_venta}</p>
                                                ${data[0].cliente ? `<p><strong>Cliente:</strong> ${data[0].cliente.NombreCliente}</p>` : ''}
                                                ${data[0].camarero ? `<p><strong>Camarero:</strong> ${data[0].camarero.NombreCamarero}</p>` : ''}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                        <div class="mb-3 row">
                                            <div class="mb-3">
                                                <label class="form-label">ADICIONAR</label>
                                                <div class="row g-2">
                                                    <div class="col-auto">
                                                    <a href="#" class="btn btn-icon" aria-label="Button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                                    </a>
                                                    </div>
                                                    <div class="col">
                                                    <input type="text" class="form-control" id="BuscarProducto" placeholder="Buscar Producto">
                                                    </div>                                                        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="mb-3" id="DivAddProduct">
                                                
                                            </div>
                                            <button id="btnGuardar" class="btn btn-primary" style="display: none">Guardar</button>
                                        </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <div class="mb-3" id="DivPreparandoDelivery">
                                                
                                            </div>
                                            
                                            <div id="DivPreparandoDeliverySubTotal" style="text-align: center">

                                            </div>
                                            <div id="DivDeliverySubTotalList">
                                                
                                            </div>
                                            <div id="DivPreparandoDeliveryDescuento">
                                                
                                            </div>
                                            <div id="DivPreparandoDeliveryTotal" style="text-align: center">
                                                <h1 style="color: #61677A">Sin Agregar Detalle al Consumo . . .</h1>
                                            </div>  
                                        </div>
                                        <div class="card-footer text-end">
                                            <div class="mb-3" id="DivBotonesFooter" style="padding: 0px;">
                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>                  
                        </form>
                    `;

                $.ajax({
                    url: '/api/get-productos',
                    type: 'GET',
                    dataType: 'json',
                    success: function (productos) {
                        var productosSeleccionados = [];
                        $('#BuscarProducto').autocomplete({
                            source: productos.map(producto => producto.NombreProducto),
                            select: function (event, ui) {
                                var productoSeleccionado = productos.find(producto => producto.NombreProducto === ui.item.label);
                                productosSeleccionados.push(Object.assign({}, productoSeleccionado));
                                actualizarDivsProductos();
                                ui.item.value = '';
                                return false;
                            },
                            close: function (event, ui) {
                                $(this).val('');
                            }
                        });

                        var btnGuardar = document.getElementById('btnGuardar');
                        $('#btnGuardar').off('click').on('click', function (event) {
                            event.preventDefault();
                            var ConsumoId = data[0].id;
                            var productosParaGuardar = productosSeleccionados.map(function (producto) {
                                return {
                                    Idconsumo: data[0].id,
                                    Idproducto: producto.id,
                                    nombre: producto.NombreProducto,
                                    cantidad: producto.Cantidad || 1,
                                    precio: producto.PrecioProducto || 0,
                                    comentario: producto.Comentario || '',
                                };
                            });

                            $.ajax({
                                url: '/api/registrar-detalle-consumo-mostrador/',
                                type: 'POST',
                                contentType: 'application/json',
                                data: JSON.stringify(productosParaGuardar),
                                success: function (response) {
                                    btnGuardar.style.display = 'none';
                                    MostrarMensaje("Producto Agregado","success")
                                    DivPedidos.innerHTML = '';
                                    AddProduct = document.getElementById('DivAddProduct');
                                    AddProduct.innerHTML = '';
                                    productosSeleccionados = [];
                                    agregarDetallesConsumoDelivery(ConsumoId);
                                },
                                error: function (error) {
                                    console.error('Error:', error);
                                }
                            });
                        });


                        function actualizarDivsProductos() {
                            var AddProduct = document.getElementById('DivAddProduct');
                            AddProduct.innerHTML = ''; 

                            productosSeleccionados.forEach(function (producto, index) {
                                var nuevoDiv = document.createElement('div');
                                nuevoDiv.className = 'row producto-row';
                                nuevoDiv.style = 'padding: 1px';

                                nuevoDiv.innerHTML = `
                                    <div class="row producto" data-index="${index}" style="background: #FFCC70; padding: 10px">
                                        <div class="col-sm-3">
                                            <div class="input-group" style="width: 100%">
                                                <button class="btn btn-outline-secondary btnDecrementar" type="button" style="width: 15px">-</button>
                                                <input type="number" name="CantProduct" class="form-control CantProduct" value="${producto.Cantidad || 1}" style="padding: 0px; text-align: center;">
                                                <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <a style="font-weight: bold; font-size: 13px">${producto.NombreProducto}</a>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="number" name="PrecioProduct" class="form-control PrecioProduct" value="${producto.PrecioProducto || 1}" style="padding-right: 0px; padding-left: 0px; text-align: center;">
                                        </div>
                                        <div class="col-sm-3" style="text-align: center;">
                                            <a class="mostrar-comentario">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" style="width: 36px; height: 36px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1" />
                                                </svg>
                                            </a>
                                            <a class="borrar-div" data-index="${index}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" style="width: 36px; height: 36px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="col-sm-12" style="text-align: center;"><br>
                                            <input type="text" name="ComentarioProduct" class="form-control ComentarioProduct" style="display: none">
                                        </div>
                                    </div>
                                `;

                                AddProduct.appendChild(nuevoDiv);

                                // Agregar controladores de eventos a los botones y elementos relevantes
                                var btnDecrementar = nuevoDiv.querySelector('.btnDecrementar');
                                var btnIncrementar = nuevoDiv.querySelector('.btnIncrementar');
                                var borrarDiv = nuevoDiv.querySelector('.borrar-div');
                                var cantProductInput = nuevoDiv.querySelector('.CantProduct');
                                var precioProductInput = nuevoDiv.querySelector('.PrecioProduct');
                                var comentarioProductInput = nuevoDiv.querySelector('.ComentarioProduct');
                                var mostrarComentarioLink = nuevoDiv.querySelector('.mostrar-comentario');

                                // Agregar controladores de eventos
                                btnDecrementar.addEventListener('click', function() {
                                    // Manejar decremento
                                    var cantidad = parseInt(cantProductInput.value, 10) || 0;
                                    if (cantidad > 0) {
                                        cantProductInput.value = cantidad - 1;
                                        producto.Cantidad = cantidad - 1; // Actualizar valor en el producto
                                    }
                                });

                                btnIncrementar.addEventListener('click', function() {
                                    // Manejar incremento
                                    var cantidad = parseInt(cantProductInput.value, 10) || 0;
                                    cantProductInput.value = cantidad + 1;
                                    producto.Cantidad = cantidad + 1; // Actualizar valor en el producto
                                });

                                borrarDiv.addEventListener('click', function() {
                                    var index = borrarDiv.getAttribute('data-index');
                                    productosSeleccionados.splice(index, 1);
                                    actualizarDivsProductos();
                                });

                                // Manejar cambios en la cantidad, precio y comentario
                                cantProductInput.addEventListener('input', function() {
                                    producto.Cantidad = cantProductInput.value;
                                });

                                precioProductInput.addEventListener('input', function() {
                                    producto.PrecioProducto = precioProductInput.value;
                                });

                                comentarioProductInput.addEventListener('input', function() {
                                    producto.Comentario = comentarioProductInput.value;
                                });

                                // Agregar evento para mostrar/comentar
                                mostrarComentarioLink.addEventListener('click', function() {
                                    // Alternar la visibilidad del input de comentario
                                    if (comentarioProductInput.style.display === 'none' || comentarioProductInput.style.display === '') {
                                        comentarioProductInput.style.display = 'block';
                                    } else {
                                        comentarioProductInput.style.display = 'none';
                                    }
                                });

                            });

                            btnGuardar.style.display = productosSeleccionados.length >= 1 ? 'block' : 'none';
                        }
                        
                    },
                    error: function (error) {
                        console.error('Error al obtener productos:', error);
                    }                            
                });
            },
            error: function (error) {
                console.error('Error al obtener datos del servidor:', error);
            }
        });   
    }

</script>
@livewireScripts
