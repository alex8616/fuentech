
$(document).ready(function() {
    FechaSelectGrupo()
});

document.getElementById('addreservasgrupo').addEventListener('click', function() {
    var formTabsDiv = document.getElementById('form_tabs');
    formTabsDiv.innerHTML = `
    <form id="form-register-product">
        <div class="card-header" style="width: 100%; background-color: #206bc4; color: white">
            <h3 class="card-title">RESERVAR</h3>
        </div>
        <div class="card-body">
            <div class="datagrid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-3 row">
                            <label class="form-label">Nombre Del Tour</label>
                            <div class="col">
                                <input class="form-control" type="text" id="TourNameInput">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3 row">
                            <label class="form-label">Codigo Tour</label>
                            <div class="col">
                                <input class="form-control" type="text" id="TourCodigoInput">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3 row">
                            <label class="form-label">Cantidad Personas</label>
                            <div class="col">
                                <input class="form-control" type="text" id="CantidadPersonasInput">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3 row">
                            <label class="form-label">Fecha Entrada</label>
                            <div class="col">
                                <input class="form-control convertDate" type="date" id="EntradaGrupoInput">
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3 row">
                            <label class="form-label">Fecha Salida</label>
                                <div class="col">
                                <input class="form-control convertDate" type="date" id="SalidaGrupoInput">
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3 row">
                            <label class="form-label">Procedencia</label>
                                <div class="col">
                                <select class="form-control" id="ProcedenciaGrupoInput">
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3 row">
                            <label class="form-label">Destino</label>
                                <div class="col">
                                <select class="form-control" id="DestinoGrupoInput">
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="mb-3 row">
                            <label class="col-12 col-form-label" style="font-weight: bold;">Comentario Grupo</label>
                            <div class="col">
                                <textarea class="form-control" id="ComentarioGrupoInput"></textarea>
                            </div>
                        </div>
                    </div>                    
                </div>                
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto" id="btn-reservar-grupo-cancelar">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-reservar-grupo">REALIZAR LA RESERVAR</button>
                </div>
            </div>
        </div>
    </form>
    `;    

    TraerDepartamentosDestinoGrupo()
    TraerDepartamentosProcedenciaGrupo()
    
    $('#btn-reservar-grupo').on('click', function(event) {
        event.preventDefault();
    
        const TourNameInput = $('#TourNameInput').val();
        const TourCodigoInput = $('#TourCodigoInput').val();
        const CantidadPersonasInput = $('#CantidadPersonasInput').val();
        const EntradaGrupoInput = $('#EntradaGrupoInput').val();
        const SalidaGrupoInput = $('#SalidaGrupoInput').val();
        const ComentarioGrupoInput = $('#ComentarioGrupoInput').val();
        const ProcedenciaGrupoInput = $('#ProcedenciaGrupoInput').val();
        const DestinoGrupoInput = $('#DestinoGrupoInput').val();
        
        const dataToSend = {
            TourNameInput: TourNameInput,
            TourCodigoInput: TourCodigoInput,
            CantidadPersonasInput: CantidadPersonasInput,
            EntradaGrupoInput: EntradaGrupoInput,
            SalidaGrupoInput: SalidaGrupoInput,
            ComentarioGrupoInput: ComentarioGrupoInput,
            ProcedenciaGrupoInput: ProcedenciaGrupoInput,
            DestinoGrupoInput: DestinoGrupoInput
        };
    
        $.ajax({
            url: '/apihostal/registrar-grupo-hospedaje',
            method: 'POST',
            data: dataToSend,
            success: function(response) {
                MostrarHabitaciones()
                MostrarMensaje("Registrado Exitosamente", "success")
                filtrarDatosGrupo()
                CanvasTime()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al ocupar la habitación:', textStatus, errorThrown);
            }
        });
    });
    
    $('#btn-reservar-grupo-cancelar').on('click', function(event) {
        event.preventDefault();
        CanvasTime();
    });

    function TraerDepartamentosProcedenciaGrupo() {
        const jsonUrl = '/utilidades/json/departamentos.json';
        const procedenciaSelect = $('#ProcedenciaGrupoInput');
        
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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar el archivo JSON:', textStatus);
            }
        });
    }

    function TraerDepartamentosDestinoGrupo() {
        const jsonUrl = '/utilidades/json/departamentos.json';
        const procedenciaSelect = $('#DestinoGrupoInput');
        
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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar el archivo JSON:', textStatus);
            }
        });
    }
});

