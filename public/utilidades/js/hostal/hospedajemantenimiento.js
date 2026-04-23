function manejarMantenimiento(id) {
    $('#form_tabs').empty();
    var HabitacionFormMantenimiento = `
        <div class="card-header" style="width: 100%;">
            <h3 class="card-title">Poner en mantenimiento la Habitacion #${id}</h3>
        </div>
        <div class="card-body">
            <div class="datagrid">
                <div class="row">
                    <div class="col-12 col-sm-12" style="padding: 10px">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Describa . . .</label>
                                    <textarea class="form-control convertmayusculas" rows="4" id="ProblemaInput"></textarea>
                                </div>
                            </div>                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex" style="text-align: right">
                <button type="button" class="btn me-auto" id="btn-ocupar-habitacion-cancelar">CANCELAR</button>
                <button type="button" class="btn btn-primary" id="btn-estado-mantenimiento-habitacion">PONER EN MANTENIMIENTO</button>
            </div>
        </div>
    `;        
    $('#form_tabs').append(HabitacionFormMantenimiento);

    convertirMayusculas()
    
    $('#btn-estado-mantenimiento-habitacion').on('click', function(event) {
        event.preventDefault();
        var ProblemaInput = $('#ProblemaInput').val()
        const dataToSend = {
            idhabitacion: id,
            ProblemaInput: ProblemaInput
        };

        $.ajax({
            url: '/apihostal/cambiar-estado-habitacion-hospedaje-mantenimiento-problema',
            method: 'POST',
            data: dataToSend,
            success: function(response) {
                MostrarHabitaciones();
                SolucionMantenimientoHabitacion(id)
                MostrarMensaje("Estado Habitación Cambiado Exitosamente", "success");
                filtrarDatosGrupo();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al cambiar el estado de la habitación:', textStatus, errorThrown);
            }
        });
    });
}

function SolucionMantenimientoHabitacion(id) {
    $.ajax({
        url: '/apihostal/get-problemas-habitacion/'+id,
        method: 'GET',
        success: function(mantenimiento) {
            $('#form_tabs').empty();
            var htmlSolucionMantenimientoHabitacion = `
                <div class="card-header" style="width: 100%;">
                    <h3 class="card-title">Poner en mantenimiento la Habitacion #${id}</h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="row">
                            <div class="col-12 col-sm-4" style="padding: 10px">
                                <strong>Inicio Problema</strong>
                            </div>
                            <div class="col-12 col-sm-8" style="padding: 10px">
                                <span>${mantenimiento.InicioProblema}</span>
                            </div>
                            <div class="col-12 col-sm-4" style="padding: 10px">
                                <strong>Detalle Problema</strong>
                                ${mantenimiento.Solucion == null ? `
                                    <a class="input-group-link" style="cursor: pointer" id="btn-solucionar-problema">Dar Solucion</a>
                                ` : ''
                                }  
                            </div>
                            <div class="col-12 col-sm-8" style="padding: 10px">
                                <span>${mantenimiento.Problema}</span>
                            </div>
                            <div class="col-12 col-sm-12" style="padding: 10px">
                                ${mantenimiento.Solucion != null ? `
                                    <div class="row">
                                        <div class="col-12 col-sm-4" style="padding: 10px">
                                            <strong>Final Problema</strong>
                                        </div>
                                        <div class="col-12 col-sm-8" style="padding: 10px">
                                            <span>${mantenimiento.FinalProblema}</span>
                                        </div>
                                        <div class="col-12 col-sm-4" style="padding: 10px">
                                            <strong>Detalle Solucion</strong>
                                        </div>
                                        <div class="col-12 col-sm-8" style="padding: 10px">
                                            <span>${mantenimiento.Solucion}</span>
                                        </div>
                                        <div class="col-12 col-sm-4" style="padding: 10px">
                                            <strong>Tiempo Transcurrido</strong>
                                        </div>
                                        <div class="col-12 col-sm-8" style="padding: 10px">
                                            <span>${mantenimiento.TiempoSolucion}</span>
                                        </div>
                                    </div>
                                ` : ''
                                }                                
                            </div>
                            
                            <div class="col-12 col-sm-12" style="padding: 10px" id="div-form-solucion">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex-end" style="text-align: right">
                        ${mantenimiento.Solucion != null ? `
                            <button type="button" class="btn btn-primary" id="btn-estado-finalizar-mantenimiento-habitacion">TERMINAR MANTENIMIENTO</button>
                        ` : ''
                        }
                    </div>
                </div>
            `;
            
            $('#form_tabs').append(htmlSolucionMantenimientoHabitacion);

            $('#btn-solucionar-problema').on('click', function(event) {
                event.preventDefault();
                var SolucionForm = `
                    <div class="row" style="background: #FFEEAD">
                        <div class="col-12 col-sm-8" style="padding: 10px">
                            <div class="mb-3">
                                <label class="form-label">Describa la solucion. . .</label>
                                <textarea class="form-control convertmayusculas" rows="4" id="SolucionInput"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4" style="padding: 10px">
                            <div class="mb-3">
                                <label class="form-label"><br></label>
                                <button type="button" class="btn btn-primary" id="btn-registrar-solucion-habitacion">Registrar Solucion</button>
                            </div>
                        </div>
                    </div>                    
                `;
                
                $('#div-form-solucion').append(SolucionForm);

                convertirMayusculas()

                $('#btn-registrar-solucion-habitacion').on('click', function(event) {
                    event.preventDefault();
                    var SolucionInput = $('#SolucionInput').val()
                    const dataToSend = {
                        idmantenimiento: mantenimiento.id,
                        SolucionInput: SolucionInput
                    };

                    $.ajax({
                        url: '/apihostal/cambiar-estado-habitacion-hospedaje-mantenimiento-solucion',
                        method: 'POST',
                        data: dataToSend,
                        success: function(response) {
                            SolucionMantenimientoHabitacion(id);
                            MostrarMensaje("Estado Habitación Cambiado Exitosamente", "success");
                            filtrarDatosGrupo();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error al cambiar el estado de la habitación:', textStatus, errorThrown);
                        }
                    });
                });

            });

            
            $('#btn-estado-finalizar-mantenimiento-habitacion').on('click', function(event) {
                event.preventDefault();
            
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Quieres Concluir Mantenimiento!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, cambiar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const dataToSend = {
                            idhabitacion: id,
                            idmantenimiento: mantenimiento.id,
                        };
            
                        $.ajax({
                            url: '/apihostal/cambiar-estado-habitacion-hospedaje-mantenimiento-sucio',
                            method: 'POST',
                            data: dataToSend,
                            success: function(response) {
                                MostrarHabitaciones();
                                MostrarMensaje("Estado Habitación Cambiado Exitosamente", "success");
                                filtrarDatosGrupo();
                                CanvasTime();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('Error al cambiar el estado de la habitación:', textStatus, errorThrown);
                            }
                        });
                    }
                });
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al cambiar el estado de la habitación:', textStatus, errorThrown);
        }
    });
}

function convertirMayusculas() {
    const inputs = document.querySelectorAll('.convertmayusculas');
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            input.value = input.value.toUpperCase();
        });
    });
}