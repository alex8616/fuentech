$(document).ready(function() {
    FechaSelectKardex()
    TraerProductos()
});


function FechaSelectKardex() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesKardex').empty();
    $('#AnioKardex').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesKardex').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesKardex').val(currentMonth + 1);

    var startYear = currentYear - 6;
    var endYear = currentYear;
    for (var year = startYear; year <= endYear; year++) {
        $('#AnioKardex').append('<option value="' + year + '">' + year + '</option>');
    }
    $('#AnioKardex').val(currentYear);

    function updateDaySelectorKardex() {
        var selectedMonth = parseInt($('#MesKardex').val());
        var selectedYear = parseInt($('#AnioKardex').val());
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaKardex').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaKardex').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaKardex').val(daysInMonth);
        } else {
            $('#DiaKardex').val(currentDay);
        }
    }

    updateDaySelectorKardex();

    $('#DateKardex').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioKardex':
                $('#DiaKardexContainer').show();
                $('#MesKardexContainer').show();
                $('#AnioKardexContainer').show();
                $('#FechaInicioContainerKardex').hide();
                $('#FechaFinContainerKardex').hide();
                break;
            case 'MensualKardex':
                $('#DiaKardexContainer').hide();
                $('#MesKardexContainer').show();
                $('#AnioKardexContainer').show();
                $('#FechaInicioContainerKardex').hide();
                $('#FechaFinContainerKardex').hide();
                break;
            case 'AnualKardex':
                $('#DiaKardexContainer').hide();
                $('#MesKardexContainer').hide();
                $('#AnioKardexContainer').show();
                $('#FechaInicioContainerKardex').hide();
                $('#FechaFinContainerKardex').hide();
                break;
            case 'RangoKardex':
                $('#DiaKardexContainer').hide();
                $('#MesKardexContainer').hide();
                $('#AnioKardexContainer').hide();
                $('#FechaInicioContainerKardex').show();
                $('#FechaFinContainerKardex').show();
                break;
            default:
                $('#DiaKardexContainer').show();
                $('#MesKardexContainer').show();
                $('#AnioKardexContainer').show();
                $('#FechaInicioContainerKardex').hide();
                $('#FechaFinContainerKardex').hide();
                break;
        }
        filtrarDatosKardex();
    });


    $('#MesKardex, #AnioKardex').on('change', function() {
        updateDaySelectorKardex();
        filtrarDatosKardex();
    });

    $('#DiaKardex').on('change', function() {
        filtrarDatosKardex();
    });

    $('#FechaInicioContainerKardex').on('change', function() {
        filtrarDatosKardex();
    });

    $('#FechaFinContainerKardex').on('change', function() {
        filtrarDatosKardex();
    });

    $('#ProductoKardexSelect').on('change', function() {
        filtrarDatosKardex();
    });

    $('#TipoKardexSelect').on('change', function() {
        filtrarDatosKardex();
    });

    $('#DateKardex').trigger('change');

}

