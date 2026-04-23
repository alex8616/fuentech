function manejarSucio(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Estás a punto de cambiar el estado de la habitación!",
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
                url: '/apihostal/cambiar-estado-habitacion-hospedaje-sucio',
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
}   