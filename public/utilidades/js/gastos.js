$(document).ready(function() {
    FechaSelectGasto()
    TraerProveedorGasto()
    TraerCategoriaGasto()
});

//agregar GASTOS
$(document).ready(function() {  
    document.getElementById('addgastos').addEventListener('click', function() {
        TraerCategoria()
        TraerProveedor()

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
                        <input type="number" class="form-control" id="Importe" name="Importe">
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
                        <label class="col-4 col-form-label required">Proveedor</label>
                        <div class="col">
                            <select class="form-select" id="ProveedorGasto" name="ProveedorGasto">
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
                            <select class="form-control" id="TipoComprobante" name="TipoComprobante">
                                <option value="TodoComprobante">Comprobante</option>
                                <option value="Factura">Factura</option>
                                <option value="Recibo">Recibo</option>
                            </select>
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
                    <button type="button" class="btn btn-primary" id="btn-registrar-gasto">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-gasto').off('click').on('click', function(event) {
            var Fecha = $("#FechaRegistro").val();
            var Importe = $("#Importe").val();
            var MedioDePagoGasto = $("#MedioDePagoGasto").val();
            var ProveedorGasto = $("#ProveedorGasto").val();
            var CategoriaGasto = $("#CategoriaGasto").val();
            var TipoComprobante = $("#TipoComprobante").val();
            var NroComprobante = $("#NroComprobante").val();
            var CheckArqueo = $("#CheckArqueo").prop('checked');
            var Comentario = $("#Comentario").val();

            var formData = new FormData();
            formData.append('Fecha', Fecha);
            formData.append('Importe', Importe);
            formData.append('MedioDePagoGasto', MedioDePagoGasto);
            formData.append('ProveedorGasto', ProveedorGasto);
            formData.append('CategoriaGasto', CategoriaGasto);
            formData.append('TipoComprobante', TipoComprobante);
            formData.append('NroComprobante', NroComprobante);
            formData.append('CheckArqueo', CheckArqueo);
            formData.append('Comentario', Comentario);

            $.ajax({
                url: '/api/registrar-gastos',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (gasto) {
                    filtrarDatosGasto()
                    CanvasTime()
                    MostrarMensaje("Creado Exitosamente","success")
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});

function FechaSelectGasto() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesGasto').empty();
    $('#AnioGasto').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesGasto').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesGasto').val(currentMonth + 1);

    var startYear = currentYear - 6;
    var endYear = currentYear;
    for (var year = startYear; year <= endYear; year++) {
        $('#AnioGasto').append('<option value="' + year + '">' + year + '</option>');
    }
    $('#AnioGasto').val(currentYear);

    function updateDaySelectorGasto() {
        var selectedMonth = parseInt($('#MesGasto').val());
        var selectedYear = parseInt($('#AnioGasto').val());
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaGasto').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaGasto').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaGasto').val(daysInMonth);
        } else {
            $('#DiaGasto').val(currentDay);
        }
    }

    updateDaySelectorGasto();

    $('#DateGasto').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioGasto':
                $('#DiaGastoContainer').show();
                $('#MesGastoContainer').show();
                $('#AnioGastoContainer').show();
                $('#FechaInicioContainerGasto').hide();
                $('#FechaFinContainerGasto').hide();
                break;
            case 'MensualGasto':
                $('#DiaGastoContainer').hide();
                $('#MesGastoContainer').show();
                $('#AnioGastoContainer').show();
                $('#FechaInicioContainerGasto').hide();
                $('#FechaFinContainerGasto').hide();
                break;
            case 'AnualGasto':
                $('#DiaGastoContainer').hide();
                $('#MesGastoContainer').hide();
                $('#AnioGastoContainer').show();
                $('#FechaInicioContainerGasto').hide();
                $('#FechaFinContainerGasto').hide();
                break;
            case 'RangoGasto':
                $('#DiaGastoContainer').hide();
                $('#MesGastoContainer').hide();
                $('#AnioGastoContainer').hide();
                $('#FechaInicioContainerGasto').show();
                $('#FechaFinContainerGasto').show();
                break;
            default:
                $('#DiaGastoContainer').show();
                $('#MesGastoContainer').show();
                $('#AnioGastoContainer').show();
                $('#FechaInicioContainerGasto').hide();
                $('#FechaFinContainerGasto').hide();
                break;
        }
        filtrarDatosGasto();
    });


    $('#MesGasto, #AnioGasto').on('change', function() {
        updateDaySelectorGasto();
        filtrarDatosGasto();
    });

    $('#DiaGasto').on('change', function() {
        filtrarDatosGasto();
    });

    $('#FechaInicioContainerGasto').on('change', function() {
        filtrarDatosGasto();
    });

    $('#FechaFinContainerGasto').on('change', function() {
        filtrarDatosGasto();
    });

    $('#ProveedorGastoSelect').on('change', function() {
        filtrarDatosGasto();
    });

    $('#CategoriaGastoSelect').on('change', function() {
        filtrarDatosGasto();
    });

    $('#ComprobanteGasto').on('change', function() {
        filtrarDatosGasto();
    });

    $('#MetodoPagoVenta').on('change', function() {
        filtrarDatosGasto();
    });

    $('#DateGasto').trigger('change');

}