function FechaSelectGrupo() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesGrupo').empty();
    $('#AnioGrupo').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesGrupo').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesGrupo').val(currentMonth + 1);

    var startYear = currentYear - 6;
    var endYear = currentYear;
    for (var year = startYear; year <= endYear; year++) {
        $('#AnioGrupo').append('<option value="' + year + '">' + year + '</option>');
    }
    $('#AnioGrupo').val(currentYear);

    function updateDaySelector() {
        var selectedMonth = parseInt($('#MesGrupo').val());
        var selectedYear = parseInt($('#AnioGrupo').val());
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaGrupo').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaGrupo').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaGrupo').val(daysInMonth);
        } else {
            $('#DiaGrupo').val(currentDay);
        }
    }

    updateDaySelector();

    $('#DateGrupo').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioGrupo':
                $('#DiaGrupoContainer').show();
                $('#MesGrupoContainer').show();
                $('#AnioGrupoContainer').show();
                $('#FechaInicioContainerGrupo').hide();
                $('#FechaFinContainerGrupo').hide();
                break;
            case 'MensualGrupo':
                $('#DiaGrupoContainer').hide();
                $('#MesGrupoContainer').show();
                $('#AnioGrupoContainer').show();
                $('#FechaInicioContainerGrupo').hide();
                $('#FechaFinContainerGrupo').hide();
                break;
            case 'AnualGrupo':
                $('#DiaGrupoContainer').hide();
                $('#MesGrupoContainer').hide();
                $('#AnioGrupoContainer').show();
                $('#FechaInicioContainerGrupo').hide();
                $('#FechaFinContainerGrupo').hide();
                break;
            case 'RangoGrupo':
                $('#DiaGrupoContainer').hide();
                $('#MesGrupoContainer').hide();
                $('#AnioGrupoContainer').hide();
                $('#FechaInicioContainerGrupo').show();
                $('#FechaFinContainerGrupo').show();
                break;
            default:
                $('#DiaGrupoContainer').show();
                $('#MesGrupoContainer').show();
                $('#AnioGrupoContainer').show();
                $('#FechaInicioContainerGrupo').hide();
                $('#FechaFinContainerGrupo').hide();
                break;
        }
        filtrarDatosGrupo();
    });


    $('#MesGrupo, #AnioGrupo').on('change', function() {
        updateDaySelector();
        filtrarDatosGrupo();
    });

    $('#DiaGrupo').on('change', function() {
        filtrarDatosGrupo();
    });

    $('#FechaInicioContainerGrupo').on('change', function() {
        filtrarDatosGrupo();
    });

    $('#FechaFinContainerGrupo').on('change', function() {
        filtrarDatosGrupo();
    });

    $('#TipoGrupo').on('change', function() {
        filtrarDatosGrupo();
    });

    $('#Habitaciones').on('change', function() {
        filtrarDatosGrupo();
    });

    $('#DateGrupo').trigger('change');

}

