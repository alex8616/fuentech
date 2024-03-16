@extends('layouts.my-dashboard-layout')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-8">
            <div class="card">
                <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-productos" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Productos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-ingredientes" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Ingredientes</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-modificadores" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Modificadores</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-cantegoriaproductos" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Categoria Productos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-cantegoriaingredientes" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Categoria Ingredientes</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-controlstock" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Control Stock</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-movimientossotck" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Movimiento Stock</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a href="#tabs-listaprecios" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Lista Precios</a>
                    </li>
                </ul>
                </div>
                <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabs-productos" role="tabpanel">
                        <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">PRODUCTOS</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <a class="btn" id="addproductos">+ PRODUCTOS</a>
                                        <a class="btn" id="exportproductos" style="padding-left: 25px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color: #303847">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="row">
                                            <div class="col-12 col-sm-4" id="all_productos" style="padding: 25px;">
                                                <div class="list-group list-group-transparent mb-3" id="listarcategorias">
                                                   
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-8" id="listarproductos" style="background: white; padding-top: 10px; padding-bottom: 10px">
                                                <div id="lista_productos">
                                                    <div class="mb-3 row">
                                                        <label class="col-4 col-form-label"> 
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" /><path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" /><path d="M18.5 19.5l2.5 2.5" /></svg>    
                                                            Filtrar por producto: </label>
                                                        <div class="col-7">
                                                        <input type="text" class="form-control" id="SearchProduct" name="SearchProduct">
                                                        </div>
                                                        <div class="col-1" style="padding-top: 10px;">
                                                            <label class="form-check form-switch">
                                                            <input class="form-check-input" id="checkMostrar" type="checkbox">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="table-responsive" id="tabla-productos">
                                                            <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                <th>Codigo</th>
                                                                <th>Producto</th>
                                                                <th>Costo</th>
                                                                <th>Margen</th>
                                                                <th>Precio</th>
                                                                <th class="w-1"></th>
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
                    <div class="tab-pane" id="tabs-ingredientes" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-modificadores" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-cantegoriaproductos" role="tabpanel">
                    <div class="card">
                            <div class="card-header" style="width: 100%; background-color: #1d2736">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white; font-weight: bold;">CATEGORIAS</h3>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <a class="btn" id="addpcategorias">+ CATEGORIA</a>
                                        <a class="btn" id="exportproductos" style="padding-left: 25px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-share" width="24" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 19h-8a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="background-color: #303847">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="row">
                                            <div class="col-12 col-sm-12" style="background: white; padding-top: 10px; padding-bottom: 10px">
                                                <div id="lista_categorias">
                                                    <div class="card">
                                                        <div class="table-responsive" id="tabla-categorias">
                                                            <table class="table table-vcenter card-table">
                                                            <thead>
                                                                <tr>
                                                                <th>Nombre</th>
                                                                <th>Cocina</th>
                                                                <th>Productos</th>
                                                                <th class="w-1"></th>
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
                    <div class="tab-pane" id="tabs-cantegoriaingredientes" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="tab-pane" id="tabs-controlstock" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="tab-pane" id="tabs-movimientossotck" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-listaprecios" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Base info</h3>
                            </div>
                            <div class="card-body">
                                <div class="datagrid">
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">Registrar</div>
                                        <div class="datagrid-content">Third Party</div>
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


    <div class="modal modal-blur fade" id="modal-image" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" class="form-control" id="ProductoImagenUpdate" name="ProductoImagenUpdate">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-cambiar-img" data-producto-id="1">Cambiar Imagen</button>
                </div>
            </div>
        </div>
    </div>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="{{ asset('utilidades/js/productos.js') }}" defer></script>
