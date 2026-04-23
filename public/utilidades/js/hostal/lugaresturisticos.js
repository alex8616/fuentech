let currentPage = 1;
let isLoading = false;
const limit = 10;

$(document).ready(function() {
    ListarDatos();

    let searchTimeout;

    $('#searchclientehostal').on('input', function() {
        clearTimeout(searchTimeout);
        const search = $(this).val();

        searchTimeout = setTimeout(function() {
            ListarDatos(1, 15, search);
        }, 300);
    });
});

function ListarDatos() {
    $.ajax({
        url: '/apihostal/get-lugares-turisticos-hostal',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const lugares = response;

            // Destruir la tabla eliminando las filas existentes
            $('#tabla-lugares tbody').empty();

            $.each(lugares, function(index, lugare) {
                var row = '<tr>' +
                    '<td hidden>' + lugare.id + '</td>' +
                    '<td>' + lugare.id + '</td>' +
                    '<td>' + lugare.NombreLugar + '</td>' +
                    '<td>' + lugare.UbicacionLugar + '</td>' +
                    '<td>' + lugare.Estado + '</td>' +
                    '<td>' + lugare.created_at + '</td>' +
                    '</tr>';

                $('#tabla-lugares tbody').append(row);
            });

            $('#tabla-lugares tbody').on('click', 'tr', function() {
                $('#tabla-lugares tbody tr').removeClass('selected-row');
                $(this).addClass('selected-row');

                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/apihostal/get-lugares-seleccionado/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionLugar(data);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos:', error);
                    }
                });
            });

            if (!response.next_page_url) {
                $('#cargar-mas-lugares').hide();
            } else {
                $('#cargar-mas-lugares').show();
            }

            isLoading = false;
        },
        error: function(error) {
            console.error('Error al recuperar datos:', error);
            isLoading = false;
        }
    });
}

function InformacionLugar(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">${data[0].NombreLugar}</h3>
                <div class="card-actions">
                    <a href="#" class="btn" data-lugares-id="${data[0].id}" id="EditarLugar">
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                <div class="row">
                    <div class="col-12 col-md-12">                        
                        ${data[0].Detalle}
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

$(document).on('click', '#EditarLugar', function(event) {
    event.preventDefault(); 
    var lugaresId = $(this).data('lugares-id');
    $.ajax({
        url: '/apihostal/get-lugares-seleccionado/' + lugaresId,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var formTabsDiv = document.getElementById('form_tabs');
            formTabsDiv.innerHTML = `
            <form id="form-register-product">
                <div class="card-header">
                    <h3 class="card-title">Nuevo Lugar</h3>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label required">Nombre Del Lugar</label>
                            <div class="col">
                            <input type="text" class="form-control convertmayusculas" id="Nombre_Lugar_update" name="Nombre_Lugar_update" value="${data[0].NombreLugar}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label required">Coordenadas</label>
                            <div class="col">
                                <input type="text" class="form-control convertmayusculas" placeholder="Ejemplo: -19.588590193553266, -65.7504048257871" id="Coordenadas_Lugar_update" name="Coordenadas_Lugar_update" value="${data[0].UbicacionLugar}">
                                <small class="form-hint">Nota debes copiar y pegar "ctr+V"</small>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label required">Estado</label>
                            <div class="col">
                                <select class="form-control" id="Estado_Lugar_Update">
                                    <option value="true">Activo</option>
                                    <option value="false">Desactivado</option>
                                </select>
                            </div>
                        </div>

                        <div id="editor"></div>

                    </div>                    
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="btn-actualizar-lugares-hostal">ACTUALIZAR</button>
                    </div>
                </div>
            </form>
            `;

            var estado = data[0].Estado;
            $('#Estado_Lugar_Update').val(estado);

            var quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'image', 'code-block'],
                        ['clean']
                    ]
                }
            });
            quill.root.innerHTML = data[0].Detalle;

            $('#btn-actualizar-lugares-hostal').off('click').on('click', function(event) {
                var Nombre_Lugar = $("#Nombre_Lugar_update").val().trim();
                var Coordenadas_Lugar = $("#Coordenadas_Lugar_update").val().trim();
                var Estado_Lugar = $("#Estado_Lugar_Update").val();
                var contenidoEditor = quill.root.innerHTML;
                var id = lugaresId

                if (Nombre_Lugar === "") {
                    MostrarMensaje("Por favor, ingrese el nombre del lugar.", "danger");
                    return;
                }
            
                if (Coordenadas_Lugar === "") {
                    MostrarMensaje("Por favor, ingrese las coordenadas.", "danger");
                    return;
                }
            
                var formData = new FormData();
                formData.append('id', id);
                formData.append('Nombre_Lugar_update', Nombre_Lugar);
                formData.append('Coordenadas_Lugar_update', Coordenadas_Lugar);
                formData.append('Estado_Lugar_update', Estado_Lugar);
                formData.append('contenidoEditor', contenidoEditor);
            
                $.ajax({
                    url: '/apihostal/actualizar-lugar-turistico-hostal',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        MostrarMensaje("Actualizado exitosamente", "success");
                        CanvasTime()
                    },
                    error: function(error) {
                        console.error('Error al actualizar:', error);
                        MostrarMensaje("Error al actualizar. Intente nuevamente.", "danger");
                    }
                });
            });
            
        },
        error: function(error) {
            console.error('Error al recuperar datos:', error);
        }
    });    
});

