@extends('layouts.my-dashboard-layout')

@section('content')
<div class="row">
    <div class="col-12 col-sm-7">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-ventas" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Ventas</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-movimientosengeneral" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Movimiento En General</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-productosvendidos" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Producto Vendidos</a>
                </li>
            </ul>
            </div>
            <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active show" id="tabs-ventas" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">VENTAS</h3>
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
                                                            <select name="DateVenta" id="DateVenta" class="form-control">
                                                                <option value="DiarioVenta">Diario</option>
                                                                <option value="MensualVenta">Mensual</option>
                                                                <option value="AnualVenta">Anual</option>
                                                                <option value="RangoVenta">Rango</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="DiaVentaContainer">
                                                            <select name="DiaVenta" id="DiaVenta" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3" id="MesVentaContainer">
                                                            <select name="MesVenta" id="MesVenta" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="AnioVentaContainer">
                                                            <select name="AnioVenta" id="AnioVenta" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3" id="FechaInicioContainerVenta">
                                                            <input type="date" name="fechaInicio" id="fechaInicio" class="form-control">
                                                        </div>
                                                        <div class="col-md-3" id="FechaFinContainerVenta">
                                                            <input type="date" name="fechaFin" id="fechaFin" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-10 col-md-12" style="border-top: 2px solid #E6E6E6;">
                                                    <div class="row" style="padding-top: 8px;" >
                                                        <div class="row" style="width: 100%;">
                                                            <div class="col-md-2" style="display: none">
                                                                <select name="EventoVenta" id="EventoVenta" class="form-control">
                                                                    <option value="Eliminada">Eliminada</option>
                                                                    <option value="Cerrada">Cerrada</option>
                                                                    <option value="Enviado">Enviado</option>
                                                                    <option value="Pagado">Pagado</option>
                                                                    <option value="Pendiente">Pendiente</option>
                                                                    <option value="A Entregar">A Entregar</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="TipoVenta" id="TipoVenta" class="form-control">
                                                                    <option value="TodoVenta">Tipo De Venta</option>
                                                                    <option value="Mesa">Local</option>
                                                                    <option value="Delivery">Delivery</option>
                                                                    <option value="Mostrador">Mostrador</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="UsuarioVenta" id="UsuarioVenta" class="form-control">
                                                                    <option value="TodoUsuario">Usuario</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="ClienteVenta" id="ClienteVenta" class="form-control">
                                                                    <option value="TodoCliente">Cliente</option>
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
                                                            <div class="col-md-1" id="AmbienteConteiner">
                                                                <select name="AmbienteMesaVenta" id="AmbienteMesaVenta" class="form-control">
                                                                    <option value="TodoAmbientes">Ambientes</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1" id="MesaContainer">
                                                                <select name="MesaVenta" id="MesaVenta" class="form-control">
                                                                <option value="TodoMesa">Mesas</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <a href="#" class="btn btn-primary w-100" id="BtnExportarPDFVentas">Export PDF</a>
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
                                                            <div class="col-md-4" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487; font-weight: bold;">Del
                                                                    <span style="color: #2C3333; font-weight: bold;" id="FechaInicio">19/06/24</span> 00:00 hs al
                                                                    <span style="color: #2C3333; font-weight: bold;" id="FechaFinal">19/06/24</span> 00:00 hs
                                                                    <span style="color: #2C3333; font-weight: bold;" id="CantidadRegistroDatos">1 registros</span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-2" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487;">Personas</span><br>
                                                                <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="CantidadPersonas"></span>
                                                            </div>
                                                            <div class="col-md-2" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487;">Promedio De Personas</span><br>
                                                                <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="PromedioPersona"></span>
                                                            </div>
                                                            <div class="col-md-2" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                                <span style="color: #7F8487;">Promedio Por Venta</span><br>
                                                                <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="PromedioVenta"></span>
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
                                                        <div class="table-responsive" id="tabla-venta">
                                                            <table class="table table-vcenter card-table">
                                                                <thead>
                                                                    <tr>
                                                                    <th>Hora Inicio</th>
                                                                    <th>Hora Cierre</th>
                                                                    <th>Estado</th>
                                                                    <th>Mesa</th>
                                                                    <th>Usuario</th>
                                                                    <th>Cliente</th>
                                                                    <th>Total</th>
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
                <div class="tab-pane" id="tabs-movimientosengeneral" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">MOVIMIENTOS DE CAJA</h3>
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
                                                            <select name="DateMovimientoReporteVenta" id="DateMovimientoReporteVenta" class="form-control">
                                                                <option value="DiarioMovimientoReporteVenta">Diario</option>
                                                                <option value="MensualMovimientoReporteVenta">Mensual</option>
                                                                <option value="AnualMovimientoReporteVenta">Anual</option>
                                                                <option value="RangoMovimientoReporteVenta">Rango</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1" id="DiaMovimientoReporteVentaContainer">
                                                            <select name="DiaMovimientoReporteVenta" id="DiaMovimientoReporteVenta" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="MesMovimientoReporteVentaContainer">
                                                            <select name="MesMovimientoReporteVenta" id="MesMovimientoReporteVenta" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1" id="AnioMovimientoReporteVentaContainer">
                                                            <select name="AnioMovimientoReporteVenta" id="AnioMovimientoReporteVenta" class="form-control">
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" id="FechaInicioContainerMovimientoReporteVenta">
                                                            <input type="date" name="fechaInicioMovimiento" id="fechaInicioMovimiento" class="form-control">
                                                        </div>
                                                        <div class="col-md-2" id="FechaFinContainerMovimientoReporteVenta">
                                                            <input type="date" name="fechaFinMovimiento" id="fechaFinMovimiento" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select name="PagoMovimientoReporteVenta" id="PagoMovimientoReporteVenta" class="form-control">
                                                                <option value="TodoPago">Todo</option>
                                                                <option value="Efectivo">Efectivo</option>
                                                                <option value="Tarjeta">Tarjeta</option>
                                                                <option value="Deposito/QR">Deposito/QR</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                            <div class="row">
                                                <div class="col-md-6 col-lg-3" style="cursor: pointer" id="DivVentasPointer">
                                                    <div class="card">
                                                    <div class="card-status-start bg-primary"></div>
                                                    <div class="card-body">
                                                        <center><h3 class="card-title">VENTAS</h3></center>
                                                        <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#396EB0" stroke="#396EB0"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#396EB0;} </style> <g> <path class="st0" d="M147.244,207.801c21.256,0,38.485-17.237,38.485-38.485l14.052-147.244h-61.569l-29.454,147.244 C108.759,190.564,125.988,207.801,147.244,207.801z"></path> <path class="st0" d="M256.004,207.801c21.248,0,38.477-17.237,38.477-38.485l-7.689-147.244h-61.576l-7.697,147.244 C217.518,190.564,234.748,207.801,256.004,207.801z"></path> <path class="st0" d="M364.763,207.801c21.249,0,38.478-17.237,38.478-38.485L373.794,22.071h-61.568l14.052,147.244 C326.278,190.564,343.507,207.801,364.763,207.801z"></path> <path class="st0" d="M460.798,22.071h-61.569l35.808,147.244c0,17.988,12.391,32.972,29.075,37.188V457.73h-57.997V287.744H259.818 V457.73H47.896V206.504c16.675-4.216,29.074-19.201,29.074-37.188l35.801-147.244H51.202L0,169.316 c0,12.687,6.218,23.85,15.698,30.864v289.75H496.31v-289.75c9.471-7.014,15.69-18.177,15.69-30.864L460.798,22.071z M381.969,457.73h-98.006V311.896h98.006V457.73z"></path> <rect x="109.404" y="276.338" class="st0" width="85.577" height="85.577"></rect> </g> </g></svg>
                                                        <p class="text-muted">Este apartado albergara toda la informacion de ventas Mesas, Delivery etc.</p>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-3" style="cursor: pointer" id="DivHostalPointer">
                                                    <div class="card">
                                                    <div class="card-status-start bg-primary"></div>
                                                    <div class="card-body">
                                                        <center><h3 class="card-title">HOSTAL</h3></center>
                                                        <svg fill="#FBA834" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#FBA834"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M12.691406 0L11.564453 2.3320312L9 2.6386719L10.949219 4.3613281L10.435547 7L12.691406 5.6816406L14.949219 7L14.435547 4.3613281L16.384766 2.6386719L13.820312 2.3320312L12.691406 0 z M 14.949219 7L10.435547 7L9.3007812 7C6.3307812 7 4 9.3307812 4 12.300781L4 45C4 45.55 4.45 46 5 46L22 46L22 36L28 36L28 46L45 46C45.55 46 46 45.55 46 45L46 12.300781C46 9.3307812 43.669219 7 40.699219 7L39.564453 7L35.050781 7L31.359375 7L26.845703 7L23.154297 7L18.640625 7L14.949219 7 z M 18.640625 7L20.896484 5.6816406L23.154297 7L22.640625 4.3613281L24.589844 2.6386719L22.025391 2.3320312L20.896484 0L19.769531 2.3320312L17.205078 2.6386719L19.154297 4.3613281L18.640625 7 z M 26.845703 7L29.103516 5.6816406L31.359375 7L30.845703 4.3613281L32.794922 2.6386719L30.230469 2.3320312L29.103516 0L27.974609 2.3320312L25.410156 2.6386719L27.359375 4.3613281L26.845703 7 z M 35.050781 7L37.308594 5.6816406L39.564453 7L39.050781 4.3613281L41 2.6386719L38.435547 2.3320312L37.308594 0L36.179688 2.3320312L33.615234 2.6386719L35.564453 4.3613281L35.050781 7 z M 10 12L16 12L16 16L10 16L10 12 z M 22 12L28 12L28 16L22 16L22 12 z M 34 12L40 12L40 16L34 16L34 12 z M 10 20L16 20L16 24L10 24L10 20 z M 22 20L28 20L28 24L22 24L22 20 z M 34 20L40 20L40 24L34 24L34 20 z M 10 28L16 28L16 32L10 32L10 28 z M 22 28L28 28L28 32L22 32L22 28 z M 34 28L40 28L40 32L34 32L34 28 z M 10 36L16 36L16 40L10 40L10 36 z M 34 36L40 36L40 40L34 40L34 36 z"></path></g></svg>
                                                        <p class="text-muted">Este apartado albergara toda la informacion de Hospedajes, Reservas etc.</p>
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
                <div class="tab-pane" id="tabs-productosvendidos" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">PRODUCTOS</h3>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
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
                                                    <select name="DateProductos" id="DateProductos" class="form-control">
                                                        <option value="DiarioProductos">Diario</option>
                                                        <option value="MensualProductos">Mensual</option>
                                                        <option value="AnualProductos">Anual</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2" id="DiaProductosContainer">
                                                    <select name="DiaProductos" id="DiaProductos" class="form-control">
                                                    </select>
                                                </div>
                                                <div class="col-md-3" id="MesProductosContainer">
                                                    <select name="MesProductos" id="MesProductos" class="form-control">
                                                    </select>
                                                </div>
                                                <div class="col-md-2" id="AnioProductosContainer">
                                                    <select name="AnioProductos" id="AnioProductos" class="form-control">
                                                    </select>
                                                </div>
                                                <div class="col-md-2" id="AnioProductosContainer">
                                                    <span class="badge bg-azure text-azure-fg">Generar <br> PDF</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">                        
                                    <div class="row" style="background: #F5F7F8;">
                                        <div class="col-2 col-md-1">
                                        
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row" style="padding-bottom: 10px">
                                                <div class="col-md-3">
                                                    <select name="RankingProductos" id="RankingProductos" class="form-control">
                                                        <option value="10">10 Productos</option>
                                                        <option value="20">20 Productos</option>
                                                        <option value="30">30 Productos</option>
                                                        <option value="40">40 Productos</option>
                                                        <option value="50">50 Productos</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select name="RankingVentas" id="RankingVentas" class="form-control">
                                                        <option value="MasVentas">Mas Ventas</option>
                                                        <option value="MenosVentas">Menos Ventas</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="CategoriaProductos" id="CategoriaProductos" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                    <div class="row">
                                        <div class="col-12 col-sm-12">
                                            <div class="card">
                                                <div id="loadingMessage" style="display: none; text-align: center;">
                                                    <p>Cargando datos, por favor espere...</p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12">
                                                        <div id="chartContainerProductos" style="overflow-y: auto; white-space: nowrap;">
                                                            <canvas id="GraficaDiarioProductos"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-12" style="padding: 20px">
                                                        
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
    <div class="col-12 col-sm-5">
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

