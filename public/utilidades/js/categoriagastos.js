$(document).ready(function() {
    ListCategoriaGasto()
});
//agregar GASTOS
$(document).ready(function() {  
    document.getElementById('addcategoriagastos').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Gasto</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Fecha</label>
                        <div class="col">
                        <input type="date" class="form-control" id="FechaRegistro" name="FechaRegistro">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Importe</label>
                        <div class="col">
                        <input type="text" class="form-control" id="Importe" name="Importe">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Medio De Pago</label>
                        <div class="col">
                        <select class="form-select" id="MedioDePago" name="MedioDePago">
                            
                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Categoria</label>
                        <div class="col">
                            <select class="form-select" id="CategoriaGasto" name="CategoriaGasto">
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Tipo Comprobante</label>
                        <div class="col">
                        <input type="number" class="form-control" id="TipoComprobante" name="TipoComprobante">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nro Comprobante</label>
                        <div class="col">
                        <input type="text" class="form-control" id="NroComprobante" name="NroComprobante">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-form-label pt-0">Usar En Arqueo</label>
                        <div class="col">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="CheckArqueo" name="CheckArqueo">
                        </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Comentario</label>
                        <div class="col">
                        <textarea class="form-control" id="Comentario" name="Comentario">

                        </textarea>
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

$(document).ready(function() {  
    document.getElementById('addcategoriagastos').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Categoria</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control" id="NombreCategoria" name="NombreCategoria">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-form-label pt-0">Activo</label>
                        <div class="col">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="CheckActivo" name="CheckActivo">
                        </label>
                        </div>
                    </div>                  
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-categoria-gasto">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-categoria-gasto').off('click').one('click', function(event) {
            var NombreCategoria = $("#NombreCategoria").val();
            var CheckActivo = $("#CheckActivo").prop('checked');
            var formData = new FormData();
            formData.append('NombreCategoria', NombreCategoria);
            formData.append('CheckActivo', CheckActivo);
            $.ajax({
                url: '/api/registrar-categoria-gastos',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    CanvasTime();
                    ListCategoriaGasto();
                    MostrarMensaje("Producto Creada Exitosamente", "success");
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});

function ListCategoriaGasto(){
    $.ajax({
        url: '/api/get-categoria-gastos',
        type: 'GET',
        success: function (response) {
            const tableBody = document.getElementById('tabla-categoria-gasto');
            tableBody.innerHTML = '';
            response.forEach(categoria => {
                var row = `
                    <tr>
                        <td hidden>${categoria.id}</td>
                        <td>${categoria.Nombre_categoria}</td>
                        <td style="text-align: right">
                            <span class="badge badge-outline text-red EliminarCategoria">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </span>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            
            $('#tabla-categoria-gasto').on('click', 'tr', function() {
                $('#tabla-categoria-gasto tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');

                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/api/get-categoria-gasto-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log("mostrando mis datos . . . . "+id)
                        InformacionCategoriaGasto(data);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de producto:', error);
                    }
                });
            });

            // Eliminar
            $('#tabla-categoria-gasto').one('click', '.EliminarCategoria', function(e) {
                const row = $(this).closest('tr');
                const id = row.find('td[hidden]').text();
                
                var formData = new FormData();
                formData.append('id', id);
                
                $.ajax({
                    url: '/api/delete-categoria-gasto',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        ListCategoriaGasto();
                        MostrarMensaje("Eliminado Exitosamente", "success");
                    },
                    error: function (error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });
        },
        error: function (error) {
            console.error('Error al registrar:', error);
        }
    });    
}

function InformacionCategoriaGasto(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">Categoria ${data[0].id}</h3>
                <div class="card-actions">
                    <a href="#" class="btn" data-movimientocaja-id="${data[0].id}" id="EditarCategoriaGasto" data-bs-toggle="modal" data-bs-target="#modal-danger">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-color-picker"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 7l6 6" /><path d="M4 16l11.7 -11.7a1 1 0 0 1 1.4 0l2.6 2.6a1 1 0 0 1 0 1.4l-11.7 11.7h-4v-4z" /></svg>
                    </a>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].Nombre_categoria}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].Estado}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}


