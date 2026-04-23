$(document).ready(function() {
    ListarDatosCategoriaRecursos()

    $('#searchcategoria').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();

        $('#tabla-registrar-categoria tbody tr').filter(function() {
            $(this).toggle(
                $(this).find('td:nth-child(2)').text().toLowerCase().includes(searchText) ||
                $(this).find('td:nth-child(3)').text().toLowerCase().includes(searchText) ||
                $(this).find('td:nth-child(4)').text().toLowerCase().includes(searchText)
            );
        });
    });
});

$(document).ready(function() {  
    document.getElementById('addcategoria').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Cliente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Perteneciente a</label>
                        <div class="col">
                            <select class="form-control" id="PerteneceCategoria">
                                <option value="Hostal">Hostal</option>
                                <option value="Salones">Salones</option>
                                <option value="Restaurante">Restaurante</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control convertirmayuscula" id="NombreCategoria" name="NombreCategoria">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Descripcion</label>
                        <div class="col">
                        <input type="mail" class="form-control convertirmayuscula" id="DescripcionCategoria" name="DescripcionCategoria">
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-categoria">GUARDAR</button>
                </div>
            </div>
        </form>
        `;
        
        convertirMayusculas()
        convertirEntero() 

        $('#btn-registrar-categoria').off('click').on('click', function(event) {
            var PerteneceCategoria = $("#PerteneceCategoria").val();
            var NombreCategoria = $("#NombreCategoria").val();
            var DescripcionCategoria = $("#DescripcionCategoria").val();

            var formData = new FormData();
            formData.append('PerteneceCategoria', PerteneceCategoria);
            formData.append('NombreCategoria', NombreCategoria);
            formData.append('DescripcionCategoria', DescripcionCategoria);
            
            $.ajax({
                url: '/apihostal/registrar-categoria-recurso',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (cliente) {
                    ListarDatosCategoriaRecursos()
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

function ListarDatosCategoriaRecursos() {
    $.ajax({
        url: '/apihostal/get-categoria-recurso',
        type: 'GET',
        success: function(categorias) {
            $('#tabla-registrar-categoria tbody').empty();

            $.each(categorias, function(index, categoria) {
                var fechaFormateada = new Date(categoria.created_at).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                var row = '<tr>' +
                    '<td hidden>' + categoria.id + '</td>' +
                    '<td>' + categoria.nombre + '</td>' +
                    '<td>' + categoria.descripcion + '</td>' +
                    '<td>' + categoria.pertenece + '</td>' +
                    '<td>' + fechaFormateada + '</td>' +
                    '</tr>';

                $('#tabla-registrar-categoria tbody').append(row);
            });

            $('#tabla-registrar-categoria tbody').on('click', 'tr', function() {
                $('#tabla-registrar-categoria tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');
                var id = $(this).find('td:first').text();
                
                $.ajax({
                    url: '/apihostal/get-categoria-recurso-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionCategoriaRecurso(data);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de producto:', error);
                    }
                });
            });
        },
        error: function(error) {
            console.error('Error al recuperar datos de producto:', error);
        }
    });
}

function InformacionCategoriaRecurso(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">${data.nombre}</h3>
                <div class="card-actions">
                    <a href="#" class="btn" data-cleinte-id="${data.id}" id="DeleteGasto" data-bs-toggle="modal" data-bs-target="#modal-danger">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </a>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Pertenece</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.pertenece}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.nombre}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Descripcion</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.descripcion}</label>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

function convertirMayusculas() {
    document.querySelectorAll('.convertirmayuscula').forEach(element => {
        element.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
}

function convertirEntero() {
    document.querySelectorAll('.convertirnumero').forEach(element => {
        element.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, ''); 
        });
    });
}