function filtrarDatosKardex(){
    var tipoFiltro = $('#DateKardex').val();
    var dia = $('#DiaKardex').val();
    var mes = $('#MesKardex').val();
    var anio = $('#AnioKardex').val();
    var fechaInicio = $('#fechaInicioKardex').val();
    var fechaFin = $('#fechaFinKardex').val();
    var TipoProducto = $('#ProductoKardexSelect').val();
    var TipoKardex = $('#TipoKardexSelect').val();

    $.ajax({
        url: 'api/filtrar-datos-kardex',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            TipoProducto: TipoProducto,
            TipoKardex: TipoKardex,
        },
        success: function(response) {
            //MostrarDivCantidadKardexs(response.cantidadregistros);
            mostrarResultadosKardexs(response);
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function MostrarDivTotalKardexs(total){
    $('#PrecioTotal').text('Bs. '+total);
}

function MostrarDivCantidadKardexs(cantidad){
    $('#CantidadRegistroDatos').text(cantidad);
}

function mostrarResultadosKardexs(filteredData) {
    $('#tabla-gasto tbody').empty();
    $.each(filteredData.Kardex, function(index, Karde) {
        var badgeClass = Karde.TipoStock === "Ingreso" ? "bg-green" : "bg-red";
        if(Karde.TipoStock === "Ingreso"){
            var row = '<tr>' +
                '<td hidden>' + Karde.id + '</td>' +
                '<td><span class="badge ms-auto ' + badgeClass + '"></span></td>' +
                '<td>' + Karde.FechaStock + '</td>' +
                '<td>' + Karde.DetalleStock + '</td>' +
                '<td>' + Karde.TipoServicio + '</td>' +
                '<td>' + Karde.stockdates.productos.NombreProducto + '</td>' +
                '<td style="text-align: center">' + Karde.Diferencia + '</td>' +
                '<td style="text-align: center">' + Karde.StockAnterior + '</td>' +
                '<td style="background: #88D66C; text-align: center; font-weight: bold; font-size: 19px">' + Karde.StockActual + '</td>' +
                '</tr>';
        
            $('#tabla-gasto tbody').append(row);
        }else if(Karde.TipoStock === "Salida"){
            var row = '<tr>' +
                '<td hidden>' + Karde.id + '</td>' +
                '<td><span class="badge ms-auto ' + badgeClass + '"></span></td>' +
                '<td>' + Karde.FechaStock + '</td>' +
                '<td>' + Karde.DetalleStock + '</td>' +
                '<td>' + Karde.TipoServicio + '</td>' +
                '<td>' + Karde.stockdates.productos.NombreProducto + '</td>' +
                '<td style="background: #FF4C4C; text-align: center">' + Karde.Diferencia + '</td>' +
                '<td style="background: #68D2E8; text-align: center">' + Karde.StockAnterior + '</td>' +
                '<td style="background: #88D66C; text-align: center; font-weight: bold; font-size: 19px">' + Karde.StockActual + '</td>' +
                '</tr>';
        
            $('#tabla-gasto tbody').append(row);
        }else if(Karde.TipoStock === "Faltante"){
            if(Karde.EstadoStock === "Activo"){
                var row = '<tr style="background: #BCCCDC; font-weight: bold;">' +
                    '<td hidden>' + Karde.id + '</td>' +
                    '<td colspan="2">' + Karde.FechaStock + '</td>' +
                    '<td>' + Karde.DetalleStock + '</td>' +
                    '<td>' + Karde.TipoServicio + '</td>' +
                    '<td>' + Karde.stockdates.productos.NombreProducto + '</td>' +
                    '<td>' + Karde.Diferencia + '</td>' +
                    '<td>' + Karde.StockAnterior + '</td>' +
                    '<td>' + Karde.StockActual + '</td>' +
                    '</tr>';
            
                $('#tabla-gasto tbody').append(row);
            }else{
                var row = '<tr style="background: #FEF3E2; font-weight: bold;">' +
                        '<td hidden>' + Karde.id + '</td>' +
                        '<td colspan="2">' + Karde.FechaStock + '</td>' +
                        '<td>' + Karde.DetalleStock + '</td>' +
                        '<td>' + Karde.TipoServicio + '</td>' +
                        '<td>' + Karde.stockdates.productos.NombreProducto + '</td>' +
                        '<td>' + Karde.Diferencia + '</td>' +
                        '<td>' + Karde.StockAnterior + '</td>' +
                        '<td>' + Karde.StockActual + '</td>' +
                    '</tr>'+
                    '<tr style="background: #FEF3E2; font-weight: bold;">' +
                        '<td> Solucion </td>' +
                        '<td colspan="5">' + Karde.SolucionStock + '</td>' +
                        '<td>' + Karde.FechaInicioSolucion + '</td>' +
                        '<td>' + Karde.FechaFinSolucion + '</td>' +
                    '</tr>'
                    ;
            
                $('#tabla-gasto tbody').append(row);
            }
        }else if(Karde.TipoStock === "Sobrante"){
            if(Karde.EstadoStock === "Activo"){
                var row = '<tr style="background: #BCCCDC; font-weight: bold;">' +
                    '<td hidden>' + Karde.id + '</td>' +
                    '<td colspan="2">' + Karde.FechaStock + '</td>' +
                    '<td>' + Karde.DetalleStock + '</td>' +
                    '<td>' + Karde.TipoServicio + '</td>' +
                    '<td>' + Karde.stockdates.productos.NombreProducto + '</td>' +
                    '<td>' + Karde.Diferencia + '</td>' +
                    '<td>' + Karde.StockAnterior + '</td>' +
                    '<td>' + Karde.StockActual + '</td>' +
                    '</tr>';
            
                $('#tabla-gasto tbody').append(row);
            }else{
                var row = '<tr style="background: #FEF3E2; font-weight: bold;">' +
                        '<td hidden>' + Karde.id + '</td>' +
                        '<td colspan="2">' + Karde.FechaStock + '</td>' +
                        '<td>' + Karde.DetalleStock + '</td>' +
                        '<td>' + Karde.TipoServicio + '</td>' +
                        '<td>' + Karde.stockdates.productos.NombreProducto + '</td>' +
                        '<td>' + Karde.Diferencia + '</td>' +
                        '<td>' + Karde.StockAnterior + '</td>' +
                        '<td>' + Karde.StockActual + '</td>' +
                    '</tr>'+
                    '<tr style="background: #FEF3E2; font-weight: bold;">' +
                        '<td> Solucion </td>' +
                        '<td colspan="5">' + Karde.SolucionStock + '</td>' +
                        '<td>' + Karde.FechaInicioSolucion + '</td>' +
                        '<td>' + Karde.FechaFinSolucion + '</td>' +
                    '</tr>'
                    ;
            
                $('#tabla-gasto tbody').append(row);
            }
        }
    });

    //agregarEventosMovimientoTabla();

    $('#tabla-gasto tbody').on('click', 'tr', function() {
        var id = $(this).find('td:first').text();
        $('#tabla-gasto tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');

        $.ajax({
            url: '/api/get-detallestock-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionKardex(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos de producto:', error);
            }
        });
    });
}

function InformacionKardex(data){
    if (data.consumo === null) {
    }else{
        var dibtiposervicioconsumo = '';
        if(data.consumo.TipoConsumo === "Mostrador"){
            dibtiposervicioconsumo += `
                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                    <h3 class="card-title" style="color: black; margin: 0">${data.consumo.TipoConsumo}</h3>
                </div>
                <div class="col-12 col-md-12">
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.fecha_venta}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha De Cierre</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.FechaCierre}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.cliente ? data.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.Comentario ? data.consumo.Comentario : 'Sin Comentario'}</label>
                        </div>
                    </div>
                </div>
            `;
            $('#DatosTipoServicioConsumo').append(dibtiposervicioconsumo);
        }
    
        if(data.consumo.TipoConsumo === "Mesa"){
            dibtiposervicioconsumo += `
                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                    <h3 class="card-title" style="color: black; margin: 0">${data.consumo.TipoConsumo}</h3>
                </div>
                <div class="col-12 col-md-12">
                    <div class="mb-12 row">
                        <div class="col">
                            <label class="col-12 col-form-label" style="color: #61677A">${data.consumo.TipoConsumo} # ${data.consumo.ambientemesa.Name} - con ${data.consumo.CantidadPersonas} Personas.</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.fecha_venta}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha De Cierre</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.FechaCierre}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.cliente ? data.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.Comentario ? data.consumo.Comentario : 'Sin Comentario'}</label>
                        </div>
                    </div>
                </div>
            `;
            $('#DatosTipoServicioConsumo').append(dibtiposervicioconsumo);
        }
        
        if(data.consumo.TipoConsumo === "Delivery"){
            dibtiposervicioconsumo += `
                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                    <h3 class="card-title" style="color: black; margin: 0">${data.consumo.TipoConsumo}</h3>
                </div>
                <div class="col-12 col-md-12">
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.fecha_venta}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha De Cierre</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.FechaCierre}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.cliente ? data.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Direccion</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.cliente ? data.consumo.cliente.CalleCliente +" - "+ data.consumo.cliente.BarrioCliente : "Sin Cliente"} </label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.DeliveryComentario ? data.consumo.DeliveryComentario : 'Sin Comentario'}</label>
                        </div>
                    </div>
                </div>
            `;
            $('#DatosTipoServicioConsumo').append(dibtiposervicioconsumo);
        }
    
        if(data.consumo.TipoConsumo === "Habitacion"){
            dibtiposervicioconsumo += `
                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                    <h3 class="card-title" style="color: black; margin: 0">${data.consumo.TipoConsumo} #${data.hospedaje.habitacion_id}</h3>
                </div>
                <div class="col-12 col-md-12">
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.fecha_venta}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha De Cierre</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.FechaCierre}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Huesped</label>
                        <div class="col">
                             <label class="col-8 col-form-label" style="color: #61677A">
                                ${data.hospedaje.detallehospedajes && data.hospedaje.detallehospedajes.length > 0
                                    ? data.hospedaje.detallehospedajes.map(detalle => `
                                        <div>
                                            <span>${detalle.cliente.NombreCompleto_cliente}</span><br>
                                        </div>
                                    `).join('')
                                    : 'No hay huéspedes registrados'
                                }
                            </label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A"></label>
                        </div>
                    </div>
                </div>
            `;
            $('#DatosTipoServicioConsumo').append(dibtiposervicioconsumo);
        }
    
        if(data.consumo.TipoConsumo === "Salon"){
            dibtiposervicioconsumo += `
                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                    <h3 class="card-title" style="color: black; margin: 0">${data.consumo.TipoConsumo}</h3>
                </div>
                <div class="col-12 col-md-12">
                    <div class="mb-12 row">
                        <div class="col">
                            <label class="col-12 col-form-label" style="color: #61677A">${data.consumo.TipoConsumo} ${data.hospedaje.salon.Nombre_salon}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.fecha_venta}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha De Cierre</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.FechaCierre}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.hospedaje.clientereserva.NombreCliente}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Empresa</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.hospedaje.empresareserva.NombreEmpresa}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.hospedaje.ComentarioReserva}</label>
                        </div>
                    </div>
                </div>
            `;
            $('#DatosTipoServicioConsumo').append(dibtiposervicioconsumo);
        }
    
        if(data.consumo.TipoConsumo === "ServicioPedido"){
            dibtiposervicioconsumo += `
                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                    <h3 class="card-title" style="color: black; margin: 0">${data.consumo.TipoServicioPedido}</h3>
                </div>
                <div class="col-12 col-md-12">
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.fecha_venta}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Numero De Orden</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.NroOrdenServicioPedido}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Nro De Pedido</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.NroPedidoServicioPedido}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.ClienteServicioPedido} </label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.DeliveryComentario ? data.consumo.DeliveryComentario : 'Sin Comentario'}</label>
                        </div>
                    </div>
                </div>
            `;
            $('#DatosTipoServicioConsumo').append(dibtiposervicioconsumo);
        }
    
        if(data.consumo.TipoConsumo === "VentaSuelta"){
            dibtiposervicioconsumo += `
                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                    <h3 class="card-title" style="color: black; margin: 0">Venta Suelta</h3>
                </div>
                <div class="col-12 col-md-12">
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.fecha_venta}</label>
                        </div>
                    </div>
                    <div class="mb-12 row">
                        <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                        <div class="col">
                            <label class="col-8 col-form-label" style="color: #61677A">${data.consumo.Comentario ? data.consumo.Comentario : 'Sin Comentario'}</label>
                        </div>
                    </div>
                </div>
            `;
            $('#DatosTipoServicioConsumo').append(dibtiposervicioconsumo);
        }
    }

    var TotalProduct = document.getElementById('form_tabs');

    if(data.detalle.TipoStock === "Ingreso" || data.detalle.TipoStock === "Salida"){
        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">DETALLE ${data.detalle.id}</h3>
                    <div class="card-actions">
                        
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">PRODUCTO</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.stockdates.productos.NombreProducto}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">TIPO</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.TipoStock}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">TIPO DE VENTA</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.TipoServicio}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">STOCK ACTUAL</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.StockActual}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">DETALLE</label>
                                <div class="col">
                                    <label class="col-12 col-form-label" style="color: #61677A">${data.detalle.DetalleStock}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="row">
                        <div class="col-12 col-md-12" id="SelectedProducts">
                        ${data.consumo ?
                            `
                            <div class="accordion" id="accordion-example">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false">
                                        Venta - Consumo
                                    </button>
                                    </h2>
                                    <div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                                        <div class="accordion-body pt-0">
                                            <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                                <div class="card-body" style="padding: 0px; margin: 0px;">                                                    
                                                    <div class="row" id="DatosTipoServicioConsumo">
                                                        ${dibtiposervicioconsumo}
                                                    </div>
                                                    <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                                        <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                                            ${data.consumo.detalleconsumos.map((detalle, index) => `
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
                                                                    <h3 class="card-title" style="color: white">${data.consumo.subTotal}</h3>
                                                                </div>
                                                            </div>

                                                            ${data.consumo.descuentoconsumos.length > 0 ? ` 
                                                                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                                    <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                                </div>
                                                                ${data.consumo.descuentoconsumos.map((descuento, index) => `
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
                                                                    <h3 class="card-title" style="color: white">${data.consumo.total}</h3>
                                                                </div>
                                                            </div>


                                                            ${data.consumo.pagosconsumos.length > 0 ? ` 
                                                                <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                                    <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                                </div>
                                                                ${data.consumo.pagosconsumos.map((pago, index) => `
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ` 
                        : 
                            ''
                        }
                        </div>
                    </div>
                </div>

            </div>
        </div>`;
    }else{
        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">DETALLE</h3>
                    <div class="card-actions">
                       
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">PRODUCTO</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.stockdates.productos.NombreProducto}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">TIPO</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.TipoStock}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">STOCK QUE DEJARON</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.StockAnterior}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">FALTANTE DE </label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.Diferencia}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">STOCK ACTUAL</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.StockActual}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">FALTANTE RESPONSABLE </label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">${data.detalle.users.name}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">DETALLE</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data.detalle.DetalleStock}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row" style="display: none" id="DetalleKardexs">
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
                    <div class="row" id="btnDetalleKardexs">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                            ${data.detalle.EstadoStock === "Activo" ? 
                                `<a class="btn btn-outline-primary w-50" href="#" data-bs-toggle="modal" data-bs-target="#ModalSolucion" id="ModalSolucionKardex">
                                    Dar Solucion
                                </a>
                                <a class="btn btn-outline-danger w-50" href="#" id="VerPendientePDFKardex">
                                    Imprimir
                                </a>
                                `
                                : 
                                `
                                <div class="row">
                                    SOLUCIONADO <br>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-12 col-form-label" style="font-weight: bold">DETALLE</label>
                                            <div class="col">
                                                <label class="col-12 col-form-label" style="color: #61677A">${data.detalle.SolucionStock}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-12 col-form-label" style="font-weight: bold">FECHA INICIO</label>
                                            <div class="col">
                                                <label class="col-12 col-form-label" style="color: #61677A">${data.detalle.FechaInicioSolucion}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-12 col-form-label" style="font-weight: bold">FECHA FIN</label>
                                            <div class="col">
                                                <label class="col-12 col-form-label" style="color: #61677A">${data.detalle.FechaFinSolucion}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `
                            }
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }
    
    $('#VerPendientePDFKardex').off('click').on('click', function(event) {
        event.preventDefault();
    
        var StockId = data.detalle.id; 
        var DescripcionSolucion = $("#DescripcionSolucion").val();
        var SelectKardex = $("#SelectKardex").val();
    
        var formData = new FormData();
        formData.append('DescripcionSolucion', DescripcionSolucion);
        formData.append('StockId', StockId);
    
        $.ajax({
            url: '/api/genrar-pdf-pendiente-kardex/' + StockId,
            type: 'GET',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var pdfBase64 = response.pdfBase64;
                $('#ModalSolucionPDF').modal('show');
                $('#pdfIframe').attr('src', pdfBase64);
                
                MostrarMensaje("Impresión Exitosa", "success");
            },
            error: function(error) {
                console.error('Error al generar el PDF:', error);
            }
        });
    });
    
    

    $('#ModalSolucionKardex').off('click').on('click', function(event) {
        event.preventDefault();
        var StockId = data.detalle.id;
        
        $('#RegistrarSolucionKardex').off('click').on('click', function(event) {
            var DescripcionSolucion = $("#DescripcionSolucion").val();
            var SelectKardex = $("#SelectKardex").val();
    
            var formData = new FormData();
            formData.append('DescripcionSolucion', DescripcionSolucion);
            formData.append('StockId', StockId);
        
            $.ajax({
                url: '/api/registrar-solucion-kardex',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function(response) {
                    CanvasTime();
                    filtrarDatosKardex();
                    $('#ModalSolucionKardex').modal('hide');
                    $('#DescripcionSolucion').val('');
                    MostrarMensaje("Ingreso Registrado Exitosamente", "success");
                },
                error: function(error) {
                    console.error('Error al registrar:', error);
                }
            });
        });
    });

    function CargarDatosKardex(){
        $('#SelectKardex').empty();
        $.ajax({
            url: '/api/get-kardex-ultimo-registros',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    $.each(data, function(index, kardex) {
                        var option = $('<option>', {
                            value: kardex.id, 
                            text: kardex.DetalleStock
                        });
                        $('#SelectKardex').append(option);
                    });
                } else {
                    console.warn('No se encontraron kardex.');
                }
            },
            error: function(error) {
                console.error('Error al obtener los kardex:', error);
            }
        });
    }
}

function TraerProductos(){
    $.ajax({
        url: '/api/get-productos-favorite-stock',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            
            $('#ProductoKardexSelect').empty().append('<option value="TodoProducto">Productos</option>');
            $.each(data, function(index, producto) {
                var option = $('<option>', {
                    value: producto.id, 
                    text: producto.NombreProducto
                });
                $('#ProductoKardexSelect').append(option);
            });
        },
        error: function(error) {
            console.error('Error al obtener los productos:', error);
        }
    });
}

$('#btn-exportar-pdf-movimientos').off('click').on('click', function(event) {
    event.preventDefault();
    
    var tipoFiltro = $('#DateKardex').val();
    var dia = $('#DiaKardex').val();
    var mes = $('#MesKardex').val();
    var anio = $('#AnioKardex').val();
    var fechaInicio = $('#fechaInicioKardex').val();
    var fechaFin = $('#fechaFinKardex').val();
    var TipoProducto = $('#ProductoKardexSelect').val();
    var TipoKardex = $('#TipoKardexSelect').val();

    var url = 'api/filtrar-datos-exportar-pdf-movimientos?' + 
        $.param({
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            TipoProducto: TipoProducto,
            TipoKardex: TipoKardex
        });

    window.open(url, '_blank');
});


