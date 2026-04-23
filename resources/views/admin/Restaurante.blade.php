@extends('layouts.my-dashboard-layout')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="row">
        <div class="col-12 col-md-8">
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
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-servicios-pedidos" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Servicios De Envio</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-ventas" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Ventas</a>
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
                                <div class="card-body" style="background-color: #303847; overflow-y: auto; width: 100%; margin: 0px; padding: 0px;" id="restaurant-grid">
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
                                                <th style="background-color: #3652AD; color: white">Direccion</th>
                                                <th style="background-color: #3652AD; color: white">Telefono</th>
                                                <th style="background-color: #3652AD; color: white">Cliente</th>
                                                <th style="background-color: #3652AD; color: white">Repartidor</th>
                                                <th style="background-color: #3652AD; color: white">Total</th>
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
                                                <th style="background-color: #F4CE14; color: white">Direccion</th>
                                                <th style="background-color: #F4CE14; color: white">Telefono</th>
                                                <th style="background-color: #F4CE14; color: white">Cliente</th>
                                                <th style="background-color: #F4CE14; color: white">Repartidor</th>
                                                <th style="background-color: #F4CE14; color: white">Total</th>
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
                                                        <th style="background: #65B741; color: white">Id</th>
                                                        <th style="background: #65B741; color: white">Hora Inicio</th>
                                                        <th style="background: #65B741; color: white">Direccion</th>
                                                        <th style="background: #65B741; color: white">Telefono</th>
                                                        <th style="background: #65B741; color: white">Cliente</th>
                                                        <th style="background: #65B741; color: white">Repartidor</th>
                                                        <th style="background: #65B741; color: white">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            <div class="text-center">
                                                <button id="loadMore" class="btn btn-primary" style="margin-top: 10px;">Load More</button>
                                            </div>
                                        </div>
                                    </div><br>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tabs-servicios-pedidos" role="tabpanel">
                            <div class="card">
                                <div class="card-header" style="width: 100%; background-color: #1d2736">
                                    <div class="row" style="width: 100%">
                                        <div class="col-12 col-sm-10">
                                            <h2 style="color: white">SERVICIOS PEDIDOS</h2>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <a href="#" class="btn btn-outline-info w-100" id="DeliveybtnServicioPedidoNuevo">
                                            + Nuevo Pedido
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow-y: auto; width: 100%;" id="restaurant-grid">
                                    <div class="row">
                                        <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                                            <div class="row" style="background: #F5F7F8;">
                                                <div class="col-md-8">
                                                    <div class="row" style="padding-bottom: 10px">
                                                        <div class="col-md-3">
                                                            <select name="DateServicioPedido" id="DateServicioPedido" class="form-control">
                                                                <option value="DiarioServicioPedido">Diario</option>
                                                                <option value="MensualidadServicioPedido">Todo El Mes</option>
                                                                <option value="RangoServicioPedido">Rango</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="DiaServicioPedidoContainer">
                                                            <select name="DiaServicioPedido" id="DiaServicioPedido" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3" id="MesServicioPedidoContainer">
                                                            <select name="MesServicioPedido" id="MesServicioPedido" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3" id="FechaInicioContainerServicioPedido">
                                                            <input type="date" name="fechaInicioServicioPedido" id="fechaInicioServicioPedido" class="form-control">
                                                        </div>
                                                        <div class="col-md-3" id="FechaFinContainerServicioPedido">
                                                            <input type="date" name="fechaFinServicioPedido" id="fechaFinServicioPedido" class="form-control">
                                                        </div>
                                                        <div class="col-md-2 d-flex gap-2">
                                                            <button class="btn btn-danger w-100" id="btnExportarPDF">
                                                                PDF
                                                            </button>
                                                            <button class="btn btn-success w-100" id="btnExportarExcel">
                                                                EXCEL
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                                            <div class="table-responsive">
                                                <table class="table table-vcenter card-table" id="table-servicio-pedido">
                                                <thead>
                                                    <tr>
                                                    <th>Tipo</th>
                                                    <th>Cliente</th>
                                                    <th>Nro Orden</th>
                                                    <th>Nro Pedido</th>
                                                    <th>Fecha</th>
                                                    <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-end"><strong>TOTAL:</strong></td>
                                                        <td id="total-sum"></td>
                                                    </tr>
                                                </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tabs-ventas" role="tabpanel">
                            <div class="card">
                                <div class="card-header" style="width: 100%; background-color: #1d2736">
                                    <div class="row" style="width: 100%">
                                        <div class="col-12 col-sm-10">
                                            <h2 style="color: white">SERVICIOS VENTAS</h2>
                                        </div>
                                        <div class="col-12 col-sm-2">
                                            <a href="#" class="btn btn-outline-info w-100" id="VentaNueva">
                                            + Nueva Venta
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow-y: auto; width: 100%;" id="restaurant-grid">
                                    <div class="row">
                                        <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                                            <div class="row" style="background: #F5F7F8;">
                                                <div class="col-md-8">
                                                    <div class="row" style="padding-bottom: 10px">
                                                        <div class="col-md-3">
                                                            <select name="DateVentaSuelta" id="DateVentaSuelta" class="form-control">
                                                                <option value="DiarioVentaSuelta">Diario</option>
                                                                <option value="MensualidadVentaSuelta">Todo El Mes</option>
                                                                <option value="RangoVentaSuelta">Rango</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="DiaVentaSueltaContainer">
                                                            <select name="DiaVentaSuelta" id="DiaVentaSuelta" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3" id="MesVentaSueltaContainer">
                                                            <select name="MesVentaSuelta" id="MesVentaSuelta" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3" id="FechaInicioContainerVentaSuelta">
                                                            <input type="date" name="fechaInicioVentaSuelta" id="fechaInicioVentaSuelta" class="form-control">
                                                        </div>
                                                        <div class="col-md-3" id="FechaFinContainerVentaSuelta">
                                                            <input type="date" name="fechaFinVentaSuelta" id="fechaFinVentaSuelta" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                                            <div class="table-responsive">
                                                <table class="table table-vcenter card-table" id="table-venta-suelta">
                                                <thead>
                                                    <tr>
                                                    <th>Tipo</th>
                                                    <th>Comentario</th>
                                                    <th>Pago</th>
                                                    <th>Fecha</th>
                                                    <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><strong>TOTAL:</strong></td>
                                                        <td id="total-sum-venta-suelta"></td>
                                                    </tr>
                                                </tfoot>
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
        <div class="col-12 col-md-4" style="margin: 0px; padding: 0px">
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

    <div class="modal modal-blur fade" id="ModalAddModificador" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Modificador . .</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 5px; padding: 5px;">
                <h5 class="modal-title" id="exampleModalLabel">Agrega Modificador Al Pedido</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnAddMod">Confirmar</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="ModalAddModificadorMostrador" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Modificador . .</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 5px; padding: 5px;">
                <h5 class="modal-title" id="exampleModalLabel">Agrega Modificador Al Pedido</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnAddModMostrador">Confirmar</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="ModalEditarModificador" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Modificador . .</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 5px; padding: 5px;">
                <h5 class="modal-title" id="exampleModalLabel">Editar Modificador Del Pedido</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnActualizaMod" data-bs-dismiss="modal">Confirmar</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="ModalEditarModificadorMostrador" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Modificador . .</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin: 5px; padding: 5px;">
                <h5 class="modal-title" id="exampleModalLabel">Editar Modificador Del Pedido</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnActualizaModMostrador" data-bs-dismiss="modal">Confirmar</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="ModalEliminarModificador" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-danger"></div>
          <div class="modal-body text-center py-4">
            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
            <h3>Are you sure?</h3>
            <div class="text-muted">Do you really want to remove 84 files? What you've done cannot be undone.</div>
          </div>
          <div class="modal-footer">
            <div class="w-100">
              <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    Cancel
                  </a></div>
                <div class="col"><a href="#" class="btn btn-danger w-100" data-bs-dismiss="modal" id="EliminarModf">
                    Borrar
                  </a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal modal-blur fade" id="ModalEliminarModificadorMostrador" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-danger"></div>
          <div class="modal-body text-center py-4">
            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
            <h3>Are you sure?</h3>
            <div class="text-muted">Do you really want to remove 84 files? What you've done cannot be undone.</div>
          </div>
          <div class="modal-footer">
            <div class="w-100">
              <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    Cancel
                  </a></div>
                <div class="col"><a href="#" class="btn btn-danger w-100" data-bs-dismiss="modal" id="EliminarModfMostrador">
                    Borrar
                  </a></div>
              </div>
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
                            <div class="row" style="padding: 10px" hidden>
                                <label class="col-6 col-form-label pt-0">Enviar a CAJAS</label>
                                <div class="col">
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" style="border: 1px solid black" id="EnviarCaja" checked>
                                    </label>
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
                            <div class="row" style="padding: 10px" hidden>
                                <label class="col-6 col-form-label pt-0">Enviar a CAJAS</label>
                                <div class="col">
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" style="border: 1px solid black" id="EnviarCajaMostrador" checked>
                                    </label>
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
    
    <!-- PDF MODAL MESA-->
    <div class="modal modal-blur fade" id="pdfModalMesa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-body">
                    <iframe id="pdfViewer" src="" width="100%" height="500px"></iframe>
                </div>
            </div>
        </div>
    </div>
    
        <!-- PDF MODAL MOSTRADOR-->
    <div class="modal modal-blur fade" id="pdfModalMostrador" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-body">
                    <iframe id="pdfViewerMostrador" src="" width="100%" height="500px"></iframe>
                </div>
            </div>
        </div>
    </div>
    
        <!-- PDF MODAL DELIVERY-->
    <div class="modal modal-blur fade" id="pdfModalDelivery" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-body">
                    <iframe id="pdfViewerDelivery" src="" width="100%" height="500px"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-cortesia-pensionado" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-success"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
                <br>
                <span id="product-name-modal" style="font-size: 18px">De este producto no se le cobrara ningun monto, ¿está seguro?</span>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                <div class="row">
                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">No</a></div>
                    <div class="col"><a href="#" class="btn btn-success w-100" data-bs-dismiss="modal" id="btn-registrar-cortesia">Si, Confirmar</a></div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-cambiar-mesa-habitacion" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pasar Consumo Mesa a Habitacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h6>Habitaciones Ocupadas:</h6>
                            <select id="habitaciones-select" class="form-select">
                                <option value="">Selecciona una habitación</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-cambio-mesa-habitacion" data-bs-dismiss="modal" disabled>Registrar Cambio</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modalBtnImprimirTicketServicioVenta" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Imprimir Ticket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
            </div>
        </div>
        </div>
    </div>


    <div class="modal modal-blur fade" id="modalBtnImprimirTicketMostrador" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Imprimir Ticket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
            </div>
        </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modalBtnImprimirTicketVentaSuelta" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Imprimir Ticket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
            </div>
        </div>
        </div>
    </div>
    
