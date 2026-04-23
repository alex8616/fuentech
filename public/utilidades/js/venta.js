$(document).ready(function() {
    FechaSelect()
    InfoMovimientoVentas()
    MostrarTablaVentas()
    TraerCliente()
    TraerUsuario()
    TraerAmbiente()
});

function FechaSelect() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesVenta').empty();
    $('#AnioVenta').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesVenta').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesVenta').val(currentMonth + 1);

    var startYear = currentYear - 6;
    var endYear = currentYear;
    for (var year = startYear; year <= endYear; year++) {
        $('#AnioVenta').append('<option value="' + year + '">' + year + '</option>');
    }
    $('#AnioVenta').val(currentYear);

    function updateDaySelector() {
        var selectedMonth = parseInt($('#MesVenta').val());
        var selectedYear = parseInt($('#AnioVenta').val());
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaVenta').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaVenta').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaVenta').val(daysInMonth);
        } else {
            $('#DiaVenta').val(currentDay);
        }
    }

    updateDaySelector();

    $('#DateVenta').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioVenta':
                $('#DiaVentaContainer').show();
                $('#MesVentaContainer').show();
                $('#AnioVentaContainer').show();
                $('#FechaInicioContainerVenta').hide();
                $('#FechaFinContainerVenta').hide();
                break;
            case 'MensualVenta':
                $('#DiaVentaContainer').hide();
                $('#MesVentaContainer').show();
                $('#AnioVentaContainer').show();
                $('#FechaInicioContainerVenta').hide();
                $('#FechaFinContainerVenta').hide();
                break;
            case 'AnualVenta':
                $('#DiaVentaContainer').hide();
                $('#MesVentaContainer').hide();
                $('#AnioVentaContainer').show();
                $('#FechaInicioContainerVenta').hide();
                $('#FechaFinContainerVenta').hide();
                break;
            case 'RangoVenta':
                $('#DiaVentaContainer').hide();
                $('#MesVentaContainer').hide();
                $('#AnioVentaContainer').hide();
                $('#FechaInicioContainerVenta').show();
                $('#FechaFinContainerVenta').show();
                break;
            default:
                $('#DiaVentaContainer').show();
                $('#MesVentaContainer').show();
                $('#AnioVentaContainer').show();
                $('#FechaInicioContainerVenta').hide();
                $('#FechaFinContainerVenta').hide();
                break;
        }
        filtrarDatos();
    });

    $('#TipoVenta').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'Mesa':
                $('#AmbienteConteiner').show();
                $('#MesaContainer').show();
                break;
            case 'Delivery':
                $('#AmbienteConteiner').hide();
                $('#MesaContainer').hide();
                break;
            case 'Mostrador':
                $('#AmbienteConteiner').hide();
                $('#MesaContainer').hide();
                break;
            default:
                $('#AmbienteConteiner').hide();
                $('#MesaContainer').hide();
                break;
        }
        filtrarDatos();
    });

    $('#MesVenta, #AnioVenta').on('change', function() {
        updateDaySelector();
        filtrarDatos();
    });

    $('#DiaVenta').on('change', function() {
        filtrarDatos();
    });

    $('#FechaInicioContainerVenta').on('change', function() {
        filtrarDatos();
    });

    $('#FechaFinContainerVenta').on('change', function() {
        filtrarDatos();
    });

    $('#TipoVenta').on('change', function() {
        if ($(this).val()) {
            $(this).addClass('selected');
        } else {
            $(this).removeClass('selected');
        }
        filtrarDatos();
    });

    $('#UsuarioVenta').on('change', function() {
        filtrarDatos();
    });

    $('#EventoVenta').on('change', function() {
        filtrarDatos();
    });

    $('#ClienteVenta').on('change', function() {
        filtrarDatos();
    });

    $('#MetodoPagoVenta').on('change', function() {
        filtrarDatos();
    });

    $('#MesaVenta').on('change', function() {
        filtrarDatos();
    });

    $('#DateVenta').trigger('change');

    $('#TipoVenta').trigger('change');

}

