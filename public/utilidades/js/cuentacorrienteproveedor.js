
$(document).ready(function() {
    TraerProveedorSelect()
    FechaSelectCuentaProveedor()
    filtrarDatosCuentaProveedor()
});

function mostrarResultadosCuentaProveedor(filteredData) {
    $('#tabla-cuenta-proveedores tbody').empty();
    $.each(filteredData.cuentas, function(index, cuenta) {
        if(cuenta.Eliminado == "true"){
            var row = '<tr>' +
                '<td hidden>' + cuenta.id + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + cuenta.proveedor.name + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + formatarFecha(cuenta.created_at) + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + cuenta.Monto + '</td>' +
                '</tr>';
            $('#tabla-cuenta-proveedores tbody').append(row);
        }else{
            var row = '<tr>' +
                '<td hidden>' + cuenta.id + '</td>' +
                '<td>' + cuenta.proveedor.name + '</td>' +
                '<td>' + formatarFecha(cuenta.created_at) + '</td>' +
                '<td>' + cuenta.Monto + '</td>' +
                '</tr>';
            $('#tabla-cuenta-proveedores tbody').append(row);
        }
    });

    $('#tabla-cuenta-proveedores tbody').on('click', 'tr', function() {
        $('#tabla-cuenta-proveedores tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');

        var id = $(this).find('td:first').text();
        $.ajax({
            url: '/api/get-cuenta-seleccionado-proveedor/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionCuentaProveedor(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos:', error);
            }
        });
    });
}

function InformacionCuentaProveedor(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">TRANSACCION</h3>
                <div class="card-actions">
                    <a href="#" class="btn" data-cuentaproveedor-id="${data.id}" id="DeleteCuenta" data-bs-toggle="modal" data-bs-target="#modal-delete-cuenta-proveedor">
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
                                <label class="col-8 col-form-label" style="color: #61677A">Pago a proveedor</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Proveedor</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.proveedor.name}</label>
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
                            <label class="col-4 col-form-label" style="font-weight: bold">Usar Arqueo Caja</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Arqueo}</label>
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

        $('#confirmDeleteBtnCuentaProveedor').one('click', function () {
            var formData = new FormData();
            formData.append('idcuenta', idcuenta);
            $.ajax({
                url: '/api/delete-cuenta-proveedor',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    CanvasTime()
                    ListarDatosProveedor()
                    filtrarDatosCuentaProveedor()
                    MostrarMensaje("Se Eliminó Exitosamente", "success");
                },
                error: function (error) {
                    console.error('Error al eliminar:', error);
                }
            });
        });
    });
}

function TraerProveedor() {
    $.ajax({
        url: 'api/get-proveedores-list-select',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#InputSelectProveedor');
            select.empty(); 
            var initialOption = $('<option></option>')
                .val('')
                .text('Seleccione un Proveedor');
            select.append(initialOption);
            data.forEach(function(proveedor) {
                var option = $('<option></option>')
                    .val(proveedor.id)
                    .text(proveedor.name );
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching clients:', error);
        }
    });
}

function TraerProveedorSelect(){
    $.ajax({
        url: 'api/get-proveedores-list-select',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#SelectProveedor');
            select.empty(); 
            var initialOption = $('<option></option>')
                .val('Todos')
                .text('Proveedor');
            select.append(initialOption);
            data.forEach(function(proveedor) {
                var option = $('<option></option>')
                    .val(proveedor.id)
                    .text(proveedor.name );
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching clients:', error);
        }
    });
}

function FechaSelectCuentaProveedor() {
    $('#SelectProveedor').on('change', function() {
        filtrarDatosCuentaProveedor();
    });
}

function filtrarDatosCuentaProveedor(){
    console.log("entro gooooooo")
    var TipoProveedor = $('#SelectProveedor').val();
    console.log(TipoProveedor)

    $.ajax({
        url: 'api/filtrar-datos-cuenta-proveedor',
        method: 'GET',
        data: {
            TipoProveedor: TipoProveedor,
        },
        success: function(response) {
            //MostrarDivCantidadGastos(response.cantidadregistros);
            mostrarResultadosCuentaProveedor(response);
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
    document.getElementById('addcuentaproveedor').addEventListener('click', function() {
        TraerProveedor()
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
                        <label class="col-4 col-form-label required">Proveedor</label>
                        <div class="col">
                            <select class="form-control" id="InputSelectProveedor">
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Monto</label>
                        <div class="col">
                            <input class="form-control" id="InputMontoProveedor" name="InputMontoProveedor">
                        </div>
                    </div>                    
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Medio De Pago</label>
                        <div class="col">
                            <select class="form-control" id="InputMedioDePagoProveedor" name="InputMedioDePagoProveedor">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Deposito/QR">Deposito/QR</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-4 col-form-label pt-0">Usar Arqueo Caja</label>
                        <div class="col">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="ArqueoProveedor" name="ArqueoProveedor">
                        </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Comentario</label>
                        <div class="col">
                        <textarea class="form-control" id="InputComentarioProveedor" name="InputComentarioProveedor">

                        </textarea>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-cuenta-proveedor">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-cuenta-proveedor').off('click').on('click', function(event) {
            var InputSelectProveedor = $("#InputSelectProveedor").val();
            var InputMontoProveedor = $("#InputMontoProveedor").val();
            var InputMedioDePagoProveedor = $("#InputMedioDePagoProveedor").val();
            var InputComentarioProveedor = $("#InputComentarioProveedor").val();
            var ArqueoProveedor = $("#ArqueoProveedor").prop('checked');
            
            var formData = new FormData();
            formData.append('Proveedor', InputSelectProveedor);
            formData.append('Monto', InputMontoProveedor);
            formData.append('MedioDePago', InputMedioDePagoProveedor);
            formData.append('Comentario', InputComentarioProveedor);
            formData.append('Arqueo', ArqueoProveedor);

            $.ajax({
                url: '/api/registrar-cuenta-proveedor',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (cuenta) {
                    CanvasTime()
                    ListarDatosProveedor()
                    filtrarDatosCuentaProveedor()
                    MostrarMensaje("Creado Exitosamente","success")
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });    
});