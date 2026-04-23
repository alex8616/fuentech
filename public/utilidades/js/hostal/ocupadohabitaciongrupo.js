function OcupadoHabitacionGrupo(id) {
    var habitacionIdPrivate = id
    $.ajax({
        url: '/apihostal/get-habitacion-ocupada-grupo/'+id,
        method: 'GET',
        success: function(response) {
            $('#form_tabs').empty();
            var hospedajeIdPrivate = response.hospedajehabitacion[0].id

            let tablaadelantos = '';
            let tablaadelantossum = '';
            let adelantos = response.hospedajehabitacion[0].adelantos;

            if (adelantos.length > 0) {
                adelantos.forEach(function(adelanto) {
                    tablaadelantos += `
                        <tr>
                            <td>${adelanto.FechaDeAdelanto || ''}</td>
                            <td>${adelanto.TipoAdelanto || ''}</td>
                            <td>${adelanto.TotalAdelanto || ''}</td>
                        </tr>
                    `;
                });

                tablaadelantossum += `
                    <tr style="background: #EAEAEA">
                        <th colspan="2" style="text-align: right">Sumatoria: </th>
                        <th>${response.hospedajehabitacion[0].Adelanto || ''}</th>
                    </tr>
                `;
            } else {
                tablaadelantos += `
                    <tr>
                        <td colspan="3">No Existe Adelantos</td>
                    </tr>
                `;
            }

            let tablaautos = '';
            let autos = response.hospedajehabitacion[0].autos;

            if (autos.length > 0) {
                autos.forEach(function(auto) {
                    tablaautos += `
                        <tr>
                            <td>${auto.placa || ''}</td>
                            <td>${auto.comentario || ''}</td>
                            <td>
                                <div class="avatar" style="background-color: ${auto.color || '#ccc'}; width: 50px; height: 20px"></div>
                            </td>
                        </tr>
                    `;
                });
            }

            let tablaprestamos = '';
            let prestamos = response.hospedajehabitacion[0].prestamos;

            if (prestamos.length > 0) {
                prestamos.forEach(function(prestamo) {
                    tablaprestamos += `
                        <tr>
                            <td>${prestamo.nombre_objeto || ''}</td>
                            <td>${prestamo.comentario    || ''}</td>
                            <td>${prestamo.fecha_venta || ''}</td>
                        </tr>
                    `;
                });
            }           

            var HabitacionForm = `
                <div class="card-header" style="width: 100%; background-color: #d63939; color: white">
                    <h3 class="card-title">Habitacion #${id}</h3>
                    <div class="ms-auto">
                        <span class="badge bg-azure-lt" data-id="${id}" id="EditarInformacionHospedaje" style="padding: 14px">
                            Editar
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-hospedaje-habitacion" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">HOSPEDAJE</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tabs-consumo-habitacion" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">CONSUMOS</a>
                                </li>                               
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SERVICIOS</a>
                                    <div class="dropdown-menu" style="">
                                    <a class="dropdown-item" href="#tabs-servicio-habitacion-desayuno" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                        Desayuno
                                    </a>
                                    <a class="dropdown-item" href="#tabs-servicio-habitacion-lavanderia" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                        Lavanderia
                                    </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-hospedaje-habitacion" role="tabpanel">
                                    <div class="datagrid" style="background: white">
                                        <div class="row">                                            
                                            <div class="col-12 col-sm-12">
                                                <div class="mb-3 row">
                                                    <div class="card-header" style="width: 100%; background-color: #151f2c; color: white">
                                                        <h3 class="card-title">PASAJEROS</h3>
                                                        <div class="ms-auto">
                                                            <a class="input-group-link" style="color: #3FA2F6; font-size: 16px" id="btn-agregar-pasajeros">Agregar Pasajeros</a>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="table-responsive">
                                                            <table class="table table-vcenter card-table" id="table-pasajeros">
                                                            <thead>
                                                                <tr>
                                                                <th>Documento</th>
                                                                <th>Nombre Completo</th>
                                                                <th>Nacionalidad</th>
                                                                <th>Profesion</th>
                                                                <th>Edad</th>
                                                                <th>Estado</th>
                                                                <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12" id="Div-Informacion-Hospedaje">
                                                <div class="card-header" style="width: 100%; background-color: #151f2c; color: white">
                                                    <h3 class="card-title">
                                                        HOSPEDAJE  <a class="input-group-link" style="color: #3FA2F6; font-size: 16px" id="btn-agregar-detalles-hospedaje">Agregar</a>
                                                    </h3>
                                                    <div class="ms-auto">
                                                        <h3 class="card-title" style="font-size: 25px; color: red">
                                                            ${response.hospedajehabitacion[0].GuiaTuristica == "false" ? `
                                                                ${response.hospedajehabitacion[0].TotalHospedaje}
                                                            ` : 'Guia Del Grupo'
                                                            }
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="card" style="padding: 8px;">
                                                    <div class="row">
                                                        ${response.hospedajehabitacion[0].CambioDolar &&  response.hospedajehabitacion[0].CambioBolivianos != 0 ? `
                                                            <div class="col-12 col-sm-6">
                                                                <div class="mb-3 row">
                                                                    <label class="col-6 col-form-label" style="font-weight: bold;">DOLAR</label>
                                                                    <div class="col">
                                                                        <label class="col-12 col-form-label">${response.hospedajehabitacion[0].CambioDolar}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-6">
                                                                <div class="mb-3 row">
                                                                    <label class="col-6 col-form-label" style="font-weight: bold;">BOLIVIANO</label>
                                                                    <div class="col">
                                                                        <label class="col-12 col-form-label">${response.hospedajehabitacion[0].CambioBolivianos}</label>
                                                                    </div>
                                                                </div>                                                                                
                                                            </div>
                                                        ` : ''
                                                        }
                                                        <div class="col-12 col-sm-6">
                                                            <div class="mb-3 row">
                                                                <label class="col-6 col-form-label" style="font-weight: bold;">TIPO DE HAB</label>
                                                                <div class="col">
                                                                    <label class="col-12 col-form-label">${response.hospedajehabitacion[0].CategoriaHabitacion}</label>
                                                                </div>
                                                            </div>                                        
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="mb-3 row">
                                                                <label class="col-6 col-form-label" style="font-weight: bold;">PRECIO DE HAB</label>
                                                                <div class="col">
                                                                    <label class="col-12 col-form-label">${response.hospedajehabitacion[0].Precio_habitacion}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="mb-3 row">
                                                                <label class="col-6 col-form-label" style="font-weight: bold;">FECHA INGRESO</label>
                                                                <div class="col">
                                                                    <label class="col-12 col-form-label">${response.hospedajehabitacion[0].ingreso_hospedaje}</label>
                                                                </div>
                                                            </div>                                                                                
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="mb-3 row">
                                                                <label class="col-6 col-form-label" style="font-weight: bold;">FECHA SALIDA</label>
                                                                <div class="col">
                                                                    <label class="col-12 col-form-label">${response.hospedajehabitacion[0].salida_hospedaje}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="mb-3 row">
                                                                <label class="col-6 col-form-label" style="font-weight: bold;">PROCEDENTE</label>
                                                                <div class="col">
                                                                    <label class="col-12 col-form-label">${response.hospedajehabitacion[0].procedencia_hospedaje}</label>
                                                                </div>
                                                            </div>                                                                                                                      
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="mb-3 row">
                                                                <label class="col-6 col-form-label" style="font-weight: bold;">DESTINO</label>
                                                                <div class="col">
                                                                    <label class="col-12 col-form-label">${response.hospedajehabitacion[0].destino_hospedaje}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-4">
                                                                    <div class="mb-3 row">
                                                                        <table class="table table-sm table-borderless">
                                                                            <tbody>
                                                                                ${tablaautos}
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-1">
                                                                    <div class="mb-3 row">
                                                                       <br>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-7">
                                                                    <div class="mb-3 row">
                                                                       <table class="table table-sm table-borderless">
                                                                            <tbody>
                                                                                ${tablaprestamos}
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12" style="background: #E6E6E6">
                                                            <div class="mb-3 row">
                                                                <label class="col-12 col-form-label" style="font-size: 20px; font-weight: normal; color: #393E46">
                                                                    Se quedara <span style="font-size: 18px; font-weight: bold; color: black">${response.hospedajehabitacion[0].dias_hospedarse}</span> dias por noche sera <span style="font-size: 18px; font-weight: bold; color: black">${response.hospedajehabitacion[0].Precio_habitacion}Bs.</span> haciendo un total de <span style="font-size: 18px; font-weight: bold; color: black">${response.hospedajehabitacion[0].TotalHospedaje}Bs.</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>                                                
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <div class="card-header" style="width: 100%; background-color: #151f2c; color: white">
                                                    <h3 class="card-title">SERVICIOS</h3>
                                                    <div class="ms-auto">
                                                        <h3 class="card-title" style="font-size: 25px; color: red">${response.hospedajehabitacion[0].servicios[0].totalgeneral}</h3>
                                                    </div>
                                                </div>
                                                <div class="accordion" id="accordion-example">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading-4">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#containertabledesayuno" aria-expanded="false">
                                                                Desayunos Extra
                                                            </button>
                                                        </h2>
                                                        <div id="containertabledesayuno" class="accordion-collapse collapse" data-bs-parent="#accordion-example" hidden>
                                                            <div class="accordion-body pt-0">
                                                                <div class="card">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-vcenter card-table" id="table-servicios-desayuno">
                                                                        <thead>
                                                                            <tr>
                                                                            <th>Pagado</th>
                                                                            <th>Fecha</th>
                                                                            <th>Comentario</th>
                                                                            <th>Cant</th>
                                                                            <th>Precio</th>
                                                                            <th>Total</th>
                                                                            <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="5" style="text-align: right;">SubTotal:</td>
                                                                                <td id="total-servicio-desayuno-subtotal">0</td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="5" style="text-align: right;">Pagado:</td>
                                                                                <td id="total-servicio-desayuno-pagado">0</td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="5" style="text-align: right;">TOTAL:</td>
                                                                                <td id="total-servicio-desayuno-total">0</td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading-4">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#containertablelavado" aria-expanded="false">
                                                                Lavanderia
                                                            </button>
                                                        </h2>
                                                        <div id="containertablelavado" class="accordion-collapse collapse" data-bs-parent="#accordion-example" hidden>
                                                            <div class="accordion-body pt-0">
                                                                <div class="card">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-vcenter card-table" id="table-servicios-lavado">
                                                                        <thead>
                                                                            <tr>
                                                                            <th>Estado</th>
                                                                            <th>Pagado</th>
                                                                            <th>Tipo</th>
                                                                            <th>Comentario</th>
                                                                            <th>Kilo</th>
                                                                            <th>Precio</th>
                                                                            <th>Total</th>
                                                                            <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="6" style="text-align: right;">SubTotal:</td>
                                                                                <td id="total-servicio-lavado-subtotal">0</td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="6" style="text-align: right;">Pagado:</td>
                                                                                <td id="total-servicio-lavado-pagado">0</td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="6" style="text-align: right;">TOTAL:</td>
                                                                                <td id="total-servicio-lavado-total">0</td>
                                                                                <td></td>
                                                                            </tr>
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
                                                        <h3 class="card-title" style="font-size: 25px; color: red">${response.hospedajehabitacion[0].servicioconsumos[0].totalgeneral}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12">
                                                        <div class="mb-3">
                                                            <div class="accordion" id="accordion-example">
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header" id="heading-1">
                                                                    <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#containertableconsumo" aria-expanded="true">
                                                                        Consumos
                                                                    </button>
                                                                    </h2>
                                                                    <div id="containertableconsumo" class="accordion-collapse collapse" data-bs-parent="#accordion-example" hidden>
                                                                        <div class="accordion-body pt-0">
                                                                            <div class="card">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-vcenter card-table" id="table-consumos">
                                                                                    <thead>
                                                                                        <tr>
                                                                                        <th>Pagado</th>
                                                                                        <th>Fecha</th>
                                                                                        <th>Consumo Detalle</th>
                                                                                        <th>Total</th>
                                                                                            <th></th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        
                                                                                    </tbody>
                                                                                    <tfoot>
                                                                                        <tr>
                                                                                            <td colspan="3" style="text-align: right;">SubTotal:</td>
                                                                                            <td id="total-consumo-subtotal">0</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="3" style="text-align: right;">Pagado:</td>
                                                                                            <td id="total-consumo-pagado">0</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="3" style="text-align: right;">TOTAL:</td>
                                                                                            <td id="total-consumo-total">0</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tfoot>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-6">
                                                                <div class="mb-3" hidden>
                                                                    <div class="card">
                                                                        <div class="card-body" style="margin: 6px; padding: 6px">
                                                                            <div class="card-header" style="width: 100%; margin: 5px; padding: 5px">  
                                                                                <h3 class="card-title">ADELANTOS</h3>
                                                                                <div class="ms-auto">
                                                                                    <span class="badge badge-outline text-blue" style="cursor: pointer;" id="btn-agregar-adelanto" data-bs-toggle="modal" data-bs-target="#modal-adelanto" data-id="${response.hospedajehabitacion[0].id}">
                                                                                        Agregar
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <table class="table table-sm table-borderless" id="tabla-adelantos">
                                                                                <tbody>
                                                                                    ${tablaadelantos}
                                                                                </tbody>
                                                                                <tfoot>
                                                                                    ${tablaadelantossum}
                                                                                </tfoot>
                                                                            </table>
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
                                                                                    <td colspan="2" style="text-align: right; padding-right: 20px">TOTAL SERVICIOS</th>
                                                                                    <td style="text-align: left; padding-left: 20px" id="TotalServiciosValor"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="2" style="text-align: right; padding-right: 20px">TOTAL CONSUMO</th>
                                                                                    <td style="text-align: left; padding-left: 20px" id="TotalConsumosValor"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th colspan="2" style="text-align: right; padding-right: 20px">SUB TOTAL</th>
                                                                                    <td style="text-align: left; padding-left: 20px" id="TotalHospedajeSubTotalValor"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th colspan="2" style="text-align: right; padding-right: 20px">ADELANTOS</th>
                                                                                    <td style="text-align: left; padding-left: 20px" id="TotalHospedajeAdelantoValor"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th colspan="2" style="font-size: 19px; text-align: right; padding-right: 20px">TOTAL A PAGAR</th>
                                                                                    <th style="font-size: 19px; text-align: left; padding-left: 20px" id="TotalHospedajeGeneralValor"></th>
                                                                                </tr>
                                                                            </tbody>
                                                                            </table>
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
                                    <div class="card-footer text-end" hidden>
                                        <button class="btn btn-primary" id="btn-concluir-hospedaje" data-bs-toggle="modal" data-bs-target="#modal-concluir-hospedaje">CONCLUIR HOSPEDAJE</button>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tabs-consumo-habitacion" role="tabpanel">
                                    <div class="datagrid" style="background: white">
                                        <div class="row">
                                            <h3 class="card-title" style="width: 100%; background:#151f2c; color: white; padding: 8px">CONSUMOS</h3>
                                            <div class="row" id="div-consumos-hmtl">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tabs-servicio-habitacion-desayuno" role="tabpanel">
                                    <div class="datagrid" style="background: white">
                                        <div class="row">
                                            <div class="col-12 col-sm-12">
                                                <div class="mb-3">
                                                    <h3 class="card-title" style="width: 100%; background:#151f2c; color: white; padding: 8px">DESAYUNO</h3>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Cantidad</label>
                                                    <input type="text" class="form-control convertNumber" id="InputCantidadDesayuno">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Precio</label>
                                                    <input type="text" class="form-control convertNumber" id="InputPrecioDesayuno">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Total</label>
                                                    <input type="text" class="form-control convertNumber" id="InputTotalDesayuno">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha De Venta</label>
                                                    <input type="date" class="form-control convertDate" id="InputFechaDesayuno">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Estado De Pago</label>
                                                    <select class="form-control" id="DesayunoEstadoPagoSelect">
                                                        <option value="Cargar a Habitacion">Cargar a Habitacion</option>
                                                        <option value="Pagado">Pagado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4" id="tipoPagoContainer" hidden>
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo De Pago</label>
                                                    <select class="form-control" id="DesayunoTipoPagoSelect">
                                                        <option value="Efectivo">Efectivo</option>
                                                        <option value="Tarjeta">Tarjeta</option>
                                                        <option value="Deposito/QR">Deposito/QR</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Comentario</label>
                                                    <textarea class="form-control" id="DesayunoComentario"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12" id="NotaContainer" hidden>
                                                <div class="mb-3">
                                                    <label class="form-label" style="color: red; font-size: 13px">*NOTA CON ESTA SELECCION SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <div class="card-footer">
                                                    <div class="d-flex">
                                                    <a href="#" class="btn btn-red" id="btn-desayuno-cancelar">Cancel</a>
                                                    <a href="#" class="btn btn-primary ms-auto" id="btn-registrar-desayuno">Registrar Desayuno</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tabs-servicio-habitacion-lavanderia" role="tabpanel">
                                    <div class="datagrid" style="background: white">                                        
                                        <div class="row">
                                            <div class="col-12 col-sm-12">
                                                <div class="mb-3">
                                                    <h3 class="card-title" style="width: 100%; background:#151f2c; color: white; padding: 8px">LAVANDERIA</h3>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Kilos</label>
                                                    <input type="text" class="form-control convertNumber" id="InputKiloLavado">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Precio</label>
                                                    <input type="text" class="form-control convertNumber" id="InputPrecioLavado">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Total</label>
                                                    <input type="text" class="form-control convertNumber" id="InputTotalLavado">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Ingreso Ropa</label>
                                                    <input type="date" class="form-control convertDate" id="InputFechaLavado">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Estado De Pago</label>
                                                    <select class="form-control" id="LavadoEstadoPagoSelect">
                                                        <option value="Cargar a Habitacion">Cargar a Habitacion</option>
                                                        <option value="Pagado">Pagado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4" id="LavadotipoPagoContainer" hidden>
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo De Pago</label>
                                                    <select class="form-control" id="LavadoTipoPagoSelect">
                                                        <option value="Efectivo">Efectivo</option>
                                                        <option value="Tarjeta">Tarjeta</option>
                                                        <option value="Deposito/QR">Deposito/QR</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Comentario</label>
                                                    <textarea class="form-control" id="LavadoComentario"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12" id="LavadoNotaContainer" hidden>
                                                <div class="mb-3">
                                                    <label class="form-label" style="color: red; font-size: 13px">*NOTA CON ESTA SELECCION SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <div class="card-footer">
                                                    <div class="d-flex">
                                                    <a href="#" class="btn btn-red" id="btn-lavado-cancelar">Cancel</a>
                                                    <a href="#" class="btn btn-primary ms-auto" id="btn-registrar-lavado">Registrar Desayuno</a>
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

            `;
            $('#form_tabs').append(HabitacionForm);            
            
            $('#TotalServiciosValor').text(response.hospedajehabitacion[0].TotalServicio);
            $('#TotalConsumosValor').text(response.hospedajehabitacion[0].TotalConsumo);
            $('#TotalHospedajeSubTotalValor').text(response.hospedajehabitacion[0].SubTotal);
            $('#TotalHospedajeAdelantoValor').text(response.hospedajehabitacion[0].Adelanto);
            $('#TotalHospedajeGeneralValor').text(response.hospedajehabitacion[0].Total);
            
            InputNumberConver()
            InputDateConver()

            let hospedajeHabitacion = response.hospedajehabitacion[0];
            let detallesHospedajes = hospedajeHabitacion.detallehospedajes;
            let botonConcluirHospedaje = document.getElementById('btn-concluir-hospedaje');

            if (detallesHospedajes.length > 0 && response.hospedajehabitacion[0].TotalHospedaje > 0) {
                botonConcluirHospedaje.removeAttribute('disabled');
            } else {
                botonConcluirHospedaje.setAttribute('disabled', 'disabled');
            }
            
            $('#btn-concluir-hospedaje').off('click').on('click', function(event) {
                event.preventDefault();
                
                $('#modal-concluir-hospedaje').on('hidden.bs.modal', function () {
                    $('#ListPagos').empty();
                    var DivMostradorListPagos = document.getElementById('MostradorListPagos');
                    DivMostradorListPagos.innerHTML = `
                        <div class="row" style="background: #F5F7F8; border: 1px solid white">
                            <div class="col-12 col-sm-12">
                                <div class="row" style="font-size: 16px">
                                    <div class="col-12 col-sm-8"><strong>TOTAL HOSPEDAJE: </strong></div>
                                    <div class="col-12 col-sm-4"><span>0.00</span></div>
                                    <div class="col-12 col-sm-8"><strong>TOTAL SERVICIO: </strong></div>
                                    <div class="col-12 col-sm-4"><span>0.00</span></div>
                                    <div class="col-12 col-sm-8"><strong>TOTAL CONSUMO: </strong></div>
                                    <div class="col-12 col-sm-4"><span>0.00</span></div>
                                    <div class="col-12 col-sm-8"><strong>SUBTOTAL: </strong></div>
                                    <div class="col-12 col-sm-4"><span>0.00</span></div>
                                    <div class="col-12 col-sm-8"><strong>ADELANTOS: </strong></div>
                                    <div class="col-12 col-sm-4"><span>0.00</span></div>
                                    <div class="col-12 col-sm-8" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                                        <div class="row">
                                            <div class="col-12 col-sm-8"><strong>Total a Pagar</strong></div>
                                            <div class="col-12 col-sm-4"><span>0.00</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                
                    `;
                    $('#MostradorlistVuelto').html('<span>Cambio: 0.00</span>');
                    $('#btnConfirmarPago').prop('disabled', true);
                });
                
                //hospedajeIdPrivate
                // Mostrar detalleconsumos en listConsumo
                var DivMostradorListPagos = document.getElementById('MostradorListPagos');
                DivMostradorListPagos.innerHTML = `
                    <div class="row" style="background: #F5F7F8; border: 1px solid white">
                        <div class="col-12 col-sm-12">
                            <div class="row" style="font-size: 16px">
                                <div class="col-12 col-sm-8"><strong>TOTAL HOSPEDAJE: </strong></div>
                                <div class="col-12 col-sm-4"><span>${response.hospedajehabitacion[0].TotalHospedaje}</span></div>
                                <div class="col-12 col-sm-8"><strong>TOTAL SERVICIO: </strong></div>
                                <div class="col-12 col-sm-4"><span>${response.hospedajehabitacion[0].TotalServicio}</span></div>
                                <div class="col-12 col-sm-8"><strong>TOTAL CONSUMO: </strong></div>
                                <div class="col-12 col-sm-4"><span>${response.hospedajehabitacion[0].TotalConsumo}</span></div>
                                <div class="col-12 col-sm-8"><strong>SUBTOTAL: </strong></div>
                                <div class="col-12 col-sm-4"><span>${response.hospedajehabitacion[0].SubTotal}</span></div>
                                <div class="col-12 col-sm-8"><strong>ADELANTOS: </strong></div>
                                <div class="col-12 col-sm-4"><span>${response.hospedajehabitacion[0].Adelanto}</span></div>
                                <div class="col-12 col-sm-8" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                                    <div class="row">
                                        <div class="col-12 col-sm-8"><strong>Total a Pagar</strong></div>
                                        <div class="col-12 col-sm-4"><span>${response.hospedajehabitacion[0].Total}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                
                `;
                
                $('#MostradoraddPagos').off('click').on('click', function () {
                    // Crear el contenido que se va a agregar
                    var nuevoPago = $('<div style="padding: 4px; margin: 4px"></div>').html(`
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="form-control" id="TipoPago">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Deposito/QR">Deposito/QR</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control moneda" id="TipoMonedaPago">
                                    <option value="Bs">Bs.</option>
                                    <option value="Dolar">$</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control montoPagoInput" id="MontoPago" style="width: 100%; display: inline-block;">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn position-relative btnEliminarPago" type="button">x</button>
                            </div>
                        </div>
                    `);

                    $('#ListPagos').append(nuevoPago);

                    nuevoPago.find('.btnEliminarPago').off('click').on('click', function () {
                        $(this).closest('.row').parent().remove();
                        calcularYMostrarCambio();
                    });

                    nuevoPago.find('.montoPagoInput').off('input').on('input', function () {
                        calcularYMostrarCambio();
                    });

                    calcularYMostrarCambio();
                });



                var primerPago = document.createElement('div');
                primerPago.innerHTML = `
                    <div style="padding: 4px; margin: 4px">
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="form-control" id="TipoPago">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Deposito/QR">Deposito/QR</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control moneda" id="TipoMonedaPago">
                                    <option value="Bs">Bs.</option>
                                    <option value="Dolar">$</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control montoPagoInput" value="${response.hospedajehabitacion[0].Total}" id="MontoPago" style="width: 100%; display: inline-block;">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn position-relative btnEliminarPago" type="button">x</button>
                            </div>
                        </div>                        
                    </div>
                `;

                document.getElementById('ListPagos').appendChild(primerPago);

                primerPago.querySelector('.montoPagoInput').addEventListener('input', function () {
                    calcularYMostrarCambio();
                });

                calcularYMostrarCambio();

                function calcularYMostrarCambio() {
                    var elementosPagos = document.querySelectorAll('#ListPagos > div');
                
                    var totalPagos = 0;
                    elementosPagos.forEach(function (elementoPago) {
                        var montoPago = parseFloat(elementoPago.querySelector('.montoPagoInput').value) || 0;
                        var tipoMoneda = elementoPago.querySelector('#TipoMonedaPago').value;
                
                        // Si la moneda es Dólar, multiplicar por 7
                        if (tipoMoneda === 'Dolar') {
                            montoPago *= 7;
                        }
                
                        totalPagos += montoPago;
                    });
                
                    var limitePago = parseFloat(response.hospedajehabitacion[0].Total) || 0;
                    var cambio = totalPagos - limitePago;
                
                    var listVuelto = document.getElementById('MostradorlistVuelto');
                    listVuelto.innerHTML = `
                        <span>Cambio: ${cambio.toFixed(2)}</span>
                    `;
                    actualizarEstadoBoton(cambio);
                }

                function actualizarEstadoBoton(cambio) {
                    var btnConfirmarPago = document.getElementById('btnConfirmarPago');
                    btnConfirmarPago.disabled = cambio < 0;
                }

                $('#btnConfirmarPago').off('click').on('click', function (event) {
                    $(this).prop('disabled', true);
                    event.preventDefault();
                    var elementosPagos = $('#ListPagos > div');
                    var pagos = [];
                    elementosPagos.each(function () {
                        var tipoPago = $(this).find('.form-control').val();
                        var tipomonedaPago = $(this).find('.moneda').val();
                        var montoPago = parseFloat($(this).find('.montoPagoInput').val()) || 0;
                        pagos.push({
                            tipo: tipoPago,
                            moneda: tipomonedaPago,
                            cantidad: montoPago
                        });
                    });
                    var token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '/apihostal/concluir-hospedaje-cerrar/' + hospedajeIdPrivate,
                        type: 'POST',
                        data: {
                            _token: token,
                            pagos: pagos,
                        },
                        success: function (data) {
                            MostrarHabitaciones();
                            CanvasTime();
                            MostrarMensaje("Hospedaje Concluida Exitosamente", "success")                     
                        },
                        error: function (error) {
                            MostrarMensaje("No ce puedo concluir", "error");
                        },
                        complete: function() {
                            $('#btnConfirmarPago').prop('disabled', false);
                        }
                    });
                });

            });
            
            //DESAYUNO INICIO
            $('#DesayunoEstadoPagoSelect').off('click').on('change', function() {
                var estadoPago = $(this).val();
                
                if (estadoPago === 'Pagado') {
                    $('#tipoPagoContainer').removeAttr('hidden'); 
                    $('#NotaContainer').removeAttr('hidden'); 
                } else {
                    $('#tipoPagoContainer').attr('hidden', true); 
                    $('#NotaContainer').attr('hidden', true); 
                }
            });

            function calcularTotal() {
                var cantidad = parseFloat($('#InputCantidadDesayuno').val()) || 0;
                var precio = parseFloat($('#InputPrecioDesayuno').val()) || 0;
                var total = cantidad * precio;
                $('#InputTotalDesayuno').val(total.toFixed(2));
            }
        
            $('#InputCantidadDesayuno, #InputPrecioDesayuno').on('input', function() {
                calcularTotal();
            });

            $('#btn-registrar-desayuno').off('click').on('click', function(event) {
                event.preventDefault();
                var data = {
                    InputCantidadDesayuno: $('#InputCantidadDesayuno').val(),
                    InputPrecioDesayuno: $('#InputPrecioDesayuno').val(),
                    InputTotalDesayuno: $('#InputTotalDesayuno').val(),
                    InputFechaDesayuno: $('#InputFechaDesayuno').val(),
                    DesayunoEstadoPagoSelect: $('#DesayunoEstadoPagoSelect').val(),
                    DesayunoTipoPagoSelect: $('#DesayunoTipoPagoSelect').val(),
                    DesayunoComentario: $('#DesayunoComentario').val(), 
                    IdHospedaje: response.hospedajehabitacion[0].id,
                };
            
                $.ajax({
                    url: '/apihostal/registrar-servicio-desayuno-hostal',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        OcupadoHabitacionGrupo(id)
                        MostrarMensaje("Servicio Registrado Exitosamente", "success")
                    },
                    error: function() {
                        alert("Error al registrar el cliente.");
                    }
                });
            });
            //DESAYUNO FIN

            //LAVADO INICIO
            $('#LavadoEstadoPagoSelect').off('click').on('change', function() {
                var estadoPagolavado = $(this).val();
                
                if (estadoPagolavado === 'Pagado') {
                    $('#LavadotipoPagoContainer').removeAttr('hidden'); 
                    $('#LavadoNotaContainer').removeAttr('hidden'); 
                } else {
                    $('#LavadotipoPagoContainer').attr('hidden', true); 
                    $('#LavadoNotaContainer').attr('hidden', true); 
                }
            });

            function LavadocalcularTotal() {
                var lavadocantidad = parseFloat($('#InputKiloLavado').val()) || 0;
                var lavadoprecio = parseFloat($('#InputPrecioLavado').val()) || 0;
                var lavadototal = lavadocantidad * lavadoprecio;
                $('#InputTotalLavado').val(lavadototal.toFixed(2));
            }
        
            $('#InputKiloLavado, #InputPrecioLavado').on('input', function() {
                LavadocalcularTotal();
            });

            $('#btn-registrar-lavado').off('click').on('click', function(event) {
                event.preventDefault();
                var data = {
                    InputKiloLavado: $('#InputKiloLavado').val(),
                    InputPrecioLavado: $('#InputPrecioLavado').val(),
                    InputTotalLavado: $('#InputTotalLavado').val(),
                    InputFechaLavado: $('#InputFechaLavado').val(),
                    LavadoEstadoPagoSelect: $('#LavadoEstadoPagoSelect').val(),
                    LavadoTipoPagoSelect: $('#LavadoTipoPagoSelect').val(),
                    LavadoComentario: $('#LavadoComentario').val(), 
                    IdHospedaje: response.hospedajehabitacion[0].id,
                };
            
                $.ajax({
                    url: '/apihostal/registrar-servicio-lavado-hostal',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        OcupadoHabitacionGrupo(id)
                        MostrarMensaje("Servicio Registrado Exitosamente", "success")
                    },
                    error: function() {
                        alert("Error al registrar el cliente.");
                    }
                });
            });
            //LAVADO FIN
                
            
            if (response.hospedajehabitacion && response.hospedajehabitacion.length > 0) {
                let tieneconsumos = false;

                response.hospedajehabitacion.forEach(function(hospedaje) {
                    if (hospedaje.servicioconsumos && hospedaje.servicioconsumos.length > 0) {
                        tieneconsumos = true;
                    }
                });

                if (tieneconsumos) {
                    llenarTablaConsumos(response)
                    
                    $('#table-consumos').off('click').on('click', '#btn-pagar-consumo', function() {
                        const consumoID = $(this).data('id'); 
                        $('#btn-confirmar-modal-consumo').data('id', consumoID);
                    
                        $('#btn-confirmar-modal-consumo').off('click').on('click', function(event) {
                            event.preventDefault();
                            
                            const ModalConsumoTipoPagoSelect = $('#ModalConsumoTipoPagoSelect').val();
                            const consumoID = $(this).data('id');
                            
                            const dataToSend = {
                                ModalConsumoTipoPagoSelect: ModalConsumoTipoPagoSelect,
                                id: consumoID,
                            };
                        
                            $.ajax({
                                url: '/apihostal/cerrar-consumo-habitacion-postenvio',
                                method: 'POST',
                                data: dataToSend,
                                success: function(response) {
                                    OcupadoHabitacionGrupo(id); 
                                    MostrarMensaje("Consumo Pagado Exitosamente", "success");
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error('Error al recuperar:', textStatus, errorThrown);
                                }
                            });
                        });
                    });
                }
            }


            if (response.hospedajehabitacion && response.hospedajehabitacion.length > 0) {
                let tieneClientes = false;

                response.hospedajehabitacion.forEach(function(hospedaje) {
                    if (hospedaje.detallehospedajes && hospedaje.detallehospedajes.length > 0) {
                        tieneClientes = true;
                    }
                });

                if (tieneClientes) {
                    llenarTablaClientes(response);
                    
                    $('#table-pasajeros').on('click', '.btn-eliminar-pasajero', function() {
                        var DetalleHospedajeId = $(this).closest('tr').find('.detalle-hospedaje-id').text();
                        var data = {
                            DetalleHospedajeId: DetalleHospedajeId,
                        };
                    
                        $.ajax({
                            url: '/apihostal/eliminar-detalle-hospedaje-cliente',
                            method: 'POST',
                            data: data,
                            success: function(data) {
                                OcupadoHabitacionGrupo(id)
                                MostrarMensaje("Eliminado Exitosamente","success")
                            },
                            error: function() {
                                alert("Error al registrar el cliente.");
                            }
                        });
                    });
                }
            }

            
            if (response.hospedajehabitacion && response.hospedajehabitacion.length > 0) {
                let tieneServicios = false;

                response.hospedajehabitacion.forEach(function(hospedaje) {
                    if (hospedaje.servicios && hospedaje.servicios.length > 0) {
                        tieneServicios = true;
                    }
                });

                if (tieneServicios) {
                    llenarTablaServicios(response);
                    
                    
                    $('#table-servicios-desayuno').off('click').on('click', '#btn-pagar-servicio-desayuno', function() {
                        const DetalleServicioDesayuno = $(this).data('id');
                        $('#btn-confirmar-modal-desayuno').off('click').on('click', function(event) {
                            event.preventDefault();
                            const HospedajeId = response.hospedajehabitacion[0].id;
                            const ModalDesayunoTipoPagoSelect = $('#ModalDesayunoTipoPagoSelect').val();
                            const habitacionId = id;
                    
                            const dataToSend = {
                                DetalleServicioDesayuno: DetalleServicioDesayuno,
                                HospedajeId: HospedajeId,
                                ModalDesayunoTipoPagoSelect: ModalDesayunoTipoPagoSelect,
                                habitacionId: habitacionId,
                            };
                        
                            $.ajax({
                                url: '/apihostal/actualizar-servicio-desayuno-hostal-postenvio',
                                method: 'POST',
                                data: dataToSend,
                                success: function(response) {
                                    OcupadoHabitacion(habitacionId)
                                    MostrarMensaje("Habitacion Actualizado Exitosamente", "success")
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error('Error al recuperar:', textStatus, errorThrown);
                                }
                            });
                        });
                    });

                    $('#table-servicios-lavado').off('click').on('click', '#btn-pagar-servicio-lavado', function() {
                        const DetalleServicioDesayuno = $(this).data('id');
                        $('#btn-confirmar-modal-lavado').off('click').on('click', function(event) {
                            event.preventDefault();
                            const HospedajeId = response.hospedajehabitacion[0].id;
                            const ModalLavadoTipoPagoSelect = $('#ModalLavadoTipoPagoSelect').val();
                            const habitacionId = id;
                    
                            const dataToSend = {
                                DetalleServicioDesayuno: DetalleServicioDesayuno,
                                HospedajeId: HospedajeId,
                                ModalLavadoTipoPagoSelect: ModalLavadoTipoPagoSelect,
                                habitacionId: habitacionId,
                            };
                        
                            $.ajax({
                                url: '/apihostal/actualizar-servicio-lavado-hostal-postenvio',
                                method: 'POST',
                                data: dataToSend,
                                success: function(response) {
                                    OcupadoHabitacion(habitacionId)
                                    MostrarMensaje("Habitacion Actualizado Exitosamente", "success")
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error('Error al recuperar:', textStatus, errorThrown);
                                }
                            });
                        });
                    });

                    $(document).off('click').on('click', '.btn-entregar-lavado', function() {
                        var servicioId = $(this).data('id');
                        
                        // Usamos SweetAlert2 para la confirmación
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¿Deseas marcar como entregado este servicio?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, entregado',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Si el usuario confirma, realizamos la solicitud AJAX
                                $.ajax({
                                    url: '/apihostal/entregar-servicio-lavado',
                                    method: 'POST',
                                    data: {
                                        id: servicioId,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        OcupadoHabitacionGrupo(id); // Recarga la información de la habitación
                                        MostrarMensaje("Actualizado Exitosamente", "success"); // Mensaje de éxito
                                    },
                                    error: function() {
                                        Swal.fire(
                                            'Error',
                                            'Ocurrió un error al procesar la solicitud.',
                                            'error'
                                        );
                                    }
                                });
                            }
                        });
                    });
                    
                }
            }
            

            $(document).on('click', '#btn-agregar-pasajeros', function(event) {
                event.preventDefault();
                $('#modalPasajeros').modal('show');
            
                $(document).ready(function() {
                    $('#InputCiPassaporte').on('input', function() {
                        const query = $(this).val();
                
                        $.ajax({
                            url: '/apihostal/get-clientes-hostal',
                            method: 'GET',
                            global: false,
                            data: { query: query },
                            success: function(data) {
                                $('#suggestions-list').empty();
                
                                if (data.length > 0) {
                                    data.forEach(cliente => {
                                        $('#suggestions-list').append(`
                                            <li class="list-group-item suggestion-item" data-id="${cliente.id}">
                                                ${cliente.Nombre_cliente} ${cliente.Apellido_cliente} - ${cliente.Documento_cliente}
                                            </li>
                                        `);
                                    });
                                    $('#suggestions-list').show(); 
                                    $('.formulario').addClass('d-none');
                                } else {
                                    $('.formulario').removeClass('d-none');
                                }
                            },
                            error: function() {
                                console.error("Error en la búsqueda");
                            }
                        });
                    });
                
                    $(document).off('click').on('click', '.suggestion-item', function() {
                        const clienteId = $(this).data('id');
                        TableClienteTemporal(clienteId)
                                                           
                        $('#suggestions-list').hide();
                        $('#InputCiPassaporte').val('');
                    });
                
                    $(document).on('click', function(e) {
                        if (!$(e.target).closest('#suggestions-list').length && !$(e.target).is('#InputCiPassaporte')) {
                            $('#suggestions-list').hide();
                        }
                    });
                });
                
                $('#btn-agregar-pasajero').off('click').on('click', function(event) {
                    event.preventDefault();
                    var data = {
                        Documento_cliente: $('#InputCiPassaporte').val(),
                        Nombre_cliente: $('#InputNombres').val(),
                        Apellido_cliente: $('#InputApellidos').val(),
                        Profesion_cliente: $('#InputProfesion').val(),
                        Nacionalidad_cliente: $('#InputNacionalidad').val(),
                        FechaNacimiento_cliente: $('#InputFechaNacimiento').val(),
                        Edad_cliente: $('#InputEdad').val(),
                        EstadoCivil_cliente: $('#InputEstadoCivil').val(),
                    };
                
                    $.ajax({
                        url: '/apihostal/registrar-cliente-hostal',
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            TableClienteTemporal(response.id)
                            $('#InputCiPassaporte').val('');
                            $('#InputNombres').val('');
                            $('#InputApellidos').val('');
                            $('#InputProfesion').val('');
                            $('#InputNacionalidad').val('');
                            $('#InputFechaNacimiento').val('');
                            $('#InputEdad').val('');
                            $('#InputEstadoCivil').val($('#InputEstadoCivil option:first').val());
                            
                            $('.formulario').addClass('d-none'); 
                        },
                        error: function() {
                            alert("Error al registrar el cliente.");
                        }
                    });
                });

                function TableClienteTemporal(clienteId){
                    $.ajax({
                        url: '/apihostal/get-cliente-hostal-seleccionado/'+clienteId,
                        method: 'GET',
                        success: function(data) {
                            $('#table-pasajeros-temporal tbody').append(`
                                <tr>
                                    <td hidden>${data.id}</td>
                                    <td>${data.Documento_cliente}</td>
                                    <td>${data.NombreCompleto_cliente}</td>
                                    <td>${data.Nacionalidad_cliente}</td>
                                    <td>${data.Profesion_cliente}</td>
                                    <td>${data.Edad_cliente}</td>
                                    <td>${data.EstadoCivil_cliente}</td>
                                    <td><a class="btn-quitar-pasajero" style="cursor: pointer; color: red;">X</a></td>
                                </tr>
                            `);
                        },
                        error: function() {
                            console.error("Error en la búsqueda");
                        }
                    });
                    
                    $(document).on('click', '.btn-quitar-pasajero', function() {
                        $(this).closest('tr').remove();
                    });
                }  
                
                $('#btn-agregar-hospedaje').off('click').on('click', function(event) {
                    event.preventDefault();
                    const IdCliente = []; 
                    const IdHospedaje = response.hospedajehabitacion[0].id;
                    const habitacionId = response.id;

                    $('#table-pasajeros-temporal tbody tr').each(function() {
                        const documento = $(this).find('td').first().text(); 
                        IdCliente.push(documento);
                    });
            
                    const dataToSend = {
                        IdCliente: IdCliente,
                        IdHospedaje: IdHospedaje,
                    };
                    
                    $.ajax({
                        url: '/apihostal/agregar-hospedaje-clientes',
                        method: 'POST',
                        data: dataToSend,
                        success: function(response) {
                            $('#table-pasajeros-temporal tbody').empty();
                            OcupadoHabitacion(habitacionId)
                            MostrarMensaje("Pasajeros Agregados Exitosamente", "success")
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error al recuperar:', textStatus, errorThrown);
                        }
                    });
                });

            });

            //DETALLE HOSPEDAJE INICIO
            $(document).on('click', '#btn-agregar-detalles-hospedaje', function(event) {
                event.preventDefault();
                $('#modaldetallehospedaje').modal('show');
                
                document.getElementById('radio-auto').addEventListener('change', function() {
                    document.getElementById('form-div-auto').hidden = false;
                    document.getElementById('form-div-prestamo').hidden = true;
                });
            
                document.getElementById('radio-prestamo').addEventListener('change', function() {
                    document.getElementById('form-div-auto').hidden = true;
                    document.getElementById('form-div-prestamo').hidden = false;
                });

                
                $('#btn-agregar-detalle').off('click').on('click', function(event) {
                    event.preventDefault();
                    const radios = document.getElementsByName('radios-inline');
                    let selectedValue = null;
                    radios.forEach(function(radio) {
                        if (radio.checked) {
                            selectedValue = radio.value;
                        }
                    });
                    const IdHospedaje = response.hospedajehabitacion[0].id;

                    var data = {
                        selectedValue: selectedValue,
                        PlacaAuto: $('#PlacaAuto').val(),
                        MarcaAuto: $('#MarcaAuto').val(),
                        ColorAuto: $('#ColorAuto').val(),
                        ComentarioAuto: $('#ComentarioAuto').val(),
                        NombreObjetoPrestamo: $('#NombreObjetoPrestamo').val(),
                        ComentarioPrestamo: $('#ComentarioPrestamo').val(),
                        IdHospedaje: IdHospedaje
                    };
                
                    $.ajax({
                        url: '/apihostal/registrar-detalle-hostal',
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            OcupadoHabitacion(habitacionIdPrivate)
                            $('#PlacaAuto').val(""),
                            $('#MarcaAuto').val(""),
                            $('#ColorAuto').val(""),
                            $('#ComentarioAuto').val(""),
                            $('#NombreObjetoPrestamo').val(""),
                            $('#ComentarioPrestamo').val(""),
                            MostrarMensaje("Registrado Exitosamente","success")
                        },
                        error: function() {
                            MostrarMensaje("Placa Repetida","error")
                        }
                    });
                });
            });  
            //DETALLE HOSPEDAJE FIN

            $(document).on('click', '#EditarInformacionHospedaje', function() {
                $('#Div-Informacion-Hospedaje').empty();
                var HabitacionFormEdit = `
                    <h3 class="card-title" style="width: 100%; background:#151f2c; color: white; padding: 8px">HOSPEDAJE</h3>
                    <div class="row" style="background: #FEF9D9; padding: 8px">
                        ${response.hospedajehabitacion[0].CambioDolar &&  response.hospedajehabitacion[0].CambioBolivianos != 0 ? `
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-6 col-form-label" style="font-weight: bold;">DOLAR</label>
                                    <div class="col">
                                        <input class="form-control" value="${response.hospedajehabitacion[0].CambioDolar}" id="UpdateCambioDolar">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-6 col-form-label" style="font-weight: bold;">BOLIVIANO</label>
                                    <div class="col">
                                        <input class="form-control" value="${response.hospedajehabitacion[0].CambioBolivianos}" id="UpdateCambioBolivianos">
                                    </div>
                                </div>                                                                                
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-6 col-form-label" style="font-weight: bold;">PRECIO HABITACION</label>
                                    <div class="col">
                                        <input class="form-control" value="${response.hospedajehabitacion[0].Precio_habitacion}" id="UpdatePrecioHabitacion">
                                    </div>
                                </div>                                                                                
                            </div>
                        ` : 
                        `<div class="col-12 col-sm-6">
                            <div class="mb-3 row">
                                <label class="col-6 col-form-label" style="font-weight: bold;">PRECIO HABITACION</label>
                                <div class="col">
                                    <input class="form-control" value="${response.hospedajehabitacion[0].Precio_habitacion}" id="UpdatePrecioHabitacion">
                                </div>
                            </div>                                                                                
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 row">
                                <label class="col-6 col-form-label" style="font-weight: bold;">DIAS A HOSPEDARSE</label>
                                <div class="col">
                                    <input class="form-control" value="${response.hospedajehabitacion[0].dias_hospedarse}" id="UpdateDiasHospedarse">
                                </div>
                            </div>                                                                                
                        </div>`
                        }

                        
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 row">
                                <label class="col-6 col-form-label" style="font-weight: bold;">TIPO DE HAB</label>
                                <div class="col">
                                    <select class="form-control" id="UpdateCategoriaHabitacion">
                                        <option value="SIMPLE">SIMPLE</option>
                                        <option value="DOBLE">DOBLE</option>
                                        <option value="TRIPLE">TRIPLE</option>
                                        <option value="MATRIMONIAL">MATRIMONIAL</option>
                                    </select>
                                </div>
                            </div>                                        
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 row">
                                <label class="col-6 col-form-label" style="font-weight: bold;">FECHA INGRESO</label>
                                <div class="col">
                                    <input class="form-control" value="${response.hospedajehabitacion[0].ingreso_hospedaje}" id="UpdateFechaIngreso">
                                </div>
                            </div>                                                                                
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 row">
                                <label class="col-6 col-form-label" style="font-weight: bold;">FECHA SALIDA</label>
                                <div class="col">
                                    <input type="date" class="form-control" id="UpdateFechaSalida">
                                </div>
                            </div>
                        </div>
                         <div class="col-12 col-sm-6">
                            <div class="mb-3 row">
                                <label class="col-6 col-form-label" style="font-weight: bold;">PROCEDENTE</label>
                                <div class="col">
                                    <select class="form-control" id="EditProcedencia">
                                        <option value="">Selecciona una ciudad</option>
                                    </select>
                                </div>
                            </div>                                                                                                                      
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3 row">
                                <label class="col-6 col-form-label" style="font-weight: bold;">DESTINO</label>
                                <div class="col">
                                    <select class="form-control" id="EditDestino">
                                        <option value="">Selecciona una ciudad</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12">
                            <div class="card-footer" style="background: #FEF9D9;">
                                <div class="d-flex">
                                <a href="#" class="btn btn-red" id="btn-actualizar-cancelar">Cancel</a>
                                <a href="#" class="btn btn-primary ms-auto" id="btn-actualizar-datos">Actualizar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#Div-Informacion-Hospedaje').append(HabitacionFormEdit);

                const dolarInput = document.getElementById('UpdateCambioDolar');
                const bolivianoInput = document.getElementById('UpdateCambioBolivianos');
                const exchangeRate = 7;
                function convertCurrency(source) {
                    if (!dolarInput || !bolivianoInput) {
                        return;
                    }
                    dolarInput.removeEventListener('input', onDolarInput);
                    bolivianoInput.removeEventListener('input', onBolivianoInput);
                    const dolarValue = parseFloat(dolarInput.value);
                    const bolivianoValue = parseFloat(bolivianoInput.value);
                    if (source === 'dolar' && !isNaN(dolarValue)) {
                        const convertedToBolivianos = (dolarValue * exchangeRate).toFixed(2);
                        bolivianoInput.value = convertedToBolivianos;
                    } else if (source === 'boliviano' && !isNaN(bolivianoValue)) {
                        const convertedToDolares = (bolivianoValue / exchangeRate).toFixed(2);
                        dolarInput.value = convertedToDolares;
                    }
                    dolarInput.addEventListener('input', onDolarInput);
                    bolivianoInput.addEventListener('input', onBolivianoInput);
                }
                function onDolarInput() {
                    convertCurrency('dolar');
                }
                function onBolivianoInput() {
                    convertCurrency('boliviano');
                }
                if (dolarInput) {
                    dolarInput.addEventListener('input', onDolarInput);
                }
                if (bolivianoInput) {
                    bolivianoInput.addEventListener('input', onBolivianoInput);
                }
                

                var categoriaHabitacion = `${response.hospedajehabitacion[0].CategoriaHabitacion}`;
                var fechaCompleta = response.hospedajehabitacion[0].salida_hospedaje;
                var fechaSolo = fechaCompleta.split(' ')[0];

                $('#UpdateFechaSalida').val(fechaSolo);
                document.getElementById('UpdateCategoriaHabitacion').value = categoriaHabitacion;

                var procedenciahabitacion = `${response.hospedajehabitacion[0].procedencia_hospedaje}`;
                TraerDepartamentosProcedenciaEdit(procedenciahabitacion);

                var destinohabitacion = `${response.hospedajehabitacion[0].destino_hospedaje}`;
                TraerDepartamentosDestinoEdit(destinohabitacion);

                $('#btn-actualizar-datos').on('click', function(event) {
                    event.preventDefault();
                    const HospedajeId = response.hospedajehabitacion[0].id;
                    const UpdateCambioDolar = $('#UpdateCambioDolar').val();
                    const UpdateCambioBolivianos = $('#UpdateCambioBolivianos').val();
                    const UpdateCategoriaHabitacion = $('#UpdateCategoriaHabitacion').val();
                    const UpdatePrecioHabitacion = $('#UpdatePrecioHabitacion').val();
                    const UpdateFechaIngreso = $('#UpdateFechaIngreso').val();
                    const UpdateFechaSalida = $('#UpdateFechaSalida ').val();
                    const UpdateDiasHospedarse = $('#UpdateDiasHospedarse ').val();
                    const EditProcedencia = $('#EditProcedencia ').val();
                    const EditDestino = $('#EditDestino ').val();
                    const habitacionId = id;
            
                    const dataToSend = {
                        UpdateCategoriaHabitacion: UpdateCategoriaHabitacion,
                        UpdatePrecioHabitacion: UpdatePrecioHabitacion,
                        UpdateFechaIngreso: UpdateFechaIngreso,
                        UpdateFechaSalida: UpdateFechaSalida,
                        UpdateCambioDolar: UpdateCambioDolar,
                        UpdateCambioBolivianos: UpdateCambioBolivianos,
                        UpdateDiasHospedarse: UpdateDiasHospedarse,
                        EditDestino: EditDestino,
                        EditProcedencia: EditProcedencia,
                        habitacionId: habitacionId,
                        HospedajeId: HospedajeId
                    };
                
                    $.ajax({
                        url: '/apihostal/update-ocupar-habitacion',
                        method: 'POST',
                        data: dataToSend,
                        success: function(response) {
                            OcupadoHabitacion(habitacionId)
                            MostrarMensaje("Habitacion Actualizado Exitosamente", "success")
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error al recuperar:', textStatus, errorThrown);
                        }
                    });
                });
                
                $('#btn-actualizar-cancelar').on('click', function(event) {
                    event.preventDefault();
                    OcupadoHabitacionGrupo(id)
                });

                $('#btn-ocupar-habitacion-cancelar').on('click', function(event) {
                    event.preventDefault();
                    CanvasTime();
                });
            });
            
            ListarConsumo(response)
            //ConsumoHospedaje(response)
            
            
            $('#modal-adelanto').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var hospedajeID = button.data('id');

                $('#btn-registrar-modal-adelanto').data('id', hospedajeID);
            });

            $('#btn-registrar-modal-adelanto').off('click').on('click', function(event) {
                event.preventDefault();
                
                const TipoAdelanto = $('#TipoAdelanto').val();
                const MontoAdelanto = $('#MontoAdelanto').val(); 
                const hospedajeID = $(this).data('id');
                
                const dataToSend = {
                    TipoAdelanto: TipoAdelanto,
                    MontoAdelanto: MontoAdelanto,
                    hospedajeID: hospedajeID,
                };

                $.ajax({
                    url: '/apihostal/registrar-adelanto-hospedaje',
                    method: 'POST',
                    data: dataToSend,
                    success: function(response) {
                        OcupadoHabitacion(hospedajeID); 
                        MostrarMensaje("Consumo Pagado Exitosamente", "success");
                        $('#MontoAdelanto').val('');
                        $('#TipoAdelanto').val($('#TipoAdelanto option:first').val());
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error al recuperar:', textStatus, errorThrown);
                    }
                });
            });

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al ocupar la habitación:', textStatus, errorThrown);
        }
    });

    function llenarTablaClientes(habitacion) {
        $('#table-pasajeros tbody').empty();
        
        habitacion.hospedajehabitacion.forEach(function(hospedaje) {
            hospedaje.detallehospedajes.forEach(function(detalle) {
                var cliente = detalle.cliente;
                if (cliente) {
                    var fila = `
                        <tr>
                            <td class="detalle-hospedaje-id" hidden>${detalle.id || ''}</td>
                            <td>${cliente.Documento_cliente || ''}</td>
                            <td>${cliente.NombreCompleto_cliente || ''}</td>
                            <td>${cliente.Nacionalidad_cliente || ''}</td>
                            <td>${cliente.Profesion_cliente || ''}</td>
                            <td>${cliente.Edad_cliente || ''}</td>
                            <td>${cliente.EstadoCivil_cliente || ''}</td>
                            <td><a class="btn-eliminar-pasajero" style="cursor: pointer; color: red;">X</a></td>
                        </tr>
                    `;
                    $('#table-pasajeros tbody').append(fila);
                }
            });
        });              
    }
    
    function llenarTablaServicios(habitacion) {
        // Vaciar ambas tablas
        $('#table-servicios-desayuno tbody').empty();
        $('#table-servicios-lavado tbody').empty();

        // Ocultar ambos contenedores al principio
        $('#containertabledesayuno').attr('hidden', true);
        $('#containertablelavado').attr('hidden', true);

        let tieneDesayuno = false;
        let tieneLavado = false;

        habitacion.hospedajehabitacion.forEach(function(hospedaje) {
            hospedaje.servicios.forEach(function(servicio) {
                servicio.detalleservicio.forEach(function(detalle) {
                    if (detalle) {
                        if (detalle.TipoServicio === "Desayuno") {
                            tieneDesayuno = true; // Se encontró un desayuno
                            
                            var fila = `
                                <tr>
                                    <td class="servicio-hospedaje-id" hidden>${detalle.id || ''}</td>
                                    <td>
                                        ${detalle.pagado === 'true' 
                                            ? '<span class="badge badge-outline text-green">SI</span>' 
                                            : `<span class="badge badge-outline text-red">NO</span>`}
                                    </td>
                                    <td>${formatearFecha(detalle.created_at) || ''}</td>
                                    <td>${detalle.comentario || ''}</td>
                                    <td>${detalle.cantidad || ''}</td>
                                    <td>${detalle.precio || ''}</td>
                                    <td>${detalle.total || ''}</td>
                                    <td>
                                        ${detalle.pagado === 'true' 
                                            ? `<strong>${detalle.tipopago}</strong>` 
                                            : `<a class="badge bg-blue text-blue-fg" id="btn-pagar-servicio-desayuno" data-bs-toggle="modal" data-bs-target="#Modal-Pagar-Desayuno" style="cursor: pointer;" title="Pagar servicio de desayuno" data-id="${detalle.id}">Pagar</a>`}
                                    </td>
                                </tr>
                            `;
                            $('#table-servicios-desayuno tbody').append(fila);
                            $('#total-servicio-desayuno-subtotal').text(servicio.subTotalDesayuno);
                            $('#total-servicio-desayuno-pagado').text(servicio.totalpagadoDesayuno);
                            $('#total-servicio-desayuno-total').text(servicio.totalDesayuno);

                            
                        } else if (detalle.TipoServicio === "Lavado") {
                            tieneLavado = true;
                            
                            var fila = `
                                <tr>
                                    <td class="servicio-hospedaje-id" hidden>${detalle.id || ''}</td>
                                    <td>
                                        ${detalle.lavado === 'Entregado' 
                                            ? '<span class="badge bg-success">Entregado</span>' 
                                            : `<span class="badge bg-danger btn-entregar-lavado" data-id="${detalle.id}">No Entregado</span>`}
                                    </td>
                                    <td>
                                        ${detalle.pagado === 'true' 
                                            ? '<span class="badge badge-outline text-green">SI</span>' 
                                            : `<span class="badge badge-outline text-red">NO</span>`}
                                    </td>
                                    <td>${formatearFecha(detalle.created_at) || ''}</td>
                                    <td>${detalle.comentario || ''}</td>
                                    <td>${detalle.cantidad || ''}</td>
                                    <td>${detalle.precio || ''}</td>
                                    <td>${detalle.total || ''}</td>
                                    <td>
                                        ${detalle.pagado === 'true' 
                                            ? `<strong>${detalle.tipopago}</strong>` 
                                            : `<a class="badge bg-blue text-blue-fg" id="btn-pagar-servicio-lavado" data-bs-toggle="modal" data-bs-target="#Modal-Pagar-Lavado" style="cursor: pointer;" title="Pagar servicio de desayuno" data-id="${detalle.id}">Pagar</a>`}
                                    </td>
                                </tr>
                            `;
                            $('#table-servicios-lavado tbody').append(fila);
                            $('#total-servicio-lavado-subtotal').text(servicio.subTotalLavado);
                            $('#total-servicio-lavado-pagado').text(servicio.totalpagadoLavado);
                            $('#total-servicio-lavado-total').text(servicio.totalLavado);
                        }
                    }
                });
            });
        });

        // Mostrar el contenedor correspondiente si se han encontrado servicios
        if (tieneDesayuno) {
            $('#containertabledesayuno').removeAttr('hidden'); // Mostrar tabla de desayuno
        }

        if (tieneLavado) {
            $('#containertablelavado').removeAttr('hidden'); // Mostrar tabla de lavado
        }
    }

    function llenarTablaConsumos(habitacion) {
        $('#table-consumos tbody').empty();
        $('#containertableconsumo').attr('hidden', false);
    
        habitacion.hospedajehabitacion.forEach(function(hospedaje) {
            hospedaje.servicioconsumos.forEach(function(servicioconsumo) {
                servicioconsumo.consumo.forEach(function(dataconsumo) {
                    let detalleConsumoHtml = '';
                    
                    dataconsumo.detalleconsumos.forEach(function(detalleconsumo) {
                        detalleConsumoHtml += `
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    ${detalleconsumo.producto.NombreProducto || ''} 
                                </div>
                                <div class="col-12 col-sm-3">
                                    ${detalleconsumo.precio || ''} 
                                </div>
                                <div class="col-12 col-sm-1">
                                    ${detalleconsumo.cantidad || ''} 
                                </div>
                                <div class="col-12 col-sm-4">
                                    <strong>${detalleconsumo.total || ''}</strong>
                                </div>
                            </div>
                        `;
                    });
    
                    let pagoHtml = '';
                    if (dataconsumo.pagosconsumos && dataconsumo.pagosconsumos.length > 0) {
                        const pago = dataconsumo.pagosconsumos[0];
                        pagoHtml = `
                            <span>${pago.TipoPago}</span>
                        `;
                    } else {
                        pagoHtml = `
                            <a class="badge bg-blue text-blue-fg" id="btn-pagar-consumo" data-bs-toggle="modal" data-bs-target="#ModalCerrarConsumoHabitacion" style="cursor: pointer;" title="Pagar Consumo" data-id="${dataconsumo.id}">Pagar</a>
                        `;
                    }
    
                    var fila = `
                        <tr>
                            <td class="servicio-hospedaje-id" hidden>${dataconsumo.id || ''}</td>
                            <td>
                                ${dataconsumo.ocupado === 'false' 
                                    ? '<span class="badge badge-outline text-green">SI</span>' 
                                    : '<span class="badge badge-outline text-red">NO</span>'}
                            </td>
                            <td style="width: 130px">${formatearFecha(dataconsumo.created_at) || ''}</td>
                            <td>${detalleConsumoHtml}</td>
                            <td>${dataconsumo.total || ''}</td>
                            <td>${pagoHtml}</td>
                        </tr>
                    `;
    
                    $('#table-consumos tbody').append(fila);
                    $('#total-consumo-subtotal').text(servicioconsumo.subTotal);
                    $('#total-consumo-pagado').text(servicioconsumo.totalpagado);
                    $('#total-consumo-total').text(servicioconsumo.total);
                });
            });
        });
    }

    function ListarConsumo(response) {
        $('#div-consumos-hmtl').empty();
        var IdHospedaje = response.hospedajehabitacion[0].id

        var ConsumoForm = `
            <div class="card-body" style="padding: 0px; margin: 0px;">
                <div class="col-md-12" style="padding: 0px; margin: 0px;">
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary" id="btn-agregar-consumo">+ Agregar Nuevo Consumo</button>
                    </div>
                    <div class="card-body">
                        <div class="row" id="ListConsumosHospedaje">
                        
                        </div>
                        <br><br>
                        <div class="row" id="SelectConsumosHospedaje">
                        
                        </div>
                    </div>
                </div>
            </div>                   
        `;
        $('#div-consumos-hmtl').append(ConsumoForm);

        $('#btn-agregar-consumo').off('click').on('click', function(event) {
            event.preventDefault();
            const dataToSend = {
                IdHospedaje: IdHospedaje
            };

            $.ajax({
                url: '/apihostal/registrar-consumo-hospedaje',
                method: 'POST',
                data: dataToSend,
                success: function(response) {
                    TablaListConsumos(IdHospedaje)
                    MostrarMensaje("Habitacion Actualizado Exitosamente", "success")
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error al recuperar:', textStatus, errorThrown);
                }
            });
        });

        TablaListConsumos(IdHospedaje)

    }
    
    function TablaListConsumos(IdHospedaje) {
        $.ajax({
            url: '/apihostal/get-consumo-hospedaje/' + IdHospedaje,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var consumos = response.servicioconsumos;
                var html = '';
                $('#ListConsumosHospedaje').empty();
    
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
                                        <button class="badge bg-blue-lt btn-mostrar-consumo-hospedaje" data-id="${consumo.id}">Mostrar ID Consumo</button>
                                    </div>
                                </div>
                            </div>
                        `;
                
                        $('#ListConsumosHospedaje').append(ConsumoForm);
                    });
                });
    
                $('#ListConsumosHospedaje').off('click', '.btn-mostrar-consumo-hospedaje').on('click', '.btn-mostrar-consumo-hospedaje', function() {
                    var consumoId = $(this).data('id');
                    ConsumoHospedaje(consumoId);
                });
    
                $('#ListConsumosHospedaje').off('click', '.eliminar-consumo-cero').on('click', '.eliminar-consumo-cero', function(event) {
                    event.preventDefault();
                    var consumoId = $(this).data('id');
                    $.ajax({
                        url: '/apihostal/consumo-hospedaje-delete/' + consumoId,
                        type: 'DELETE',
                        success: function(result) {
                            MostrarMensaje("Eliminado Exitosamente", "success");
                            TablaListConsumos(IdHospedaje);
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
    
    function ConsumoHospedaje(consumoId) {
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
                                        url: '/apihostal/registrar-detalle-consumo-hospedaje',
                                        type: 'POST',
                                        contentType: 'application/json',
                                        data: JSON.stringify(productosParaGuardar),
                                        success: function (response) {      
                                            btnGuardar.style.display = 'none';
                                            MostrarMensaje("Producto Agregado", "success");
                                            DivPedidos.innerHTML = '';
                                            AddProduct = document.getElementById('DivAddProduct');
                                            AddProduct.innerHTML = '';
                                            productosSeleccionados = [];
                                            agregarDetallesConsumo(consumoId);
                                            DivTotalConsumo(consumoId);
                                            OcupadoHabitacionGrupo(id)
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
                                                    <input type="text" name="CantProduct" class="form-control CantProduct" value="${producto.Cantidad || 1}" style="padding: 0px; text-align: center;" id="divInput" disabled>
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
                                                <button type="button" class="btn btn-primary" id="btnPorcentaje" data-id="${IdConsumo}" style="text-align: center; padding: 0px; margin: 0px; padding-left: 6px; padding-right: 6px">
                                                    <span style="font-size: 20px; font-weight: bold;">%</span>
                                                </button>
            
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#ModalCerrarConsumoHabitacion" class="btn btn-danger" data-id="${IdConsumo}" id="btnCerrarConsumo">Cerrar Consumo</button>
                                            </div>
                                        `;
            
                                        // Vuelve a asignar el controlador de eventos al botón de porcentaje
                                        document.getElementById('btnPorcentaje').onclick = DescuentoDiv;
                                        document.getElementById('btnCerrarConsumo').onclick = guardarCambios;
            
                                        function guardarCambios() {
                                            var btnCerrarConsumo = $('#btnCerrarConsumo');
                                            $('#btn-confirmar-modal-consumo').off('click').on('click', function(event) {
                                                event.preventDefault();
                                                const ModalConsumoTipoPagoSelect = $('#ModalConsumoTipoPagoSelect').val();
                                                var id = btnCerrarConsumo.data('id');
                                        
                                                const dataToSend = {
                                                    ModalConsumoTipoPagoSelect: ModalConsumoTipoPagoSelect,
                                                    id: id,
                                                };
                                            
                                                $.ajax({
                                                    url: '/apihostal/cerrar-consumo-habitacion-postenvio',
                                                    method: 'POST',
                                                    data: dataToSend,
                                                    success: function(response) {
                                                        OcupadoHabitacion(habitacionIdPrivate)
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

    function TraerDepartamentosProcedenciaEdit(procedenciahabitacion) {
        const jsonUrl = '/utilidades/json/departamentos.json';
        const procedenciaSelect = $('#EditProcedencia');
    
        $.ajax({
            url: jsonUrl,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                procedenciaSelect.empty();
                procedenciaSelect.append('<option value="">Selecciona una ciudad</option>');
                $.each(data, function(departmentKey, department) {
                    const departmentOption = $('<option>', {
                        value: department.name,
                        text: department.name
                    });
                    procedenciaSelect.append(departmentOption);
                    $.each(department.ciudades, function(index, city) {
                        const cityOption = $('<option>', {
                            value: city.name,
                            text: ` ${city.name}` 
                        });
                        procedenciaSelect.append(cityOption);
                    });
                });
                procedenciaSelect.select2({
                    placeholder: 'Selecciona una ciudad',
                    allowClear: true,
                    width: '100%',
                });
                if (procedenciahabitacion) {
                    procedenciaSelect.val(procedenciahabitacion).trigger('change');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar el archivo JSON:', textStatus);
            }
        });
    }

    function TraerDepartamentosDestinoEdit(destinohabitacion) {
        const jsonUrl = '/utilidades/json/departamentos.json';
        const destinoSelect = $('#EditDestino');
    
        $.ajax({
            url: jsonUrl,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                destinoSelect.empty();
                destinoSelect.append('<option value="">Selecciona una ciudad</option>');
                $.each(data, function(departmentKey, department) {
                    const departmentOption = $('<option>', {
                        value: department.name,
                        text: department.name
                    });
                    destinoSelect.append(departmentOption);
                    $.each(department.ciudades, function(index, city) {
                        const cityOption = $('<option>', {
                            value: city.name,
                            text: ` ${city.name}` 
                        });
                        destinoSelect.append(cityOption);
                    });
                });
                destinoSelect.select2({
                    placeholder: 'Selecciona una ciudad',
                    allowClear: true,
                    width: '100%',
                });
                if (destinohabitacion) {
                    destinoSelect.val(destinohabitacion).trigger('change');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar el archivo JSON:', textStatus);
            }
        });
    }
}

    