function filtrarDatosGrupo() {
    var tipoFiltro = $('#DateGrupo').val();
    var dia = $('#DiaGrupo').val();
    var mes = $('#MesGrupo').val();
    var anio = $('#AnioGrupo').val();
    var fechaInicio = $('#fechaInicioGrupo').val();
    var fechaFin = $('#fechaFinGrupo').val();
    var TipoGrupo = $('#TipoGrupo').val();
    var Habitaciones = $('#Habitaciones').val();

    $.ajax({
        url: '/apihostal/filtrar-datos-grupos',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
            TipoGrupo: TipoGrupo,
            Habitaciones: Habitaciones
        },
        success: function(response) {
            MostrarDivCantidad(response.cantidadregistros)
            MostrarDivTotal(response.totalSum)
            mostrarResultadosGrupos(response);
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function mostrarResultadosGrupos(filteredData) {
    $('#tabla-grupo tbody').empty();
    $.each(filteredData.grupos, function(index, grupo) {
        var row = '<tr>' +
            '<td hidden>' + grupo.id + '</td>' +
            '<td style="font-weight: bold;">' + grupo.CodigoHospedaje + '</td>' +
            '<td style="font-weight: bold;">' + grupo.TourName + '</td>' +
            '<td style="font-weight: bold;">' + grupo.ingreso_hospedaje + '</td>' +
            '<td style="font-weight: bold;">' + grupo.salida_hospedaje + '</td>' +
            '<td style="font-weight: bold;">' + grupo.Comentario + '</td>' +
        '</tr>';

        $('#tabla-grupo tbody').append(row);
    });

    $('#tabla-grupo tbody').on('click', 'tr', function() {
        $('#tabla-grupo tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');
        var id = $(this).find('td:first').text();
        $.ajax({
            url: '/apihostal/get-grupo-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionGrupo(id);
            },
            error: function(error) {
                console.error('Error al recuperar datos de la grupo:', error);
            }
        });
    });
}

function cargarHabitaciones(){
    $.ajax({
        url: '/apihostal/get-habitaciones',
        method: 'GET',
        success: function(response) {
            $('#Habitaciones').empty();
            $('#Habitaciones').append('<option value="TodoHabitaciones">Habitaciones</option>');
            
            $.each(response, function(index, habitacion) {
                $('#Habitaciones').append('<option value="' + habitacion.id + '">' + habitacion.Nombre_habitacion + '</option>');
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            MostrarMensaje("Error al cargar habitaciones", "error");
        }
    });
}


function InformacionGrupo(id){
    $.ajax({
        url: '/apihostal/get-grupo-seleccionado/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var TotalProduct = document.getElementById('form_tabs');
            var habitacionHtmlGrupo = '';
            var habitacionAdelantoHtmlGrupo = '';
        
            $.each(data, function(index, hospedaje) {
                $.each(hospedaje.hospedajes, function(i, detalleHospedaje) {
                    var clientesHtml = '';
                    $.each(detalleHospedaje.detallehospedajes, function(j, detalle) {
                        clientesHtml += `<li>${detalle.cliente.Nombre_cliente} ${detalle.cliente.Apellido_cliente}</li>`;
                    });
            
                    if (clientesHtml === '') {
                        clientesHtml = '<li style="color: red">No hay clientes asociados</li>';
                    }
            
                    habitacionHtmlGrupo += `
                        <div class="col-12 col-sm-4">
                            <h3 class="card-title" style="font-size: 13px">${detalleHospedaje.habitacion.Nombre_habitacion}</h3>
                        </div>
                        <div class="col-12 col-sm-5">
                            <h3 class="card-title" style="font-size: 13px">${detalleHospedaje.CategoriaHabitacion}</h3>
                        </div>
                        <div class="col-12 col-sm-3">
                            ${detalleHospedaje.GuiaTuristica == "false" ? `
                                <h3 class="card-title" style="font-size: 13px">${detalleHospedaje.Precio_habitacion}</h3>
                            ` : 'Guia'
                            }
                        </div>
                    `;
                });
            
                if (habitacionHtmlGrupo === '') {
                    habitacionHtmlGrupo = '<div class="col-12"><p style="color: red">No hay habitaciones asociadas.</p></div>';
                }
            
                $('#div-habitaciones-grupo').append(habitacionHtmlGrupo);
            });
            
            $.each(data, function(index, hospedaje) {
                $.each(hospedaje.adelantos, function(i, adelanto) {
                    habitacionAdelantoHtmlGrupo += `
                        <div class="col-12 col-md-6">
                            <h3 class="card-title">${adelanto.TipoAdelanto}</h3>
                        </div>
                        <div class="col-12 col-md-6">
                            <h3 class="card-title" style="font-weight: bold">${adelanto.TotalAdelanto}</h3>
                        </div>
                    `;
                });
            
                if (habitacionAdelantoHtmlGrupo === '') {
                    habitacionAdelantoHtmlGrupo = '<div class="col-12"><p style="color: red">No hay adelantos asociadas.</p></div>';
                }
            
                $('#div-habitaciones-adelanto-grupo').append(habitacionAdelantoHtmlGrupo);
            });
            
            TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                        <h3 class="card-title">CODIGO DE RESERVA ${data[0].CodigoHospedaje}</h3>
                        ${data[0].EstadoHospedajeGrupo == "false" ? `
                            <div class="card-actions">
                                <span class="badge badge-outline text-red" id="btn-editar-grupo" style="cursor: pointer;">Editar</span>
                            </div>
                        ` : ''
                        }
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="row" id="edit-div">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Codigo Grupo</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].CodigoHospedaje}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Nombre</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].TourName}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Check-in</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].ingreso_hospedaje}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Check-out</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].salida_hospedaje}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Cant. Dias</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].dias_hospedarse}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Personas</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].CantidadPersonas}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Procedencia</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].procedencia_hospedaje}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Destino</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].destino_hospedaje}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Comentario</label>
                                    <div class="col">
                                        <label class="col-12 col-form-label" style="color: #61677A">${data[0].Comentario}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Estado</label>
                                    <div class="col">
                                        ${data[0].EstadoGrupo != "CONCLUIDO" ? `
                                            <span class="badge bg-red">${data[0].EstadoGrupo}</span>
                                        ` : ` 
                                            <span class="badge bg-green">Concluido</span>
                                        `
                                        }
                                    </div>
                                </div>
                            </div>                            
                            <div class="mb-12 row">
                                <div class="col-12 col-md-5">
                                    <div class="mb-3 row">
                                        <label class="col-12 col-form-label" style="font-weight: bold;">
                                            ${data[0].EstadoGrupo != "CONCLUIDO" ? `
                                                <a class="form-controll" id="btn-registrar-adelanto" id="btn-pagar-servicio-lavado" data-bs-toggle="modal" data-bs-target="#Modal-adelanto-grupo-list">Registrar Adelanto</a>
                                            ` : ''
                                            }
                                        </label>
                                        <div class="col" id="FormularioAdelanto">
                                        </div>
                                    </div>
                                    <div class="card" style="padding: 10px">
                                        <div class="row" style="margin: 0px; margin: 0px;">
                                            ${habitacionAdelantoHtmlGrupo}
                                        </div>
                                        <div class="card-footer" style="padding: 5px">
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
                                <div class="col-12 col-md-7">
                                    <div class="mb-3 row">
                                        <label class="col-12 col-form-label" style="font-weight: bold;">
                                        ${data[0].EstadoGrupo != "CONCLUIDO" ? `
                                            <a class="form-controll" id="btn-registrar-habitacion-grupo">Registrar Habitación</a>
                                        ` : ''
                                        }
                                        </label>
                                        <div class="col" id="FormularioAdelanto">
                                    </div>
                                    </div>
                                    <div class="card" style="padding: 10px">
                                        <div class="row" style="margin: 0px; margin: 0px;">
                                            ${habitacionHtmlGrupo}
                                        </div>
                                        <div class="card-footer" style="padding: 5px">
                                            <div class="row" style="background: #1d2736; color: white; padding-top: 12px">
                                                <div class="col-12 col-md-9">
                                                    <h3 class="card-title">TOTAL</h3>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <h3 class="card-title" style="font-weight: bold">${data[0].SubTotal}</h3>                                                     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex">
                        ${data[0].EstadoGrupo == "PENDIENTE" ? `
                            <a class="btn btn-primary ms-auto" id="btn-concluir-hospedaje-grupo">Concluir Hospedaje</a>
                        ` : ''
                        }
                        </div>
                    </div>
                </div>
            </div>`;
        
            $('#btn-concluir-hospedaje-grupo').on('click', function() {
                var id = data[0].id
                $.ajax({
                    url: '/apihostal/cambiar-estado-grupo/' + id,
                    method: 'GET',
                    success: function(response) {
                        MostrarHabitaciones()
                        CanvasTime()
                        MostrarMensaje("Concluido Exitosamente", "success")
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error al cargar las habitaciones:", textStatus);
                    }
                });
            });

            $('#btn-registrar-habitacion-grupo').on('click', function() {
                $('#modal-asiganar-habitacion').modal('show');
                var IdGrupo = data[0].id
        
                cargarHabitacionesGrupo(IdGrupo);
                cargarHabitacionesEnSelect(IdGrupo);
        
                $('#btn-agregar-habitaciones-grupo').off('click').on('click', function() {
                    let selectedHabitaciones = $('#SelectHabitacionesGrupo').val();
                    if (selectedHabitaciones.length === 0) {
                        MostrarMensaje("Por favor selecciona al menos una habitación","error")
                        return;
                    }
                    var IdGrupo = data[0].id
            
                    $.ajax({
                        url: '/apihostal/registrar-grupo-habitaciones',
                        method: 'POST',
                        data: {
                            habitaciones: selectedHabitaciones,
                            IdGrupo: IdGrupo,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            cargarHabitacionesGrupo(IdGrupo);
                            cargarHabitacionesEnSelect(IdGrupo);
                            InformacionGrupo(id)
                            MostrarMensaje("Agregados Exitosamente","success")
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Error al registrar habitaciones:", textStatus);
                        }
                    });
                });
            });
        
            $('#btn-confirmar-modal-adelanto-grupo-list').off('click').on('click', function(e) {
                e.preventDefault();
                var tipoPago = $('#ModalGrupoTipoPagoSelect').val();
                var tipomoneda = $('#ModalGrupoTipoMonedaSelect').val();
                var monto = $('#ModalGrupoMonto').val();
        
                if (monto === '' || isNaN(monto)) {
                    alert('Por favor, ingresa un monto válido.');
                    return;
                }
                $.ajax({
                    url: '/apihostal/registrar-adelanto-grupo',
                    method: 'POST',
                    data: {
                        tipo_pago: tipoPago,
                        tipomoneda: tipomoneda,
                        monto: monto,
                        id: data[0].id
                    },
                    success: function(response) {
                        InformacionGrupo(id);
                        MostrarMensaje("El adelanto ha sido registrado correctamente.","success")
                    },
                    error: function(xhr, status, error) {
                        MostrarMensaje("Ocurrió un error al registrar el adelanto.","error")
                    }
                });
            });

            function cargarHabitacionesGrupo(id) {
                $.ajax({
                    url: '/apihostal/get-habitaciones-grupo/' + id,
                    method: 'GET',
                    success: function(response) {
                        $('#div-habitaciones').empty();
            
                        $.each(response, function(index, hospedaje) {
                            var clientesHtml = '';
            
                            $.each(hospedaje.detallehospedajes, function(i, detalleHospedaje) {
                                clientesHtml += `<li>${detalleHospedaje.cliente.Nombre_cliente} ${detalleHospedaje.cliente.Apellido_cliente}</li>`;
                            });
            
                            if (clientesHtml === '') {
                                clientesHtml = '<li style="color: red">No hay clientes asociados</li>';
                            }
            
                            var habitacionHtml = `
                                <div class="col-12 col-sm-6 mb-6">
                                    <div class="card bg-primary-lt" style="margin: 0 5px;" data-id="${hospedaje.id}">
                                        <div class="card-body" style="padding: 4px; margin: 4px">
                                            <h3 class="card-title">${hospedaje.habitacion.Nombre_habitacion}</h3>
                                            <ul>${clientesHtml}</ul>
                                        </div>
                                    </div>
                                </div>
                            `;
            
                            $('#div-habitaciones').append(habitacionHtml);
                        });
            
                        $('#div-habitaciones .card').off('click').on('click', function() {
                            var hospedajeID = $(this).data('id');
            
                            $.ajax({
                                url: '/apihostal/get-hospedaje-grupos/'+hospedajeID,
                                method: 'GET',
                                success: function(response) {
                                    $('#div-habitaciones-form').empty();
                                    
                                    var habitacionHtml = `
                                        <div class="card-header" style="width: 100%; background-color: #2fb344; color: white">
                                            <h3 class="card-title">Habitacion #${hospedajeID}</h3>
                                            <div class="ms-auto">
                                                <span class="badge bg-red" data-id="${hospedajeID}" id="btn-eliminar-habitacion-grupo">X</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="datagrid">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12" style="padding: 2px">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12">
                                                                <div class="mb-3">
                                                                    <div class="card">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-vcenter card-table" id="table-pasajeros-grupo">
                                                                            <thead>
                                                                                <tr>
                                                                                <th>Documento</th>
                                                                                <th>Nombre Completo</th>
                                                                                <th>Nacionalidad</th>
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
                                                            <div class="col-12 col-sm-2">
                                                                <div class="mb-3">
                                                                    <label class="form-label">GUIA</label>
                                                                    <label class="form-check">
                                                                        <input class="form-check-input" type="checkbox" id="check-guia">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-4" id="habitacion-tipo">
                                                                <div class="mb-3">
                                                                    <label class="form-label">TIPO</label>
                                                                    <select class="form-control" id="CategoriaHabitacionGrupo">
                                                                        <option value="SIMPLE">SIMPLE</option>
                                                                        <option value="DOBLE">DOBLE</option>
                                                                        <option value="TRIPLE">TRIPLE</option>
                                                                        <option value="MATRIMONIAL">MATRIMONIAL</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-4" id="precio-habitacion">
                                                                <div class="mb-3">
                                                                    <label class="form-label">PRECIO HABITACION</label>
                                                                    <input class="form-control" id="PrecioHabitacionGrupo" value="${response[0].Precio_habitacion}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-2">
                                                                <div class="mb-3">
                                                                    <label class="form-label"><br></label>
                                                                    <span class="badge bg-blue" id="btn-actualizar-datos-grupo" style="padding: 10px; cursor: pointer">Actualizar</span>
                                                                </div>
                                                            </div>

                                                            <!-- Mensaje de guía -->
                                                            <div class="col-12" id="mensaje-guia" style="display: none;">
                                                                <div class="mb-3">
                                                                    <span class="badge bg-warning" style="padding: 10px;">La habitación lo ocupará un guía</span>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-sm-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">CI - PASSAPORTE</label>
                                                                    <input type="text" class="form-control convertmayusculas" id="PassaporteInputGrupo" placeholder="Buscar por Nombre o Documento">
                                                                    <div id="div-clientes" class="dropdown-menu dropdown-menu-demo">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12">
                                                                <div id="div-formulario" class="row d-none">
                                                                    <div class="col-lg-6 formulario" style="background: #FEF9D9; padding-left: 10px; padding-right: 10px">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nombres</label>
                                                                            <input type="text" class="form-control convertmayusculas" id="InputNombresGrupo">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 formulario" style="background: #FEF9D9; padding-left: 10px; padding-right: 10px">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Apellidos</label>
                                                                            <input type="text" class="form-control convertmayusculas" id="InputApellidosGrupo">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 formulario" style="background: #FEF9D9; padding-left: 10px; padding-right: 10px">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Profesion</label>
                                                                            <input type="text" class="form-control convertmayusculas" id="InputProfesionGrupo">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 formulario" style="background: #FEF9D9; padding-left: 10px; padding-right: 10px">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nacionalidad</label>
                                                                            <select class="form-control" id="InputNacionalidadGrupo">
                                                                                <!-- Opciones de nacionalidad -->
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 formulario" style="background: #FEF9D9; padding-left: 10px; padding-right: 10px">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Estado Civil</label>
                                                                            <select class="form-control" id="InputEstadoCivilGrupo">
                                                                                <option value="Soltero(a)">Soltero(a)</option>
                                                                                <option value="Casado(a)">Casado(a)</option>
                                                                                <option value="Viudo(a)">Viudo(a)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 formulario" style="background: #FEF9D9; padding-left: 10px; padding-right: 10px">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Fecha Nacimiento</label>
                                                                            <input type="date" class="form-control" id="InputFechaNacimientoGrupo" onchange="calcularEdadGrupo()">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 formulario" style="background: #FEF9D9; padding-left: 10px; padding-right: 10px">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Edad</label>
                                                                            <input type="text" class="form-control" id="InputEdadGrupo" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 formulario" style="background: #FEF9D9; text-align: center">
                                                                        <div class="mb-3">
                                                                            <a href="#" id="btn-registrar-cliente-grupo" class="btn btn-primary ms-auto" style="width: 100%">
                                                                                Registrar Cliente y Agregar
                                                                            </a>
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

                                    $('#div-habitaciones-form').append(habitacionHtml);
                
                                    var categoriaHabitacion = response[0].CategoriaHabitacion;
                                    $('#CategoriaHabitacionGrupo').val(categoriaHabitacion);

                                    if (response[0].GuiaTuristica === "true") {
                                        $('#habitacion-tipo').hide();
                                        $('#precio-habitacion').hide();
                                        $('#mensaje-guia').show();
                                        $('#check-guia').prop('checked', true);
                                    } else {
                                        $('#habitacion-tipo').show();
                                        $('#precio-habitacion').show();
                                        $('#mensaje-guia').hide();
                                        $('#check-guia').prop('checked', false);
                                    }

                                    $('#check-guia').change(function() {
                                        if ($(this).is(':checked')) {
                                            $('#habitacion-tipo').hide();
                                            $('#precio-habitacion').hide();
                                            $('#mensaje-guia').show();
                                        } else {
                                            $('#habitacion-tipo').show();
                                            $('#precio-habitacion').show();
                                            $('#mensaje-guia').hide();
                                        }
                                    });

                                    $('#btn-eliminar-habitacion-grupo').off('click').on('click', function(event) {
                                        event.preventDefault();
                                        let HospedajeId = $(this).data('id');
                                    
                                        Swal.fire({
                                            title: '¿Estás seguro?',
                                            text: "No podrás recuperar este hospedaje después de eliminarlo.",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Sí, eliminarlo',
                                            cancelButtonText: 'Cancelar'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                var data = {
                                                    HospedajeId: HospedajeId,
                                                };
                                    
                                                $.ajax({
                                                    url: '/apihostal/eliminar-hospedaje-cliente-grupo',
                                                    method: 'POST',
                                                    data: data,
                                                    success: function(IdGrupo) {
                                                        cargarHabitacionesGrupo(IdGrupo);
                                                        cargarHabitacionesEnSelect(IdGrupo);
                                                        InformacionGrupo(id);
                                                        $('#div-habitaciones-form').empty();
                                                        MostrarMensaje("Eliminado Exitosamente", "success");
                                                    },
                                                    error: function() {
                                                        alert("Error al registrar el cliente.");
                                                    }
                                                });
                                            }
                                        });
                                    });
                
                                    convertirMayusculas();
                                    TraerPaisesNacionalidad();
                                    TraerPaisesNacionalidadGrupo();
                                    cargarClientesHospedajeGrupo(hospedajeID)
                
                                    $('#PassaporteInputGrupo').on('input', function() {
                                        var query = $(this).val().trim();
                                        var $divFormulario = $('#div-formulario');
                                        var $divClientes = $('#div-clientes'); 
                                        $divClientes.empty();
                                    
                                        if (query === '') {
                                            $divFormulario.addClass('d-none');
                                            return;
                                        }            
                                        
                                        $.ajax({
                                            url: '/apihostal/get-clientes-hostal',
                                            method: 'GET',
                                            data: { query: query },
                                            success: function(response) {
                                                var clientesHtml = '';
                                                if (response.length > 0) {
                                                    $.each(response, function(index, cliente) {
                                                        clientesHtml += `
                                                            <a class="dropdown-item cliente-seleccionado" href="#" data-id="${cliente.id}">
                                                                ${cliente.Nombre_cliente} ${cliente.Apellido_cliente} - ${cliente.Documento_cliente}
                                                            </a>`;
                                                    });
                                                    $divClientes.html(clientesHtml);
                                                    $divFormulario.addClass('d-none');
                                                } else {
                                                    $divFormulario.removeClass('d-none');
                                                }
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                console.error("Error al buscar cliente:", textStatus);
                                            }
                                        });
                                        
                                        $(document).off('click').on('click', '.cliente-seleccionado', function(e) {
                                            e.preventDefault();
                                            var clienteId = $(this).data('id');
                                            const IdHospedajeGrupo = hospedajeID;
                                            const CategoriaHabitacionGrupo = $('#CategoriaHabitacionGrupo').val()
                
                                            const enviardatos = {
                                                IdHospedajeGrupo: IdHospedajeGrupo,
                                                IdCliente: clienteId,
                                                CategoriaHabitacionGrupo: CategoriaHabitacionGrupo
                                            };
                                            
                                            $.ajax({
                                                url: '/apihostal/agregar-hospedaje-cliente-grupo',
                                                method: 'POST',
                                                data: enviardatos,
                                                success: function(response) {
                                                    $('#PassaporteInputGrupo').val('')
                                                    var $divClientes = $('#div-clientes'); 
                                                    $divClientes.empty();
                                                    cargarHabitacionesGrupo(id)
                                                    cargarClientesHospedajeGrupo(response.id)
                                                    InformacionGrupo(id)
                                                    MostrarMensaje("Pasajeros Agregados Habitacion", "success")                                        
                                                },
                                                error: function(jqXHR, textStatus, errorThrown) {
                                                    console.error('Error al recuperar:', textStatus, errorThrown);
                                                }
                                            });
                                        });
                                        
                                    });
                
                                    $('#btn-registrar-cliente-grupo').off('click').on('click', function(event) {
                                        event.preventDefault();
                                        const PassaporteInputGrupo = $('#PassaporteInputGrupo').val()
                                        const InputNombresGrupo = $('#InputNombresGrupo').val()
                                        const InputApellidosGrupo = $('#InputApellidosGrupo').val()
                                        const InputProfesionGrupo = $('#InputProfesionGrupo').val()
                                        const InputNacionalidadGrupo = $('#InputNacionalidadGrupo').val()
                                        const InputEstadoCivilGrupo = $('#InputEstadoCivilGrupo').val()
                                        const InputFechaNacimientoGrupo = $('#InputFechaNacimientoGrupo').val()
                                        const InputEdadGrupo = $('#InputEdadGrupo').val()
                                        const IdHospedajeGrupo = hospedajeID;
                    
                                        const dataToSend = {
                                            Documento_cliente: PassaporteInputGrupo,
                                            Nombre_cliente: InputNombresGrupo,
                                            Apellido_cliente: InputApellidosGrupo,
                                            Profesion_cliente: InputProfesionGrupo,
                                            Nacionalidad_cliente: InputNacionalidadGrupo,
                                            EstadoCivil_cliente: InputEstadoCivilGrupo,
                                            FechaNacimiento_cliente: InputFechaNacimientoGrupo,
                                            Edad_cliente: InputEdadGrupo,
                                            IdHospedajeGrupo: IdHospedajeGrupo,
                                        };
                                        
                                        if (!InputNombresGrupo || !InputApellidosGrupo || !PassaporteInputGrupo || !InputProfesionGrupo || !InputNacionalidadGrupo || !InputFechaNacimientoGrupo || !InputEdadGrupo ) {
                                            MostrarMensaje("Por favor completa los campos requeridos", "error");
                                            return;
                                        }
                
                                        var $divFormulario = $('#div-formulario');
                
                                        $.ajax({
                                            url: '/apihostal/registrar-cliente-hostal',
                                            method: 'POST',
                                            data: dataToSend,
                                            success: function(cliente) {
                                                MostrarMensaje("Pasajeros Agregados Exitosamente", "success")
                                                $divFormulario.addClass('d-none');
                                                $('#PassaporteInputGrupo').val('')
                                                $('#InputNombresGrupo').val('')
                                                $('#InputApellidosGrupo').val('')
                                                $('#InputProfesionGrupo').val('')
                                                $('#InputNacionalidadGrupo').val('')
                                                $('#InputEstadoCivilGrupo').val('')
                                                $('#InputFechaNacimientoGrupo').val('')
                                                $('#InputEdadGrupo').val('')
                                                
                                                const enviardatos = {
                                                    IdHospedajeGrupo: IdHospedajeGrupo,
                                                    IdCliente: cliente.id,
                                                };
                                                
                                                $.ajax({
                                                    url: '/apihostal/agregar-hospedaje-cliente-grupo',
                                                    method: 'POST',
                                                    data: enviardatos,
                                                    success: function(response) {
                                                        cargarHabitacionesGrupo(id)
                                                        cargarClientesHospedajeGrupo(response.id)
                                                        MostrarMensaje("Pasajeros Agregados Habitacion", "success")                                        
                                                    },
                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                        console.error('Error al recuperar:', textStatus, errorThrown);
                                                    }
                                                });
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                console.error('Error al recuperar:', textStatus, errorThrown);
                                            }
                                        });
                                    });

                                    $('#btn-actualizar-datos-grupo').off('click').on('click', function(event) {
                                        event.preventDefault();
                                        
                                        const PrecioHabitacionGrupo = $('#PrecioHabitacionGrupo').val();
                                        const IdHospedajeGrupo = hospedajeID;
                                        const CategoriaHabitacionGrupo = $('#CategoriaHabitacionGrupo').val();
                                        const Guia = $('#check-guia').prop('checked');
                                    
                                        const dataToSend = {
                                            CategoriaHabitacionGrupo: CategoriaHabitacionGrupo,
                                            IdHospedajeGrupo: IdHospedajeGrupo,
                                            PrecioHabitacionGrupo: PrecioHabitacionGrupo,
                                            Guia: Guia
                                        };
                                    
                                        $.ajax({
                                            url: '/apihostal/actualizar-hospedaje-grupo',
                                            method: 'POST',
                                            data: dataToSend,
                                            success: function(response) {
                                                MostrarMensaje("Datos Actualizados Exitosamente", "success");
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                console.error('Error al recuperar:', textStatus, errorThrown);
                                            }
                                        });
                                    });
                                                                       
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error("Error al cargar las habitaciones:", textStatus);
                                }
                            });                           
                            
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error al cargar las habitaciones:", textStatus);
                    }
                });
            }
            
            
            function cargarHabitacionesEnSelect(id) {
                $.ajax({
                    url: '/apihostal/get-habitaciones-disponibles-grupo/'+id,
                    method: 'GET',
                    success: function(response) {
                        var selectHabitaciones = $('#SelectHabitacionesGrupo');
                        selectHabitaciones.empty();
                        $.each(response, function(index, habitacion) {
                            selectHabitaciones.append(new Option(`${habitacion.Nombre_habitacion}`, habitacion.id));
                        });
                        selectHabitaciones.select2({
                            placeholder: "Selecciona habitaciones...",
                            allowClear: true,
                            width: '75%'
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error al cargar las habitaciones:", textStatus);
                    }
                });
            }
        
            function cargarClientesHospedajeGrupo(id) {
                $.ajax({
                    url: '/apihostal/get-clientes-hospedajes/' + id,
                    method: 'GET',
                    success: function(data) {
                        $('#table-pasajeros-grupo tbody').empty();
                        
                        data.detallehospedajes.forEach(function(detalle) {
                            let cliente = detalle.cliente;
                            let fila = `
                                <tr>
                                    <td>${cliente.Documento_cliente}</td>
                                    <td>${cliente.Nombre_cliente} ${cliente.Apellido_cliente}</td>
                                    <td>${cliente.Nacionalidad_cliente}</td>
                                    <td>
                                        <span class="badge bg-red text-red-fg btn-eliminar-cliente" data-detallecliente-id="${detalle.id}">X</span>
                                    </td>
                                </tr>
                            `;
                            
                            $('#table-pasajeros-grupo tbody').append(fila);
                        });
                        
                        $(document).off('click').on('click', '.btn-eliminar-cliente', function() {
                            let DetalleHospedajeId = $(this).data('detallecliente-id');
                            var data = {
                                DetalleHospedajeId: DetalleHospedajeId,
                            };
                        
                            $.ajax({
                                url: '/apihostal/eliminar-detalle-hospedaje-cliente-grupo',
                                method: 'POST',
                                data: data,
                                success: function(IdGrupo) {
                                    cargarHabitacionesGrupo(IdGrupo);
                                    cargarClientesHospedajeGrupo(id)
                                    MostrarMensaje("Eliminado Exitosamente","success")
                                },
                                error: function() {
                                    alert("Error al registrar el cliente.");
                                }
                            });
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error al obtener los clientes:', textStatus, errorThrown);
                    }
                });
            }
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

function MostrarDivTotal(total){
    $('#TotalGrupo').text('Bs. '+total);
}

function MostrarDivCantidad(cantidad){
    $('#SpanCantidad').text((cantidad + (cantidad > 1 ? ' registros' : ' registro')));
}

function convertirMayusculas() {
    const inputs = document.querySelectorAll('.convertmayusculas');
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            input.value = input.value.toUpperCase();
        });
    });
}

