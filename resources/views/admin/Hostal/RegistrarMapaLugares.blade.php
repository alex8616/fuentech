@extends('layouts.my-dashboard-layout')

@section('content')
<div class="row">
    <div class="col-12 col-sm-6">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-lugares" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Lugares Turisticos</a>
                </li>
            </ul>
            </div>
            <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active show" id="tabs-lugares" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">LUGARES TURISTICOS</h3>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right;">
                                    <a class="btn" style="padding-left: 25px;" id="addlugares"> 
                                        + Agregar
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
                                                        <div class="col-md-6">            
                                                            <input class="form-control" placeholder="Filtrar Por Lugar" id="searchclientehostal" name="searchclientehostal" style="margin-bottom: 10px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                    <div class="card" style="height: 600px; overflow-y: scroll;">
                                                        <div class="table-responsive" id="tabla-lugares">
                                                            <table class="table table-vcenter card-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Id</th>
                                                                        <th>Nombre</th>
                                                                        <th>Ubicacion</th>
                                                                        <th>Estado</th>
                                                                        <th>Fecha</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="clientes-tbody">
                                                                    <!-- Los datos de los clientes se cargarán aquí -->
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
    <div class="col-12 col-sm-6">
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

<div class="modal modal-blur fade" id="modal-delete-cuenta" tabindex="-1" role="dialog" aria-hidden="true">
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
                <div class="col"><a href="#" class="btn btn-danger w-100" data-bs-dismiss="modal" id="confirmDeleteBtnCuenta">
                    Borrar
                    </a></div>
                </div>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
<script src="{{ asset('utilidades/js/hostal/lugaresturisticos.js') }}" defer></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<style>
    #editor {
        height: 300px;
    }
    
    .ql-editor img {
        max-width: 100%; /* Ajusta al ancho del contenedor */
        height: auto;    /* Mantiene la proporción */
    }
    
    #tabla-lugares tbody tr:hover {
        background-color: #ffeeba;
    }
    #tabla-lugares tbody tr.selected-row {
        background-color: #ffeeba;
    }

    #tabla-lugares-salon tbody tr:hover {
        background-color: #ffeeba;
    }
    #tabla-lugares-salon tbody tr.selected-row {
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
            updateUrl('#tabs-lugares');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
        });
    });
</script>
@livewireScripts
