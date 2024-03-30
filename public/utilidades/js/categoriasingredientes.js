$(document).ready(function() {  
    MostrarTablaCategoriaIngrediente();

    document.getElementById('addpcategoriaingredientes').addEventListener('click', function() {
        cargarCategorias();
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Registrar Categoria Ingrediente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Nombre De Categoria</label>
                        <div class="col">
                        <input type="text" class="form-control" id="CategoriaIngredienteNombre" name="CategoriaIngredienteNombre">
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-ingrediente-categoria">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-ingrediente-categoria').off('click').on('click', function(event) {
            var Nombre = $("#CategoriaIngredienteNombre").val();
            var formData = new FormData();
            formData.append('Nombre', Nombre);
            $.ajax({
                url: '/api/registrar-ingrediente-categoria',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false, 
                success: function (categoria) {
                    MostrarTablaCategoriaIngrediente();
                    MostrarMensaje("Creado Exitosamente", "success");
                    $("#CategoriaIngredienteNombre").val("");
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});

function MostrarTablaCategoriaIngrediente(){        
    $.ajax({
        url: 'api/get-categoria-ingredientes',
        type: 'GET',
        dataType: 'json',
        success: function(categorias) {
            if (categorias.length > 0) {
                actualizarCategoriaTabla();
                function actualizarCategoriaTabla() {
                    var tablaCategorias = $('#tabla-categoria-ingredientes tbody');
                    tablaCategorias.empty();
                    $.each(categorias, function(index, categoria) {
                        var filaCategoria = '<tr class="categoria-fila-ingrediente" data-categoria-id="' + categoria.id + '">' +
                                                '<td>' + categoria.NombreCategoria + '</td>' +
                                                '<td style="font-weight: bold; padding-left: 40px">' + categoria.ingredientes_count + '</td>' +
                                                '<td style="font-weight: bold;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg></td>' +
                                            '</tr>';
                        tablaCategorias.append(filaCategoria);
                        });


                    $('.categoria-fila-ingrediente').on('click', function() {
                        $('.categoria-fila-ingrediente').removeClass('seleccionado');
                        $(this).addClass('seleccionado');
                        var categoriaID = $(this).data('categoria-id');
                        $.ajax({
                            url: '/api/get-categoria-ingredientes-seleccionado/' + categoriaID,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                var CategoriaDivs = document.getElementById('form_tabs');
                                CategoriaDivs.innerHTML = ``;
                                CategoriaDivs.innerHTML = `
                                <form id="form-register-product">
                                    <div class="card-header">
                                        <h3 class="card-title">${data.NombreCategoria}</h3>
                                        <div class="card-actions">
                                        <a href="#" class="btn" data-categoria-id="${data.id}" id="EditarCategoriaIngrediente">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                                        </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body">
                                            <div class="mb-12 row">
                                                <label class="col-3 col-form-label" style="font-weight: bold;">Nombre</label>
                                                <div class="col">
                                                <label class="col-9 col-form-label">${data.NombreCategoria}</label>
                                                </div>
                                            </div>
                                        </div>                    
                                    </div>
                                </form>
                                `;

                                $('#EditarCategoriaIngrediente').off('click').on('click', function(event) {
                                    var id = this.getAttribute('data-categoria-id');
                                    var CategoriaDivs = document.getElementById('form_tabs');
                                    CategoriaDivs.innerHTML = ``;
                                    CategoriaDivs.innerHTML = `
                                    <form id="form-register-product">
                                        <div class="card-header">
                                            <h3 class="card-title">Editando ${data.NombreCategoria}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="mb-12 row">
                                                    <label class="col-4 col-form-label" style="font-weight: bold;">Nombre</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="UpdateNombre_categoriaIngrediente" name="UpdateNombre_categoriaIngrediente" value="${data.NombreCategoria}">
                                                    </div>
                                                </div><br>                                            
                                            </div>                    
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex" style="text-align: right">
                                                <button type="button" class="btn me-auto">CANCELAR</button>
                                                <button type="button" class="btn btn-primary" id="btn-actualizar-categoria-ingrediente">ACTUALIZAR</button>
                                            </div>
                                        </div>
                                    </form>
                                    `;

                                    $('#btn-actualizar-categoria-ingrediente').off('click').on('click', function(event) {
                                        var EditNombre = $("#UpdateNombre_categoriaIngrediente").val();

                                        var datosRecogidos = {
                                            id: id,
                                            nombre: EditNombre,
                                        };

                                        $.ajax({
                                            url: '/api/actualizar-categoria-ingrediente/',
                                            type: 'POST',
                                            data: datosRecogidos,
                                            success: function (producto) {
                                                CanvasTime();
                                                MostrarTablaCategoriaIngrediente();
                                                MostrarMensaje("Se Actualizo La Categoria Exitosamente", "success");
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