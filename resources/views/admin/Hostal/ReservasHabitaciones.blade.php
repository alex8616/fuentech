<div class="card-header" id="card-reservas" style="width: 100%; background-color: white; display: flex; flex-wrap: wrap;">
    <div class="tab-pane" id="tabs-Reserva" role="tabpanel">
        <div class="card">
            <div class="card-header" style="width: 100%; background-color: #1d2736">
                <div class="row" style="width: 100%;">
                    <div class="col-12 col-sm-8">
                        <h3 class="card-title" style="color: white; font-weight: bold;">RESERVAS HABITACIONES <br> <span style="color: #28a745">concluido </span>  / <span style="color: #FFA500">espera</span>  /  <span style="color: #dc3545">cancelado</span> </h3>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align: right;">
                        <a class="btn" id="addreservas">+ Nueva Reserva</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id='calendar' style="width: 900px;"></div>
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
<script src="{{ asset('utilidades/js/hostal/reservashabitaciones.js') }}" defer></script>
<script src="{{ asset('utilidades/js/InputClass.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
