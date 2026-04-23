@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-novedades" class="nav-link" data-bs-toggle="tab" aria-selected="true" role="tab">NOVEDADES</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-caja-hostal" class="nav-link" data-bs-toggle="tab" aria-selected="true" role="tab">HOSTAL</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-caja-restaurante" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">RESTAURANTE</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-caja-tarjeta" class="nav-link" data-bs-toggle="tab" aria-selected="true" role="tab">TARJETA</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-caja-depositos" class="nav-link" data-bs-toggle="tab" aria-selected="true" role="tab">DEPOSITOS</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-dolar" class="nav-link" data-bs-toggle="tab" aria-selected="true" role="tab">DOLAR</a>
                </li>
            </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane" id="tabs-novedades" role="tabpanel">
                        <div class="card">
                            @include('admin.caja.Novedades')
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-caja-hostal" role="tabpanel">
                        <div class="card">
                            @include('admin.caja.CajaHostal')
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-caja-restaurante" role="tabpanel">
                        <div class="card">
                            @include('admin.caja.CajaRestaurante')
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-caja-tarjeta" role="tabpanel">
                        @include('admin.caja.CajaTarjeta')
                    </div>
                    <div class="tab-pane" id="tabs-caja-depositos" role="tabpanel">
                        @include('admin.caja.CajaDeposito')
                    </div>
                    <div class="tab-pane" id="tabs-dolar" role="tabpanel">
                        @include('admin.caja.CajaDolar')
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

<style>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
            updateUrl('#tabs-novedades');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
            CanvasTime();
        });
    });
</script>
@livewireScripts
