
$(document).ready(function() {
    FechaSelect()
    MostrarTablaMovimientoStock()
    InfoMovimientos()
    DateProdIngre()
});


function DateProdIngre() {
    $.ajax({
        url: '/api/get-all-data',
        method: 'GET',
        success: function(response) {
            var productos = response.productos;
            var ingredientes = response.ingredientes;
            
            var items = [];

            // Combina productos e ingredientes en un solo array para autocompletar
            productos.forEach(function(producto) {
                items.push({ label: producto.NombreProducto, value: 'producto-' + producto.id, type: 'producto' });
            });

            ingredientes.forEach(function(ingrediente) {
                items.push({ label: ingrediente.NombreIngrediente, value: 'ingrediente-' + ingrediente.id, type: 'ingrediente' });
            });

            $('#SearchMovimientos').autocomplete({
                source: items,
                select: function(event, ui) {
                    event.preventDefault();
                    
                    var selectedLabel = ui.item.label;
                    var selectedValue = ui.item.value;
                    var selectedType = ui.item.type;
                    
                    $('#SearchMovimientos').val(selectedLabel);
                    $('#SearchMovimientos').data('selected-id', selectedValue);
                    $('#SearchMovimientos').data('selected-type', selectedType);

                    filtrarDatos();
                }
            });

            $('#SearchMovimientos').on('keyup', function() {
                var searchText = $(this).val().trim();
                if (searchText === '') {
                    $('#SearchMovimientos').data('selected-id', '');
                    $('#SearchMovimientos').data('selected-type', '');
                    filtrarDatos();
                }
            });
        },
        error: function(error) {
            console.error('Error al obtener los datos:', error);
        }
    });
}


function FechaSelect() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesStock').empty();
    $('#AnioStock').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesStock').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesStock').val(currentMonth + 1);

    var startYear = currentYear - 6;
    var endYear = currentYear;
    for (var year = startYear; year <= endYear; year++) {
        $('#AnioStock').append('<option value="' + year + '">' + year + '</option>');
    }
    $('#AnioStock').val(currentYear);

    function updateDaySelector() {
        var selectedMonth = parseInt($('#MesStock').val());
        var selectedYear = parseInt($('#AnioStock').val());
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaStock').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaStock').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaStock').val(daysInMonth);
        } else {
            $('#DiaStock').val(currentDay);
        }
    }

    updateDaySelector();

    $('#DateStock').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioStock':
                $('#DiaStockContainer').show();
                $('#MesStockContainer').show();
                $('#AnioStockContainer').show();
                $('#FechaInicioContainer').hide();
                $('#FechaFinContainer').hide();
                break;
            case 'MensualStock':
                $('#DiaStockContainer').hide();
                $('#MesStockContainer').show();
                $('#AnioStockContainer').show();
                $('#FechaInicioContainer').hide();
                $('#FechaFinContainer').hide();
                break;
            case 'AnualStock':
                $('#DiaStockContainer').hide();
                $('#MesStockContainer').hide();
                $('#AnioStockContainer').show();
                $('#FechaInicioContainer').hide();
                $('#FechaFinContainer').hide();
                break;
            case 'RangoStock':
                $('#DiaStockContainer').hide();
                $('#MesStockContainer').hide();
                $('#AnioStockContainer').hide();
                $('#FechaInicioContainer').show();
                $('#FechaFinContainer').show();
                break;
            default:
                $('#DiaStockContainer').show();
                $('#MesStockContainer').show();
                $('#AnioStockContainer').show();
                $('#FechaInicioContainer').hide();
                $('#FechaFinContainer').hide();
                break;
        }
        filtrarDatos();
    });

    $('#MesStock, #AnioStock').on('change', function() {
        updateDaySelector();
        filtrarDatos();
    });

    $('#DiaStock').on('change', function() {
        filtrarDatos();
    });

    $('#FechaInicioContainer').on('change', function() {
        filtrarDatos();
    });

    $('#FechaFinContainer').on('change', function() {
        filtrarDatos();
    });

    $('#TipoStock').on('change', function() {
        filtrarDatos();
    });

    $('#EventoStock').on('change', function() {
        filtrarDatos();
    });

    $('#SearchMovimientos').on('change', function() {
        filtrarDatos();
    });

    $('#DateStock').trigger('change');
}

