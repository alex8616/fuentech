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
<style>
    #tabla-productos .producto-fila:hover {
        background-color: #FE8F8F;
    }
    #tabla-productos .producto-fila.selected {
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
        background-color: #FE8F8F;
    }
</style>
@livewireStyles
<script>
    function MostrarCategoria(){
        $.ajax({
            url: 'api/get-categorias',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    var categoriasContainer = $('#listarcategorias');
                    var contenidoHTML = '';
                    $.each(data, function(index, categoria) {
                        contenidoHTML += '<div>'
                        contenidoHTML += '<a class="list-group-item list-group-item-action d-flex align-items-center" href="#" data-id="' + categoria.id + '" style="color: white; font-weight: bold;">';
                        contenidoHTML += categoria.Nombre_categoria;
                        contenidoHTML += '<small class="text ms-auto" style="color: white;">' + (categoria.Estado === 'true' ? 'activo' : 'inactivo') + '</small>';
                        contenidoHTML += '</a>';
                        contenidoHTML += '</div>'
                    });
                    categoriasContainer.html(contenidoHTML);
                    $('#listarcategorias').on('click', '.list-group-item', function() {
                        $('.list-group-item').parent().removeClass('selected');
                        $(this).parent().addClass('selected');        
                        var categoriaId = $(this).data('id');
                        ListProductos(categoriaId);
                    });
                } else {
                    $('#listarcategorias').html('<p class="text-muted">No se encontraron categorías.</p>');
                }
            },
            error: function(error) {
                console.error('Error al recuperar datos:', error);
            }
        });  
    }

    function ListProductos(categoriaId){
        $.ajax({
            url: 'api/get-productos-categoria/' + categoriaId,
            type: 'GET',
            dataType: 'json',
            success: function(productos) {
                if (productos.length > 0) {
                    $('#checkMostrar').change(function() {
                        actualizarTabla();
                    });
                    actualizarTabla();
                    function actualizarTabla() {
                        var tablaProductos = $('#tabla-productos tbody');
                        tablaProductos.empty();
                        $.each(productos, function(index, producto) {
                            var margen = parseFloat(producto.PrecioProducto) - parseFloat(producto.CostoProducto);
                            var filaClass = producto.EstadoProducto === "false" ? "fila-tachada" : "";

                            if ($('#checkMostrar').is(':checked') || producto.EstadoProducto === "true") {
                                tablaProductos.append('<tr class="producto-fila ' + filaClass + '" data-producto-id="' + producto.id + '">' +
                                    '<td style="font-weight: bold;">' + producto.CodigoProducto + '</td>' +
                                    '<td>' + producto.NombreProducto + '</td>' +
                                    '<td> Bs.' + parseFloat(producto.CostoProducto).toFixed(2) + '</td>' +
                                    '<td> Bs.' + margen.toFixed(2) + '</td>' +
                                    '<td style="font-weight: bold;"> Bs.' + parseFloat(producto.PrecioProducto).toFixed(2) + '</td>' +
                                    (producto.FavoritoProducto === "true" ? '<td class="w-1 boton-registrar-favorito-sip"><span class="gl-star-rating--stars"><span data-index="0" data-value="1" class="gl-active"><svg xmlns="http://www.w3.org/2000/svg" class="icon gl-star-full icon-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none;"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor"></path></svg></span><span data-index="1" data-value="2" class="gl-active"></svg></span></span></td>' : '<td class="w-1 boton-registrar-favorito-nop"><span class="gl-star-rating--stars"><span data-index="0" data-value="1" class="gl-active"><svg xmlns="http://www.w3.org/2000/svg" class="icon gl-star-full icon-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none;"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor"></path></svg></span><span data-index="1" data-value="2" class="gl-active"></svg></span></span></td>') +
                                    '</tr>');
                            }
                        });

                        $('.producto-fila').on('click', function() {
                            $('.producto-fila').removeClass('seleccionado');
                            $(this).addClass('seleccionado');
                            var productoId = $(this).data('producto-id');
                            $.ajax({
                                url: '/api/get-productos-seleccionado/' + productoId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    InformacionProducto(data);
                                    ActualizarProductoImagen(productoId);
                                },
                                error: function(error) {
                                    console.error('Error al recuperar datos de producto:', error);
                                }
                            });
                        });

                        $('#SearchProduct').on('input', function() {
                            var searchText = $(this).val().toLowerCase();
                            $('#tabla-productos tbody tr').each(function() {
                                var codigo = $(this).find('td:nth-child(1)').text().toLowerCase();
                                var nombre = $(this).find('td:nth-child(2)').text().toLowerCase();
                                var costo = $(this).find('td:nth-child(3)').text().toLowerCase();
                                var margen = $(this).find('td:nth-child(4)').text().toLowerCase();
                                var precio = $(this).find('td:nth-child(5)').text().toLowerCase();
                                if (codigo.includes(searchText) || nombre.includes(searchText) || costo.includes(searchText) || margen.includes(searchText) || precio.includes(searchText)) {
                                    $(this).show();
                                } else {
                                    $(this).hide();
                                }
                            });
                        });

                        $('.boton-registrar-favorito-sip').on('click', function() {
                            var productoId = $(this).closest('tr').data('producto-id');
                            $.ajax({
                                url: '/api/producto-register-true/'+ productoId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    MostrarMensaje("Se Quito De Favoritos", "success");
                                    ListProductos(categoriaId);
                                },
                                error: function(error) {
                                    console.error('Error al recuperar datos de categorías:', error);
                                }
                            });
                        });

                        $('.boton-registrar-favorito-nop').on('click', function() {
                            var productoId = $(this).closest('tr').data('producto-id');
                            $.ajax({
                                url: '/api/producto-register-false/'+ productoId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    MostrarMensaje("Se Agrego a Favoritos", "success");
                                    ListProductos(categoriaId);
                                },
                                error: function(error) {
                                    console.error('Error al recuperar datos de categorías:', error);
                                }
                            });
                        });
                    }                    
                } else {
                    var tablaProductos = $('#tabla-productos tbody');
                    tablaProductos.empty();
                    tablaProductos.append('<tr>' +
                    '<td colspan="5" style="text-align: center">LA CATEGORIA NO TIENE REGISTROS AUN</td>' +
                    '</tr>');
                }
            },
            error: function(error) {
                console.error('Error al recuperar datos de productos por categoría:', error);
            }
        });
    }
    
    function cargarCategorias(){
        $.ajax({
            url: '/api/get-categorias',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#ProductoCategoria');
                select.empty();
                select.append($('<option></option>').attr('value', '').text('Seleccionar categoría'));
                $.each(data, function(index, categoria) {
                    select.append($('<option></option>').attr('value', categoria.id).text(categoria.Nombre_categoria));
                });
            },
            error: function(error) {
                console.error('Error al recuperar datos de categorías:', error);
            }
        });
    }

    function cargarSubcategorias() {
        var id = $('#ProductoCategoria').val();
        $.ajax({
            url: '/api/get-subcategorias/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var select = $('#ProductoSubCategoria');
                select.empty();
                select.append($('<option></option>').attr('value', '').text('Seleccionar subcategoría'));
                $.each(data, function(index, subcategoria) {
                    select.append($('<option></option>').attr('value', subcategoria.id).text(subcategoria.Nombre_subcategoria));
                });
            },
            error: function(error) {
                console.error('Error al recuperar datos de subcategorías:', error);
            }
        });
    }

    function InformacionProducto(data){
        var TotalProduct = document.getElementById('form_tabs');
        TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">${data.NombreProducto}</h3>
                        <div class="card-actions">
                        <a href="#" class="btn" data-producto-id="${data.id}" id="EditarProducto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-7">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Categoria</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.categoria.Nombre_categoria}</label>                                                    
                                    </div>
                                </div>
                                ${data.categoria.subcategorias.length > 0 ? `
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Sub Categoria</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">${data.categoria.subcategorias[0].Nombre_subcategoria}</label>
                                    </div>
                                </div>` : ''}
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Costo</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">Bs. ${data.CostoProducto}</label>                                                    
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Precio</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">Bs. ${data.PrecioProducto}</label>                                                    
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Codigo</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.CodigoProducto}</label>                                                    
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Activo</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.EstadoProducto}</label>                                                    
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Proveedor</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.proveedor ? data.proveedor.name : 'Sin proveedor'}</label>
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Menu Online</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.categoria.Nombre_categoria}</label>                                                    
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Carta QR</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image" data-producto-id="${data.id}" id="openModal">Establecer Imagen</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Control Stock</label>
                                    <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.ControlStock}</label>                                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <img src="/${data.ImagenProducto}" alt="Imagen del producto">
                            </div>
                        </div>                                                                                                
                    </div>
                </div>
            </div>
        `;


        $('#EditarProducto').on('click', function() {
            TotalProduct.innerHTML = ``;
            TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> EDITANDO ${data.NombreProducto}</h3>
                        <div class="card-actions">
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-7">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                                    <div class="col">
                                    <input type="text" class="form-control" id="UpdateProductoNombre" name="UpdateProductoNombre" value="${data.NombreProducto}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Categoria</label>
                                    <div class="col">
                                    <select id="categoriaProductoSelect" class="form-control">
                                        
                                    </select>
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Sub Categoria</label>
                                    <div class="col">
                                    <select id="subcategoriaProductoSelect" class="form-control">
                                        
                                    </select>
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Precio</label>
                                    <div class="col">
                                    <input type="text" class="form-control" id="UpdateProductoPrecio" name="UpdateProductoPrecio" value="${data.PrecioProducto}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Costo</label>
                                    <div class="col">                                    
                                    <input type="text" class="form-control" id="UpdateProductoCosto" name="UpdateProductoCosto" value="${data.CostoProducto}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Codigo</label>
                                    <div class="col">
                                    <input type="text" class="form-control" id="UpdateProductoCodigo" name="UpdateProductoCodigo" value="${data.CodigoProducto}">
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Activo</label>
                                    <div class="col">
                                    <select id="estadoProductoSelect" class="form-control">
                                        <option value="true">Habilitado</option>
                                        <option value="false">Deshabilitado</option>
                                    </select>
                                    <label class="col-8 col-form-label" style="color: #61677A"></label>                                                    
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Proveedor</label>
                                    <div class="col">
                                    <select id="proveedorProductoSelect" class="form-control">
                                        
                                    </select>
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Menu Online</label>
                                    <div class="col">
                                        <select id="menuProductoSelect" class="form-control">
                                            <option value="true">Habilitado</option>
                                            <option value="false">Deshabilitado</option>
                                        </select>
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Carta QR</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-image" data-producto-id="${data.id}" id="openModal">Establecer Imagen</a>
                                        </label>
                                    </div>
                                </div><br>
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Control Stock</label>
                                    <div class="col">
                                    <select id="stockProductoSelect" class="form-control">
                                        <option value="true">Habilitado</option>
                                        <option value="false">Deshabilitado</option>
                                    </select>
                                    </div>
                                </div><br>
                                <button id="EditBtnGuardar">Guardar</button>
                                <button id="EditBtnCancelar">Cancelar</button>
                            </div>
                            <div class="col-12 col-md-5">
                                <img src="/${data.ImagenProducto}" alt="Imagen del producto">
                            </div>
                        </div>                                                                                                
                    </div>
                </div>
            </div>`;   
                      
            if (data.proveedor !== null) {
                var proveedorProductoId = data.proveedor.id;
                $.ajax({
                    url: '/api/get-proveedor',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {        
                        var select = $('#proveedorProductoSelect');
                        select.empty();
                        var optionDefault = $('<option></option>').attr('value', '').text('Seleccione un proveedor');
                        select.append(optionDefault);
                        $.each(data, function(index, proveedor) {
                            select.append($('<option></option>').attr('value', proveedor.id).text(proveedor.name));
                        }); 
                        $('#proveedorProductoSelect').val(proveedorProductoId).change();
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de proveedores:', error);
                    }
                }); 
            }else{
                $.ajax({
                    url: '/api/get-proveedor',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {        
                        var select = $('#proveedorProductoSelect');
                        select.empty();
                        var optionDefault = $('<option></option>').attr('value', '').text('Seleccione un proveedor');
                        select.append(optionDefault);
                        $.each(data, function(index, proveedor) {
                            select.append($('<option></option>').attr('value', proveedor.id).text(proveedor.name));
                        }); 
                        optionDefault.prop('selected', true);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de proveedores:', error);
                    }
                });
            }

            var categoriaProductoId = data.categoria.id;
            $.ajax({
                url: 'api/get-categorias',
                type: 'GET',
                dataType: 'json',
                success: function(categorias) {
                    var select = $('#categoriaProductoSelect');
                    select.empty();
                    $.each(categorias, function(index, categoria) {
                        select.append($('<option></option>').attr('value', categoria.id).text(categoria.Nombre_categoria));
                    }); 
                    $('#categoriaProductoSelect').val(categoriaProductoId).change();
                },
                error: function(error) {
                    console.error('Error al recuperar datos de categorías:', error);
                }
            });

            var sub_categoria_id = data.sub_categoria_id;
            $.ajax({
                url: '/api/get-subcategorias/' + categoriaProductoId,
                type: 'GET',
                dataType: 'json',
                success: function(subcategorias) {
                    var select = $('#subcategoriaProductoSelect');
                    select.empty();
                    $.each(subcategorias, function(index, subcategoria) {
                        select.append($('<option></option>').attr('value', subcategoria.id).text(subcategoria.Nombre_subcategoria));
                    }); 
                    $('#subcategoriaProductoSelect').val(sub_categoria_id).change();
                },
                error: function(error) {
                    console.error('Error al recuperar datos de categorías:', error);
                }
            });

            $('#categoriaProductoSelect').change(function() {
                var categoriaSeleccionadaId = $(this).val();
                if (categoriaSeleccionadaId) {
                    $.ajax({
                        url: '/api/get-subcategorias/' + categoriaSeleccionadaId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(subcategorias) {
                            var selectSubcategoria = $('#subcategoriaProductoSelect');
                            selectSubcategoria.empty();
                            $.each(subcategorias, function(index, subcategoria) {
                                selectSubcategoria.append($('<option></option>').attr('value', subcategoria.id).text(subcategoria.Nombre_subcategoria));
                            }); 
                        },
                        error: function(error) {
                            console.error('Error al recuperar datos de subcategorías:', error);
                        }
                    });
                } else {
                    $('#subcategoriaProductoSelect').empty();
                }
            });

            var estadoProducto = `${data.EstadoProducto}`;
            $('#estadoProductoSelect').val(estadoProducto).change();

            var stockProducto = `${data.ControlStock}`;
            $('#stockProductoSelect').val(stockProducto).change();

            var IdUpdate = `${data.id}`;

            var IdCategoriaUpdate = `${data.categoria_id}`;

            $('#EditBtnGuardar').off('click').on('click', function(event) {
                var EditNombre = $("#UpdateProductoNombre").val();
                var EditPrecio = $("#UpdateProductoPrecio").val();
                var EditCosto = $("#UpdateProductoCosto").val();
                var EditCodigo = $("#UpdateProductoCodigo").val();
                var Editproveedor = $("#proveedorProductoSelect").val();
                var Editactivo = $("#estadoProductoSelect").val();
                var EditcontrolStock = $("#stockProductoSelect").val();
                var EditCategoria = $("#categoriaProductoSelect").val();
                var EditSubCategoria = $("#subcategoriaProductoSelect").val();

                var datosRecogidos = {
                    id: IdUpdate,
                    nombre: EditNombre,
                    precio: EditPrecio,
                    costo: EditCosto,
                    codigo: EditCodigo,
                    proveedor: Editproveedor,
                    activo: Editactivo,
                    controlStock: EditcontrolStock,
                    categoria: EditCategoria,
                    subcategoria: EditSubCategoria
                };

                $.ajax({
                    url: '/api/actualizar-producto',
                    type: 'POST',
                    data: datosRecogidos,
                    success: function (producto) {
                        ListProductos(IdCategoriaUpdate);
                        CanvasTime();
                        MostrarMensaje("Se Actualizo El Producto Exitosamente", "success");
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });

        });
    }

    function ActualizarProductoImagen(productoId){
        $('#btn-cambiar-img').off('click').on('click', function() {
            var id = productoId;
            var imagen = $('#ProductoImagenUpdate')[0].files[0];
            var formData = new FormData();
            formData.append('imagen', imagen);
            formData.append('id', id);
            $.ajax({
                url: '/api/update-productos-seleccionado',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    CanvasTime();
                    MostrarMensaje("Imagen Cambiado Exitosamente", "success");
                    $("#ProductoImagenUpdate").val("");
                },
                error: function(error) {
                    console.error('Error al recuperar datos de producto:', error);
                }
            });                        
        }); 
    }

    $(document).ready(function() {  
        MostrarCategoria();

        document.getElementById('addproductos').addEventListener('click', function() {
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
                            <input type="text" class="form-control" id="ProductoNombre" name="ProductoNombre">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Categoria</label>
                            <div class="col">
                            <select class="form-select" id="ProductoCategoria" name="ProductoCategoria">
                                
                            </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Sub Categoria</label>
                            <div class="col">
                            <select class="form-select" id="ProductoSubCategoria" name="ProductoSubCategoria">
                                
                            </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Precio</label>
                            <div class="col">
                            <input type="number" class="form-control" id="ProductoPrecio" name="ProductoPrecio">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Costo</label>
                            <div class="col">
                            <input type="number" class="form-control" id="ProductoCosto" name="ProductoCosto">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Codigo</label>
                            <div class="col">
                            <input type="text" class="form-control" id="ProductoCodigo" name="ProductoCodigo">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Cocina</label>
                            <div class="col">
                            <select class="form-select">

                            </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Proveedor</label>
                            <div class="col">
                            <select class="form-select" id="ProductoProveedor" name="ProductoProveedor">

                            </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Descripcion</label>
                            <div class="col">
                            <input type="text" class="form-control" id="ProductoDescripcion" name="ProductoDescripcion">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Imagen</label>
                            <div class="col">
                            <input type="file" class="form-control" id="ProductoImagen" name="ProductoImagen">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-3 col-form-label pt-0">Activo</label>
                            <div class="col">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" id="CheckActivo" name="CheckActivo">
                            </label>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-3 col-form-label pt-0">Control Stock</label>
                            <div class="col">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" id="CheckStock" name="CheckStock">
                            </label>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="btn-registrar-producto">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;

            $.ajax({
                url: '/api/get-proveedor',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var select = $('#ProductoProveedor');
                    select.empty();
                    select.append($('<option></option>'));
                    $.each(data, function(index, proveedor) {
                        select.append($('<option></option>').attr('value', proveedor.id).text(proveedor.name));
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

            $('#btn-registrar-producto').off('click').on('click', function(event) {
                // Obtener los valores de los otros campos del formulario
                var Nombre = $("#ProductoNombre").val();
                var Categoria = $("#ProductoCategoria").val();
                var SubCategoria = $("#ProductoSubCategoria").val();
                var Precio = $("#ProductoPrecio").val();
                var Costo = $("#ProductoCosto").val();
                var Codigo = $("#ProductoCodigo").val();
                var proveedor = $("#ProductoProveedor").val();
                var Descripcion = $("#ProductoDescripcion").val();
                var activo = $("#CheckActivo").prop('checked');
                var controlStock = $("#CheckStock").prop('checked');

                // Capturar el archivo seleccionado por el usuario
                var imagen = $('#ProductoImagen')[0].files[0]; // Aquí estamos obteniendo el primer archivo seleccionado

                // Crear un objeto FormData para enviar los datos del formulario
                var formData = new FormData();
                formData.append('Nombre', Nombre);
                formData.append('Categoria', Categoria);
                formData.append('SubCategoria', SubCategoria);
                formData.append('Precio', Precio);
                formData.append('Costo', Costo);
                formData.append('Codigo', Codigo);
                formData.append('proveedor', proveedor);
                formData.append('Descripcion', Descripcion);
                formData.append('activo', activo);
                formData.append('controlStock', controlStock);
                formData.append('imagen', imagen); // Agregar la imagen al objeto FormData

                // Realizar la solicitud AJAX
                $.ajax({
                    url: '/api/registrar-producto',
                    type: 'POST',
                    data: formData, // Enviar el objeto FormData en lugar de un objeto JSON
                    contentType: false,
                    processData: false, // Es importante establecer processData como false
                    success: function (producto) {
                        ListProductos(Categoria);
                        MostrarMensaje("Producto Creada Exitosamente", "success");
                        $("#ProductoNombre").val("");
                        $("#ProductoCategoria").val("");
                        $("#ProductoSubCategoria").val("");
                        $("#ProductoPrecio").val("");
                        $("#ProductoCosto").val("");
                        $("#ProductoCodigo").val("");
                        $("#ProductoProveedor").val("");
                        $("#ProductoDescripcion").val("");
                        $("#CheckActivo").prop('checked', false);
                        $("#CheckStock").prop('checked', false);
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });

        });
    });

    function CanvasTime(){
        var TotalProduct = document.getElementById('form_tabs');
        TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <h3 class="card-title" style="color: #424769">Sin Seleccionar Nada, En Espera ...</h3>
                    </div>
                    <div class="img-responsive img-responsive-21x21 card-img-bottom" style="background-image: url('/utilidades/svg/espera.svg')"></div>
                </div>
            </div>
        `;        
    }
</script>
@livewireScripts
