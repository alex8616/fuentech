function OcupadoReservaSalon(id){
    var SalonIdPrivate = id
    $.ajax({
        url: '/apihostal/get-salon-ocupada/'+id,
        method: 'GET',
        success: function(response) {
            var data = response.reservasalon
            $.ajax({
                url: '/apihostal/get-reserva-salon-seleccionado/' + data[0].id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var TotalProduct = document.getElementById('form_tabs');
                    TotalProduct.innerHTML = '';
                    var idrecuperado = data[0].id;
                    let divadelantos = '';
                    let adelantos = data[0].adelantos;
                    let estado = data[0].EstadoReserva;
                    let dateservicios = data[0].servicios;
                    let divdetalleservicio = '';
                    let divdetalleserviciotfoot = '';
                    let titledivtotalservicio= '';
                    let titledivtotalservicioconsumo= '';
        
                    let dateconsumos = data[0].servicioconsumos;
                    let divconsumos = ''; 
                    let divconsumosfoot = '';
        
                    if (dateconsumos.length > 0) {
                        dateconsumos[0].consumo.forEach(function(allconsumo) {
                            // Comenzamos una fila por cada consumo
                            divconsumos += `
                                <tr>
                                    <td style="width: 10%">
                                        ${allconsumo.ocupado === 'false' 
                                            ? '<span class="badge badge-outline text-green">SI</span>' 
                                            : `<span class="badge badge-outline text-red" id="btn-pagar-consumo-reserva-ocupado" data-bs-toggle="modal" data-bs-target="#Modal-Cerrar-Consumo-Reserva-Salon-Ocupado"  data-id="${allconsumo.id}" style="cursor: pointer;">NO</span>`}
                                    </td>
                                    <td colspan="6"> <!-- Aquí van todos los detalles dentro de una única celda -->
                                        <div class="row" style="background: #FDFAD9">
                            `;
                        
                            // Aquí iteramos sobre los detalles del consumo y los añadimos dentro de esta celda
                            allconsumo.detalleconsumos.forEach(function(alldetalleconsumo) {
                                divconsumos += `
                                    <div class="row" style="padding: 5px 0;">
                                        <div class="col-12 col-md-2">
                                            ${alldetalleconsumo.cantidad}
                                        </div>
                                        <div class="col-12 col-md-6">
                                            ${alldetalleconsumo.producto.NombreProducto}
                                        </div>
                                        <div class="col-12 col-md-4">
                                            ${alldetalleconsumo.precio}
                                        </div>
                                    </div>
                                `;
                            });
                        
                            // Cerramos el div de los detalles y la fila del consumo
                            divconsumos += `
                                    </td>
                                    <td style="width: 10%">
                                        ${allconsumo.total}
                                    </td>
                                </tr>
                            `;
                        });
        
                        divconsumosfoot += `
                            <tr>
                                <td colspan="7" style="text-align: right;">SubTotal:</td>
                                <td id="total-consumo-reserva-subtotal">${dateconsumos[0].subTotal || '0.00'}</td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: right;">Pagado:</td>
                                <td id="total-consumo-reserva-pagado">${dateconsumos[0].totalpagado || '0.00'}</td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: right;">TOTAL:</td>
                                <td id="total-consumo-reserva-total">${dateconsumos[0].totalgeneral || '0.00'}</td>
                            </tr>
                        `;        
                    }
        
                    if(data[0].servicios[0]){
                        titledivtotalservicio+= `
                            <span>${data[0].servicios[0].totalgeneral}</span>
                        `;
                    }
                        
                    if(data[0].servicioconsumos[0]){
                        titledivtotalservicioconsumo+= `
                            <span>${data[0].servicioconsumos[0].totalgeneral}</span>
                        `;
                    }
        
                    if (dateservicios.length > 0) {
                            dateservicios[0].detalleservicio.forEach(function(servicio, index) {
                            if(servicio.eliminado == "true"){
                                divdetalleservicio += `
                                    <tr data-id="${servicio.id}">
                                        <td><s>${servicio.TipoServicio}</s></td>
                                        <td><s>${servicio.comentarioeliminado}</s></td>
                                        <td><s>${servicio.cantidad}</s></td>
                                        <td><s>${servicio.precio}</s></td>
                                        <td><s>${servicio.total}</s></td>
                                    </tr>
                                `;
                            }else{
                                divdetalleservicio += `
                                <tr data-id="${servicio.id}">
                                    <td>${servicio.TipoServicio}</td>
                                    <td>${servicio.comentario}</td>
                                    <td><input type="text" id="cantidad-${servicio.id}" value="${servicio.cantidad}" disabled class="form-control cantidad-servicio"></td>
                                    <td><input type="text" id="precio-${servicio.id}" value="${servicio.precio}" disabled class="form-control precio-servicio"></td>
                                    <td><span id="total-${servicio.id}">${servicio.total}</span></td>
                                    <td>
                                        <span class="badge bg-blue-lt edit-servicio-salon" data-id="${servicio.id}">E</span>
                                        <span class="badge bg-red-lt delete-servicio-salon" data-id="${servicio.id}" data-bs-toggle="modal" data-bs-target="#modal-delete-ambiente-salon">X</span>
                                    </td>
                                </tr>
                            `;
                            }
                            
                        });
                        divdetalleserviciotfoot += `
                            <tr>
                                <td colspan="4" style="text-align: right;">TOTAL:</td>
                                <td id="total-servicio-data-total">${dateservicios[0].totalgeneral || '0.00'}</td>
                                <td></td>
                            </tr>
                        `;
                    }
        
                    if (adelantos) {
                        adelantos.forEach(function(adelanto) {
                            divadelantos += `
                                <div class="row">
                                    <div class="col-12 col-md-5" style="padding: 0px; margin: 0px">
                                        <label class="col-12 col-form-label" style="color: #61677A">${adelanto.FechaDeAdelanto || ''} </label>                       
                                    </div>
                                    <div class="col-12 col-md-4" style="padding: 0px; margin: 0px">
                                        <label class="col-12 col-form-label" style="color: #61677A">${adelanto.TipoAdelanto || ''}</label>                        
                                    </div>
                                    <div class="col-12 col-md-3" style="padding: 0px; margin: 0px">
                                        <label class="col-12 col-form-label" style="color: #61677A">${adelanto.TotalAdelanto || ''}</label>                        
                                    </div>
                                </div>
                            `;
                        });
                    }
                    
                    TotalProduct.innerHTML = `
                        <div class="col-md-6 col-lg-12">
                            <div class="card">
                                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                                    <h3 class="card-title">CODIGO DE RESERVA ${data[0].Codigosalon}</h3>
                                    <div class="card-actions">
                                        <a href="#" class="btn" data-reserva-id="${data[0].id}" id="Editar-reserva">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a href="#tabs-reserva-ambiente-salon" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">RESERVA</a>
                                                </li>
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SERVICIOS</a>
                                                    <div class="dropdown-menu" style="">
                                                    <a class="dropdown-item" href="#tabs-servicio-data-salon" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                                        Data Display
                                                    </a>
                                                    </div>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a href="#tabs-consumo-ambiente-salon" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">CONSUMOS</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active show" id="tabs-reserva-ambiente-salon" role="tabpanel">
                                                    <div class="datagrid" style="background: white">
                                                        <div class="card-body p-12" style="height: 100%">
                                                            <div class="row" id="edit-div">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Codigo</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].Codigosalon}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Fecha</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].ingreso_salon}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora Ingreso</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].hora_ingreso}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].clientereserva.NombreCliente}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Telefono</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].clientereserva.CelularCliente}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
        
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Salon</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].salon.Nombre_salon}</label>
                                                                        </div>
                                                                    </div>                          
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Tarifa</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].Tarifa_salon}</label>
                                                                        </div>
                                                                    </div>                           
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora Salida</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].hora_salida}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Empresa</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].empresareserva.NombreEmpresa}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-12 row">
                                                                        <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                                                        <div class="col">
                                                                            <label class="col-8 col-form-label" style="color: #61677A">${data[0].ComentarioReserva}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
        
                                                                <div class="col-12 col-sm-12">
                                                                    <div class="card-header" style="width: 100%; background-color: #151f2c; color: white">
                                                                        <h3 class="card-title">SERVICIOS</h3>
                                                                        <div class="ms-auto">
                                                                            <h3 class="card-title" style="font-size: 25px; color: red" id="titledivtotalservicio">${titledivtotalservicio}</h3>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="accordion" id="accordion-example">
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header" id="heading-4">
                                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#containerservicio" aria-expanded="false">
                                                                                    Servicios
                                                                                </button>
                                                                            </h2>
                                                                            <div id="containerservicio" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                                                                                <div class="accordion-body pt-0">
                                                                                    <div class="card">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-vcenter card-table" id="table-servicios-data">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                <th>Tipo Servicio</th>
                                                                                                <th>Comentario</th>
                                                                                                <th>Cant</th>
                                                                                                <th>Precio</th>
                                                                                                <th>Total</th>
                                                                                                <th></th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                ${divdetalleservicio}
                                                                                            </tbody>
                                                                                            <tfoot>
                                                                                                ${divdetalleserviciotfoot}
                                                                                            </tfoot>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
        
                                                                <div class="col-12 col-sm-12">
                                                                    <div class="card-header" style="width: 100%; background-color: #151f2c; color: white">
                                                                        <h3 class="card-title">CONSUMOS</h3>
                                                                        <div class="ms-auto">
                                                                            <h3 class="card-title" style="font-size: 25px; color: red" id="titledivtotalservicioconsumo">${titledivtotalservicioconsumo}</h3>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="accordion" id="accordion-example">
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header" id="heading-4">
                                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#containerconsumo" aria-expanded="false">
                                                                                    Consumos
                                                                                </button>
                                                                            </h2>
                                                                            <div id="containerconsumo" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                                                                                <div class="accordion-body pt-0">
                                                                                    <div class="card">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-vcenter card-table" id="table-consumos-reserva">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                <th>Pagado</th>
                                                                                                <th colspan="6">Detalle Consumo</th>
                                                                                                <th>Total</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                ${divconsumos}
                                                                                            </tbody>
                                                                                            <tfoot>
                                                                                                ${divconsumosfoot}
                                                                                            </tfoot>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
        
                                                                <div class="col-12 col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-12 col-md-12">
                                                                            <div class="mb-12 row">
                                                                                <label class="col-12 col-form-label" style="font-weight: bold">
                                                                                    <a class="form-controll" id="btn-registrar-adelanto-salon-ocupado" data-bs-toggle="modal" data-bs-target="#modal-adelanto-reserva-salon-ocupado">Registrar Adelanto</a>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-md-6">
                                                                            <div class="card" style="padding: 10px">
                                                                                <div class="row" style="margin: 0px; margin: 0px;">
                                                                                    adelantos 
                                                                                </div>
                                                                                <div class="card-footer" style="padding: 5px">
                                                                                ${divadelantos}
                                                                                    <div class="row" style="background: #1d2736; color: white; padding-top: 12px">
                                                                                        <div class="col-12 col-md-6">
                                                                                            <h3 class="card-title">TOTAL</h3>
                                                                                        </div>
                                                                                        <div class="col-12 col-md-6">
                                                                                            <h3 class="card-title" style="font-weight: bold">${data[0].Adelanto}</h3>                                                     
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6">
                                                                            <div class="mb-3">
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <table class="table table-sm table-borderless">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th colspan="2" style="text-align: right; padding-right: 20px">PRECIO SALON</th>
                                                                                                <td style="text-align: left; padding-left: 20px" id="TotalPrecioSalon"></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="2" style="text-align: right; padding-right: 20px">TOTAL CONSUMO</th>
                                                                                                <td style="text-align: left; padding-left: 20px" id="TotalConsumoSalon"></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="2" style="text-align: right; padding-right: 20px">TOTAL SERVICIOS</th>
                                                                                                <td style="text-align: left; padding-left: 20px" id="TotalServicioSalon"></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="2" style="text-align: right; padding-right: 20px">SUB TOTAL</th>
                                                                                                <td style="text-align: left; padding-left: 20px" id="SubTotalSalon"></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="2" style="text-align: right; padding-right: 20px">ADELANTOS</th>
                                                                                                <td style="text-align: left; padding-left: 20px" id="TotalAdelantoSalon"></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th colspan="2" style="font-size: 19px; text-align: right; padding-right: 20px">TOTAL A PAGAR</th>
                                                                                                <th style="font-size: 19px; text-align: left; padding-left: 20px" id="TotalSalon"></th>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>                                
                                                                    </div>
                                                                </div>
                                                                
                                                                <br><br>
                                                                <div class="mb-12 row">
                                                                    <div class="card-footer">
                                                                        <div class="d-flex justify-content-end">
                                                                            <button type="button" class="btn btn-primary" id="btn-dar-baja-reserva-salon" data-bs-toggle="modal" data-bs-target="#modal-dar-baja-reserva-salon-ocupado" data-id="${data[0].id}" data-total="${data[0].Total}">DAR DE BAJA SALON</button> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="tab-pane" id="tabs-consumo-ambiente-salon" role="tabpanel">
                                                    <div class="datagrid" style="background: white">
                                                        <div class="row">
                                                            <h3 class="card-title" style="width: 100%; background:#151f2c; color: white; padding: 8px">CONSUMOS</h3>
                                                            <div class="row" id="div-consumos-hmtl-salon">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="tab-pane" id="tabs-servicio-data-salon" role="tabpanel">
                                                    <div class="datagrid" style="background: white">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Servicio</label>
                                                                    <select class="form-control" id="ServicioAlquilerSalon">
                                                                        <option value="DataDisplay">DataDisplay</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Cantidad Horas</label>
                                                                    <input type="text" class="form-control convertNumber" id="CantidadAlquilerSalon">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Precio</label>
                                                                    <input type="text" class="form-control convertNumber"  value="50" id="PrecioAlquilerSalon">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Total</label>
                                                                    <input type="text" class="form-control convertNumber" id="TotalAlquilerSalon">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Comentario</label>
                                                                    <textarea class="form-control convertmayusculas" id="ComentarioAlquilerSalon"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12">
                                                                <div class="card-footer">
                                                                    <div class="d-flex">
                                                                    <a href="#" class="btn btn-red" id="btn-desayuno-cancelar">Cancel</a>
                                                                    <a href="#" class="btn btn-primary ms-auto" id="btn-registrar-prestamos-data">Registrar Prestamo Data</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
        
                        convertirMayusculas()
                        ListarConsumoSalon(data)
        
                        $('#TotalPrecioSalon').text(data[0].Precio_salon);
                        $('#TotalServicioSalon').text(data[0].TotalServicio);
                        $('#TotalConsumoSalon').text(data[0].TotalConsumo);
                        $('#SubTotalSalon').text(data[0].SubTotal);
                        $('#TotalAdelantoSalon').text(data[0].Adelanto);
                        $('#TotalSalon').text(data[0].Total);
        
                        $('#CantidadAlquilerSalon').on('input', function() {
                            let cantidadHoras = parseFloat($(this).val());
                            let precio = parseFloat($('#PrecioAlquilerSalon').val());
                            if (!isNaN(cantidadHoras) && cantidadHoras > 0) {
                                let total = cantidadHoras * precio;
                                $('#TotalAlquilerSalon').val(total.toFixed(2));
                            } else {
                                $('#TotalAlquilerSalon').val('');
                            }
                        });
        
                        /* ELIMINAR INICIO */
                        $(document).on('click', '.delete-servicio-salon', function() {
                            let id = $(this).data('id');
                            $('#btn-registrar-delete-servicio-salon').data('id', id);
                            $('#ComentarioDeleteServicioSalon').val('');
                        });
                        
                        $('#btn-registrar-delete-servicio-salon').off('click').on('click', function(event) {
                            event.preventDefault();
                            let id = $(this).data('id');
                            let comentario = $('#ComentarioDeleteServicioSalon').val();
                            
                            var data = {
                                _token: '{{ csrf_token() }}',
                                id: id,
                                ComentarioDeleteServicioSalon: comentario
                            };
                        
                            $.ajax({
                                url: '/apihostal/delete-detalle-data-salon',
                                method: 'POST',
                                data: data,
                                success: function(response) {
                                    filtrarDatosReserva()
                                    InformacionReservaSalon(data)
                                    MostrarMensaje("Servicio Eliminado Exitosamente", "success");
                                },
                                error: function() {
                                    MostrarMensaje("Error al eliminar el servicio.", "error");
                                }
                            });
                        });
                        /* ELIMINAR FIN */
                        
                        /* EDITAR INICIO */
                        $(document).on('click', '.edit-servicio-salon', function() {
                            let id = $(this).data('id');
                            $(`#cantidad-${id}, #precio-${id}`).prop('disabled', false);
                            $(this).text('G').removeClass('edit-servicio-salon bg-blue-lt').addClass('save-servicio-salon bg-green-lt');
                        });
        
                        $(document).on('input', '.cantidad-servicio, .precio-servicio', function() {
                            let id = $(this).closest('tr').data('id');
                            let cantidad = $(`#cantidad-${id}`).val();
                            let precio = $(`#precio-${id}`).val();
                            let total = cantidad * precio;
                            $(`#total-${id}`).text(total.toFixed(2));
                        });
        
                        $(document).on('click', '.save-servicio-salon', function() {
                            let id = $(this).data('id');
                            let nuevaCantidad = $(`#cantidad-${id}`).val();
                            let nuevoPrecio = $(`#precio-${id}`).val();
                            let nuevoTotal = nuevaCantidad * nuevoPrecio;
        
                            $(`#total-${id}`).text(nuevoTotal.toFixed(2));
                            $(`#cantidad-${id}, #precio-${id}`).prop('disabled', true);
                            $(this).text('E').removeClass('save-servicio-salon bg-green-lt').addClass('edit-servicio-salon bg-blue-lt');
        
                            $.ajax({
                                url: '/apihostal/actualizar-data-salon',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id,
                                    cantidad: nuevaCantidad,
                                    precio: nuevoPrecio,
                                    total: nuevoTotal
                                },
                                success: function(response) {
                                    filtrarDatosReserva()
                                    InformacionReservaSalon(response)
                                    MostrarMensaje("Adelanto Agregado Exitosamente", "success")
                                },
                                error: function(xhr, status, error) {
                                    console.log('Error al actualizar los datos:', error);
                                }
                            });
                        });
                        /* EDITAR FIN */
        
                        /* MODAL PAGAR CONSUMO INICIO */
                        $('#table-consumos-reserva').off('click').on('click', '#btn-pagar-consumo-reserva-ocupado', function() {
                            const consumoID = $(this).data('id'); 
                            $('#btn-confirmar-modal-consumo-reserva-salon-ocupado').data('id', consumoID);
                        
                            $('#btn-confirmar-modal-consumo-reserva-salon-ocupado').off('click').on('click', function(event) {
                                event.preventDefault();
                                
                                const ModalConsumoTipoPagoSelect = $('#ModalConsumoTipoPagoSelect-ocupado').val();
                                const consumoID = $(this).data('id');
                                
                                const dataToSend = {
                                    ModalConsumoTipoPagoSelect: ModalConsumoTipoPagoSelect,
                                    id: consumoID,
                                };
                            
                                $.ajax({
                                    url: '/apihostal/cerrar-consumo-reserva-salon-postenvio',
                                    method: 'POST',
                                    data: dataToSend,
                                    success: function(response) {
                                        OcupadoReservaSalon(id)
                                        MostrarMensaje("Consumo Pagado Exitosamente", "success");
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.error('Error al recuperar:', textStatus, errorThrown);
                                    }
                                });
                            });
                        });
                        /* MODAL PAGAR CONSUMO FIN */
        
                        $('#btn-registrar-prestamos-data').off('click').on('click', function(event) {            
                            event.preventDefault();
                            var data = {
                                id: idrecuperado,
                                ServicioAlquilerSalon: $('#ServicioAlquilerSalon').val(),
                                CantidadAlquilerSalon: $('#CantidadAlquilerSalon').val(),
                                PrecioAlquilerSalon: $('#PrecioAlquilerSalon').val(),
                                TotalAlquilerSalon: $('#TotalAlquilerSalon').val(),
                                ComentarioAlquilerSalon: $('#ComentarioAlquilerSalon').val(),
                            };
                        
                            $.ajax({
                                url: '/apihostal/registrar-servicio-data-salon',
                                method: 'POST',
                                data: data,
                                success: function(response) {
                                    OcupadoReservaSalon(id)
                                    MostrarMensaje("Servicio Registrado Exitosamente", "success")
                                },
                                error: function() {
                                    alert("Error al registrar el cliente.");
                                }
                            });
                        });
        

                        $(document).off('click').on('click', '#btn-dar-baja-reserva-salon', function(event) {
                            event.preventDefault();
                            $('#modal-dar-baja-reserva-salon-ocupado').modal('show');

                            const total = $(this).data('total');
                            const idReserva = $(this).data('id');

                            $('#MontoAdelanto-salon-dar-baja').val(total);

                            const formContainer = document.getElementById('form-container');
                            const addFormButton = document.getElementById('add-form');
                            const registerButton = document.getElementById('btn-registrar-modal-dar-baja-reserva-salon-ocupado');

                            function createNewForm() {
                                const newForm = document.createElement('div');
                                newForm.classList.add('row', 'additional-form');

                                newForm.innerHTML = `
                                    <div class="col-12 col-sm-5">
                                        <div class="mb-3">
                                            <label class="form-label">Tipo De Pago</label>
                                            <select class="form-control">
                                                <option value="Efectivo">Efectivo</option>
                                                <option value="Tarjeta">Tarjeta</option>
                                                <option value="Deposito/QR">Deposito/QR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-5">
                                        <div class="mb-3">
                                            <label class="form-label">Monto</label>
                                            <input class="form-control payment-input" value="0.00" type="number">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label class="form-label"><br></label>
                                        <button type="button" class="btn btn-danger remove-form" style="width: 70%">X</button>
                                    </div>
                                `;

                                newForm.querySelector('.remove-form').addEventListener('click', function() {
                                    formContainer.removeChild(newForm);
                                    updateTotal();
                                });

                                newForm.querySelector('.payment-input').addEventListener('input', updateTotal);

                                return newForm;
                            }

                            function updateTotal() {
                                let totalSum = parseFloat($('#MontoAdelanto-salon-dar-baja').val()) || 0;
                                let restante
                                const paymentInputs = document.querySelectorAll('.payment-input');
                                paymentInputs.forEach(input => {
                                    const value = parseFloat(input.value) || 0;
                                    totalSum += value;
                                    restante = totalSum - total
                                });

                                if (totalSum >= total) {
                                    registerButton.disabled = false;
                                } else {
                                    registerButton.disabled = true;
                                }

                                $('#idtextcambio').text(restante);
                            }

                            addFormButton.addEventListener('click', function() {
                                const newForm = createNewForm();
                                formContainer.appendChild(newForm);
                                updateTotal();
                            });

                            updateTotal();


                            $('#btn-registrar-modal-dar-baja-reserva-salon-ocupado').off('click').on('click', function() {
                                const total = $('#MontoAdelanto-salon-dar-baja').val();
                                const formsData = [];
                            
                                formsData.push({
                                    tipoPago: $('#TipoAdelanto-salon-dar-baja').val(),
                                    monto: total
                                });
                            
                                const additionalForms = document.querySelectorAll('.additional-form');
                                additionalForms.forEach(function(form) {
                                    const tipoPago = form.querySelector('select').value;
                                    const monto = form.querySelector('.payment-input').value;
                                    formsData.push({
                                        tipoPago: tipoPago,
                                        monto: monto
                                    });
                                });
                                                        
                                $.ajax({
                                    url: '/apihostal/dar-baja-reserva-salon',
                                    method: 'POST',
                                    data: {
                                        id: idReserva, 
                                        pagos: formsData 
                                    },
                                    success: function(response) {
                                        $('#modal-dar-baja-reserva-salon-ocupado').modal('hide');
                                        MostrarAmbientes();
                                        filtrarDatosReserva();
                                        CanvasTime();
                                        MostrarMensaje("Salon Dado De Baja Exitosamente", "success");
                                    },
                                    error: function(xhr, status, error) {
                                        MostrarMensaje("Noce Pudo Registrar", "error");
                                    }
                                });
                            });                                                       
        
                        });

        
                        $('#Editar-reserva').off('click').on('click', function(event) {
                            event.preventDefault();
                            $('#edit-div').empty();
                            
                            var formularioHtml = `
                                <div class="col-12 col-md-12">
                                    <div class="mb-12 row" style="padding: 10px">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Check-in</label>
                                        <div class="col">
                                            <input type="date" class="form-control" value="${data[0].ingreso_reserva}" id="EditFechaIngreso">
                                        </div>
                                    </div>
                                    <div class="mb-12 row" style="padding: 10px">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Check-out</label>
                                        <div class="col">
                                            <input type="date" class="form-control" value="${data[0].salida_reserva}" id="EditFechaSalida">
                                        </div>
                                    </div>
                                    <div class="mb-12 row" style="padding: 10px">
                                        <label class="col-4 col-form-label" style="font-weight: bold">Asignar Habitacion</label>
                                        <div class="col">
                                            <select class="form-control" id="SelectHabitacionesUpdate"> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-12 row">
                                    <div class="card-footer text-end">
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-link" id="btn-cancelar-edit">Cancel</a>
                                                <button type="submit" class="btn btn-primary ms-auto" id="btn-actualizar-edit">Actualizar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            $('#edit-div').append(formularioHtml);
                            
                            var habitacionSeleccionada = `${data[0].hospedajehabitacion.habitacion_id}`;
                            TraerHabitacionesUpdate(habitacionSeleccionada);
        
                            $('#btn-actualizar-edit').off('click').on('click', function(event) {
                                event.preventDefault();
                                const EditFechaIngreso = $('#EditFechaIngreso').val();
                                const EditFechaSalida = $('#EditFechaSalida').val();
                                const IdReserva = data[0].id
                                const SelectHabitacionesUpdate = $('#SelectHabitacionesUpdate').val();
        
                                const dataToSend = {
                                    EditFechaIngreso: EditFechaIngreso,
                                    EditFechaSalida: EditFechaSalida,
                                    SelectHabitacionesUpdate: SelectHabitacionesUpdate,
                                    IdReserva: IdReserva
                                };
                            
                                $.ajax({
                                    url: '/apihostal/actualizar-reserva-habitacion',
                                    method: 'POST',
                                    data: dataToSend,
                                    success: function(data) {
                                        filtrarDatosReserva();
                                        InformacionReservaSalon(data)
                                        MostrarMensaje("Actualizado Exitosamente", "success");
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {                        
                                        MostrarMensaje("No se registró la reserva", "error");
                                    }
                                });
                            });
                        });
        
                        $(document).on('click', '#btn-registrar-adelanto-salon-ocupado', function(event) {
                            event.preventDefault();
                            $('#modal-adelanto-reserva-salon-ocupado').modal('show');
                                    
                            $('#btn-registrar-modal-adelanto-reserva-salon-ocupado').off('click').on('click', function(event) {
                                event.preventDefault();
                                var dataToSend = {
                                    idreservaSalon: data[0].id,
                                    TipoAdelanto: $('#TipoAdelanto-salon-ocupado').val(),
                                    MontoAdelanto: $('#MontoAdelanto-salon-ocupado').val(),
                                };
                                
                                $.ajax({
                                    url: '/apihostal/registrar-adelanto-salon',
                                    method: 'POST',
                                    data: dataToSend,
                                    success: function(response) {
                                        const reservaData = response;
                                        filtrarDatosReserva()
                                        InformacionReservaSalon(reservaData)
                                        MostrarMensaje("Adelanto Agregado Exitosamente", "success")
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.error('Error al recuperar:', textStatus, errorThrown);
                                    }
                                });
                            });
        
                        });
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de la reserva:', error);
                    }
                });
        
                function ListarConsumoSalon(data){
                    $('#div-consumos-hmtl-salon').empty();
                    var IdReservaSalon = data[0].id
                
                    var ConsumoForm = `
                        <div class="card-body" style="padding: 0px; margin: 0px;">
                            <div class="col-md-12" style="padding: 0px; margin: 0px;">
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary" id="btn-agregar-consumo">+ Agregar Nuevo Consumo</button>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="ListConsumosReservaSalon">
                                    
                                    </div>
                                    <br><br>
                                    <div class="row" id="SelectConsumosHospedaje">
                                    
                                    </div>
                                </div>
                            </div>
                        </div>                   
                    `;
                    $('#div-consumos-hmtl-salon').append(ConsumoForm);
                
                    $('#btn-agregar-consumo').off('click').on('click', function(event) {
                        event.preventDefault();
                        const dataToSend = {
                            IdReservaSalon: IdReservaSalon
                        };
                
                        $.ajax({
                            url: '/apihostal/registrar-consumo-reserva-salon',
                            method: 'POST',
                            data: dataToSend,
                            success: function(response) {
                                TablaListConsumosSalon(IdReservaSalon)
                                MostrarMensaje("Habitacion Actualizado Exitosamente", "success")
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('Error al recuperar:', textStatus, errorThrown);
                            }
                        });
                    });
                
                    TablaListConsumosSalon(IdReservaSalon)
                
                }
                
                function TablaListConsumosSalon(IdReservaSalon) {
                    $.ajax({
                        url: '/apihostal/get-consumo-reserva-salon/' + IdReservaSalon,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            var consumos = response.servicioconsumos;
                            var html = '';
                            $('#ListConsumosReservaSalon').empty();
                
                            consumos.forEach(function(servicio) {
                                servicio.consumo.forEach(function(consumo) {
                                    var botonEliminar = '';
                                    if (consumo.detalleconsumos.length === 0) {
                                        botonEliminar = `
                                            <a href="#" class="btn-action eliminar-consumo-cero" data-id="${consumo.id}">
                                                <svg fill="#ff0000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 72 72" enable-background="new 0 0 72 72" xml:space="preserve" stroke="#ff0000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M53.678,61.824c-2.27,0-4.404-0.885-6.01-2.49L36,47.667L24.332,59.334c-1.604,1.605-3.739,2.49-6.01,2.49 s-4.404-0.885-6.01-2.49c-1.605-1.604-2.49-3.739-2.49-6.01c0-2.271,0.885-4.405,2.491-6.011l11.666-11.667l-10.96-10.961 c-1.605-1.604-2.49-3.739-2.49-6.01s0.885-4.405,2.49-6.01c1.605-1.605,3.739-2.49,6.011-2.49c2.271,0,4.405,0.885,6.01,2.49 L36,23.626l10.96-10.96c1.605-1.605,3.738-2.49,6.01-2.49s4.406,0.885,6.01,2.49c1.605,1.604,2.49,3.739,2.49,6.01 s-0.885,4.405-2.49,6.01L48.021,35.646l11.666,11.668c1.605,1.604,2.49,3.738,2.49,6.01c0,2.271-0.885,4.405-2.49,6.01 C58.084,60.939,55.949,61.824,53.678,61.824z M36,42.839c0.511,0,1.023,0.195,1.414,0.586l13.082,13.081 c0.852,0.851,1.98,1.318,3.182,1.318c1.203,0,2.332-0.468,3.182-1.318c0.852-0.851,1.318-1.98,1.318-3.182 c0-1.202-0.467-2.332-1.318-3.181l-13.08-13.083c-0.781-0.781-0.781-2.047,0-2.828l12.373-12.375 c0.852-0.851,1.318-1.979,1.318-3.182s-0.467-2.331-1.318-3.182c-0.85-0.851-1.98-1.318-3.182-1.318s-2.332,0.468-3.18,1.318 L37.414,27.868c-0.781,0.781-2.046,0.781-2.828,0L22.21,15.494c-0.85-0.851-1.979-1.318-3.181-1.318 c-1.202,0-2.332,0.468-3.182,1.318c-0.851,0.851-1.319,1.979-1.319,3.182s0.469,2.331,1.318,3.182l12.374,12.375 c0.781,0.781,0.781,2.047,0,2.828L15.14,50.143c-0.85,0.85-1.318,1.979-1.318,3.182c0,1.201,0.469,2.331,1.318,3.182 c0.851,0.851,1.98,1.318,3.182,1.318c1.202,0,2.332-0.468,3.182-1.318l13.083-13.081C34.977,43.034,35.489,42.839,36,42.839z"></path> </g> </g></svg>
                                            </a>
                                        `;
                                    }
                            
                                    var ConsumoForm = `
                                        <div class="col-12 col-sm-4" style="padding: 8px">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Consumo #${consumo.id}</h3>
                                                    <div class="card-actions btn-actions">
                                                        ${botonEliminar}
                                                    </div>
                                                </div>
                                                <div class="card-status-start bg-primary"></div>
                                                <div class="card-body">
                                                    <p>Fecha de Venta: ${consumo.fecha_venta}</p>
                                                    <p>Total: ${consumo.total}</p>
                                                    <button class="badge bg-blue-lt btn-mostrar-consumo-reserva-salon" data-id="${consumo.id}">Mostrar ID Consumo</button>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                            
                                    $('#ListConsumosReservaSalon').append(ConsumoForm);
                                });
                            });
                
                            $('#ListConsumosReservaSalon').off('click', '.btn-mostrar-consumo-reserva-salon').on('click', '.btn-mostrar-consumo-reserva-salon', function() {
                                var consumoId = $(this).data('id');
                                ConsumoReservaSalon(consumoId);
                            });
                
                            $('#ListConsumosReservaSalon').off('click', '.eliminar-consumo-cero').on('click', '.eliminar-consumo-cero', function(event) {
                                event.preventDefault();
                                var consumoId = $(this).data('id');
                                $.ajax({
                                    url: '/apihostal/consumo-hospedaje-delete/' + consumoId,
                                    type: 'DELETE',
                                    success: function(result) {
                                        MostrarMensaje("Eliminado Exitosamente", "success");
                                        TablaListConsumosSalon(IdReservaSalon);
                                    },
                                    error: function(xhr) {
                                        MostrarMensaje("Error al eliminar", "error");
                                    }
                                });
                            });
                        },
                        error: function(error) {
                            console.error('Error al obtener productos:', error);
                        }
                    });
                }
                
                function ConsumoReservaSalon(consumoId) {
                    $.ajax({
                        url: '/apihostal/get-consumo-select-private/' + consumoId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if(response.ocupado != "true"){
                                $('#SelectConsumosHospedaje').empty();
                                var ConsumoForm = `
                                    <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                        <div class="card-body" style="padding: 0px; margin: 0px;">
                                            <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                <h3 class="card-title" style="color: black; margin: 0">VENTA</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12">
                                                    <div class="mb-12 row">
                                                        <label class="col-4 col-form-label" style="font-weight: bold">Hora Inicio</label>
                                                        <div class="col">
                                                            <label class="col-8 col-form-label" style="color: #61677A">${response.fecha_venta}</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-12 row">
                                                        <label class="col-4 col-form-label" style="font-weight: bold">Consumo</label>
                                                        <div class="col">
                                                            <label class="col-8 col-form-label" style="color: #61677A">${response.TipoConsumo} </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                                <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                                    ${response.detalleconsumos.map((detalle, index) => `
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
                                                            <h3 class="card-title" style="color: white">${response.subTotal}</h3>
                                                        </div>
                                                    </div>
                
                                                    ${response.descuentoconsumos.length > 0 ? ` 
                                                        <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                            <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                        </div>
                                                        ${response.descuentoconsumos.map((descuento, index) => `
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
                                                            <h3 class="card-title" style="color: white">${response.total}</h3>
                                                        </div>
                                                    </div>
                
                
                                                    ${response.pagosconsumos.length > 0 ? ` 
                                                        <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                            <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                        </div>
                                                        ${response.pagosconsumos.map((pago, index) => `
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
                                `;
                                $('#SelectConsumosHospedaje').append(ConsumoForm);
                            }else{
                                $('#SelectConsumosHospedaje').empty();
                                var ConsumoForm = `
                                    <div class="card-body" style="padding: 0px; margin: 0px;">
                                        <div class="col-md-12" style="padding: 0px; margin: 0px;">
                                            <form class="card">
                                                <div class="card-body">
                                                <div class="mb-3 row">
                                                    <div class="mb-3">
                                                        <label class="form-label">ADICIONAR</label>
                                                        <div class="row g-2">
                                                            <div class="col-auto">
                                                            <a href="#" class="btn btn-icon" aria-label="Button">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                                            </a>
                                                            </div>
                                                            <div class="col">
                                                            <input type="text" class="form-control" id="BuscarProducto" placeholder="Buscar Producto">
                                                            </div>                                                        
                                                        </div>
                                                    </div>
                                                    <div class="contenedor" id="DivFavorite" style="width: 100%; margin: 0px; padding: 0px;">
                                                        
                                                    </div>
                                                </div>
                                                <div>
                                                    <div id="DivAddProduct">
                                                        
                                                    </div>
                                                    <button id="btnGuardar" class="btn btn-primary" style="display: none">Guardar</button>
                                                </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <div class="mb-3" id="DivPedidos">
                                                        
                                                    </div>
                                                    
                                                    <div id="DivSubTotal" style="text-align: center">
                        
                                                    </div>
                                                    <div id="DivSubTotalList">
                                                        
                                                    </div>
                                                    <div id="DivDescuento">
                                                        
                                                    </div>
                                                    <div id="DivTotal" style="text-align: center">
                                                        <h1>Cargando ...</h1>
                                                    </div>  
                                                </div>
                                                <div class="card-footer text-end">
                                                    <div class="mb-3" id="DivBotonesFooter" style="padding: 0px;">
                                                        
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>                   
                                `;
                                $('#SelectConsumosHospedaje').append(ConsumoForm);
                        
                                var productosSeleccionados = [];
                        
                                $.ajax({
                                    url: '/api/get-productos',
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function (productos) {
                                        var DivPedidos = document.getElementById('DivPedidos');
                                        DivPedidos.innerHTML = '';
                                        agregarDetallesConsumo(consumoId);
                                        DivTotalConsumo(consumoId);
                        
                                        $.ajax({
                                            url: '/api/get-productos-favorite',
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#DivFavorite').empty();
                                                var productos = Object.values(response);
                                                productos.forEach(function(producto) {
                                                    var elementoHtml = `
                                                        <div class="elemento" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            <p style="display: flex; justify-content: space-between;">
                                                                <span style="color: black; font-weight: bold;">${producto.PrecioProducto} Bs.</span>
                                                                <span style="font-weight: bold; color: blue">${producto.stockdates[0]?.Cantidad || ''}</span>
                                                            </p>
                                                            <p style="display: inline; color: #3C4048;">${producto.NombreProducto}</p>
                                                        </div>
                                                    `;
                                                    $('#DivFavorite').append(elementoHtml);
                                                });
                        
                                                $('#DivFavorite').on('click', '.elemento', function() {
                                                    var nombreProducto = $(this).find('p:eq(1)').text().trim();
                                                    var productoSeleccionado = productos.find(producto => producto.NombreProducto === nombreProducto);
                                                    if (productoSeleccionado) {
                                                        productosSeleccionados.push({
                                                            Idproducto: productoSeleccionado.id,
                                                            NombreProducto: productoSeleccionado.NombreProducto,
                                                            Cantidad: 1,
                                                            PrecioProducto: productoSeleccionado.PrecioProducto,
                                                            modificador: productoSeleccionado.modificadore
                                                        });                                            
                                                        actualizarDivsProductos();
                                                    } else {
                                                        console.error('No se encontró el producto seleccionado:', nombreProducto);
                                                    }
                                                });
                        
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error al cargar los datos:', error);
                                            }
                                        });
                        
                                        
                                        $('#BuscarProducto').autocomplete({
                                            source: productos.map(producto => ({
                                                label: `${producto.CodigoProducto} - ${producto.NombreProducto}`,
                                                value: producto.NombreProducto,
                                                codigo: producto.CodigoProducto,
                                                modificador: producto.modificadore
                                            })),
                                            
                                            
                                            select: function (event, ui) {
                                                var productoSeleccionado = productos.find(producto => producto.NombreProducto === ui.item.value);
                                                // Agregar una nueva instancia del producto seleccionado
                                                productosSeleccionados.push({
                                                    Idproducto: productoSeleccionado.id,
                                                    NombreProducto: productoSeleccionado.NombreProducto,
                                                    Cantidad: 1,
                                                    PrecioProducto: productoSeleccionado.PrecioProducto,
                                                    modificador: productoSeleccionado.modificadore
                                                });
                                                actualizarDivsProductos();
                                                $(this).val('');
                                                return false;
                                            },
                                            
                                                                                
                                            
                                            close: function (event, ui) {
                                                $(this).val('');
                                            },
                                            open: function (event, ui) {
                                                $('.ui-menu-item').each(function () {
                                                    var text = $(this).text();
                                                    var codigo = text.split(' - ')[0];
                                                    var nombre = text.split(' - ')[1];
                                                    $(this).html(`<span class="autocomplete-bold">${codigo}</span> - ${nombre}`);
                                                });
                                            }
                                        });
                        
                                        
                        
                                        var btnGuardar = document.getElementById('btnGuardar');
                                            $('#btnGuardar').off('click').on('click', function (event) {
                                                $(this).prop('disabled', true);
                                                event.preventDefault();
                        
                                                var productosParaGuardar = recuperarDatosProductos();
                        
                                                $.ajax({
                                                    url: '/apihostal/registrar-detalle-consumo-reserva-salon',
                                                    type: 'POST',
                                                    contentType: 'application/json',
                                                    data: JSON.stringify(productosParaGuardar),
                                                    success: function (response) {      
                                                        OcupadoReservaSalon(id)
                                                        btnGuardar.style.display = 'none';
                                                        MostrarMensaje("Producto Agregado", "success");
                                                        DivPedidos.innerHTML = '';
                                                        AddProduct = document.getElementById('DivAddProduct');
                                                        AddProduct.innerHTML = '';
                                                        productosSeleccionados = [];
                                                        agregarDetallesConsumo(consumoId);
                                                        DivTotalConsumo(consumoId);
                                                    },
                                                    error: function (error) {
                                                        console.error('Error:', error);
                                                    },
                                                    complete: function () {
                                                        $('#btnGuardar').prop('disabled', false);
                                                    }
                                                });
                                            });
                        
                        
                                            function recuperarDatosProductos() {
                                                var productosRecuperados = [];
                        
                                                productosSeleccionados.forEach(function (producto, index) {
                                                    var productoRecuperado = {
                                                        consumoId: consumoId,
                                                        Idproducto: producto.Idproducto,
                                                        nombre: producto.NombreProducto,
                                                        cantidad: producto.Cantidad || 1,
                                                        precio: producto.PrecioProducto || 0,
                                                        comentario: producto.Comentario || '',
                                                        Modificadores: []
                                                    };
                                            
                                                    if (producto.modificador != null) {
                                                        producto.modificador.detallemodificador.forEach(function (detalle, indexDetalle) {
                                                            var DetalleID = detalle.id; // Usar detalle.id directamente si es único
                                                            var cantidadInputId = `DivModificadorCantidad${index}-${indexDetalle}`;
                                                            var costoInputId = `DivModificadorCosto${index}-${indexDetalle}`;
                                                            var checkboxId = `ModificadorCheck${index}-${indexDetalle}`;
                                            
                                                            var cantidad = document.getElementById(cantidadInputId).value;
                                                            var costo = document.getElementById(costoInputId).value;
                                                            var checkbox = document.getElementById(checkboxId);
                                                            var valorCheckbox = checkbox.checked;
                                            
                                                            var modificador = {
                                                                id: DetalleID,
                                                                NombreProducto: detalle.producto.NombreProducto,
                                                                CostoDetalleModificador: costo || 1,
                                                                Cantidad: cantidad || 1,
                                                                Checkbox: valorCheckbox
                                                            };
                                                            productoRecuperado.Modificadores.push(modificador);
                                                        });
                                                    }
                                            
                                                    productosRecuperados.push(productoRecuperado);
                                                });
                                            
                                                return productosRecuperados;
                                            }
                                            
                                            
                        
                                        function actualizarDivsProductos() {                                    
                                            var AddProduct = document.getElementById('DivAddProduct');
                                            AddProduct.innerHTML = ''; 
                        
                                            productosSeleccionados.forEach(function (producto, index) {
                                                var nuevoDiv = document.createElement('div');
                                                nuevoDiv.className = 'row producto-row';
                                                nuevoDiv.style = 'padding: 1px';
                        
                                                nuevoDiv.innerHTML = `
                                                <div style="background: #FFCC70; padding-top: 10px;">
                                                    <div data-index="${index}" style="display: flex; padding: 0px; margin: 0px;">
                                                        <div style="width: 25%;" id="divdate1">
                                                            <div class="input-group" style="width: 100%">
                                                                <button class="btn btn-outline-secondary btnDecrementar" type="button" style="width: 15px">-</button>
                                                                <input type="text" name="CantProduct" class="form-control CantProduct" value="${producto.Cantidad || 1}" style="padding: 0px; text-align: center;" id="divInput">
                                                                <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                                                            </div>
                                                        </div>
                                                        <div style="padding-left: 9px; padding-right: 9px; width: 35%;" id="divdate2">
                                                            <a style="font-weight: bold; font-size: 13px; word-wrap: break-word;">${producto.NombreProducto}</a>
                                                        </div>
                                                        <div style="width: 25%;" id="divdate3">
                                                            <input type="number" name="PrecioProduct" class="form-control PrecioProduct" value="${producto.PrecioProducto  || 1}" style="padding-right: 0px; padding-left: 0px; text-align: center; width: 55px">
                                                        </div>
                                                        <div style="text-align: center; width: 25%; padding: 0px; margin: 0px; id="divdate4">
                                                            <a class="mostrar-comentario">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" style="width: 36px; height: 36px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1" />
                                                                </svg>
                                                            </a>
                                                            <a class="borrar-div" data-index="${index}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" style="width: 36px; height: 36px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M18 6l-12 12" />
                                                                    <path d="M6 6l12 12" />
                                                                </svg>
                                                            </a>
                                                        </div>                                                
                                                    </div>
                                                    ${producto.modificador != null ? `
                                                        <div style="text-align: center; margin-left: 10%;" id="DivModificadores"><br>
                                                            <!-- Aquí listame todos los productos con modificadores -->
                                                        </div>
                                                    ` : ''}
                                                    <div style="text-align: center;"><br>
                                                        <input type="text" name="ComentarioProduct" class="form-control ComentarioProduct" style="display: none"><br id="saltoDiv" style="display: none" placeholder="Escriba El Comentario . . .">
                                                    </div>
                                                </div>
                                                `;
                        
                                                if (producto.modificador != null) {
                                                    var productosModificadoresDiv = nuevoDiv.querySelector('#DivModificadores');
                                                    producto.modificador.detallemodificador.forEach(function (detalle, indexDetalle) {
                                                        // Aquí usa indexDetalle en lugar de index
                                                        var productoModificador = detalle.producto;
                                                        var productoModificadorDiv = document.createElement('div');
                                                        productoModificadorDiv.innerHTML = `
                                                            <div class="card" style="margin: 0px; padding: 10px; border-left: 6px solid orange">
                                                                <div data-index="${index}-${indexDetalle}" style="display: flex; padding: 0px; margin: 0px;">
                                                                    <div style="width: 30%;" id="divdate1">
                                                                        <input type="text" id="IdDetalleModificador" class="form-control CantProduct" value="${detalle.id}" style="padding: 0px; text-align: center;" hidden>
                                                                        <div class="input-group" style="width: 100%">
                                                                            <button class="btn btn-outline-secondary btnDecrementar" type="button" style="width: 15px">-</button>
                                                                            <input type="text" name="CantProduct" class="form-control CantProduct" value="${productoModificador.Cantidad || 1}" style="padding: 0px; text-align: center;" id="DivModificadorCantidad${index}-${indexDetalle}">
                                                                            <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                                                                        </div>
                                                                    </div>
                                                                    <div style="padding-left: 9px; padding-right: 9px; width: 35%;" id="divdate2">
                                                                        <a style="font-weight: bold; font-size: 13px; word-wrap: break-word;">${productoModificador.NombreProducto}</a>
                                                                    </div>
                                                                    <div style="width: 20%;" id="divdate3">
                                                                        <input type="number" class="form-control PrecioProduct" value="${detalle.CostoDetalleModificador || 1}" style="padding-right: 0px; padding-left: 0px; text-align: center; width: 55px" id="DivModificadorCosto${index}-${indexDetalle}">
                                                                    </div>
                                                                    <div style="text-align: center; padding: 8px; margin: 0px;" id="divdate4">
                                                                        <input class="form-check" type="checkbox" style="width: 20px; height: 20px" id="ModificadorCheck${index}-${indexDetalle}" checked>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        `;
                                                        productosModificadoresDiv.appendChild(productoModificadorDiv);
                                                    });
                                                }
                        
                                                AddProduct.appendChild(nuevoDiv);
                        
                                                // Agregar controladores de eventos a los botones y elementos relevantes
                                                var btnDecrementar = nuevoDiv.querySelector('.btnDecrementar');
                                                var btnIncrementar = nuevoDiv.querySelector('.btnIncrementar');
                                                var borrarDiv = nuevoDiv.querySelector('.borrar-div');
                                                var cantProductInput = nuevoDiv.querySelector('.CantProduct');
                                                var precioProductInput = nuevoDiv.querySelector('.PrecioProduct');
                                                var comentarioProductInput = nuevoDiv.querySelector('.ComentarioProduct');
                                                var mostrarComentarioLink = nuevoDiv.querySelector('.mostrar-comentario');
                        
                                                // Agregar controladores de eventos
                                                btnDecrementar.addEventListener('click', function() {
                                                    // Manejar decremento
                                                    var cantidad = parseInt(cantProductInput.value, 10) || 0;
                                                    if (cantidad > 0) {
                                                        cantProductInput.value = cantidad - 1;
                                                        producto.Cantidad = cantidad - 1; // Actualizar valor en el producto
                                                    }
                                                });
                        
                                                btnIncrementar.addEventListener('click', function() {
                                                    // Manejar incremento
                                                    var cantidad = parseInt(cantProductInput.value, 10) || 0;
                                                    cantProductInput.value = cantidad + 1;
                                                    producto.Cantidad = cantidad + 1; // Actualizar valor en el producto
                                                });
                        
                                                borrarDiv.addEventListener('click', function() {
                                                    var index = borrarDiv.getAttribute('data-index');
                                                    productosSeleccionados.splice(index, 1);
                                                    actualizarDivsProductos();
                                                });
                        
                                                // Manejar cambios en la cantidad, precio y comentario
                                                cantProductInput.addEventListener('input', function() {
                                                    producto.Cantidad = cantProductInput.value;
                                                });
                        
                                                precioProductInput.addEventListener('input', function() {
                                                    producto.PrecioProducto = precioProductInput.value;
                                                });
                        
                                                comentarioProductInput.addEventListener('input', function() {
                                                    producto.Comentario = comentarioProductInput.value;
                                                });
                        
                                                // Agregar evento para mostrar/comentar
                                                mostrarComentarioLink.addEventListener('click', function() {
                                                    // Alternar la visibilidad del input de comentario
                                                    if (comentarioProductInput.style.display === 'none' || comentarioProductInput.style.display === '') {
                                                        comentarioProductInput.style.display = 'block';
                                                        saltoDiv.style.display = 'block';
                                                    } else {
                                                        comentarioProductInput.style.display = 'none';
                                                        saltoDiv.style.display = 'none';
                                                    }
                                                });
                        
                                            });
                        
                                            btnGuardar.style.display = productosSeleccionados.length >= 1 ? 'block' : 'none';
                        
                                        }
                        
                                        function DivTotalConsumo(consumoId) {
                        
                                            function DescuentoDiv() {
                                                var btn = document.getElementById('btnPorcentaje');
                                                var id = btn.getAttribute('data-id');
                                                // Haz lo que necesites con el id
                                                var DivDescuento = document.getElementById('DivDescuento');
                                                DivDescuento.innerHTML = 
                                                `<div class="d-flex" data-index="${id}" style="background: #DDE6ED; margin: 0px; padding: 10px; width: 100%; display: flex; height: 60px;">
                                                    <input type="number" value="${id}" id="IdDescuento" class="form-control" style="width: 100%" hidden>
                                                    <div class="mb-6 row" style="width: 200%;">
                                                        <label class="col-1 col-form-label" style="white-space: nowrap; width: auto">Descuento: </label>
                                                        <div class="col" style="display: flex; align-items: center;">
                                                            <input type="text" id="DescuentoPorcentaje" class="form-control" style="width: 80%">
                                                            <label class="col-form-label">%</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-6 row" style="width: 150%;">
                                                        <label class="col-3 col-form-label" style="width: auto">Bs: </label>
                                                        <div class="col">
                                                            <input type="text" id="DescuentoMonto" class="form-control" style="width: 60%">
                                                        </div>
                                                    </div>
                                                    <div class="mb-6 row" style="width: auto; padding: 7px">
                                                        <div class="d-flex">
                                                            <button type="button" class="badge bg-red-lt" id="btnDescuentoCancelar" style="height: 100%">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                                            </button>
                                                            <button type="button" class="badge bg-green-lt" id="btnDescuentoConfirmar" style="height: 100%">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                                            </button>
                                                        </div>                                            
                                                    </div>
                                                </div>
                                                `;
                        
                                                document.getElementById('btnDescuentoCancelar').addEventListener('click', function () {
                                                    DivDescuento.innerHTML = '';
                                                });
                        
                                                //para los inputs
                                                document.getElementById('DescuentoPorcentaje').addEventListener('input', function () {
                                                    var porcentaje = parseInt(this.value, 10) || 0;
                        
                                                    if (porcentaje < 1) {
                                                        porcentaje = '';
                                                    } else if (porcentaje > 100) {
                                                        porcentaje = 80;
                                                    }
                        
                                                    this.value = porcentaje;
                        
                                                    var montoInput = document.getElementById('DescuentoMonto');
                                                    montoInput.value = ''; // Limpiar el valor del monto
                                                    montoInput.disabled = true; // Desactivar el input de monto
                        
                                                    // Habilitar el input DescuentoMonto si DescuentoPorcentaje está vacío
                                                    if (!this.value.trim()) {
                                                        montoInput.disabled = false;
                                                    }
                                                });
                                                document.getElementById('DescuentoMonto').addEventListener('input', function () {
                                                    var monto = parseFloat(this.value) || 0;
                        
                                                    var porcentajeInput = document.getElementById('DescuentoPorcentaje');
                                                    porcentajeInput.value = ''; // Limpiar el valor del porcentaje
                                                    porcentajeInput.disabled = true; // Desactivar el input de porcentaje
                        
                                                    // Habilitar el input DescuentoPorcentaje si DescuentoMonto está vacío
                                                    if (!this.value.trim()) {
                                                        porcentajeInput.disabled = false;
                                                    }
                                                });
                        
                                                
                                                document.getElementById('btnDescuentoConfirmar').addEventListener('click', function () {
                        
                                                    $(this).prop('disabled', true);
                        
                                                    var idDescuento = document.getElementById('IdDescuento').value;
                                                    var descuentoPorcentaje = document.getElementById('DescuentoPorcentaje').value;
                                                    var descuentoMonto = document.getElementById('DescuentoMonto').value;
                                                    $.ajax({
                                                        url: '/api/registrar-descuento',
                                                        type: 'POST',
                                                        data: {
                                                            id: idDescuento,
                                                            porcentaje: descuentoPorcentaje,
                                                            monto: descuentoMonto
                                                        },
                                                        success: function (response) {
                                                            DivDescuento.innerHTML = '';
                                                            ListarDescuentos(id)
                                                            MostrarMensaje('Descuento Registrado Correctamente','success');
                                                            //actualiza total
                                                            $.ajax({
                                                                url: '/apihostal/get-consumo/' + consumoId,
                                                                type: 'GET',
                                                                dataType: 'json',
                                                                success: function (consumo) {
                                                                    var SubTotalProduct = document.getElementById('DivSubTotal');
                                                                    if (consumo.descuentoconsumos.length > 0) {
                                                                        SubTotalProduct.innerHTML = `
                                                                            <div class="d-flex" style="background: #243A73; padding: 20px;">
                                                                                <div class="flex-grow-1">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex-shrink-0 text-right">
                                                                                    <span style="font-size: 20px; color: white">${consumo.subTotal} Bs.</span>
                                                                                </div>
                                                                            </div>
                                                                        `;
                                                                    } else {
                                                                        SubTotalProduct.innerHTML = '';
                                                                    }
                                                                    var TotalProduct = document.getElementById('DivTotal');
                                                                    TotalProduct.innerHTML = `
                                                                        <div style="background: #243A73; padding: 20px; display: flex;">
                                                                            <div style="width: 50%;">
                                                                                <div class="input-group" style="width: 100%;">
                                                                                    <span style="font-size: 20px; color: white;">TOTAL</span>
                                                                                </div>
                                                                            </div>
                                                                            <div style="text-align: right; width: 50%;">
                                                                                <span style="font-size: 20px; color: white;">${consumo.total} Bs.</span>
                                                                            </div>
                                                                        </div>
                                                                    `;
                                                                },
                                                                error: function (error) {
                                                                    MostrarMensaje(error,'error');
                                                                }
                                                            });
                                                        },
                                                        error: function (error) {
                                                            MostrarMensaje(error,'error');
                                                        },
                                                        complete: function() {
                                                            $('#btnDescuentoConfirmar').prop('disabled', false);
                                                        }
                                                    });
                                                });                                        
                        
                                            }
                                            ///aqui total
                                            $.ajax({
                                                url: '/apihostal/get-consumo/' + consumoId,
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function (consumo) {
                                                    var SubTotalProduct = document.getElementById('DivSubTotal');
                                                    var IdConsumo = consumo.id;
                        
                                                    if (consumo.descuentoconsumos.length > 0) {
                                                        SubTotalProduct.innerHTML = `
                                                            <div class="d-flex" style="background: #243A73; padding: 20px;">
                                                                <div class="flex-grow-1">
                                                                    <div class="input-group" style="width: 100%">
                                                                        <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0 text-right">
                                                                    <span style="font-size: 20px; color: white">${consumo.subTotal} Bs.</span>
                                                                </div>
                                                            </div>
                                                        `;
                                                    } else {
                                                        SubTotalProduct.innerHTML = '';
                                                    }
                        
                                                    var TotalProduct = document.getElementById('DivTotal');
                                                    TotalProduct.innerHTML = `
                                                        <div style="background: #243A73; padding: 20px; display: flex;">
                                                            <div style="width: 50%;">
                                                                <div class="input-group" style="width: 100%;">
                                                                    <span style="font-size: 20px; color: white;">TOTAL</span>
                                                                </div>
                                                            </div>
                                                            <div style="text-align: right; width: 50%;">
                                                                <span style="font-size: 20px; color: white;">${consumo.total} Bs.</span>
                                                            </div>
                                                        </div>
                                                    `;
                                                    var DivBotones = document.getElementById('DivBotonesFooter');
                                                    DivBotones.innerHTML = `
                                                        <div class="col-md-6 col-lg-12 d-flex justify-content-between">
                                                            <button type="button" class="btn btn-primary" id="btnPorcentaje" data-id="${IdConsumo}" style="text-align: center; padding: 0px; margin: 0px; padding-left: 6px; padding-right: 6px" hidden>
                                                                <span style="font-size: 20px; font-weight: bold;">%</span>
                                                            </button>
                        
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#Modal-Cerrar-Consumo-Reserva-Salon-Ocupado" class="btn btn-danger" data-id="${IdConsumo}" id="btnCerrarConsumo">Cerrar Consumo</button>
                                                        </div>
                                                    `;
                        
                                                    // Vuelve a asignar el controlador de eventos al botón de porcentaje
                                                    document.getElementById('btnPorcentaje').onclick = DescuentoDiv;
                                                    document.getElementById('btnCerrarConsumo').onclick = guardarCambios;
                        
                                                    function guardarCambios() {
                                                        var btnCerrarConsumo = $('#btnCerrarConsumo');
                                                        $('#btn-confirmar-modal-consumo-reserva-salon').off('click').on('click', function(event) {
                                                            event.preventDefault();
                                                            const ModalConsumoTipoPagoSelect = $('#ModalConsumoTipoPagoSelect').val();
                                                            var id = btnCerrarConsumo.data('id');
                                                    
                                                            const dataToSend = {
                                                                ModalConsumoTipoPagoSelect: ModalConsumoTipoPagoSelect,
                                                                id: id,
                                                            };
                                                        
                                                            $.ajax({
                                                                url: '/apihostal/cerrar-consumo-reserva-salon-postenvio',
                                                                method: 'POST',
                                                                data: dataToSend,
                                                                success: function(response) {
                                                                    MostrarMensaje("Actualizado Exitosamente", "success")
                                                                },
                                                                error: function(jqXHR, textStatus, errorThrown) {
                                                                    console.error('Error al recuperar:', textStatus, errorThrown);
                                                                }
                                                            });
                                                        });
                                                    }
                                                },
                                                error: function (error) {
                                                    console.error('Error:', error);
                                                }
                                            });
                        
                                        }
                        
                        
                                        
                                        function agregarDetallesConsumo(consumoId) {
                                            $.ajax({
                                                url: '/apihostal/get-consumo/' + consumoId,
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function (data) {      
                                                    DivagregarDetallesConsumo(data.detalleconsumos, consumoId);
                                                    ListarDescuentos(data.id)
                                                    //DivTotalConsumo(mesaId);
                                                },
                                                error: function (error) {
                                                    console.error('Error:', error);
                                                }
                                            });
                                        }
                        
                                        var DivPedidos = document.getElementById('DivPedidos');
                        
                                        function DivagregarDetallesConsumo(detalleconsumos, consumoId) {
                                        $.ajax({
                                            url: '/apihostal/get-consumo/' + consumoId,
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function (consumo) {
                                            DivPedidos.innerHTML = '';
                                            detalleconsumos.forEach(function (detalle, index) {
                                                var nuevoDiv = document.createElement('div');
                                                nuevoDiv.className = 'row producto-row';
                                                        if(detalle.eliminado == 'true'){
                                                            nuevoDiv.innerHTML = `
                                                                <div class="col-md-12 col-lg-12" style="width: 100%; padding: 0px; margin: 0px;">
                                                                    <div class="card" id="CardOcupado" style="width: 100%; padding: 0px; margin: 0px;">
                                                                        <div class="card-status-start bg-primary"></div>
                                                                        <div class="card-header" style="padding: 0px; margin: 0px; height: auto;">
                                                                            <div style="width: 100%; padding-top: 10px; margin: 0px; display: flex; height: auto;">
                                                                                <div class="col-md-12 col-lg-2" style="width: auto;">
                                                                                    <h3 class="card-title">${detalle.cantidad}</h3>
                                                                                </div>
                                                                                <div class="col-md-12 col-lg-7" style="text-align: left; width: 100%;">
                                                                                    <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                                    <p style="font-size: 12px">CANCELADO: ${detalle.comentarioeliminado}</p>
                                                                                </div>
                                                                                <div class="col-md-12 col-lg-3" style="width: 50%;">
                                                                                    <h3 class="card-title">${detalle.total}</h3>                                                                    
                                                                                </div>
                                                                                <div class="col-md-12 col-lg-1"  style="width: auto; text-aling: right;">
                                                                                    <a class="nav-link">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                                            <path d="M18 6l-12 12" />
                                                                                            <path d="M6 6l12 12" />
                                                                                        </svg>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            `;
                                                        }else{
                                                            if (detalle.modificadordetalleconsumo.length === 0) {                                                    
                                                                // Si está vacío, muestra el HTML correspondiente
                                                                nuevoDiv.innerHTML = `
                                                                    <div class="col-md-12 col-lg-12" style="width: 100%; padding: 0px; margin: 0px;">
                                                                        <div class="card" style="width: 100%; padding: 0px; margin: 0px;">
                                                                            <div class="card-status-start bg-primary"></div>
                                                                            <div class="card-header" style="padding: 0px; margin: 0px; height: auto;">
                                                                                <div style="width: 100%; padding-top: 10px; margin: 0px; display: flex; height: auto;">
                                                                                    <div class="col-md-12 col-lg-2" style="width: auto;">
                                                                                        <h3 class="card-title">${detalle.cantidad}</h3>
                                                                                    </div>
                                                                                    <div class="col-md-12 col-lg-7" style="text-align: left; width: 100%;">
                                                                                        <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                                        <p style="font-size: 12px">${detalle.comentario}</p>
                                                                                    </div>
                                                                                    <div class="col-md-12 col-lg-3" style="width: 50%;">
                                                                                        <h3 class="card-title">${detalle.total}</h3>                                                                    
                                                                                    </div>
                                                                                    <div class="col-md-12 col-lg-1"  style="width: auto; text-aling: right;">
                                                                                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#ElminarDetalle" data-index="${index}">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                                                <path d="M18 6l-12 12" />
                                                                                                <path d="M6 6l12 12" />
                                                                                            </svg>
                                                                                        </a>
                                                                                    </div>                                                                    
                                                                                </div>
                                                                            </div>    
                                                                            <div>                                                               
                                                                            </div>                                                        
                                                                        </div>
                                                                    </div>
                                                                `;
                                                            } else {                                                    
                                                                // Si no está vacío, muestra el HTML correspondiente
                                                                IdMod = detalle.producto.modificadore_id
                                                                nuevoDiv.innerHTML = `
                                                                    <div class="col-md-12 col-lg-12" style="width: 100%; padding: 0px; margin: 0px;">
                                                                        <div class="card" style="width: 100%; padding: 0px; margin: 0px;">
                                                                            <div class="card-status-start bg-primary"></div>
                                                                            <div class="card-header" style="padding: 0px; margin: 0px; height: auto; border-bottom: 0px solid black">
                                                                                <div style="width: 100%; padding-top: 10px; margin: 0px; display: flex; height: auto;">
                                                                                    <div class="col-md-12 col-lg-2" style="width: auto;">
                                                                                        <h3 class="card-title">${detalle.cantidad}</h3>
                                                                                    </div>
                                                                                    <div class="col-md-12 col-lg-7" style="text-align: left; width: 100%;">
                                                                                        <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                                        <p style="font-size: 12px;">
                                                                                            ${detalle.comentario} 
                                                                                            <a id="AddModificador" style="color: blue" data-bs-toggle="modal" data-bs-target="#ModalAddModificador" data-IdModificador="${IdMod}" data-IdDetalle="${detalle.id}">Add</a>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-md-12 col-lg-3" style="width: 50%;">
                                                                                        <h3 class="card-title">${detalle.total}</h3>                                                                    
                                                                                    </div>
                                                                                    <div class="col-md-12 col-lg-1"  style="width: auto; text-aling: right;">
                                                                                        <a class="nav-link" data-bs-toggle="modal" data-bs-target="#ElminarDetalle" data-index="${index}">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                                                <path d="M18 6l-12 12" />
                                                                                                <path d="M6 6l12 12" />
                                                                                            </svg>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div style="margin-top: -30px; padding: 10px;">
                                                                                ${detalle.modificadordetalleconsumo.map(modificador => `
                                                                                    <div class="card-header" style="padding: 0px; margin: 0px; height: auto; border-bottom: 0px solid red;">
                                                                                        <div style="width: 100%; padding-top: 10px; margin: 0px; display: flex; height: auto;">
                                                                                            <div class="col-md-12 col-lg-2" style="width: 100%;">
                                                                                                <h3 class="card-title" id="Cantidad${modificador.id}">${modificador.cantidad}</h3>
                                                                                            </div>
                                                                                            <div class="col-md-12 col-lg-5" style="text-align: left; width: 100%;">
                                                                                                <p class="card-title">${modificador.detallemodificador.producto.NombreProducto} - ${modificador.precio}</p>
                                                                                                
                                                                                            </div>
                                                                                            <div class="col-md-12 col-lg-3" style="width: 100%;">
                                                                                                <h3 class="card-title">${modificador.total}</h3>                                                                    
                                                                                            </div>
                                                                                            <div class="col-md-12 col-lg-1" style="margin: 0px; padding: 0px">
                                                                                                <span class="badge badge-outline text-green" data-bs-toggle="modal" data-bs-target="#ModalEditarModificador" data-IdEditModif="${modificador.id}" style="padding: 0px; padding-top: 5px; height: 21px; width: 100%;">E</span>
                                                                                            </div>
                                                                                            <div class="col-md-12 col-lg-1" style="margin: 0px; padding: 0px">
                                                                                                <span class="badge badge-outline text-red" data-bs-toggle="modal" data-bs-target="#ModalEliminarModificador" data-IdEliminarModif="${modificador.id}" style="padding: 0px; padding-top: 5px; height: 21px; width: 100%;">X</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                `).join('')}
                                                                            </div>                                                        
                                                                        </div>
                                                                    </div>
                                                                `;
                                                            }
                                                            detalle.modificadordetalleconsumo.forEach(modificador => {
                                                                var editButton = nuevoDiv.querySelector(`[data-IdEditModif="${modificador.id}"]`);
                                                                if (editButton) {
                                                                    editButton.addEventListener('click', function() {
                                                                        var modalBody = document.querySelector('#ModalEditarModificador .modal-body');
                                                                        modalBody.innerHTML = '';
                                                                
                                                                        var cantidad = modificador.cantidad;
                                                                        var precio = modificador.precio;
                                                                
                                                                        function calcularTotal() {
                                                                            var cantidadInput = document.getElementById('EditCantidad');
                                                                            var totalInput = document.getElementById('EditTotal');
                                                                            var nuevaCantidad = parseInt(cantidadInput.value);
                                                                            var nuevoTotal = nuevaCantidad * precio;
                                                                            totalInput.value = nuevoTotal;
                                                                        }
                                                                
                                                                        var productoHtml = `
                                                                            <div class="row row-cards">
                                                                                <div class="col-sm-6 col-md-3">
                                                                                    <input type="text" class="form-control" id="EditId" value="${modificador.id}" hidden>
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Nombre Producto</label>
                                                                                        <input type="text" class="form-control" value="${modificador.detallemodificador.producto.NombreProducto}" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6 col-md-3">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Precio</label>
                                                                                        <input type="text" class="form-control" id="EditPrecio" value="${precio}" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6 col-md-3">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Cantidad</label>
                                                                                        <input type="text" class="form-control" id="EditCantidad" value="${cantidad}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6 col-md-2">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Total</label>
                                                                                        <input type="text" class="form-control" id="EditTotal" value="${cantidad * precio}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        `;
                                                                        modalBody.insertAdjacentHTML('beforeend', productoHtml);
                                                                        calcularTotal();
                                                                        var cantidadInput = document.getElementById('EditCantidad');
                                                                        cantidadInput.addEventListener('input', calcularTotal);
                                                                
                                                                    });
                                                                }
                                                            });
                        
                                                            detalle.modificadordetalleconsumo.forEach(modificador => {
                                                                var eliminarButton = nuevoDiv.querySelector(`[data-IdEliminarModif="${modificador.id}"]`);
                                                                if (eliminarButton) {
                                                                    eliminarButton.addEventListener('click', function() {
                                                                        var modalBody = document.querySelector('#ModalEliminarModificador .modal-body');
                                                                        modalBody.innerHTML = '';
                                                                
                                                                        var productoHtml = `
                                                                            <div class="row row-cards">
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <input type="text" class="form-control" id="EliminarId" value="${modificador.id}" hidden>
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">ESTAS SEGURO QUE DESEAS ELIMINAR?</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        `;
                                                                        modalBody.insertAdjacentHTML('beforeend', productoHtml);
                                                                    });
                                                                }
                                                            });
                                                        }
                                                        DivPedidos.appendChild(nuevoDiv);     
                                                        
                                                        var addButton = nuevoDiv.querySelector('#AddModificador');
                                                        if (addButton) {
                                                            addButton.addEventListener('click', function() {
                                                                var idModificador = addButton.getAttribute('data-IdModificador');
                                                                var IdDetalle = addButton.getAttribute('data-IdDetalle');
                                                                $.ajax({
                                                                    url: '/api/get-modificador-seleccionado/'+idModificador,
                                                                    type: 'GET',
                                                                    dataType: 'json',
                                                                    success: function(data) {
                                                                        var modalBody = document.querySelector('#ModalAddModificador .modal-body');
                                                                        modalBody.innerHTML = '';
                                                                        data.detallemodificador.forEach(function (detalle) {
                                                                            var productoHtml = `
                                                                                <div class="row row-cards" id="productoDiv" style="padding: 20px; margin: 2px">
                                                                                    <div class="col-sm-6 col-md-1">
                                                                                        <input type="text" class="form-control" id="MIdproducto_${detalle.id}" value="${detalle.producto.id}" hidden>
                                                                                        <input type="text" class="form-control" id="MIdDetalle_${detalle.id}" value="${detalle.id}" hidden>
                                                                                        <div class="mb-3">
                                                                                            <label class="form-check" style="padding: 15px; margin: 20px">
                                                                                                <input class="form-check-input" type="checkbox" id="ChexInput_${detalle.id}" style="border: 4px solid black; width: 20px; height: 20px">
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">Nombre Producto</label>
                                                                                            <input type="text" class="form-control" value="${detalle.producto.NombreProducto}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">Precio</label>
                                                                                            <input type="text" class="form-control" id="MPrecio_${detalle.id}" value="${detalle.CostoDetalleModificador}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-2">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">Cantidad</label>
                                                                                            <input type="text" class="form-control" id="MCantidad_${detalle.id}" value="1">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-6 col-md-3">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">Total</label>
                                                                                            <input type="text" id="MTotal_${detalle.id}" class="form-control" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            `;
                                                                            modalBody.insertAdjacentHTML('beforeend', productoHtml);
                                                                        
                                                                            var checkboxId = `ChexInput_${detalle.id}`;
                                                                            var cantidadId = `MCantidad_${detalle.id}`;
                                                                            var precioId = `MPrecio_${detalle.id}`;
                                                                            var totalId = `MTotal_${detalle.id}`;
                        
                                                                            var cantidadInput = document.getElementById(cantidadId);
                                                                            var precioInput = document.getElementById(precioId);
                                                                            var totalInput = document.getElementById(totalId);
                        
                                                                            function calcularTotal() {
                                                                                var cantidad = parseInt(cantidadInput.value);
                                                                                var precio = parseFloat(precioInput.value);
                                                                                var total = cantidad * precio;
                                                                                totalInput.value = total.toFixed(2);
                                                                            }
                        
                                                                            calcularTotal();
                        
                                                                            cantidadInput.addEventListener('input', calcularTotal);
                                                                            precioInput.addEventListener('input', calcularTotal);
                                                                            
                        
                                                                            var checkboxId = `ChexInput_${detalle.id}`;
                                                                            document.getElementById(checkboxId).addEventListener('change', function() {
                                                                                var productoDiv = this.closest('.row-cards');
                                                                                if (this.checked) {
                                                                                    productoDiv.style.backgroundColor = '';
                                                                                    productoDiv.style.opacity = '1';
                                                                                    productoDiv.style.backgroundImage = 'none';
                                                                                } else {
                                                                                    productoDiv.style.backgroundColor = 'lightgray';
                                                                                    productoDiv.style.opacity = '0.6';
                                                                                    productoDiv.style.backgroundSize = '9px 9px';
                                                                                    productoDiv.style.backgroundImage = 'repeating-linear-gradient(45deg, #ff0000 0, #ff0000 0.8px, #ffffff 0, #ffffff 50%)'; // Restablecer la imagen de fondo
                                                                                }
                                                                            });                                                                                                                        
                                                                        });
                                                                        
                                                                        var addModfBtn = document.getElementById('btnAddMod');
                                                                        addModfBtn.addEventListener('click', function handleClick() {
                                                                            var detalles = data.detallemodificador;
                                                                            var datosArray = [];
                        
                                                                            detalles.forEach(function(detalle) {
                                                                                var cantidadElement = document.getElementById(`MCantidad_${detalle.id}`);
                                                                                var precioElement = document.getElementById(`MPrecio_${detalle.id}`);
                                                                                var totalElement = document.getElementById(`MTotal_${detalle.id}`);
                                                                                var idElement = IdDetalle;
                                                                                var idElement2 = document.getElementById(`MIdDetalle_${detalle.id}`);
                                                                                var checkboxId = `ChexInput_${detalle.id}`;
                                                                                var checkboxElement = document.getElementById(checkboxId);
                        
                                                                                if (cantidadElement && precioElement && totalElement && idElement && checkboxElement) {
                                                                                    var cantidad = parseInt(cantidadElement.value);
                                                                                    var precio = parseFloat(precioElement.value);
                                                                                    var total = parseFloat(totalElement.value);
                                                                                    var idproducto = parseFloat(idElement);
                                                                                    var idDetalle = parseFloat(idElement2.value);
                                                                                    var checkboxValue = checkboxElement.checked;
                        
                                                                                    var data = {
                                                                                        iddetalleconsumo: idproducto,
                                                                                        iddetallemodificadore: idDetalle,
                                                                                        cantidad: cantidad,
                                                                                        precio: precio,
                                                                                        total: total,
                                                                                        checkboxValue: checkboxValue
                                                                                    };
                        
                                                                                    datosArray.push(data);
                                                                                }
                                                                            });
                        
                                                                            $.ajax({
                                                                                url: '/api/registrar-modificador-consumo',
                                                                                type: 'POST',
                                                                                contentType: 'application/json',
                                                                                data: JSON.stringify(datosArray),
                                                                                success: function(response) {
                                                                                    var modalAdd = document.getElementById('ModalAddModificador');
                                                                                    $(modalAdd).modal('hide');
                                                                                    DivPedidos.innerHTML = '';
                                                                                    AddProduct = document.getElementById('DivAddProduct');
                                                                                    AddProduct.innerHTML = '';
                                                                                    productosSeleccionados = [];
                                                                                    agregarDetallesConsumo(mesaId);
                                                                                    DivTotalConsumo(mesaId);
                                                                                    MostrarMensaje('Se agrego exitosamente','success')
                                                                                },
                                                                                error: function(xhr, status, error) {
                                                                                    MostrarMensaje('Error al enviar los datos','error')
                                                                                }
                                                                            });
                        
                                                                            // Remover el evento de clic después de hacer clic una vez
                                                                            addModfBtn.removeEventListener('click', handleClick);
                                                                        });
                        
                        
                                                                    },
                                                                    error: function(error) {
                                                                        console.error('Error:', error);
                                                                    }
                                                                });
                                                            });
                                                        }
                        
                                                    });
                        
                                                    $('#ElminarDetalle').on('show.bs.modal', function (event) {
                                                        var link = $(event.relatedTarget);
                                                        var index = link.data('index');
                                                        var detalle = detalleconsumos[index];
                                                        var modal = $(this);
                                                        modal.find('#detalleIdInput').val(detalle && detalle.id || '');
                                                    });
                        
                                                    var botonAceptar = $('#CancelarDetalle');
                                                    var textareaComentario = $('#TextComentario');
                                                    botonAceptar.prop('disabled', true);
                                                    textareaComentario.on('input', function() {
                                                        botonAceptar.prop('disabled', $(this).val().trim() === '');
                                                    });
                        
                                                    var botonAceptar = $('#CancelarDetalle');
                                                        $('#CancelarDetalle').off('click').on('click', function (event) {
                        
                                                        var detalleId = $('#detalleIdInput').val();
                                                        var comentario = $('#TextComentario').val();
                                                        
                                                        $.ajax({
                                                            url: '/api/delete-detalle-consumo/' + detalleId,
                                                            type: 'POST',
                                                            data: { detalleId: detalleId, comentario: comentario },
                                                            success: function (response) {
                                                                MostrarMensaje('Se Cancelo su detalle del pedido','success')
                                                                agregarDetallesConsumo(consumoId);
                                                                DivTotalConsumo(consumoId)
                                                            },
                                                            error: function (error) {
                                                                MostrarMensaje('hubo un problema en borrar','error')
                                                            }
                                                        });
                                                    });
                                                },
                                                error: function (error) {
                                                    console.error('Error:', error);
                                                }
                                            });                                
                                        }
                        
                                        function ListarDescuentos(id) {
                                            var DivLisDescuentos = document.getElementById('DivSubTotalList');
                                            
                                            $.ajax({
                                                url: '/api/get-descuento/' + id,
                                                type: 'get',
                                                success: function (response) {
                                                    DivLisDescuentos.innerHTML = '';
                                                    response.forEach(function (descuento) {
                                                        var nuevoDescuentoDiv = document.createElement('div');
                                                        nuevoDescuentoDiv.className = 'row';
                                                        nuevoDescuentoDiv.style.background = '#F0F0F0';
                                                        nuevoDescuentoDiv.style.padding = '6px';
                                                        nuevoDescuentoDiv.style.border = '2px solid white';
                                        
                                                        var tipoDescuentoText = descuento.TipoDescuento === 'porcentaje' ?
                                                            `Descuento de ${descuento.MontoDescuento} %` :
                                                            `Descuento de ${descuento.TipoDescuento}`;
                                        
                                                            nuevoDescuentoDiv.innerHTML = `
                                                                <div class="col-sm-6">
                                                                    <div class="input-group" style="width: 100%">
                                                                        <span style="font-size: 16px; color: #3D3B40">${tipoDescuentoText}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-5" style="text-align: right">
                                                                    <span style="font-size: 16px; color: #3D3B40">${descuento.TotalDescuento} Bs.</span>
                                                                </div>
                                                                <div class="col-sm-1" style="text-align: right">
                                                                    <button type="button" class="badge bg-red btnDeleteDescuento" data-descuento-id="${descuento.id}">x</button>
                                                                </div>
                                                            `;
                                                        DivLisDescuentos.appendChild(nuevoDescuentoDiv);                    
                                        
                                                        var btnDeleteDescuento = nuevoDescuentoDiv.querySelector('.btnDeleteDescuento');
                                                        btnDeleteDescuento.addEventListener('click', function () {
                                                            var descuentoId = btnDeleteDescuento.getAttribute('data-descuento-id');
                                                            $.ajax({
                                                                url: '/api/eliminar-descuento/' + descuentoId,
                                                                type: 'DELETE',
                                                                success: function (response) {
                                                                    DivDescuento.innerHTML = '';
                                                                    ListarDescuentos(id)
                                                                    MostrarMensaje('Descuento Eliminado Correctamente','success');
                                                                    //actualiza total
                                                                    $.ajax({
                                                                        url: '/apihostal/get-consumo/' + consumoId,
                                                                        type: 'GET',
                                                                        dataType: 'json',
                                                                        success: function (consumo) {
                                                                            var SubTotalProduct = document.getElementById('DivSubTotal');
                                                                            if (consumo[0].descuentoconsumos.length > 0) {
                                                                                SubTotalProduct.innerHTML = `
                                                                                    <div class="d-flex" style="background: #243A73; padding: 20px;">
                                                                                        <div class="flex-grow-1">
                                                                                            <div class="input-group" style="width: 100%">
                                                                                                <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="flex-shrink-0 text-right">
                                                                                            <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                                                                                        </div>
                                                                                    </div>
                                                                                `;
                                                                            } else {
                                                                                SubTotalProduct.innerHTML = '';
                                                                            }
                                                                            var TotalProduct = document.getElementById('DivTotal');
                                                                            TotalProduct.innerHTML = `
                                                                                <div style="background: #243A73; padding: 20px; display: flex;">
                                                                                    <div style="width: 50%;">
                                                                                        <div class="input-group" style="width: 100%;">
                                                                                            <span style="font-size: 20px; color: white;">TOTAL</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="text-align: right; width: 50%;">
                                                                                        <span style="font-size: 20px; color: white;">${consumo[0].total} Bs.</span>
                                                                                    </div>
                                                                                </div>
                                                                            `;
                                                                        },
                                                                        error: function (error) {
                                                                            console.error('Error:', error);
                                                                        }
                                                                    });
                                                                },
                                                                error: function (error) {
                                                                    MostrarMensaje(error,'error');
                                                                }
                                                            });
                                                        });
                                        
                                                    });
                                                },
                                                error: function (error) {
                                                    MostrarMensaje(error,'error');
                                                }
                                            });
                                        }
                        
                                        /*
                                        var btnActualizaMod = document.getElementById('btnActualizaMod');
                                        btnActualizaMod.addEventListener('click', function() {                                                
                                            var cantidad = parseInt(document.getElementById('EditCantidad').value);
                                            var precio = parseFloat(document.getElementById('EditPrecio').value);
                                            var total = parseFloat(document.getElementById('EditTotal').value);
                                            var id = parseFloat(document.getElementById('EditId').value);
                        
                                            var data = {
                                                id: id,
                                                cantidad: cantidad,
                                                precio: precio,
                                                total: total
                                            };
                        
                                            $.ajax({
                                                url: '/api/actualizar-modificador-consumo',
                                                type: 'POST',
                                                contentType: 'application/json',
                                                data: JSON.stringify(data),
                                                success: function(response) {
                                                    DivPedidos.innerHTML = '';
                                                    AddProduct = document.getElementById('DivAddProduct');
                                                    AddProduct.innerHTML = '';
                                                    productosSeleccionados = [];
                                                    agregarDetallesConsumo(mesaId);
                                                    DivTotalConsumo(mesaId);
                                                    MostrarMensaje('Se actualizo exitosamente','success')
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('Error al enviar los datos:', error);
                                                }
                                            });
                                            $(this).off('click');
                                        });
                        
                                        var eliminarModfBtn = document.getElementById('EliminarModf');
                                        eliminarModfBtn.addEventListener('click', function() {
                                            var id = document.getElementById('EliminarId').value;
                                            var data = {
                                                id: id,
                                                total: total
                                            };
                                            $.ajax({
                                                url: '/api/eliminar-modificador-consumo',
                                                type: 'POST',
                                                contentType: 'application/json',
                                                data: JSON.stringify(data),
                                                success: function(response) {
                                                    DivPedidos.innerHTML = '';
                                                    AddProduct = document.getElementById('DivAddProduct');
                                                    AddProduct.innerHTML = '';
                                                    productosSeleccionados = [];
                                                    agregarDetallesConsumo(mesaId);
                                                    DivTotalConsumo(mesaId);
                                                    MostrarMensaje('Se elimino exitosamente','success')
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('Error al enviar los datos:', error);
                                                }
                                            });
                                            $(this).off('click');
                                        });
                                        */
                                    },
                                    error: function (error) {
                                        console.error('Error al obtener productos:', error);
                                    }
                                });
                            }
                        },
                        error: function(error) {
                            console.error('Error al obtener datos:', error);
                        }
                    });
                }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al ocupar la habitación:', textStatus, errorThrown);
        }
    });    
}