function filtrarDatos() {
    var tipoFiltro = $('#DateStock').val();
    var dia = $('#DiaStock').val();
    var mes = $('#MesStock').val();
    var anio = $('#AnioStock').val();
    var fechaInicio = $('#fechaInicio').val();
    var fechaFin = $('#fechaFin').val();
    var TipoStock = $('#TipoStock').val();
    var EventoStock = $('#EventoStock').val();
    var searchText = $('#SearchMovimientos').data('selected-id') || '';
    $.ajax({
        url: 'api/filtrar-datos',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            TipoStock: TipoStock,
            EventoStock: EventoStock,
            searchText: searchText
        },
        success: function(response) {
            mostrarResultados(response);
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function mostrarResultados(filteredData) {
    $('#tabla-stockmovimiento tbody').empty();
    $.each(filteredData, function(index, movimiento) {
        var borderStyle = (movimiento.TipoStock == 'Salida') ? 'border-left: 4px solid red;' : 'border-left: 4px solid green;';
        var row = '<tr style="' + borderStyle + '">' +
            '<td hidden>' + movimiento.id + '</td>' +
            '<td>' + movimiento.TipoStock + '</td>' +
            '<td>' + (movimiento.producto_id ? 'Producto' : (movimiento.ingrediente_id ? 'Ingrediente' : '-')) + '</td>' +
            '<td>' + movimiento.NombreProducto + '</td>' +
            '<td>' + movimiento.StockAnterior + '</td>' +
            '<td>' + movimiento.StockActual + '</td>' +
            '<td>' + movimiento.Diferencia + '</td>' +
            '<td>' + movimiento.FechaStock + '</td>' +
            '</tr>';
        $('#tabla-stockmovimiento tbody').append(row);
    });

    agregarEventosMovimientoTabla();

    $('#tabla-stockmovimiento tbody').on('click', 'tr', function() {
        $('#tabla-stockmovimiento tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');

        var id = $(this).find('td:first').text();
        $.ajax({
            url: '/api/get-movimiento-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionMovimientoStock(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos de producto:', error);
            }
        });
    });
}

/*DATOS DE FILTRADO ARRIBA*/
function InfoMovimientos(){
    $.ajax({
        url: 'api/get-movimientos-cantidad',
        type: 'GET',
        success: function(data) {
            var startDate = new Date(data.day);
            var endDate = new Date(data.daymore);

            var formattedStartDate = ('0' + startDate.getDate()).slice(-2) + '/' + ('0' + (startDate.getMonth() + 1)).slice(-2) + '/' + startDate.getFullYear().toString().slice(-2);
            var formattedEndDate = ('0' + endDate.getDate()).slice(-2) + '/' + ('0' + (endDate.getMonth() + 1)).slice(-2) + '/' + endDate.getFullYear().toString().slice(-2);

            $('#FechaInicio').text(formattedStartDate);
            $('#FechaFinal').text(formattedEndDate);
            $('#CantidadRegistro').text(data.count + (data.count > 1 ? ' registros' : ' registro'));
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function MostrarTablaMovimientoStock(){
    $.ajax({
        url: 'api/get-movimientos-stock',
        type: 'GET',
        success: function(data) {
            $('#tabla-stockmovimiento tbody').empty();
            $.each(data, function(index, movimiento) {
                var borderStyle = (movimiento.TipoStock == 'Salida') ? 'border-left: 4px solid red;' : 'border-left: 4px solid green;';
                var row = '<tr style="' + borderStyle + '">' +
                    '<td hidden>' + movimiento.id + '</td>' +
                    '<td>' + movimiento.TipoStock + '</td>' +
                    '<td>' + (movimiento.producto_id ? 'Producto' : (movimiento.ingrediente_id ? 'Ingrediente' : '-')) + '</td>' +
                    '<td>' + movimiento.NombreProducto + '</td>' +
                    '<td>' + movimiento.StockAnterior + '</td>' +
                    '<td>' + movimiento.StockActual + '</td>' +
                    '<td>' + movimiento.Diferencia + '</td>' +
                    '<td>' + movimiento.FechaStock + '</td>' +
                    '</tr>';
                $('#tabla-stockmovimiento tbody').append(row);
            });

            agregarEventosMovimientoTabla();

            $('#tabla-stockmovimiento tbody').on('click', 'tr', function() {
                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/api/get-movimiento-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionMovimientoStock(data);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de producto:', error);
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function agregarEventosMovimientoTabla() {
    $('#tabla-stockmovimiento tbody tr').hover(function() {
        $(this).addClass('hovered');
    }, function() {
        $(this).removeClass('hovered');
    });
    $('#tabla-stockmovimiento tbody tr').click(function() {
        $('#tabla-stockmovimiento tbody tr').removeClass('tableproducseleccionado');
        $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
    });
}

function InformacionMovimientoStock(data){
    var TotalProduct = document.getElementById('form_tabs');
    var NameDate
    var ExitNombre
    var Comentario
    var Tipo
    if(data.movimiento.ingredientes == null){
        NameDate = 'Producto'
        ExitNombre = data.movimiento.productos.NombreProducto
        Comentario = data.movimiento.productos.ComentarioStock
        Tipo = data.movimiento.TipoStock
    }else{
        NameDate = 'Ingrediente'
        ExitNombre = data.movimiento.ingredientes.NombreIngrediente
        Comentario = data.movimiento.ingredientes.ComentarioStock
    }

    TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">${data.movimiento.NombreProducto}</h3>
                    <div class="card-actions">
                        <a href="#" class="btn" data-ingrediente-id="${data.movimiento.id}" id="AddIngredienteStock">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Evento</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.movimiento.TipoStock} unid. (En Stock)</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">${NameDate}</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${ExitNombre}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Stock Anterior</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.movimiento.StockAnterior} unid.</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Stock Actual</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.movimiento.StockActual} unid.</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Diferencia</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.movimiento.Diferencia} unid.</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.movimiento.FechaStock}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Usuario</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">Sin Date Moment</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${Comentario}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    ${Tipo === "Adición Creada" ? `
                    <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                        <div class="card-body" style="padding: 0px; margin: 0px;">
                            <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                <h3 class="card-title" style="color: black; margin: 0">VENTA</h3>
                            </div>
                            <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                <div class="col-md-12" style="width: 100%; background: white; padding: 10px">
                                    <p style="color: #61677A;width: 100%;">
                                        <span style="font-weight: bold; color: black;">Hora Inicio</span> ${data.consumo[0].fecha_venta ? formatarFecha(data.consumo[0].fecha_venta) : ''}
                                    </p>
                                    <p style="color: #61677A;width: 100%;">
                                        <span style="font-weight: bold; color: black;">Hora cierre</span> ${data.consumo[0].fecha_venta ? formatarFecha(data.consumo[0].fecha_venta) : ''}
                                    </p>
                                    <p style="color: #61677A;width: 100%;">
                                        <span style="font-weight: bold; color: black;">Total de la venta Bs.</span> ${data.consumo[0].total}
                                    </p>
                                    <p style="color: #61677A;width: 100%;">
                                        <span style="font-weight: bold; color: black;">Mesa</span> ${data.consumo[0].ambiente_mesa_id}
                                    </p>
                                </div>

                                <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                    ${data.consumo[0].detalleconsumos.map((detalle, index) => `
                                        ${detalle.eliminado === "true" ? `
                                            <div id="CardOcupado" class="card col-md-12 col-lg-12">
                                                <div class="card-status-start bg-primary" style="background: red"></div>
                                                <div class="card-header">
                                                    <div style="width: 100%; display: flex;">
                                                        <div class="col-md-12 col-lg-2" style="width: 20%;">
                                                            <h3 class="card-title">${detalle.cantidad}</h3>
                                                        </div>
                                                        <div class="col-md-12 col-lg-7" style="text-align: left; width: 60%;">
                                                            <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                            <p style="font-size: 12px">CANCELADO: ${detalle.comentarioeliminado}</p>
                                                        </div>
                                                        <div class="col-md-12 col-lg-3" style="width: 20%;">
                                                            <h3 class="card-title">${detalle.total} <strong>Bs.</strong></h3>                                                                    
                                                        </div>                                                                
                                                    </div>
                                                </div>                                                       
                                            </div><br>
                                        ` : `
                                            <div class="card col-md-12 col-lg-12">
                                                <div class="card-status-start bg-primary"></div>
                                                <div class="card-header">
                                                    <div style="width: 100%; display: flex;">
                                                        <div class="col-md-12 col-lg-2" style="width: 20%;">
                                                            <h3 class="card-title">${detalle.cantidad}</h3>
                                                        </div>
                                                        <div class="col-md-12 col-lg-7" style="text-align: left; width: 60%;">
                                                            <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                            <p style="font-size: 12px">${detalle.comentario}</p>
                                                        </div>
                                                        <div class="col-md-12 col-lg-3" style="width: 35%;">
                                                            <h3 class="card-title">${detalle.total} <strong>Bs.</strong></h3>                                                                    
                                                        </div>                                                                
                                                    </div>
                                                </div> 
                                                

                                                ${detalle.modificadordetalleconsumo.length > 0 ? `
                                                    ${detalle.modificadordetalleconsumo.map(modificador => `
                                                        <div class="card-header" style="padding-left: 20%;">
                                                            <div style="display: flex; width: 93%;">
                                                                <div class="col-md-12 col-lg-3">
                                                                    <h3 class="card-title">${modificador.cantidad}</h3>
                                                                </div>
                                                                <div class="col-md-12 col-lg-6" style="text-align: left;">
                                                                    <p class="card-title">${modificador.detallemodificador.producto.NombreProducto} - ${modificador.precio}</p>
                                                                    
                                                                </div>
                                                                <div class="col-md-12 col-lg-3" style="text-align: right;">
                                                                    <h3 class="card-title">${modificador.total} Bs.</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `).join('')}`
                                                : ''}
                                            </div><br>
                                        `}
                                                                                        
                                    `).join('')}

                                    <div class="row" style="padding: 5px; margin: 0px; background: #1d2736">
                                        <div class="col-md-12 col-lg-10">
                                            <h3 class="card-title" style="color: white">SUBTOTAL</h3>
                                        </div>

                                        <div class="col-md-12 col-lg-2" style="text-align: right">
                                            <h3 class="card-title" style="color: white">${data.consumo[0].subTotal}</h3>
                                        </div>
                                    </div>

                                    ${data.consumo[0].descuentoconsumos.length > 0 ? ` 
                                        <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                            <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                        </div>
                                        ${data.consumo[0].descuentoconsumos.map((descuento, index) => `
                                            <div class="row producto-row" style="padding: 8px">
                                                <div class="col-md-12 col-lg-2" style="width: 50%;">
                                                    <h3 class="card-title">${descuento.TipoDescuento}</h3>
                                                </div>
                                                <div class="col-md-12 col-lg-7" style="text-align: left; width: 25%;">
                                                    <p class="card-title">${descuento.MontoDescuento}</p>
                                                </div>
                                                <div class="col-md-12 col-lg-3" style="width: 25%; text-align: right">
                                                    <h3 class="card-title">${descuento.TotalDescuento}</h3>                                                                    
                                                </div>                                            
                                            </div>
                                        `).join('')}
                                        </div>`
                                    : ''}

                                    <div class="row" style="padding: 5px; margin: 0px; background: #1d2736">
                                        <div class="col-md-12 col-lg-10">
                                            <h3 class="card-title" style="color: white">TOTAL</h3>
                                        </div>

                                        <div class="col-md-12 col-lg-2" style="text-align: right">
                                            <h3 class="card-title" style="color: white">${data.consumo[0].total}</h3>
                                        </div>
                                    </div>


                                    ${data.consumo[0].pagosconsumos.length > 0 ? ` 
                                        <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                            <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                        </div>
                                        ${data.consumo[0].pagosconsumos.map((pago, index) => `
                                            <div class="row producto-row" style="padding: 8px">
                                                <div class="col-md-12 col-lg-10" style="width: 75%;">
                                                    <h3 class="card-title">${pago.TipoPago}</h3>
                                                </div>
                                                <div class="col-md-12 col-lg-2" style="text-align: right; width: 25%;">
                                                    <p class="card-title">${pago.TotalPago}</p>
                                                </div>
                                            </div>
                                        `).join('')}     
                                        </div>`
                                    : ''}
                            </div>
                        </div>
                    </div>` : ''}
                </div>
            </div>
        </div>`;
}

//formatear fecha
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