$(document).ready(function() {  
    MostrarTablaModificadores();

    document.getElementById('addModificador').addEventListener('click', function() {
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
                        <label class="col-3 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control" id="NombreModificador" name="NombreModificador">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Nombre Publico</label>
                        <div class="col">
                        <input type="text" class="form-control" id="NombrePublicoModificador" name="NombrePublicoModificador">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Logica Del Precio Final</label>
                        <div class="col">
                            <select name="LogicaPrecioModificador" id="LogicaPrecioModificador" class="form-control">
                                <option value="Suma">Suma</option>
                                <option value="Maximo">Maximo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Cant. Minima</label>
                        <div class="col">
                        <input type="text" class="form-control" id="CantidadMinimaModificador" name="CantidadMinimaModificador">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required">Cant. Maxima</label>
                        <div class="col">
                        <input type="text" class="form-control" id="CantidadMaximaModificador" name="CantidadMaximaModificador">
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-modificador">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-modificador').off('click').on('click', function(event) {
            var Nombre = $("#NombreModificador").val();
            var NombrePublic = $("#NombrePublicoModificador").val();
            var Logica = $("#LogicaPrecioModificador").val();
            var CantMin = $("#CantidadMinimaModificador").val();
            var CantMax = $("#CantidadMaximaModificador").val();
        
            var formData = new FormData();
            formData.append('Nombre', Nombre);
            formData.append('NombrePublic', NombrePublic);
            formData.append('Logica', Logica);
            formData.append('CantMin', CantMin);
            formData.append('CantMax', CantMax);
        
            $.ajax({
                url: '/api/registrar-modificadore',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false, 
                success: function (modificadore) {
                    MostrarMensaje("Creado Exitosamente", "success");
                    $("#NombreModificador").val("");
                    $("#NombrePublicoModificador").val("");
                    $("#LogicaPrecioModificador").val("");
                    $("#CantidadMinimaModificador").val("");
                    $("#CantidadMaximaModificador").val("");
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});

function MostrarTablaModificadores(){        
    $.ajax({
        url: 'api/get-modificadores',
        type: 'GET',
        dataType: 'json',
        success: function(modificadores) {
            if (modificadores.length > 0) {
                actualizarModificadorTabla();
                function actualizarModificadorTabla() {
                    var tablamodificadores = $('#tabla-modificadores tbody');
                    tablamodificadores.empty();
                    $.each(modificadores, function(index, modificadore) {
                        var filamodificadore = '<tr class="modificador-fila" data-modificador-id="' + modificadore.id + '">' +
                                                '<td>' + modificadore.NombreModificador + '</td>' +
                                                '<td style="font-weight: bold; padding-left: 40px">' + modificadore.detallemodificador_count + '</td>' +
                                                '<td style="font-weight: bold; padding-left: 40px">' + modificadore.CantidadMinimaModificador + '</td>' +
                                                '<td style="font-weight: bold; padding-left: 40px">' + modificadore.CantidadMaximaModificador + '</td>' +
                                            '</tr>';
                                            tablamodificadores.append(filamodificadore);
                        });


                    $('.modificador-fila').on('click', function() {
                        $('.modificador-fila').removeClass('seleccionado');
                        $(this).addClass('seleccionado');
                        var modificadorID = $(this).data('modificador-id');
                        $.ajax({
                            url: '/api/get-modificador-seleccionado/' + modificadorID,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                var CategoriaDivs = document.getElementById('form_tabs');
                                CategoriaDivs.innerHTML = ``;
                                CategoriaDivs.innerHTML = `
                                <form id="form-register-product">
                                    <div class="card-header">
                                        <h3 class="card-title">${data.NombreModificador}</h3>
                                        <div class="card-actions">
                                        <a href="#" class="btn" data-modificador-id="${data.id}" id="EditarModificador">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                                        </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body">
                                            <div class="mb-12 row">
                                                <label class="col-3 col-form-label" style="font-weight: bold;">Nombre</label>
                                                <div class="col">
                                                <label class="col-9 col-form-label">${data.NombreModificador}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-3 col-form-label" style="font-weight: bold;">Nombre Publico</label>
                                                <div class="col">
                                                <label class="col-9 col-form-label">${data.NombrePublicoModificador}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-3 col-form-label" style="font-weight: bold;">Logica De Precio Final</label>
                                                <div class="col">
                                                <label class="col-9 col-form-label">${data.LogicaPrecioModificador}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-3 col-form-label" style="font-weight: bold;">Cant. Minima</label>
                                                <div class="col">
                                                <label class="col-9 col-form-label">${data.CantidadMinimaModificador}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-3 col-form-label" style="font-weight: bold;">Cant. Maxima</label>
                                                <div class="col">
                                                <label class="col-9 col-form-label">${data.CantidadMaximaModificador}</label>
                                                </div>
                                            </div>
                                            <div class="row justify-content-end">
                                                <div class="col-auto">
                                                    <button  type="button" class="btn btn-outline-dark" data-selectmodificador-id="${data.id}" id="btn-add-producto">Agregar Productos</button>
                                                </div>
                                            </div>
                                            <div class="mb-12 row" id="DivProductModificar" style="display: none">
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Nombre</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="UpdateNombreModificador" name="UpdateNombreModificador">
                                                    </div>
                                                </div><br>
                                            </div>
                                        </div>                    
                                    </div>
                                </form>
                                `;

                                
                                $('#btn-add-producto').off('click').on('click', function(event) {
                                    var id = this.getAttribute('data-selectmodificador-id');
                                    const divproduct = document.getElementById('DivProductModificar');
                                    divproduct.style.display = 'block';
                                    alert("El IDD es "+id)

                                    var DivProductos = document.getElementById('DivProductModificar');
                                    DivProductos.innerHTML = ``;
                                    DivProductos.innerHTML = `
                                    <form id="form-register-product">
                                        <div class="card-header">
                                            <h3 class="card-title">PRODUCTOS MODIFICADORES</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="mb-12 row">
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="SeachProductoModificador" name="SeachProductoModificador" placeholder="Buscar Producto . . .">
                                                    </div>
                                                </div><br>
                                                <div id="contenedor-product">
                                                </div>
                                            </div>                    
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex" style="text-align: right">
                                                <button type="button" class="btn me-auto" id="btn-cancelar-modificador-producto">CANCELAR</button>
                                                <button type="button" class="btn btn-primary" id="btn-registrar-modificador-producto">Guardar</button>
                                            </div>
                                        </div>
                                    </form>
                                    `;

                                    var productId = button.data('selectproduct-id');
                                    $.ajax({
                                        url: '/api/get-productos',
                                        method: 'GET',
                                        success: function(data) {
                                            
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Error al obtener las opciones:", error);
                                        }
                                    });
                                    
                                    $('#btn-cancelar-modificador-producto').off('click').on('click', function(event) {
                                        var id = this.getAttribute('data-selectmodificador-id');
                                        const divproduct = document.getElementById('DivProductModificar');
                                        divproduct.style.display = 'none';
                                    });
                                });

                                $('#EditarModificador').off('click').on('click', function(event) {
                                    var id = this.getAttribute('data-modificador-id');
                                    var CategoriaDivs = document.getElementById('form_tabs');
                                    CategoriaDivs.innerHTML = ``;
                                    CategoriaDivs.innerHTML = `
                                    <form id="form-register-product">
                                        <div class="card-header">
                                            <h3 class="card-title">Editando ${data.NombreModificador}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Nombre</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="UpdateNombreModificador" name="UpdateNombreModificador" value="${data.NombreModificador}">
                                                    </div>
                                                </div><br>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Nombre Publico</label>
                                                    <div class="col">
                                                    <input type="text" class="form-control" id="UpdateNombrePublicoModificador" name="UpdateNombrePublicoModificador" value="${data.NombrePublicoModificador}">
                                                    </div>
                                                </div><br>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Logica De Precio Final</label>
                                                    <div class="col">
                                                    <select id="UpdateLogicaPrecioModificador" name="UpdateLogicaPrecioModificador" class="form-control">
                                                        <option value="Suma">Suma</option>
                                                        <option value="Maximo">Maximo</option>
                                                    </select>
                                                    </div>
                                                </div><br>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Cant. Minima</label>
                                                    <div class="col">
                                                    <input type="text" class="form-control" id="UpdateCantidadMinimaModificador" name="UpdateCantidadMinimaModificador" value="${data.CantidadMinimaModificador}">
                                                    </div>
                                                </div><br>
                                                <div class="mb-12 row">
                                                    <label class="col-3 col-form-label" style="font-weight: bold;">Cant. Maxima</label>
                                                    <div class="col">
                                                    <input type="text" class="form-control" id="UpdateCantidadMaximaModificador" name="UpdateCantidadMaximaModificador" value="${data.CantidadMaximaModificador}">
                                                    </div>
                                                </div><br>                                                
                                            </div>                    
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex" style="text-align: right">
                                                <button type="button" class="btn me-auto">CANCELAR</button>
                                                <button type="button" class="btn btn-primary" id="btn-actualizar-modificador">ACTUALIZAR</button>
                                            </div>
                                        </div>
                                    </form>
                                    `;

                                    var logico = `${data.LogicaPrecioModificador}`;
                                    $('#UpdateLogicaPrecioModificador').val(logico).change();

                                    $('#btn-actualizar-modificador').off('click').on('click', function(event) {
                                        var NombreModificador = $("#UpdateNombreModificador").val();
                                        var NombrePublicoModificador = $("#UpdateNombrePublicoModificador").val();
                                        var LogicaPrecioModificador = $("#UpdateLogicaPrecioModificador").val();
                                        var CantidadMinimaModificador = $("#UpdateCantidadMinimaModificador").val();
                                        var CantidadMaximaModificador = $("#UpdateCantidadMaximaModificador").val();

                                        var datosRecogidos = {
                                            id: id,
                                            nombre: NombreModificador,
                                            nombrepublic: NombrePublicoModificador,
                                            logica: LogicaPrecioModificador,
                                            cantmin: CantidadMinimaModificador,
                                            cantmax: CantidadMaximaModificador,
                                        };

                                        $.ajax({
                                            url: '/api/actualizar-modificador/',
                                            type: 'POST',
                                            data: datosRecogidos,
                                            success: function (modificador) {
                                                CanvasTime();
                                                MostrarTablaModificadores();
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
                }
            } else {
                var tablamodificadores = $('#tabla-modificadores tbody');
                tablamodificadores.empty();
                tablamodificadores.append('<tr>' +
                '<td colspan="5" style="text-align: center">LA CATEGORIA NO TIENE REGISTROS AUN</td>' +
                '</tr>');
            }
        },
        error: function(error) {
            console.error('Error al recuperar datos:', error);
        }
    });  
}

function AddDivProduct(ingredienteSeleccionado, productId) {
    var divIngrediente = `
    <div class="row row-cards">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                <div class="mb-3 row" style="width: 35%; margin: 8px;">
                    <label class="col-12 col-form-label" id="RecuperarNombreIngrediente">xxx xx x</label>
                </div>
                <div class="mb-3 row" style="width: 30%; margin: 8px;">
                    <label class="col-4 col-form-label">Bs.</label>
                    <div class="col">
                    <input type="text" class="form-control"  id="Costo">
                    </div>
                </div>
                <div class="mb-3 row" style="width: 30%; margin: 8px;">
                    <label class="col-5 col-form-label">Max.</label>
                    <div class="col">
                    <input type="text" class="form-control"  id="CantiMax">
                    </div>
                </div>
                <div class="mb-3 row" style="width: 5%; margin: 8px;">
                <span class="badge badge-outline text-red">X</span>
                </div>
            </div>
        </div>
    </div>
    `;

    $("#contenedor-product").append(divIngrediente);

    $('#contenedor-ingrediente').off('change', '.row-cards').on('change', '.row-cards', calcularCantidadBrutaYTotal);

    calcularCantidadBrutaYTotal({ target: $('#contenedor-ingrediente').children().last().find('#CantidadNeta')[0] });

    $('#contenedor-ingrediente').on('click', '#EliminarFila', function() {
        $(this).closest('.row-cards').remove();
    });
}