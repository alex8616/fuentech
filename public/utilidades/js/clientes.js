var currentPage = 1;
var isLoading = false;

$(document).ready(function() {
    ListarDatos();

    $('#searchcliente').on('input', function() {
        var searchValue = $(this).val().toLowerCase();
        currentPage = 1;
        ListarDatos(currentPage, 10, searchValue);
    });

    $('#tabla-clientes').on('scroll', function() {
        if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
            ListarDatos(currentPage, 10, $('#searchcliente').val().toLowerCase());
        }
    });
});

function ListarDatos(page = 1, limit = 10, search = '') {
    if (isLoading) return;
    isLoading = true;

    $.ajax({
        url: '/api/get-clientes',
        type: 'GET',
        data: { page: page, limit: limit, search: search },
        dataType: 'json',
        success: function(response) {
            const clientes = response.data;

            if (page === 1) {
                $('#tabla-clientes tbody').empty();
            }

            $.each(clientes, function(index, cliente) {
                var row = '<tr>' +
                    '<td hidden>' + cliente.id + '</td>' +
                    '<td>' + cliente.NombreCliente + '</td>' +
                    '<td>' + cliente.EmailCliente + '</td>' +
                    '<td>' + cliente.TelefonoCliente + '</td>' +
                    '<td>' + cliente.BarrioCliente + ' ' + cliente.CalleCliente + ' ' + cliente.NumeroCliente + '</td>' +
                    '<td>' + cliente.Total + '</td>' +
                    '</tr>';

                $('#tabla-clientes tbody').append(row);
            });

            $('#tabla-clientes tbody').on('click', 'tr', function() {
                $('#tabla-clientes tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');
                
                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/api/get-cliente-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionCliente(data);
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

function InformacionCliente(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">${data.NombreCliente}</h3>
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
                                <label class="col-8 col-form-label" style="color: #61677A">${data.NombreCliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Email</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.EmailCliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Teléfono</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.TelefonoCliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Dirección</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.BarrioCliente} ${data.CalleCliente} ${data.NumeroCliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Nit / Dni</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.NitDni}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Medio de Pago</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.MedioDePagoGasto} ${data.CalleCliente} ${data.NumeroCliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Medio de Pago</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.MedioDePagoGasto}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Descuento</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Descuento}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Tiene Cuenta</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.CuentaCorrienteCliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Activo</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.EstadoCliente}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

$(document).ready(function() {  
    document.getElementById('addclientes').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Cliente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control" id="NombreCliente" name="NombreCliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Email</label>
                        <div class="col">
                        <input type="mail" class="form-control" id="EmailCliente" name="EmailCliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Telefono</label>
                        <div class="col">
                            <input class="form-control" id="TelefonoCliente" name="TelefonoCliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Direccion</label>
                        <div class="col">
                            <input class="form-control" id="CalleCliente" name="CalleCliente" placeholder="Calle"><br>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <input class="form-control" id="NumeroCliente" name="NumeroCliente" placeholder="Numero">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input class="form-control" id="PisoCliente" name="PisoCliente" placeholder="Piso / Depto">
                                </div><br><br><br>
                                <div class="col-12 col-sm-12">
                                    <input class="form-control" id="BarrioCliente" name="BarrioCliente" placeholder="Barrio">
                                </div>
                            </div>
                        </div>                                    
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Comentario</label>
                        <div class="col">
                        <textarea class="form-control" id="Comentario" name="Comentario">

                        </textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nro Documento</label>
                        <div class="col">
                            <input class="form-control" id="NitDni" name="NitDni" placeholder="CI, NIT, RUT">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Medio De Pago</label>
                        <div class="col">
                            <select class="form-control" id="MedioDePagoGasto" name="MedioDePagoGasto">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Deposito/QR">Deposito/QR</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Descuento</label>
                        <div class="col">
                            <input type="number" class="form-control" id="DescuentoCliente" name="DescuentoCliente" placeholder="Porcentaje">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-form-label pt-0">Estado</label>
                        <div class="col">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="EstadoCliente" name="EstadoCliente" checked>
                        </label>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-cliente">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-cliente').off('click').on('click', function(event) {
            var NombreCliente = $("#NombreCliente").val();
            var EmailCliente = $("#EmailCliente").val();
            var TelefonoCliente = $("#TelefonoCliente").val();
            var CalleCliente = $("#CalleCliente").val();
            var NumeroCliente = $("#NumeroCliente").val();
            var PisoCliente = $("#PisoCliente").val();
            var BarrioCliente = $("#BarrioCliente").val();
            var Comentario = $("#Comentario").val();
            var NitDni = $("#NitDni").val();
            var MedioDePagoGasto = $("#MedioDePagoGasto").val();
            var DescuentoCliente = $("#DescuentoCliente").val();
            var EstadoCliente = $("#EstadoCliente").prop('checked');

            var formData = new FormData();
            formData.append('NombreCliente', NombreCliente);
            formData.append('EmailCliente', EmailCliente);
            formData.append('TelefonoCliente', TelefonoCliente);
            formData.append('CalleCliente', CalleCliente);
            formData.append('NumeroCliente', NumeroCliente);
            formData.append('PisoCliente', PisoCliente);
            formData.append('BarrioCliente', BarrioCliente);
            formData.append('Comentario', Comentario);
            formData.append('NitDni', NitDni);
            formData.append('MedioDePagoGasto', MedioDePagoGasto);
            formData.append('DescuentoCliente', DescuentoCliente);
            formData.append('EstadoCliente', EstadoCliente);

            $.ajax({
                url: '/api/registrar-cliente',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (cliente) {
                    ListarDatos()
                    CanvasTime()
                    TraerClienteSelect()
                    MostrarMensaje("Creado Exitosamente","success")
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});
