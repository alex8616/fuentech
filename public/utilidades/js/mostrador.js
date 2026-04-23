document.addEventListener('DOMContentLoaded', function () {
    CanvasTime();
    GetMostradorAll();
    GetMostradorAllCerrado();
    var btnPedidoNuevo = document.getElementById('MbtnPedidoNuevo');
    btnPedidoNuevo.addEventListener('click', function () {
        var MostradorNuevoPedido = document.getElementById('form_tabs');
        MostradorNuevoPedido.innerHTML = `
            <form>
                <div class="card-header">
                    <div class="row" style="width: 100%">
                        <div class="col-12 col-sm-12">
                            <h3>Nuevo Pedido</h3>
                        </div> 
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <form class="card">
                            <div class="card-body">
                            <div class="mb-3 row" hidden>
                                <label class="col-3 col-form-label required">Caja</label>
                                <div class="col">
                                    <select class="form-select" id="MSeleccionarCaja" name="SeleccionarCaja">
                                    
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label">Cliente</label>
                                <div class="col">
                                <select class="form-select" id="MSeleccionarCliente" name="MSeleccionarCliente">
                                    
                                </select>
                                </div>
                            </div>
                            <div class="mb-3 row" hidden>
                                <label class="col-3 col-form-label">Camarero</label>
                                <div class="col">
                                <select class="form-select" id="MSeleccionarCamarero" name="MSeleccionarCamarero"> 
                                    
                                </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-3 col-form-label pt-0">Comentario</label>
                                <div class="col">
                                <textarea class="form-control" rows="5" id="MComentario" name="MComentario"></textarea>
                                </div>
                            </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary" id="MbtnCrearMostrador">Crear</button>
                            </div>
                        </form>
                    </div>
                </div>                    
            </form>
        `;

        //para el select Caja
        $.ajax({
            url: '/api/get-clientes',
            type: 'GET',
            dataType: 'json',
            success: function (clientes) {
                $('#MSeleccionarCaja').empty();

                $('#MSeleccionarCaja').append($('<option>', {
                    value: '1',
                    text: 'Seleccione la caja',
                    selected: true,
                }));
                
                for (var i = 0; i < clientes.length; i++) {
                    var cliente = clientes[i];
                    $('#MSeleccionarCaja').append($('<option>', {
                        value: cliente.id,
                        text: cliente.NombreCliente
                    }));
                }
            },
            error: function (error) {
                console.error('Error al obtener clientes:', error);
            }
        });

        //para el select cliente
        $('#MSeleccionarCliente').select2({
            ajax: {
                url: '/api/get-clientes', // Ruta de tu controlador
                dataType: 'json',
                delay: 250, // Tiempo de espera antes de hacer la petición
                data: function (params) {
                    return {
                        search: params.term, // Término de búsqueda
                        page: params.page || 1 // Número de página
                    };
                },
                processResults: function (data, params) {
                    // Almacenar la página actual
                    params.page = params.page || 1;

                    return {
                        results: data.data, // Datos que provienen de la respuesta
                        pagination: {
                            more: (params.page * data.per_page) < data.total // Verifica si hay más páginas
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 1, // Mínimo caracteres antes de buscar
            placeholder: 'Selecciona un cliente', // Placeholder
            templateResult: formatCliente, // Función para formatear el resultado
            templateSelection: formatClienteSelection // Función para formatear la selección
        });
    
        // Formato de los resultados en el dropdown
        function formatCliente(cliente) {
            if (cliente.loading) {
                return cliente.text; // Muestra un texto de carga
            }
            // Formato del cliente a mostrar en el dropdown
            return $('<div>' + cliente.NombreCliente + ' (' + cliente.EmailCliente + ')</div>');
        }
    
        // Formato de la selección
        function formatClienteSelection(cliente) {
            return cliente.NombreCliente || cliente.text; // Muestra solo el nombre del cliente seleccionado
        }

        //para el select camareros
        $.ajax({
            url: '/api/get-camarero',
            type: 'GET',
            dataType: 'json',
            success: function (camareros) {
                $('#MSeleccionarCamarero').empty();

                $('#MSeleccionarCamarero').append($('<option>', {
                    value: '',
                    text: 'Seleccione un camarero',
                    selected: true,
                }));

                for (var i = 0; i < camareros.length; i++) {
                    var camarero = camareros[i];
                    $('#MSeleccionarCamarero').append($('<option>', {
                        value: camarero.id,
                        text: camarero.NombreCamarero
                    }));
                }
            },
            error: function (error) {
                console.error('Error al obtener camareros:', error);
            }
        });

        $('#MbtnCrearMostrador').off('click').on('click', function(event) {
            event.preventDefault();
            var MClienteID = $("#MSeleccionarCliente").val();
            var MCamareroID = $("#MSeleccionarCamarero").val();
            var MComentario = $("#MComentario").val();
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/api/registrar-consumo-mostrador',
                type: 'POST',
                data: {
                    _token: token,
                    mcliente_id: MClienteID,
                    mcamarero_id: MCamareroID,
                    mComentario: MComentario
                },
                success: function(consumo) {
                    GetMostradorAll();
                    GetMostrador(consumo.id);
                    DivTotalConsumo(consumo.id);
                },
                
                error: function(error) {
                    MostrarMensaje("La Mesa Noce Pudo Ocupar","error");
                }
            });
        });
    });
});

function DivTotalConsumo(ConsumoId) {
    function DescuentoDiv() {
        var btn = document.getElementById('btnPorcentajeMostrador');
        var id = btn.getAttribute('data-id');
        // Haz lo que necesites con el id
        var DivDescuento = document.getElementById('DivDescuento');
        DivDescuento.innerHTML = 
        `<div class="row" data-index="${id}" style="background: #DDE6ED; padding: 10px; widht: 100%">
            <input type="number" value="${id}" id="IdDescuento" class="form-control" style="width: 100%" hidden>
            <div class="col-sm-6">
                <div class="mb-3 row">
                    <label class="col-3 col-form-label" style="width: 40%">Descuento: </label>
                    <div class="col">
                    <input type="number" id="DescuentoPorcentaje" class="form-control" style="width: 100%">
                    </div>
                    <label class="col-3 col-form-label" style="width: 10%">%</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3 row">
                    <label class="col-3 col-form-label" style="width: 50%">Bs: </label>
                    <div class="col">
                    <input type="number" id="DescuentoMonto" class="form-control" style="width: 100%">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="badge bg-red-lt" id="btnDescuentoCancelar">Cancelar</button>
                <button type="button" class="badge bg-green-lt" id="btnDescuentoConfirmar">Confirmar</button>
            </div>
        </div>`;

        document.getElementById('btnDescuentoCancelar').addEventListener('click', function () {
            DivDescuento.innerHTML = '';
        });

        //para los inputs
        document.getElementById('DescuentoPorcentaje').addEventListener('input', function () {
            var porcentaje = parseInt(this.value, 10) || 0;

            if (porcentaje < 1) {
                porcentaje = '';
            } else if (porcentaje > 100) {
                porcentaje = 100;
            }

            this.value = porcentaje;

            var montoInput = document.getElementById('DescuentoMonto');
            montoInput.value = ''; // Limpiar el valor del monto
            montoInput.disabled = true; // Desactivar el input de monto

            // Habilitar el input DescuentoMonto si DescuentoPorcentaje está vacío
            if (!this.value.trim()) {
                montoInput.disabled = false;
            }
        });
        document.getElementById('DescuentoMonto').addEventListener('input', function () {
            var monto = parseFloat(this.value) || 0;

            var porcentajeInput = document.getElementById('DescuentoPorcentaje');
            porcentajeInput.value = ''; // Limpiar el valor del porcentaje
            porcentajeInput.disabled = true; // Desactivar el input de porcentaje

            // Habilitar el input DescuentoPorcentaje si DescuentoMonto está vacío
            if (!this.value.trim()) {
                porcentajeInput.disabled = false;
            }
        });

        
        document.getElementById('btnDescuentoConfirmar').addEventListener('click', function () {
            var idDescuento = document.getElementById('IdDescuento').value;
            var descuentoPorcentaje = document.getElementById('DescuentoPorcentaje').value;
            var descuentoMonto = document.getElementById('DescuentoMonto').value;
            $.ajax({
                url: '/api/registrar-descuento',
                type: 'POST',
                data: {
                    id: idDescuento,
                    porcentaje: descuentoPorcentaje,
                    monto: descuentoMonto
                },
                success: function (response) {
                    DivDescuento.innerHTML = '';
                    ListarDescuentos(id)
                    MostrarMensaje('Descuento Registrado Correctamente','success');
                    //actualiza total
                    $.ajax({
                        url: '/api/get-consumo-ocupado-mostrador/' + ConsumoId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (consumo) {
                            var SubTotalProduct = document.getElementById('DivSubTotal');
                            if (consumo[0].descuentoconsumos.length > 0) {
                                SubTotalProduct.innerHTML = `
                                    <div class="row" style="background: #243A73; padding: 20px;">
                                        <div class="col-sm-7">
                                            <div class="input-group" style="width: 100%">
                                                <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-5" style="text-align: right">
                                            <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                                        </div>
                                    </div>
                                `;
                            } else {
                                SubTotalProduct.innerHTML = '';
                            }
                            var TotalProduct = document.getElementById('DivTotal');
                            TotalProduct.innerHTML = `
                                <div class="row" style="background: #243A73; padding: 20px;">
                                    <div class="col-sm-7">
                                        <div class="input-group" style="width: 100%">
                                            <span style="font-size: 20px; color: white">TOTAL</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5" style="text-align: right">
                                        <span style="font-size: 20px; color: white">${consumo[0].total} Bs.</span>
                                    </div>
                                </div>
                            `;
                        },
                        error: function (error) {
                            MostrarMensaje(error,'error');
                        }
                    });
                },
                error: function (error) {
                    MostrarMensaje(error,'error');
                }
            });
        });                                        

    }
    ///aqui total
    $.ajax({
        url: '/api/get-consumo-ocupado-mostrador/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            var SubTotalProduct = document.getElementById('DivSubTotal');
            var IdConsumo = consumo[0].id;

            if (consumo[0].descuentoconsumos.length > 0) {
                SubTotalProduct.innerHTML = `
                    <div class="row" style="background: #243A73; padding: 20px;">
                        <div class="col-sm-7">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 20px; color: white">SUB TOTAL</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                        </div>
                    </div>
                `;
            } else {
                SubTotalProduct.innerHTML = '';
            }

            var TotalProduct = document.getElementById('DivTotal');
            TotalProduct.innerHTML = `
                <div class="row" style="background: #243A73; padding: 20px;">
                    <div class="col-sm-7">
                        <div class="input-group" style="width: 100%">
                            <span style="font-size: 20px; color: white">TOTAL</span>
                        </div>
                    </div>
                    <div class="col-sm-5" style="text-align: right">
                        <span style="font-size: 20px; color: white">${consumo[0].total} Bs.</span>
                    </div>
                </div>
            `;
            var DivBotones = document.getElementById('DivBotonesFooter');
            DivBotones.innerHTML = `
                <div class="col-md-6 col-lg-12 d-flex justify-content-between">
                    <button type="button" class="btn btn-primary" id="btnPorcentajeMostrador" data-id="${IdConsumo}" style="text-align: center; padding: 0px; margin: 0px; padding-left: 6px; padding-right: 6px">
                        <span style="font-size: 20px; font-weight: bold;">%</span>
                    </button>

                    <button type="button" data-bs-toggle="modal" data-bs-target="#ModalCerrarMostrador" class="btn btn-danger" data-id="${IdConsumo}" id="btnCerrarMostrador">Concluir</button>
                </div>
            `;

            // Vuelve a asignar el controlador de eventos al botón de porcentaje
            document.getElementById('btnPorcentajeMostrador').onclick = DescuentoDiv;
            document.getElementById('btnCerrarMostrador').onclick = MostradorguardarCambios;

        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function agregarDetallesConsumo(ConsumoId) {
    $.ajax({
        url: '/api/get-consumo-ocupado-mostrador/'+ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            DivagregarDetallesConsumo(consumo[0].detalleconsumos, ConsumoId);
            ListarDescuentos(consumo[0].id)
            DivTotalConsumo(consumo[0].id);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function DivagregarDetallesConsumo(detalleconsumos, ConsumoId) {
    $.ajax({
        url: '/api/get-consumo-ocupado-mostrador/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {  
        DivPedidos.innerHTML = '';
        detalleconsumos.forEach(function (detalle, index) {
            var nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'row producto-row';
                if(detalle.eliminado == 'true'){
                    nuevoDiv.innerHTML = `
                        <div class="col-md-12 col-lg-12" style="width: 100%; padding: 0px; margin: 0px;">
                            <div class="card" id="CardOcupado" style="width: 100%; padding: 0px; margin: 0px;">
                                <div class="card-status-start bg-primary"></div>
                                <div class="card-header" style="padding: 0px; margin: 0px; height: auto;">
                                    <div style="width: 100%; padding-top: 10px; margin: 0px; display: flex; height: auto;">
                                        <div class="col-md-12 col-lg-2" style="width: auto;">
                                            <h3 class="card-title">${detalle.cantidad}</h3>
                                        </div>
                                        <div class="col-md-12 col-lg-7" style="text-align: left; width: 100%;">
                                            <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                            <p style="font-size: 12px">CANCELADO: ${detalle.comentarioeliminado}</p>
                                        </div>
                                        <div class="col-md-12 col-lg-3" style="width: 50%;">
                                            <h3 class="card-title">${detalle.total}</h3>                                                                    
                                        </div>
                                        <div class="col-md-12 col-lg-1"  style="width: auto; text-aling: right;">
                                            <a class="nav-link">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }else{
                    if (detalle.modificadordetalleconsumo.length === 0) {                                                    
                        // Si está vacío, muestra el HTML correspondiente
                        nuevoDiv.innerHTML = `
                            <div class="col-md-12 col-lg-12" style="width: 100%; padding: 0px; margin: 0px;">
                                <div class="card" style="width: 100%; padding: 0px; margin: 0px;">
                                    <div class="card-status-start bg-primary"></div>
                                    <div class="card-header" style="padding: 0px; margin: 0px; height: auto;">
                                        <div style="width: 100%; padding-top: 10px; margin: 0px; display: flex; height: auto;">
                                            <div class="col-md-12 col-lg-2" style="width: auto;">
                                                <h3 class="card-title">${detalle.cantidad}</h3>
                                            </div>
                                            <div class="col-md-12 col-lg-7" style="text-align: left; width: 100%;">
                                                <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                <p style="font-size: 12px">${detalle.comentario}</p>
                                            </div>
                                            <div class="col-md-12 col-lg-3" style="width: 50%;">
                                                <h3 class="card-title">${detalle.total}</h3>                                                                    
                                            </div>
                                            <div class="col-md-12 col-lg-1"  style="width: auto; text-aling: right;">
                                                <a class="nav-link" data-bs-toggle="modal" data-bs-target="#ElminarDetalle" data-index="${index}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                </a>
                                            </div>                                                                    
                                        </div>
                                    </div>    
                                    <div>                                                               
                                    </div>                                                        
                                </div>
                            </div>
                        `;
                    } else {                                                    
                        // Si no está vacío, muestra el HTML correspondiente
                        IdMod = detalle.producto.modificadore_id
                        nuevoDiv.innerHTML = `
                            <div class="col-md-12 col-lg-12" style="width: 100%; padding: 0px; margin: 0px;">
                                <div class="card" style="width: 100%; padding: 0px; margin: 0px;">
                                    <div class="card-status-start bg-primary"></div>
                                    <div class="card-header" style="padding: 0px; margin: 0px; height: auto; border-bottom: 0px solid black">
                                        <div style="width: 100%; padding-top: 10px; margin: 0px; display: flex; height: auto;">
                                            <div class="col-md-12 col-lg-2" style="width: auto;">
                                                <h3 class="card-title">${detalle.cantidad}</h3>
                                            </div>
                                            <div class="col-md-12 col-lg-7" style="text-align: left; width: 100%;">
                                                <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.producto.PrecioProducto}</p>
                                                <p style="font-size: 12px;">
                                                    ${detalle.comentario} 
                                                    <a id="AddModificadorMostrador" style="color: blue" data-bs-toggle="modal" data-bs-target="#ModalAddModificadorMostrador" data-IdModificador="${IdMod}" data-IdDetalle="${detalle.id}">Add</a>
                                                </p>
                                            </div>
                                            <div class="col-md-12 col-lg-3" style="width: 50%;">
                                                <h3 class="card-title">${detalle.total}</h3>                                                                    
                                            </div>
                                            <div class="col-md-12 col-lg-1"  style="width: auto; text-aling: right;">
                                                <a class="nav-link" data-bs-toggle="modal" data-bs-target="#ElminarDetalle" data-index="${index}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: -30px; padding: 10px;">
                                        ${detalle.modificadordetalleconsumo.map(modificador => `
                                            <div class="card-header" style="padding: 0px; margin: 0px; height: auto; border-bottom: 0px solid red;">
                                                <div style="width: 100%; padding-top: 10px; margin: 0px; display: flex; height: auto;">
                                                    <div class="col-md-12 col-lg-2" style="width: 100%;">
                                                        <h3 class="card-title" id="Cantidad${modificador.id}">${modificador.cantidad}</h3>
                                                    </div>
                                                    <div class="col-md-12 col-lg-5" style="text-align: left; width: 100%;">
                                                        <p class="card-title">${modificador.detallemodificador.producto.NombreProducto} - ${modificador.precio}</p>
                                                        
                                                    </div>
                                                    <div class="col-md-12 col-lg-3" style="width: 100%;">
                                                        <h3 class="card-title">${modificador.total}</h3>                                                                    
                                                    </div>
                                                    <div class="col-md-12 col-lg-1" style="margin: 0px; padding: 0px">
                                                        <span class="badge badge-outline text-green" data-bs-toggle="modal" data-bs-target="#ModalEditarModificadorMostrador" data-IdEditModifMostrador="${modificador.id}" style="padding: 0px; padding-top: 5px; height: 21px; width: 100%;">E</span>
                                                    </div>
                                                    <div class="col-md-12 col-lg-1" style="margin: 0px; padding: 0px">
                                                        <span class="badge badge-outline text-red" data-bs-toggle="modal" data-bs-target="#ModalEliminarModificadorMostrador" data-IdEliminarModif="${modificador.id}" style="padding: 0px; padding-top: 5px; height: 21px; width: 100%;">X</span>
                                                    </div>
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>                                                        
                                </div>
                            </div>
                        `;
                    }

                    detalle.modificadordetalleconsumo.forEach(modificador => {
                        var editButton = nuevoDiv.querySelector(`[data-IdEditModifMostrador="${modificador.id}"]`);
                        if (editButton) {
                            editButton.addEventListener('click', function() {
                                var modalBody = document.querySelector('#ModalEditarModificadorMostrador .modal-body');
                                modalBody.innerHTML = '';
                        
                                var cantidad = modificador.cantidad;
                                var precio = modificador.precio;
                        
                                function calcularTotal() {
                                    var cantidadInputMostrador = document.getElementById('EditCantidadMostrador');
                                    var totalInputMostrador = document.getElementById('Mostrador'); // Cambiado a 'Mostrador'
                                    var precioInputMostrador = document.getElementById('EditPrecio'); // Agregado
                                    var nuevaCantidad = parseInt(cantidadInputMostrador.value);
                                    var nuevoPrecio = parseFloat(precioInputMostrador.value); // Nuevo
                                    var nuevoTotal = nuevaCantidad * nuevoPrecio; // Usar el precio actualizado
                                    totalInputMostrador.value = nuevoTotal.toFixed(2);
                                }

                                var productoHtml = `
                                    <div class="row row-cards">
                                        <div class="col-sm-6 col-md-3">
                                            <input type="text" class="form-control" id="EditIdMostrador" value="${modificador.id}" hidden>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre Producto</label>
                                                <input type="text" class="form-control" value="${modificador.detallemodificador.producto.NombreProducto}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Precio</label>
                                                <input type="text" class="form-control" id="EditPrecio" value="${precio}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Cantidad</label>
                                                <input type="text" class="form-control" id="EditCantidadMostrador" value="${cantidad}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Total</label>
                                                <input type="text" class="form-control" id="Mostrador" value="${cantidad * precio}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                modalBody.insertAdjacentHTML('beforeend', productoHtml);
                                calcularTotal();
                                var cantidadInputMostrador = document.getElementById('EditCantidadMostrador');
                                cantidadInputMostrador.addEventListener('input', calcularTotal);
                        
                            });
                        }
                    });

                    detalle.modificadordetalleconsumo.forEach(modificador => {
                        var eliminarButton = nuevoDiv.querySelector(`[data-IdEliminarModif="${modificador.id}"]`);
                        if (eliminarButton) {
                            eliminarButton.addEventListener('click', function() {
                                var modalBody = document.querySelector('#ModalEliminarModificadorMostrador .modal-body');
                                modalBody.innerHTML = '';
                        
                                var productoHtml = `
                                    <div class="row row-cards">
                                        <div class="col-sm-12 col-md-12">
                                            <input type="text" class="form-control" id="EliminarId" value="${modificador.id}" hidden>
                                            <div class="mb-3">
                                                <label class="form-label">ESTAS SEGURO QUE DESEAS ELIMINAR?</label>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                modalBody.insertAdjacentHTML('beforeend', productoHtml);
                            });
                        }
                    });

                }


                DivPedidos.appendChild(nuevoDiv);     
                
                var addButton = nuevoDiv.querySelector('#AddModificadorMostrador');
                if (addButton) {
                    addButton.addEventListener('click', function() {
                        var idModificador = addButton.getAttribute('data-IdModificador');
                        var IdDetalle = addButton.getAttribute('data-IdDetalle');
                        $.ajax({
                            url: '/api/get-modificador-seleccionado-mostrador/'+idModificador,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                var modalBody = document.querySelector('#ModalAddModificadorMostrador .modal-body');
                                modalBody.innerHTML = '';
                                data.detallemodificador.forEach(function (detalle) {
                                    var productoHtml = `
                                        <div class="row row-cards" id="productoDiv" style="padding: 20px; margin: 2px">
                                            <div class="col-sm-6 col-md-1">
                                                <input type="text" class="form-control" id="MIdproducto_Mostrador${detalle.id}" value="${detalle.producto.id}" hidden>
                                                <input type="text" class="form-control" id="MIdDetalle_Mostrador${detalle.id}" value="${detalle.id}" hidden>
                                                <div class="mb-3">
                                                    <label class="form-check" style="padding: 15px; margin: 20px">
                                                        <input class="form-check-input" type="checkbox" id="ChexInput_Mostrador${detalle.id}" style="border: 4px solid black; width: 20px; height: 20px">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre Producto</label>
                                                    <input type="text" class="form-control" value="${detalle.producto.NombreProducto}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Precio</label>
                                                    <input type="text" class="form-control" id="MPrecio_Mostrador${detalle.id}" value="${detalle.CostoDetalleModificador}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label class="form-label">Cantidad</label>
                                                    <input type="text" class="form-control" id="MCantidad_Mostrador${detalle.id}" value="1">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Total</label>
                                                    <input type="text" id="MTotal_Mostrador${detalle.id}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    modalBody.insertAdjacentHTML('beforeend', productoHtml);
                                
                                    var checkboxIdMostrador = `ChexInput_Mostrador${detalle.id}`;
                                    var cantidadIdMostrador = `MCantidad_Mostrador${detalle.id}`;
                                    var precioIdMostrador = `MPrecio_Mostrador${detalle.id}`;
                                    var totalIdMostrador = `MTotal_Mostrador${detalle.id}`;

                                    var cantidadInputMostrador = document.getElementById(cantidadIdMostrador);
                                    var precioInputMostrador = document.getElementById(precioIdMostrador);
                                    var totalInputMostrador = document.getElementById(totalIdMostrador);

                                    function calcularTotal() {
                                        var cantidad = parseInt(cantidadInputMostrador.value) || 0;
                                        var precio = parseFloat(precioInputMostrador.value) || 0;
                                        var total = cantidad * precio;
                                        totalInputMostrador.value = total.toFixed(2);
                                    }
                                    
                                    // Agregar controladores de eventos para calcular el total dinámicamente
                                    cantidadInputMostrador.addEventListener('input', calcularTotal);
                                    precioInputMostrador.addEventListener('input', calcularTotal);
                                    
                                    // Calcular el total inicialmente
                                    calcularTotal();
                                    

                                    var checkboxIdMostrador = `ChexInput_Mostrador${detalle.id}`;
                                    document.getElementById(checkboxIdMostrador).addEventListener('change', function() {
                                        var productoDiv = this.closest('.row-cards');
                                        if (this.checked) {
                                            productoDiv.style.backgroundColor = '';
                                            productoDiv.style.opacity = '1';
                                            productoDiv.style.backgroundImage = 'none';
                                        } else {
                                            productoDiv.style.backgroundColor = 'lightgray';
                                            productoDiv.style.opacity = '0.6';
                                            productoDiv.style.backgroundSize = '9px 9px';
                                            productoDiv.style.backgroundImage = 'repeating-linear-gradient(45deg, #ff0000 0, #ff0000 0.8px, #ffffff 0, #ffffff 50%)'; // Restablecer la imagen de fondo
                                        }
                                    });                                                                                                                        
                                });
                                
                                var addModfBtn = document.getElementById('btnAddModMostrador');
                                addModfBtn.addEventListener('click', function handleClick() {
                                    var detalles = data.detallemodificador;
                                    var datosArray = [];

                                    detalles.forEach(function(detalle) {
                                        var cantidadElement = document.getElementById(`MCantidad_Mostrador${detalle.id}`);
                                        var precioElement = document.getElementById(`MPrecio_Mostrador${detalle.id}`);
                                        var totalElement = document.getElementById(`MTotal_Mostrador${detalle.id}`);
                                        var idElement = IdDetalle;
                                        var idElement2 = document.getElementById(`MIdDetalle_Mostrador${detalle.id}`);
                                        var checkboxIdMostrador = `ChexInput_Mostrador${detalle.id}`;
                                        var checkboxElement = document.getElementById(checkboxIdMostrador);

                                        if (cantidadElement && precioElement && totalElement && idElement && checkboxElement) {
                                            var cantidad = parseInt(cantidadElement.value);
                                            var precio = parseFloat(precioElement.value);
                                            var total = parseFloat(totalElement.value);
                                            var idproducto = parseFloat(idElement);
                                            var idDetalle = parseFloat(idElement2.value);
                                            var checkboxValue = checkboxElement.checked;

                                            var data = {
                                                iddetalleconsumo: idproducto,
                                                iddetallemodificadore: idDetalle,
                                                cantidad: cantidad,
                                                precio: precio,
                                                total: total,
                                                checkboxValue: checkboxValue
                                            };

                                            datosArray.push(data);
                                        }
                                    });

                                    $.ajax({
                                        url: '/api/registrar-modificador-consumo-mostrador',
                                        type: 'POST',
                                        contentType: 'application/json',
                                        data: JSON.stringify(datosArray),
                                        success: function(response) {
                                            GetMostradorAll();
                                            var modalAdd = document.getElementById('ModalAddModificadorMostrador');
                                            $(modalAdd).modal('hide');
                                            GetMostrador(response.id);
                                            var DivPedidos = document.getElementById('DivPedidos');
                                            agregarDetallesConsumo(response.id);
                                            DivTotalConsumo(response.id);
                                            MostrarMensaje('Se agrego exitosamente','success')
                                        },
                                        error: function(xhr, status, error) {
                                            MostrarMensaje('Error al enviar los datos','error')
                                        }
                                    });

                                    // Remover el evento de clic después de hacer clic una vez
                                    addModfBtn.removeEventListener('click', handleClick);
                                });


                            },
                            error: function(error) {
                                console.error('Error:', error);
                            }
                        });
                    });
                }

            });

            $('#ElminarDetalle').on('show.bs.modal', function (event) {
                var link = $(event.relatedTarget);
                var index = link.data('index');
                var detalle = detalleconsumos[index];
                var modal = $(this);
                modal.find('#detalleIdInput').val(detalle && detalle.id || '');
            });

            var botonAceptar = $('#CancelarDetalle');
            var textareaComentario = $('#TextComentario');
            botonAceptar.prop('disabled', true);
            textareaComentario.on('input', function() {
                botonAceptar.prop('disabled', $(this).val().trim() === '');
            });

            var botonAceptar = $('#CancelarDetalle');
                $('#CancelarDetalle').off('click').on('click', function (event) {

                var detalleId = $('#detalleIdInput').val();
                var comentario = $('#TextComentario').val();
                
                $.ajax({
                    url: '/api/delete-detalle-consumo/' + detalleId,
                    type: 'POST',
                    data: { detalleId: detalleId, comentario: comentario },
                    success: function (response) {
                        MostrarMensaje('Se Cancelo su detalle del pedido','success')
                        agregarDetallesConsumo(ConsumoId);
                    },
                    error: function (error) {
                        MostrarMensaje('hubo un problema en borrar','error')
                    }
                });
            });

        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

var btnActualizaModMostrador = document.getElementById('btnActualizaModMostrador');
btnActualizaModMostrador.addEventListener('click', function() {                                                
    var cantidad = parseInt(document.getElementById('EditCantidadMostrador').value);
    var precio = parseFloat(document.getElementById('EditPrecio').value);
    var total = parseFloat(document.getElementById('Mostrador').value);
    var id = parseFloat(document.getElementById('EditIdMostrador').value);

    var data = {
        id: id,
        cantidad: cantidad,
        precio: precio,
        total: total
    };

    $.ajax({
        url: '/api/actualizar-modificador-consumo-mostrador',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            GetMostradorAll();
            var modalAdd = document.getElementById('ModalAddModificadorMostrador');
            $(modalAdd).modal('hide');
            GetMostrador(response.id);
            var DivPedidos = document.getElementById('DivPedidos');
            agregarDetallesConsumo(response.id);
            DivTotalConsumo(response.id);
            MostrarMensaje('Se agrego exitosamente','success')
        },
        error: function(xhr, status, error) {
            console.error('Error al enviar los datos:', error);
        }
    });
    $(this).off('click');
});

var eliminarModfBtn = document.getElementById('EliminarModfMostrador');
eliminarModfBtn.addEventListener('click', function() {
    var id = document.getElementById('EliminarId').value;
    var data = {
        id: id,
        total: total
    };
    $.ajax({
        url: '/api/eliminar-modificador-consumo-mostrador',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            GetMostradorAll();
            GetMostrador(response.id);
            var DivPedidos = document.getElementById('DivPedidos');
            agregarDetallesConsumo(response.id);
            DivTotalConsumo(response.id);
            MostrarMensaje('Se agrego exitosamente','success')
        },
        error: function(xhr, status, error) {
            console.error('Error al enviar los datos:', error);
        }
    });
    $(this).off('click');
});



function GetMostradorAll() {
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
                GetMostradorAllCerrado()
                $('#MostradorTableCurso tbody tr').not(this).removeClass('selected');
                $(this).toggleClass('selected');
                if ($(this).hasClass('selected')) {
                    id = $(this).find('td:first').text();
                    GetMostrador(id);
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


function GetMostradorAllCerrado() {
    $.ajax({
        url: '/api/get-mostrador-consumo-all-cerrado',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#MostradorTableCerrado tbody').empty();

            $.each(data, function (index, consumo) {
                var row = `<tr>
                            <td>${consumo.id}</td>
                            <td>${consumo.fecha_venta}</td>
                            <td><span class="badge badge-outline text-green">Cerrado</span></td>
                            <td>${consumo.cliente ? consumo.cliente.NombreCliente : '-'}</td>
                            <td>${consumo.total}</td>
                            <td class="w-1"></td>
                        </tr>`;
                $('#MostradorTableCerrado tbody').append(row);
            });

            var id;

            $('#MostradorTableCerrado').off('click').on('click', 'tbody tr', function (event) {
                event.preventDefault();  
                GetMostradorAll();
                $(this).toggleClass('selected');
                if ($(this).hasClass('selected')) {
                    id = $(this).find('td:first').text();
                    GetMostradorCerrado(id)
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
    

function GetMostradorCerrado(consumo){
    $.ajax({
        url: '/api/get-mostrador-consumo-cerrado/'+consumo,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var MostradorNuevoPedido = document.getElementById('form_tabs');
                MostradorNuevoPedido.innerHTML = `
                    <form>
                        <div class="card-header" style="background: #202c3b">
                            <div class="row" style="width: 100%">
                                <div class="col-12 col-sm-10">
                                    <h3 class="card-title" style="color: white">Pedido # ${data[0].id}</h3>
                                </div>
                                <div class="col-12 col-sm-2" style="text-align: right">
                                    <a href="#" class="btn btn-outline-light active w-100" style="padding: 20px: margin: 10px" data-id="${data[0].id}" id="BtnImprimirTicketMostrador" data-bs-toggle="modal" data-bs-target="#modalBtnImprimirTicketMostrador">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                                    </a>
                                </div>
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="col-md-12">
                                <form class="card">
                                    <div class="card-header">
                                        <div>
                                            <p><strong style="color: red">${data[0].Comentario}</strong> </p>
                                            <p><strong>Hora De Inicio:</strong> ${data[0].fecha_venta}</p>
                                            ${data[0].cliente ? `<p><strong>Cliente:</strong> ${data[0].cliente.NombreCliente}</p>` : ''}
                                            ${data[0].camarero ? `<p><strong>Camarero:</strong> ${data[0].camarero.NombreCamarero}</p>` : ''}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                    <div class="mb-3 row">
                                        <div class="mb-3">
                                            <div class="row g-2">
                                                <div class="col-md-12" style="background: #202c3b; color: white; padding: 6px">
                                                    <label style="font-size: 15px">PRODUCTOS PEDIDOS</label>
                                                </div>
                                            </div>    
                                            <div class="row g-2" id="detalleConsumosSection" style="padding-top: 10px">
                                            </div>                                               
                                        </div>                                            
                                        <div class="mb-3">
                                            <div class="row g-2">
                                                <div class="col-md-10" style="background: #424769; color: white; padding: 6px">
                                                    <label style="font-size: 15px">SubTotal</label>
                                                </div>
                                                <div class="col-md-2" style="background: #424769; color: white; padding: 6px">
                                                    <label style="font-size: 15px; text-align: right;">${data[0].subTotal}</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row g-2" id="detalleDescuentosSection">
                                                    </div>
                                                </div>
                                                <div class="col-md-10" style="background: #202c3b; color: white; padding: 6px">
                                                    <label style="font-size: 21px">Total</label>
                                                </div>
                                                <div class="col-md-2" style="background: #202c3b; color: white; padding: 6px">
                                                    <label style="font-size: 21px">${data[0].total}</label>
                                                </div>
                                                <div class="col-md-12" style="background: #424769; color: white; padding: 6px">
                                                    <label class="form-label">PAGOS</label>
                                                    <div class="row g-2" id="detallePagosSection">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </form>
                            </div>
                        </div>                  
                    </form>
                `;

                $(document).on('click', '#BtnImprimirTicketMostrador', function() {
                    const id = $(this).data('id');
        
                    $.ajax({                    
                        url: '/api/imprimir-ticket-mostrador/'+id,
                        type: 'GET',
                        data: { id: id },
                        success: function(response) {
                            const pdfBase64 = response.pdfBase64;
                            $('#modalBtnImprimirTicketMostrador .modal-body').html(`
                                <iframe src="data:application/pdf;base64,${pdfBase64}" width="100%" height="500px" style="border: none;"></iframe>
                            `);
                            $('#modalBtnImprimirTicketMostrador').modal('show');
                        },
                        error: function(xhr, status, error) {
                            alert('Ocurrió un error al recuperar los datos.');
                            console.error(error);
                        }
                    });
                });

                var detalleConsumosSection = document.getElementById('detalleConsumosSection');

                data[0].detalleconsumos.forEach(function (detalleConsumo, index) {
                    if (detalleConsumo.eliminado === "true") {
                        var detalleConsumoHTML = `
                            <div class="col-md-12 col-lg-12">
                                <div class="card" id="CardOcupado">
                                    <div class="card-status-start bg-primary"></div>
                                    <div class="card-header" style="margin-bottom: 0px; padding: 5px; padding-top: 15px; padding-left: 15px">
                                        <div class="row" style="width: 100%;">
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title">${detalleConsumo.cantidad}</h3>
                                            </div>
                                            <div class="col-md-12 col-lg-8" style="text-align: left;">
                                                <p class="card-title">${detalleConsumo.producto.NombreProducto}</p>
                                                <p style="font-size: 12px">${detalleConsumo.comentario} CANCELADO: ${detalleConsumo.comentarioeliminado}</p>
                                            </div>
                                            <div class="col-md-12 col-lg-2" style="text-align: right;">
                                                <h3 class="card-title" style="text-decoration:line-through;">${detalleConsumo.precio}</h3>                                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        var detalleConsumoHTML = `
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-status-start bg-primary"></div>
                                    <div class="card-header" style="margin-bottom: 0px; padding: 5px; padding-top: 15px; padding-left: 15px">
                                        <div class="row" style="width: 100%">
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title">${detalleConsumo.cantidad}</h3>
                                            </div>
                                            <div class="col-md-12 col-lg-8" style="text-align: left;">
                                                <p class="card-title">${detalleConsumo.producto.NombreProducto}</p>
                                                <p style="font-size: 12px">${detalleConsumo.comentario}</p>
                                            </div>
                                            <div class="col-md-12 col-lg-2" style="text-align: right;">
                                                <h3 class="card-title">${detalleConsumo.precio}</h3>                                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    detalleConsumosSection.innerHTML += detalleConsumoHTML;
                });

                var detalleDescuentosSection = document.getElementById('detalleDescuentosSection');
                data[0].descuentoconsumos.forEach(function (descuentoconsumo) {
                    if (descuentoconsumo.TipoDescuento === "porcentaje") {
                        var detalleDescuentoHTML = `
                            <div class="col-md-6">
                                <label class="form-label">Descuento % ${descuentoconsumo.MontoDescuento}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-end">${descuentoconsumo.TotalDescuento}</label>
                            </div>
                        `;
                    }else{
                        var detalleDescuentoHTML = `
                            <div class="col-md-6">
                                <label class="form-label">Descuento ${descuentoconsumo.MontoDescuento}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-end">${descuentoconsumo.TotalDescuento}</label>
                            </div>
                        `;
                    }
                    detalleDescuentosSection.innerHTML += detalleDescuentoHTML;
                });

                var detallePagosSection = document.getElementById('detallePagosSection');
                data[0].pagosconsumos.forEach(function (pagosconsumo) {
                    var detallePagoHTML = `
                        <div class="col-md-6">
                            <label class="form-label">${pagosconsumo.TipoPago}</label>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-end">${pagosconsumo.TotalPago}</label>
                        </div>
                    `;
                    detallePagosSection.innerHTML += detallePagoHTML;
                });
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });   
}


function GetMostrador(consumo){
   
    $.ajax({
        url: '/api/get-mostrador-consumo/'+consumo,
        type: 'GET',
        dataType: 'json',
        success: function (data) {                   
            var MostradorNuevoPedido = document.getElementById('form_tabs');
                MostradorNuevoPedido.innerHTML = `
                    <form>
                        <div class="card-header" style="background: #FF8080">
                            <div class="d-flex align-items-center" style="width: 100%">
                                <h3 class="card-title" style="color: white; margin: 0">Pedido # ${data[0].id}</h3>
                                <div class="ms-auto">
                                    <span class="badge bg-orange" data-id="${consumo}" id="ImprimirMostrador" onclick="generarPDFMostrador()" style="padding: 10px">
                                        <svg width="40px" height="20px" viewBox="0 0 24.00 24.00" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#ffffff;stroke-miterlimit:10;stroke-width:1.8719999999999999;}</style></defs><path class="cls-1" d="M17.73,17.73h2.86a1.91,1.91,0,0,0,1.91-1.91V9.14a1.92,1.92,0,0,0-1.91-1.91H3.41A1.92,1.92,0,0,0,1.5,9.14v6.68a1.91,1.91,0,0,0,1.91,1.91H6.27"></path><rect class="cls-1" x="6.27" y="14.86" width="11.45" height="7.64"></rect><rect class="cls-1" x="6.27" y="1.5" width="11.45" height="5.73"></rect><line class="cls-1" x1="4.36" y1="14.86" x2="19.64" y2="14.86"></line><line class="cls-1" x1="17.73" y1="11.05" x2="19.64" y2="11.05"></line><line class="cls-1" x1="9.14" y1="18.68" x2="14.86" y2="18.68"></line></g></svg>
                                    </span>
                                    <span class="badge bg-blue" data-id="${consumo}" id="VerImprimirMostrador" onclick="generarPDFVerMostrador()" style="padding: 14px">
                                        VerPDF
                                    </span>
                                </div>
                            </div> 
                        </div> 
                        <div class="card-body">
                            <div class="col-md-12">
                                <form class="card">
                                    <div class="card-header">
                                        <div>
                                            <p><strong style="color: red">${data[0].Comentario}</strong> </p>
                                            <p><strong>Hora De Inicio:</strong> ${data[0].fecha_venta}</p>
                                            ${data[0].cliente ? `<p><strong>Cliente:</strong> ${data[0].cliente.NombreCliente}</p>` : ''}
                                            ${data[0].camarero ? `<p><strong>Camarero:</strong> ${data[0].camarero.NombreCamarero}</p>` : ''}
                                        </div>
                                    </div>
                                    <div class="card-body">
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
                                            <div class="contenedor" id="DivFavoriteMostrador" style="width: 100%; margin: 0px; padding: 0px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="mb-3" id="DivAddProduct">
                                            
                                        </div>
                                        <button id="btnGuardar" class="btn btn-primary" style="display: none">Guardar</button>
                                    </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="mb-3" id="DivPedidos">
                                            
                                        </div>
                                        
                                        <div id="DivSubTotal" style="text-align: center">

                                        </div>
                                        <div id="DivSubTotalList">
                                            
                                        </div>
                                        <div id="DivDescuento">
                                            
                                        </div>
                                        <div id="DivTotal" style="text-align: center">
                                            <h1 style="color: #61677A">Sin Agregar Detalle al Consumo . . .</h1>
                                        </div>  
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="mb-3" id="DivBotonesFooter" style="padding: 0px;">
                                            
                                        </div>
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
                        url: '/api/get-productos-favorite',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#DivFavoriteMostrador').empty();
                            
                            var productos = Object.values(response);
                            productos.forEach(function(producto) {
                                var elementoHtml = `
                                    <div class="elemento" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <p style="display: flex; justify-content: space-between;">
                                            <span style="color: black; font-weight: bold;">${producto.PrecioProducto} Bs.</span>
                                            <span style="font-weight: bold; color: blue">${producto.stockdates[0]?.Cantidad || ''}</span>
                                        </p>
                                        <p style="display: inline; color: #3C4048;">${producto.NombreProducto}</p>
                                    </div>
                                `;
                                $('#DivFavoriteMostrador').append(elementoHtml);
                            });

                            $('#DivFavoriteMostrador').on('click', '.elemento', function() {
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

                        btnGuardar.style.display = productosSeleccionados.length >= 1 ? 'block' : 'none';
                    }

                    var btnGuardar = document.getElementById('btnGuardar');
                    $('#btnGuardar').off('click').on('click', function (event) {
                        $(this).prop('disabled', true);
                        event.preventDefault();

                        var productosParaGuardar = recuperarDatosProductos();
                        $.ajax({
                            url: '/api/registrar-detalle-consumo',
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify(productosParaGuardar),
                            success: function (response) {
                                GetMostradorAll();
                                btnGuardar.style.display = 'none';
                                MostrarMensaje("Producto Agregado", "success");
                                DivPedidos.innerHTML = '';
                                AddProduct = document.getElementById('DivAddProduct');
                                AddProduct.innerHTML = '';
                                productosSeleccionados = [];
                                agregarDetallesConsumo(consumo);
                                DivTotalConsumo(consumo);
                            },
                            error: function (error) {
                                console.error('Error:', error);
                            },
                            complete: function () {
                                $('#btnGuardar').prop('disabled', false);
                            }
                        });
                    });


                    function recuperarDatosProductos() {
                        var productosRecuperados = [];
                        productosSeleccionados.forEach(function (producto, index) {
                            var productoRecuperado = {
                                Idconsumo: consumo,
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
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });   
}

$('#ModalCerrarMostrador').on('shown.bs.modal', function () {
    $('#btnPorcentajeMostrador').off('click').on('click', DescuentoDiv);
    $('#btnCerrarMostrador').off('click').on('click', MostradorguardarCambios);
});


function MostradorguardarCambios() {
    var idConsumo = $('#IdConsumo').val();
    var btnCerrarMostrador = $('#btnCerrarMostrador');
    var id = btnCerrarMostrador.data('id');
    $.ajax({
        url: '/api/get-consumo-ocupado-mostrador/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            // Mostrar detalleconsumos en listConsumo
            document.getElementById('MostradorListPagos').innerHTML = '';
            var MostradorlistConsumo = document.getElementById('MostradorlistConsumo');
            MostradorlistConsumo.innerHTML = '';
            consumo[0].detalleconsumos.forEach(function (detalleConsumo) {
                if (detalleConsumo.eliminado === "false") {
                    var detalleConsumoItem = document.createElement('div');
                    detalleConsumoItem.innerHTML = `
                        <div class="row" style="background: #F5F7F8; border: 1px solid white">
                            <div class="col-12 col-sm-8">
                                ${detalleConsumo.cantidad} - <strong>${detalleConsumo.producto.NombreProducto}</strong>
                            </div>
                            <div class="col-12 col-sm-4" style="text-align: right">
                                <strong>${detalleConsumo.total}</strong>
                            </div>
                        </div>                
                    `;
                    MostradorlistConsumo.appendChild(detalleConsumoItem);
                }
            });

            // Mostrar descuentoconsumos en lisDescuento
            var MostradorlisDescuento = document.getElementById('MostradorlisDescuento');
            MostradorlisDescuento.innerHTML = '';
            consumo[0].descuentoconsumos.forEach(function (descuento) {
                var descuentoItem = document.createElement('div');
                var formatoDescuento = (descuento.TipoDescuento === 'porcentaje') ? `${descuento.MontoDescuento}%` : descuento.MontoDescuento;
                descuentoItem.innerHTML = `
                    <div class="row" style="background: #F5F7F8; border: 1px solid white">
                        <div class="col-12 col-sm-8">
                            Descuento ${formatoDescuento}
                        </div>
                        <div class="col-12 col-sm-4" style="text-align: right">
                            - ${descuento.TotalDescuento}
                        </div>
                    </div>
                `;
                MostradorlisDescuento.appendChild(descuentoItem);
            });

            // Mostrar total en listTotal
            var MostradorTotalDiv = document.getElementById('MostradorlistTotal');
            var totalItem = document.createElement('div');
            MostradorTotalDiv.innerHTML = '';        
            totalItem.innerHTML = `
                <div class="row">
                    <div class="col-12 col-sm-8">
                        <strong>Total a Pagar</strong>
                    </div>
                    <div class="col-12 col-sm-4" style="text-align: right">
                        <strong>${consumo[0].total}</strong>
                    </div>
                </div>                
            `;
            MostradorTotalDiv.appendChild(totalItem);
            
            $('#btnConfirmarPagoMostrador').off('click');

            $('#MostradoraddPagos').off('click').on('click', function () {
                // Crear el contenido que se va a agregar
                var nuevoPago = $('<div style="padding: 4px; margin: 4px"></div>').html(`
                    <div class="row">
                        <div class="col-sm-5">
                            <select class="form-control" id="TipoPago">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Deposito/QR">Deposito/QR</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <label for="MontoPago" style="display: inline-block; margin-right: 10px;">Bs.</label>
                            <input type="number" class="form-control montoPagoInput" id="MontoPago" style="width: 70%; display: inline-block;">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn position-relative btnEliminarPago" type="button">x</button>
                        </div>
                    </div>
                `);

                // Agregar el nuevo elemento al contenedor
                $('#MostradorListPagos').append(nuevoPago);

                // Desvincular y volver a vincular eventos específicos para este nuevo elemento
                nuevoPago.find('.btnEliminarPago').off('click').on('click', function () {
                    $(this).closest('.row').parent().remove();
                    calcularYMostrarCambio();
                });

                nuevoPago.find('.montoPagoInput').off('input').on('input', function () {
                    calcularYMostrarCambio();
                });

                calcularYMostrarCambio();
            });



            var primerPago = document.createElement('div');
            primerPago.innerHTML = `
                <div style="padding: 4px; margin: 4px">
                    <div class="row">
                        <div class="col-sm-5">
                            <select class="form-control">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Deposito/QR">Deposito/QR</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <label for="MontoPago" style="display: inline-block; margin-right: 10px;">Bs.</label>
                            <input type="number" class="form-control montoPagoInput" value="${consumo[0].total}" style="width: 70%; display: inline-block;">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn position-relative btnEliminarPago" type="button">x</button>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('MostradorListPagos').appendChild(primerPago);

            primerPago.querySelector('.montoPagoInput').addEventListener('input', function () {
                calcularYMostrarCambio();
            });

            calcularYMostrarCambio();

            function calcularYMostrarCambio() {
                var elementosPagos = document.querySelectorAll('#MostradorListPagos > div');

                var totalPagos = 0;
                elementosPagos.forEach(function (elementoPago) {
                    var montoPago = parseFloat(elementoPago.querySelector('.montoPagoInput').value) || 0;
                    totalPagos += montoPago;
                });
                var limitePago = parseFloat(consumo[0].total) || 0;
                var cambio = totalPagos - limitePago;

                var listVuelto = document.getElementById('MostradorlistVuelto');
                listVuelto.innerHTML = `
                    <p>Cambio: ${cambio.toFixed(2)}</p>
                `;
                actualizarEstadoBoton(cambio);
            }

            function actualizarEstadoBoton(cambio) {
                var btnConfirmarPagoMostrador = document.getElementById('btnConfirmarPagoMostrador');
                btnConfirmarPagoMostrador.disabled = cambio < 0;
            }

            $('#btnConfirmarPagoMostrador').off('click').on('click', function (event) {
                event.preventDefault();
                
                var elementosPagos = $('#MostradorListPagos > div');
                var pagos = [];
                var isCheckedMostrador = document.getElementById('EnviarCajaMostrador').checked;

                elementosPagos.each(function () {
                    var tipoPago = $(this).find('.form-control').val();
                    var montoPago = parseFloat($(this).find('.montoPagoInput').val()) || 0;

                    pagos.push({
                        tipo: tipoPago,
                        cantidad: montoPago
                    });
                });

                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '/api/cerrar-mostrador/' + id,
                    type: 'POST',
                    data: {
                        _token: token,
                        pagos: pagos,
                        isCheckedMostrador: isCheckedMostrador 
                    },
                    success: function (consumo) {
                        $('#ModalCerrarMostrador').modal('hide');
                        document.getElementById('MostradorListPagos').innerHTML = '';
                        document.getElementById('MostradorlistConsumo').innerHTML = '';
                        document.getElementById
                        ('MostradorlisDescuento').innerHTML = '';
                        document.getElementById('MostradorlistTotal').innerHTML = '';
                        document.getElementById('MostradorlistVuelto').innerHTML = '';
                        document.getElementById('EnviarCajaMostrador').checked = false;
                        GetMostradorAll()
                        GetMostradorAllCerrado()
                        MostrarMensaje("Pedido Cerrada Correctamente", "success");
                        CanvasTime()
                    },
                    error: function (error) {
                        MostrarMensaje("El Pedido Noce Pudo Cerrar", "error");
                    }
                });
            });

        }
    });
}

/*
function generarMostradorPDF() {
    var consumoID = document.getElementById('ImprimirMostrador').getAttribute('data-id');
    let pdfLink;
    console.log(window.location.origin + '/api/get-mostrador-comanda/' + consumoID)
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
                    xhr.open('POST', 'https://'+IpImpresor+'/imprimir/'+printerName, true);
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
*/
function generarPDFMostrador() {
    var mostradorId = document.getElementById('ImprimirMostrador').getAttribute('data-id');
    let pdfLink;
    $.ajax({
        url: window.location.origin + '/api/get-mostrador-comanda/' + mostradorId,
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
                    xhr.open('POST', 'https://'+IpImpresor+'/imprimir/'+printerName, true);
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