<div class="modal modal-blur fade" id="modal-delete-arqueo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
            <h3>Estas serguro que quieres borrar?</h3>
            <div class="text-muted">Una vez borrado no hay vuelta atras.</div>
            </div>
            <div class="modal-footer">
            <div class="w-100">
                <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    Cancelar
                    </a></div>
                <div class="col"><a href="#" class="btn btn-danger w-100" data-bs-dismiss="modal" id="confirmDeleteBtnArqueo">
                    Borrar
                    </a></div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
            <h3>Estas serguro que quieres borrar?</h3>
            <div class="text-muted">Una vez borrado no hay vuelta atras.</div>
            </div>
            <div class="modal-footer">
            <div class="w-100">
                <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    Cancelar
                    </a></div>
                <div class="col"><a href="#" class="btn btn-danger w-100" data-bs-dismiss="modal" id="confirmDeleteBtn">
                    Borrar
                    </a></div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modalBtnImprimirTicketVentasGeneral" tabindex="-1" role="dialog" aria-hidden="true">
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
<link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">


<script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-gantt.min.js"></script>
<script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0"></script>

<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/locale/es.js"></script>
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
<script src="{{ asset('utilidades/js/venta.js') }}" defer></script>
<script src="{{ asset('utilidades/js/movimientoscaja.js') }}" defer></script>
<script src="{{ asset('utilidades/js/grafica-productos.js') }}" defer></script>

<style>
    .selected {
        border: 15px solid green;
        background: red;
    }
    .hovered{
        background-color: #fd7;
    }
    .tableproducseleccionado{
        background-color: #fd7;
    }
    .tableingredienteseleccionado{
        background-color: #fd7;
    }

    #tabla-movimientocaja tbody tr:hover {
        background-color: #ffeeba;
    }
    #tabla-movimientocaja tbody tr.selected-row {
        background-color: #ffeeba;
    }

    #tabla-arqueocaja tbody tr:hover {
        background-color: #ffeeba;
    }
    #tabla-arqueocaja tbody tr.selected-row {
        background-color: #ffeeba;
    }
</style>
@livewireStyles
<script>
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
            updateUrl('#tabs-ventas');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
        });
    });
</script>
@livewireScripts
