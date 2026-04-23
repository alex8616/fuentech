$(document).ready(function() {
    $('#modal-ingredientes').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('selectproduct-id');
        $.ajax({
            url: '/api/get-ingrediente',
            method: 'GET',
            success: function(data) {
                $("#BuscarReceta").autocomplete({
                    source: function(request, response) {
                        var searchTerm = request.term.toLowerCase();
                        var filteredData = data.filter(function(ingrediente) {
                            return ingrediente.NombreIngrediente.toLowerCase().includes(searchTerm);
                        });
                        response(filteredData);
                    },
                    appendTo: "#modal-ingredientes",
                    select: function(event, ui) {
                        var ingredienteSeleccionado = ui.item;
                        agregarDivIngrediente(ingredienteSeleccionado,productId);
                    },
                    create: function() {
                        $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
                            return $("<li>")
                                .append("<div>" + item.NombreIngrediente + "</div>")
                                .appendTo(ul);
                        };
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener las opciones:", error);
            }
        });
    });
    

    // Evitar que el modal se cierre cuando se hace clic fuera de él
    $('#modal-ingredientes').modal({ backdrop: 'static', keyboard: false });

    // Cuando se haga clic en el botón Registrar
    $('#BtnRegistrarReceta').on('click', function() {
        var Id = $('#productoID').val(); // Obtener el Id una sola vez fuera del bucle
        var ingredientes = []; // Array para almacenar todos los ingredientes
        
        $('.row-cards').each(function() {
            var row = $(this);
            var ingrediente = {
                Id: row.find('#productoID').val(),
                ingredienteId: row.find('#ingredienteID').val(), 
                nombreIngrediente: row.find('#RecuperarNombreIngrediente').text(),
                cantidadNeta: row.find('#CantidadNeta').val(),
                unidadNeta: row.find('#UnidadNeta').val(),
                merma: row.find('#RecuperarMermaIngrediente').text(),
                cantidadBruta: row.find('#CantidadBruta').val(),
                costoIngrediente: row.find('#TotalIngrediente').text()
            };
            ingredientes.push(ingrediente); 
        });
    
        // Enviar todos los ingredientes juntos en una sola solicitud AJAX
        $.ajax({
            url: '/api/registrar-receta',
            method: 'POST',
            data: {
                Id: Id, 
                ingredientes: ingredientes
            },
            success: function(response) {
                $('#BuscarModificador').val('');
                $('#contenedor-modificador').empty();
                $('.row-cards').remove(); 
                MostrarMensaje("Agregado Exitosamente", "success");
                actualizarTablaDetallesReceta(response)
            },
            error: function(xhr, status, error) {
                console.error('Error al registrar ingredientes:', error);
            }
        });
    });
    
    function agregarDivIngrediente(ingredienteSeleccionado, productId) {
        var divIngrediente = `
        <br><div class="row row-cards">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold">Ingrediente</label>
                        <input type="text" readonly class="form-control" id="productoID" value="${productId}" hidden>  
                        <input type="text" readonly class="form-control" id="ingredienteID" value="${ingredienteSeleccionado.id}" hidden>  
                        <span id="RecuperarNombreIngrediente">${ingredienteSeleccionado.NombreIngrediente}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold">Cant. Neta</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" id="CantidadNeta">
                            </div>
                            <div class="col">
                                <select class="form-control form-select" id="UnidadNeta">
                                    <option value="Unid">Unid.</option>
                                    <option value="Kilos">Kilos</option>
                                    <option value="Gramos">Gramos</option>
                                    <option value="Onza">Onza</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold">Merma</label>
                        <span id="RecuperarMermaIngrediente">
                            ${ingredienteSeleccionado.CantidadIngrediente ? ingredienteSeleccionado.CantidadIngrediente : 0}
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold">Cant. Bruta</label>
                        <div class="row">
                            <div class="col" style="margin: 0px;">
                                <input type="text" class="form-control" id="CantidadBruta" readonly>
                            </div>
                            <div class="col" style="margin: 0px;">
                                <select class="form-control form-select" id="UnidadBruta" disabled>
                                    <option value="Unid">Unid.</option>
                                    <option value="Kilos">Kilos</option>
                                    <option value="Gramos">Gramos</option>
                                    <option value="Onza">Onza</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold">Costo</label>
                        <div class="row">
                            <div class="col-auto">
                                <span id="TotalIngrediente">${ingredienteSeleccionado.CostoIngrediente}</span>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="badge bg-red-lt" id="EliminarFila">X</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $("#contenedor-ingrediente").append(divIngrediente);

        function calcularCantidadBrutaYTotal(event) {
            var row = $(event.target).closest('.row-cards');
            var cantidadNeta = parseFloat(row.find('#CantidadNeta').val());
            var merma = parseFloat(row.find('#RecuperarMermaIngrediente').text());
            var costoIngrediente = 0,
            costoIngrediente = parseFloat(row.find('#TotalIngrediente').text());
            if (!isNaN(cantidadNeta) && !isNaN(merma) && !isNaN(costoIngrediente)) {
                var cantidadBruta = cantidadNeta / (1 - (merma / 100));
                var total = cantidadBruta * costoIngrediente;

                row.find('#CantidadBruta').val(cantidadBruta.toFixed(2));
                row.find('#TotalIngrediente').text(total.toFixed(2));
            } else {
                if(merma == null){
                    var cantidadBruta = cantidadNeta / (1 - (cantidadNeta / 100));
                    var total = cantidadBruta * costoIngrediente;

                    row.find('#CantidadBruta').val(cantidadBruta.toFixed(2));
                    row.find('#TotalIngrediente').text(total.toFixed(2));
                }
            }
        }

        $('#contenedor-ingrediente').off('change', '.row-cards').on('change', '.row-cards', calcularCantidadBrutaYTotal);

        calcularCantidadBrutaYTotal({ target: $('#contenedor-ingrediente').children().last().find('#CantidadNeta')[0] });

        $('#contenedor-ingrediente').on('click', '#EliminarFila', function() {
            $(this).closest('.row-cards').remove();
        });
    }
});

$(document).on('change', '.DetectarMenuCheck', function() {
    const checkbox = $(this);
    const categoriaId = checkbox.attr('id').replace('DetectarMenuCheck-', '');
    const nuevoEstado = checkbox.is(':checked'); // true o false

    // Actualiza visualmente el texto activo/inactivo
    const $link = checkbox.closest('.form-check').find('a');
    const $estadoTexto = $link.find('small');
    $estadoTexto.text(nuevoEstado ? 'activo' : 'inactivo');

    // Enviar al backend con AJAX
    $.ajax({
        url: 'api/categorias/actualizar-estado',
        method: 'POST',
        data: {
            id: categoriaId,
            menuOnline: nuevoEstado,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            MostrarMensaje("Estado actualizado con éxito", "success");
        },
        error: function(xhr) {
            MostrarMensaje("Error al actualizar el estado", "error");
            checkbox.prop('checked', !nuevoEstado);
            $estadoTexto.text(!nuevoEstado ? 'activo' : 'inactivo');
        }
    });
});

$(document).ready(function() {
    $('#modal-grupos').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('selectproduct-id');
        $.ajax({
            url: '/api/get-modificadores',
            method: 'GET',
            success: function(data) {
                $("#BuscarModificador").autocomplete({
                    source: function(request, response) {
                        var searchTerm = request.term.toLowerCase();
                        var filteredData = data.filter(function(modificadore) {
                            return modificadore.NombreModificador.toLowerCase().includes(searchTerm);
                        });
                        response(filteredData);
                    },
                    appendTo: "#modal-grupos",
                    select: function(event, ui) {                        
                        var modificadoreSeleccionado = ui.item;
                        agregarDivModificadore(modificadoreSeleccionado,productId);
                    },
                    create: function() {
                        $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
                            return $("<li>")
                                .append("<div>" + item.NombreModificador + "</div>")
                                .appendTo(ul);
                        };
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener las opciones:", error);
            }
        });
    });
    

    $('#modal-grupos').modal({ backdrop: 'static', keyboard: false });

    $('#BtnRegistrarModificador').on('click', function() {
        var Id = $('#productoID').val();
        var modificadores = [];
        
        $('.row-cards').each(function() {
            var row = $(this);
            var modificadore = {
                Id: row.find('#productoID').val(),
                IdMod: row.find('#modificadorID').val(),
            };
            modificadores.push(modificadore); 
        });
    
        $.ajax({
            url: '/api/producto-modificador-update/'+Id,
            method: 'GET',
            data: {
                Id: Id, 
                modificadores: modificadores
            },
            success: function(response) {
                actualizarTablaModificador(response)
                MostrarMensaje("Agregado Exitosamente", "success");
            },
            error: function(xhr, status, error) {
                console.error('Error al registrar ingredientes:', error);
            }
        });
    });
    
    function agregarDivModificadore(modificadoreSeleccionado, productId) {
        var divIngrediente = `
        <br><br><div class="row row-cards" style="background: #F0F0F0; padding-left: 10px; padding-right: 10px">
                <div class="col-md-6">
                    <div class="mb-3">
                        <input type="text" readonly class="form-control" id="productoID" value="${productId}" hidden>  
                        <input type="text" readonly class="form-control" id="modificadorID" value="${modificadoreSeleccionado.id}" hidden>  
                        <span id="RecuperarNombreIngrediente">${modificadoreSeleccionado.NombreModificador}</span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="mb-3">
                        <span id="RecuperarNombreIngrediente">${modificadoreSeleccionado.NombreModificador}</span>
                    </div>
                </div>
                <div class="col-md-1">
                    <a href="#" class="badge bg-red-lt" id="EliminarFila">X</a>
                </div>
            </div>
        `;
        $("#contenedor-modificador").append(divIngrediente);

        $('#contenedor-modificador').on('click', '#EliminarFila', function() {
            $(this).closest('.row-cards').remove();
        });
    }
});

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
                    contenidoHTML += '<div class="mb-2">';
                    
                    contenidoHTML += '<div class="form-check form-switch d-flex align-items-center">';
                    contenidoHTML += '<input class="form-check-input me-2 DetectarMenuCheck" type="checkbox" id="DetectarMenuCheck-' + categoria.id + '" ' + (categoria.MenuOnline === 'true' ? 'checked' : '') + '>';
                    
                    contenidoHTML += '<a class="list-group-item list-group-item-action d-flex align-items-center w-100" href="#" data-id="' + categoria.id + '" style="color: white; font-weight: bold;">';
                    contenidoHTML += categoria.Nombre_categoria;
                    contenidoHTML += '<small class="text ms-auto" style="color: white;">' + (categoria.Estado === 'true' ? 'activo' : 'inactivo') + '</small>';
                    contenidoHTML += '</a>';
                    
                    contenidoHTML += '</div>';
                    contenidoHTML += '</div>';
                });
                
                categoriasContainer.html(contenidoHTML);
                $('#listarcategorias').on('click', '.list-group-item', function() {
                    var $listItem = $(this);
                    var $nextSubcategorias = $listItem.parent().next('.subcategorias-lista');

                    // Si las subcategorías están visibles, las ocultamos
                    if ($nextSubcategorias.is(':visible')) {
                        $nextSubcategorias.slideUp();
                        return; // Salimos de la función, no es necesario continuar
                    }

                    // Ocultamos las subcategorías de otras categorías
                    $('.subcategorias-lista').not($nextSubcategorias).slideUp();

                    // Removemos la clase 'selected' de todos los elementos y la agregamos al elemento clicado
                    $('.list-group-item').parent().removeClass('selected');
                    $listItem.parent().addClass('selected');

                    var categoriaId = $listItem.data('id');

                    $.ajax({
                        url: 'api/get-subcategorias/' + categoriaId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(subcategorias) {
                            var subcategoriasHTML = '';
                            if (subcategorias.length > 0) {
                                subcategoriasHTML += '<ul class="subcategorias-lista">';
                                $.each(subcategorias, function(index, subcategoria) {
                                    subcategoriasHTML += '<li class="subcategoria-item" data-id="' + subcategoria.id + '">' + subcategoria.Nombre_subcategoria + '</li>';
                                });
                                subcategoriasHTML += '</ul>';
                                ListProductos(categoriaId);   
                                
                                // Remover controladores de eventos previos y luego adjuntar uno nuevo
                                $('#listarcategorias').off('click', '.subcategoria-item').on('click', '.subcategoria-item', function() {
                                    var subcategoriaId = $(this).data('id');
                                    ListProductoSubCategoria(subcategoriaId);
                                });
                            }else {
                                ListProductos(categoriaId);
                            }

                            // Eliminamos las subcategorías existentes antes de agregar las nuevas
                            $('.subcategorias-lista').remove();

                            // Insertar las subcategorías después del elemento clicado
                            $listItem.parent().after(subcategoriasHTML);
                            $nextSubcategorias.slideDown();
                        },
                        error: function(error) {
                            console.error('Error al recuperar subcategorías:', error);
                        }
                    });
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

////INICIO
    // Fetch and display products initially
    fetchAndDisplayProducts();

    // Set up the input event listener for the search
    $('#SearchProduct').on('input', function() {
        fetchAndDisplayProducts($(this).val().toLowerCase());
    });

    // Set up the change event listener for the select dropdown
    $('.form-select').on('change', function() {
        var selectedValue = $(this).val();
        if (selectedValue === 'FAVOTIROS') {
            fetchAndDisplayFavoriteProducts();
        } else {
            fetchAndDisplayProducts();
        }
    });

    function fetchAndDisplayProducts(searchText = '') {
        $.ajax({
            url: '/api/get-productos',
            type: 'GET',
            dataType: 'json',
            success: function(productos) {
                actualizarTabla(productos, searchText);
            },
            error: function(error) {
                console.error('Error al recuperar datos de productos:', error);
            }
        });
    }

    function fetchAndDisplayFavoriteProducts(searchText = '') {
        $.ajax({
            url: '/api/get-productos-favorite',
            type: 'GET',
            dataType: 'json',
            success: function(productos) {
                actualizarTabla(productos, searchText);
            },
            error: function(error) {
                console.error('Error al recuperar datos de productos favoritos:', error);
            }
        });
    }

    function actualizarTabla(productos, searchText) {
        var tablaProductos = $('#tabla-productos tbody');
        tablaProductos.empty();

        if (productos.length > 0) {
            $.each(productos, function(index, producto) {
                var margen = parseFloat(producto.PrecioProducto) - parseFloat(producto.CostoProducto);
                var filaClass = producto.EstadoProducto === "false" ? "fila-tachada" : "";

                // Check if the product matches the search text
                if (producto.CodigoProducto.toLowerCase().includes(searchText) ||
                    producto.NombreProducto.toLowerCase().includes(searchText) ||
                    margen.toFixed(2).toLowerCase().includes(searchText) ||
                    producto.PrecioProducto.toLowerCase().includes(searchText)) {
                    
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

            $('.boton-registrar-favorito-sip').on('click', function() {
                var productoId = $(this).closest('tr').data('producto-id');
                $.ajax({
                    url: '/api/producto-register-true/'+ productoId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        MostrarMensaje("Se Quito De Favoritos", "success");
                        fetchAndDisplayProducts();
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
                        fetchAndDisplayProducts();
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de categorías:', error);
                    }
                });
            });

        } else {
            tablaProductos.append('<tr>' +
                '<td colspan="5" style="text-align: center">LA CATEGORIA NO TIENE REGISTROS AUN</td>' +
                '</tr>');
        }
    }
////FIN

function ListProductoSubCategoria(subcategoriaId){
    $.ajax({
        url: 'api/get-productos-subcategoria/' + subcategoriaId,
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

function cargarCategoriasProducto(){
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

function cargarSubcategoriasProducto() {
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
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-ingredientes" data-selectproduct-id="${data.id}">Agregar Ingredientes</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-grupos" data-selectproduct-id="${data.id}">Agregar Grupos</button>
                        </div>
                    </div> <br>
                    <div class="mb-12 row">
                        <div class="table-responsive" id="TableDetalle" style="display: none">
                            <div style="background: #182433; padding: 12px; color: white">PRODUCTOS</div>
                            <table class="table table-striped">                                
                                <tbody id="detalleRecetaBody">
                                    <!-- Aquí se llenarán los detalles de la receta -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th><a href="#" data-bs-toggle="modal" data-bs-target="#modal-editar-receta" data-producto-id="${data.id}" id="editar-receta">Editar</a></th>
                                    <th colspan="4" style="text-align: right" id="TotalDetalleReceta"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div> <br>
                    <div class="mb-12 row">
                        <div class="table-responsive" id="TableDetalleModificadore" style="display: none">
                            <div style="background: #182433; padding: 12px; color: white">GRUPOS</div>
                            <table class="table table-striped">
                                 <tbody id="detalleModificadorBody">
                                    <!-- Aquí se llenarán los detalles de la receta -->
                                </tbody>
                            </table>
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
                    MostrarTablaProductStock()
                    MostrarMensaje("Se Actualizo El Producto Exitosamente", "success");
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
    
    actualizarTablaDetallesReceta(data);
    actualizarTablaModificador(data);

    $('#editar-receta').off('click').on('click', function() {
        const editarRecetaLink = document.getElementById('editar-receta');
        const productoId = editarRecetaLink.getAttribute('data-producto-id');
        $.ajax({
            url: '/api/get-productos-seleccionado/' + productoId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                TablaDetalleRecetas(data)
                
                $('#recetaTableBody').off('click', '#EditarDetalleReceta').on('click', '#EditarDetalleReceta', function() {
                    const row = this.closest('tr');
                    const cells = row.querySelectorAll('td');
                                    
                    cells.forEach(cell => {
                        if (cell.classList.contains('editable-cell-select')) {
                            const oldValue = cell.textContent.trim();
                            const select = document.createElement('select');
                            const options = ['Unid', 'Kilos', 'Gramos','Onza'];
                            options.forEach(option => {
                                const optionElement = document.createElement('option');
                                optionElement.textContent = option;
                                optionElement.value = option;
                                select.appendChild(optionElement);
                            });
                            select.value = oldValue;
                            const cellWidth = cell.getBoundingClientRect().width;
                            select.style.width = cellWidth + 'px';
                            select.classList.add('form-control');
                            cell.innerHTML = '';
                            cell.appendChild(select);
                        } else if(cell.classList.contains('editable-cell')) { 
                            const costoIngrediente = parseFloat(row.querySelector('td:nth-child(7)').textContent.trim());
                            const oldValue = cell.textContent.trim();
                            const input = document.createElement('input');
                            input.setAttribute('type', 'text');
                            input.setAttribute('value', oldValue);
                            input.classList.add('form-control');
                
                            // Agregar un evento input al input de cantidad neta para calcular la cantidad bruta y el costo total
                            input.addEventListener('input', function() {
                                const cantidadNeta = parseFloat(this.value);
                                const cantidadIngrediente = parseFloat(row.querySelector('td:nth-child(4)').textContent.trim());
                                const cantidadBruta = cantidadNeta * cantidadIngrediente; // Multiplicar por la cantidad de ingrediente
                                const cantidadBrutaCell = row.querySelector('.editable-cell:nth-child(5)');
                                cantidadBrutaCell.textContent = cantidadBruta.toFixed(2);
                                
                                // Calcular el costo multiplicando el costo del ingrediente por 2
                                const costoTotal = cantidadBruta * costoIngrediente;
                                const costoTotalCell = row.querySelector('.editable-cell:nth-child(7)');
                                costoTotalCell.textContent = costoTotal.toFixed(2);
                            });
                
                            const cellWidth = cell.getBoundingClientRect().width;
                            input.style.width = cellWidth + 'px';
                
                            // Reemplazar el contenido de la celda por el input creado
                            cell.innerHTML = '';
                            cell.appendChild(input);
                
                            // Agregar las clases y atributos necesarios al input
                            input.classList.add('editable-cell'); // Agregar clase editable-cell
                            input.classList.add('editable-cell-input'); // Agregar clase editable-cell-input
                            input.dataset.oldValue = oldValue; // Guardar el valor anterior en un atributo data
                        }
                    });
                
                    $(this).text('G');
                    $(this).attr('id', 'GuardarDetalleReceta');
                    $(this).removeClass('text-green').addClass('text-blue');
                
                    $(row).find('#EliminarDetalleReceta').hide();
                });
                
                $('#recetaTableBody').off('click', '#GuardarDetalleReceta').on('click', '#GuardarDetalleReceta', function(event) {
                    event.preventDefault(); // Evitar que el formulario se envíe de manera predeterminada
                    const row = $(this).closest('tr');
                    const rowIdCell = row.find('td:first-child');
                    const rowId = rowIdCell.text().trim();
                    const cells = row.find('td');
                    
                    const newData = {
                        producId: productoId,
                        id: rowId,
                        cantidadBruta: parseFloat(row.find('.editable-cell:nth-child(5)').text().trim()), // Obtener la cantidad bruta desde la celda
                        costoTotal: parseFloat(row.find('.editable-cell:nth-child(7)').text().trim()) // Obtener el costo total desde la celda
                    };
                    
                    cells.each(function(index, cell) {
                        const inputOrSelect = $(cell).find('input, select');
                        if (inputOrSelect.length > 0) {
                            const newValue = inputOrSelect.val();
                            newData[index] = newValue;
                            $(cell).text(newValue); // Actualizar el contenido de la celda con el nuevo valor
                        }
                    });
                    
                    $.ajax({
                        url: '/api/actualizar-detallereceta',
                        type: 'POST',
                        dataType: 'json',
                        data: newData,
                        success: function(response) {
                            actualizarTablaDetallesReceta(response);
                            MostrarMensaje("Actualizado Exitosamente","success");
                        },
                        error: function(error) {
                            console.error('Error al actualizar los datos:', error);
                        }
                    });
                    
                    $(this).text('E');
                    $(this).attr('id', 'EditarDetalleReceta');
                    $(this).removeClass('text-blue').addClass('text-green');
                    
                    row.find('#EliminarDetalleReceta').show();
                });
                
                $('#recetaTableBody').off('click', '#EliminarDetalleReceta').on('click', '#EliminarDetalleReceta', function(event) {
                    event.preventDefault(); 
                    var $this = $(this);
                    mostrarConfirmacion("¿Estás seguro de que deseas realizar esta acción?", function(esConfirmado) {
                        if (esConfirmado) {
                            const rowId = $this.closest('tr').find('td:first-child').text().trim(); // Usar la variable local
                            $.ajax({
                                url: '/api/eliminar-detallereceta',
                                type: 'POST',
                                dataType: 'json',
                                data: { id: rowId, producId: productoId },
                                success: function(response) {
                                    TablaDetalleRecetas(response);
                                    actualizarTablaDetallesReceta(response);
                                    MostrarMensaje("Eliminado Exitosamente","success");
                                },
                                error: function(error) {
                                    console.error('Error al eliminar el detalle de receta:', error);
                                }
                            });
                        } else {
                        }                        
                    });
                });
                
            },
            error: function(error) {
                console.error('Error al recuperar datos de proveedores:', error);
            }
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
        cargarCategoriasProducto();
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
                        <input type="text" class="form-control convertmayuscula" id="ProductoNombre" name="ProductoNombre">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label"></label>
                        <div class="col">
                            <div id="sugerencias-nombre" class="mt-2" style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; display: none;">
                            </div>
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
                    <div class="mb-3 row" hidden>
                        <label class="col-3 col-form-label required">Codigo</label>
                        <div class="col">
                        <input type="text" class="form-control" id="ProductoCodigo" name="ProductoCodigo">
                        </div>
                    </div>
                    <div class="mb-3 row" hidden>
                        <label class="col-3 col-form-label">Cocina</label>
                        <div class="col">
                        <select class="form-select">

                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row" hidden>
                        <label class="col-3 col-form-label">Proveedor</label>
                        <div class="col">
                        <select class="form-select" id="ProductoProveedor" name="ProductoProveedor">

                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Descripcion</label>
                        <div class="col">
                        <input type="text" class="form-control convertmayuscula" id="ProductoDescripcion" name="ProductoDescripcion">
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
             
        convertirAMayusculas();
        function convertirAMayusculas() {
            const inputs = document.querySelectorAll('.convertmayuscula');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    input.value = input.value.toUpperCase();
                });
            });
        }
        
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
                cargarSubcategoriasProducto(categoriaSeleccionada);
                $('#ProductoSubCategoria').parent().show();
            } else {
                $('#ProductoSubCategoria').parent().hide();
            }
        });

        $('#ProductoNombre').keyup(function() {
            var nombre = $(this).val();
            var inputsYBoton = $('#ProductoCategoria, #ProductoSubCategoria, #ProductoPrecio, #ProductoCosto, #ProductoCodigo, #ProductoProveedor, #ProductoDescripcion, #ProductoImagen, #btn-registrar-producto');
            
            if (nombre.length > 2) {
                $.ajax({
                    url: '/api/verificar-nombre-similar',
                    type: 'POST',
                    data: JSON.stringify({ Nombre: nombre }),
                    contentType: 'application/json',
                    success: function(response) {
                        var sugerenciasDiv = $('#sugerencias-nombre');
                        sugerenciasDiv.empty();
        
                        if (response.length > 0) {
                            sugerenciasDiv.show();
                            inputsYBoton.prop('disabled', true);
                            $.each(response, function(index, producto) {
                                sugerenciasDiv.append(`
                                    <div class="sugerencia-item">
                                        <strong>${producto.NombreProducto}</strong>
                                    </div>
                                `);
                            });
                        } else {
                            sugerenciasDiv.hide();
                            inputsYBoton.prop('disabled', false);
                        }
                    },
                    error: function(error) {
                        console.error('Error al verificar nombres similares:', error);
                    }
                });
            } else {
                $('#sugerencias-nombre').hide();
                inputsYBoton.prop('disabled', false);
            }
        });
        

        $('#btn-registrar-producto').off('click').on('click', function(event) {
            event.preventDefault();
        
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
            var imagen = $('#ProductoImagen')[0].files[0]; 
        
            // Verificar si el nombre del producto ya existe
            $.ajax({
                url: '/api/verificar-nombre-producto',
                type: 'POST',
                data: JSON.stringify({ Nombre: Nombre }),
                contentType: 'application/json',
                success: function(existe) {
                    if (existe) {
                        MostrarMensaje("El nombre del producto ya está en uso. Por favor, elige otro.", "warning");
                    } else {
                        // Si el nombre no existe, proceder con el registro
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
                        formData.append('imagen', imagen);
        
                        $.ajax({
                            url: '/api/registrar-producto',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(producto) {
                                ListProductos(Categoria);
                                MostrarMensaje("Producto Creado Exitosamente", "success");
                                $("#form-register-product")[0].reset();
                            },
                            error: function(error) {
                                console.error('Error al registrar:', error);
                            }
                        });
                    }
                },
                error: function(error) {
                    console.error('Error al verificar el nombre:', error);
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

function actualizarTablaDetallesReceta(data) {
    var detalleRecetaBody = document.getElementById('detalleRecetaBody');
    var totalCosto = 0;

    detalleRecetaBody.innerHTML = '';

    if (data.receta && data.receta.length > 0) {
        const tablaDetalle = document.getElementById('TableDetalle');
        tablaDetalle.style.display = 'block';
        
        data.receta.forEach(function (receta) {
            receta.detallerecetas.forEach(function (detalle) {                
                var row = `
                    <tr style="font-size: 13px">
                        <td>${detalle.ingrediente.NombreIngrediente}</td>
                        <td>${detalle.cantidadneta} ${detalle.unidad}</td>
                        <td>${detalle.ingrediente.CantidadIngrediente}</td>
                        <td>${detalle.cantidadbruta} ${detalle.unidad}</td>
                        <td>${detalle.costo}</td>
                    </tr>
                `;
                detalleRecetaBody.insertAdjacentHTML('beforeend', row);

                totalCosto += parseFloat(detalle.costo);
            });
        });

        var totalDetalleReceta = document.getElementById('TotalDetalleReceta');
        totalDetalleReceta.textContent = 'TOTAL RECETA: ' + totalCosto.toFixed(2);
    } else {
        const tablaDetalle = document.getElementById('TableDetalle');
        tablaDetalle.style.display = 'none';
        detalleRecetaBody.innerHTML = '<tr><td colspan="5">No se encontraron detalles de receta</td></tr>';
    }
}


function actualizarTablaModificador(data) {
    var detalleModificadorBody = document.getElementById('detalleModificadorBody');
    detalleModificadorBody.innerHTML = '';

    if (data.modificadore) {
        const tablaDetallemodificador = document.getElementById('TableDetalleModificadore');
        tablaDetallemodificador.style.display = 'block';
        var row = `
            <tr style="font-size: 13px">
                <td>${data.modificadore.id}</td>
                <td>${data.modificadore.NombreModificador}</td>
                <td>${data.modificadore.CantidadMinimaModificador} Min</td>
                <td>${data.modificadore.CantidadMaximaModificador} Max</td>
                <td>
                    <span class="badge badge-outline text-red eliminar-grupo">X</span>
                </td>
            </tr>
        `;
        detalleModificadorBody.insertAdjacentHTML('beforeend', row);
        detalleModificadorBody.querySelector('.eliminar-grupo').addEventListener('click', function() {
            const Idproducto = data.id
            var $this = $(this);
            mostrarConfirmacion("¿Estás seguro de que deseas realizar esta acción?", function(esConfirmado) {
                if (esConfirmado) {
                    const rowId = $this.closest('tr').find('td:first-child').text().trim();
                    $.ajax({
                        url: '/api/eliminar-grupomodificador',
                        type: 'GET',
                        dataType: 'json',
                        data: { id: rowId, Idproducto: Idproducto},
                        success: function(response) {
                            actualizarTablaModificador(response);
                            MostrarMensaje("Eliminado Exitosamente", "success");
                        },
                        error: function(error) {
                            console.error('Error al eliminar . . . ', error);
                        }
                    });
                } else {
                }
            });
        });
    } else {
    }
}


function TablaDetalleRecetas(data){
    const detallesReceta = data.receta[0].detallerecetas;
    const tableBody = document.getElementById('recetaTableBody');
    tableBody.innerHTML = '';
    detallesReceta.forEach(detalle => {
        const row = `
            <tr>
                <td>${detalle.id}</td>
                <td>${detalle.ingrediente.NombreIngrediente}</td>
                <td class="editable-cell">${detalle.cantidadneta}</td>
                <td>${detalle.ingrediente.CantidadIngrediente}</td>
                <td class="editable-cell">${detalle.cantidadbruta}</td>
                <td class="editable-cell-select">${detalle.unidad}</td>
                <td class="editable-cell">${detalle.ingrediente.CostoIngrediente}</td>
                <td>
                    <span class="badge badge-outline text-green" id="EditarDetalleReceta">E</span>
                    <span class="badge badge-outline text-red" id="EliminarDetalleReceta">X</span>
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
}


