$('#DivVentasPointer').off('click').one('click', function () {
    FechaSelectReporteVenta()
});

$('#DivHostalPointer').off('click').one('click', function () {
    FechaSelectReporteHostal()
});

function FechaSelectReporteVenta() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesMovimientoReporteVenta').empty();
    $('#AnioMovimientoReporteVenta').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesMovimientoReporteVenta').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesMovimientoReporteVenta').val(currentMonth + 1);

    var startYear = currentYear - 6;
    var endYear = currentYear;
    for (var year = startYear; year <= endYear; year++) {
        $('#AnioMovimientoReporteVenta').append('<option value="' + year + '">' + year + '</option>');
    }
    $('#AnioMovimientoReporteVenta').val(currentYear);

    function updateDaySelector() {
        var selectedMonth = parseInt($('#MesMovimientoReporteVenta').val());
        var selectedYear = parseInt($('#AnioMovimientoReporteVenta').val());
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaMovimientoReporteVenta').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaMovimientoReporteVenta').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaMovimientoReporteVenta').val(daysInMonth);
        } else {
            $('#DiaMovimientoReporteVenta').val(currentDay);
        }
    }

    updateDaySelector();

    $('#DateMovimientoReporteVenta').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioMovimientoReporteVenta':
                $('#DiaMovimientoReporteVentaContainer').show();
                $('#MesMovimientoReporteVentaContainer').show();
                $('#AnioMovimientoReporteVentaContainer').show();
                $('#FechaInicioContainerMovimientoReporteVenta').hide();
                $('#FechaFinContainerMovimientoReporteVenta').hide();
                break;
            case 'MensualMovimientoReporteVenta':
                $('#DiaMovimientoReporteVentaContainer').hide();
                $('#MesMovimientoReporteVentaContainer').show();
                $('#AnioMovimientoReporteVentaContainer').show();
                $('#FechaInicioContainerMovimientoReporteVenta').hide();
                $('#FechaFinContainerMovimientoReporteVenta').hide();
                break;
            case 'AnualMovimientoReporteVenta':
                $('#DiaMovimientoReporteVentaContainer').hide();
                $('#MesMovimientoReporteVentaContainer').hide();
                $('#AnioMovimientoReporteVentaContainer').show();
                $('#FechaInicioContainerMovimientoReporteVenta').hide();
                $('#FechaFinContainerMovimientoReporteVenta').hide();
                break;
            case 'RangoMovimientoReporteVenta':
                $('#DiaMovimientoReporteVentaContainer').hide();
                $('#MesMovimientoReporteVentaContainer').hide();
                $('#AnioMovimientoReporteVentaContainer').hide();
                $('#FechaInicioContainerMovimientoReporteVenta').show();
                $('#FechaFinContainerMovimientoReporteVenta').show();
                break;
            default:
                $('#DiaMovimientoReporteVentaContainer').show();
                $('#MesMovimientoReporteVentaContainer').show();
                $('#AnioMovimientoReporteVentaContainer').show();
                $('#FechaInicioContainerMovimientoReporteVenta').hide();
                $('#FechaFinContainerMovimientoReporteVenta').hide();
                break;
        }
        filtrarDatosReporteVenta();
    });


    $('#MesMovimientoReporteVenta, #AnioMovimientoReporteVenta').on('change', function() {
        updateDaySelector();
        filtrarDatosReporteVenta();
    });

    $('#DiaMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteVenta();
    });

    $('#FechaInicioContainerMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteVenta();
    });

    $('#FechaFinContainerMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteVenta();
    });

    $('#TipoMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteVenta();
    });

    $('#PagoMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteVenta();
    });

    $('#DateMovimientoReporteVenta').trigger('change');

}

