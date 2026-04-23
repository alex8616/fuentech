
$(document).ready(function() {
    TraerClienteSelect()
    FechaSelectCuenta()
    filtrarDatosCuentas()
});

function mostrarResultadosCuentas(filteredData) {
    $('#tabla-cuenta-corriente tbody').empty();
    $.each(filteredData.cuentas, function(index, cuenta) {
        if(cuenta.Eliminado == "true"){
            var row = '<tr>' +
                '<td hidden>' + cuenta.id + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + cuenta.cliente.NombreCliente + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + formatarFecha(cuenta.created_at) + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + cuenta.Monto + '</td>' +
                '</tr>';
            $('#tabla-cuenta-corriente tbody').append(row);
        }else{
            var row = '<tr>' +
                '<td hidden>' + cuenta.id + '</td>' +
                '<td>' + cuenta.cliente.NombreCliente + '</td>' +
                '<td>' + formatarFecha(cuenta.created_at) + '</td>' +
                '<td>' + cuenta.Monto + '</td>' +
                '</tr>';
            $('#tabla-cuenta-corriente tbody').append(row);
        }
    });

    $('#tabla-cuenta-corriente tbody').on('click', 'tr', function() {
        $('#tabla-cuenta-corriente tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');

        var id = $(this).find('td:first').text();
        $.ajax({
            url: '/api/get-cuenta-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionCuenta(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos:', error);
            }
        });
    });
}

function InformacionCuenta(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">TRANSACCION</h3>
                <div class="card-actions">
                    <a href="#" class="btn" data-cuenta-id="${data.id}" id="DeleteCuenta" data-bs-toggle="modal" data-bs-target="#modal-delete-cuenta">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </a>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Tipo</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Tipo}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.cliente.NombreCliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Monto</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Monto}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Fecha Hora</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${formatarFecha(data.created_at)}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Medio de Pago</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.MedioDePago}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Comentario}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

    $('#DeleteCuenta').on('click', function(event) {
        var idcuenta = data.id

        $('#confirmDeleteBtnCuenta').one('click', function () {
            var formData = new FormData();
            formData.append('idcuenta', idcuenta);
            $.ajax({
                url: '/api/delete-cuenta',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (cuenta) {
                    CanvasTime()
                    ListarDatos()
                    filtrarDatosCuentas()
                    MostrarMensaje("Se Eliminó Exitosamente", "success");
                },
                error: function (error) {
                    console.error('Error al eliminar:', error);
                }
            });
        });
    });
}

function TraerCliente() {
    $.ajax({
        url: 'api/get-clientes-list',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#InputSelectCliente');
            select.empty(); 
            var initialOption = $('<option></option>')
                .val('')
                .text('Seleccione un Cliente');
            select.append(initialOption);
            data.forEach(function(cliente) {
                var option = $('<option></option>')
                    .val(cliente.id)
                    .text(cliente.NombreCliente );
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching clients:', error);
        }
    });
}

function TraerClienteSelect(){
    $.ajax({
        url: 'api/get-clientes-list',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#SelectCliente');
            select.empty(); 
            var initialOption = $('<option></option>')
                .val('Todos')
                .text('Cliente');
            select.append(initialOption);
            data.forEach(function(cliente) {
                var option = $('<option></option>')
                    .val(cliente.id)
                    .text(cliente.NombreCliente );
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching clients:', error);
        }
    });
}

function FechaSelectCuenta() {
    $('#SelectCliente').on('change', function() {
        filtrarDatosCuentas();
    });
}

function filtrarDatosCuentas(){
    var TipoCliente = $('#SelectCliente').val();

    $.ajax({
        url: 'api/filtrar-datos-cuenta',
        method: 'GET',
        data: {
            TipoCliente: TipoCliente,
        },
        success: function(response) {
            console.log(response)
            //MostrarDivCantidadGastos(response.cantidadregistros);
            mostrarResultadosCuentas(response);
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function formatarFecha(fechaString) {
    const fecha = new Date(fechaString);

    const dia = fecha.getDate();
    const mes = fecha.getMonth() + 1;
    const anio = fecha.getFullYear();
    const hora = fecha.getHours();
    const minutos = fecha.getMinutes();
    const segundos = fecha.getSeconds();

    const diaStr = (dia < 10 ? '0' : '') + dia;
    const mesStr = (mes < 10 ? '0' : '') + mes;
    const horaStr = (hora < 10 ? '0' : '') + hora;
    const minutosStr = (minutos < 10 ? '0' : '') + minutos;
    const segundosStr = (segundos < 10 ? '0' : '') + segundos;

    return `${diaStr}/${mesStr}/${anio} ${horaStr}:${minutosStr}:${segundosStr}`;
}

$(document).ready(function() {  
    document.getElementById('addcuentacorriente').addEventListener('click', function() {
        TraerCliente()
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Cuenta Corriente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Tipo</label>
                        <div class="col">
                        <span>Cobrar</span>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Cliente</label>
                        <div class="col">
                            <select class="form-control" id="InputSelectCliente">
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Monto</label>
                        <div class="col">
                            <input class="form-control" id="InputMonto" name="InputMonto">
                        </div>
                    </div>                    
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Medio De Pago</label>
                        <div class="col">
                            <select class="form-control" id="InputMedioDePago" name="InputMedioDePago">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Deposito/QR">Deposito/QR</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Comentario</label>
                        <div class="col">
                        <textarea class="form-control" id="InputComentario" name="InputComentario">

                        </textarea>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-cuenta-corrienta">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-cuenta-corrienta').off('click').on('click', function(event) {
            var InputSelectCliente = $("#InputSelectCliente").val();
            var InputMonto = $("#InputMonto").val();
            var InputMedioDePago = $("#InputMedioDePago").val();
            var InputComentario = $("#InputComentario").val();
            

            var formData = new FormData();
            formData.append('Cliente', InputSelectCliente);
            formData.append('Monto', InputMonto);
            formData.append('MedioDePago', InputMedioDePago);
            formData.append('Comentario', InputComentario);

            $.ajax({
                url: '/api/registrar-cuenta-corriente',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (cuenta) {
                    CanvasTime()
                    ListarDatos()
                    filtrarDatosCuentas()
                    MostrarMensaje("Creado Exitosamente","success")
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});