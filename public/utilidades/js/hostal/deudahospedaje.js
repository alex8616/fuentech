
$(document).ready(function() {
    mostrarResultadosDeudas()
});

function mostrarResultadosDeudas() {    
    $.ajax({
        url: '/apihostal/pendiente-habitacion-hospedaje-get',
        type: 'GET',
        dataType: 'json',
        success: function(deudas) {
            $('#tabla-Deudas tbody').empty();
            $.each(deudas, function(index, deuda) {
                var clientes = deuda.detallehospedajes.map(function(detalle) {
                    return detalle.cliente.NombreCompleto_cliente;
                }).join('<br>');

                var ingresoFecha = deuda.ingreso_hospedaje.split(' ')[0]; 
                var salidaFecha = deuda.salida_hospedaje.split(' ')[0];

                var row = '<tr>' +
                    '<td hidden>' + deuda.id + '</td>' +
                    '<td style="font-weight: bold;">' + deuda.CodigoHospedaje + '</td>' +
                    '<td style="font-weight: bold;">' + "Habitación #" + deuda.habitacion_id + '</td>' +
                    '<td style="font-weight: bold;">' + clientes + '</td>' +
                    '<td style="font-weight: bold;">' + ingresoFecha + '</td>' +
                    '<td style="font-weight: bold;">' + salidaFecha + '</td>' +
                    '<td style="font-weight: bold;">' + deuda.Total + '</td>' +
                '</tr>';

                $('#tabla-Deudas tbody').append(row);
            });

            $('#tabla-Deudas tbody').on('click', 'tr', function() {
                $('#tabla-Deudas tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');
                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/apihostal/get-grupo-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionDeuda(id);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de la grupo:', error);
                    }
                });
            });
        },
        error: function(error) {
            console.error('Error al recuperar datos de la grupo:', error);
        }
    });

    
}

