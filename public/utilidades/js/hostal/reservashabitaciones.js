let calendar;

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const formTabs = document.getElementById('form_tabs');

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: async function(fetchInfo, successCallback, failureCallback) {
            try {
                const response = await fetch('/apihostal/get-datos-reservas-habitaciones');
                const data = await response.json();

                const events = data.map(reserva => {
                    const endDate = new Date(reserva.salida_reserva);
                    endDate.setDate(endDate.getDate() + 1);

                    return {
                        id: reserva.id,
                        title: `${reserva.ComentarioReserva} - ${reserva.CategoriaHabitacion} (${reserva.CantidadPersonas} personas)`,
                        start: reserva.ingreso_reserva,
                        end: endDate.toISOString().split('T')[0],
                        color: getColorByEstado(reserva.EstadoReserva),
                    };
                });

                successCallback(events);
            } catch (error) {
                console.error('Error al cargar los eventos:', error);
                failureCallback(error);
            }
        },
        eventClick: function(info) {
            $.ajax({
                url: '/apihostal/get-reserva-seleccionado/' + info.event.id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    InformacionReserva(data);
                },
                error: function(error) {
                    console.error('Error al recuperar datos de la reserva:', error);
                }
            });
        },
        noEventsText: 'No hay reservas para mostrar'
    });

    calendar.render();
});


function getColorByEstado(estado) {
    switch(estado) {
        case 'En Espera':
            return '#FFA500'; // Naranja
        case 'Concluido':
            return '#28a745'; // Verde
        case 'Cancelado':
            return '#dc3545'; // Rojo
        default:
            return '#007bff'; // Azul (por defecto en caso de que el estado no sea reconocido)
    }
}


