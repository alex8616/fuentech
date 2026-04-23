$(document).ready(function() {
    FechaSelectReporteInventario()
    
    $.ajax({
        url: 'apihostal/get-categoria-recurso',
        type: 'GET',
        dataType: 'json',
        success: function(categorias) {
            var select = $('#AllCategoriaSelect');
            select.empty(); 
            select.append($('<option value="Todo">Todo</option>')); 
            $.each(categorias, function(index, categoria) {
                select.append($('<option></option>').attr('value', categoria.id).text(categoria.nombre));
            });
            $('#AllCategoriaSelect').trigger('change');
        },
        error: function(error) {
            console.error('Error al recuperar datos de categorías:', error);
        }
    });
    

    $('#searcharticulo').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();

        $('#tabla-articulo tbody tr').filter(function() {
            $(this).toggle(
                $(this).find('td:nth-child(2)').text().toLowerCase().includes(searchText) ||
                $(this).find('td:nth-child(3)').text().toLowerCase().includes(searchText) ||
                $(this).find('td:nth-child(4)').text().toLowerCase().includes(searchText)
            );
        });
    });
});

$('#btnExportarPDF').off('click').on('click', function(event) {
    event.preventDefault();
    var FiltroTipo = $('#AllTipoSelect').val();
    var FiltroCategoria = $('#AllCategoriaSelect').val();
    
    var url = '/apihostal/get-filtro-articulos-PDF?FiltroTipo=' + FiltroTipo + '&FiltroCategoria=' + FiltroCategoria;
    window.open(url, '_blank');
});

$('#btnExportarPDFCompleto').off('click').on('click', function(event) {
    event.preventDefault();
    var FiltroTipo = $('#AllTipoSelect').val();
    var FiltroCategoria = $('#AllCategoriaSelect').val();
    
    var url = '/apihostal/get-filtro-articulos-PDF-completo?FiltroTipo=' + FiltroTipo + '&FiltroCategoria=' + FiltroCategoria;
    window.open(url, '_blank');
});


function FechaSelectReporteInventario() {
    $('#AllCategoriaSelect').on('change', function() {
        filtrarDatosReporte();
    });

    $('#AllTipoSelect').on('change', function() {
        filtrarDatosReporte();
    });

    $('#AllCategoriaSelect').trigger('change');
    $('#AllTipoSelect').trigger('change');
}

