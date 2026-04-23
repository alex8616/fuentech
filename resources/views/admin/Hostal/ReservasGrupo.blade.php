<div class="card-header" id="card-reservas" style="width: 100%; background-color: white; display: flex; flex-wrap: wrap;">
    <div class="tab-pane" id="tabs-Grupo" role="tabpanel">
        <div class="card">
            <div class="card-header" style="width: 100%; background-color: #1d2736">
                <div class="row" style="width: 100%;">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title" style="color: white; font-weight: bold;">RESERVAS</h3>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align: right;">
                        <a class="btn" id="addreservasgrupo">+ Nueva Grupo</a>
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
                                                <select name="DateGrupo" id="DateGrupo" class="form-control">
                                                    <option value="DiarioGrupo">Diario</option>
                                                    <option value="MensualGrupo">Mensual</option>
                                                    <option value="AnualGrupo">Anual</option>
                                                    <option value="RangoGrupo">Rango</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1" id="DiaGrupoContainer">
                                                <select name="DiaGrupo" id="DiaGrupo" class="form-control">
                                                </select>
                                            </div>
                                            <div class="col-md-2" id="MesGrupoContainer">
                                                <select name="MesGrupo" id="MesGrupo" class="form-control">
                                                </select>
                                            </div>
                                            <div class="col-md-2" id="AnioGrupoContainer">
                                                <select name="AnioGrupo" id="AnioGrupo" class="form-control">
                                                </select>
                                            </div>
                                            <div class="col-md-3" id="FechaInicioContainerGrupo">
                                                <input type="date" name="fechaInicioGrupo" id="fechaInicioGrupo" class="form-control">
                                            </div>
                                            <div class="col-md-3" id="FechaFinContainerGrupo">
                                                <input type="date" name="fechaFinGrupo" id="fechaFinGrupo" class="form-control">
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
                                                    <span style="color: #7F8487; font-weight: bold;">Grupos existentes para esta fecha
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
                                            <div class="table-responsive" id="tabla-Grupo">
                                                <table class="table table-vcenter card-table">
                                                        <thead>
                                                            <tr>
                                                            <th>Codigo Grupo</th>
                                                            <th>Name Grupo</th>
                                                            <th>CheckIn</th>
                                                            <th>ChexkOut</th>
                                                            <th>Comentario</th>
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

<div class="modal modal-blur fade" id="modal-asiganar-habitacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Asignar Habitaciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="input-group mb-2" style="padding: 5px">
                        <select class="form-control" id="SelectHabitacionesGrupo" multiple="multiple" placeholder="Seleccion multiple…">
                        </select>
                        <button class="btn btn-primary ms-auto" id="btn-agregar-habitaciones-grupo">Agregar</button>
                    </div>

                    <div class="row" id="div-habitaciones">
                    
                    </div> 
                </div>
                <div class="col-12 col-sm-6">
                    <div id="div-habitaciones-form">

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Cancel
        </a>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="Modal-adelanto-grupo-list" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title">Adelanto Del Grupo</div>
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="ModalGrupoTipoPagoSelect">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Moneda</label>
                        <select class="form-control moneda" id="ModalGrupoTipoMonedaSelect">
                            <option value="Bs">Bs.</option>
                            <option value="Dolar">$</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input class="form-control" id="ModalGrupoMonto" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" data-bs-dismiss="modal" id="btn-confirmar-modal-adelanto-grupo-list">Si, Enviar EL Pago</button>
        </div>
    </div>
    </div>
</div>

<style>
    .selected-row {
        background-color: #FFEEAD;
    }

    #suggestions-list {
        position: absolute; 
        z-index: 999;
        background-color: white;
        width: 100%;
        border: 1px solid black; /* Borde temporal para verificar si la lista está en pantalla */
    }

    .select2-container {
        z-index: 9999 !important;
    }

</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('utilidades/js/hostal/hospedajehabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/reservasgrupos.js') }}" defer></script>
<script src="{{ asset('utilidades/js/InputClass.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
