<div class="datagrid-item">
    <div class="row">
        <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
            <div class="row" style="background: #F5F7F8;">
                <div class="col-md-11">
                    <div class="row" style="padding-bottom: 10px">
                        <div class="col-md-3">
                            <select name="DateAsistencia" id="DateAsistencia" class="form-control">
                                <option value="MensualidadAsistencia">Todo El Mes</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="MesAsistenciaContainer">
                            <select name="MesAsistencia" id="MesAsistencia" class="form-control">
                            </select>
                        </div>
                        <div class="col-md-3" id="AnioAsistenciaContainer">
                            <select name="AnioAsistencia" id="AnioAsistencia" class="form-control">
                            </select>
                        </div>
                        <div class="col-md-3" id="PersonaContainer">
                            <select name="PersonaAsistencia" id="PersonaAsistencia" class="form-control">
                                <option value="">Cargando personas...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="row" style="padding-bottom: 10px; text-align: end;">
                        <span class="badge bg-blue" style="padding: 10px; width: 50%; cursor: pointer;" id="btn-refrescar-tabla-hostal">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-reload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="table-responsive" style="overflow-y: scroll; max-height: 500px" id="RespuestaContainer">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-add-detalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Agregar Asistencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <div class="mb-3">
                    <label class="form-label">Fecha De Registro</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="text" class="form-control" id="DateFecha">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" id="DateHora">
                        </div>
                    </div>
                </div>
                <label class="form-label">Selecciona Una Opcion</label>
                <div class="form-selectgroup">
                    <label class="form-selectgroup-item">
                        <input type="radio" name="IngresoSalida" value="Ingreso" class="form-selectgroup-input" checked id="opcionIngreso">
                        <span class="form-selectgroup-label">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                            INGRESO
                        </span>
                    </label>
                    <label class="form-selectgroup-item">
                        <input type="radio" name="IngresoSalida" value="Salida" class="form-selectgroup-input" id="opcionSalida">
                        <span class="form-selectgroup-label">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                            SALIDA
                        </span>
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Ingrese Su PIN</label>
                <input type="password" class="form-control" name="example-text-input" placeholder="Ingrese PIN" id="PinCliente">
                <small class="form-hint" id="estadoPin" style="display: none;"></small>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-registrar-ingreso-salida">Registrar</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-editar-detalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Editar o <a href="#" id="btn-eliminar-detalle">Eliminar</a></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <div class="mb-3">
                    <label class="form-label">Fecha De Registro</label>
                    <input type="text" class="form-control" id="HoraUpdate">
                </div>
                <label class="form-label">Selecciona Una Opcion</label>
                <div class="form-selectgroup">
                    <label class="form-selectgroup-item">
                        <input type="radio" name="IngresoSalidaUpdate" value="Ingreso" class="form-selectgroup-input" checked id="opcionIngresoUpdate">
                        <span class="form-selectgroup-label">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                            INGRESO
                        </span>
                    </label>
                    <label class="form-selectgroup-item">
                        <input type="radio" name="IngresoSalidaUpdate" value="Salida" class="form-selectgroup-input" id="opcionSalidaUpdate">
                        <span class="form-selectgroup-label">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>
                            SALIDA
                        </span>
                    </label>
                </div>
                <br><br>
                <div class="mb-3">
                    <label class="form-label">Hora Extra</label>
                    <input type="text" class="form-control" id="HoraExtraUpdate">
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-actualizar-ingreso-salida">Actualizar</button>
        </div>
    </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<script>
    $(document).ready(function() { 
        FechaSelectAsistencia()
        TraerPersonas()
    });

    function FechaSelectAsistencia() {
        var today = new Date();
        var currentDay = today.getDate();
        var currentMonth = today.getMonth();
        var currentYear = today.getFullYear();
        var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        $('#MesAsistencia').empty();
        $('#AnioAsistencia').empty();

        for (var month = 0; month < 12; month++) {
            $('#MesAsistencia').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
        }
        $('#MesAsistencia').val(currentMonth + 1);

        var startYear = currentYear - 6;
        var endYear = currentYear;
        for (var year = startYear; year <= endYear; year++) {
            $('#AnioAsistencia').append('<option value="' + year + '">' + year + '</option>');
        }
        $('#AnioAsistencia').val(currentYear);
        
        $('#MesAsistencia').on('change', function() {
            FiltrarDatosAsistencia();
        });
        
        $('#PersonaAsistencia').on('change', function() {
            FiltrarDatosAsistencia();
        });

        $('#AnioAsistencia').on('change', function() {
            FiltrarDatosAsistencia();
        });

        $('#DateAsistencia').trigger('change');

    }

    function DibujarDias(Datos) {
    const month = parseInt($('#MesAsistencia').val());
    const year = parseInt($('#AnioAsistencia').val());
    const daysInMonth = new Date(year, month, 0).getDate();
    const asistencias = Datos.asistencias || [];

    $('#RespuestaContainer').empty();

    let formHtml = `
        <table border="1" class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Ingreso</th>
                    <th>Salida</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                ${Array.from({ length: daysInMonth }, (_, i) => {
                    const day = i + 1;
                    const formattedDate = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const displayDate = `${day}/${month}/${year}`;

                    const ingresos = asistencias
                        .filter(a => a.fecha_ingreso && a.fecha_ingreso.startsWith(formattedDate))
                        .map(a => `<span onclick="mostrarId(${a.id})">${a.hora_ingreso}</span>`)
                        .join('<br>') || '-';

                    const salidas = asistencias
                        .filter(a => a.fecha_salida && a.fecha_salida.startsWith(formattedDate))
                        .map(a => `<span onclick="mostrarId(${a.id})">${a.hora_salida}</span>`)
                        .join('<br>') || '-';

                    const observacion = asistencias
                        .filter(a =>
                            (a.fecha_ingreso && a.fecha_ingreso.startsWith(formattedDate)) ||
                            (a.fecha_salida && a.fecha_salida.startsWith(formattedDate))
                        )
                        .map(a => a.HoraExtra === "true" && a.RazonHoraExtra ? a.RazonHoraExtra : '-')
                        .join('<br>') || '-';

                    return `
                        <tr>
                            <td data-bs-toggle="modal" data-bs-target="#modal-add-detalle" onclick="abrirModal('${formattedDate}')">${displayDate}</td>
                            <td>${ingresos}</td>
                            <td>${salidas}</td>
                            <td>${observacion}</td>
                        </tr>
                    `;
                }).join('')}
            </tbody>
        </table>
    `;

    $('#RespuestaContainer').append(formHtml);
}



    function abrirModal(fecha) {
        const now = new Date();
        const formattedDateTime = `${fecha}`;
        $('#DateFecha').val(formattedDateTime);

        const currentHora = now.toTimeString().split(' ')[0]; // HH:MM:SS
        $('#DateHora').val(currentHora);

        $('#btn-registrar-ingreso-salida').off('click').on('click', function() {
            const fecha = $('#DateFecha').val();
            const hora = $('#DateHora').val();
            const opcionSeleccionada = $('input[name="IngresoSalida"]:checked').val();
            const pin = $('#PinCliente').val();

            if (!fecha || !opcionSeleccionada || !pin) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos antes de continuar.',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }

            const data = {
                fecha: fecha,
                hora: hora,
                opcion: opcionSeleccionada,
                pin: pin
            };

            $.ajax({
                url: '/Registrar-por-Pin',
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    FiltrarDatosAsistencia();
                    $('#modal-add-detalle').modal('hide'); // Cerrar modal después de éxito
                    
                    // SweetAlert de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro exitoso',
                        text: 'El registro fue realizado correctamente.',
                        confirmButtonText: 'Aceptar'
                    });
                },
                error: function(error) {
                    console.error('Error al registrar:', error);
                    
                    // SweetAlert de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al registrar',
                        text: 'Ocurrió un error al registrar. Verifique e intente nuevamente.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });

    }


    function mostrarId(id) {
        $.ajax({
            url: `/detalle-registro-por-Pin/${id}`,
            method: 'GET',
            success: function(response) {
                const id = response.id
                // Determinar fecha y hora (Ingreso o Salida)
                const fecha = response.fecha_ingreso || response.fecha_salida;
                let hora = response.hora_ingreso || response.hora_salida;
                const tipo = response.estado.charAt(0).toUpperCase() + response.estado.slice(1); // Convertir a 'Ingreso' o 'Salida'

                if (!hora) {
                    alert('Datos de hora no disponibles');
                    return;
                }

                // Convertir la hora a formato 24 horas (si es necesario)
                if (/^\d{1,2}:\d{2}:\d{2}\s?(AM|PM)?$/i.test(hora)) {
                    const date = new Date(`1970-01-01T${hora}`);
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const seconds = String(date.getSeconds()).padStart(2, '0');
                    hora = `${hours}:${minutes}:${seconds}`;
                }

                // Asignar la hora al input de texto (eliminamos los segundos si no es necesario)
                const formattedTime = hora.split(':').slice(0, 3).join(':');  // Solo hora, minuto y segundo (HH:MM:SS)
                $('#HoraUpdate').val(formattedTime);

                // Seleccionar la opción correcta (Ingreso o Salida)
                if (tipo === 'Ingreso') {
                    $('#opcionIngresoUpdate').prop('checked', true);
                } else if (tipo === 'Salida') {
                    $('#opcionSalidaUpdate').prop('checked', true);
                }

                // Mostrar el modal
                $('#modal-editar-detalle').modal('show');

                $('#btn-actualizar-ingreso-salida').off('click').on('click', function() {
                    const horaupda = $('#HoraUpdate').val();
                    const opcionSeleccionadaupda = $('input[name="IngresoSalidaUpdate"]:checked').val();
                    const HoraExtraUpdate = $('#HoraExtraUpdate').val();

                    const data = {
                        id: id,
                        hora: horaupda,
                        opcion: opcionSeleccionadaupda,
                        extra: HoraExtraUpdate,
                    };

                    $.ajax({
                        url: '/actulizar-informacion-persona-detalle',
                        method: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            FiltrarDatosAsistencia();
                            $('#modal-editar-detalle').modal('hide'); // Cerrar modal

                            // Mostrar mensaje de éxito
                            Swal.fire({
                                icon: 'success',
                                title: 'Actualizado',
                                text: 'La información fue actualizada correctamente.',
                                confirmButtonText: 'Aceptar'
                            });
                        },
                        error: function(error) {
                            console.error('Error al actualizar:', error);
                            
                            // Mostrar mensaje de error con SweetAlert2
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error al actualizar. Verifique e intente nuevamente.',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    });
                });

                $('#btn-eliminar-detalle').off('click').on('click', function() {
                    const data = {
                        id: id,
                    };

                    // Mostrar confirmación con SweetAlert2
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminarlo',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si confirma, realizar la petición AJAX
                            $.ajax({
                                url: '/eliminar-persona-detalle',
                                method: 'POST',
                                data: data,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    Swal.fire(
                                        '¡Eliminado!',
                                        response.message,
                                        'success'
                                    );
                                    FiltrarDatosAsistencia();
                                    $('#modal-editar-detalle').modal('hide');

                                },
                                error: function(error) {
                                    console.error('Error al eliminar:', error);
                                    Swal.fire(
                                        'Error',
                                        'Ocurrió un error al eliminar. Intente nuevamente.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            },
            error: function(error) {
                console.error('Error al obtener los detalles:', error);
                alert('Ocurrió un error al obtener los detalles. Intente de nuevo.');
            }
        });
    }


    function FiltrarDatosAsistencia(){
        var today = new Date();
        var selectedYear = $('#AnioAsistencia').val();
        var tipoFiltro = $('#DateAsistencia').val();
        var mes = $('#MesAsistencia').val();
        var persona =$('#PersonaAsistencia').val();
        var anio = selectedYear;

        $.ajax({
            url: '/filtrar-datos-asistencia-user',
            method: 'GET',
            data: {
                tipoFiltro: tipoFiltro,
                mes: mes,
                anio: anio,
                persona: persona
            },
            success: function(response) {
                DibujarDias(response);
            },
            error: function(error) {
                console.error('Error al filtrar datos:', error);
            }
        });
    }

    function TraerPersonas(){
        $.ajax({
            url: '/api/get-personas',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#PersonaAsistencia').empty();

                $('#PersonaAsistencia').append('<option value="">Seleccione una persona</option>');

                $.each(data, function(index, persona) {
                    $('#PersonaAsistencia').append(`<option value="${persona.id}">${persona.Nombre_Completo}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar las personas:', error);
                alert('No se pudieron cargar las personas. Verifique la API.');
            }
        });
    }
</script>