<style>
    #tabla-productos .categoria-fila:hover {
        background-color: #FE8F8F;
    }
    #tabla-productos .categoria-fila.selected {
        background-color: #FE8F8F;
    }
    .selected {
        background-color: #FF0303;
    }
    .star-label {
        cursor: pointer;
    }
    #checkbox-1:checked + .star-label .icon-1 {
        color: gold;
    }

    .boton-registrar-favorito-sip {
        color: #007bff;
    }

    .fila-tachada td {
        text-decoration: line-through;
        color: #7077A1;
    }
    .seleccionado {
        background-color: #ffc0c8;
    }

    .seleccionadosub {
        background-color: #ffe9ec;
    }

    .selectedlist {
        background-color: red;
    }

    /* Estilos para la lista de subcategorías */
    .subcategorias-lista {
        list-style: none;
        padding-left: 0;
    }

    /* Estilos para los elementos de subcategoría */
    .subcategoria-item {
        padding: 10px 10px;
        background-color: #f9f9f9;
        color: #333;
        cursor: pointer;
    }

    /* Estilos para los elementos de subcategoría al pasar el ratón */
    .subcategoria-item:hover {
        background-color: #ffc0c8;
    }
</style>
@livewireStyles
<script>
    $(document).ready(function() {  
        MostrarTablaCategoria();

        document.getElementById('addpcategorias').addEventListener('click', function() {
            cargarCategorias();
            var formTabsDiv = document.getElementById('form_tabs');
            formTabsDiv.innerHTML = `
            <form id="form-register-product">
                <div class="card-header">
                    <h3 class="card-title">Registrar Producto</h3>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Nombre</label>
                            <div class="col">
                            <input type="text" class="form-control" id="CategoriaNombre" name="CategoriaNombre">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Cocina</label>
                            <div class="col">
                            <select class="form-select" id="CategoriaCocina" name="CategoriaCocina">
                                
                            </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-3 col-form-label pt-0">App Comensal</label>
                            <div class="col">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" id="CheckAppComensal" name="CheckAppComensal">
                            </label>
                            </div>
                        </div><br>
                        <div class="row">
                            <label class="col-3 col-form-label pt-0">Menu Online</label>
                            <div class="col">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" id="CheckMenuOnline" name="CheckMenuOnline">
                            </label>
                            </div>
                        </div><br>
                        <div class="row">
                            <label class="col-3 col-form-label pt-0">Carta QR</label>
                            <div class="col">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" id="CheckCartaQR" name="CheckCartaQR">
                            </label>
                            </div>
                        </div><br>
                    </div>                    
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="btn-registrar-categoria">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;

            $.ajax({
                url: '/api/get-cocinas',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#CategoriaCocina');
                    select.empty();
                    select.append($('<option></option>'));
                    $.each(data, function(index, cocina) {
                        select.append($('<option></option>').attr('value', cocina.id).text(cocina.Nombre_Cocina));
                    });
                },
                error: function(error) {
                    console.error('Error al recuperar datos de categorías:', error);
                }
            });

            $('#ProductoCategoria').change(function() {
                var categoriaSeleccionada = $(this).val();
                if (categoriaSeleccionada) {
                    cargarSubcategorias(categoriaSeleccionada);
                    $('#ProductoSubCategoria').parent().show();
                } else {
                    $('#ProductoSubCategoria').parent().hide();
                }
            });

            $('#btn-registrar-categoria').off('click').on('click', function(event) {
                // Obtener los valores de los otros campos del formulario
                var Nombre = $("#CategoriaNombre").val();
                var cocina = $("#CategoriaCocina").val();
                var appcomensal = $("#CheckAppComensal").prop('checked');
                var menuonline = $("#CheckMenuOnline").prop('checked');
                var cartaqr = $("#CheckCartaQR").prop('checked');

                // Crear un objeto FormData para enviar los datos del formulario
                var formData = new FormData();
                formData.append('Nombre', Nombre);
                formData.append('Cocina', cocina);
                formData.append('AppComensal', appcomensal);
                formData.append('MenuOnline', menuonline);
                formData.append('CartaQR', cartaqr);

                // Realizar la solicitud AJAX
                $.ajax({
                    url: '/api/registrar-categoria',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false, 
                    success: function (categoria) {
                        MostrarTablaCategoria();
                        MostrarCategoria();
                        MostrarMensaje("Cocina Creada Exitosamente", "success");
                        $("#CategoriaNombre").val("");
                        $("#CategoriaCocina").val("");
                        $("#CheckAppComensal").prop('checked', false);
                        $("#CheckMenuOnline").prop('checked', false);
                        $("#CheckCartaQR").prop('checked', false);
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });

        });
    });

    function MostrarTablaCategoria(){        
        $.ajax({
            url: 'api/get-categorias',
            type: 'GET',
            dataType: 'json',
            success: function(categorias) {
                if (categorias.length > 0) {
                    actualizarCategoriaTabla();
                    function actualizarCategoriaTabla() {
                        console.log(categorias)
                        var tablaCategorias = $('#tabla-categorias tbody');
                        tablaCategorias.empty();
                        $.each(categorias, function(index, categoria) {
                            var filaCategoria = '<tr class="categoria-fila" data-categoria-id="' + categoria.id + '">' +
                                                    '<td style="font-weight: bold;">' + categoria.Nombre_categoria + '</td>' +
                                                    '<td style="font-weight: bold;">' + (categoria.cocina ? categoria.cocina.Nombre_Cocina : '-') + '</td>' +
                                                    '<td style="font-weight: bold;">' + categoria.productos_count + '</td>' +
                                                    '<td style="font-weight: bold;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg></td>' +
                                                '</tr>';
                            tablaCategorias.append(filaCategoria);

                            if (categoria.subcategorias && categoria.subcategorias.length > 0) {
                                $.each(categoria.subcategorias, function(subindex, subcategoria) {
                                    var filaSubcategoria = '<tr class="subcategoria-fila" data-subcategoria-id="' + subcategoria.id + '">' +
                                                                '<td  style="color: #6C7B95"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8v8h8" /></svg>' + subcategoria.Nombre_subcategoria + '</td>' +
                                                                '<td style="color: #6C7B95">' + (subcategoria.cocina_id ? subcategoria.cocina.Nombre_Cocina : '-') + '</td>' +
                                                                '<td  style="color: #6C7B95">' + categoria.productos_count + '</td>' +
                                                                '<td  style="color: #6C7B95"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg></td>' +
                                                            '</tr>';
                                    tablaCategorias.append(filaSubcategoria);
                                });
                            }
                        });


                        $('.categoria-fila').on('click', function() {
                            $('.categoria-fila').removeClass('seleccionado');
                            $('.subcategoria-fila').removeClass('seleccionadosub');
                            $(this).addClass('seleccionado');
                            var categoriaID = $(this).data('categoria-id');
                            $.ajax({
                                url: '/api/get-categoria-seleccionado/' + categoriaID,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    var CategoriaDivs = document.getElementById('form_tabs');
                                    CategoriaDivs.innerHTML = ``;
                                    CategoriaDivs.innerHTML = `
                                    <form id="form-register-product">
                                        <div class="card-header">
                                            <h3 class="card-title">${data.Nombre_categoria}</h3>
                                            <div class="card-actions">
                                            <a href="#" class="btn" data-categoria-id="${data.id}" id="EditarCategoria">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                                            </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Nombre</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.Nombre_categoria}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Cocina</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.cocina_id != null ? data.cocina.Nombre_Cocina : 'sin cocina'}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">App Comensal</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.AppComensal == 'true' ? 'Si' : 'No'}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Menu Online</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.MenuOnline == 'true' ? 'Si' : 'No'}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Carta QR</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.CartaQR == 'true' ? 'Si' : 'No'}</label>
                                                    </div>
                                                </div>
                                            </div>                    
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex" style="text-align: right">
                                                <button type="button" class="btn btn-primary" id="btn-registrar-subcategoria" data-categoria-id="${categoriaID}">Agregar Sub - Categoria</button>
                                            </div>
                                        </div>
                                    </form>
                                    `;

                                    $('#EditarCategoria').off('click').on('click', function(event) {
                                        var id = this.getAttribute('data-categoria-id');
                                        var CategoriaDivs = document.getElementById('form_tabs');
                                        CategoriaDivs.innerHTML = ``;
                                        CategoriaDivs.innerHTML = `
                                        <form id="form-register-product">
                                            <div class="card-header">
                                                <h3 class="card-title">Editando ${data.Nombre_categoria}</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-body">
                                                    <div class="mb-12 row">
                                                        <label class="col-4 col-form-label" style="font-weight: bold;">Nombre</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" id="UpdateNombre_categoria" name="UpdateNombre_categoria" value="${data.Nombre_categoria}">
                                                        </div>
                                                    </div><br>
                                                    <div class="mb-12 row">
                                                        <label class="col-4 col-form-label" style="font-weight: bold;">Cocina</label>
                                                        <div class="col">
                                                        <select id="categoriaCocinaSelect" class="form-control">

                                                        </select>
                                                        </div>
                                                    </div><br>
                                                    <div class="mb-12 row">
                                                        <label class="col-4 col-form-label" style="font-weight: bold">App Comensal</label>
                                                        <div class="col">
                                                            <select id="UpdateAppComensal" name="UpdateAppComensal" class="form-control">
                                                                <option value="true">Habilitado</option>
                                                                <option value="false">Deshabilitado</option>
                                                            </select>
                                                        </div>
                                                    </div><br>
                                                    <div class="mb-12 row">
                                                        <label class="col-4 col-form-label" style="font-weight: bold">Menu Online</label>
                                                        <div class="col">
                                                            <select id="UpdateMenuOnline" name="UpdateMenuOnline" class="form-control">
                                                                <option value="true">Habilitado</option>
                                                                <option value="false">Deshabilitado</option>
                                                            </select>
                                                        </div>
                                                    </div><br>
                                                    <div class="mb-12 row">
                                                        <label class="col-4 col-form-label" style="font-weight: bold">Carta Qr</label>
                                                        <div class="col">
                                                            <select id="UpdateCartaQr" name="UpdateCartaQr" class="form-control">
                                                                <option value="true">Habilitado</option>
                                                                <option value="false">Deshabilitado</option>
                                                            </select>
                                                        </div>
                                                    </div><br>
                                                </div>                    
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex" style="text-align: right">
                                                    <button type="button" class="btn me-auto">CANCELAR</button>
                                                    <button type="button" class="btn btn-primary" id="btn-actualizar-categoria">ACTUALIZAR</button>
                                                </div>
                                            </div>
                                        </form>
                                        `;

                                        var cocinaId = data.cocina_id;
                                        $.ajax({
                                            url: 'api/get-cocinas',
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(cocinas) {
                                                var select = $('#categoriaCocinaSelect');
                                                select.empty();
                                                select.append($('<option></option>').attr('value', null).text('Seleccione una cocina'));
                                                $.each(cocinas, function(index, cocina) {
                                                    select.append($('<option></option>').attr('value', cocina.id).text(cocina.Nombre_Cocina));
                                                }); 
                                                $('#categoriaCocinaSelect').val(cocinaId).change();
                                            },
                                            error: function(error) {
                                                console.error('Error al recuperar datos de categorías:', error);
                                            }
                                        });

                                        var appcomensal = data.AppComensal;
                                        $('#UpdateAppComensal').val(appcomensal).change();
                                        var cartaqr = data.CartaQR;
                                        $('#UpdateCartaQr').val(cartaqr).change();
                                        var menuonline = data.MenuOnline;
                                        $('#UpdateMenuOnline').val(menuonline).change();

                                        $('#btn-actualizar-categoria').off('click').on('click', function(event) {
                                            var EditNombre = $("#UpdateNombre_categoria").val();
                                            var Editcocina = $("#categoriaCocinaSelect").val();
                                            var Editappcomensal = $("#UpdateAppComensal").val();
                                            var Editmenuonline = $("#UpdateMenuOnline").val();
                                            var Editcartaqr = $("#UpdateCartaQr").val();

                                            var datosRecogidos = {
                                                id: id,
                                                nombre: EditNombre,
                                                cocina_id: Editcocina,
                                                appcomensal: Editappcomensal,
                                                menuonline: Editmenuonline,
                                                cartaqr: Editcartaqr
                                            };

                                            $.ajax({
                                                url: '/api/actualizar-categoria/',
                                                type: 'POST',
                                                data: datosRecogidos,
                                                success: function (producto) {
                                                    CanvasTime();
                                                    MostrarTablaCategoria();
                                                    MostrarCategoria();
                                                    MostrarMensaje("Se Actualizo La Categoria Exitosamente", "success");
                                                },
                                                error: function (error) {
                                                    console.error('Error al registrar:', error);
                                                }
                                            });
                                        });
                                    });                                                                                                        
                                    
                                    const btnRegistrarSubcategoria = document.getElementById('btn-registrar-subcategoria');
                                    btnRegistrarSubcategoria.addEventListener('click', function() {
                                        const categoriaID = this.getAttribute('data-categoria-id');
                                        var SubCategoriaDivs = document.getElementById('form_tabs');
                                        SubCategoriaDivs.innerHTML = ``;
                                        SubCategoriaDivs.innerHTML = `
                                        <form id="form-register-product">
                                            <div class="card-header">
                                                <h3 class="card-title" style="color: blue"> se registrara sub categoria a ${data.Nombre_categoria}</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-body">
                                                    <div class="mb-12 row">
                                                        <label class="col-3 col-form-label" style="font-weight: bold;">Nombre Categoria Padre</label>
                                                        <div class="col">
                                                        <label class="col-9 col-form-label">${data.Nombre_categoria}</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-3 col-form-label required">Nombre Sub Categoria</label>
                                                        <div class="col">
                                                        <input type="text" class="form-control" id="SubCategoriaNombre" name="SubCategoriaNombre">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-3 col-form-label required">Cocina</label>
                                                        <div class="col">
                                                        <select class="form-select" id="SubCategoriaCocina" name="SubCategoriaCocina">
                                                            
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-3 col-form-label pt-0">App Comensal</label>
                                                        <div class="col">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="SubCheckAppComensal" name="SubCheckAppComensal">
                                                        </label>
                                                        </div>
                                                    </div><br>
                                                    <div class="row">
                                                        <label class="col-3 col-form-label pt-0">Menu Online</label>
                                                        <div class="col">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="SubCheckMenuOnline" name="SubCheckMenuOnline">
                                                        </label>
                                                        </div>
                                                    </div><br>
                                                    <div class="row">
                                                        <label class="col-3 col-form-label pt-0">Carta QR</label>
                                                        <div class="col">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="SubCheckCartaQR" name="SubCheckCartaQR">
                                                        </label>
                                                        </div>
                                                    </div><br>
                                                </div>                    
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex" style="text-align: right">
                                                    <button type="button" class="btn me-auto">CANCELAR</button>
                                                    <button type="button" class="btn btn-primary" id="btn-enviar-subcategoria">GUARDAR</button>
                                                </div>
                                            </div>
                                        </form>
                                        `;

                                        $.ajax({
                                            url: '/api/get-cocinas',
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(data) {
                                                var select = $('#SubCategoriaCocina');
                                                select.empty();
                                                select.append($('<option></option>'));
                                                $.each(data, function(index, cocina) {
                                                    select.append($('<option></option>').attr('value', cocina.id).text(cocina.Nombre_Cocina));
                                                });
                                            },
                                            error: function(error) {
                                                console.error('Error al recuperar datos de categorías:', error);
                                            }
                                        });

                                        $('#btn-enviar-subcategoria').off('click').on('click', function(event) {
                                            // Obtener los valores de los otros campos del formulario
                                            var Nombre = $("#SubCategoriaNombre").val();
                                            var cocina = $("#SubCategoriaCocina").val();
                                            var appcomensal = $("#SubCheckAppComensal").prop('checked');
                                            var menuonline = $("#SubCheckMenuOnline").prop('checked');
                                            var cartaqr = $("#SubCheckCartaQR").prop('checked');
                                            var categoriaId = categoriaID;
                                            // Crear un objeto FormData para enviar los datos del formulario
                                            var formData = new FormData();
                                            formData.append('Nombre', Nombre);
                                            formData.append('Cocina', cocina);
                                            formData.append('AppComensal', appcomensal);
                                            formData.append('MenuOnline', menuonline);
                                            formData.append('CartaQR', cartaqr);
                                            formData.append('Categoria', categoriaId);
                                            // Realizar la solicitud AJAX
                                            $.ajax({
                                                url: '/api/registrar-subcategoria',
                                                type: 'POST',
                                                data: formData,
                                                contentType: false,
                                                processData: false, 
                                                success: function (categoria) {
                                                    MostrarTablaCategoria();
                                                    MostrarCategoria();
                                                    MostrarMensaje("Cocina Creada Exitosamente", "success");
                                                    $("#SubCategoriaNombre").val("");
                                                    $("#SubCategoriaCocina").val("");
                                                    $("#SubCheckAppComensal").prop('checked', false);
                                                    $("#SubCheckMenuOnline").prop('checked', false);
                                                    $("#SubCheckCartaQR").prop('checked', false);
                                                },
                                                error: function (error) {
                                                    console.error('Error al registrar:', error);
                                                }
                                            });
                                        });
                                    });
                                },
                                error: function(error) {
                                    console.error('Error al recuperar datos de producto:', error);
                                }
                            });
                        });

                        $('.subcategoria-fila').on('click', function() {
                            $('.subcategoria-fila').removeClass('seleccionadosub');
                            $('.categoria-fila').removeClass('seleccionado');
                            $(this).addClass('seleccionadosub');
                            var categoriaID = $(this).data('subcategoria-id');
                            $.ajax({
                                url: '/api/get-subcategoria-seleccionado/' + categoriaID,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    var CategoriaDivs = document.getElementById('form_tabs');
                                    CategoriaDivs.innerHTML = ``;
                                    CategoriaDivs.innerHTML = `
                                    <form id="form-register-product">
                                        <div class="card-header">
                                            <h3 class="card-title">${data.Nombre_subcategoria}</h3>
                                            <div class="card-actions">
                                            <a href="#" class="btn" data-subcategoria-id="${data.id}" id="EditarSubCategoria">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                                            </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Categoria</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.categoria.Nombre_categoria}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Nombre</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.Nombre_subcategoria}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Cocina</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.cocina_id != null ? data.cocina.Nombre_Cocina : 'sin cocina'}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">App Comensal</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.AppComensal == 'true' ? 'Si' : 'No'}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Menu Online</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.MenuOnline == 'true' ? 'Si' : 'No'}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Carta QR</label>
                                                    <div class="col">
                                                    <label class="col-9 col-form-label">${data.AppComensal == 'true' ? 'Si' : 'No'}</label>
                                                    </div>
                                                </div>
                                            </div>                    
                                        </div>
                                    </form>
                                    `;

                                    $('#EditarSubCategoria').off('click').on('click', function(event) {
                                        var id = this.getAttribute('data-subcategoria-id');
                                        alert(id)
                                    });

                                    const btnRegistrarSubcategoria = document.getElementById('btn-registrar-subcategoria');
                                    btnRegistrarSubcategoria.addEventListener('click', function() {
                                        const categoriaID = this.getAttribute('data-categoria-id');
                                        var SubCategoriaDivs = document.getElementById('form_tabs');
                                        SubCategoriaDivs.innerHTML = ``;
                                        SubCategoriaDivs.innerHTML = `
                                        <form id="form-register-product">
                                            <div class="card-header">
                                                <h3 class="card-title" style="color: blue"> se registrara sub categoria a ${data.Nombre_categoria}</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-body">
                                                    <div class="mb-12 row">
                                                        <label class="col-3 col-form-label" style="font-weight: bold;">Nombre Categoria Padre</label>
                                                        <div class="col">
                                                        <label class="col-9 col-form-label">${data.Nombre_categoria}</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-3 col-form-label required">Nombre Sub Categoria</label>
                                                        <div class="col">
                                                        <input type="text" class="form-control" id="SubCategoriaNombre" name="SubCategoriaNombre">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-3 col-form-label required">Cocina</label>
                                                        <div class="col">
                                                        <select class="form-select" id="SubCategoriaCocina" name="SubCategoriaCocina">
                                                            
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-3 col-form-label pt-0">App Comensal</label>
                                                        <div class="col">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="SubCheckAppComensal" name="SubCheckAppComensal">
                                                        </label>
                                                        </div>
                                                    </div><br>
                                                    <div class="row">
                                                        <label class="col-3 col-form-label pt-0">Menu Online</label>
                                                        <div class="col">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="SubCheckMenuOnline" name="SubCheckMenuOnline">
                                                        </label>
                                                        </div>
                                                    </div><br>
                                                    <div class="row">
                                                        <label class="col-3 col-form-label pt-0">Carta QR</label>
                                                        <div class="col">
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="SubCheckCartaQR" name="SubCheckCartaQR">
                                                        </label>
                                                        </div>
                                                    </div><br>
                                                </div>                    
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex" style="text-align: right">
                                                    <button type="button" class="btn me-auto">CANCELAR</button>
                                                    <button type="button" class="btn btn-primary" id="btn-enviar-subcategoria">GUARDAR</button>
                                                </div>
                                            </div>
                                        </form>
                                        `;

                                        $.ajax({
                                            url: '/api/get-cocinas',
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(data) {
                                                var select = $('#SubCategoriaCocina');
                                                select.empty();
                                                select.append($('<option></option>'));
                                                $.each(data, function(index, cocina) {
                                                    select.append($('<option></option>').attr('value', cocina.id).text(cocina.Nombre_Cocina));
                                                });
                                            },
                                            error: function(error) {
                                                console.error('Error al recuperar datos de categorías:', error);
                                            }
                                        });

                                        $('#btn-enviar-subcategoria').off('click').on('click', function(event) {
                                            // Obtener los valores de los otros campos del formulario
                                            var Nombre = $("#SubCategoriaNombre").val();
                                            var cocina = $("#SubCategoriaCocina").val();
                                            var appcomensal = $("#SubCheckAppComensal").prop('checked');
                                            var menuonline = $("#SubCheckMenuOnline").prop('checked');
                                            var cartaqr = $("#SubCheckCartaQR").prop('checked');
                                            var categoriaId = categoriaID;
                                            // Crear un objeto FormData para enviar los datos del formulario
                                            var formData = new FormData();
                                            formData.append('Nombre', Nombre);
                                            formData.append('Cocina', cocina);
                                            formData.append('AppComensal', appcomensal);
                                            formData.append('MenuOnline', menuonline);
                                            formData.append('CartaQR', cartaqr);
                                            formData.append('Categoria', categoriaId);
                                            // Realizar la solicitud AJAX
                                            $.ajax({
                                                url: '/api/registrar-subcategoria',
                                                type: 'POST',
                                                data: formData,
                                                contentType: false,
                                                processData: false, 
                                                success: function (categoria) {
                                                    MostrarTablaCategoria();
                                                    MostrarCategoria();
                                                    MostrarMensaje("Cocina Creada Exitosamente", "success");
                                                    $("#SubCategoriaNombre").val("");
                                                    $("#SubCategoriaCocina").val("");
                                                    $("#SubCheckAppComensal").prop('checked', false);
                                                    $("#SubCheckMenuOnline").prop('checked', false);
                                                    $("#SubCheckCartaQR").prop('checked', false);
                                                },
                                                error: function (error) {
                                                    console.error('Error al registrar:', error);
                                                }
                                            });
                                        });
                                    });
                                    
                                },
                                error: function(error) {
                                    console.error('Error al recuperar datos de producto:', error);
                                }
                            });
                        });

                        $('#SearchProduct').on('input', function() {
                            var searchText = $(this).val().toLowerCase();
                            $('#tabla-categorias tbody tr').each(function() {
                                var codigo = $(this).find('td:nth-child(1)').text().toLowerCase();
                                var nombre = $(this).find('td:nth-child(2)').text().toLowerCase();
                                var costo = $(this).find('td:nth-child(3)').text().toLowerCase();
                                if (codigo.includes(searchText) || nombre.includes(searchText) || costo.includes(searchText) || margen.includes(searchText) || precio.includes(searchText)) {
                                    $(this).show();
                                } else {
                                    $(this).hide();
                                }
                            });
                        });
                    }                    
                } else {
                    var tablaCategorias = $('#tabla-productos tbody');
                    tablaCategorias.empty();
                    tablaCategorias.append('<tr>' +
                    '<td colspan="5" style="text-align: center">LA CATEGORIA NO TIENE REGISTROS AUN</td>' +
                    '</tr>');
                }
            },
            error: function(error) {
                console.error('Error al recuperar datos:', error);
            }
        });  
    }
</script>
@livewireScripts