function filtrarDatosReporte() {
    var FiltroTipo = $('#AllTipoSelect').val();
    var FiltroCategoria = $('#AllCategoriaSelect').val();

    $.ajax({
        url: '/apihostal/get-filtro-articulos',
        method: 'GET',
        data: {
            FiltroTipo: FiltroTipo,
            FiltroCategoria: FiltroCategoria,
        },
        success: function(response) {
            ListarDatosArticuloRecurso(response)
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

$(document).ready(function() {  
    document.getElementById('addarticulo').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Cliente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Categoria</label>
                        <div class="col">
                            <select class="form-control" id="CategoriaRecursoSelect">
                                
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control convertirmayuscula" id="NombreRecurso" name="NombreRecurso">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Descripcion</label>
                        <div class="col">
                        <textarea class="form-control" id="DescripcionRecurso" name="DescripcionRecurso"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Cantidad</label>
                        <div class="col">
                        <input type="text" class="form-control convertirnumero" id="CantidadRecurso" name="CantidadRecurso">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Estado</label>
                        <div class="col">
                        <select class="form-control" id="SelectEstado">
                            <option value="Bueno">Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Malo">Malo</option>
                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Clasificacion</label>
                        <div class="col">
                        <select class="form-control" id="SelectClasificacion">
                            <option value="Muebles">Muebles</option>
                            <option value="Equipo">Equipo</option>
                            <option value="Otros">Otros</option>
                        </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Marca</label>
                        <div class="col">
                        <input type="text" class="form-control" id="MarcaRecurso" name="MarcaRecurso">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Observaciones</label>
                        <div class="col">
                        <textarea class="form-control" id="ObservacionesRecurso" name="ObservacionesRecurso"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Color</label>
                        <div class="col">
                        <input type="text" class="form-control" id="ColorRecurso">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Imagen</label>
                        <div class="col">
                            <input type="file" class="form-control" id="ImagenRecurso" name="ImagenRecurso" multiple>
                        </div>
                    </div>
                    <div class="row" id="previewContainer">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-articulo">REGISTRAR</button>
                </div>
            </div>
        </form>
        `;

        convertirMayusculas();
        convertirEntero();


        $('#CategoriaRecursoSelect').select2({
            ajax: {
                url: '/apihostal/get-categoria-recurso-select',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    var formattedData = data.map(function(categoria) {
                        return {
                            id: categoria.id,
                            text: categoria.nombre 
                        };
                    });
        
                    return {
                        results: formattedData
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            placeholder: 'Selecciona una categoría'
        });
        
        const imagenInput = document.getElementById('ImagenRecurso');
        const previewContainer = document.getElementById('previewContainer');
        imagenInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            Array.from(imagenInput.files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageContainer = document.createElement('div');
                    imageContainer.classList.add('col-3', 'position-relative', 'mb-3');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-fluid', 'rounded', 'border');
                    img.style.maxHeight = '150px';
                    const removeButton = document.createElement('button');
                    removeButton.innerHTML = '×';
                    removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0', 'end-0', 'm-1');
                    removeButton.style.zIndex = '1';
                    removeButton.addEventListener('click', function() {
                        imageContainer.remove();
                    });
                    imageContainer.appendChild(img);
                    imageContainer.appendChild(removeButton);
                    previewContainer.appendChild(imageContainer);
                };
                reader.readAsDataURL(file);
            });
        });


        $('#btn-registrar-articulo').off('click').on('click', function(event) {
            event.preventDefault();
        
            var CategoriaRecursoSelect = $("#CategoriaRecursoSelect").val();
            var NombreRecurso = $("#NombreRecurso").val();
            var DescripcionRecurso = $("#DescripcionRecurso").val();
            var CantidadRecurso = $("#CantidadRecurso").val();
            var SelectEstado = $("#SelectEstado").val();
            var SelectClasificacion = $("#SelectClasificacion").val();
            var MarcaRecurso = $("#MarcaRecurso").val();
            var ObservacionesRecurso = $("#ObservacionesRecurso").val();
            var ColorRecurso = $("#ColorRecurso").val();


        
            var formData = new FormData();
            formData.append('CategoriaRecursoSelect', CategoriaRecursoSelect);
            formData.append('NombreRecurso', NombreRecurso);
            formData.append('DescripcionRecurso', DescripcionRecurso);
            formData.append('CantidadRecurso', CantidadRecurso);
            formData.append('SelectEstado', SelectEstado);
            formData.append('SelectClasificacion', SelectClasificacion);
            formData.append('MarcaRecurso', MarcaRecurso);
            formData.append('ObservacionesRecurso', ObservacionesRecurso);
            formData.append('ColorRecurso', ColorRecurso);

        
            var imagenes = document.getElementById('ImagenRecurso').files;
            for (var i = 0; i < imagenes.length; i++) {
                formData.append('imagenes[]', imagenes[i]);
            }
        
            $.ajax({
                url: '/apihostal/registrar-articulo-recurso',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function(response) {
                    filtrarDatosReporte()
                    CanvasTime()
                    MostrarMensaje("Creado Exitosamente", "success");
                },
                error: function(error) {
                    console.error('Error al registrar:', error);
                }
            });
        });
    });
});

function ListarDatosArticuloRecurso(data) {
    $('#tabla-articulo tbody').empty();
    $.each(data, function(index, articulo) {
        var fechaFormateada = new Date(articulo.created_at).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        var row = '<tr>' +
            '<td hidden>' + articulo.id + '</td>' +
            '<td>' + articulo.descripcion + '</td>' +
            '<td>' + articulo.nombre + '</td>' +
            '<td text-align: center">' + (articulo.inventario[0]?.totalgeneral ? '<span class="float-right font-weight-medium text-black" style="font-weight: bold">'+articulo.inventario[0]?.totalgeneral+'</span>' : '-') + '</td>' +
            '<td>' + articulo.color + '</td>' +
            '<td>' + articulo.categoriarecurso.nombre + '</td>' +
            '<td>' + articulo.estado + '</td>' +
            '<td>' + articulo.clasificacion + '</td>' +
            '<td>' + articulo.marca + '</td>' +
            '<td>' + articulo.observaciones + '</td>' +
            '</tr>';

        $('#tabla-articulo tbody').append(row);

    });

    $('#tabla-articulo tbody').on('click', 'tr', function() {
        $('#tabla-articulo tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');
        var id = $(this).find('td:first').text();
        
        $.ajax({
            url: '/apihostal/get-articulo-recurso-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionArticuloRecurso(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos de producto:', error);
            }
        });
    });
}

function InformacionArticuloRecurso(data) {
    let divdetalles = ''; 

    if (data.inventario && data.inventario.length > 0 && data.inventario[0].detalleinventarios) {
        let datedetalles = data.inventario[0].detalleinventarios;

        divdetalles += `
            <div class="row">`
                datedetalles.forEach(function(datedetalle) {
                    var fechaFormateadaDetalle = new Date(datedetalle.fecha).toLocaleDateString('es-ES', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    if(datedetalle.tipo == "entrada"){
                        divdetalles += `
                        <div class="col-md-12">
                            <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-green-lt avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M18 11l-6 -6"></path><path d="M6 11l6 -6"></path></svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                    ${fechaFormateadaDetalle} - <span style="font-weight: bold; text-decoration:underline;">${datedetalle.estado}</span>
                                    <span class="float-right font-weight-medium text-green">+${datedetalle.cantidad}</span>
                                    </div>
                                    <div class="text-muted">
                                    ${datedetalle.descripcion}
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        `;
                    }else{
                        divdetalles += `
                        <div class="col-md-12">
                            <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-red-lt avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M18 13l-6 6"></path><path d="M6 13l6 6"></path></svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                    ${fechaFormateadaDetalle} - <span style="font-weight: bold; text-decoration:underline;">${datedetalle.estado}</span>
                                    <span class="float-right font-weight-medium text-red">-${datedetalle.cantidad}</span>
                                    </div>
                                    <div class="text-muted">
                                    ${datedetalle.descripcion}
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        `;
                    }
                });
        divdetalles += `</div>`
    }

    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
    <div class="col-md-6 col-lg-12">
        <div class="card">
            <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                <h3 class="card-title">${data.nombre}</h3>
                <div class="card-actions">
                    <a href="#" class="btn" data-editar-id="${data.id}" id="EditarArticulo">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-highlight"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M12.5 5.5l4 4" /><path d="M4.5 13.5l4 4" /><path d="M21 15v4h-8l4 -4z" /></svg>
                    </a>
                    <a href="#" class="btn" data-eliminar-id="${data.id}" id="EliminarArticulo">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </a>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                <div class="row">
                    <div class="col-12 col-md-12">                        
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Nombre</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.nombre}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Descripción</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.descripcion}</label>
                            </div>
                        </div>       
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Precio</label>
                            <div class="col">
                                <label class="col-8 col-form-label" style="color: #61677A">${data.precio}</label>
                            </div>
                        </div>
                        <div class="mb-12 row">
                            <label class="col-4 col-form-label" style="font-weight: bold">Imágenes</label>
                            <div class="col">
                                <div class="row">
                                    ${data.imagen ? 
                                        data.imagen.split(',').map(img => `
                                            <div class="col-4 mb-4">
                                                <img src="/images/inventario/${img}" alt="${data.nombre}" class="img-fluid" style="max-height: 200px; object-fit: cover;" onclick="openModal('/images/inventario/${img}')">
                                            </div>
                                        `).join('') :
                                        `<label class="col-8 col-form-label" style="color: #61677A">No hay imágenes disponibles para este artículo.</label>`
                                    }
                                </div>
                            </div>
                        </div>                 
                    </div>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                <div class="row">
                    <div class="col-12 col-md-12">                        
                        <div class="mb-12 row">
                            <div class="col">
                                 <a href="#" data-bs-toggle="modal" data-bs-target="#ModalIngreso" id="ModalIngresoInvento" data-ingreso-id="${data.id}">
                                    Registrar Ingreso 
                                </a>
                            </div>
                             <div class="col">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#ModalSalida" id="ModalSalidaInvento" data-salida-id="${data.id}">
                                    Registrar Salida
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-12" style="height: 100%">
                ${divdetalles}
            </div>
        </div>
    </div>`;

    $('#ModalIngresoInvento').off('click').on('click', function(event) {
        event.preventDefault();
        var IngresoArticuloId = $(this).data('ingreso-id');
        $('#RegistrarIngresoInventario').off('click').on('click', function(event) {
            var EstadoIngreso = $("#EstadoIngreso").val();
            var CantidadIngreso = $("#CantidadIngreso").val();
            var DescripcionIngreso = $("#DescripcionIngreso").val();

            var formData = new FormData();
            formData.append('EstadoIngreso', EstadoIngreso);
            formData.append('CantidadIngreso', CantidadIngreso);
            formData.append('DescripcionIngreso', DescripcionIngreso);
            formData.append('IngresoArticuloId', IngresoArticuloId);
        
            $.ajax({
                url: '/apihostal/registrar-ingreso-inventario',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#ModalIngreso').modal('hide');
                    $('#EstadoIngreso').val('');
                    $('#CantidadIngreso').val('');
                    $('#DescripcionIngreso').val('');
                    InformacionArticuloRecurso(response)
                    ListarDatosArticuloRecurso()
                    MostrarMensaje("Ingreso Registrado Exitosamente", "success");
                },
                error: function(error) {
                    console.error('Error al registrar:', error);
                }
            });
        });
    });

    
    $('#ModalSalidaInvento').off('click').on('click', function(event) {
        event.preventDefault();
        var SalidaArticuloId = $(this).data('salida-id');
        $('#RegistrarSalidaInventario').off('click').on('click', function(event) {
            var EstadoSalida = $("#EstadoSalida").val();
            var CantidadSalida = $("#CantidadSalida").val();
            var DescripcionSalida = $("#DescripcionSalida").val();

            var formData = new FormData();
            formData.append('EstadoSalida', EstadoSalida);
            formData.append('CantidadSalida', CantidadSalida);
            formData.append('DescripcionSalida', DescripcionSalida);
            formData.append('SalidaArticuloId', SalidaArticuloId);
        
            $.ajax({
                url: '/apihostal/registrar-salida-inventario',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#ModalSalida').modal('hide');
                    $('#EstadoSalida').val('');
                    $('#CantidadSalida').val('');
                    $('#DescripcionSalida').val('');
                    InformacionArticuloRecurso(response)
                    ListarDatosArticuloRecurso()
                    MostrarMensaje("Salida Registrado Exitosamente", "success");
                },
                error: function(error) {
                    console.error('Error al registrar:', error);
                }
            });
        });
    });

    $(document).off('click').on('click', '#EditarArticulo', function(event) {
        event.preventDefault();
        var editarId = $(this).data('editar-id');        

        const imageContainer = data.imagen 
            ? data.imagen.split(',').map((img, index) => `
                <div class="col-4 mb-4 position-relative">
                    <img src="/images/inventario/${img}" alt="${data.nombre}" class="img-fluid" style="max-height: 100px; object-fit: cover;">
                    <button class="btn btn-danger btn-sm position-absolute remove-image" style="top: 0; right: 0;" data-imagen="${img}" data-index="${index}" data-articulo-id="${editarId}">X</button>
                </div>
            `).join('')
            : `<label class="col-8 col-form-label" style="color: #61677A">No hay imágenes disponibles para este artículo.</label>`;

        $('#ImagePreviewContainer').html(imageContainer);

        var TotalProduct = document.getElementById('form_tabs');
        TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                        <h3 class="card-title">Editando ${data.nombre}</h3>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label required">Categoria</label>
                                <div class="col">
                                    <select class="form-control" id="UpdateCategoriaRecursoSelect"></select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label required">Nombre</label>
                                <div class="col">
                                    <input class="form-control convertirmayuscula" id="UpdateNombre" value="${data.nombre}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label required">Descripcion</label>
                                <div class="col">
                                    <input class="form-control convertirmayuscula" id="UpdateDescripcion" value="${data.descripcion}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label required">estado</label>
                                <div class="col">
                                    <select class="form-control" id="UpdateSelectEstado">
                                        <option value="Bueno">Bueno</option>
                                        <option value="Regular">Regular</option>
                                        <option value="Malo">Malo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label required">clasificacion</label>
                                <div class="col">
                                    <select class="form-control" id="UpdateSelectClasificacion">
                                        <option value="Muebles">Muebles</option>
                                        <option value="Equipo">Equipo</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label required">marca</label>
                                <div class="col">
                                    <input class="form-control" id="Updatemarca" value="${data.marca}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label required">color</label>
                                <div class="col">
                                    <input class="form-control" id="Updatecolor" value="${data.color}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-4 col-form-label required">observaciones</label>
                                <div class="col">
                                    <input class="form-control" id="Updateobservaciones" value="${data.observaciones}">
                                </div>
                            </div>
                            <div class="mb-3 row" hidden>
                                <label class="col-4 col-form-label required">Imagen</label>
                                <div class="col">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#UpdateImagen" id="ModalActualizarImagen" data-imagen-id="${data.id}">
                                        Actualizar Imagen
                                    </a>
                                </div>
                            </div>
                            <div class="row" id="previewContainer"></div>
                            <div class="row" id="imagenesContainer">
                                ${imageContainer}            
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex">
                            <a href="#" class="btn btn-link" id="CancelarActualizacion">Cancel</a>
                            <a href="#" class="btn btn-primary ms-auto" id="ActualizarDatos">Actualizar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
    
            document.getElementById("UpdateSelectEstado").value = data.estado;
            document.getElementById("UpdateSelectClasificacion").value = data.clasificacion;

            convertirMayusculas();
            convertirEntero();

        var categoriaID = data.categori_recursos_id;
        $.ajax({
            url: 'apihostal/get-categoria-recurso',
            type: 'GET',
            dataType: 'json',
            success: function(categorias) {
                console.log(categorias)
                var select = $('#UpdateCategoriaRecursoSelect');
                select.empty();
                $.each(categorias, function(index, categoria) {
                    select.append($('<option></option>').attr('value', categoria.id).text(categoria.nombre));
                }); 
                $('#UpdateCategoriaRecursoSelect').val(categoriaID).change();
            },
            error: function(error) {
                console.error('Error al recuperar datos de categorías:', error);
            }
        });

        $('#UpdateImagenRecurso').on('change', function(event) {
            const files = event.target.files;
            const previewContainer = $('#ImagePreviewContainer');
            previewContainer.empty();
    
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgElement = $('<img />', {
                            src: e.target.result,
                            class: 'img-fluid',
                            style: 'max-height: 150px; object-fit: cover; margin-right: 10px; margin-bottom: 10px;'
                        });
                        previewContainer.append(imgElement);
                    };
                    reader.readAsDataURL(file); 
                });
            }
        });       
        
        $('#CancelarActualizacion').off('click').on('click', function(event) {
            InformacionArticuloRecurso(data)
        }); 
       
        $('#ActualizarDatos').off('click').on('click', function(event) {
            event.preventDefault();
        
            var UpdateCategoriaRecursoSelect = $("#UpdateCategoriaRecursoSelect").val();
            var UpdateNombre = $("#UpdateNombre").val();
            var UpdateDescripcion = $("#UpdateDescripcion").val();
            var IdUpdate = data.id;
            var UpdateSelectEstado = $("#UpdateSelectEstado").val();
            var UpdateSelectClasificacion = $("#UpdateSelectClasificacion").val();
            var Updatemarca = $("#Updatemarca").val();
            var Updatecolor = $("#Updatecolor").val();
            var Updateobservaciones = $("#Updateobservaciones").val();

            var formData = new FormData();
            formData.append('UpdateSelectEstado', UpdateSelectEstado);
            formData.append('UpdateSelectClasificacion', UpdateSelectClasificacion);
            formData.append('Updatemarca', Updatemarca);
            formData.append('Updatecolor', Updatecolor);
            formData.append('Updateobservaciones', Updateobservaciones);
            formData.append('UpdateCategoriaRecursoSelect', UpdateCategoriaRecursoSelect);
            formData.append('UpdateNombre', UpdateNombre);
            formData.append('UpdateDescripcion', UpdateDescripcion);
            formData.append('IdUpdate', IdUpdate);
        
            $.ajax({
                url: '/apihostal/actualizar-articulo-recurso',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function(response) {
                    filtrarDatosReporte()
                    InformacionArticuloRecurso(response)
                    CanvasTime()
                    MostrarMensaje("Actualizado Exitosamente", "success");
                },
                error: function(error) {
                    console.error('Error al registrar:', error);
                }
            });
        });
    });
    

    $('#EliminarArticulo').off('click').on('click', function(event){
        event.preventDefault();
        var idDelete = $(this).data('eliminar-id'); 
      
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'apihostal/eliminar-recurso-inventario',
                    type: 'POST',
                    data: { id: idDelete },
                    success: function(response) {
                        if (response.success) {
                            filtrarDatosReporte()
                            CanvasTime()
                            MostrarMensaje("Actualizado Exitosamente", "success");
                            
                            Swal.fire(
                                '¡Eliminado!',
                                'El artículo ha sido eliminado.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error',
                                'Hubo un problema al eliminar el artículo.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'No se pudo conectar con el servidor.',
                            'error'
                        );
                    }
                });
            }
        });
    });
    
    
    $('#ActualizarImageLista').off('click').on('click', function() {
        const formData = new FormData();
        const files = $('#UpdateImagenRecurso')[0].files; 
        const articuloId = $('#ModalActualizarImagen').data('imagen-id'); 
    
        if (files.length > 0) {
            Array.from(files).forEach(file => {
                formData.append('images[]', file); 
            });
    
            for (let pair of formData.entries()) {
                console.log(pair[0]+ ', ' + pair[1]);
            }
    
            $.ajax({
                url: '/apihostal/articulo/' + articuloId + '/actualizar-imagen', 
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    InformacionArticuloRecurso(response)
                    MostrarMensaje("Imagenes Actualizados Exitosamente", "success");
                    $('#UpdateImagen').modal('hide');
                    $('#UpdateImagenRecurso').val('');
                    $('#ImagePreviewContainer').empty();
                },
                error: function(xhr, status, error) {
                    console.error('Error al subir la imagen:', error);
                    Swal.fire(
                        '¡Error!',
                        'Hubo un problema al actualizar la imagen.',
                        'error'
                    );
                }
            });
        } else {
            Swal.fire(
                '¡Error!',
                'Por favor selecciona al menos una imagen.',
                'error'
            );
        }
    });

    function eliminarImagen(imagen, articuloId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar la imagen "${imagen}" del artículo ID ${articuloId}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/apihostal/eliminar-imagen',
                    type: 'POST',
                    data: {
                        id: articuloId,
                        imagen: imagen
                    },
                    success: function(response) {
                        const imgElement = document.querySelector(`#imagenesContainer img[src='/images/inventario/${imagen}']`);
                        if (imgElement) {
                            imgElement.parentElement.remove();
                        }
                        Swal.fire(
                            'Eliminado!',
                            'La imagen ha sido eliminada.',
                            'success'
                        );
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al eliminar la imagen:', error);
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al eliminar la imagen.',
                            'error'
                        );
                    }
                });
            }
        });
    }
    
    $(document).on('click', '.remove-image', function() {
        const imagen = $(this).data('imagen');
        const articuloId = $(this).data('articulo-id');
        eliminarImagen(imagen, articuloId);
    });
    
}

function openModal(imageSrc) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageSrc; 
    $('#imageModal').modal('show');
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