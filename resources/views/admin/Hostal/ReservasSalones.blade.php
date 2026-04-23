<div class="card-header" id="card-reservas" style="width: 100%; background-color: white; display: flex; flex-wrap: wrap;">
    <div class="tab-pane" id="tabs-Reserva" role="tabpanel">
        <div class="card">
            <div class="card-header" style="width: 100%; background-color: #1d2736">
                <div class="row" style="width: 100%;">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title" style="color: white; font-weight: bold;">RESERVAS SALONES</h3>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align: right;">
                        <a class="btn" id="addreservassalone">+ Nueva Reserva</a>
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
                                    <div class="col-md-10">
                                        <div class="row" style="padding-bottom: 10px">
                                            <div class="col-md-3">
                                                <select name="DateReservaSalon" id="DateReservaSalon" class="form-control">
                                                    <option value="DiarioReservaSalon">Diario</option>
                                                    <option value="MensualReservaSalon">Mensual</option>
                                                    <option value="AnualReservaSalon">Anual</option>
                                                    <option value="RangoReservaSalon">Rango</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1" id="DiaReservaSalonContainer">
                                                <select name="DiaReservaSalon" id="DiaReservaSalon" class="form-control">
                                                </select>
                                            </div>
                                            <div class="col-md-2" id="MesReservaSalonContainer">
                                                <select name="MesReservaSalon" id="MesReservaSalon" class="form-control">
                                                </select>
                                            </div>
                                            <div class="col-md-2" id="AnioReservaSalonContainer">
                                                <select name="AnioReservaSalon" id="AnioReservaSalon" class="form-control">
                                                </select>
                                            </div>
                                            <div class="col-md-3" id="FechaInicioContainerReservaSalon">
                                                <input type="date" name="fechaInicioReservaSalon" id="fechaInicioReservaSalon" class="form-control">
                                            </div>
                                            <div class="col-md-3" id="FechaFinContainerReservaSalon">
                                                <input type="date" name="fechaFinReservaSalon" id="fechaFinReservaSalon" class="form-control">
                                            </div>
                                            <div class="col-md-2" id="FechaFinContainerReservaSalon">
                                                <select name="TipoReserva" id="TipoReserva" class="form-control">
                                                    <option value="TodoReserva">Estado Reserva</option>
                                                    <option value="Concluido">Concluido</option>
                                                    <option value="En Espera">En Espera</option>
                                                    <option value="Cancelado">Cancelado</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="Salones" id="Salones" class="form-control">
                                                    <option value="TodoSalones">Salones</option>
                                                </select>
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
                                                <div class="col-md-12" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                                    <span style="color: #7F8487; font-weight: bold;">Reservas existentes para esta fecha
                                                        <span style="color: #2C3333; font-weight: bold; font-size: 22px"id="SpanCantidad"></span>
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
                                            <div class="table-responsive" id="tabla-Reserva-salones">
                                                <table class="table table-vcenter card-table">
                                                        <thead>
                                                            <tr>
                                                            <th>Codigo Reserva</th>
                                                            <th>Salon</th>
                                                            <th>Fecha</th>
                                                            <th>Hora Inicio</th>
                                                            <th>Hora Fin</th>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-adelanto-reserva-salon" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Registrar Adelanto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="TipoAdelanto-salon">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input class="form-control" id="MontoAdelanto-salon">
                    </div>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btn-registrar-modal-adelanto-reserva-salon" data-bs-dismiss="modal">Registrar Adelanto</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-delete-ambiente-salon" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Eliminar Servicio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="">Detalle del por que borrara</label>
                <textarea class="form-control" id="ComentarioDeleteServicioSalon"></textarea>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn me-auto" id="btn-cancelar-delete-servicio-salon" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-registrar-delete-servicio-salon">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="ModalCerrarConsumoReservaSalon" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title">Pagar El Consumo</div>
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="ModalConsumoTipoPagoSelect">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" data-bs-dismiss="modal" id="btn-confirmar-modal-consumo-reserva-salon">Si, Enviar EL Pago</button>
        </div>
    </div>
    </div>
</div>

<style>
    .selected-row {
        background-color: #FFEEAD;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('utilidades/js/hostal/hospedajehabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/ocupadohabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/InputClass.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/reservassalones.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/OcupadoReservaSalon.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