function calcularEdadGrupo() {
    const fechaNacimiento = document.getElementById("InputFechaNacimientoGrupo").value;
    const fechaNacimientoDate = new Date(fechaNacimiento);
    const hoy = new Date();
    
    let edad = hoy.getFullYear() - fechaNacimientoDate.getFullYear();
    const mes = hoy.getMonth() - fechaNacimientoDate.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimientoDate.getDate())) {
        edad--;
    }

    document.getElementById("InputEdadGrupo").value = edad;
}

function TraerPaisesNacionalidadGrupo() {
    const jsonUrl = '/utilidades/json/countries.json';
    const nacionalidadSelect = $('#InputNacionalidadGrupo');

    if (nacionalidadSelect.hasClass("select2-hidden-accessible")) {
        nacionalidadSelect.select2('destroy');
    }

    $.ajax({
        url: jsonUrl,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            nacionalidadSelect.empty();
            nacionalidadSelect.append('<option value="">Selecciona un país</option>');

            $.each(data.countries, function(index, country) {
                nacionalidadSelect.append(`<option value="${country.nationality}">${country.name}</option>`);
            });

            nacionalidadSelect.select2({
                dropdownParent: $('#modal-asiganar-habitacion'),
                placeholder: 'Selecciona un país',
                allowClear: true,
                width: '100%',
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al cargar el archivo JSON:', textStatus);
        }
    });    
}  



