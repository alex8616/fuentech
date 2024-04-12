function MostrarCategoriaIngrediente(){
    $.ajax({
        url: 'api/get-categoria-ingredientes',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                var categoriasContainer = $('#listaringredientes');
                var contenidoHTML = '';
                $.each(data, function(index, categoria) {
                    contenidoHTML += '<div>'
                    contenidoHTML += '<a class="list-group-item list-group-item-action d-flex align-items-center" href="#" data-id="' + categoria.id + '" style="color: white; font-weight: bold;">';
                    contenidoHTML += categoria.NombreCategoria;
                    contenidoHTML += '</a>';
                    contenidoHTML += '</div>'
                });
                categoriasContainer.html(contenidoHTML);
                $('#listaringredientes').on('click', '.list-group-item', function() {
                    var $listItem = $(this);

                    // Removemos la clase 'selected' de todos los elementos y la agregamos al elemento clicado
                    $('.list-group-item').parent().removeClass('selected');
                    $listItem.parent().addClass('selected');

                    var categoriaId = $listItem.data('id');

                    ListIngredientes(categoriaId)
                });
            } else {
                $('#listaringredientes').html('<p class="text-muted">No se encontraron categorías.</p>');
            }
        },
        error: function(error) {
            console.error('Error al recuperar datos:', error);
        }
    });  
}

