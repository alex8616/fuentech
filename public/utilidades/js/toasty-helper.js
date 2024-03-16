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
