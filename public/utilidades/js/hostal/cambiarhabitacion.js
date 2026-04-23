function manejarcambiarhab(id) {
    var habitacionIdPrivate = id
    $.ajax({
        url: '/apihostal/get-habitacion-ocupada/'+id,
        method: 'GET',
        success: function(response) {
            $('#form_tabs').empty();
            
            var HabitacionForm = `
                <div class="card-header" style="width: 100%; background-color: #d63939; color: white">
                    <h3 class="card-title">Cambiar Habitacion #${id} a</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-5">
                            <span style="font-size: 16px; font-weight: bold">Habitacion #${response.id}</span>
                        </div>
                        <div class="col-12 col-sm-2">
                            <span style="font-size: 16px; font-weight: bold"> A </span>
                        </div>
                        <div class="col-12 col-sm-5">
                            <select class="form-control" id="HabitacionSelect">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex-end" style="text-align: right">
                        <button type="button" class="btn btn-primary" id="btn-cambiar-habitacion" data-id="${response.hospedajehabitacion[0].id}">CAMBIAR HABITACION</button>
                    </div>
                </div>
            `;
            $('#form_tabs').append(HabitacionForm);            
            
            cargarHabitacioneslibres()

            function cargarHabitacioneslibres() {
                $.ajax({
                    url: '/apihostal/get-habitaciones-libres',
                    type: 'GET',
                    dataType: 'json',
                    success: function(habitaciones) {
                        var $select = $('#HabitacionSelect');
                        $select.empty();
                        $select.append('<option value="">Selecciona una habitación</option>');
                        $.each(habitaciones, function(index, habitacion) {
                            $select.append('<option value="' + habitacion.id + '">' + habitacion.Nombre_habitacion + '</option>');
                        });
                    },
                    error: function() {
                        alert('Error al cargar las habitaciones');
                    }
                });
            }

            $('#btn-cambiar-habitacion').off('click').on('click', function(event) {
                event.preventDefault();
                var hospedajeId = $(this).data('id');
                var habitacionSeleccionada = $('#HabitacionSelect').val();

                var data = {
                    hospedajeId: hospedajeId,
                    habitacionSeleccionada: habitacionSeleccionada,
                };
            
                $.ajax({
                    url: '/apihostal/registrar-cambio-habitacion',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        MostrarHabitaciones();
                        CanvasTime();
                        MostrarMensaje("Habitacion Cambiada Exitosamente", "success")
                    },
                    error: function() {
                        alert("Error al registrar el cliente.");
                    }
                });
            });
        }
    });
}

    