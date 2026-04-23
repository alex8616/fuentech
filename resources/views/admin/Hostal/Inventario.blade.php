@extends('layouts.my-dashboard-layout')

@section('content')
<div class="row">
    <div class="col-12 col-sm-8">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#tabs-categoria" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Categoria</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#tabs-articulo" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Articulo</a>
                </li>           
            </ul>
            </div>
            <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane" id="tabs-categoria" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">CATEGORIAS</h3>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right;">
                                    <a class="btn" style="padding-left: 25px;" id="addcategoria"> 
                                        + Categoria
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
                                                <div class="col-md-8">
                                                    <div class="row" style="padding-bottom: 10px">
                                                        <div class="col-md-6">
                                                           <input class="form-control" placeholder="Filtrar Por Categoria" id="searchcategoria" name="searchcategoria" style="margin-bottom: 10px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                    <div class="card" style="height: 600px; overflow-y: scroll;">
                                                        <div class="table-responsive">
                                                            <table class="table table-vcenter card-table" id="tabla-registrar-categoria">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nombre</th>
                                                                        <th>Descripcion</th>
                                                                        <th>Pertenece</th>
                                                                        <th>Fecha</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- Datos se cargarán aquí -->
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
                <div class="tab-pane" id="tabs-articulo" role="tabpanel">
                    <div class="card">
                        <div class="card-header" style="width: 100%; background-color: #1d2736">
                            <div class="row" style="width: 100%;">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: white; font-weight: bold;">ARTICULOS</h3>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right;">
                                    <a class="btn" style="padding-left: 25px;" id="addarticulo"> 
                                        + Articulo
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
                                                <div class="col-md-12">
                                                    <div class="row" style="padding-bottom: 10px">
                                                        <div class="col-md-4">
                                                           <input class="form-control" placeholder="Filtrar Por Articulo" id="searcharticulo" name="searcharticulo" style="margin-bottom: 10px;">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-control" id="AllCategoriaSelect"></select>
                                                        </div>
                                                        <div class="col-md-3" hidden>
                                                            <select class="form-control" id="AllTipoSelect">
                                                                <option value="Todo">Todo</option>
                                                                <option value="Hostal">Hostal</option>
                                                                <option value="Restaurante">Restaurante</option>
                                                                <option value="Otros">Otros</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a href="#" class="btn btn-facebook w-100" id="btnExportarPDF">
                                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-notes"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M9 7l6 0" /><path d="M9 11l6 0" /><path d="M9 15l4 0" /></svg>
                                                                Export PDF
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a href="#" class="btn btn-facebook w-100" id="btnExportarPDFCompleto">
                                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-notes"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M9 7l6 0" /><path d="M9 11l6 0" /><path d="M9 15l4 0" /></svg>
                                                                Export PDF Completo
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                                            <div class="row">
                                                <div class="col-12 col-sm-12">
                                                    <div class="card" style="height: 600px; overflow-y: scroll;">
                                                        <div class="table-responsive">
                                                            <table class="table table-vcenter card-table" id="tabla-articulo">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Descripcion</th>
                                                                        <th>Nombre</th>
                                                                        <th>Cant</th>
                                                                        <th>Color</th>
                                                                        <th>Ubicacion</th>
                                                                        <th>Estado</th>
                                                                        <th>Clasificacion</th>
                                                                        <th>Marca</th>
                                                                        <th>Observaciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- Datos se cargarán aquí -->
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
    <div class="col-12 col-sm-4">
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

<!-- Modal -->
<div class="modal modal-blur fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <img id="modalImage" src="" alt="Imagen" class="img-fluid" style="max-height: 500px; object-fit: cover;">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>


<div class="modal modal-blur fade" id="UpdateImagen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title">Actualizar Imagen</h5>
                <input type="file" class="form-control" id="UpdateImagenRecurso" name="UpdateImagenRecurso" multiple accept="image/*">
                <div id="ImagePreviewContainer" class="mt-3">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="ActualizarImageLista">Guardar Imagen</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="ModalIngreso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingreso Articulo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="text" class="form-control convertirnumero" id="CantidadIngreso">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-control" id="EstadoIngreso">
                            <option value="Buen Estado">Buen Estado</option>
                            <option value="Daniado">Daniado</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea class="form-control convertirmayuscula" rows="5" id="DescripcionIngreso"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal" id="CerrarIngresoInventario">Cerrar</button>
                <button type="button" class="btn btn-primary" id="RegistrarIngresoInventario">Registrar Ingreso</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="ModalSalida" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Salida Articulo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="text" class="form-control convertirnumero" id="CantidadSalida">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-control" id="EstadoSalida">
                            <option value="Desecho">Desecho</option>
                            <option value="Perdido">Perdido</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea class="form-control convertirmayuscula" rows="5" id="DescripcionSalida"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal" id="CerrarSalidaInventario">Cerrar</button>
                <button type="button" class="btn btn-primary" id="RegistrarSalidaInventario">Registrar Salida</button>
            </div>
        </div>
    </div>
</div>
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('utilidades/js/inventario/categoriainventario.js') }}" defer></script>
<script src="{{ asset('utilidades/js/inventario/articuloinventario.js') }}" defer></script>

<style>
    .selected-row {
        background-color: #ffeeba;
    }
</style>
@livewireStyles
<script>
    
    function convertirMayusculas() {
        document.querySelectorAll('.convertirmayuscula').forEach(element => {
            element.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    }

    function convertirEntero() {
        document.querySelectorAll('.convertirnumero').forEach(element => {
            element.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, ''); 
            });
        });
    }

    $(document).ready(function() {
        convertirMayusculas()
        convertirEntero() 

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
            updateUrl('#tabs-inventario');
        });

        $('.nav-tabs .nav-link').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            updateUrl(tabId);
        });
    });
</script>
@livewireScripts