function filtrarDatosReporteVenta() {
    var tipoFiltro = $('#DateMovimientoReporteVenta').val();
    var dia = $('#DiaMovimientoReporteVenta').val();
    var mes = $('#MesMovimientoReporteVenta').val();
    var anio = $('#AnioMovimientoReporteVenta').val();
    var fechaInicio = $('#fechaInicioMovimiento').val();
    var fechaFin = $('#fechaFinMovimiento').val();
    var TipoMovimientoReporteVenta = $('#TipoMovimientoReporteVenta').val();
    var tipoPago = $('#PagoMovimientoReporteVenta').val();

    $.ajax({
        url: '/apihostal/full-ventas-get',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            TipoMovimientoReporteVenta: TipoMovimientoReporteVenta,
            tipoPago: tipoPago
        },
        success: function(response) {
            MostrarDetalleInformacion(response)
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function MostrarDetalleInformacion(data){
    var nombreMes = moment().month(data.mes - 1).format('MMMM');
    let divcontent = ''; 
    let tablebody = ''; 
    let tablefoot = ''; 
    let table = ''; 

    let divcontentmesas = ''; 
    let tablemesasbody = ''; 
    let tablemesasfoot = ''; 
    let tablemesas = ''; 

    let tablemostradorbody = ''; 
    let tablemostradorfoot = ''; 
    let tablemostrador = ''; 
    
    let tabledeliverybody = ''; 
    let tabledeliveryfoot = ''; 
    let tabledelivery = ''; 

    let tablehabitacionbody = ''; 
    let tablehabitacionfoot = ''; 
    let tablehabitacion = '';

    let tablesalonbody = ''; 
    let tablesalonfoot = ''; 
    let tablesalon = '';

    let tablepedidoyabody = ''; 
    let tablepedidoyafoot = ''; 
    let tablepedidoya = '';
    
    if(data.seleccion == "DiarioMovimientoReporteVenta"){
        divcontent+= `
            <span style="font-size: 17px">Datos De Venta Del Dia <strong>${data.dia}</strong> - <strong>${nombreMes}</strong> - <strong>${data.anio}</strong> - <strong>${data.pago}</strong></span>
        `;
        Object.entries(data.productosCantidad).forEach(function([producto, cantidad]) {
            tablebody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablefoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidos}</td>
            </tr>
            <tr>
                <td class="strong text-end">TOTAL EFECTIVO</td>
                <td class="text-center">${data.totalefectivo}</td>
            </tr>
            <tr>
                <td class="strong text-end">TOTAL DEPOSITO/QR</td>
                <td class="text-center">${data.totaldeposito}</td>
            </tr>
            <tr>
                <td class="strong text-end">TOTAL TARJETA</td>
                <td class="text-center">${data.totaltarjeta}</td>
            </tr>
            <tr>
                <td class="strong text-end">TOTAL GENERAL</td>
                <td class="text-center">${data.total}</td>
            </tr>
        `   
        table += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablebody}
            </tbody>
            <tfoot>
                ${tablefoot}
            </tfoot>
        </table>`

        
        /*MESAS DE AQUI INICIO*/
        Object.entries(data.productosCantidadMesas).forEach(function([producto, cantidad]) {
            tablemesasbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablemesasfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosMesas}</td>
            </tr>            
        `   
        tablemesas += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablemesasbody}
            </tbody>
            <tfoot>
                ${tablemesasfoot}
            </tfoot>
        </table>`
        /*MESAS DE AQUI FIN*/

        /*MOSTRADOR DE AQUI INICIO*/
        Object.entries(data.productosCantidadMostrador).forEach(function([producto, cantidad]) {
            tablemostradorbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablemostradorfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosMostrador}</td>
            </tr>
        `   
        tablemostrador += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablemostradorbody}
            </tbody>
            <tfoot>
                ${tablemostradorfoot}
            </tfoot>
        </table>`
        /*MOSTRADOR DE AQUI FIN*/

        /*DELIVERY DE AQUI INICIO*/
        Object.entries(data.productosCantidadDelivery).forEach(function([producto, cantidad]) {
            tabledeliverybody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tabledeliveryfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosDelivery}</td>
            </tr>
        `   
        tabledelivery += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tabledeliverybody}
            </tbody>
            <tfoot>
                ${tabledeliveryfoot}
            </tfoot>
        </table>`
        /*DELIVERY DE AQUI FIN*/

        /*HABITACION DE AQUI INICIO*/
        Object.entries(data.productosCantidadHabitacion).forEach(function([producto, cantidad]) {
            tablehabitacionbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablehabitacionfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosHabitacion}</td>
            </tr>
        `   
        tablehabitacion += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablehabitacionbody}
            </tbody>
            <tfoot>
                ${tablehabitacionfoot}
            </tfoot>
        </table>`
        /*HABITACION DE AQUI FIN*/

        /*SALONES DE AQUI INICIO*/
        Object.entries(data.productosCantidadSalone).forEach(function([producto, cantidad]) {
            tablesalonbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablesalonfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosSalone}</td>
            </tr>
        `   
        tablesalon += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablesalonbody}
            </tbody>
            <tfoot>
                ${tablesalonfoot}
            </tfoot>
        </table>`
        /*SALONES DE AQUI FIN*/
        
        /*PEDIDOSYA-DINKI DE AQUI INICIO*/
        Object.entries(data.productosCantidadPedidoYa).forEach(function([producto, cantidad]) {
            tablepedidoyabody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablepedidoyafoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosPedidoYa}</td>
            </tr>
        `   
        tablepedidoya += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablepedidoyabody}
            </tbody>
            <tfoot>
                ${tablepedidoyafoot}
            </tfoot>
        </table>`
        /*PEDIDOSYA-DINKI DE AQUI FIN*/
    }
   
    if(data.seleccion == "MensualMovimientoReporteVenta"){
        divcontent+= `
            <span style="font-size: 17px">Datos Del Mes <strong>${nombreMes}</strong> - <strong>${data.pago}</strong></span>
        `;
        Object.entries(data.productosCantidad).forEach(function([producto, cantidad]) {
            tablebody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablefoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidos}</td>
            </tr>
        `   
        table += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablebody}
            </tbody>
            <tfoot>
                ${tablefoot}
            </tfoot>
        </table>`

        
        /*MESAS DE AQUI INICIO*/
        Object.entries(data.productosCantidadMesas).forEach(function([producto, cantidad]) {
            tablemesasbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablemesasfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosMesas}</td>
            </tr>
        `   
        tablemesas += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablemesasbody}
            </tbody>
            <tfoot>
                ${tablemesasfoot}
            </tfoot>
        </table>`
        /*MESAS DE AQUI FIN*/

        /*MOSTRADOR DE AQUI INICIO*/
        Object.entries(data.productosCantidadMostrador).forEach(function([producto, cantidad]) {
            tablemostradorbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablemostradorfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosMostrador}</td>
            </tr>
        `   
        tablemostrador += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablemostradorbody}
            </tbody>
            <tfoot>
                ${tablemostradorfoot}
            </tfoot>
        </table>`
        /*MOSTRADOR DE AQUI FIN*/

        /*DELIVERY DE AQUI INICIO*/
        Object.entries(data.productosCantidadDelivery).forEach(function([producto, cantidad]) {
            tabledeliverybody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tabledeliveryfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosDelivery}</td>
            </tr>
        `   
        tabledelivery += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tabledeliverybody}
            </tbody>
            <tfoot>
                ${tabledeliveryfoot}
            </tfoot>
        </table>`
        /*DELIVERY DE AQUI FIN*/

        /*HABITACION DE AQUI INICIO*/
        Object.entries(data.productosCantidadHabitacion).forEach(function([producto, cantidad]) {
            tablehabitacionbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablehabitacionfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosHabitacion}</td>
            </tr>
        `   
        tablehabitacion += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablehabitacionbody}
            </tbody>
            <tfoot>
                ${tablehabitacionfoot}
            </tfoot>
        </table>`
        /*HABITACION DE AQUI FIN*/

        /*SALONES DE AQUI INICIO*/
        Object.entries(data.productosCantidadSalone).forEach(function([producto, cantidad]) {
            tablesalonbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablesalonfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosSalone}</td>
            </tr>
        `   
        tablesalon += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablesalonbody}
            </tbody>
            <tfoot>
                ${tablesalonfoot}
            </tfoot>
        </table>`
        /*SALONES DE AQUI FIN*/
        
        /*PEDIDOSYA-DINKI DE AQUI INICIO*/
        Object.entries(data.productosCantidadPedidoYa).forEach(function([producto, cantidad]) {
            tablepedidoyabody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablepedidoyafoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosPedidoYa}</td>
            </tr>
        `   
        tablepedidoya += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablepedidoyabody}
            </tbody>
            <tfoot>
                ${tablepedidoyafoot}
            </tfoot>
        </table>`
        /*PEDIDOSYA-DINKI DE AQUI FIN*/
    }

    if(data.seleccion == "AnualMovimientoReporteVenta"){
        divcontent+= `
            <span style="font-size: 17px">Datos Del Anio <strong>${data.anio}</strong> - <strong>${data.pago}</strong></span>
        `;
        Object.entries(data.productosCantidad).forEach(function([producto, cantidad]) {
            tablebody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablefoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidos}</td>
            </tr>
        `   
        table += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablebody}
            </tbody>
            <tfoot>
                ${tablefoot}
            </tfoot>
        </table>`

        
        /*MESAS DE AQUI INICIO*/
        Object.entries(data.productosCantidadMesas).forEach(function([producto, cantidad]) {
            tablemesasbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablemesasfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosMesas}</td>
            </tr>
        `   
        tablemesas += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablemesasbody}
            </tbody>
            <tfoot>
                ${tablemesasfoot}
            </tfoot>
        </table>`
        /*MESAS DE AQUI FIN*/

        /*MOSTRADOR DE AQUI INICIO*/
        Object.entries(data.productosCantidadMostrador).forEach(function([producto, cantidad]) {
            tablemostradorbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablemostradorfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosMostrador}</td>
            </tr>
        `   
        tablemostrador += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablemostradorbody}
            </tbody>
            <tfoot>
                ${tablemostradorfoot}
            </tfoot>
        </table>`
        /*MOSTRADOR DE AQUI FIN*/

        /*DELIVERY DE AQUI INICIO*/
        Object.entries(data.productosCantidadDelivery).forEach(function([producto, cantidad]) {
            tabledeliverybody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tabledeliveryfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosDelivery}</td>
            </tr>
        `   
        tabledelivery += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tabledeliverybody}
            </tbody>
            <tfoot>
                ${tabledeliveryfoot}
            </tfoot>
        </table>`
        /*DELIVERY DE AQUI FIN*/

        /*HABITACION DE AQUI INICIO*/
        Object.entries(data.productosCantidadHabitacion).forEach(function([producto, cantidad]) {
            tablehabitacionbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablehabitacionfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosHabitacion}</td>
            </tr>
        `   
        tablehabitacion += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablehabitacionbody}
            </tbody>
            <tfoot>
                ${tablehabitacionfoot}
            </tfoot>
        </table>`
        /*HABITACION DE AQUI FIN*/

        /*SALONES DE AQUI INICIO*/
        Object.entries(data.productosCantidadSalone).forEach(function([producto, cantidad]) {
            tablesalonbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablesalonfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosSalone}</td>
            </tr>
        `   
        tablesalon += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablesalonbody}
            </tbody>
            <tfoot>
                ${tablesalonfoot}
            </tfoot>
        </table>`
        /*SALONES DE AQUI FIN*/
        
        /*PEDIDOSYA-DINKI DE AQUI INICIO*/
        Object.entries(data.productosCantidadPedidoYa).forEach(function([producto, cantidad]) {
            tablepedidoyabody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablepedidoyafoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosPedidoYa}</td>
            </tr>
        `   
        tablepedidoya += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablepedidoyabody}
            </tbody>
            <tfoot>
                ${tablepedidoyafoot}
            </tfoot>
        </table>`
        /*PEDIDOSYA-DINKI DE AQUI FIN*/
    }

    if(data.seleccion == "RangoMovimientoReporteVenta"){
        divcontent+= `
            <span style="font-size: 17px">Datos De Fecha <strong>${data.inicio}</strong> a fecha <strong>${data.fin}</strong> - <strong>${data.pago}</strong></span>
        `;
        Object.entries(data.productosCantidad).forEach(function([producto, cantidad]) {
            tablebody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablefoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidos}</td>
            </tr>
        `   
        table += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablebody}
            </tbody>
            <tfoot>
                ${tablefoot}
            </tfoot>
        </table>`

        
        /*MESAS DE AQUI INICIO*/
        Object.entries(data.productosCantidadMesas).forEach(function([producto, cantidad]) {
            tablemesasbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablemesasfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosMesas}</td>
            </tr>
        `   
        tablemesas += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablemesasbody}
            </tbody>
            <tfoot>
                ${tablemesasfoot}
            </tfoot>
        </table>`
        /*MESAS DE AQUI FIN*/

        /*MOSTRADOR DE AQUI INICIO*/
        Object.entries(data.productosCantidadMostrador).forEach(function([producto, cantidad]) {
            tablemostradorbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablemostradorfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosMostrador}</td>
            </tr>
        `   
        tablemostrador += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablemostradorbody}
            </tbody>
            <tfoot>
                ${tablemostradorfoot}
            </tfoot>
        </table>`
        /*MOSTRADOR DE AQUI FIN*/

        /*DELIVERY DE AQUI INICIO*/
        Object.entries(data.productosCantidadDelivery).forEach(function([producto, cantidad]) {
            tabledeliverybody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tabledeliveryfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosDelivery}</td>
            </tr>
        `   
        tabledelivery += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tabledeliverybody}
            </tbody>
            <tfoot>
                ${tabledeliveryfoot}
            </tfoot>
        </table>`
        /*DELIVERY DE AQUI FIN*/

        /*HABITACION DE AQUI INICIO*/
        Object.entries(data.productosCantidadHabitacion).forEach(function([producto, cantidad]) {
            tablehabitacionbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablehabitacionfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosHabitacion}</td>
            </tr>
        `   
        tablehabitacion += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablehabitacionbody}
            </tbody>
            <tfoot>
                ${tablehabitacionfoot}
            </tfoot>
        </table>`
        /*HABITACION DE AQUI FIN*/

        /*SALONES DE AQUI INICIO*/
        Object.entries(data.productosCantidadSalone).forEach(function([producto, cantidad]) {
            tablesalonbody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablesalonfoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosSalone}</td>
            </tr>
        `   
        tablesalon += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablesalonbody}
            </tbody>
            <tfoot>
                ${tablesalonfoot}
            </tfoot>
        </table>`
        /*SALONES DE AQUI FIN*/
        
        /*PEDIDOSYA-DINKI DE AQUI INICIO*/
        Object.entries(data.productosCantidadPedidoYa).forEach(function([producto, cantidad]) {
            tablepedidoyabody += `
                <tr>
                    <td>
                        <p class="strong mb-1">${producto}</p>
                    </td>
                    <td class="text-center">${cantidad}</td>
                </tr>
            `;
        });
        tablepedidoyafoot += `
            <tr>
                <td class="strong text-end">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.totalProductosVendidosPedidoYa}</td>
            </tr>
        `   
        tablepedidoya += `
        <table class="table table-transparent table-responsive">
            <thead>
            <tr>
                <th>Product</th>
                <th class="text-center" style="width: 1%">Cantidad</th>
            </tr>
            </thead>
            <tbody>
                ${tablepedidoyabody}
            </tbody>
            <tfoot>
                ${tablepedidoyafoot}
            </tfoot>
        </table>`
        /*PEDIDOSYA-DINKI DE AQUI FIN*/
    }

    var TotalProduct = document.getElementById('form_tabs');
    
    TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">INFORMACION DE VENTAS</h3>
                    <div class="card-actions">
                        <a href="#" class="btn" data-ingrediente-id="${data.id}" id="AddIngredienteStock">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%; background: #F5F7F8">
                    ${divcontent}
                </div>
                <div class="card-footer" style="background: #F5F7F8"">
                    ${table}
                </div>
            </div><br>
            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header d-flex justify-content-between align-items-center" id="heading-2">
                        <button class="accordion-button flex-grow-1" type="button" data-bs-toggle="collapse" data-bs-target="#ProductoMesas" aria-expanded="false">
                            PRODUCTOS SALIDOS DE MESA - ${data.totalProductosVendidosMesas}
                        </button>
                    </h2>
                    <div id="ProductoMesas" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tablemesas}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ProductoMostrador" aria-expanded="false">
                        PRODUCTOS SALIDOS DE MOSTRADOR - ${data.totalProductosVendidosMostrador}
                        </button>
                    </h2>
                    <div id="ProductoMostrador" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tablemostrador}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ProductoDelivery" aria-expanded="false">
                        PRODUCTOS SALIDOS DE DELIVERY - ${data.totalProductosVendidosDelivery}
                        </button>
                    </h2>
                    <div id="ProductoDelivery" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tabledelivery}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ProductoHabitacion" aria-expanded="false">
                        PRODUCTOS SALIDOS DE HABITACION - ${data.totalProductosVendidosHabitacion}
                        </button>
                    </h2>
                    <div id="ProductoHabitacion" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tablehabitacion}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ProductoSalon" aria-expanded="false">
                        PRODUCTOS SALIDOS SALONES - ${data.totalProductosVendidosSalone}
                        </button>
                    </h2>
                    <div id="ProductoSalon" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tablesalon}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ProductoPedidosYa" aria-expanded="false">
                        PRODUCTOS SALIDOS PEDIDOS YA - DINKI - ${data.totalProductosVendidosPedidoYa}
                        </button>
                    </h2>
                    <div id="ProductoPedidosYa" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tablepedidoya}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="strong text-end">
                <a href="#" id="ReportePDFventa">Más Detalle Exportar En PDF</a><br><br>
            </div>

        </div>`;

        $('#ReportePDFventa').off('click').on('click', function(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
            
            // Obtener los valores de los filtros
            var tipoFiltro = $('#DateMovimientoReporteVenta').val();
            var dia = $('#DiaMovimientoReporteVenta').val();
            var mes = $('#MesMovimientoReporteVenta').val();
            var anio = $('#AnioMovimientoReporteVenta').val();
            var fechaInicio = $('#fechaInicioMovimiento').val();
            var fechaFin = $('#fechaFinMovimiento').val();
            var TipoMovimientoReporteVenta = $('#TipoMovimientoReporteVenta').val();
            
            // Crear parámetros de consulta
            var params = $.param({
                tipoFiltro: tipoFiltro,
                dia: dia,
                mes: mes,
                anio: anio,
                fechaInicio: fechaInicio,
                fechaFin: fechaFin,
                TipoMovimientoReporteVenta: TipoMovimientoReporteVenta
            });
        
            // Redirigir a la URL para descargar el PDF
            window.open('/apihostal/full-ventas-get-pdf?' + params, '_blank');
        });
}


function FechaSelectReporteHostal() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesMovimientoReporteVenta').empty();
    $('#AnioMovimientoReporteVenta').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesMovimientoReporteVenta').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesMovimientoReporteVenta').val(currentMonth + 1);

    var startYear = currentYear - 6;
    var endYear = currentYear;
    for (var year = startYear; year <= endYear; year++) {
        $('#AnioMovimientoReporteVenta').append('<option value="' + year + '">' + year + '</option>');
    }
    $('#AnioMovimientoReporteVenta').val(currentYear);

    function updateDaySelector() {
        var selectedMonth = parseInt($('#MesMovimientoReporteVenta').val());
        var selectedYear = parseInt($('#AnioMovimientoReporteVenta').val());
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaMovimientoReporteVenta').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaMovimientoReporteVenta').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaMovimientoReporteVenta').val(daysInMonth);
        } else {
            $('#DiaMovimientoReporteVenta').val(currentDay);
        }
    }

    updateDaySelector();

    $('#DateMovimientoReporteVenta').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioMovimientoReporteVenta':
                $('#DiaMovimientoReporteVentaContainer').show();
                $('#MesMovimientoReporteVentaContainer').show();
                $('#AnioMovimientoReporteVentaContainer').show();
                $('#FechaInicioContainerMovimientoReporteVenta').hide();
                $('#FechaFinContainerMovimientoReporteVenta').hide();
                break;
            case 'MensualMovimientoReporteVenta':
                $('#DiaMovimientoReporteVentaContainer').hide();
                $('#MesMovimientoReporteVentaContainer').show();
                $('#AnioMovimientoReporteVentaContainer').show();
                $('#FechaInicioContainerMovimientoReporteVenta').hide();
                $('#FechaFinContainerMovimientoReporteVenta').hide();
                break;
            case 'AnualMovimientoReporteVenta':
                $('#DiaMovimientoReporteVentaContainer').hide();
                $('#MesMovimientoReporteVentaContainer').hide();
                $('#AnioMovimientoReporteVentaContainer').show();
                $('#FechaInicioContainerMovimientoReporteVenta').hide();
                $('#FechaFinContainerMovimientoReporteVenta').hide();
                break;
            case 'RangoMovimientoReporteVenta':
                $('#DiaMovimientoReporteVentaContainer').hide();
                $('#MesMovimientoReporteVentaContainer').hide();
                $('#AnioMovimientoReporteVentaContainer').hide();
                $('#FechaInicioContainerMovimientoReporteVenta').show();
                $('#FechaFinContainerMovimientoReporteVenta').show();
                break;
            default:
                $('#DiaMovimientoReporteVentaContainer').show();
                $('#MesMovimientoReporteVentaContainer').show();
                $('#AnioMovimientoReporteVentaContainer').show();
                $('#FechaInicioContainerMovimientoReporteVenta').hide();
                $('#FechaFinContainerMovimientoReporteVenta').hide();
                break;
        }
        filtrarDatosReporteHostal();
    });


    $('#MesMovimientoReporteVenta, #AnioMovimientoReporteVenta').on('change', function() {
        updateDaySelector();
        filtrarDatosReporteHostal();
    });

    $('#DiaMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteHostal();
    });

    $('#FechaInicioContainerMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteHostal();
    });

    $('#FechaFinContainerMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteHostal();
    });

    $('#TipoMovimientoReporteVenta').on('change', function() {
        filtrarDatosReporteHostal();
    });

    $('#DateMovimientoReporteVenta').trigger('change');

}

function filtrarDatosReporteHostal() {
    var tipoFiltro = $('#DateMovimientoReporteVenta').val();
    var dia = $('#DiaMovimientoReporteVenta').val();
    var mes = $('#MesMovimientoReporteVenta').val();
    var anio = $('#AnioMovimientoReporteVenta').val();
    var fechaInicio = $('#fechaInicioMovimiento').val();
    var fechaFin = $('#fechaFinMovimiento').val();
    var TipoMovimientoReporteVenta = $('#TipoMovimientoReporteVenta').val();

    $.ajax({
        url: '/apihostal/full-hostal-get',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            TipoMovimientoReporteVenta: TipoMovimientoReporteVenta,
        },
        success: function(response) {
            MostrarDetalleInformacionHostal(response)
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function MostrarDetalleInformacionHostal(data){
    var TotalProduct = document.getElementById('form_tabs');
    
    var nombreMes = moment().month(data.mes - 1).format('MMMM');
    let divcontent = ''; 
    let tablefoot = ''; 
    let table = ''; 

    let tablehospedajefoot = ''; 
    let tablehospedaje = ''; 

    let tablegrupofoot = ''; 
    let tablegrupo = ''; 

    let tablereservafoot = ''; 
    let tablereserva = ''; 

    if(data.seleccion == "DiarioMovimientoReporteVenta"){
        divcontent+= `
            <span style="font-size: 17px">Datos De Venta Del Dia <strong>${data.dia}</strong> - <strong>${nombreMes}</strong> - <strong>${data.anio}</strong></span>
        `;
        tablefoot += `
            <tr>
                <td class="strong text-end" colspan="4">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.TotalGeneral.toFixed(2)}</td>
            </tr>
        `   
        table = `
            <table class="table table-transparent">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Ingreso</th>
                        <th>Salida</th>
                        <th>Cliente</th>
                        <th>Habitación</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
        `;
        // Iterar sobre `hospedajes`
        data.hospedajes.forEach(hospedaje => {
            const cliente = hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;

            table += `
                <tr>
                    <td>${'Hospedaje'}</td>
                    <td>${hospedaje.CodigoHospedaje || ''}</td>
                    <td>${cliente ? `${cliente.Nombre_cliente} ${cliente.Apellido_cliente}` : 'Sin cliente'}</td>
                    <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                    <td>${hospedaje.Total || '0.00'}</td>
                </tr>
            `;
        });
        // Iterar sobre los 'grupohospedajes'
        data.grupohospedajes.forEach(grupo => {
            grupo.hospedajes.forEach(hospedaje => {
                const cliente = hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;
                let mostrarGuia = hospedaje.GuiaTuristica === "true" ? 'Guía' : (hospedaje.TotalHospedaje || '0.00');
                table += `
                    <tr>
                        <td>${'Grupo'}</td>
                        <td>${grupo.TourName || ''}</td>
                        <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                        <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                        <td>${mostrarGuia}</td>
                    </tr>
                `;
            });
        });
        // Iterar sobre `reservashospedaje` (asumiendo que esta estructura es similar a `hospedajes` o `grupohospedajes`)
        data.reservashospedaje.forEach(reserva => {
            const cliente = reserva.hospedajehabitacion.detallehospedajes && reserva.hospedajehabitacion.detallehospedajes.length > 0 ? reserva.hospedajehabitacion.detallehospedajes[0].cliente : null;

            table += `
                <tr>
                    <td>${'Reserva'}</td>
                    <td>${reserva.CodigoReserva || ''}</td>
                    <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                    <td>${reserva.CategoriaHabitacion || ''} - Habitación #${reserva.hospedajehabitacion.habitacion_id || ''}</td>
                    <td>${reserva.hospedajehabitacion.TotalHospedaje || '0.00'}</td>
                </tr>
            `;
        });
        table += `
                </tbody>
                <tfoot>
                    ${tablefoot}
                </tfoot>
            </table>
        `;

        /*HOSPEDAJE INICIO*/
        data.hospedajes.forEach(hospedaje => {
            const cliente = hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;

            tablehospedaje += `
                <tr>
                    <td>${hospedaje.CodigoHospedaje || ''}</td>
                    <td>${cliente ? `${cliente.Nombre_cliente} ${cliente.Apellido_cliente}` : 'Sin cliente'}</td>
                    <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                    <td>${parseFloat(hospedaje.Total || '0.00').toFixed(2)}</td>
                </tr>
            `;
        });

        tablehospedajefoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL HOSPEDAJE</td>
                <td class="text-center">${parseFloat(data.TotalHospedajes || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablehospedaje = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablehospedaje}
            </tbody>
            <tfoot>
                ${tablehospedajefoot}
            </tfoot>
        </table>`;
        /*HOSPEDAJE FIN*/

        /*GRUPO INICIO*/
        data.grupohospedajes.forEach(grupo => {
            grupo.hospedajes.forEach(hospedaje => {
                const cliente = hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;
                let mostrarGuia = hospedaje.GuiaTuristica === "true" ? 'Guía' : (hospedaje.TotalHospedaje || '0.00');
                tablegrupo += `
                    <tr>
                        <td>${grupo.TourName || ''}</td>
                        <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                        <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                        <td>${mostrarGuia}</td>
                    </tr>
                `;
            });
        });

        tablegrupofoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL GRUPOS</td>
                <td class="text-center">${parseFloat(data.TotalGrupos || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablegrupo = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablegrupo}
            </tbody>
            <tfoot>
                ${tablegrupofoot}
            </tfoot>
        </table>`;
        /*GRUPO FIN*/

        /*RESERVA INICIO*/
        data.reservashospedaje.forEach(reserva => {
            const cliente = reserva.hospedajehabitacion.detallehospedajes && reserva.hospedajehabitacion.detallehospedajes.length > 0 ? reserva.hospedajehabitacion.detallehospedajes[0].cliente : null;

            tablereserva += `
                <tr>
                    <td>${reserva.CodigoReserva || ''}</td>
                    <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                    <td>${reserva.CategoriaHabitacion || ''} - Habitación #${reserva.hospedajehabitacion.habitacion_id || ''}</td>
                    <td>${reserva.hospedajehabitacion.TotalHospedaje || '0.00'}</td>
                </tr>
            `;
        });

        tablereservafoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL RESERVAS</td>
                <td class="text-center">${parseFloat(data.TotalReservas || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablereserva = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablereserva}
            </tbody>
            <tfoot>
                ${tablereservafoot}
            </tfoot>
        </table>`;
        /*RESERVA FIN*/
    }

    if(data.seleccion == "MensualMovimientoReporteVenta"){
        divcontent+= `
            <span style="font-size: 17px">Datos Del Mes <strong>${nombreMes}</strong></span>
        `;
        tablefoot += `
            <tr>
                <td class="strong text-end" colspan="4">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.TotalGeneral.toFixed(2)}</td>
            </tr>
        `   
        table = `
            <table class="table table-transparent">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Habitación</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
        `;
        // Iterar sobre `hospedajes`
        data.hospedajes.forEach(hospedaje => {
            const cliente = hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;

            table += `
                <tr>
                    <td>${'Hospedaje'}</td>
                    <td>${hospedaje.CodigoHospedaje || ''}</td>
                    <td>${cliente ? `${cliente.Nombre_cliente} ${cliente.Apellido_cliente}` : 'Sin cliente'}</td>
                    <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                    <td>${hospedaje.Total || '0.00'}</td>
                </tr>
            `;
        });
        // Iterar sobre los 'grupohospedajes'
        data.grupohospedajes.forEach(grupo => {
            grupo.hospedajes.forEach(hospedaje => {
                const cliente = hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;
                let mostrarGuia = hospedaje.GuiaTuristica === "true" ? 'Guía' : (hospedaje.TotalHospedaje || '0.00');
                table += `
                    <tr>
                        <td>${'Grupo'}</td>
                        <td>${grupo.TourName || ''}</td>
                        <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                        <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                        <td>${mostrarGuia}</td>
                    </tr>
                `;
            });
        });
        // Iterar sobre `reservashospedaje` (asumiendo que esta estructura es similar a `hospedajes` o `grupohospedajes`)
        data.reservashospedaje.forEach(reserva => {
            const cliente = reserva.hospedajehabitacion.detallehospedajes && reserva.hospedajehabitacion.detallehospedajes.length > 0 ? reserva.hospedajehabitacion.detallehospedajes[0].cliente : null;

            table += `
                <tr>
                    <td>${'Reserva'}</td>
                    <td>${reserva.CodigoReserva || ''}</td>
                    <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                    <td>${reserva.CategoriaHabitacion || ''} - Habitación #${reserva.hospedajehabitacion.habitacion_id || ''}</td>
                    <td>${reserva.hospedajehabitacion.TotalHospedaje || '0.00'}</td>
                </tr>
            `;
        });
        table += `
                </tbody>
                <tfoot>
                    ${tablefoot}
                </tfoot>
            </table>
        `;

        /*HOSPEDAJE INICIO*/
        data.hospedajes.forEach(hospedaje => {
            const cliente = hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;

            tablehospedaje += `
                <tr>
                    <td>${hospedaje.CodigoHospedaje || ''}</td>
                    <td>${cliente ? `${cliente.Nombre_cliente} ${cliente.Apellido_cliente}` : 'Sin cliente'}</td>
                    <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                    <td>${parseFloat(hospedaje.Total || '0.00').toFixed(2)}</td>
                </tr>
            `;
        });

        tablehospedajefoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL HOSPEDAJE</td>
                <td class="text-center">${parseFloat(data.TotalHospedajes || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablehospedaje = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablehospedaje}
            </tbody>
            <tfoot>
                ${tablehospedajefoot}
            </tfoot>
        </table>`;
        /*HOSPEDAJE FIN*/

        /*GRUPO INICIO*/
        data.grupohospedajes.forEach(grupo => {
            grupo.hospedajes.forEach(hospedaje => {
                const cliente = hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;
                let mostrarGuia = hospedaje.GuiaTuristica === "true" ? 'Guía' : (hospedaje.TotalHospedaje || '0.00');
                tablegrupo += `
                    <tr>
                        <td>${grupo.TourName || ''}</td>
                        <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                        <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                        <td>${mostrarGuia}</td>
                    </tr>
                `;
            });
        });

        tablegrupofoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL GRUPOS</td>
                <td class="text-center">${parseFloat(data.TotalGrupos || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablegrupo = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablegrupo}
            </tbody>
            <tfoot>
                ${tablegrupofoot}
            </tfoot>
        </table>`;
        /*GRUPO FIN*/

        /*RESERVA INICIO*/
        data.reservashospedaje.forEach(reserva => {
            const cliente = reserva.hospedajehabitacion.detallehospedajes && reserva.hospedajehabitacion.detallehospedajes.length > 0 ? reserva.hospedajehabitacion.detallehospedajes[0].cliente : null;

            tablereserva += `
                <tr>
                    <td>${reserva.CodigoReserva || ''}</td>
                    <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                    <td>${reserva.CategoriaHabitacion || ''} - Habitación #${reserva.hospedajehabitacion.habitacion_id || ''}</td>
                    <td>${reserva.hospedajehabitacion.TotalHospedaje || '0.00'}</td>
                </tr>
            `;
        });

        tablereservafoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL RESERVAS</td>
                <td class="text-center">${parseFloat(data.TotalReservas || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablereserva = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablereserva}
            </tbody>
            <tfoot>
                ${tablereservafoot}
            </tfoot>
        </table>`;
        /*RESERVA FIN*/
    }

    if(data.seleccion == "AnualMovimientoReporteVenta"){
        divcontent+= `
            <span style="font-size: 17px">Datos Del Anio <strong>${data.anio}</strong></span>
        `;
        tablefoot += `
            <tr>
                <td class="strong text-end" colspan="4">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.TotalGeneral.toFixed(2)}</td>
            </tr>
        `   
        table = `
            <table class="table table-transparent">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Habitación</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
        `;
        // Iterar sobre `hospedajes`
        data.hospedajes.forEach(hospedaje => {
            const cliente = hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;

            table += `
                <tr>
                    <td>${'Hospedaje'}</td>
                    <td>${hospedaje.CodigoHospedaje || ''}</td>
                    <td>${cliente ? `${cliente.Nombre_cliente} ${cliente.Apellido_cliente}` : 'Sin cliente'}</td>
                    <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                    <td>${hospedaje.Total || '0.00'}</td>
                </tr>
            `;
        });
        // Iterar sobre los 'grupohospedajes'
        data.grupohospedajes.forEach(grupo => {
            grupo.hospedajes.forEach(hospedaje => {
                const cliente = hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;
                let mostrarGuia = hospedaje.GuiaTuristica === "true" ? 'Guía' : (hospedaje.TotalHospedaje || '0.00');
                table += `
                    <tr>
                        <td>${'Grupo'}</td>
                        <td>${grupo.TourName || ''}</td>
                        <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                        <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                        <td>${mostrarGuia}</td>
                    </tr>
                `;
            });
        });
        // Iterar sobre `reservashospedaje` (asumiendo que esta estructura es similar a `hospedajes` o `grupohospedajes`)
        data.reservashospedaje.forEach(reserva => {
            const cliente = reserva.hospedajehabitacion.detallehospedajes && reserva.hospedajehabitacion.detallehospedajes.length > 0 ? reserva.hospedajehabitacion.detallehospedajes[0].cliente : null;

            table += `
                <tr>
                    <td>${'Reserva'}</td>
                    <td>${reserva.CodigoReserva || ''}</td>
                    <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                    <td>${reserva.CategoriaHabitacion || ''} - Habitación #${reserva.hospedajehabitacion.habitacion_id || ''}</td>
                    <td>${reserva.hospedajehabitacion.TotalHospedaje || '0.00'}</td>
                </tr>
            `;
        });
        table += `
                </tbody>
                <tfoot>
                    ${tablefoot}
                </tfoot>
            </table>
        `;

        /*HOSPEDAJE INICIO*/
        data.hospedajes.forEach(hospedaje => {
            const cliente = hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;

            tablehospedaje += `
                <tr>
                    <td>${hospedaje.CodigoHospedaje || ''}</td>
                    <td>${cliente ? `${cliente.Nombre_cliente} ${cliente.Apellido_cliente}` : 'Sin cliente'}</td>
                    <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                    <td>${parseFloat(hospedaje.Total || '0.00').toFixed(2)}</td>
                </tr>
            `;
        });

        tablehospedajefoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL HOSPEDAJE</td>
                <td class="text-center">${parseFloat(data.TotalHospedajes || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablehospedaje = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablehospedaje}
            </tbody>
            <tfoot>
                ${tablehospedajefoot}
            </tfoot>
        </table>`;
        /*HOSPEDAJE FIN*/

        /*GRUPO INICIO*/
        data.grupohospedajes.forEach(grupo => {
            grupo.hospedajes.forEach(hospedaje => {
                const cliente = hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;
                let mostrarGuia = hospedaje.GuiaTuristica === "true" ? 'Guía' : (hospedaje.TotalHospedaje || '0.00');
                tablegrupo += `
                    <tr>
                        <td>${grupo.TourName || ''}</td>
                        <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                        <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                        <td>${mostrarGuia}</td>
                    </tr>
                `;
            });
        });

        tablegrupofoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL GRUPOS</td>
                <td class="text-center">${parseFloat(data.TotalGrupos || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablegrupo = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablegrupo}
            </tbody>
            <tfoot>
                ${tablegrupofoot}
            </tfoot>
        </table>`;
        /*GRUPO FIN*/

        /*RESERVA INICIO*/
        data.reservashospedaje.forEach(reserva => {
            const cliente = reserva.hospedajehabitacion.detallehospedajes && reserva.hospedajehabitacion.detallehospedajes.length > 0 ? reserva.hospedajehabitacion.detallehospedajes[0].cliente : null;

            tablereserva += `
                <tr>
                    <td>${reserva.CodigoReserva || ''}</td>
                    <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                    <td>${reserva.CategoriaHabitacion || ''} - Habitación #${reserva.hospedajehabitacion.habitacion_id || ''}</td>
                    <td>${reserva.hospedajehabitacion.TotalHospedaje || '0.00'}</td>
                </tr>
            `;
        });

        tablereservafoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL RESERVAS</td>
                <td class="text-center">${parseFloat(data.TotalReservas || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablereserva = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablereserva}
            </tbody>
            <tfoot>
                ${tablereservafoot}
            </tfoot>
        </table>`;
        /*RESERVA FIN*/
    }

    if(data.seleccion == "RangoMovimientoReporteVenta"){
        divcontent+= `
            <span style="font-size: 17px">Datos De Fecha <strong>${data.inicio}</strong> a fecha <strong>${data.fin}</strong></span>
        `;
        tablefoot += `
            <tr>
                <td class="strong text-end" colspan="4">TOTAL PRODCUTOS SALIDOS</td>
                <td class="text-center">${data.TotalGeneral.toFixed(2)}</td>
            </tr>
        `   
        table = `
            <table class="table table-transparent">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Habitación</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
        `;
        // Iterar sobre `hospedajes`
        data.hospedajes.forEach(hospedaje => {
            const cliente = hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;

            table += `
                <tr>
                    <td>${'Hospedaje'}</td>
                    <td>${hospedaje.CodigoHospedaje || ''}</td>
                    <td>${cliente ? `${cliente.Nombre_cliente} ${cliente.Apellido_cliente}` : 'Sin cliente'}</td>
                    <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                    <td>${hospedaje.Total || '0.00'}</td>
                </tr>
            `;
        });
        // Iterar sobre los 'grupohospedajes'
        data.grupohospedajes.forEach(grupo => {
            grupo.hospedajes.forEach(hospedaje => {
                const cliente = hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;
                let mostrarGuia = hospedaje.GuiaTuristica === "true" ? 'Guía' : (hospedaje.TotalHospedaje || '0.00');
                table += `
                    <tr>
                        <td>${'Grupo'}</td>
                        <td>${grupo.TourName || ''}</td>
                        <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                        <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                        <td>${mostrarGuia}</td>
                    </tr>
                `;
            });
        });
        // Iterar sobre `reservashospedaje` (asumiendo que esta estructura es similar a `hospedajes` o `grupohospedajes`)
        data.reservashospedaje.forEach(reserva => {
            const cliente = reserva.hospedajehabitacion.detallehospedajes && reserva.hospedajehabitacion.detallehospedajes.length > 0 ? reserva.hospedajehabitacion.detallehospedajes[0].cliente : null;

            table += `
                <tr>
                    <td>${'Reserva'}</td>
                    <td>${reserva.CodigoReserva || ''}</td>
                    <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                    <td>${reserva.CategoriaHabitacion || ''} - Habitación #${reserva.hospedajehabitacion.habitacion_id || ''}</td>
                    <td>${reserva.hospedajehabitacion.TotalHospedaje || '0.00'}</td>
                </tr>
            `;
        });
        table += `
                </tbody>
                <tfoot>
                    ${tablefoot}
                </tfoot>
            </table>
        `;

        /*HOSPEDAJE INICIO*/
        data.hospedajes.forEach(hospedaje => {
            const cliente = hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;

            tablehospedaje += `
                <tr>
                    <td>${hospedaje.CodigoHospedaje || ''}</td>
                    <td>${cliente ? `${cliente.Nombre_cliente} ${cliente.Apellido_cliente}` : 'Sin cliente'}</td>
                    <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                    <td>${parseFloat(hospedaje.Total || '0.00').toFixed(2)}</td>
                </tr>
            `;
        });

        tablehospedajefoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL HOSPEDAJE</td>
                <td class="text-center">${parseFloat(data.TotalHospedajes || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablehospedaje = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablehospedaje}
            </tbody>
            <tfoot>
                ${tablehospedajefoot}
            </tfoot>
        </table>`;
        /*HOSPEDAJE FIN*/

        /*GRUPO INICIO*/
        data.grupohospedajes.forEach(grupo => {
            grupo.hospedajes.forEach(hospedaje => {
                const cliente = hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0 ? hospedaje.detallehospedajes[0].cliente : null;
                let mostrarGuia = hospedaje.GuiaTuristica === "true" ? 'Guía' : (hospedaje.TotalHospedaje || '0.00');
                tablegrupo += `
                    <tr>
                        <td>${grupo.TourName || ''}</td>
                        <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                        <td>${hospedaje.CategoriaHabitacion || ''} - Habitación #${hospedaje.habitacion_id || ''}</td>
                        <td>${mostrarGuia}</td>
                    </tr>
                `;
            });
        });

        tablegrupofoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL GRUPOS</td>
                <td class="text-center">${parseFloat(data.TotalGrupos || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablegrupo = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablegrupo}
            </tbody>
            <tfoot>
                ${tablegrupofoot}
            </tfoot>
        </table>`;
        /*GRUPO FIN*/

        /*RESERVA INICIO*/
        data.reservashospedaje.forEach(reserva => {
            const cliente = reserva.hospedajehabitacion.detallehospedajes && reserva.hospedajehabitacion.detallehospedajes.length > 0 ? reserva.hospedajehabitacion.detallehospedajes[0].cliente : null;

            tablereserva += `
                <tr>
                    <td>${reserva.CodigoReserva || ''}</td>
                    <td>${cliente ? cliente.NombreCompleto_cliente : 'Sin cliente'}</td>
                    <td>${reserva.CategoriaHabitacion || ''} - Habitación #${reserva.hospedajehabitacion.habitacion_id || ''}</td>
                    <td>${reserva.hospedajehabitacion.TotalHospedaje || '0.00'}</td>
                </tr>
            `;
        });

        tablereservafoot += `
            <tr>
                <td class="strong text-end" colspan="3">TOTAL RESERVAS</td>
                <td class="text-center">${parseFloat(data.TotalReservas || '0.00').toFixed(2)}</td>
            </tr>
        `;

        tablereserva = `
        <table class="table table-transparent">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Habitación</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                ${tablereserva}
            </tbody>
            <tfoot>
                ${tablereservafoot}
            </tfoot>
        </table>`;
        /*RESERVA FIN*/
    }

    TotalProduct.innerHTML = `
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">INFORMACION DE HOSPEDAJES</h3>
                    <div class="card-actions">
                        <a href="#" class="btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                        </a>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%; background: #F5F7F8">
                    ${divcontent}
                </div>
                <div class="card-footer p-12" style="background: #F5F7F8;">
                    ${table}
                </div>
            </div><br>
            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header d-flex justify-content-between align-items-center" id="heading-2">
                        <button class="accordion-button flex-grow-1" type="button" data-bs-toggle="collapse" data-bs-target="#HospedajeHabitacion" aria-expanded="false">
                        HOSPEDAJE HABITACION - ${data.CantidadHospedajes}
                        </button>
                    </h2>
                    <div id="HospedajeHabitacion" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tablehospedaje}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#GrupoHabitacion" aria-expanded="false">
                        GRUPOS - ${data.CantidadGrupos}
                        </button>
                    </h2>
                    <div id="GrupoHabitacion" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tablegrupo}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ReservasHabitacion" aria-expanded="false">
                        RESERVAS HABITACION - ${data.CantidadReservas}
                        </button>
                    </h2>
                    <div id="ReservasHabitacion" class="accordion-collapse collapse" data-bs-parent="#accordion-example" style="">
                        <div class="accordion-body pt-0">
                            <div class="card-footer">
                                ${tablereserva}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

            <div class="strong text-end">
                <a href="#" id="ReportePDFHospedajes">Más Detalle Exportar En PDF</a><br><br>
            </div>

        </div>`;

        $('#ReportePDFHospedajes').off('click').on('click', function(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
            
            // Obtener los valores de los filtros
            var tipoFiltro = $('#DateMovimientoReporteVenta').val();
            var dia = $('#DiaMovimientoReporteVenta').val();
            var mes = $('#MesMovimientoReporteVenta').val();
            var anio = $('#AnioMovimientoReporteVenta').val();
            var fechaInicio = $('#fechaInicioMovimiento').val();
            var fechaFin = $('#fechaFinMovimiento').val();
            var TipoMovimientoReporteVenta = $('#TipoMovimientoReporteVenta').val();
            
            // Crear parámetros de consulta
            var params = $.param({
                tipoFiltro: tipoFiltro,
                dia: dia,
                mes: mes,
                anio: anio,
                fechaInicio: fechaInicio,
                fechaFin: fechaFin,
                TipoMovimientoReporteVenta: TipoMovimientoReporteVenta
            });
        
            // Redirigir a la URL para descargar el PDF
            window.open('/apihostal/full-hostal-get-pdf?' + params, '_blank');
        });
}