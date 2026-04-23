<div class="card-header" id="card-reservas" style="background-color: white; display: flex; flex-wrap: wrap;">
    <div class="card" style="width: 100%">
        <div class="card-header" style="background-color: #1d2736">
            <div class="col-12 col-sm-12">
                <h3 class="card-title" style="color: white; font-weight: bold;">DEUDAS DE LAS HABITACIONES</h3>
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
                                        <div class="table-responsive" id="tabla-Deudas">
                                            <table class="table table-vcenter card-table">
                                                    <thead>
                                                        <tr>
                                                        <th>Codigo Grupo</th>
                                                        <th>Habitacion</th>
                                                        <th>Clientes</th>
                                                        <th>CheckIn</th>
                                                        <th>ChexkOut</th>
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

<div class="modal modal-blur fade" id="modal-concluir-deuda-hospedaje" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Concluir Deuda Hospedaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-5">
                    <div class="card">
                        <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                            <h3 class="card-title">DETALLE HOSPEDAJE</h3>
                        </div>
                        <div class="card-body" style="margin: 4px; padding: 4px;">
                            <div id="MostradorListPagosDeuda">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                            <h3 class="card-title" style="margin: 0;">PAGO</h3>
                            <button id="MostradoraddPagosDeuda" class="btn btn-danger">+</button>
                        </div>
                        <div id="ListPagosDeuda" class="card-body" style="padding: 0px; margin: 0px">
                            
                        </div>
                        <div class="card-header" style="background: #1b293a; color: white; width: 100%; padding: 10px;">
                            <div id="MostradorlistVueltoDeuda">
                            
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btnConfirmarPagoDeuda">Save changes</button>
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
<script src="{{ asset('utilidades/js/hostal/deudahospedaje.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