function InformacionReserva(data){
    var TotalProduct = document.getElementById('form_tabs');
    
    let divadelantos = '';
    let adelantos = data[0].hospedajehabitacion.adelantos;
    let estado = data[0].EstadoReserva;

    
    if (adelantos) {
        adelantos.forEach(function(adelanto) {
            divadelantos += `
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label class="col-12 col-form-label" style="color: #61677A">${adelanto.FechaDeAdelanto || ''} </label>                       
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="col-12 col-form-label" style="color: #61677A">${adelanto.TipoAdelanto || ''}</label>                        
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="col-12 col-form-label" style="color: #61677A">${adelanto.TotalAdelanto || ''}</label>                        
                    </div>
                </div>
            `;
        });
        if(estado === "En Espera"){
            divadelantos += `
                <div class="row">
                    <div class="col-12 col-md-12">                               
                        <label class="col-8 col-form-label" style="color: #61677A"><a class="form-controll" id="btn-registrar-adelanto-nuevo">Agregar Adelantos</a></label>
                    </div>
                </div>
            `;
        }    
    }
    
    TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">CODIGO DE RESERVA ${data[0].CodigoReserva}</h3>
                    <div class="card-actions">
                        <a href="#" class="btn" data-reserva-id="${data.id}" id="Editar-reserva">
                            Asignar Habitacion
                        </a>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row" id="edit-div">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Codigo Reserva</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].CodigoReserva}</label>
                                </div>
                            </div>
                            ${data[0].hospedajehabitacion.habitacion_id != null ? `
                                <div class="mb-12 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold">Habitacion</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #61677A">${data[0].hospedajehabitacion.habitacion_id}</label>
                                    </div>
                                </div>
                            ` : ''}                            
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Check-in</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].ingreso_reserva}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Check-out</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].salida_reserva}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].ComentarioReserva}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Cantidad Personas</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].CantidadPersonas} </label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Tipo De Habitacion</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].CategoriaHabitacion} </label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                ${data[0].hospedajehabitacion.habitacion_id !== null
                                    ? `<label class="col-12 col-form-label" style="font-weight: bold; color: blue; font-size: 15px">HABITACION #${data[0].hospedajehabitacion.habitacion_id} ASIGNADA </label>`
                                    : `<label class="col-12 col-form-label" style="font-weight: bold; color: red; font-size: 15px">SIN HABITACION ASIGNADA </label>`
                                }
                            </div>

                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Adelantos</label>
                                <div class="col">
                                    ${divadelantos}
                                </div>
                            </div>
                            <div class="mb-12 row">
                                 <div class="col">
                                    <div class="row">
                                        <div class="col-sm-12" id="form-nuevo-adelanto">
                                           
                                        </div>
                                        <div class="col-sm-12" id="form-nuevo-adelanto">
                                            <button id="btn-enviar-adelantos" class="btn btn-primary" style="display: none">Enviar Adelantos</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ${data[0].EstadoReserva == "Cancelado" ? `
                                <div class="mb-12 row" style="background: #FE0000">
                                    <label class="col-4 col-form-label" style="font-weight: bold; color: white">Cancelado Por</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: white">${data[0].ComentarioCancelado} </label>
                                    </div>
                                </div>
                            ` : ''}
                             ${data[0].EstadoReserva == "En Espera" ? `
                                <div class="mb-12 row">
                                    <div class="card-footer">
                                        <div class="mb-12 row">
                                            <div class="d-flex justify-content-between w-100">
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-cancelar-reserva">CANCELAR RESERVA</button> 
                                                <button type="button" class="btn btn-primary" id="btn-concluir-reserva" disabled>CONCLUIR RESERVA</button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        verificarFechaHabilitarBoton(data[0].ingreso_reserva, '#btn-concluir-reserva');
        
        function verificarFechaHabilitarBoton(ingresoReserva, botonId) {
            const fechaIngreso = new Date(ingresoReserva);
            const fechaActual = new Date();
    
            if (fechaActual >= fechaIngreso && data[0].hospedajehabitacion.habitacion_id != null) {
                $(botonId).removeAttr('disabled');
            }
        }

        $('#btn-concluir-reserva').off('click').on('click', function(event) {
            event.preventDefault();
            const id = data[0].id;
            $.ajax({
                url: '/apihostal/concluir-reserva-habitacion/'+id,
                method: 'GET',
                success: function(data) {
                    MostrarHabitaciones();
                    CanvasTime();
                    MostrarMensaje("Reserva Concluida Exitosamente", "success");
                    if (calendar) {
                        calendar.refetchEvents();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {                        
                    MostrarMensaje("No se registró la reserva", "error");
                }
            });
        });

        $('#btn-cancelar-reserva').off('click').on('click', function(event) {
            event.preventDefault();
            const id = data[0].id;
            
            const Textrazoncancelar = $('#Textrazoncancelar').val();

            const dataToSend = {
                id: id,
                Textrazoncancelar: Textrazoncancelar,
            };

            $.ajax({
                url: '/apihostal/cancelar-reserva-habitacion',
                method: 'POST',
                data: dataToSend,
                success: function(response) {
                    MostrarHabitaciones();
                    CanvasTime();
                    MostrarMensaje("Reserva Concluida Exitosamente", "success");
                    if (calendar) {
                        calendar.refetchEvents();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    MostrarMensaje("No se registró la reserva", "error");
                }
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
            TraerHabitaciones();

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
                        InformacionReserva(data)
                        MostrarMensaje("Actualizado Exitosamente", "success");
                        if (calendar) {
                            calendar.refetchEvents();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {                        
                        MostrarMensaje("No se registró la reserva", "error");
                    }
                });
            });
        });

        // Agregar nuevo formulario
        $('#btn-registrar-adelanto-nuevo').off('click').on('click', function(event) {
            event.preventDefault();
            var uniqueId = new Date().getTime();
            var formularioHtml = `
                <div id="form-adelanto-${uniqueId}" class="mb-3">
                    <form>
                        <div class="row" style="background: #FFEEAD; padding: 10px">
                            <div class="col-sm-4">
                                <select class="form-control" id="TipoPago-${uniqueId}">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Deposito/QR">Deposito/QR</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control moneda" id="TipoMonedaPago-${uniqueId}">
                                    <option value="Bs">Bs.</option>
                                    <option value="Dolar">$</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control montoPagoInput" id="MontoPago-${uniqueId}" style="width: 100%; display: inline-block;">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-danger btnEliminarPago" type="button" data-id="${uniqueId}">X</button>
                            </div>
                        </div>
                    </form>
                </div>
            `;
            
            $('#form-nuevo-adelanto').append(formularioHtml);
            toggleEnviarAdelantosButton();
        });

        function toggleEnviarAdelantosButton() {
            var formCount = $('#form-nuevo-adelanto form').length;
            if (formCount > 0) {
                $('#btn-enviar-adelantos').show();
            } else {
                $('#btn-enviar-adelantos').hide();
            }
        }

        // Eliminar un formulario
        $('#form-nuevo-adelanto').on('click', '.btnEliminarPago', function() {
            var uniqueId = $(this).data('id');
            $('#form-adelanto-' + uniqueId).remove();
            toggleEnviarAdelantosButton();
        });

        // Enviar el formulario con todos los adelantos
        $('#btn-enviar-adelantos').off('click').on('click', function(event) {
            event.preventDefault();
            
            var adelantos = [];
            var HospedajeID = data[0].hospedajehabitacion.id; // Obteniendo el ID del hospedaje
            
            // Recorrer todos los formularios de adelanto
            $('#form-nuevo-adelanto form').each(function() {
                var tipoPago = $(this).find('select[id^="TipoPago"]').val();
                var tipoMoneda = $(this).find('select[id^="TipoMonedaPago"]').val();
                var montoPago = $(this).find('input[id^="MontoPago"]').val();
                
                // Validar los campos
                if (tipoPago && tipoMoneda && montoPago) {
                    adelantos.push({
                        TipoPago: tipoPago,
                        TipoMonedaPago: tipoMoneda,
                        MontoPago: montoPago
                    });
                }
            });
            
            // Si hay adelantos, enviarlos al servidor
            if (adelantos.length > 0) {
                $.ajax({
                    url: '/apihostal/registrar-reserva-adelanto', // Asegúrate de poner la URL correcta en el backend
                    method: 'POST',
                    data: {
                        Adelantos: adelantos,
                        HospedajeID: HospedajeID // Incluye el ID del hospedaje
                    },
                    success: function(response) {
                        CanvasTime()
                        MostrarMensaje("Registrada Exitosamente", "success");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        MostrarMensaje("Error al registrar", "error");
                    }
                });
            } else {
                alert("Por favor, ingrese al menos un adelanto.");
            }
        });

}

function TraerHabitaciones() {
    $.ajax({
        url: '/apihostal/get-habitaciones-select',
        method: 'GET',
        success: function(response) {
            $('#SelectHabitacionesUpdate').empty();
            $('#SelectHabitacionesUpdate').append(`
                <option value="SinHabitacion">Ninguna habitación</option>
            `);
            if (response.length > 0) {
                response.forEach(function(habitacion) { 
                    $('#SelectHabitacionesUpdate').append(`
                        <option value="${habitacion.id}">${habitacion.Nombre_habitacion}</option>
                    `);
                });
            } else {
                $('#SelectHabitacionesUpdate').append(`
                    <option value="">No hay habitaciones disponibles</option>
                `);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            MostrarMensaje("Error al cargar habitaciones","error")
        }
    });
}

document.getElementById('addreservas').addEventListener('click', function() {
    var formTabsDiv = document.getElementById('form_tabs');
    formTabsDiv.innerHTML = `
    <form id="form-register-product">
        <div class="card-header" style="width: 100%; background-color: #206bc4; color: white">
            <h3 class="card-title">AGREGAR RESERVA HABITACION</h3>
        </div>
        <div class="card-body">
            <div class="datagrid">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="mb-3">
                            <label class="form-label">RESERVA DE</label>
                            <select class="form-control" id="CanalDeReserva">
                                <option value="Booking">Booking</option>
                                <option value="Telefono/WhatsApp">Telefono/WhatsApp</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="mb-3">
                            <label class="form-label">TIPO DE HABITACION</label>
                            <select class="form-control" id="CategoriaHabitacion">
                                <option value="SIMPLE">SIMPLE</option>
                                <option value="DOBLE">DOBLE</option>
                                <option value="TRIPLE">TRIPLE</option>
                                <option value="MATRIMONIAL">MATRIMONIAL</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3 row">
                            <label class="form-label">Cantidad Personas</label>
                            <div class="col">
                                <input class="form-control" type="text" id="CantidadPersonas">
                            </div>
                        </div> 
                    </div>

                    <div class="col-12 col-md-12">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">Informacion Reserva</label>
                            <div class="col">
                                <textarea class="form-control" id="ComentarioReserva"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">Codigo Reserva</label>
                            <div class="col">
                                <input class="form-control convertDate" type="text" id="CodigoReserva">
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">Fecha Entrada</label>
                            <div class="col">
                                <input class="form-control convertDate" type="date" id="EntradaReserva">
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">Fecha Salida</label>
                            <div class="col">
                                <input class="form-control convertDate" type="date" id="SalidaReserva">
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">Precio (Dolar)</label>
                            <div class="col">
                                <input class="form-control convertDate" type="text" id="PrecioDolar" value="0">
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">Comision (Dolar)</label>
                            <div class="col">
                                <input class="form-control convertDate" type="text" id="ComisionDolar" value="0">
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">Precio (Bolivianos)</label>
                            <div class="col">
                                <input class="form-control convertDate" type="text" id="PrecioBolivianos" value="0">
                            </div>
                        </div> 
                    </div>
                    
                    <div class="col-12 col-md-12">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">
                                <a class="form-controll" id="btn-registrar-adelanto">Registrar Adelanto</a>
                            </label>
                            <div class="col" id="FormularioAdelanto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto" id="btn-reservar-habitacion-cancelar">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-reservar-habitacion">REALIZAR LA RESERVAR</button>
                </div>
            </div>
        </div>
    </form>
    `;
    
    configurarConversionMoneda(7, "PrecioDolar", "PrecioBolivianos");

    function configurarConversionMoneda(tasaCambio, dolarInputId, bolivianosInputId) {
        const dolarInput = document.getElementById(dolarInputId);
        const bolivianosInput = document.getElementById(bolivianosInputId);

        dolarInput.addEventListener("input", () => {
            const valorDolar = parseFloat(dolarInput.value);

            if (!isNaN(valorDolar)) {
                const valorBolivianos = valorDolar * tasaCambio;
                bolivianosInput.value = valorBolivianos.toFixed(2);
                bolivianosInput.setAttribute("disabled", "disabled");
            } else {
                bolivianosInput.value = "";
                bolivianosInput.removeAttribute("disabled");
            }
        });

        bolivianosInput.addEventListener("input", () => {
            const valorBolivianos = parseFloat(bolivianosInput.value);

            if (!isNaN(valorBolivianos)) {
                const valorDolar = valorBolivianos / tasaCambio;
                dolarInput.value = valorDolar.toFixed(2);
                dolarInput.setAttribute("disabled", "disabled");
            } else {
                dolarInput.value = "";
                dolarInput.removeAttribute("disabled");
            }
        });

        dolarInput.addEventListener("focus", () => {
            bolivianosInput.removeAttribute("disabled");
        });

        bolivianosInput.addEventListener("focus", () => {
            dolarInput.removeAttribute("disabled");
        });
    }

    function validarFechas() {
        var fechaEntrada = $('#EntradaReserva').val();
        var fechaSalida = $('#SalidaReserva').val();

        if (fechaEntrada && fechaSalida) {
            var fechaEntradaObj = new Date(fechaEntrada);
            var fechaSalidaObj = new Date(fechaSalida);

            if (fechaEntradaObj > fechaSalidaObj) {
                MostrarMensaje("La Fecha De Salida Debe Ser Mayor o Igual a Fecha De Ingreso","warning")
                $('#SalidaReserva').val('');
            } else {
                var rangoReserva = "RangoReserva";
                var fechaInicio = $('#EntradaReserva').val();
                var fechaFin = $('#SalidaReserva').val();
                $('#DateReserva').val(rangoReserva);
                $('#fechaInicioReserva').val(fechaInicio);
                $('#fechaFinReserva').val(fechaFin);
            }
        }
    }

    $('#EntradaReserva').on('change', function() {
        validarFechas();
    });

    $('#SalidaReserva').on('change', function() {
        validarFechas();
    });


    $('#btn-registrar-adelanto').off('click').on('click', function(event) {
        event.preventDefault();
        var uniqueId = new Date().getTime();
        var formularioHtml = `
            <div id="form-adelanto-${uniqueId}" class="mb-3">
                <form>
                    <div class="row">
                        <div class="col-sm-4">
                            <select class="form-control" id="TipoPago-${uniqueId}">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Deposito/QR">Deposito/QR</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control moneda" id="TipoMonedaPago-${uniqueId}">
                                <option value="Bs">Bs.</option>
                                <option value="Dolar">$</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control montoPagoInput" id="MontoPago-${uniqueId}" style="width: 100%; display: inline-block;">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-danger btnEliminarPago" type="button" data-id="${uniqueId}">X</button>
                        </div>
                    </div>
                </form>
            </div>
        `;
    
        $('#FormularioAdelanto').append(formularioHtml);
    });
    
    $(document).on('click', '.btnEliminarPago', function() {
        var formId = $(this).data('id');
        $('#form-adelanto-' + formId).remove();
    });
    
    $('#btn-reservar-habitacion').off('click').on('click', function(event) {
        event.preventDefault();
        const CanalDeReserva = $('#CanalDeReserva').val();
        const CategoriaHabitacion = $('#CategoriaHabitacion').val();
        const CantidadPersonas = $('#CantidadPersonas').val();
        const CodigoReserva = $('#CodigoReserva').val();
        const EntradaReserva = $('#EntradaReserva').val();
        const SalidaReserva = $('#SalidaReserva').val();
        const PrecioDolar = $('#PrecioDolar').val();
        const PrecioBolivianos = $('#PrecioBolivianos').val();
        const ComisionDolar = $('#ComisionDolar').val();
        const ComentarioReserva = $('#ComentarioReserva').val();
        
        const adelantos = [];
    
        $('#FormularioAdelanto form').each(function() {
            const TipoPago = $(this).find('select[id^="TipoPago"]').val();
            const TipoMonedaPago = $(this).find('select[id^="TipoMonedaPago"]').val();
            const MontoPago = $(this).find('input[id^="MontoPago"]').val();
    
            adelantos.push({
                TipoPago: TipoPago,
                TipoMonedaPago: TipoMonedaPago,
                MontoPago: MontoPago,
            });
        });
    
        const dataToSend = {
            CanalDeReserva: CanalDeReserva,
            CategoriaHabitacion: CategoriaHabitacion,
            CantidadPersonas: CantidadPersonas,
            CodigoReserva: CodigoReserva,
            EntradaReserva: EntradaReserva,
            SalidaReserva: SalidaReserva,
            PrecioDolar: PrecioDolar,
            PrecioBolivianos: PrecioBolivianos,
            ComisionDolar: ComisionDolar,
            ComentarioReserva: ComentarioReserva,
            Adelantos: adelantos,
        };
    
        $.ajax({
            url: '/apihostal/registrar-reserva-habitacion',
            method: 'POST',
            data: dataToSend,
            success: function(response) {
                CanvasTime();
                MostrarMensaje("Registrada Exitosamente", "success");
                if (calendar) {
                    calendar.refetchEvents();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                MostrarMensaje("No se registró la reserva", "error");
            }
        });
    });
    
});