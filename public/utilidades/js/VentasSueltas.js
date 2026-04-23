document.addEventListener('DOMContentLoaded', function () {
    CanvasTime();
    FechaSelectVentaSuelta()
    var btnVentaSueltaNuevo = document.getElementById('VentaNueva');
    btnVentaSueltaNuevo.addEventListener('click', function () {
        var MostradorNuevoPedido = document.getElementById('form_tabs');
        MostradorNuevoPedido.innerHTML = `
            <form>
                <div class="card-header">
                    <div class="row" style="width: 100%">
                        <div class="col-12 col-sm-12">
                            <h3>Servicio Pedidos</h3>
                        </div> 
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <form class="card">
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Comentario</label>
                                    <div class="col">
                                        <textarea class="form-control" id="VentaSueltaComentario"></textarea>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Tipo De Pago</label>
                                    <div class="col">
                                        <select class="form-control" id="TipoPagoVentaSuelta">
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Tarjeta">Tarjeta</option>
                                            <option value="Deposito/QR">Deposito/QR</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="mb-3">
                                        <label class="form-label">ADICIONAR</label>
                                        <div class="row g-2">
                                            <div class="col-auto">
                                            <a href="#" class="btn btn-icon" aria-label="Button">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                            </a>
                                            </div>
                                            <div class="col">
                                            <input type="text" class="form-control" id="BuscarProducto" placeholder="Buscar Producto">
                                            </div>                                                        
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="contenedor" id="DivFavoriteVentaSuelta" style="width: 100%; margin: 0px; padding: 0px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="mb-3" id="DivAddProduct">
                                        
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button id="btnGuardarVentaSuelta" class="btn btn-primary" style="display: none">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>                    
            </form>
        `;

        $.ajax({
            url: '/api/get-productos',
            type: 'GET',
            dataType: 'json',
            success: function (productos) {
                $.ajax({
                    url: '/api/get-productos-favorite-stock',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Convierte el objeto en un array
                        var productos = Object.values(response);
                    
                        $('#DivFavoriteVentaSuelta').empty();
                    
                        // Itera sobre los productos
                        productos.forEach(function(producto) {
                            var elementoHtml = `
                                <div class="elemento" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <p style="display: flex; justify-content: space-between;">
                                        <span style="color: black; font-weight: bold;">${producto.PrecioProducto} Bs.</span>
                                        <span style="font-weight: bold; color: blue">${producto.stockdates[0]?.Cantidad || 0}</span>
                                    </p>
                                    <p style="display: inline; color: #3C4048;">${producto.NombreProducto}</p>
                                </div>
                            `;
                            $('#DivFavoriteVentaSuelta').append(elementoHtml);
                        });
                    
                        // Evento para manejar clicks
                        $('#DivFavoriteVentaSuelta').on('click', '.elemento', function() {
                            var nombreProducto = $(this).find('p:eq(1)').text().trim();
                            var productoSeleccionado = productos.find(producto => producto.NombreProducto === nombreProducto);
                            if (productoSeleccionado) {
                                productosSeleccionados.push({
                                    Idproducto: productoSeleccionado.id,
                                    NombreProducto: productoSeleccionado.NombreProducto,
                                    Cantidad: 1,
                                    PrecioProducto: productoSeleccionado.PrecioProducto,
                                    modificadore: productoSeleccionado.modificadore
                                });
                                actualizarDivsProductos();
                            } else {
                                console.error('No se encontró el producto seleccionado:', nombreProducto);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los datos:', error);
                    }
                });

                var productosSeleccionados = [];
                $('#BuscarProducto').autocomplete({
                    source: productos.map(producto => ({
                        label: `${producto.CodigoProducto} - ${producto.NombreProducto}`,
                        value: producto.NombreProducto,
                        codigo: producto.CodigoProducto,
                        modificadore: producto.modificadore
                    })),
                    
                    
                    select: function (event, ui) {
                        var productoSeleccionado = productos.find(producto => producto.NombreProducto === ui.item.value);
                        // Agregar una nueva instancia del producto seleccionado
                        productosSeleccionados.push({
                            Idproducto: productoSeleccionado.id,
                            NombreProducto: productoSeleccionado.NombreProducto,
                            Cantidad: 1,
                            PrecioProducto: productoSeleccionado.PrecioProducto,
                            modificadore: productoSeleccionado.modificadore
                        });
                        actualizarDivsProductos();
                        $(this).val('');
                        return false;
                    },
                    
                                                        
                    
                    close: function (event, ui) {
                        $(this).val('');
                    },
                    open: function (event, ui) {
                        $('.ui-menu-item').each(function () {
                            var text = $(this).text();
                            var codigo = text.split(' - ')[0];
                            var nombre = text.split(' - ')[1];
                            $(this).html(`<span class="autocomplete-bold">${codigo}</span> - ${nombre}`);
                        });
                    }
                });

                function actualizarDivsProductos() {
                    var AddProduct = document.getElementById('DivAddProduct');
                    AddProduct.innerHTML = '';
            
                    productosSeleccionados.forEach(function (producto, index) {
                        var nuevoDiv = document.createElement('div');
                        nuevoDiv.className = 'row producto-row';
                        nuevoDiv.style = 'padding: 1px';
            
                        nuevoDiv.innerHTML = `
                        <div style="background: #FFCC70; padding-top: 10px;">
                            <div data-index="${index}" style="display: flex; padding: 0px; margin: 0px;">
                                <div style="width: 25%;" id="divdate1">
                                    <div class="input-group" style="width: 100%">
                                        <button class="btn btn-outline-secondary btnDecrementar" type="button" style="width: 15px">-</button>
                                        <input type="text" name="CantProduct" class="form-control CantProduct" value="${producto.Cantidad || 1}" style="padding: 0px; text-align: center;" id="divInput">
                                        <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                                    </div>
                                </div>
                                <div style="padding-left: 9px; padding-right: 9px; width: 35%;" id="divdate2">
                                    <a style="font-weight: bold; font-size: 13px; word-wrap: break-word;">${producto.NombreProducto}</a>
                                </div>
                                <div style="width: 15%;" id="divdate3">
                                    <input type="number" name="PrecioProduct" class="form-control PrecioProduct" value="${producto.PrecioProducto  || 1}" style="padding-right: 0px; padding-left: 0px; text-align: center; width: 55px">
                                </div>
                                <div style="text-align: center; width: 25%; padding: 0px; margin: 0px; id="divdate4">
                                    <a class="mostrar-comentario">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" style="width: 36px; height: 36px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M3 20l1.3 -3.9c-2.324 -3.437 -1.426 -7.872 2.1 -10.374c3.526 -2.501 8.59 -2.296 11.845 .48c3.255 2.777 3.695 7.266 1.029 10.501c-2.666 3.235 -7.615 4.215 -11.574 2.293l-4.7 1" />
                                        </svg>
                                    </a>
                                    <a class="borrar-div" data-index="${index}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" style="width: 36px; height: 36px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M18 6l-12 12" />
                                            <path d="M6 6l12 12" />
                                        </svg>
                                    </a>
                                </div>                                                
                            </div>
                            ${producto.modificadore != null ? `
                                <div style="text-align: center; margin-left: 10%;" id="DivModificadores"><br>
                                    <!-- Aquí listame todos los productos con modificadores -->
                                </div>
                            ` : ''}
                            <div style="text-align: center;"><br>
                                <input type="text" name="ComentarioProduct" class="form-control ComentarioProduct" style="display: none"><br id="saltoDiv" style="display: none" placeholder="Escriba El Comentario . . .">
                            </div>
                        </div>
                        `;

                        if (producto.modificadore != null) {
                            var productosModificadoresDiv = nuevoDiv.querySelector('#DivModificadores');
                            producto.modificadore.detallemodificador.forEach(function (detalle, indexDetalle) {
                                // Aquí usa indexDetalle en lugar de index
                                var productoModificador = detalle.producto;
                                var productoModificadorDiv = document.createElement('div');
                                productoModificadorDiv.innerHTML = `
                                <div class="card" style="margin: 0px; padding: 10px; border-left: 6px solid orange">
                                        <div data-index="${index}-${indexDetalle}" style="display: flex; padding: 0px; margin: 0px;">
                                            <div style="width: 30%;" id="divdate1">
                                                <input type="text" id="IdDetalleModificador" class="form-control CantProduct" value="${detalle.id}" style="padding: 0px; text-align: center;" hidden>
                                                <div class="input-group" style="width: 100%">
                                                    <button class="btn btn-outline-secondary btnDecrementar" type="button" style="width: 15px">-</button>
                                                    <input type="text" name="CantProduct" class="form-control CantProduct" value="${productoModificador.Cantidad || 1}" style="padding: 0px; text-align: center;" id="DivModificadorCantidadMostrador${index}-${indexDetalle}">
                                                    <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                                                </div>
                                            </div>
                                            <div style="padding-left: 9px; padding-right: 9px; width: 35%;" id="divdate2">
                                                <a style="font-weight: bold; font-size: 13px; word-wrap: break-word;">${productoModificador.NombreProducto}</a>
                                            </div>
                                            <div style="width: 20%;" id="divdate3">
                                                <input type="number" class="form-control PrecioProduct" value="${detalle.CostoDetalleModificador || 1}" style="padding-right: 0px; padding-left: 0px; text-align: center; width: 55px" id="DivModificadorCostoMostrador${index}-${indexDetalle}">
                                            </div>
                                            <div style="text-align: center; padding: 8px; margin: 0px;" id="divdate4">
                                                <input class="form-check" type="checkbox" style="width: 20px; height: 20px" id="ModificadorCheckMostrador${index}-${indexDetalle}" checked>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                productosModificadoresDiv.appendChild(productoModificadorDiv);
                            });
                        }
            
                        AddProduct.appendChild(nuevoDiv);
            
                        // Agregar controladores de eventos a los botones y elementos relevantes
                        var btnDecrementar = nuevoDiv.querySelector('.btnDecrementar');
                        var btnIncrementar = nuevoDiv.querySelector('.btnIncrementar');
                        var borrarDiv = nuevoDiv.querySelector('.borrar-div');
                        var cantProductInput = nuevoDiv.querySelector('.CantProduct');
                        var precioProductInput = nuevoDiv.querySelector('.PrecioProduct');
                        var comentarioProductInput = nuevoDiv.querySelector('.ComentarioProduct');                                        

                        // Agregar controladores de eventos
                        btnDecrementar.addEventListener('click', function() {
                            var cantidad = parseInt(cantProductInput.value, 10) || 0;
                            if (cantidad > 0) {
                                cantProductInput.value = cantidad - 1;
                                // Actualizar el valor de la cantidad en el objeto del producto
                                producto.Cantidad = cantidad - 1;
                            }
                        });
                        
                        btnIncrementar.addEventListener('click', function() {
                            var cantidad = parseInt(cantProductInput.value, 10) || 0;
                            cantProductInput.value = cantidad + 1;
                            // Actualizar el valor de la cantidad en el objeto del producto
                            producto.Cantidad = cantidad + 1;
                        });
            
                        borrarDiv.addEventListener('click', function() {
                            var index = borrarDiv.getAttribute('data-index');
                            productosSeleccionados.splice(index, 1);
                            actualizarDivsProductos();
                        });

                        cantProductInput.addEventListener('input', function() {
                            var cantidadActual = cantProductInput.value;
                            producto.Cantidad = cantidadActual;
                        });
                        
                        precioProductInput.addEventListener('input', function() {
                            producto.PrecioProducto = precioProductInput.value;
                        });
            
                        // Agregar controlador de eventos para mostrar el campo de comentario
                        var mostrarComentario = nuevoDiv.querySelector('.mostrar-comentario');
                        mostrarComentario.addEventListener('click', function() {
                            var comentarioInput = nuevoDiv.querySelector('.ComentarioProduct');
                            comentarioInput.style.display = 'block';
                        });

                        // Agregar controlador de eventos al campo de comentario
                        comentarioProductInput.addEventListener('input', function() {
                            var comentarioActual = comentarioProductInput.value;
                            producto.Comentario = comentarioActual;
                        });
                    });

                    btnGuardarVentaSuelta.style.display = productosSeleccionados.length >= 1 ? 'block' : 'none';
                }

                var btnGuardarVentaSuelta = document.getElementById('btnGuardarVentaSuelta');
                $('#btnGuardarVentaSuelta').off('click').on('click', function (event) {
                    $(this).prop('disabled', true);
                    event.preventDefault();
                
                    var productosParaGuardar = recuperarDatosProductos();
                    var datosAdicionales = recuperarDatosAdicionales();
                
                    var datosParaEnviar = {
                        productos: productosParaGuardar,
                        adicionales: datosAdicionales
                    };
                
                    $.ajax({
                        url: '/api/registrar-venta-suelta',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(datosParaEnviar),
                        success: function (response) {
                            CanvasTime();
                            FiltrarDatosVentaSuelta();
                            MostrarMensaje("success", "Venta registrada con éxito.");
                        },
                        error: function (error) {
                            if (error.status === 400 && error.responseJSON && error.responseJSON.message) {
                                MostrarMensaje(error.responseJSON.message);
                            } else {
                                MostrarMensaje("error", "Ocurrió un error inesperado. Por favor, intenta de nuevo.");
                            }
                        },
                        complete: function () {
                            $('#btnGuardarVentaSuelta').prop('disabled', false);
                        }
                    });
                    
                });
                

                function recuperarDatosAdicionales() {
                    return {
                        tipoventasueltapago: $('#TipoPagoVentaSuelta').val(),
                        comentario: $('#VentaSueltaComentario').val(),
                    };
                }

                function recuperarDatosProductos() {
                    var productosRecuperados = [];
                    productosSeleccionados.forEach(function (producto, index) {
                        var productoRecuperado = {
                            Idproducto: producto.Idproducto,
                            nombre: producto.NombreProducto,
                            cantidad: producto.Cantidad || 1,
                            precio: producto.PrecioProducto || 0,
                            comentario: producto.Comentario || '',
                            Modificadores: []
                        };

                        if (producto.modificadore != null) {
                            producto.modificadore.detallemodificador.forEach(function (detalle, indexDetalle) {
                                var DetalleID = detalle.id; // Usar detalle.id directamente si es único
                                var cantidadInputId = `DivModificadorCantidadMostrador${index}-${indexDetalle}`;
                                var costoInputId = `DivModificadorCostoMostrador${index}-${indexDetalle}`;
                                var checkboxId = `ModificadorCheckMostrador${index}-${indexDetalle}`;
                
                                var cantidad = document.getElementById(cantidadInputId).value;
                                var costo = document.getElementById(costoInputId).value;
                                var checkbox = document.getElementById(checkboxId);
                                var valorCheckbox = checkbox.checked;
                
                                var modificador = {
                                    id: DetalleID,
                                    NombreProducto: detalle.producto.NombreProducto,
                                    CostoDetalleModificador: costo || 1,
                                    Cantidad: cantidad || 1,
                                    Checkbox: valorCheckbox
                                };
                                productoRecuperado.Modificadores.push(modificador);
                            });
                        }

                        productosRecuperados.push(productoRecuperado);
                    });

                    return productosRecuperados;
                }
                                    
            },
            error: function (error) {
                console.error('Error al obtener productos:', error);
            }                            
        });

    });
});


function GetVentaSueltaAll() {
    $.ajax({
        url: '/api/get-mostrador-consumo-all',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#MostradorTableCurso tbody').empty();

            $.each(data, function (index, consumo) {
                var row = `<tr>
                            <td>${consumo.id}</td>
                            <td>${consumo.fecha_venta}</td>
                            <td><span class="badge badge-outline text-red">En Curso</span></td>
                            <td>${consumo.cliente ? consumo.cliente.NombreCliente : '-'}</td>
                            <td>${consumo.total}</td>
                            <td class="w-1"></td>
                        </tr>`;
                $('#MostradorTableCurso tbody').append(row);
            });

            var id;

            $('#MostradorTableCurso').off('click').on('click', 'tbody tr', function (event) {
                event.preventDefault(); 
                $('#MostradorTableCurso tbody tr').not(this).removeClass('selected');
                $(this).toggleClass('selected');
                if ($(this).hasClass('selected')) {
                    id = $(this).find('td:first').text();
                    var DivPedidos = document.getElementById('DivPedidos');
                    agregarDetallesConsumo(id);
                    DivTotalConsumo(id);
                }
            });
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });
}

function generarMostradorPDF() {
    var consumoID = document.getElementById('ImprimirMostrador').getAttribute('data-id');
    let pdfLink;
    $.ajax({
        url: window.location.origin + '/api/get-mostrador-comanda/' + consumoID,
        type: 'GET',
        beforeSend: function(xhr, settings) {
            pdfLink = settings.url;
        },
        success: function(data) {            
            $.ajax({
                url:'/api/print-name',
                type: 'GET',
                success: function(data) {
                    let IpImpresor = data.DireccionIp;
                    let printerName = data.NombreImpresora;
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'http://'+IpImpresor+'/imprimir/'+printerName, true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            MostrarMensaje("Se envio a la impresora "+printerName, "success");
                        } else {
                            MostrarMensaje("Error en impresora "+printerName, "error");
                            alert('Hubo un error al enviar el archivo PDF para imprimir.');
                        }
                    };
                    xhr.send(JSON.stringify({ pdf_link: pdfLink }));
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function generarPDFVerMostrador() {
    var mesaId = document.getElementById('VerImprimirMostrador').getAttribute('data-id');
    var pdfUrl = '/api/get-mostrador-comanda/' + mesaId;

    // Configura el iframe con la URL del PDF
    document.getElementById('pdfViewerMostrador').src = pdfUrl;

    // Muestra el modal
    var pdfModalMostrador = new bootstrap.Modal(document.getElementById('pdfModalMostrador'));
    pdfModalMostrador.show();
}

function FechaSelectVentaSuelta() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesVentaSuelta').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesVentaSuelta').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesVentaSuelta').val(currentMonth + 1);

    function updateDaySelectorNovedad() {
        var selectedMonth = parseInt($('#MesVentaSuelta').val());
        var selectedYear = today.getFullYear();
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaVentaSuelta').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaVentaSuelta').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaVentaSuelta').val(daysInMonth);
        } else {
            $('#DiaVentaSuelta').val(currentDay);
        }
    }

    updateDaySelectorNovedad();

    $('#DateVentaSuelta').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioVentaSuelta':
                $('#DiaVentaSueltaContainer').show();
                $('#FechaInicioContainerVentaSuelta').hide();
                $('#FechaFinContainerVentaSuelta').hide();
                break;
            case 'MensualidadVentaSuelta':
                $('#MesVentaSueltaContainer').show();
                $('#DiaVentaSueltaContainer').hide();
                $('#FechaInicioContainerVentaSuelta').hide();
                $('#FechaFinContainerVentaSuelta').hide();
            break;
            case 'RangoVentaSuelta':
                $('#DiaVentaSueltaContainer').hide();
                $('#MesVentaSueltaContainer').hide();
                $('#FechaInicioContainerVentaSuelta').show();
                $('#FechaFinContainerVentaSuelta').show();
            break;
        }
        FiltrarDatosVentaSuelta();
    });


    $('#MesVentaSuelta').on('change', function() {
        updateDaySelectorNovedad();
        FiltrarDatosVentaSuelta();
    });

    $('#DiaVentaSuelta').on('change', function() {
        FiltrarDatosVentaSuelta();
    });

    $('#FechaInicioContainerVentaSuelta').on('change', function() {
        FiltrarDatosVentaSuelta();
    });

    $('#FechaFinContainerVentaSuelta').on('change', function() {
        FiltrarDatosVentaSuelta();
    });

    $('#DateVentaSuelta').trigger('change');

}

function FiltrarDatosVentaSuelta(){
    var today = new Date();
    var selectedYear = today.getFullYear();
    var tipoFiltro = $('#DateVentaSuelta').val();
    var dia = $('#DiaVentaSuelta').val();
    var mes = $('#MesVentaSuelta').val();
    var anio = selectedYear;
    var fechaInicio = $('#fechaInicioVentaSuelta').val();
    var fechaFin = $('#fechaFinVentaSuelta').val();

    $.ajax({
        url: '/api/filtrar-datos-get-venta-suelta',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
            fechaInicio: fechaInicio,
            fechaFin: fechaFin,
        },
        success: function(response) {            
            cargarDatosEnTablaVentaSuelta(response)
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function cargarDatosEnTablaVentaSuelta(datos) {
    $('#table-venta-suelta tbody').empty();
    $.each(datos.ventasuelta, function(index, venta) {        
        var row = '<tr>' +
            '<td hidden>' + venta.id + '</td>' +
            '<td>' + venta.TipoConsumo + '</td>' +
            '<td>' + venta.Comentario + '</td>' +
            '<td>' + venta.pagosconsumos[0].TipoPago + '</td>' +
            '<td>' + new Date(venta.fecha_venta).toLocaleString() + '</td>' +
            '<td>' + venta.total + '</td>' +
            '</tr>';
        $('#table-venta-suelta tbody').append(row);
    });
    
    $('#total-sum-venta-suelta').text(datos.totalventasuelta.toFixed(2));

    $('#table-venta-suelta tbody').on('click', 'tr', function() {
        $('#table-venta-suelta tbody tr').removeClass('selected');
        $(this).addClass('selected');

        var id = $(this).find('td:first').text();
        $.ajax({
            url: '/api/get-venta-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionVentaSuelta(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos de producto:', error);
            }
        });
    });

    agregarEventos();

    function InformacionVentaSuelta(data){
        var TotalProduct = document.getElementById('form_tabs');
        var tipotext
        if(data.TipoConsumo == 'Mesa'){
            tipotext = "Mesa # "+venta.ambiente_mesa_id
        }else if(data.TipoConsumo == 'Mostrador'){
            tipotext = "Mostrador"
        }else{
            tipotext = "Delivery"
        }
        
        TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                        <h3 class="card-title">VENTA ${data[0].id}</h3>
                        <div class="card-actions">
                            <a href="#" class="btn" data-id="${data[0].id}" id="BtnImprimirTicketVentaSuelta" data-bs-toggle="modal" data-bs-target="#modalBtnImprimirTicketVentaSuelta">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-12" style="height: 100%">
                        ${data[0].TipoConsumo == "Mesa" ?  
                            `
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Hora Inicio</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].fecha_venta}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Hora De Cierre</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].FechaCierre}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Tipo</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${tipotext}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${((data.ocupado == 'true') ? 'En Curso' : 'Cerrado')} </label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Mesa</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">Mesa # ${data[0].ambiente_mesa_id} </label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Personas</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].CantidadPersonas} </label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].cliente ? data[0].cliente.NombreCliente : "Sin Cliente"} </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
    
                                <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                    <div class="card-body" style="padding: 0px; margin: 0px;">
                                        <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                            <h3 class="card-title" style="color: black; margin: 0">VENTA</h3>
                                        </div>
                                        <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                            <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                                ${data[0].detalleconsumos.map((detalle, index) => `
                                                    ${detalle.eliminado === "true" ? `
                                                        <div id="CardOcupado" class="card col-md-12 col-lg-12">
                                                            <div class="card-status-start bg-primary" style="background: red"></div>
                                                            <div class="card-header">
                                                                <div style="width: 100%; display: flex;">
                                                                    <div class="col-md-12 col-lg-2" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.cantidad}</h3>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-7" style="text-align: left; width: 60%;">
                                                                        <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                        <p style="font-size: 12px">CANCELADO: ${detalle.comentarioeliminado}</p>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-3" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.total} <strong>Bs.</strong></h3>                                                                    
                                                                    </div>                                                                
                                                                </div>
                                                            </div>                                                       
                                                        </div><br>
                                                    ` : `
                                                        <div class="card col-md-12 col-lg-12">
                                                            <div class="card-status-start bg-primary"></div>
                                                            <div class="card-header">
                                                                <div style="width: 100%; display: flex;">
                                                                    <div class="col-md-12 col-lg-2" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.cantidad}</h3>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-7" style="text-align: left; width: 60%;">
                                                                        <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                        <p style="font-size: 12px">${detalle.comentario}</p>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-3" style="width: 35%;">
                                                                        <h3 class="card-title">${detalle.total} <strong>Bs.</strong></h3>                                                                    
                                                                    </div>                                                                
                                                                </div>
                                                            </div> 
                                                            
    
                                                            ${detalle.modificadordetalleconsumo.length > 0 ? `
                                                                ${detalle.modificadordetalleconsumo.map(modificador => `
                                                                    <div class="card-header" style="padding-left: 20%;">
                                                                        <div style="display: flex; width: 93%;">
                                                                            <div class="col-md-12 col-lg-3">
                                                                                <h3 class="card-title">${modificador.cantidad}</h3>
                                                                            </div>
                                                                            <div class="col-md-12 col-lg-6" style="text-align: left;">
                                                                                <p class="card-title">${modificador.detallemodificador.producto.NombreProducto} - ${modificador.precio}</p>
                                                                                
                                                                            </div>
                                                                            <div class="col-md-12 col-lg-3" style="text-align: right;">
                                                                                <h3 class="card-title">${modificador.total} Bs.</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `).join('')}`
                                                            : ''}
                                                        </div><br>
                                                    `}
                                                                                                    
                                                `).join('')}
    
                                                <div class="row" style="padding: 5px; margin: 0px; background: #1d2736">
                                                    <div class="col-md-12 col-lg-10">
                                                        <h3 class="card-title" style="color: white">SUBTOTAL</h3>
                                                    </div>
    
                                                    <div class="col-md-12 col-lg-2" style="text-align: right">
                                                        <h3 class="card-title" style="color: white">${data[0].subTotal}</h3>
                                                    </div>
                                                </div>
    
                                                ${data[0].descuentoconsumos.length > 0 ? ` 
                                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                        <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                    </div>
                                                    ${data[0].descuentoconsumos.map((descuento, index) => `
                                                        <div class="row producto-row" style="padding: 8px">
                                                            <div class="col-md-12 col-lg-2" style="width: 50%;">
                                                                <h3 class="card-title">${descuento.TipoDescuento}</h3>
                                                            </div>
                                                            <div class="col-md-12 col-lg-7" style="text-align: left; width: 25%;">
                                                                <p class="card-title">${descuento.MontoDescuento}</p>
                                                            </div>
                                                            <div class="col-md-12 col-lg-3" style="width: 25%; text-align: right">
                                                                <h3 class="card-title">${descuento.TotalDescuento}</h3>                                                                    
                                                            </div>                                            
                                                        </div>
                                                    `).join('')}
                                                    </div>`
                                                : ''}
    
                                                <div class="row" style="padding: 5px; margin: 0px; background: #1d2736">
                                                    <div class="col-md-12 col-lg-10">
                                                        <h3 class="card-title" style="color: white">TOTAL</h3>
                                                    </div>
    
                                                    <div class="col-md-12 col-lg-2" style="text-align: right">
                                                        <h3 class="card-title" style="color: white">${data[0].total}</h3>
                                                    </div>
                                                </div>
    
    
                                                ${data[0].pagosconsumos.length > 0 ? ` 
                                                    <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                        <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                    </div>
                                                    ${data[0].pagosconsumos.map((pago, index) => `
                                                        <div class="row producto-row" style="padding: 8px">
                                                            <div class="col-md-12 col-lg-10" style="width: 75%;">
                                                                <h3 class="card-title">${pago.TipoPago}</h3>
                                                            </div>
                                                            <div class="col-md-12 col-lg-2" style="text-align: right; width: 25%;">
                                                                <p class="card-title">${pago.TotalPago}</p>
                                                            </div>
                                                        </div>
                                                    `).join('')}     
                                                    </div>`
                                                : ''}
                                            
                                        </div>
                                    </div>
                                </div>
                            `
                        : data[0].TipoConsumo == "Mostrador" ?
                        `
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Hora Inicio</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].fecha_venta}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Hora De Cierre</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].FechaCierre}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Tipo</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${tipotext}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${((data.ocupado == 'true') ? 'En Curso' : 'Cerrado')} </label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].cliente ? data[0].cliente.NombreCliente : "Sin Cliente"} </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                    <div class="card-body" style="padding: 0px; margin: 0px;">
                                        <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                            <h3 class="card-title" style="color: black; margin: 0">VENTA</h3>
                                        </div>
                                        <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                            <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                                ${data[0].detalleconsumos.map((detalle, index) => `
                                                    ${detalle.eliminado === "true" ? `
                                                        <div id="CardOcupado" class="card col-md-12 col-lg-12">
                                                            <div class="card-status-start bg-primary" style="background: red"></div>
                                                            <div class="card-header">
                                                                <div style="width: 100%; display: flex;">
                                                                    <div class="col-md-12 col-lg-2" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.cantidad}</h3>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-7" style="text-align: left; width: 60%;">
                                                                        <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                        <p style="font-size: 12px">CANCELADO: ${detalle.comentarioeliminado}</p>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-3" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.total} <strong>Bs.</strong></h3>                                                                    
                                                                    </div>                                                                
                                                                </div>
                                                            </div>                                                       
                                                        </div><br>
                                                    ` : `
                                                        <div class="card col-md-12 col-lg-12">
                                                            <div class="card-status-start bg-primary"></div>
                                                            <div class="card-header">
                                                                <div style="width: 100%; display: flex;">
                                                                    <div class="col-md-12 col-lg-2" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.cantidad}</h3>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-7" style="text-align: left; width: 60%;">
                                                                        <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                        <p style="font-size: 12px">${detalle.comentario}</p>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-3" style="width: 35%;">
                                                                        <h3 class="card-title">${detalle.total} <strong>Bs.</strong></h3>                                                                    
                                                                    </div>                                                                
                                                                </div>
                                                            </div> 
                                                            
    
                                                            ${detalle.modificadordetalleconsumo.length > 0 ? `
                                                                ${detalle.modificadordetalleconsumo.map(modificador => `
                                                                    <div class="card-header" style="padding-left: 20%;">
                                                                        <div style="display: flex; width: 93%;">
                                                                            <div class="col-md-12 col-lg-3">
                                                                                <h3 class="card-title">${modificador.cantidad}</h3>
                                                                            </div>
                                                                            <div class="col-md-12 col-lg-6" style="text-align: left;">
                                                                                <p class="card-title">${modificador.detallemodificador.producto.NombreProducto} - ${modificador.precio}</p>
                                                                                
                                                                            </div>
                                                                            <div class="col-md-12 col-lg-3" style="text-align: right;">
                                                                                <h3 class="card-title">${modificador.total} Bs.</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `).join('')}`
                                                            : ''}
                                                        </div><br>
                                                    `}
                                                                                                    
                                                `).join('')}
    
                                                <div class="row" style="padding: 5px; margin: 0px; background: #1d2736">
                                                    <div class="col-md-12 col-lg-10">
                                                        <h3 class="card-title" style="color: white">SUBTOTAL</h3>
                                                    </div>
    
                                                    <div class="col-md-12 col-lg-2" style="text-align: right">
                                                        <h3 class="card-title" style="color: white">${data[0].subTotal}</h3>
                                                    </div>
                                                </div>
    
                                                ${data[0].descuentoconsumos.length > 0 ? ` 
                                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                        <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                    </div>
                                                    ${data[0].descuentoconsumos.map((descuento, index) => `
                                                        <div class="row producto-row" style="padding: 8px">
                                                            <div class="col-md-12 col-lg-2" style="width: 50%;">
                                                                <h3 class="card-title">${descuento.TipoDescuento}</h3>
                                                            </div>
                                                            <div class="col-md-12 col-lg-7" style="text-align: left; width: 25%;">
                                                                <p class="card-title">${descuento.MontoDescuento}</p>
                                                            </div>
                                                            <div class="col-md-12 col-lg-3" style="width: 25%; text-align: right">
                                                                <h3 class="card-title">${descuento.TotalDescuento}</h3>                                                                    
                                                            </div>                                            
                                                        </div>
                                                    `).join('')}
                                                    </div>`
                                                : ''}
    
                                                <div class="row" style="padding: 5px; margin: 0px; background: #1d2736">
                                                    <div class="col-md-12 col-lg-10">
                                                        <h3 class="card-title" style="color: white">TOTAL</h3>
                                                    </div>
    
                                                    <div class="col-md-12 col-lg-2" style="text-align: right">
                                                        <h3 class="card-title" style="color: white">${data[0].total}</h3>
                                                    </div>
                                                </div>
    
    
                                                ${data[0].pagosconsumos.length > 0 ? ` 
                                                    <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                        <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                    </div>
                                                    ${data[0].pagosconsumos.map((pago, index) => `
                                                        <div class="row producto-row" style="padding: 8px">
                                                            <div class="col-md-12 col-lg-10" style="width: 75%;">
                                                                <h3 class="card-title">${pago.TipoPago}</h3>
                                                            </div>
                                                            <div class="col-md-12 col-lg-2" style="text-align: right; width: 25%;">
                                                                <p class="card-title">${pago.TotalPago}</p>
                                                            </div>
                                                        </div>
                                                    `).join('')}     
                                                    </div>`
                                                : ''}
                                            
                                        </div>
                                    </div>
                                </div>
                            `
                        :
                        `
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                                <div class="col">
                                                <label class="col-12 col-form-label" style="color: black; font-size: 20px; text-align: center">${data[0].TipoVentaSuelta}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Nro Orden</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].NroOrdenVentaSuelta}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Nro Pedido</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].NroPedidoVentaSuelta}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Hora Inicio</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].fecha_venta}</label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${((data.ocupado == 'true') ? 'En Curso' : 'Cerrado')} </label>
                                            </div>
                                        </div>
                                        <div class="mb-12 row">
                                            <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                            <div class="col">
                                                <label class="col-8 col-form-label" style="color: #61677A">${data[0].ClienteVentaSuelta} </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                    <div class="card-body" style="padding: 0px; margin: 0px;">
                                        <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                            <h3 class="card-title" style="color: black; margin: 0">VENTA</h3>
                                        </div>
                                        <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                            <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                                ${data[0].detalleconsumos.map((detalle, index) => `
                                                    ${detalle.eliminado === "true" ? `
                                                        <div id="CardOcupado" class="card col-md-12 col-lg-12">
                                                            <div class="card-status-start bg-primary" style="background: red"></div>
                                                            <div class="card-header">
                                                                <div style="width: 100%; display: flex;">
                                                                    <div class="col-md-12 col-lg-2" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.cantidad}</h3>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-7" style="text-align: left; width: 60%;">
                                                                        <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                        <p style="font-size: 12px">CANCELADO: ${detalle.comentarioeliminado}</p>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-3" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.total} <strong>Bs.</strong></h3>                                                                    
                                                                    </div>                                                                
                                                                </div>
                                                            </div>                                                       
                                                        </div><br>
                                                    ` : `
                                                        <div class="card col-md-12 col-lg-12">
                                                            <div class="card-status-start bg-primary"></div>
                                                            <div class="card-header">
                                                                <div style="width: 100%; display: flex;">
                                                                    <div class="col-md-12 col-lg-2" style="width: 20%;">
                                                                        <h3 class="card-title">${detalle.cantidad}</h3>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-7" style="text-align: left; width: 60%;">
                                                                        <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                                        <p style="font-size: 12px">${detalle.comentario}</p>
                                                                    </div>
                                                                    <div class="col-md-12 col-lg-3" style="width: 35%;">
                                                                        <h3 class="card-title">${detalle.total} <strong>Bs.</strong></h3>                                                                    
                                                                    </div>                                                                
                                                                </div>
                                                            </div> 
                                                            
    
                                                            ${detalle.modificadordetalleconsumo.length > 0 ? `
                                                                ${detalle.modificadordetalleconsumo.map(modificador => `
                                                                    <div class="card-header" style="padding-left: 20%;">
                                                                        <div style="display: flex; width: 93%;">
                                                                            <div class="col-md-12 col-lg-3">
                                                                                <h3 class="card-title">${modificador.cantidad}</h3>
                                                                            </div>
                                                                            <div class="col-md-12 col-lg-6" style="text-align: left;">
                                                                                <p class="card-title">${modificador.detallemodificador.producto.NombreProducto} - ${modificador.precio}</p>
                                                                                
                                                                            </div>
                                                                            <div class="col-md-12 col-lg-3" style="text-align: right;">
                                                                                <h3 class="card-title">${modificador.total} Bs.</h3>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `).join('')}`
                                                            : ''}
                                                        </div><br>
                                                    `}
                                                                                                    
                                                `).join('')}
    
                                                <div class="row" style="padding: 5px; margin: 0px; background: #1d2736">
                                                    <div class="col-md-12 col-lg-10">
                                                        <h3 class="card-title" style="color: white">SUBTOTAL</h3>
                                                    </div>
    
                                                    <div class="col-md-12 col-lg-2" style="text-align: right">
                                                        <h3 class="card-title" style="color: white">${data[0].subTotal}</h3>
                                                    </div>
                                                </div>
    
                                                ${data[0].descuentoconsumos.length > 0 ? ` 
                                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                        <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                    </div>
                                                    ${data[0].descuentoconsumos.map((descuento, index) => `
                                                        <div class="row producto-row" style="padding: 8px">
                                                            <div class="col-md-12 col-lg-2" style="width: 50%;">
                                                                <h3 class="card-title">${descuento.TipoDescuento}</h3>
                                                            </div>
                                                            <div class="col-md-12 col-lg-7" style="text-align: left; width: 25%;">
                                                                <p class="card-title">${descuento.MontoDescuento}</p>
                                                            </div>
                                                            <div class="col-md-12 col-lg-3" style="width: 25%; text-align: right">
                                                                <h3 class="card-title">${descuento.TotalDescuento}</h3>                                                                    
                                                            </div>                                            
                                                        </div>
                                                    `).join('')}
                                                    </div>`
                                                : ''}
    
                                                <div class="row" style="padding: 5px; margin: 0px; background: #1d2736">
                                                    <div class="col-md-12 col-lg-10">
                                                        <h3 class="card-title" style="color: white">TOTAL</h3>
                                                    </div>
    
                                                    <div class="col-md-12 col-lg-2" style="text-align: right">
                                                        <h3 class="card-title" style="color: white">${data[0].total}</h3>
                                                    </div>
                                                </div>
    
    
                                                ${data[0].pagosconsumos.length > 0 ? ` 
                                                    <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                        <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                    </div>
                                                    ${data[0].pagosconsumos.map((pago, index) => `
                                                        <div class="row producto-row" style="padding: 8px">
                                                            <div class="col-md-12 col-lg-10" style="width: 75%;">
                                                                <h3 class="card-title">${pago.TipoPago}</h3>
                                                            </div>
                                                            <div class="col-md-12 col-lg-2" style="text-align: right; width: 25%;">
                                                                <p class="card-title">${pago.TotalPago}</p>
                                                            </div>
                                                        </div>
                                                    `).join('')}     
                                                    </div>`
                                                : ''}
                                            
                                        </div>
                                    </div>
                                </div>
                            ` 
                    }
                        
                    </div>
                </div>
            </div>`;

        $(document).on('click', '#BtnImprimirTicketVentaSuelta', function() {
            const id = $(this).data('id');

            $.ajax({                    
                url: '/api/imprimir-ticket-venta-suelta/'+id,
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    const pdfBase64 = response.pdfBase64;
                    $('#modalBtnImprimirTicketVentaSuelta .modal-body').html(`
                        <iframe src="data:application/pdf;base64,${pdfBase64}" width="100%" height="500px" style="border: none;"></iframe>
                    `);
                    $('#modalBtnImprimirTicketVentaSuelta').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Ocurrió un error al recuperar los datos.');
                    console.error(error);
                }
            });
        });
    }
}

function agregarEventos() {
    $('#table-venta-suelta tbody').on('mouseenter', 'tr', function() {
        $(this).addClass('hovered');
    }).on('mouseleave', 'tr', function() {
        $(this).removeClass('hovered');
    });
}
