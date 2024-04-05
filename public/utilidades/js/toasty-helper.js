function MostrarMensaje(message, status) {
    // Mapeo de estados a colores
    const statusColors = {
        success: '#2ecc71',
        error: '#e74c3c',
        warning: '#f39c12',
        info: '#3498db',
        // Puedes agregar más estados según sea necesario
    };

    // Obtén el color del estado (o un color predeterminado si no coincide)
    const backgroundColor = statusColors[status] || '#3498db';

    // Crea el elemento de icono según el estado
    const iconElement = document.createElement('i');
    iconElement.className = getStatusIconClass(status);

    // Crea un contenedor para el nodo que incluye el icono y el mensaje
    const container = document.createElement('div');
    container.appendChild(iconElement); // Agrega el icono al contenedor
    container.appendChild(document.createTextNode(message)); // Agrega el texto del mensaje al contenedor

    // Configuración de Toastify con el contenedor como nodo
    Toastify({
        node: container, // Utiliza el contenedor como nodo
        duration: 6000,
        gravity: 'bottom',
        position: 'right',
        backgroundColor: backgroundColor,
        className: 'toastify',
        style: {
            borderRadius: '10px',
            boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
            color: '#fff',
            fontSize: '16px',
        },
    }).showToast();
}

function mostrarConfirmacion(message, callback) {
    const container = document.createElement('div');
    container.style.display = 'flex'; // Establecer el contenedor como flexbox
    container.style.flexDirection = 'row'; // Disponer los elementos en una fila
    container.style.alignItems = 'center'; // Centrar verticalmente los elementos

    const textNode = document.createTextNode(message);
    container.appendChild(textNode);

    const botonesContainer = document.createElement('div');
    botonesContainer.style.display = 'flex'; // Establecer contenedor de botones como flexbox
    botonesContainer.style.marginLeft = '10px'; // Agregar un margen entre el texto y los botones

    const botonSi = document.createElement('button');
    botonSi.textContent = 'Sí';
    botonSi.style.backgroundColor = '#2ecc71';
    botonSi.style.color = '#fff';
    botonSi.style.border = 'none';
    botonSi.style.borderRadius = '5px';
    botonSi.style.padding = '5px 10px';
    botonSi.style.cursor = 'pointer';
    botonSi.addEventListener('click', function() {
        callback(true);
        toastify.hideToast();
    });

    const botonNo = document.createElement('button');
    botonNo.textContent = 'No';
    botonNo.style.backgroundColor = '#e74c3c';
    botonNo.style.color = '#fff';
    botonNo.style.border = 'none';
    botonNo.style.borderRadius = '5px';
    botonNo.style.padding = '5px 10px';
    botonNo.style.cursor = 'pointer';
    botonNo.style.marginLeft = '10px'; // Agregar margen entre los botones
    botonNo.addEventListener('click', function() {
        callback(false);
        toastify.hideToast();
    });

    botonesContainer.appendChild(botonSi);
    botonesContainer.appendChild(botonNo);

    container.appendChild(botonesContainer);

    const toastify = Toastify({
        node: container,
        duration: -1,
        gravity: 'bottom',
        position: 'right',
        className: 'toastify',
    }).showToast();
}

function getStatusIconClass(status) {
    // Asocia el estado con la clase de icono de FontAwesome
    const iconClasses = {
        success: 'fas fa-check-circle',
        error: 'fas fa-times-circle',
        warning: 'fas fa-exclamation-circle',
        info: 'fas fa-info-circle',
    };

    return iconClasses[status] || 'fas fa-info-circle'; // Icono predeterminado
}