function filtrarDatos() {
    var tipoFiltro = $('#DateVenta').val();
    var dia = $('#DiaVenta').val();
    var mes = $('#MesVenta').val();
    var anio = $('#AnioVenta').val();
    var fechaInicio = $('#fechaInicio').val();
    var fechaFin = $('#fechaFin').val();
    var TipoVenta = $('#TipoVenta').val();
    var EventoVenta = $('#EventoVenta').val();
    var UsuarioVenta = $('#UsuarioVenta').val();
    var ClienteVenta = $('#ClienteVenta').val();
    var MetodoPagoVenta = $('#MetodoPagoVenta').val();
    var MesaVenta = $('#MesaVenta').val();

    $.ajax({
        url: 'api/filtrar-datos-ventas',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            TipoVenta: TipoVenta,
            EventoVenta: EventoVenta,
            UsuarioVenta: UsuarioVenta,
            ClienteVenta: ClienteVenta,
            MetodoPagoVenta: MetodoPagoVenta,
            MesaVenta: MesaVenta
        },
        success: function(response) {
            mostrarResultados(response);
            MostrarDivTotal(response.totalSum);
            MostrarDivCantidad(response.cantidadventas)
            MostrarDivPromedioVenta(response.promedioventa)
            MostrarDivCantPersonas(response.cantpersonas)
            MostrarDivPromedioPersonas(response.promediopersonas)
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function mostrarResultados(filteredData) {
    $('#tabla-venta tbody').empty();
    $.each(filteredData.ventas, function(index, venta) {        
        var ambienteMesaText;
        if(venta.TipoConsumo == 'Mesa'){
            ambienteMesaText = "Mesa # "+venta.ambientemesa.Name
        }else if(venta.TipoConsumo == 'Mostrador'){
            ambienteMesaText = "Mostrador"
        }else{
            ambienteMesaText = "Delivery"
        }

        var clienteText;
        var clienteText = venta.cliente ? venta.cliente.NombreCliente : 
                     (venta.cliente_temporal ? venta.cliente_temporal.NombreClienteTemporal : 'Cliente no disponible');
        
        var userText;
        var userText = venta.user ? venta.user.name : 'Usuario no disponible';

        var ocupadoText;
        if(venta.ocupado == 'true'){
            ocupadoText = "En Curso"
        }else{
            ocupadoText = "Cerrado"
        }

        var row = '<tr>' +
            '<td hidden>' + venta.id + '</td>' +
            '<td>' + venta.fecha_venta + '</td>' +
            '<td>' + venta.FechaCierre + '</td>' +
            '<td>' + ((venta.ocupado == 'true') ? '<span class="badge badge-outline text-blue">En Curso</span>' : '<span class="badge badge-outline text-red">Cerrado</span>') + '</td>' +
            '<td>' + ambienteMesaText + '</td>' +
            '<td>' + userText + '</td>' +
            '<td>' + clienteText + '</td>' +
            '<td>' + venta.total + '</td>' +
            '</tr>';
        
        $('#tabla-venta tbody').append(row);
    });

    agregarEventosMovimientoTabla();

    $('#tabla-venta tbody').on('click', 'tr', function() {
        var id = $(this).find('td:first').text();
        $.ajax({
            url: '/api/get-venta-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionVenta(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos de producto:', error);
            }
        });
    });
}

function MostrarDivTotal(total){
    $('#PrecioTotal').text('Bs. '+total);
}

function MostrarDivCantidad(cantidad){
    $('#CantidadRegistroDatos').text((cantidad + (cantidad > 1 ? ' registros' : ' registro')));
}

function MostrarDivPromedioVenta(promedioventa){
    $('#PromedioVenta').text(promedioventa);
}

function MostrarDivCantPersonas(cantpersonas){
    $('#CantidadPersonas').text(cantpersonas);
}

function MostrarDivPromedioPersonas(promediopersonas){
    $('#PromedioPersona').text(promediopersonas);
}

/*DATOS DE FILTRADO ARRIBA*/

function MostrarTablaVentas(){
    $.ajax({
        url: 'api/get-all-consumo',
        type: 'GET',
        success: function(data) {           
            $('#tabla-venta tbody').empty();
            $.each(data.ventas, function(index, venta) {
                var row = '<tr>' +
                    '<td>' + venta.fecha_venta + '</td>' +
                    '<td>' + venta.FechaCierre + '</td>' +
                    '<td>' + venta.id + '</td>' +
                    '<td>' + venta.ambiente_mesa_id + '</td>' +
                    '<td>' + venta.user_id + '</td>' +
                    '<td>' + venta.cliente_id + '</td>' +
                    '<td>' + venta.total + '</td>' +
                    '</tr>';
                $('#tabla-venta tbody').append(row);
            });

            MostrarDivTotal(data.totalSum)
            MostrarDivCantidad(data.cantidadventas)
            MostrarDivPromedioVenta(data.promedioventa)
            MostrarDivCantPersonas(data.cantpersonas)
            MostrarDivPromedioPersonas(data.promediopersonas)

            agregarEventosMovimientoTabla();

            /*$('#tabla-venta tbody').on('click', 'tr', function() {
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
            });*/
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function agregarEventosMovimientoTabla() {
    $('#tabla-venta tbody tr').hover(function() {
        $(this).addClass('hovered');
    }, function() {
        $(this).removeClass('hovered');
    });
    $('#tabla-venta tbody tr').click(function() {
        $('#tabla-venta tbody tr').removeClass('tableproducseleccionado');
        $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
    });
}

function InformacionVenta(data){
    var TotalProduct = document.getElementById('form_tabs');
    var tipotext
    if(data.TipoConsumo == 'Mesa'){
        tipotext = "Mesa # "+venta.ambientemesa.Name
    }else if(data.TipoConsumo == 'Mostrador'){
        tipotext = "Mostrador"
    }else{
        tipotext = "Delivery"
    }
    
    TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">VENTA ${data[0].id}</h3>
                    <div class="card-actions">
                        <a href="#" class="btn" data-id="${data[0].id}" id="BtnImprimirTicketVentasGeneral" data-bs-toggle="modal" data-bs-target="#modalBtnImprimirTicketVentasGeneral">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                        </a>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    ${data[0].TipoConsumo == "Mesa" ?  
                        `
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora Inicio</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].fecha_venta}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora De Cierre</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].FechaCierre}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Tipo</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${tipotext}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${((data.ocupado == 'true') ? 'En Curso' : 'Cerrado')} </label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Mesa</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">Mesa # ${data[0].ambientemesa.Name} </label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Personas</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].CantidadPersonas} </label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].cliente ? data[0].cliente.NombreCliente : "Sin Cliente"} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                <div class="card-body" style="padding: 0px; margin: 0px;">
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">VENTA</h3>
                                    </div>
                                    <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                        <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                            ${data[0].detalleconsumos.map((detalle, index) => `
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
                                                    <h3 class="card-title" style="color: white">${data[0].subTotal}</h3>
                                                </div>
                                            </div>

                                            ${data[0].descuentoconsumos.length > 0 ? ` 
                                                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                    <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                </div>
                                                ${data[0].descuentoconsumos.map((descuento, index) => `
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
                                                    <h3 class="card-title" style="color: white">${data[0].total}</h3>
                                                </div>
                                            </div>


                                            ${data[0].pagosconsumos.length > 0 ? ` 
                                                <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                    <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                </div>
                                                ${data[0].pagosconsumos.map((pago, index) => `
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
                            </div>
                        `
                    : data[0].TipoConsumo == "Mostrador" ?
                    `
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora Inicio</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].fecha_venta}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora De Cierre</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].FechaCierre}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Tipo</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${tipotext}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${((data.ocupado == 'true') ? 'En Curso' : 'Cerrado')} </label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].cliente ? data[0].cliente.NombreCliente : "Sin Cliente"} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                <div class="card-body" style="padding: 0px; margin: 0px;">
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">VENTA</h3>
                                    </div>
                                    <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                        <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                            ${data[0].detalleconsumos.map((detalle, index) => `
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
                                                    <h3 class="card-title" style="color: white">${data[0].subTotal}</h3>
                                                </div>
                                            </div>

                                            ${data[0].descuentoconsumos.length > 0 ? ` 
                                                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                    <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                </div>
                                                ${data[0].descuentoconsumos.map((descuento, index) => `
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
                                                    <h3 class="card-title" style="color: white">${data[0].total}</h3>
                                                </div>
                                            </div>


                                            ${data[0].pagosconsumos.length > 0 ? ` 
                                                <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                    <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                </div>
                                                ${data[0].pagosconsumos.map((pago, index) => `
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
                            </div>
                        `
                    :
                    `
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora Inicio</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].fecha_venta}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora De Cierre</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].FechaCierre}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Tipo</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${tipotext}</label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${((data.ocupado == 'true') ? 'En Curso' : 'Cerrado')} </label>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                        <div class="col">
                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].cliente ? data[0].cliente.NombreCliente : "Sin Cliente"} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                <div class="card-body" style="padding: 0px; margin: 0px;">
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">VENTA</h3>
                                    </div>
                                    <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                        <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                            ${data[0].detalleconsumos.map((detalle, index) => `
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
                                                    <h3 class="card-title" style="color: white">${data[0].subTotal}</h3>
                                                </div>
                                            </div>

                                            ${data[0].descuentoconsumos.length > 0 ? ` 
                                                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                    <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                </div>
                                                ${data[0].descuentoconsumos.map((descuento, index) => `
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
                                                    <h3 class="card-title" style="color: white">${data[0].total}</h3>
                                                </div>
                                            </div>


                                            ${data[0].pagosconsumos.length > 0 ? ` 
                                                <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                    <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                </div>
                                                ${data[0].pagosconsumos.map((pago, index) => `
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
                            </div>
                        ` 
                }
                    
                </div>
            </div>
        </div>`;

    $(document).on('click', '#BtnImprimirTicketVentasGeneral', function() {
        const id = $(this).data('id');

        $.ajax({                    
            url: '/api/imprimir-ticket-ventas-general/'+id,
            type: 'GET',
            data: { id: id },
            success: function(response) {
                const pdfBase64 = response.pdfBase64;
                $('#modalBtnImprimirTicketVentasGeneral .modal-body').html(`
                    <iframe src="data:application/pdf;base64,${pdfBase64}" width="100%" height="500px" style="border: none;"></iframe>
                `);
                $('#modalBtnImprimirTicketVentasGeneral').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Ocurrió un error al recuperar los datos.');
                console.error(error);
            }
        });
    });
}


$('#BtnExportarPDFVentas').off('click').on('click', function (event) {
    var params = {
        tipoFiltro: $('#DateVenta').val(),
        dia: $('#DiaVenta').val(),
        mes: $('#MesVenta').val(),
        anio: $('#AnioVenta').val(),
        fechaInicio: $('#fechaInicio').val(),
        fechaFin: $('#fechaFin').val(),
        TipoVenta: $('#TipoVenta').val(),
        EventoVenta: $('#EventoVenta').val(),
        UsuarioVenta: $('#UsuarioVenta').val(),
        ClienteVenta: $('#ClienteVenta').val(),
        MetodoPagoVenta: $('#MetodoPagoVenta').val(),
        MesaVenta: $('#MesaVenta').val()
    };

    var queryString = $.param(params);

    window.open('api/filtrar-datos-ventas-pdf?' + queryString, '_blank');
});


function InfoMovimientoVentas(){
    $.ajax({
        url: 'api/get-ventas-cantidad',
        type: 'GET',
        success: function(data) {
            var startDate = new Date(data.day);
            var endDate = new Date(data.daymore);

            var formattedStartDate = ('0' + startDate.getDate()).slice(-2) + '/' + ('0' + (startDate.getMonth() + 1)).slice(-2) + '/' + startDate.getFullYear().toString().slice(-2);
            var formattedEndDate = ('0' + endDate.getDate()).slice(-2) + '/' + ('0' + (endDate.getMonth() + 1)).slice(-2) + '/' + endDate.getFullYear().toString().slice(-2);

            $('#FechaInicio').text(formattedStartDate);
            $('#FechaFinal').text(formattedEndDate);
            $('#CantidadRegistroDatos').text(data.count + (data.count > 1 ? ' registros' : ' registro'));
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
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

function TraerCliente(){
    $.ajax({
        url: 'api/get-clientes-list',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log("trae clientes")
            console.log(data)
            var select = $('#ClienteVenta');
            data.forEach(function(cliente) {
                var option = $('<option></option>')
                    .val(cliente.id)
                    .text(cliente.NombreCliente);
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching clients:', error);
        }
    });
}

function TraerUsuario(){
    $.ajax({
        url: 'api/get-users',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#UsuarioVenta');
            data.forEach(function(user) {
                var option = $('<option></option>')
                    .val(user.id)
                    .text(user.name);
                select.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching users:', error);
        }
    });
}

function TraerAmbiente(){
    $.ajax({
        url: 'api/get-ambientes',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var selectAmbiente = $('#AmbienteMesaVenta');
            data.forEach(function(ambiente) {
                var option = $('<option></option>')
                    .val(ambiente.id)
                    .text(ambiente.NombreAmbiente);
                selectAmbiente.append(option);
            });

            selectAmbiente.on('change', function() {
                var ambienteId = $(this).val();
                if (ambienteId) {
                    TraerMesasPorAmbiente(ambienteId);
                } else {
                    $('#MesaVenta').empty().append('<option value="">Seleccione una Mesa</option>');
                }
            });
        },
        error: function(error) {
            console.error('Error fetching users:', error);
        }
    });
}

function TraerMesasPorAmbiente(ambienteId) {
    $.ajax({
        url: 'api/get-ambiente-seleccionado/' + ambienteId,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var selectMesa = $('#MesaVenta');
            data[0].ambientemesas.forEach(function(mesa) {
                var option = $('<option></option>')
                    .val(mesa.id)
                    .text(mesa.id);
                selectMesa.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching mesas:', error);
        }
    });
}