$(document).ready(function() {  
    document.getElementById('addlugares').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Lugar</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre Del Lugar</label>
                        <div class="col">
                        <input type="text" class="form-control convertmayusculas" id="Nombre_Lugar" name="Nombre_Lugar">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Coordenadas</label>
                        <div class="col">
                            <input type="text" class="form-control convertmayusculas" placeholder="Ejemplo: -19.588590193553266, -65.7504048257871" id="Coordenadas_Lugar" name="Coordenadas_Lugar">
                            <small class="form-hint">Nota debes copiar y pegar "ctr+V"</small>
                        </div>
                    </div>

                    <div id="editor"></div>

                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-lugares-hostal">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        const input = document.getElementById('Coordenadas_Lugar');
        input.addEventListener('keydown', function(event) {
            if (event.key !== 'Control' && event.key !== 'v' && event.key !== 'Meta') {
                event.preventDefault();
            }
        });

        input.addEventListener('paste', function(event) {
            event.preventDefault();
            const pastedData = event.clipboardData.getData('text/plain');
            const regex = /^-?\d+(\.\d+)?\,\s*-?\d+(\.\d+)?$/;
            if (regex.test(pastedData)) {
                input.value = pastedData; 
            } else {
                MostrarMensaje("Por favor, pega coordenadas en el formato: -19.588590193553266, -65.7504048257871","danger")
            }
        });
        
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    ['ordered', 'bullet', 'blockquote'],
                    ['link', 'image', 'code-block'],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });

        function convertirMayusculas() {
            const inputs = document.querySelectorAll('.convertmayusculas');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    input.value = input.value.toUpperCase();
                });
            });
        }
        
        convertirMayusculas()

        $('#btn-registrar-lugares-hostal').off('click').on('click', function(event) {
            var Nombre_Lugar = $("#Nombre_Lugar").val().trim();
            var Coordenadas_Lugar = $("#Coordenadas_Lugar").val().trim();
        
            if (Nombre_Lugar === "") {
                MostrarMensaje("Por favor, ingrese el nombre del lugar.", "danger");
                return;
            }
        
            if (Coordenadas_Lugar === "") {
                MostrarMensaje("Por favor, ingrese las coordenadas.", "danger");
                return; 
            }
        
            var contenidoEditor = quill.root.innerHTML;
        
            var formData = new FormData();
            formData.append('Nombre_Lugar', Nombre_Lugar);
            formData.append('Coordenadas_Lugar', Coordenadas_Lugar);
            formData.append('contenidoEditor', contenidoEditor);
        
            $.ajax({
                url: '/apihostal/registrar-lugar-turistico-hostal',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    ListarDatos();
                    CanvasTime()
                    MostrarMensaje("Creado Exitosamente", "success");
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });
        

    });
});

