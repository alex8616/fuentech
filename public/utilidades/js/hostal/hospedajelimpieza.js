function LimpiezaHabitacion(id) {
    $('#form_tabs').empty();

    var HabitacionForm = `
        <div class="card-header" style="width: 100%; background-color: #f76707; color: white">
            <h3 class="card-title">Habitacion #${id}</h3>
        </div>
        <div class="card-body">
            <div class="datagrid">
                Desea Terminar La Limpieza De La Habitacion?
            </div>
        </div>
        <div class="card-footer">
             <div class="d-flex-end" style="text-align: right">
                <button type="button" class="btn btn-primary" id="btn-terminar-limpieza-habitacion">Terminar Limpieza</button>
            </div>
        </div>        
    `;
    $('#form_tabs').append(HabitacionForm);

    $('#btn-terminar-limpieza-habitacion').on('click', function(event) {
        event.preventDefault();
    
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Estás quieres terminar la limpieza de la habitacion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const dataToSend = {
                    idhabitacion: id
                };
    
                $.ajax({
                    url: '/apihostal/cambiar-estado-habitacion-hospedaje',
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
    
}   