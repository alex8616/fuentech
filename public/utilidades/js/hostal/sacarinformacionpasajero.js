$(document).ready(function() {
    $('#ObtenidoFechaNacimiento').on('change', function() {
        let fechaNacimiento = $(this).val();
        let edad = calcularEdad(fechaNacimiento);
        $('#ObtenidoEdad').val(edad);
    });


    $('#btn-sacar-datos-imagen').on('click', function(e) {
        e.preventDefault(); // Evita que se recargue la página

        let formData = new FormData();
        let fileInput = $('#InputSubirImagen')[0].files[0];

        if (!fileInput) {
            console.error("Por favor, selecciona una imagen.");
            return;
        }

        formData.append('image', fileInput);

        $.ajax({
            url: '/upload',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("Datos extraídos:", response);

                // Llenar los campos con los datos extraídos
                $('#ObtenidoNDocumento').val(response.numero_documento || '');
                $('#ObtenidoNombres').val(response.nombres || '');
                $('#ObtenidoApellidos').val(response.apellidos || '');
                $('#ObtenidoNacionalidad').val(response.nacionalidad || '');
                $('#ObtenidoProfesion').val(response.profesion || '');

                let fechaConvertida = convertirFecha(response.fecha_nacimiento);
                $('#ObtenidoFechaNacimiento').val(fechaConvertida);

                // Llamar a verificarCampos() después de llenar los datos
                verificarCampos();
            },
            error: function(xhr, status, error) {
                console.error("Error al procesar la imagen:", xhr.responseText);
            }
        });

    });

    // Detectar cambios manuales en los inputs
    $('#ObtenidoNDocumento, #ObtenidoNombres, #ObtenidoApellidos').on('input', verificarCampos);

    // Desactivar el botón al inicio
    verificarCampos();


    $('#btn-registrar-por-IA').on('click', function(e) {
        e.preventDefault(); 

        var data = {
            Documento_cliente: $('#ObtenidoNDocumento').val(),
            Nombre_cliente: $('#ObtenidoNombres').val(),
            Apellido_cliente: $('#ObtenidoApellidos').val(),
            Profesion_cliente: $('#ObtenidoProfesion').val(),
            Nacionalidad_cliente: $('#ObtenidoNacionalidad').val(),
            FechaNacimiento_cliente: $('#ObtenidoFechaNacimiento').val(),
            Edad_cliente: $('#ObtenidoEdad').val(),
            EstadoCivil_cliente: 'Soltero(a)',
        };
    
        $.ajax({
            url: '/apihostal/registrar-cliente-hostal',
            method: 'POST',
            data: data,
            success: function(response) {
                document.getElementById("collapse-2").classList.remove("show");
                $('#ObtenidoNDocumento').val(''),
                $('#ObtenidoNombres').val(''),
                $('#ObtenidoApellidos').val(''),
                $('#ObtenidoProfesion').val(''),
                $('#ObtenidoNacionalidad').val(''),
                $('#ObtenidoFechaNacimiento').val(''),
                $('#ObtenidoEdad').val(''),
                MostrarMensaje("Huesped Registrado Exitosamente", "success")
                $('#InputCiPassaporte').val(response.Documento_cliente)
            },
            error: function(xhr, status, error) {
                const errorMessage = xhr.responseJSON?.error || "Error desconocido al registrar el cliente.";
                MostrarMensaje(errorMessage, "error")
            }
        });
        
    });

});

function convertirFecha(fecha) {
    if (!fecha) return '';
    let partes = fecha.split('/');
    if (partes.length === 3) {
        return `${partes[2]}-${partes[1].padStart(2, '0')}-${partes[0].padStart(2, '0')}`;
    }
    return '';
}

function verificarCampos() {
    let documento = $('#ObtenidoNDocumento').val().trim();
    let nombres = $('#ObtenidoNombres').val().trim();
    let apellidos = $('#ObtenidoApellidos').val().trim();

    if (documento !== '' && nombres !== '' && apellidos !== '') {
        $('#btn-registrar-por-IA').prop('disabled', false);
    } else {
        $('#btn-registrar-por-IA').prop('disabled', true);
    }
}

function calcularEdad(fechaNacimiento) {
    if (!fechaNacimiento) return ''; // Si no hay fecha, devolver vacío

    let fechaNac = new Date(fechaNacimiento);
    let hoy = new Date();

    let edad = hoy.getFullYear() - fechaNac.getFullYear();
    let mes = hoy.getMonth() - fechaNac.getMonth();
    let dia = hoy.getDate() - fechaNac.getDate();

    // Si aún no ha cumplido años en el mes actual, restar 1
    if (mes < 0 || (mes === 0 && dia < 0)) {
        edad--;
    }

    return edad;
}