@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('utilidades/js/mesas.js') }}" defer></script>
<script src="{{ asset('utilidades/js/mostrador.js') }}" defer></script>
<script src="{{ asset('utilidades/js/delivery.js') }}" defer></script>
<script src="{{ asset('utilidades/js/serviciospedidos.js') }}" defer></script>
<script src="{{ asset('utilidades/js/VentasSueltas.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<style>
    #table-servicio-pedido tr.hovered {
        background-color: #fd7;
    }

    #table-servicio-pedido tr.selected {
        background-color: #fd7;
    }

    .contenedor {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .elemento {
        flex: 0 0 calc(33.33% - 3px);
        margin-bottom: 3px;
        margin-right: 3px;
        background-color: #EEEEEE;
        padding: 5px;
        box-sizing: border-box;
        border: 1px solid #B2B2B2;
    }

    .elemento:last-child {
        margin-right: 0;
    }


    .autocomplete-bold {
        font-weight: bold;
    }

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
    #productoDiv{
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
        background-color: #B0DAFF;
    }
    .selectedEnviar {
        background-color: #FFFAE6;
    }
    .star-label {
        cursor: pointer;
    }
    #checkbox-1:checked + .star-label .icon-1 {
        color: gold;
    }

    .mesa {
        margin: 5px;
        padding-top: 0;
        padding-bottom: 0;
        position: relative;
        aspect-ratio: 1;
    }

    .mesa a{
        width: 100%;
        height: 100%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .mesa a.selected-btn {
        border: 10px solid #206bc4 !important;
        box-sizing: border-box !important;
        width: 100% !important;
        margin: 0px !important;
    }

    @media only screen and (max-width: 500px) {
        .mesa a{
            width: 130% !important;
            height: 130% !important;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
        }

        #EditAmbiente{
            display: none;
        }

        .mesa a.selected-btn {
            border: 8px solid #206bc4 !important;
            font-size: 14px !important;
            height: 182% !important;
        }
    }

    @media (min-width:767 and max-width: 768px) {
        .mesa a{
            width: 100% !important;
            height: 100% !important;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
        }

        .mesa a.selected-btn {
            border: 8px solid #206bc4 !important;
            font-size: 14px !important;
            height: 100% !important;
        }
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
            updateUrl('#tabs-mesas');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
        });
    });
</script>
@livewireScripts