function InformacionDeuda(id){
    $.ajax({
        url: '/apihostal/pendiente-habitacion-hospedaje-select/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#form_tabs').empty();
            var hospedajeIdPrivateDeuda = response.hospedajehabitacion[0].id

            let tablaadelantosDeuda = '';
            let tablaadelantossumDeuda = '';
            let adelantosDeuda = response.hospedajehabitacion[0].adelantos;

            if (adelantosDeuda.length > 0) {
                adelantosDeuda.forEach(function(adelanto) {
                    tablaadelantosDeuda += `
                        <tr>
                            <td>${adelanto.FechaDeAdelanto || ''}</td>
                            <td>${adelanto.TipoAdelanto || ''}</td>
                            <td>${adelanto.TotalAdelanto || ''}</td>
                        </tr>
                    `;
                });

                tablaadelantossumDeuda += `
                    <tr style="background: #EAEAEA">
                        <th colspan="2" style="text-align: right">Sumatoria: </th>
                        <th>${response.hospedajehabitacion[0].Adelanto || ''}</th>
                    </tr>
                `;
            } else {
                tablaadelantosDeuda += `
                    <tr>
                        <td colspan="3">No Existe Adelantos</td>
                    </tr>
                `;
            }

            let tablaautosDeuda = '';
            let autosDeuda = response.hospedajehabitacion[0].autos;

            if (autosDeuda.length > 0) {
                autosDeuda.forEach(function(auto) {
                    tablaautosDeuda += `
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

            let tablaprestamosDeuda = '';
            let prestamosDeuda = response.hospedajehabitacion[0].prestamos;

            if (prestamosDeuda.length > 0) {
                prestamosDeuda.forEach(function(prestamo) {
                    tablaprestamosDeuda += `
                        <tr>
                            <td>${prestamo.nombre_objeto || ''}</td>
                            <td>${prestamo.comentario    || ''}</td>
                            <td>${prestamo.fecha_venta || ''}</td>
                        </tr>
                    `;
                });
            }           

            var HabitacionFormDeuda = `
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
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tabs-hospedaje-habitacion" role="tabpanel">
                                    <div class="datagrid" style="background: white">
                                        <div class="row">                                            
                                            <div class="col-12 col-sm-12">
                                                <div class="mb-3 row">
                                                    <div class="card-header" style="width: 100%; background-color: #151f2c; color: white">
                                                        <h3 class="card-title">PASAJEROS</h3>
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
                                                        HOSPEDAJE
                                                    </h3>
                                                    <div class="ms-auto">
                                                        <h3 class="card-title" style="font-size: 25px; color: red">${response.hospedajehabitacion[0].TotalHospedaje}</h3>
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
                                                                                ${tablaautosDeuda}
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
                                                                                ${tablaprestamosDeuda}
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
                                                                <div class="mb-3">
                                                                    <div class="card">
                                                                        <div class="card-body" style="margin: 6px; padding: 6px">
                                                                            <div class="card-header" style="width: 100%; margin: 5px; padding: 5px">  
                                                                                <h3 class="card-title">ADELANTOS</h3>
                                                                            </div>
                                                                            <table class="table table-sm table-borderless" id="tabla-adelantosDeuda">
                                                                                <tbody>
                                                                                    ${tablaadelantosDeuda}
                                                                                </tbody>
                                                                                <tfoot>
                                                                                    ${tablaadelantossumDeuda}
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
                                                                                    <td colspan="2" style="text-align: right; padding-right: 20px; width: 90%">TOTAL HOSPEDAJE</th>
                                                                                    <td style="text-align: left; padding-left: 20px" id="TotalHospedajeValor"></td>
                                                                                </tr>
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
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" id="btn-pagar-deuda-hospedaje" data-bs-toggle="modal" data-bs-target="#modal-concluir-deuda-hospedaje">PAGAR DEUDA</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>                    
                </div>

            `;
            $('#form_tabs').append(HabitacionFormDeuda);            
            
            $('#TotalHospedajeValor').text(response.hospedajehabitacion[0].TotalHospedaje);
            $('#TotalServiciosValor').text(response.hospedajehabitacion[0].TotalServicio);
            $('#TotalConsumosValor').text(response.hospedajehabitacion[0].TotalConsumo);
            $('#TotalHospedajeSubTotalValor').text(response.hospedajehabitacion[0].SubTotal);
            $('#TotalHospedajeAdelantoValor').text(response.hospedajehabitacion[0].Adelanto);
            $('#TotalHospedajeGeneralValor').text(response.hospedajehabitacion[0].Total);
            
            InputNumberConver()
            InputDateConver()

            let hospedajeHabitacionDeuda = response.hospedajehabitacion[0];
            let detallesHospedajesDeuda = hospedajeHabitacionDeuda.detallehospedajes;
            let botonConcluirHospedajeDeuda = document.getElementById('btn-pagar-deuda-hospedaje');

            if (detallesHospedajesDeuda.length > 0 && response.hospedajehabitacion[0].TotalHospedaje > 0) {
                botonConcluirHospedajeDeuda.removeAttribute('disabled');
            } else {
                botonConcluirHospedajeDeuda.setAttribute('disabled', 'disabled');
            }

            function llenarTablaClientesDeuda(habitacion) {
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
            
            function llenarTablaServiciosDeuda(habitacion) {
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

            function llenarTablaConsumosDeuda(habitacion) {
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

            function ListarConsumoDeuda(response) {
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
                            TablaListConsumosDeuda(IdHospedaje)
                            MostrarMensaje("Habitacion Actualizado Exitosamente", "success")
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error al recuperar:', textStatus, errorThrown);
                        }
                    });
                });
        
                TablaListConsumosDeuda(IdHospedaje)
        
            }

            function TablaListConsumosDeuda(IdHospedaje) {
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
                                    TablaListConsumosDeuda(IdHospedaje);
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

            $('#btn-pagar-deuda-hospedaje').off('click').on('click', function(event) {
                event.preventDefault();
                
                $('#modal-concluir-deuda-hospedaje').on('hidden.bs.modal', function () {
                    $('#ListPagosDeuda').empty();
                    var DivMostradorListPagos = document.getElementById('MostradorListPagosDeuda');
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
                    $('#MostradorlistVueltoDeuda').html('<span>Cambio: 0.00</span>');
                    $('#btnConfirmarPagoDeuda').prop('disabled', true);
                });
                
                //hospedajeIdPrivateDeuda
                // Mostrar detalleconsumos en listConsumo
                var DivMostradorListPagos = document.getElementById('MostradorListPagosDeuda');
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
                
                $('#MostradoraddPagosDeuda').off('click').on('click', function () {
                    // Crear el contenido que se va a agregar
                    var nuevoPago = $('<div style="padding: 4px; margin: 4px"></div>').html(`
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="form-control" id="TipoPagoDeuda">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Deposito/QR">Deposito/QR</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control moneda" id="TipoMonedaPagoDeuda">
                                    <option value="Bs">Bs.</option>
                                    <option value="Dolar">$</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control montoPagoInput" id="MontoPagoDeuda" style="width: 100%; display: inline-block;">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn position-relative btnEliminarPagoDeuda" type="button">x</button>
                            </div>
                        </div>
                    `);

                    $('#ListPagosDeuda').append(nuevoPago);

                    nuevoPago.find('.btnEliminarPagoDeuda').off('click').on('click', function () {
                        $(this).closest('.row').parent().remove();
                        calcularYMostrarCambio();
                    });

                    nuevoPago.find('.montoPagoInput').off('input').on('input', function () {
                        calcularYMostrarCambio();
                    });

                    calcularYMostrarCambio();
                });



                var primerPagoDeuda = document.createElement('div');
                primerPagoDeuda.innerHTML = `
                    <div style="padding: 4px; margin: 4px">
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="form-control" id="TipoPagoDeuda">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Deposito/QR">Deposito/QR</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control moneda" id="TipoMonedaPagoDeuda">
                                    <option value="Bs">Bs.</option>
                                    <option value="Dolar">$</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control montoPagoInput" value="${response.hospedajehabitacion[0].Total}" id="MontoPagoDeuda" style="width: 100%; display: inline-block;">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn position-relative btnEliminarPagoDeuda" type="button">x</button>
                            </div>
                        </div>                        
                    </div>
                `;

                document.getElementById('ListPagosDeuda').appendChild(primerPagoDeuda);

                primerPagoDeuda.querySelector('.montoPagoInput').addEventListener('input', function () {
                    calcularYMostrarCambio();
                });

                calcularYMostrarCambio();

                function calcularYMostrarCambio() {
                    var elementosPagos = document.querySelectorAll('#ListPagosDeuda > div');
                
                    var totalPagos = 0;
                    elementosPagos.forEach(function (elementoPago) {
                        var montoPago = parseFloat(elementoPago.querySelector('.montoPagoInput').value) || 0;
                        var tipoMoneda = elementoPago.querySelector('#TipoMonedaPagoDeuda').value;
                
                        // Si la moneda es Dólar, multiplicar por 7
                        if (tipoMoneda === 'Dolar') {
                            montoPago *= 7;
                        }
                
                        totalPagos += montoPago;
                    });
                
                    var limitePago = parseFloat(response.hospedajehabitacion[0].Total) || 0;
                    var cambio = totalPagos - limitePago;
                
                    var listVuelto = document.getElementById('MostradorlistVueltoDeuda');
                    listVuelto.innerHTML = `
                        <span>Cambio: ${cambio.toFixed(2)}</span>
                    `;
                    actualizarEstadoBoton(cambio);
                }

                function actualizarEstadoBoton(cambio) {
                    var btnConfirmarPagoDeuda = document.getElementById('btnConfirmarPagoDeuda');
                }

                $('#btnConfirmarPagoDeuda').off('click').on('click', function (event) {
                    $(this).prop('disabled', true);
                    event.preventDefault();
                    var elementosPagos = $('#ListPagosDeuda > div');
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
                        url: '/apihostal/concluir-deuda-hospedaje-cerrar/' + hospedajeIdPrivateDeuda,
                        type: 'POST',
                        data: {
                            _token: token,
                            pagos: pagos,
                        },
                        success: function (data) {
                            MostrarHabitaciones();
                            mostrarResultadosDeudas();
                            CanvasTime();
                            MostrarMensaje("Hospedaje Concluida Exitosamente", "success")                     
                        },
                        error: function (error) {
                            MostrarMensaje("No ce puedo concluir", "error");
                        },
                        complete: function() {
                            $('#btnConfirmarPagoDeuda').prop('disabled', false);
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

            function calcularTotalDeuda() {
                var cantidad = parseFloat($('#InputCantidadDesayuno').val()) || 0;
                var precio = parseFloat($('#InputPrecioDesayuno').val()) || 0;
                var total = cantidad * precio;
                $('#InputTotalDesayuno').val(total.toFixed(2));
            }
        
            $('#InputCantidadDesayuno, #InputPrecioDesayuno').on('input', function() {
                calcularTotalDeuda();
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
                        OcupadoHabitacion(id)
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
                        OcupadoHabitacion(id)
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
                    llenarTablaConsumosDeuda(response)
                    
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
                                    OcupadoHabitacion(id); 
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
                    llenarTablaClientesDeuda(response);
                    
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
                                OcupadoHabitacion(id)
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
                    llenarTablaServiciosDeuda(response);
                    
                    
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
                                        OcupadoHabitacion(id); // Recarga la información de la habitación
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
                    OcupadoHabitacion(id)
                });

                $('#btn-ocupar-habitacion-cancelar').on('click', function(event) {
                    event.preventDefault();
                    CanvasTime();
                });
            });
            
            ListarConsumoDeuda(response)
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
        error: function(error) {
            console.error('Error al recuperar datos de la grupo:', error);
        }
    });    
}

function agregarEventosGrupoTabla() {
    $('#tabla-reserva tbody tr').hover(function() {
        $(this).addClass('hovered');
    }, function() {
        $(this).removeClass('hovered');
    });
    $('#tabla-reserva tbody tr').click(function() {
        $('#tabla-reserva tbody tr').removeClass('tableproducseleccionado');
        $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
    });
}



