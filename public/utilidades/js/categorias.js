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