function filtrarDatosGasto(){
    var tipoFiltro = $('#DateGasto').val();
    var dia = $('#DiaGasto').val();
    var mes = $('#MesGasto').val();
    var anio = $('#AnioGasto').val();
    var fechaInicio = $('#fechaInicioGasto').val();
    var fechaFin = $('#fechaFinGasto').val();
    var TipoProveedor = $('#ProveedorGastoSelect').val();
    var TipoCategoria = $('#CategoriaGastoSelect').val();
    var TipoComprobante = $('#ComprobanteGasto').val();
    var TipoDePago = $('#MetodoPagoVenta').val();

    $.ajax({
        url: 'api/filtrar-datos-gasto',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            TipoProveedor: TipoProveedor,
            TipoCategoria: TipoCategoria,
            TipoComprobante: TipoComprobante,
            TipoDePago: TipoDePago
        },
        success: function(response) {
            MostrarDivCantidadGastos(response.cantidadregistros);
            mostrarResultadosGastos(response);
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function MostrarDivTotalGastos(total){
    $('#PrecioTotal').text('Bs. '+total);
}

function MostrarDivCantidadGastos(cantidad){
    $('#CantidadRegistroDatos').text(cantidad);
}

function mostrarResultadosGastos(filteredData) {
    $('#tabla-gasto tbody').empty();
    $.each(filteredData.gastos, function(index, gasto) {
        var row = '<tr>' +
            '<td hidden>' + gasto.id + '</td>' +
            '<td>' + gasto.FechaRegistro + '</td>' +
            '<td>' + (gasto.proveedor && gasto.proveedor.name ? gasto.proveedor.name : 'No seleccionado') + '</td>'+
            '<td>' + (gasto.categoriagasto && gasto.categoriagasto.Nombre_categoria ? gasto.categoriagasto.Nombre_categoria : 'No seleccionado') + '</td>'+
            '<td>' + gasto.Comentario + '</td>' +
            '<td>' + gasto.Importe + '</td>' +
            '</tr>';

        $('#tabla-gasto tbody').append(row);
    });

    //agregarEventosMovimientoTabla();

    $('#tabla-gasto tbody').on('click', 'tr', function() {
        var id = $(this).find('td:first').text();
        $('#tabla-gasto tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');

        $.ajax({
            url: '/api/get-gasto-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionGasto(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos de producto:', error);
            }
        });
    });
}

function InformacionGasto(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">GASTO ${data[0].id}</h3>
                    <div class="card-actions">
                        <a href="#" class="btn" data-gasto-id="${data[0].id}" id="DeleteGasto" data-bs-toggle="modal" data-bs-target="#modal-danger">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </a>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].FechaRegistro}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Creado Por</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].user.name}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Importe</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].Importe}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Medio De Pago</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].MedioDePago}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Proveedor</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].proveedor.name}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Categoria</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].categoriagasto.Nombre_categoria}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Tipo Comprobante</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].TipoConprobante} # ${data[0].NumeroComprobante}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Arqueo Caja</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].UsarArqueo} </label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].Comentario} </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="ContainerDetalleGastosList">
                        <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                            <h3 class="card-title">DETALLE</h3>
                        </div>
                        <div id="DetalleGastosList">
                            
                        </div>
                    </div>

                    <hr>

                    <div class="row" style="display: none" id="DetalleGastos">
                        <div class="col-12 col-md-12">
                            <div class="input-icon mb-3">
                                <input type="text" id="SearchProduct" class="form-control" placeholder="Busca un producto">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                </span>
                            </div>
                            <div id="ProductList"></div>
                        </div>
                         <div class="col-12 col-md-12">                            
                            <div class="row">
                                <div class="col-12 col-md-12" id="SelectedProducts">

                                </div>
                                <div class="col-12 col-md-6">
                                    <a class="btn btn-outline-danger w-100" id="btn-cancelar-detalle">
                                        Cancelar
                                    </a>
                                </div>
                                <div class="col-12 col-md-6">
                                    <a class="btn btn-outline-success w-100" id="btn-registrar-detalle">
                                        Registrar
                                    </a>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="row" id="btnDetalleGastos">
                        <div class="col-12 col-md-3">
                            <div class="mb-3 row">
                                <a class="btn btn-outline-primary w-100" id="btn-agregar-detalle">
                                    Agregar Detalle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        var ContainerDetalleGastosList = document.getElementById('ContainerDetalleGastosList');
        var detalleGastosList = document.getElementById('DetalleGastosList');
        if (data[0].detallegasto.length > 0) {
            data[0].detallegasto.forEach(function(detallegasto) {
                if(detallegasto.eliminado == "true"){
                    var detalleHTML = `
                        <div class="row" style="margin: 5px; background: red">
                            <div class="col-12 col-md-3" style="padding: 10px;">
                                ${detallegasto.cantidad} Und.
                            </div>
                            <div class="col-12 col-md-5" style="padding: 10px;">
                                ${detallegasto.productos.NombreProducto}
                            </div>
                            <div class="col-12 col-md-2" style="padding: 10px;">
                                ${detallegasto.total}
                            </div>
                            <div class="col-12 col-md-1" style="padding: 10px; text-align: right;">
                                <a class="btn btn-outline-danger w-100 btn-delete-detalle" data-id="${detallegasto.id}">
                                    <span style="color: black">X</span>
                                </a>
                            </div>
                        </div>
                    `;
                }else{
                    var detalleHTML = `
                        <div class="row" style="margin: 5px; background: #EEEEEE">
                            <div class="col-12 col-md-3" style="padding: 10px;">
                                ${detallegasto.cantidad} Und.
                            </div>
                            <div class="col-12 col-md-5" style="padding: 10px;">
                                ${detallegasto.productos.NombreProducto}
                            </div>
                            <div class="col-12 col-md-2" style="padding: 10px;">
                                ${detallegasto.total}
                            </div>
                            <div class="col-12 col-md-1" style="padding: 10px; text-align: right;">
                                <a class="btn btn-outline-danger w-100 btn-delete-detalle" data-id="${detallegasto.id}">
                                    <span style="color: black">X</span>
                                </a>
                            </div>
                        </div>
                    `;
                }
                detalleGastosList.innerHTML += detalleHTML;                
            });
        
            detalleGastosList.addEventListener('click', function(event) {
                if (event.target.closest('.btn-delete-detalle')) {
                    var detalleId = event.target.closest('.btn-delete-detalle').getAttribute('data-id');

            
                    var formData = new FormData();
                    formData.append('detalleId', detalleId);
            
                    $.ajax({
                        url: '/api/delete-detalle-gasto',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            InformacionGasto(response)
                            MostrarMensaje("Eliminado Exitosamente","success")
                        },
                        error: function (error) {
                            console.error('Error al registrar:', error);
                        }
                    });
                }
            });
        } else {
            ContainerDetalleGastosList.style.display = 'none';
        }


        $('#btn-agregar-detalle').off('click').on('click', function(event) {
            document.getElementById('DetalleGastos').style.display = 'block';
            document.getElementById('btnDetalleGastos').style.display = 'none';

            $('#SearchProduct').on('input', function() {
                var query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: '/api/get-productos',
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#ProductList').empty();
            
                            var filteredProducts = response.filter(function(product) {
                                return product.NombreProducto.toLowerCase().includes(query.toLowerCase());
                            });
            
                            filteredProducts.forEach(function(product) {
                                var productHtml = `
                                    <div class="product-item" data-id="${product.id}" data-name="${product.NombreProducto}">
                                        ${product.NombreProducto}
                                    </div>
                                `;
                                $('#ProductList').append(productHtml);
                            });
            
                            // Añadir producto seleccionado
                            $('.product-item').on('click', function() {
                                var productId = $(this).data('id');
                                var productName = $(this).data('name');
            
                                var selectedProductHtml = `
                                    <div class="selected-product" data-id="${productId}" style="width: 100%">
                                        <div class="row">
                                            <div class="col-12 col-md-1">
                                                <div class="mb-12 row" style="padding: 5px; padding-left: 5px;">
                                                    <label class="col-6 col-form-label"></label>
                                                    <div class="col">
                                                        <input class="form-check-input" type="checkbox" id="StockIncrement" name="StockIncrement" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-12 row">
                                                    <label class="col-12 col-form-label">${productName}</label>                                              
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <div class="mb-12 row">
                                                    <label class="col-6 col-form-label">Cant.</label>
                                                    <div class="col">
                                                        <input class="form-control" type="text" id="CantidadProducto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="mb-12 row">
                                                    <label class="col-6 col-form-label">Costo</label>
                                                    <div class="col">
                                                        <input class="form-control" id="CostoProducto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1">
                                                <div class="mb-12 row">
                                                    <a class="btn btn-outline-danger w-100 btn-quitar-detalle">
                                                        X
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#SelectedProducts').append(selectedProductHtml);
            
                                $('#ProductList').empty();
                                $('#SearchProduct').val('');
                            });
            
                            // Eliminar producto seleccionado
                            $('#SelectedProducts').on('click', '.btn-quitar-detalle', function() {
                                $(this).closest('.selected-product').remove();
                            });
                        },
                        error: function(error) {
                            console.error('Error fetching products:', error);
                        }
                    });
                } else {
                    $('#ProductList').empty();
                }
            });
            
        });

        $('#btn-cancelar-detalle').off('click').on('click', function(event) {
            document.getElementById('DetalleGastos').style.display = 'none';
            document.getElementById('btnDetalleGastos').style.display = 'block';
            
        });

        $('#btn-registrar-detalle').on('click', function() {
            var productosSeleccionados = [];
        
            $('#SelectedProducts .selected-product').each(function() {
                var productId = $(this).data('id');
                var cantidad = $(this).find('#CantidadProducto').val();
                var costo = $(this).find('#CostoProducto').val();
                var stockIncrement = $(this).find('#StockIncrement').is(':checked');
                var idgasto = data[0].id

                productosSeleccionados.push({
                    idgasto: idgasto,
                    id: productId,
                    cantidad: cantidad,
                    costo: costo,
                    stockIncrement: stockIncrement
                });
            });
        
            $.ajax({
                url: '/api/registrar-detalle-gasto',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ detalles: productosSeleccionados }),
                success: function(response) {
                    InformacionGasto(response)
                    MostrarMensaje("Registrado Exitosamente","success")
                },
                error: function(error) {
                    console.error('Error registrando productos:', error);
                }
            });
        });
}


function TraerCategoria() {
    $.ajax({
        url: 'api/get-categoria-gastos',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#CategoriaGasto');
            select.empty(); 
            var initialOption = $('<option></option>')
                .val('')
                .text('Seleccione una categoría');
            select.append(initialOption);
            data.forEach(function(categoria) {
                var option = $('<option></option>')
                    .val(categoria.id)
                    .text(categoria.Nombre_categoria);
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching clients:', error);
        }
    });
}

function TraerProveedor() {
    $.ajax({
        url: 'api/get-proveedor',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#ProveedorGasto');
            select.empty();
            var initialOption = $('<option></option>')
                .val('')
                .text('Seleccione un proveedor');
            select.append(initialOption);
            data.forEach(function(proveedor) {
                var option = $('<option></option>')
                    .val(proveedor.id)
                    .text(proveedor.name);
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching clients:', error);
        }
    });
}

function TraerProveedorGasto() {
    $.ajax({
        url: 'api/get-proveedor',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#ProveedorGastoSelect');
            data.forEach(function(proveedor) {
                var option = $('<option></option>')
                    .val(proveedor.id)
                    .text(proveedor.name);
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching clients:', error);
        }
    });
}

function TraerCategoriaGasto(){
    $.ajax({
        url: 'api/get-categoria-gastos',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#CategoriaGastoSelect');
            data.forEach(function(categoria) {
                var option = $('<option></option>')
                    .val(categoria.id)
                    .text(categoria.Nombre_categoria);
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching users:', error);
        }
    });
}