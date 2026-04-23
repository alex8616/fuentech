@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-12 col-sm-7">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-habitaciones" class="nav-link active" data-bs-toggle="tab" role="tab">AMBIENTES</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">RESERVAS</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#tabs-reservas-habitaciones" data-bs-toggle="tab" role="tab">Habitación</a>
                            <a class="dropdown-item" href="#tabs-reservas-salones" data-bs-toggle="tab" role="tab">Salón</a>
                        </div>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-reservas-grupos" class="nav-link" data-bs-toggle="tab" role="tab">GRUPOS</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#tabs-deudas-habitaciones" class="nav-link" data-bs-toggle="tab" role="tab">DEUDAS</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabs-habitaciones" role="tabpanel">
                        @include('admin.Hostal.Habitaciones')
                    </div>
                    <div class="tab-pane" id="tabs-reservas-habitaciones" role="tabpanel">
                        @include('admin.Hostal.ReservasHabitaciones')
                    </div>
                    <div class="tab-pane" id="tabs-reservas-salones" role="tabpanel">
                        @include('admin.Hostal.ReservasSalones')
                    </div>
                    <div class="tab-pane" id="tabs-reservas-grupos" role="tabpanel">
                        @include('admin.Hostal.ReservasGrupo')
                    </div>
                    <div class="tab-pane" id="tabs-deudas-habitaciones" role="tabpanel">
                        @include('admin.Hostal.DeudasHabitacion')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-5" style="margin: 0px; padding: 0px;">
        <div class="card" id="form_tabs">
            <div class="card-header">
                <h3 class="card-title">. . .</h3>
            </div>
            <div class="card-body">
                <div class="datagrid"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-select-habitacion-mandar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <select name="SelectHabitacionCambiar" id="SelectHabitacionCambiar"></select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-concluir-reserva">Pasar a la habitacion</button>
        </div>
    </div>
    </div>
</div>


<div class="modal modal-blur fade" id="modal-cancelar-reserva" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-danger"></div>
        <div class="modal-body text-center py-4">
        <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
        <h3>Estas seguro que deseas cancelar la reserva?</h3>
        <div class="text-muted">
            <textarea name="Textrazoncancelar" id="Textrazoncancelar" class="form-control" placeholder="Detalla del por que cancelaras"></textarea>
        </div>
        </div>
        <div class="modal-footer">
        <div class="w-100">
            <div class="row">
            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                Cancel
                </a></div>
            <div class="col">
                <a href="#" class="btn btn-danger w-100" data-bs-dismiss="modal" id="btn-cancelar-reserva">
                Confirmar
                </a>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

@endsection

@livewireStyles
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

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
            return window.location.href.split('#')[0];
        }

        function updateUrl(tabId) {
            if (tabId) {
                history.replaceState(null, null, getBaseUrl() + tabId);
            }
        }

        // Al cargar la página, si hay un hash en la URL, activa la pestaña correspondiente
        var currentHash = window.location.hash;
        if (currentHash) {
            $('.nav-tabs .nav-link[href="' + currentHash + '"], .dropdown-item[href="' + currentHash + '"]').tab('show');
        }

        // Evento para actualizar la URL cuando se cambia de pestaña o se selecciona un dropdown item
        $('.nav-tabs .nav-link, .dropdown-menu .dropdown-item').on('click', function(e) {
            var tabId = $(this).attr('href');
            if (tabId !== undefined) {
                e.preventDefault();
                updateUrl(tabId);
                // Cierra el menú desplegable al hacer clic en una opción
                $('.dropdown-menu').removeClass('show');
                $('.nav-item.dropdown .nav-link.dropdown-toggle').attr('aria-expanded', 'false');
            }
        });

        // Cierra cualquier menú desplegado al cargar la página
        $('.dropdown-menu').removeClass('show');
        $('.nav-item.dropdown .nav-link.dropdown-toggle').attr('aria-expanded', 'false');
    });
</script>
@livewireScripts
