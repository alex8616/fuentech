var currentPage = 1;
var isLoading = false;

$(document).ready(function() {
    ListarDatosProveedor();

    $('#searchproveedor').on('input', function() {
        var searchValue = $(this).val().toLowerCase();
        currentPage = 1;
        ListarDatosProveedor(currentPage, 10, searchValue);
    });

    $('#tabla-proveedores').on('scroll', function() {
        if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
            ListarDatosProveedor(currentPage, 10, $('#searchproveedor').val().toLowerCase());
        }
    });
});

function ListarDatosProveedor(page = 1, limit = 10, search = '') {
    if (isLoading) return;
    isLoading = true;

    $.ajax({
        url: '/api/get-proveedores-list',
        type: 'GET',
        data: { page: page, limit: limit, search: search },
        dataType: 'json',
        success: function(response) {
            const proveedores = response.data;

            if (page === 1) {
                $('#tabla-proveedores tbody').empty();
            }

            $.each(proveedores, function(index, proveedor) {
                var row = '<tr>' +
                    '<td hidden>' + proveedor.id + '</td>' +
                    '<td>' + proveedor.name + '</td>' +
                    '<td>' + proveedor.email + '</td>' +
                    '<td>' + proveedor.telefono + '</td>' +
                    '<td>' + proveedor.direccion + '</td>' +
                    '<td>' + proveedor.Total + '</td>' +
                    '</tr>';

                $('#tabla-proveedores tbody').append(row);
            });

            $('#tabla-proveedores tbody').on('click', 'tr', function() {
                $('#tabla-proveedores tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');
                
                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/api/get-proveedor-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionProveedor(data);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de producto:', error);
                    }
                });
            });

            isLoading = false;
            currentPage++;
        },
        error: function(error) {
            console.error('Error al recuperar datos de producto:', error);
            isLoading = false;
        }
    });
}

function InformacionProveedor(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">${data.name}</h3>
                <div class="card-actions">
                    <a href="#" class="btn" data-cleinte-id="${data.id}" id="DeleteGasto" data-bs-toggle="modal" data-bs-target="#modal-danger">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </a>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.name}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Email</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.email}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Teléfono</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.telefono}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Dirección</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.direccion}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Nit / Dni</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.documento}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.comentario}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Activo</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.estado}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

$(document).ready(function() {  
    document.getElementById('addproveedor').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Proveedor</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control" id="NombreProveedor" name="NombreProveedor">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Email</label>
                        <div class="col">
                        <input type="mail" class="form-control" id="EmailProveedor" name="EmailProveedor">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Telefono</label>
                        <div class="col">
                            <input class="form-control" type="number" id="TelefonoProveedor" name="TelefonoProveedor">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Direccion</label>
                        <div class="col">
                            <input class="form-control" id="DireccionProveedor" name="DireccionProveedor">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nit / CI</label>
                        <div class="col">
                            <input class="form-control" id="DocumentoProveedor" name="DocumentoProveedor">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Comentario</label>
                        <div class="col">
                            <input class="form-control" id="ComentarioProveedor" name="ComentarioProveedor">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-form-label pt-0">Estado</label>
                        <div class="col">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="EstadoProveedor" name="EstadoProveedor" checked>
                        </label>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-proveedor">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-proveedor').off('click').on('click', function(event) {
            var NombreProveedor = $("#NombreProveedor").val();
            var DocumentoProveedor = $("#DocumentoProveedor").val();
            var EmailProveedor = $("#EmailProveedor").val();
            var TelefonoProveedor = $("#TelefonoProveedor").val();
            var DireccionProveedor = $("#DireccionProveedor").val();
            var ComentarioProveedor = $("#ComentarioProveedor").val();
            var EstadoProveedor = $("#EstadoProveedor").prop('checked');

            var formData = new FormData();
            formData.append('NombreProveedor', NombreProveedor);
            formData.append('EmailProveedor', EmailProveedor);
            formData.append('TelefonoProveedor', TelefonoProveedor);
            formData.append('DireccionProveedor', DireccionProveedor);
            formData.append('ComentarioProveedor', ComentarioProveedor);
            formData.append('EstadoProveedor', EstadoProveedor);
            formData.append('DocumentoProveedor', DocumentoProveedor);

            $.ajax({
                url: '/api/registrar-proveedor',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (proveedor) {
                    ListarDatosProveedor()
                    CanvasTime()
                    TraerProveedorSelect()
                    MostrarMensaje("Creado Exitosamente","success")
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});
