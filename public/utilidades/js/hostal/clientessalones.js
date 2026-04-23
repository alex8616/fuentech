let currentPageSalon = 1;
let isLoadingSalon = false;
const limitSalon = 10;

$(document).ready(function() {
    ListarDatosClienteSalon(currentPageSalon, limitSalon);
    let searchTimeout;

    $('#searchclientesalon').on('input', function() {
        clearTimeout(searchTimeout);
        const search = $(this).val();

        searchTimeout = setTimeout(function() {
            ListarDatosClienteSalon(1, 15, search);
        }, 300);
    });
});

function ListarDatosClienteSalon(page = 1, limitSalon = 15, search = '') {
    if (isLoadingSalon) return;
    isLoadingSalon = true;

    $.ajax({
        url: '/apihostal/get-clientes-salon-paginate',
        type: 'GET',
        data: { page: page, limitSalon: limitSalon, search: search },
        dataType: 'json',
        success: function(response) {
            const clientes = response.data;

            if (page === 1) {
                $('#tabla-clientes-salon tbody').empty();
            }

            // Calcular el número inicial para la enumeración
            const startNumber = (page - 1) * limitSalon + 1;

            $.each(clientes, function(index, cliente) {
                var row = '<tr>' +
                    '<td hidden>' + cliente.id + '</td>' +
                    '<td>' + (startNumber + index) + '</td>' +
                    '<td>' + cliente.NombreCliente + '</td>' +
                    '<td>' + cliente.CelularCliente + '</td>' +
                    '<td>' + cliente.created_at + '</td>' +
                    '</tr>';

                $('#tabla-clientes-salon tbody').append(row);
            });

            $('#tabla-clientes-salon tbody').on('click', 'tr', function() {
                $('#tabla-clientes-salon tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');
                
                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/apihostal/get-cliente-salon-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionClienteSalon(data);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos:', error);
                    }
                });
            });

            if (!response.next_page_url) {
                $('#cargar-mas-clientes').hide();
            } else {
                $('#cargar-mas-clientes').show();
            }

            isLoadingSalon = false;
        },
        error: function(error) {
            console.error('Error al recuperar datos:', error);
            isLoadingSalon = false;
        }
    });
}
$('#cargar-mas-clientes').on('click', function() {
    currentPageSalon++;
    ListarDatosClienteSalon(currentPageSalon, limitSalon);
});


function InformacionClienteSalon(data){
    console.log(data)
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">${data.NombreCliente}</h3>
                <div class="card-actions">
                    <a href="#" class="btn" data-cleinte-id="${data.id}" id="DeleteGasto" data-bs-toggle="modal" data-bs-target="#modal-danger">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 10 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 10 3.89543 10 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </a>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                <div class="row">
                    <div class="col-12 col-md-12">                        
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.NombreCliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Celular</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.CelularCliente}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

$(document).ready(function() {  
    document.getElementById('addclientessalon').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Cliente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control convertmayusculas" id="NombreCompletoSalon" name="NombreCompletoSalon">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Celular</label>
                        <div class="col">
                        <input type="mail" class="form-control convertmayusculas" id="CelularSalon" name="CelularSalon">
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-cliente-salon">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        function convertirMayusculas() {
            const inputs = document.querySelectorAll('.convertmayusculas');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    input.value = input.value.toUpperCase();
                });
            });
        }
        
        convertirMayusculas()

        $('#btn-registrar-cliente-salon').off('click').on('click', function(event) {
            var NombreCompletoSalon = $("#NombreCompletoSalon").val();
            var CelularSalon = $("#CelularSalon").val();

            var formData = new FormData();
            formData.append('NombreCompletoSalon', NombreCompletoSalon);
            formData.append('CelularSalon', CelularSalon);
           

            $.ajax({
                url: '/apihostal/registrar-cliente-salon',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (cliente) {
                    ListarDatosClienteSalon(currentPageSalon, limitSalon)
                    CanvasTime()
                    MostrarMensaje("Creado Exitosamente","success")
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});