function ListIngredientes(categoriaId){
    $.ajax({
        url: 'api/get-ingrediente-categoria/' + categoriaId,
        type: 'GET',
        dataType: 'json',
        success: function(productos) {
            if (productos.length > 0) {
                actualizarTabla();
                function actualizarTabla() {
                    var tablaIngredientes = $('#tabla-ingredientes tbody');
                    tablaIngredientes.empty();
                    
                    if (productos.length === 0) {
                        tablaIngredientes.append('<tr><td colspan="4">Esta categoría no tiene ingredientes</td></tr>');
                    } else {
                        $.each(productos, function(index, producto) {
                            tablaIngredientes.append('<tr class="ingrediente-fila" data-producto-id="' + producto.id + '">' +
                                '<td style="font-weight: bold;">' + producto.NombreIngrediente + '</td>' +
                                '<td>' + producto.UnidadIngrediente + '</td>' +
                                '<td> Bs.' + parseFloat(producto.CostoIngrediente).toFixed(2) + '</td>' +
                                '<td style="font-weight: bold;"> Bs.' + parseFloat(producto.CostoIngrediente).toFixed(2) + '</td>' +
                                '</tr>');
                        });
                    }

                    $('.ingrediente-fila').on('click', function() {
                        $('.ingrediente-fila').removeClass('seleccionado');
                        $(this).addClass('seleccionado');
                        var productoId = $(this).data('producto-id');
                        $.ajax({
                            url: '/api/get-ingrediente-seleccionado/' + productoId,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                InformacionIngrediente(data);
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
                }                    
            } else {
                var tablaIngredientes = $('#tabla-productos tbody');
                tablaIngredientes.empty();
                tablaIngredientes.append('<tr>' +
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
        url: '/api/get-categoria-ingredientes',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#IngredienteCategoria');
            select.empty();
            select.append($('<option></option>').attr('value', '').text('Seleccionar categoría'));
            $.each(data, function(index, categoria) {
                select.append($('<option></option>').attr('value', categoria.id).text(categoria.NombreCategoria));
            });
        },
        error: function(error) {
            console.error('Error al recuperar datos de categorías:', error);
        }
    });
}


function InformacionIngrediente(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">${data.NombreIngrediente}</h3>
                    <div class="card-actions">
                    <a href="#" class="btn" data-producto-id="${data.id}" id="EditarProducto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                    </a>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">                            
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                                <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">Bs. ${data.NombreIngrediente}</label>                                                    
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Unidad</label>
                                <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">Bs. ${data.UnidadIngrediente}</label>                                                    
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Categoria</label>
                                <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.categoriaingrediente.NombreCategoria}</label>                                                    
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Costo</label>
                                <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.CostoIngrediente}</label>                                                    
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Merma</label>
                                <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.CantidadIngrediente}</label>                                                    
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Proveedor</label>
                                <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.proveedor ? data.proveedor.name : 'Sin proveedor'}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Control Stock</label>
                                <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.ControlStock}</label>                                                    
                                </div>
                            </div>
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
                    <h3 class="card-title"> EDITANDO ${data.NombreIngrediente}</h3>
                    <div class="card-actions">
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">                           
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                                <div class="col">
                                <input type="text" class="form-control" id="UpdateIngredienteNombre" name="UpdateIngredienteNombre" value="${data.NombreIngrediente}">
                                </div>
                            </div><br>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Categoria</label>
                                <div class="col">
                                <select id="CategoriaIngredienteSelect" class="form-control">
                                    
                                </select>
                                </div>
                            </div><br>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Unidad</label>
                                <div class="col">
                                <input type="text" class="form-control" id="UpdateIngredienteUnidad" name="UpdateIngredienteUnidad" value="${data.UnidadIngrediente}">
                                </div>
                            </div><br>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Costo</label>
                                <div class="col">                                    
                                <input type="text" class="form-control" id="UpdateIngredienteCosto" name="UpdateIngredienteCosto" value="${data.CostoIngrediente}">
                                </div>
                            </div><br>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Merma</label>
                                <div class="col">
                                <input type="text" class="form-control" id="UpdateIngredienteMerma" name="UpdateIngredienteMerma" value="${data.CantidadIngrediente}">
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
                                <label class="col-4 col-form-label" style="font-weight: bold">Control Stock</label>
                                <div class="col">
                                <select id="stockProductoSelect" class="form-control">
                                    <option value="true">Habilitado</option>
                                    <option value="false">Deshabilitado</option>
                                </select>
                                </div>
                            </div><br>
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button id="EditBtnIngredienteGuardar" class="btn btn-success active">Guardar</button>
                                </div>
                                <div class="col-auto">
                                    <button id="EditBtnIngredienteCancelar" class="btn btn-danger active">Cancelar</button>
                                </div>
                            </div>
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

        var categoriaProductoId = data.categoriaingrediente.id;
        $.ajax({
            url: 'api/get-categoria-ingredientes',
            type: 'GET',
            dataType: 'json',
            success: function(categorias) {
                var select = $('#CategoriaIngredienteSelect');
                select.empty();
                $.each(categorias, function(index, categoria) {
                    select.append($('<option></option>').attr('value', categoria.id).text(categoria.NombreCategoria));
                }); 
                $('#CategoriaIngredienteSelect').val(categoriaProductoId).change();
            },
            error: function(error) {
                console.error('Error al recuperar datos de categorías:', error);
            }
        });

        var stockProducto = `${data.ControlStock}`;
        $('#stockProductoSelect').val(stockProducto).change();

        var IdUpdate = `${data.id}`;

        var IdCategoriaUpdate = `${data.categoria_id}`;

        $('#EditBtnIngredienteGuardar').off('click').on('click', function(event) {
            var EditNombre = $("#UpdateIngredienteNombre").val();
            var EditCategoria = $("#CategoriaIngredienteSelect").val();
            var EditUnidad = $("#UpdateIngredienteUnidad").val();
            var EditCosto = $("#UpdateIngredienteCosto").val();
            var EditMerma = $("#UpdateIngredienteMerma").val();
            var Editproveedor = $("#proveedorProductoSelect").val();
            var EditcontrolStock = $("#stockProductoSelect").val();

            var datosRecogidos = {
                id: IdUpdate,
                nombre: EditNombre,
                unidad: EditUnidad,
                costo: EditCosto,
                merma: EditMerma,
                proveedor: Editproveedor,
                controlStock: EditcontrolStock,
                categoria: EditCategoria,
            };

            $.ajax({
                url: '/api/actualizar-ingrediente',
                type: 'POST',
                data: datosRecogidos,
                success: function (producto) {
                    ListIngredientes(EditCategoria);
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

$(document).ready(function() {  
    MostrarCategoriaIngrediente();

    document.getElementById('addingredientes').addEventListener('click', function() {
        cargarCategorias();
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Ingrediente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control" id="IngredienteNombre" name="IngredienteNombre">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Categoria</label>
                        <div class="col">
                        <select class="form-select" id="IngredienteCategoria" name="IngredienteCategoria">
                            
                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Unidad</label>
                        <div class="col">
                        <input type="text" class="form-control" id="IngredienteUnidad" name="IngredienteUnidad">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Costo</label>
                        <div class="col">
                        <input type="number" class="form-control" id="IngredienteCosto" name="IngredienteCosto">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Merma %</label>
                        <div class="col">
                        <input type="text" class="form-control" id="IngredienteMerma" name="IngredienteMerma">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label">Proveedor</label>
                        <div class="col">
                        <select class="form-select" id="ProductoProveedor" name="ProductoProveedor">

                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-3 col-form-label pt-0">Control Stock</label>
                        <div class="col">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkboxIngrediente" name="checkboxIngrediente">
                        </label>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-ingrediente">GUARDAR</button>
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
        });IngredienteCategoria

        $('#btn-registrar-ingrediente').off('click').on('click', function(event) {
            // Obtener los valores de los otros campos del formulario
            var Nombre = $("#IngredienteNombre").val();
            var Categoria = $("#IngredienteCategoria").val();
            var Unidad = $("#IngredienteUnidad").val();
            var Costo = $("#IngredienteCosto").val();
            var Merma = $("#IngredienteMerma").val();
            var proveedor = $("#ProductoProveedor").val();
            var controlStock = $("#checkboxIngrediente").prop('checked');

            // Crear un objeto FormData para enviar los datos del formulario
            var formData = new FormData();
            formData.append('Nombre', Nombre);
            formData.append('Categoria', Categoria);
            formData.append('Unidad', Unidad);
            formData.append('Costo', Costo);
            formData.append('Merma', Merma);
            formData.append('proveedor', proveedor);
            formData.append('controlStock', controlStock);

            // Realizar la solicitud AJAX
            $.ajax({
                url: '/api/registrar-ingrediente',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false, 
                success: function (producto) {
                    ListIngredientes(Categoria);
                    MostrarMensaje("Producto Creada Exitosamente", "success");
                    $("#IngredienteNombre").val("");
                    $("#IngredienteCategoria").val("");
                    $("#IngredienteUnidad").val("");
                    $("#IngredienteCosto").val("");
                    $("#IngredienteMerma").val("");
                    $("#ProductoProveedor").val("");
                    $("#checkboxIngrediente").prop('checked', false);
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