@extends('layouts.my-dashboard-layout')

@section('content')

<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-caja-chica" class="nav-link" data-bs-toggle="tab" aria-selected="true" role="tab">CAJA CHICA</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-movimientos-chica" class="nav-link" data-bs-toggle="tab" aria-selected="true" role="tab">MOVIMIENTOS</a>
                </li>
            </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane" id="tabs-caja-chica" role="tabpanel">
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">MOVIMIENTOS</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <button  id="addcajachica" class="btn position-relative">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="row">
                                            <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                                                <div class="row" style="background: #F5F7F8;">
                                                    <div class="col-md-11">
                                                        <div class="row" style="padding-bottom: 10px">
                                                            <div class="col-md-3">
                                                                <select name="DateCajaChica" id="DateCajaChica" class="form-control">
                                                                    <option value="DiarioCajaChica">Diario</option>
                                                                    <option value="MensualidadCajaChica">Todo El Mes</option>
                                                                    <option value="RangoCajaChica">Rango</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2" id="DiaCajaChicaContainer">
                                                                <select name="DiaCajaChica" id="DiaCajaChica" class="form-control">
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3" id="MesCajaChicaContainer">
                                                                <select name="MesCajaChica" id="MesCajaChica" class="form-control">
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3" id="AnioCajaChicaContainer">
                                                                <select name="AnioCajaChica" id="AnioCajaChica" class="form-control">
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3" id="FechaInicioContainerCajaChica">
                                                                <input type="date" name="fechaInicioCajaChica" id="fechaInicioCajaChica" class="form-control">
                                                            </div>
                                                            <div class="col-md-3" id="FechaFinContainerCajaChica">
                                                                <input type="date" name="fechaFinCajaChica" id="fechaFinCajaChica" class="form-control">
                                                            </div><br><br><br>
                                                            <div class="col-md-11">
                                                                <input type="text" name="searchcajachica" id="searchcajachica" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="row" style="padding-bottom: 10px; text-align: end;">
                                                            <span class="badge bg-blue" style="padding: 10px; width: 50%; cursor: pointer;" id="btn-refrescar-tabla-restaurante">
                                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-reload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12">
                                                        <div class="card">
                                                            <div class="table-responsive" style="overflow-y: scroll; max-height: 500px">
                                                                <table class="table table-vcenter card-table" id="tabla-caja-CajaChica">
                                                                    <thead style="position: sticky; top: 0; z-index: 1;">
                                                                        <tr>
                                                                        <th>N°</th>
                                                                        <th>Codigo</th>
                                                                        <th>Nombre Atributo</th>
                                                                        <th>Descripcion</th>
                                                                        <th>Fecha Registro</th>
                                                                        <th>Ingreso</th>
                                                                        <th>Egreso</th>
                                                                        <th>Sumatoria</th>
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

                    <div class="tab-pane" id="tabs-movimientos-chica" role="tabpanel">
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">MOVIMIENTOS</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <button  id="addcajachica" class="btn position-relative">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                                                       
                                </div>
                            </div>
                        </div>
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
    .selected-row {
        background-color: #ffeeba;
        color: #000;
    }
</style>

@livewireStyles
<script src="{{ asset('utilidades/js/InputClass.js') }}" defer></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() { 

        $('#searchcajachica').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $("#tabla-caja-CajaChica tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

    });
</script>
@livewireScripts
