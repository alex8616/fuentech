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
                                <div class="mb-3 row">
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
                                <div class="mb-3 row">
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
            $.ajax({
                url: '/api/get-clientes',
                type: 'GET',
                dataType: 'json',
                success: function (clientes) {
                    $('#MSeleccionarCliente').empty();

                    $('#MSeleccionarCliente').append($('<option>', {
                        value: '',
                        text: 'Seleccione un cliente',
                        selected: true,
                    }));
                    
                    for (var i = 0; i < clientes.length; i++) {
                        var cliente = clientes[i];
                        $('#MSeleccionarCliente').append($('<option>', {
                            value: cliente.id,
                            text: cliente.NombreCliente
                        }));
                    }
                },
                error: function (error) {
                    console.error('Error al obtener clientes:', error);
                }
            });

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
                console.log("entro a total: ")
                console.log(consumo)
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

                        <button type="button" data-bs-toggle="modal" data-bs-target="#ModalCerrarMostrador" class="btn btn-danger" data-id="${IdConsumo}" id="btnCerrarMostrador">Cerrar Mesa</button>
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
            nuevoDiv.style = 'padding: 1px';

                    if(detalle.eliminado == 'true'){
                        nuevoDiv.innerHTML = `
                            <div class="col-md-12 col-lg-12">
                                <div class="card" id="CardOcupado">
                                    <div class="card-status-start bg-primary"></div>
                                    <div class="card-header">
                                        <div class="row" style="width: 100%;">
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title">${detalle.cantidad}</h3>
                                            </div>
                                            <div class="col-md-12 col-lg-7"  style="text-align: left;">
                                                <p class="card-title">${detalle.producto.NombreProducto}</p>
                                                <p style="font-size: 12px">${detalle.comentario} CANCELADO: ${detalle.comentarioeliminado}</p>
                                            </div>
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title" style="text-decoration:line-through;">${detalle.precio}</h3>                                                                    
                                            </div>
                                            <div class="col-md-12 col-lg-1" style="text-aling: right;">
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
                        nuevoDiv.innerHTML = `
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-status-start bg-primary"></div>
                                    <div class="card-header">
                                        <div class="row" style="width: 100%">
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title">${detalle.cantidad}</h3>
                                            </div>
                                            <div class="col-md-12 col-lg-7" style="text-align: left;">
                                                <p class="card-title">${detalle.producto.NombreProducto}</p>
                                                <p style="font-size: 12px">${detalle.comentario}</p>
                                            </div>
                                            <div class="col-md-12 col-lg-2">
                                                <h3 class="card-title">${detalle.precio}</h3>                                                                    
                                            </div>
                                            <div class="col-md-12 col-lg-1"  style="text-aling: right;">
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
                                </div>
                            </div>
                        `;
                    }
                    
                    DivPedidos.appendChild(nuevoDiv);
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
                console.log(data)
                var MostradorNuevoPedido = document.getElementById('form_tabs');
                    MostradorNuevoPedido.innerHTML = `
                        <form>
                            <div class="card-header" style="background: #202c3b">
                                <div class="row" style="width: 100%">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white">Pedido # ${data[0].id}</h3>
                                    </div>
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="col-md-12">
                                    <form class="card">
                                        <div class="card-header">
                                            <div>
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
                                <div class="row" style="width: 100%">
                                    <div class="col-12 col-sm-8">
                                        <h3 class="card-title" style="color: white">Pedido # ${data[0].id}</h3>
                                    </div> 
                                </div>
                            </div> 
                            <div class="card-body">
                                <div class="col-md-12">
                                    <form class="card">
                                        <div class="card-header">
                                            <div>
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
                        var productosSeleccionados = [];
                        $('#BuscarProducto').autocomplete({
                            source: productos.map(producto => producto.NombreProducto),
                            select: function (event, ui) {
                                var productoSeleccionado = productos.find(producto => producto.NombreProducto === ui.item.label);
                                productosSeleccionados.push(Object.assign({}, productoSeleccionado));
                                actualizarDivsProductos();
                                ui.item.value = '';
                                return false;
                            },
                            close: function (event, ui) {
                                $(this).val('');
                            }
                        });

                        var btnGuardar = document.getElementById('btnGuardar');
                        $('#btnGuardar').off('click').on('click', function (event) {
                            event.preventDefault();
                            var ConsumoId = data[0].id;
                            var productosParaGuardar = productosSeleccionados.map(function (producto) {
                                return {
                                    Idconsumo: data[0].id,
                                    Idproducto: producto.id,
                                    nombre: producto.NombreProducto,
                                    cantidad: producto.Cantidad || 1,
                                    precio: producto.PrecioProducto || 0,
                                    comentario: producto.Comentario || ''
                                };
                            });

                            $.ajax({
                                url: '/api/registrar-detalle-consumo-mostrador/',
                                type: 'POST',
                                contentType: 'application/json',
                                data: JSON.stringify(productosParaGuardar),
                                success: function (response) {
                                    btnGuardar.style.display = 'none';
                                    MostrarMensaje("Producto Agregado","success")
                                    DivPedidos.innerHTML = '';
                                    AddProduct = document.getElementById('DivAddProduct');
                                    AddProduct.innerHTML = '';
                                    productosSeleccionados = [];
                                    agregarDetallesConsumo(ConsumoId);
                                },
                                error: function (error) {
                                    console.error('Error:', error);
                                }
                            });
                        });


                        function actualizarDivsProductos() {
                            var AddProduct = document.getElementById('DivAddProduct');
                            AddProduct.innerHTML = ''; 

                            productosSeleccionados.forEach(function (producto, index) {
                                var nuevoDiv = document.createElement('div');
                                nuevoDiv.className = 'row producto-row';
                                nuevoDiv.style = 'padding: 1px';

                                nuevoDiv.innerHTML = `
                                    <div class="row producto" data-index="${index}" style="background: #FFCC70; padding: 10px">
                                        <div class="col-sm-3">
                                            <div class="input-group" style="width: 100%">
                                                <button class="btn btn-outline-secondary btnDecrementar" type="button" style="width: 15px">-</button>
                                                <input type="number" name="CantProduct" class="form-control CantProduct" value="${producto.Cantidad || 1}" style="padding: 0px; text-align: center;">
                                                <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <a style="font-weight: bold; font-size: 13px">${producto.NombreProducto}</a>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="number" name="PrecioProduct" class="form-control PrecioProduct" value="${producto.PrecioProducto || 1}" style="padding-right: 0px; padding-left: 0px; text-align: center;">
                                        </div>
                                        <div class="col-sm-3" style="text-align: center;">
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
                                        <div class="col-sm-12" style="text-align: center;"><br>
                                            <input type="text" name="ComentarioProduct" class="form-control ComentarioProduct" style="display: none">
                                        </div>
                                    </div>
                                `;

                                AddProduct.appendChild(nuevoDiv);

                                // Agregar controladores de eventos a los botones y elementos relevantes
                                var btnDecrementar = nuevoDiv.querySelector('.btnDecrementar');
                                var btnIncrementar = nuevoDiv.querySelector('.btnIncrementar');
                                var borrarDiv = nuevoDiv.querySelector('.borrar-div');
                                var cantProductInput = nuevoDiv.querySelector('.CantProduct');
                                var precioProductInput = nuevoDiv.querySelector('.PrecioProduct');
                                var comentarioProductInput = nuevoDiv.querySelector('.ComentarioProduct');
                                var mostrarComentarioLink = nuevoDiv.querySelector('.mostrar-comentario');

                                // Agregar controladores de eventos
                                btnDecrementar.addEventListener('click', function() {
                                    // Manejar decremento
                                    var cantidad = parseInt(cantProductInput.value, 10) || 0;
                                    if (cantidad > 0) {
                                        cantProductInput.value = cantidad - 1;
                                        producto.Cantidad = cantidad - 1; // Actualizar valor en el producto
                                    }
                                });

                                btnIncrementar.addEventListener('click', function() {
                                    // Manejar incremento
                                    var cantidad = parseInt(cantProductInput.value, 10) || 0;
                                    cantProductInput.value = cantidad + 1;
                                    producto.Cantidad = cantidad + 1; // Actualizar valor en el producto
                                });

                                borrarDiv.addEventListener('click', function() {
                                    var index = borrarDiv.getAttribute('data-index');
                                    productosSeleccionados.splice(index, 1);
                                    actualizarDivsProductos();
                                });

                                // Manejar cambios en la cantidad, precio y comentario
                                cantProductInput.addEventListener('input', function() {
                                    producto.Cantidad = cantProductInput.value;
                                });

                                precioProductInput.addEventListener('input', function() {
                                    producto.PrecioProducto = precioProductInput.value;
                                });

                                comentarioProductInput.addEventListener('input', function() {
                                    producto.Comentario = comentarioProductInput.value;
                                });

                                // Agregar evento para mostrar/comentar
                                mostrarComentarioLink.addEventListener('click', function() {
                                    // Alternar la visibilidad del input de comentario
                                    if (comentarioProductInput.style.display === 'none' || comentarioProductInput.style.display === '') {
                                        comentarioProductInput.style.display = 'block';
                                    } else {
                                        comentarioProductInput.style.display = 'none';
                                    }
                                });

                            });

                            btnGuardar.style.display = productosSeleccionados.length >= 1 ? 'block' : 'none';

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
                            pagos: pagos 
                        },
                        success: function (consumo) {
                            $('#ModalCerrarMostrador').modal('hide');
                            document.getElementById('MostradorListPagos').innerHTML = '';
                            document.getElementById('MostradorlistConsumo').innerHTML = '';
                            document.getElementById
                            ('MostradorlisDescuento').innerHTML = '';
                            document.getElementById('MostradorlistTotal').innerHTML = '';
                            document.getElementById('MostradorlistVuelto').innerHTML = '';
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