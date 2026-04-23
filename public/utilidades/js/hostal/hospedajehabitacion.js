function hospedarHabitacion(id) {
    $('#form_tabs').empty();
    var HabitacionForm = `
        <div class="card-header" style="width: 100%; background-color: #2fb344; color: white">
            <h3 class="card-title">Habitacion #${id}</h3>
        </div>
        <div class="card-body">
            <div class="datagrid">
                <div class="row">
                    <div class="col-12 col-sm-12" style="padding: 10px">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">TIPO</label>
                                    <select class="form-control" id="CategoriaHabitacion">
                                        <option value="SIMPLE">SIMPLE</option>
                                        <option value="DOBLE">DOBLE</option>
                                        <option value="TRIPLE">TRIPLE</option>
                                        <option value="MATRIMONIAL">MATRIMONIAL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">DOLAR</label>
                                    <input type="text" class="form-control convertNumber" id="DolarInput">
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">      
                                    <label class="form-label">BOLIVIANO</label>
                                    <input class="form-control convertNumber" id="BolivianoInput">
                                </div>
                            </div>                                
                        </div>
                    </div>

                    <div class="col-12 col-sm-12" style="padding: 10px">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">PRECIO HABITACION</label>
                                    <input type="text" class="form-control convertNumber" id="PrecioHabitacion"> 
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">FECHA INGRESO</label>
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <input type="date" class="form-control convertDate" id="DateFechaIngreso" placeholder="Select a date" id="datepicker-default" >
                                        </div>
                                        <div class="col-12 col-sm-5 ">
                                            <input type="time" class="form-control convertTime" id="TimeIngresohora">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">FECHA SALIDA</label>
                                    <input type="date" class="form-control convertDate" id="DateFechaSalida" placeholder="Select a date">
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="col-12 col-sm-12" style="padding: 10px">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label required">PROCEDENTE</label>
                                    <select class="form-control" id="Procedencia">
                                        <option value="">Selecciona una ciudad</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="mb-3">      
                                    <label class="form-label required">DESTINO</label>
                                    <select class="form-control" id="Destino">
                                    </select>
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
                <button type="button" class="btn btn-primary" id="btn-ocupar-habitacion">OCUPAR HABITACION</button>
            </div>
        </div>
    `;        
    $('#form_tabs').append(HabitacionForm);

    setCurrentTime()

    const dolarInput = document.getElementById('DolarInput');
    const bolivianoInput = document.getElementById('BolivianoInput');
    const exchangeRate = 7;
    function convertCurrency(source) {
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
    dolarInput.addEventListener('input', onDolarInput);
    bolivianoInput.addEventListener('input', onBolivianoInput);
    
    
    function toggleInputs() {
        const dolarInput = document.getElementById('DolarInput');
        const bolivianoInput = document.getElementById('BolivianoInput');
        const precioHabitacionInput = document.getElementById('PrecioHabitacion');
        const dolarValue = parseFloat(dolarInput.value) || 0;
        const bolivianoValue = parseFloat(bolivianoInput.value) || 0;
        const precioHabitacionValue = parseFloat(precioHabitacionInput.value) || 0;
        if (precioHabitacionValue !== 0) {
            dolarInput.disabled = true;
            bolivianoInput.disabled = true;
        } else {
            dolarInput.disabled = false;
            bolivianoInput.disabled = false;
    
            if (dolarValue === 0 || bolivianoValue === 0) {
                precioHabitacionInput.disabled = false;
            } else {
                precioHabitacionInput.disabled = true;
            }
        }
    }
    document.getElementById('DolarInput').addEventListener('input', toggleInputs);
    document.getElementById('BolivianoInput').addEventListener('input', toggleInputs);
    document.getElementById('PrecioHabitacion').addEventListener('input', toggleInputs);
    

    $('#btn-ocupar-habitacion').on('click', function(event) {
        event.preventDefault();
    
        const categoriaHabitacion = $('#CategoriaHabitacion').val();
        const dolarInput = $('#DolarInput').val();
        const bolivianoInput = $('#BolivianoInput').val();
        const fechaIngreso = $('#DateFechaIngreso').val();
        const horaIngreso = $('#TimeIngresohora').val();
        const fechaSalida = $('#DateFechaSalida').val();
        const PrecioHabitacion = $('#PrecioHabitacion').val();
        const procedencia = $('#Procedencia').val();
        const destino = $('#Destino').val();
        const pasajeros = $('#PasajerosSelect').val();
        const habitacionId = id;
    
        if (procedencia === "" || destino === "") {
            MostrarMensaje("Por favor selecciona tanto la Procedencia como el Destino.","warning")
            return;
        }
    
        const dataToSend = {
            categoriaHabitacion: categoriaHabitacion,
            dolarInput: dolarInput,
            bolivianoInput: bolivianoInput,
            fechaIngreso: fechaIngreso,
            horaIngreso: horaIngreso,
            fechaSalida: fechaSalida,
            PrecioHabitacion: PrecioHabitacion,
            procedencia: procedencia,
            destino: destino,
            pasajeros: pasajeros,
            habitacionId: habitacionId
        };
    
        $.ajax({
            url: '/apihostal/registrar-ocupar-habitacion',
            method: 'POST',
            data: dataToSend,
            success: function(response) {
                MostrarHabitaciones();
                MostrarMensaje("Habitación Registrada Exitosamente", "success")
                OcupadoHabitacion(id)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al ocupar la habitación:', textStatus, errorThrown);
            }
        });
    });
    
    $('#btn-ocupar-habitacion-cancelar').on('click', function(event) {
        event.preventDefault();
        CanvasTime();
    });
    
    TraerDepartamentosProcedencia()
    TraerDepartamentosDestino()
    InputNumberConver()
    InputDateConver()

    function TraerDepartamentosProcedencia() {
        const jsonUrl = '/utilidades/json/departamentos.json';
        const procedenciaSelect = $('#Procedencia');
        
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

    function TraerDepartamentosDestino() {
        const jsonUrl = '/utilidades/json/departamentos.json';
        const procedenciaSelect = $('#Destino');
        
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
}
