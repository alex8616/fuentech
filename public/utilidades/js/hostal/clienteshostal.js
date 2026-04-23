let currentPage = 1;
let isLoading = false;
const limit = 10;

$(document).ready(function() {
    ListarDatos(currentPage, limit);

    let searchTimeout;

    $('#searchclientehostal').on('input', function() {
        clearTimeout(searchTimeout);
        const search = $(this).val();

        searchTimeout = setTimeout(function() {
            ListarDatos(1, 15, search);
        }, 300);
    });
});

function ListarDatos(page = 1, limit = 15, search = '') {
    if (isLoading) return;
    isLoading = true;

    $.ajax({
        url: '/apihostal/get-clientes-hostal-paginate',
        type: 'GET',
        data: { page: page, limit: limit, search: search },
        dataType: 'json',
        success: function(response) {
            const clientes = response.data;

            if (page === 1) {
                $('#tabla-clientes tbody').empty();
            }

            // Calcular el número inicial para la enumeración
            const startNumber = (page - 1) * limit + 1;

            $.each(clientes, function(index, cliente) {
                var row = '<tr>' +
                    '<td hidden>' + cliente.id + '</td>' +
                    '<td>' + (startNumber + index) + '</td>' +  // Número de fila
                    '<td>' + cliente.NombreCompleto_cliente + '</td>' +
                    '<td>' + cliente.Documento_cliente + '</td>' +
                    '<td>' + cliente.Nacionalidad_cliente + '</td>' +
                    '<td>' + cliente.Edad_cliente + '</td>' +
                    '<td>' + cliente.EstadoCivil_cliente + '</td>' +
                    '</tr>';

                $('#tabla-clientes tbody').append(row);
            });

            $('#tabla-clientes tbody').on('click', 'tr', function() {
                $('#tabla-clientes tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');
                
                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/apihostal/get-cliente-hostal-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionCliente(data);
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

            isLoading = false;
        },
        error: function(error) {
            console.error('Error al recuperar datos:', error);
            isLoading = false;
        }
    });
}
$('#cargar-mas-clientes').on('click', function() {
    currentPage++;
    ListarDatos(currentPage, limit);
});


function InformacionCliente(data){
    console.log(data)
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">${data.NombreCompleto_cliente}</h3>
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
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Nombre_cliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Apellido</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Apellido_cliente}</label>
                            </div>
                        </div>                        
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Nacionalidad</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Nacionalidad_cliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Profesion</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Profesion_cliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Edad</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Edad_cliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Estado Civil</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.EstadoCivil_cliente}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Celular</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.Celular_cliente}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

$(document).ready(function() {  
    document.getElementById('addclientes').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Cliente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Documento</label>
                        <div class="col">
                        <input type="text" class="form-control convertmayusculas" id="Documento_cliente" name="Documento_cliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control convertmayusculas" id="Nombre_cliente" name="Nombre_cliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Apellido</label>
                        <div class="col">
                        <input type="mail" class="form-control convertmayusculas" id="Apellido_cliente" name="Apellido_cliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nacionalidad</label>
                        <div class="col">
                            <select class="form-control" id="SelectNacionalidad"></select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label">Profesion</label>
                        <div class="col">
                            <input class="form-control convertmayusculas" id="Profesion_cliente" name="Profesion_cliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Fecha Nacimiento</label>
                        <div class="col">
                            <input type="date" class="form-control" id="FechaNacimiento_cliente" name="FechaNacimiento_cliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Edad</label>
                        <div class="col">
                            <input class="form-control" id="Edad_cliente" name="Edad_cliente">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Estado Civil</label>
                        <div class="col">
                            <select class="form-control" id="EstadoCivil_cliente">
                                <option value="Soltero">Soltero</option>
                                <option value="Casado">Casado</option>
                                <option value="Viudo">Viudo</option>
                            </select>
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-cliente-hostal">GUARDAR</button>
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

        TraerPaisesNacionalidadGrupo()

        $('#FechaNacimiento_cliente').on('change', function() {
            var birthDate = new Date($(this).val());
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDifference = today.getMonth() - birthDate.getMonth();
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            $('#Edad_cliente').val(age);
        });

        $('#btn-registrar-cliente-hostal').off('click').on('click', function(event) {
            var Nombre_cliente = $("#Nombre_cliente").val();
            var Apellido_cliente = $("#Apellido_cliente").val();
            var Documento_cliente = $("#Documento_cliente").val();
            var Nacionalidad_cliente = $("#SelectNacionalidad").val();
            var Profesion_cliente = $("#Profesion_cliente").val();
            var FechaNacimiento_cliente = $("#FechaNacimiento_cliente").val();
            var Edad_cliente = $("#Edad_cliente").val();
            var EstadoCivil_cliente = $("#EstadoCivil_cliente").val();

            var formData = new FormData();
            formData.append('Nombre_cliente', Nombre_cliente);
            formData.append('Apellido_cliente', Apellido_cliente);
            formData.append('Documento_cliente', Documento_cliente);
            formData.append('Nacionalidad_cliente', Nacionalidad_cliente);
            formData.append('Profesion_cliente', Profesion_cliente);
            formData.append('FechaNacimiento_cliente', FechaNacimiento_cliente);
            formData.append('Edad_cliente', Edad_cliente);
            formData.append('EstadoCivil_cliente', EstadoCivil_cliente);

            $.ajax({
                url: '/apihostal/registrar-cliente-hostal',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (cliente) {
                    ListarDatos(currentPage, limit)
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

function TraerPaisesNacionalidadGrupo() {
    const jsonUrl = '/utilidades/json/countries.json';
    const nacionalidadSelect = $('#SelectNacionalidad');

    if ($.fn.select2 && nacionalidadSelect.hasClass("select2-hidden-accessible")) {
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
