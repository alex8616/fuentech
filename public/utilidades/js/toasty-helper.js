function MostrarMensaje(message, status) {
    const statusColors = {
        success: '#2ecc71',
        error: '#e74c3c',
        warning: '#f39c12',
        info: '#3498db',
    };

    const backgroundColor = statusColors[status] || '#3498db';

    const iconElement = document.createElement('i');
    iconElement.className = getStatusIconClass(status);

    const container = document.createElement('div');
    container.appendChild(iconElement);
    container.appendChild(document.createTextNode(message));

    Toastify({
        node: container,
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
    container.style.display = 'flex';
    container.style.flexDirection = 'row';
    container.style.alignItems = 'center';

    const textNode = document.createTextNode(message);
    container.appendChild(textNode);

    const botonesContainer = document.createElement('div');
    botonesContainer.style.display = 'flex';
    botonesContainer.style.marginLeft = '10px'; 

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
    botonNo.style.marginLeft = '10px';
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
    const iconClasses = {
        success: 'fas fa-check-circle',
        error: 'fas fa-times-circle',
        warning: 'fas fa-exclamation-circle',
        info: 'fas fa-info-circle',
    };

    return iconClasses[status] || 'fas fa-info-circle';
}

function CanvasTime(){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-body">
                <h3 class="card-title" style="color: #424769">Sin Seleccionar Nada, En Espera ...</h3>
                </div>
                <div class="img-responsive img-responsive-21x21 card-img-bottom" style="background-image: url('/utilidades/svg/espera.svg')"></div>
            </div>
        </div>
    `;        
}

function mostrarCargandoDatos() {
    const cargandoHtml = `
        <div id="cargandoDatos" class="page page-center" style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999; /* Asegura que esté encima de todo */
        ">
            <div class="container container-slim py-4">
                <div class="text-center">
                    <div class="text-muted mb-3" style="font-size: 18px; font-weight: bold;">
                        Espera ... Cargando Datos
                    </div>
                    <div class="progress progress-sm" style="width: 50%; margin: 0 auto;">
                        <div class="progress-bar progress-bar-indeterminate" style="
                            background-color: #007bff; /* Azul */
                            height: 8px;
                            animation: indeterminate 1.5s infinite linear;
                        "></div>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', cargandoHtml);
}

function ocultarCargandoDatos() {
    const cargandoElemento = document.getElementById('cargandoDatos');
    if (cargandoElemento) {
        cargandoElemento.remove();
    }
}

function mostrarMensajeSinConexion() {
    const cargandoHtml = `
        <div id="sinConexion" class="page page-center" style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999; /* Asegura que esté encima de todo */
        ">
            <div class="container container-slim py-4">
                <div class="text-center">

                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> <radialGradient id="RG1" cx="50%" cy="50%" fx="50%" fy="50%" r="50%"> <stop style="stop-color:#679bcb;stop-opacity:0.75;" offset="0%"></stop> <stop style="stop-color:#123141;stop-opacity:1;" offset="100%"></stop> </radialGradient> </defs> <ellipse cx="35" cy="34" rx="32" ry="30" style="stroke-width:4;stroke:#dddddd;fill:none;"></ellipse> <ellipse cx="35" cy="34" rx="32" ry="30" style="fill:url(#RG1);fill-opacity:1;fill-rule:nonzero"></ellipse> <g style="fill:none;stroke:#aaaaaa;stroke-width:1.5px;stroke-linecap:butt;"> <path d="M 36,64 C 22,56 19,46 19,34 19,22 26,10 36,4 l 0,60 C 36,64 54,55 54,34 54,13 36,4 36,4"></path> <path d="m 4,34 63,0 0,0"></path> <path d="m 13,15 c 0,0 12,7 23,7 13,0 23,-7 23,-7"></path> <path d="m 13,54 c 0,0 9,-7 23,-7 16,0 23,7 23,7"></path> </g> <ellipse cx="35" cy="34" rx="32" ry="30" style="stroke-width:3;stroke:#123141;fill:none;"></ellipse> <ellipse cx="35" cy="22" rx="5" ry="5" style="fill:#000000;stroke:#cccccc;stroke-width:2"></ellipse> <path style="fill:none;stroke:#000000;stroke-width:4;" d="M 38,81 C 12,92 3.9,67 10,58 17,46 32,46 39,35 41,32 41,25 36,22"></path> <path style="fill:#FF3D3D;stroke:#730000;stroke-width:3;fill-opacity:0.85" d="M 15,4.6 5,15 25,35 5.5,55 15,65 35,45 55,65 65,55 45,35 65,14 55,4.6 35,25 z"></path> <path style="fill:#111111;stroke:#666666" d="m 60,87 0,5 c 0,0 -3,0 -4,0 -2,0 -3,3 -3,3 1,0 26,0 27,0 0,0 -1,-3 -3,-3 -1,0 -4,0 -4,0 l 0,-5"></path> <path style="fill:#ffffff;stroke:#000000;stroke-width:4px;stroke-linecap:butt" d="m 39,83 c 0,-8 0,-25 0,-31 0,-2 0,-5 3,-5 6,0 45,0 48,0 3,0 3,3 3,7 0,6 0,26 0,29 0,1 0,3 -5,3 -3,0 -43,0 -46,0 -3,0 -3,-3 -3,-3 z"></path> <path style="fill:#444444;stroke:#ffffff" d="m 41,49 50,0 0,35 -50,0 z"></path> </g></svg>

                    <div class="text-muted mb-3" style="font-size: 18px; font-weight: bold;">
                        No tienes conexión a internet.
                    </div>
                    <div class="progress progress-sm" style="width: 50%; margin: 0 auto;">
                      
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', cargandoHtml);
}

function ocultarMensajeSinConexion() {
    const mensaje = document.getElementById('sinConexion');
    if (mensaje) {
        mensaje.remove();
    }
}