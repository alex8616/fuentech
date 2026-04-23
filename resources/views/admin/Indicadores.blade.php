@extends('layouts.my-dashboard-layout')

@section('content')
<div class="row">
    <div class="card-header" style="width: 100%; background-color: #1d2736">
        <div class="row" style="width: 100%;">
            <div class="col-12 col-sm-12" style="padding: 15px">
                <h3 class="card-title" style="color: white; font-weight: bold; font-size: 22px; text-align: center">REPORTES</h3>
            </div>
        </div>
    </div>

    <div class="row g-0" style="margin: 0; padding: 0;">
        <div class="col-12 col-md-2 border-end" style="background-color: #1d2736; height: 680px;">
            <div class="card-body">
                <div class="list-group list-group-transparent" style="padding: 18px;">
                    <a href="#" class="list-group-item list-group-item-action nav-link" data-tab="#tab-mesas" style="color: white; font-size: 19px; display: block;">
                        <span class="d-flex align-items-center">
                            Mesas
                        </span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action nav-link" data-tab="#tab-productos" style="color: white; font-size: 19px; display: block;">
                        <span class="d-flex align-items-center">
                            Productos
                        </span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action nav-link" data-tab="#tab-ventas" style="color: white; font-size: 19px; display: block;">
                        <span class="d-flex align-items-center">
                            Ventas
                        </span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action nav-link" data-tab="#tab-balance" style="color: white; font-size: 19px; display: block;">
                        <span class="d-flex align-items-center">
                            Reporte PDF
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-10 d-flex flex-column" style="padding: 25px;">
            <div id="tab-mesas" class="tab-content" style="display: none;">
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
                                        <select name="DateMesas" id="DateMesas" class="form-control">
                                            <option value="DiarioMesas">Diario</option>
                                            <option value="MensualMesas">Mensual</option>
                                            <option value="AnualMesas">Anual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="DiaMesasContainer">
                                        <select name="DiaMesas" id="DiaMesas" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="MesMesasContainer">
                                        <select name="MesMesas" id="MesMesas" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="AnioMesasContainer">
                                        <select name="AnioMesas" id="AnioMesas" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="AnioMesasContainer">
                                        <span id="generarPDFButton" class="badge bg-azure text-azure-fg" onclick="generarPDF()">Generar <br> PDF</span>
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
                                            <span style="color: #7F8487; font-weight: bold;"> 
                                                <span style="color: #2C3333; font-weight: bold;" id="TextoContenido"></span> 
                                            </span>
                                        </div>
                                        <div class="col-md-2" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                            <span style="color: #7F8487;">Mesas</span><br>
                                            <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="CantidadMesas"></span>
                                        </div>
                                        <div class="col-md-2" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                            <span style="color: #7F8487;">Promedio De Mesas</span><br>
                                            <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="PromedioMesas"></span>
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
                                    <div id="loadingMessage" style="display: none; text-align: center;">
                                        <p>Cargando datos, por favor espere...</p>
                                    </div>
                                    <div id="chartContainer" style="overflow-x: auto; white-space: nowrap;">
                                        <canvas id="ganttChartDiario"></canvas>
                                        <canvas id="ganttChartMensual"></canvas>
                                        <canvas id="ganttChartAnual"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab-productos" class="tab-content" style="display: none;">
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
                                        <div class="col-12 col-sm-7">
                                            <div id="chartContainerProductos" style="overflow-y: auto; white-space: nowrap;">
                                                <canvas id="GraficaDiarioProductos"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-5" style="padding: 20px">
                                            <table id="TableProductos" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Codigo</th>
                                                        <th>Producto</th>
                                                        <th>Ventas</th>
                                                        <th>Precio</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="TableProductosBody">
                                                    
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
            <div id="tab-ventas" class="tab-content" style="display: none;">
                Contenido Ventas
            </div>
            <div id="tab-balance" class="tab-content" style="display: none;">
                
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
<script src="{{ asset('utilidades/js/grafica-mesas.js') }}" defer></script>
<script src="{{ asset('utilidades/js/grafica-productos.js') }}" defer></script>
<script src="{{ asset('utilidades/js/grafica-ventas.js') }}" defer></script>
<script src="{{ asset('utilidades/js/grafica-balances.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0"></script>
<style>
    #chartContainer {
        overflow-x: auto;
        overflow-y: auto;
    }

    #chartContainer canvas {
        width: 100%;
    }
</style>
@livewireStyles
<script>
    $(document).ready(function() {
        $('.list-group-item').click(function(e) {
            e.preventDefault();
            $('.list-group-item').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').hide();
            var tabToShow = $(this).data('tab');
            $(tabToShow).show();
        });
    });
</script>
@livewireScripts
