document.addEventListener('DOMContentLoaded', function() {        
    GetDeliveryPreparando()
    GetDeliveryEntregar()
    GetDeliveryEnviar()
    GetDeliveryCompleto()
});
var DeliveybtnPedidoNuevo = document.getElementById('DeliveybtnPedidoNuevo');

DeliveybtnPedidoNuevo.addEventListener('click', function () {
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
                            <label class="col-3 col-form-label required">Telefono</label>
                            <div class="col">
                                <input class="form-control" id="DeliveryTelefono">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Cliente</label>
                            <div class="col">
                                <input class="form-control" id="DeliveryCliente">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <input class="form-control" id="DeliveryClienteId" hidden>
                            <label class="col-3 col-form-label required">Direccion</label>
                            <div class="col">
                                <input class="form-control" id="DeliveryCalle" placeholder="Calle"><br>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <input class="form-control" id="DeliveryNumero" placeholder="Numero">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input class="form-control" id="DeliveryPiso" placeholder="Piso / Depto">
                                    </div><br><br><br>
                                    <div class="col-12 col-sm-12">
                                        <input class="form-control" id="DeliveryBarrio" placeholder="Barrio">
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Repartidor</label>
                            <div class="col">
                            <select class="form-select" id="DeliverySeleccionarRepartidor" name="DeliverySeleccionarRepartidor">
                                
                            </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label">Tiempo</label>
                            <div class="col">
                            <select class="form-select" id="DeliveryTiempo" name="DeliveryTiempo"> 
                                <option value=" "></option>
                                <option value="20 Minutos">20 Minutos</option>
                                <option value="30 Minutos">30 Minutos</option>
                                <option value="40 Minutos">40 Minutos</option>
                                <option value="50 Minutos">50 Minutos</option>
                                <option value="1 Hora">1 Hora</option>
                                <option value="1 Hora">1 Hora y Media</option>
                                <option value="2 Horas">2 Horas</option>
                                <option value="2 Horas">2 Horas y Media</option>
                                <option value="3 Horas">3 Horas</option>
                                <option value="6 Horas">6 Horas</option>
                                <option value="12 Horas">12 Horas</option>
                                <option value="24 Horas">24 Horas</option>
                                <option value="48 Horas">48 Horas</option>
                            </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-3 col-form-label pt-0">Costo De Envio</label>
                            <div class="col">
                            <input class="form-control" id="DeliveryCostoEnvio"><br>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-3 col-form-label pt-0">Comentario</label>
                            <div class="col">
                            <textarea class="form-control" rows="5" id="DeliveryComentario" name="DeliveryComentario"></textarea>
                            </div>
                        </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-end">
                            <div>
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" id="RegistrarCliente">
                                    <span class="form-check-label">Registrar Cliente</span>
                                </label>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" id="btnCrearDelivery">Crear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>                    
        </form>
    `;

    $(function() {
        var $deliveryClienteId = $('#DeliveryClienteId');
        var $deliveryCliente = $('#DeliveryCliente');
        var $deliveryCalle = $('#DeliveryCalle');
        var $deliveryNumero = $('#DeliveryNumero');
        var $deliveryPiso = $('#DeliveryPiso');
        var $deliveryBarrio = $('#DeliveryBarrio');
        var $checkbox = $('#RegistrarCliente');
        $('#DeliveryTelefono').autocomplete({
            minLength: 0,
            source: function(request, response) {
                $.ajax({
                    url: '/api/Search-Client',
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        if (data.length === 0) {
                            $deliveryClienteId.val('');
                            $deliveryCliente.val('');
                            $deliveryCalle.val('');
                            $deliveryNumero.val('');
                            $deliveryPiso.val('');
                            $deliveryBarrio.val('');
                        }
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $deliveryClienteId.val(ui.item.id);
                $deliveryCliente.val(ui.item.NombreCliente);
                $deliveryCalle.val(ui.item.CalleCliente);
                $deliveryNumero.val(ui.item.NumeroCliente);
                $deliveryPiso.val(ui.item.PisoCliente);
                $deliveryBarrio.val(ui.item.BarrioCliente);
                return false;
            }
        });
    });

    
    //para el select repartidor
    $.ajax({
        url: '/api/get-repartidor',
        type: 'GET',
        dataType: 'json',
        success: function (repartidores) {
            $('#DeliverySeleccionarRepartidor').empty();

            $('#DeliverySeleccionarRepartidor').append($('<option>', {
                value: '',
                text: '',
                selected: true,
            }));
            
            for (var i = 0; i < repartidores.length; i++) {
                var repartidore = repartidores[i];
                $('#DeliverySeleccionarRepartidor').append($('<option>', {
                    value: repartidore.id,
                    text: repartidore.NombreRepartidor
                }));
            }
        },
        error: function (error) {
            console.error('Error al obtener clientes:', error);
        }
    });
    
    $('#btnCrearDelivery').off('click').on('click', function(event) {
        event.preventDefault();
        //var MClienteID = $("#MSeleccionarCliente").val();
        var ClienteID = $("#DeliveryClienteId").val();
        var ClienteTelefono = $("#DeliveryTelefono").val();
        var ClienteNombre = $("#DeliveryCliente").val();
        var ClienteCalle = $("#DeliveryCalle").val();
        var ClienteNumero = $("#DeliveryNumero").val();
        var ClientePiso = $("#DeliveryPiso").val();
        var ClienteBarrio = $("#DeliveryBarrio").val();

        var SelectRepartidor = $("#DeliverySeleccionarRepartidor").val();
        var SelectTiempo = $("#DeliveryTiempo").val();
        var DeliveryCosto = $("#DeliveryCostoEnvio").val();
        var DeliveryComentario = $("#DeliveryComentario").val();

        var RegistrarCliente = $("#RegistrarCliente").prop("checked");

        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/api/registrar-consumo-delivery',
            type: 'POST',
            data: {
                _token: token,
                ClienteID: ClienteID,
                ClienteTelefono: ClienteTelefono,
                ClienteNombre: ClienteNombre,
                ClienteCalle: ClienteCalle,
                ClienteNumero: ClienteNumero,
                ClientePiso: ClientePiso,
                ClienteBarrio: ClienteBarrio,
                SelectRepartidor: SelectRepartidor,
                SelectTiempo: SelectTiempo,
                DeliveryCosto: DeliveryCosto,
                DeliveryComentario: DeliveryComentario,
                RegistrarCliente: RegistrarCliente,
            },
            success: function(consumo) {
                GetDeliveryPreparando()
                GetConsumoDelivery(consumo.id)
                productosSeleccionados = [];
                agregarDetallesConsumoDelivery(consumo.id);
                DivTotalConsumoDelivery(consumo.id);
                MostrarMensaje("Producto Agregado", "success");
            },
            
            error: function(error) {
                MostrarMensaje("La Mesa Noce Pudo Ocupar","error");
            }
        });
    });
});

function DivTotalConsumoDelivery(ConsumoId) {
    function DescuentoDiv() {
        var btn = document.getElementById('btnPorcentajeDelivery');
        var id = btn.getAttribute('data-id');
        // Haz lo que necesites con el id
        var DivDescuentoDelivery = document.getElementById('DivPreparandoDeliveryDescuento');
        DivDescuentoDelivery.innerHTML = 
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
            DivDescuentoDelivery.innerHTML = '';
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
                    DivDescuentoDelivery.innerHTML = '';
                    ListarDescuentosDelivery(response.consumo_id)
                    MostrarMensaje('Descuento Registrado Correctamente','success');
                    //actualiza total
                    $.ajax({
                        url: '/api/get-delivery-consumo/' + ConsumoId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (consumo) {
                            var SubTotalProduct = document.getElementById('DivPreparandoDeliverySubTotal');
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
                            var TotalProduct = document.getElementById('DivPreparandoDeliveryTotal');
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

    $.ajax({
        url: '/api/get-delivery-consumo/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            var SubTotalProduct = document.getElementById('DivPreparandoDeliverySubTotal');
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

            var TotalProduct = document.getElementById('DivPreparandoDeliveryTotal');
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

            var PagoProduct = document.getElementById('DivPagoTotalDelivery');
            PagoProduct.innerHTML = `
                <div>
                    <div class="col-sm-6">
                        <div class="input-group" style="width: 100%"></div>
                    </div>
            
                    <div class="row" style="background: #243A73; padding: 5px;">
                        <div class="col-sm-7">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 20px; color: white">PAGAR CON</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <button class="btn position-relative btnAddPagoDelivery" type="button" onclick="agregarDivPago()">Add</button>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="padding: 10px">
                    <div class="col-sm-12">
                    <button class="btn position-relative btnGuardarPagoDelivery" type="button" style="background: #90D26D; display: none" data-idpago="${ConsumoId}" id="btnGuardarPago" onclick="enviarPagos(this)">Guardar</button>
                    </div>
                </div>
            `;

            
            var DivBotones = document.getElementById('DivBotonesFooter');
            DivBotones.innerHTML = `
                <div class="col-md-6 col-lg-12 d-flex justify-content-between">

                    <button type="button" class="btn btn-primary" id="btnPorcentajeDelivery" data-id="${IdConsumo}" style="text-align: center; padding: 0px; margin: 0px; padding-left: 6px; padding-right: 6px">
                        <span style="font-size: 20px; font-weight: bold;">%</span>
                    </button>.
                    <button type="button" class="btn btn-danger" data-id="${IdConsumo}" id="btnDeliverySiguiente" onclick="CambiarEstadoEntregar(this)" style="background: #3652AD">Listo Para Entregar</button>
                </div>
            `;

            listarpagos(ConsumoId)
            document.getElementById('btnPorcentajeDelivery').onclick = DescuentoDiv;

        },
        error: function (error) {
            console.error('Error:', error);
        }
    });       

}

function agregarDetallesConsumoDelivery(ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-consumo/'+ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            DivagregarDetallesConsumoDelivery(consumo[0].detalleconsumos, ConsumoId);
            DivTotalConsumoDelivery(consumo[0].id);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function DivagregarDetallesConsumoDelivery(detalleconsumos, ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-consumo/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
        var DivPedidosDelivery = document.getElementById('DivPreparandoDelivery');
        DivPedidosDelivery.innerHTML = '';

        detalleconsumos.forEach(function (detalle, index) {
            var nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'row producto-row';
            nuevoDiv.style = 'padding: 1px';

                if(detalleconsumos.length > 0){
                    document.getElementById('DivPagoTotalDelivery').style.display = 'block';
                    document.getElementById('DivBotonesFooter').style.display = 'block';
                }else{
                    document.getElementById('DivPagoTotalDelivery').style.display = 'none';
                    document.getElementById('DivBotonesFooter').style.display = 'none';
                }

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
                                                <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                <p style="font-size: 12px;">
                                                    ${detalle.comentario} 
                                                    <a id="AddModificador" style="color: blue" data-bs-toggle="modal" data-bs-target="#ModalAddModificador" data-IdModificador="${IdMod}" data-IdDetalle="${detalle.id}">Add</a>
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
                                                        <span class="badge badge-outline text-green" data-bs-toggle="modal" data-bs-target="#ModalEditarModificador" data-IdEditModif="${modificador.id}" style="padding: 0px; padding-top: 5px; height: 21px; width: 100%;">E</span>
                                                    </div>
                                                    <div class="col-md-12 col-lg-1" style="margin: 0px; padding: 0px">
                                                        <span class="badge badge-outline text-red" data-bs-toggle="modal" data-bs-target="#ModalEliminarModificador" data-IdEliminarModif="${modificador.id}" style="padding: 0px; padding-top: 5px; height: 21px; width: 100%;">X</span>
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
                        var editButton = nuevoDiv.querySelector(`[data-IdEditModif="${modificador.id}"]`);
                        if (editButton) {
                            editButton.addEventListener('click', function() {
                                var modalBody = document.querySelector('#ModalEditarModificador .modal-body');
                                modalBody.innerHTML = '';
                        
                                var cantidad = modificador.cantidad;
                                var precio = modificador.precio;
                        
                                function calcularTotal() {
                                    var cantidadInput = document.getElementById('EditCantidad');
                                    var totalInput = document.getElementById('EditTotal');
                                    var nuevaCantidad = parseInt(cantidadInput.value);
                                    var nuevoTotal = nuevaCantidad * precio;
                                    totalInput.value = nuevoTotal;
                                }
                        
                                var productoHtml = `
                                    <div class="row row-cards">
                                        <div class="col-sm-6 col-md-3">
                                            <input type="text" class="form-control" id="EditId" value="${modificador.id}" hidden>
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
                                                <input type="text" class="form-control" id="EditCantidad" value="${cantidad}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label">Total</label>
                                                <input type="text" class="form-control" id="EditTotal" value="${cantidad * precio}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                modalBody.insertAdjacentHTML('beforeend', productoHtml);
                                calcularTotal();
                                var cantidadInput = document.getElementById('EditCantidad');
                                cantidadInput.addEventListener('input', calcularTotal);
                        
                            });
                        }
                    });

                    detalle.modificadordetalleconsumo.forEach(modificador => {
                        var eliminarButton = nuevoDiv.querySelector(`[data-IdEliminarModif="${modificador.id}"]`);
                        if (eliminarButton) {
                            eliminarButton.addEventListener('click', function() {
                                var modalBody = document.querySelector('#ModalEliminarModificador .modal-body');
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
                DivPedidosDelivery.appendChild(nuevoDiv);
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

function GetDeliveryPreparando() {
    $.ajax({
        url: '/api/get-delivery-preparacion',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log("Datos Preparando traigos de DB")
            console.log(data)
            $('#DeliveyPreparacion tbody').empty();

            $.each(data, function (index, consumo) {
                var row = `<tr>
                            <td>${consumo.id}</td>
                            <td>${consumo.fecha_venta}</td>
                            <td>
                                ${consumo.cliente 
                                    ? `${consumo.cliente.CalleCliente} ${consumo.cliente.NumeroCliente} ${consumo.cliente.PisoCliente} ${consumo.cliente.BarrioCliente}` 
                                    : `${consumo.clientetemporal.CalleCliente} ${consumo.clientetemporal.NumeroCliente} ${consumo.clientetemporal.PisoCliente} ${consumo.clientetemporal.BarrioCliente}`
                                }
                            </td>
                            <td>
                                ${consumo.cliente 
                                    ? consumo.cliente.TelefonoCliente 
                                    : consumo.clientetemporal.TelefonoCliente 
                                }
                            </td>
                            <td>
                                ${consumo.cliente 
                                    ? consumo.cliente.NombreCliente 
                                    : consumo.clientetemporal.NombreCliente 
                                }
                            </td>
                            <td>${consumo.repartidor_id}</td>
                            <td>${consumo.TipoConsumo}</td>
                            <td>${consumo.total}</td>
                            <td>
                            <button style="background: #3652AD; color: white; border: white 1px solid white" hidden>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-big-right-lines" style="width: 24px; height: 24px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v-3.586a1 1 0 0 1 1.707 -.707l6.586 6.586a1 1 0 0 1 0 1.414l-6.586 6.586a1 1 0 0 1 -1.707 -.707v-3.586h-3v-6h3z" /><path d="M3 9v6" /><path d="M6 9v6" /></svg>
                            </button>

                            </td>
                        </tr>`;
                $('#DeliveyPreparacion tbody').append(row);
            });

            var id;

            $('#DeliveyPreparacion').off('click').on('click', 'tbody tr', function (event) {
                event.preventDefault(); 
                $('#DeliveyPreparacion tbody tr').not(this).removeClass('selected');
                $(this).toggleClass('selected');
                if ($(this).hasClass('selected')) {
                    id = $(this).find('td:first').text();
                    GetConsumoDelivery(id);
                    agregarDetallesConsumoDelivery(id);
                    DivTotalConsumoDelivery(id);
                    ListarDescuentosDelivery(id);
                    listarpagos(id)
                }
            });
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });
}

function GetConsumoDelivery(consumo){
    var productosSeleccionados = [];

    $.ajax({
        url: '/api/get-delivery-consumo/'+consumo,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var MostradorNuevoPedido = document.getElementById('form_tabs');
                MostradorNuevoPedido.innerHTML = `
                    <form>
                        <div class="card-header" style="background: #cd7318">
                            <div class="row" style="width: 100%">
                                <div class="d-flex align-items-center" style="width: 100%">
                                    <h3 class="card-title" style="color: white">Pedido # ${data[0].id}</h3>
                                    <div class="ms-auto">
                                        <span class="badge bg-azure" data-id="${data[0].id}" id="ImprimirDelivery" onclick="generarPDFDelivery()" style="padding: 10px">
                                            <svg width="40px" height="20px" viewBox="0 0 24.00 24.00" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#ffffff;stroke-miterlimit:10;stroke-width:1.8719999999999999;}</style></defs><path class="cls-1" d="M17.73,17.73h2.86a1.91,1.91,0,0,0,1.91-1.91V9.14a1.92,1.92,0,0,0-1.91-1.91H3.41A1.92,1.92,0,0,0,1.5,9.14v6.68a1.91,1.91,0,0,0,1.91,1.91H6.27"></path><rect class="cls-1" x="6.27" y="14.86" width="11.45" height="7.64"></rect><rect class="cls-1" x="6.27" y="1.5" width="11.45" height="5.73"></rect><line class="cls-1" x1="4.36" y1="14.86" x2="19.64" y2="14.86"></line><line class="cls-1" x1="17.73" y1="11.05" x2="19.64" y2="11.05"></line><line class="cls-1" x1="9.14" y1="18.68" x2="14.86" y2="18.68"></line></g></svg>
                                        </span>
                                        <span class="badge bg-blue" data-id="${data[0].id}" id="VerImprimirDelivery" onclick="generarPDFverDelivery()" style="padding: 14px">
                                            VerPDF
                                        </span>
                                    </div>
                                </div> 
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="col-md-12">
                                <form class="card">
                                    <div class="card-header">
                                        <div>
                                            <p><strong>Hora De Inicio:</strong> ${data[0].fecha_venta}</p>
                                            <p><strong>Cliente:</strong> ${data[0].cliente ? data[0].cliente.NombreCliente : data[0].clientetemporal.NombreCliente}</p>
                                            <p><strong>Telefono:</strong> ${data[0].cliente ? data[0].cliente.TelefonoCliente : data[0].clientetemporal.TelefonoCliente}</p>
                                            <p><strong>Direccion:</strong> ${data[0].cliente ? `${data[0].cliente.BarrioCliente} - ${data[0].cliente.CalleCliente} - ${data[0].cliente.NumeroCliente}` : `${data[0].clientetemporal.BarrioCliente} - ${data[0].clientetemporal.CalleCliente} - ${data[0].clientetemporal.NumeroCliente}`}</p>
                                            <p><strong>Tiempo Estimado:</strong> ${data[0].DeliveryTiempo}</p>
                                            <p><strong>Comentario:</strong> ${data[0].DeliveryComentario}</p>
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
                                        <div class="contenedor" id="DivFavoriteDelivery" style="width: 100%; margin: 0px; padding: 0px;">
                                                
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="mb-3" id="DivAddProduct">
                                            
                                        </div>
                                        <button id="btnGuardar" class="btn btn-primary" style="display: none">Guardar</button>
                                    </div>
                                    </div>
                                    <div class="card-footer text-end">                                            
                                        <div class="mb-3" id="DivPreparandoDelivery">
                                            
                                        </div>

                                        <div class="row" id="DivDeliveryCosto" style="background: #F0F0F0; padding: 6px; border: 2px solid white">
                                            <div class="col-sm-6">
                                                <div class="input-group" style="width: 100%">
                                                    <span style="font-size: 16px; color: #3D3B40">Costo De Envio</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-5" style="text-align: right">
                                                <span style="font-size: 16px; color: #3D3B40">${data[0].DeliveryCosto} Bs.</span>
                                            </div>
                                            <div class="col-sm-1" style="text-align: right">
                                                <button type="button" class="badge bg-green btnCostoEnvio" data-descuento-id="${data[0].id}">E</button>
                                            </div>
                                        </div>
                                        <div id="DivPreparandoDeliverySubTotal" style="text-align: center">

                                        </div>
                                        <div id="DivDeliverySubTotalList">
                                            
                                        </div>
                                        <div id="DivPreparandoDeliveryDescuento">
                                            
                                        </div>                                            
                                        <div id="DivPreparandoDeliveryTotal" style="text-align: center">
                                            <h1 style="color: #61677A">Sin Agregar Detalle al Consumo . . .</h1>
                                        </div>
                                        <div id="DivPagoTotalDelivery" style="display: none">
                                            
                                        </div>
                                        <div id="DivListPagoTotalDelivery" style="padding: 0px; margin: 0px">
                                            
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="mb-3" id="DivBotonesFooter" style="padding: 0px; display: none">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                  
                    </form>
                `;


                
                document.body.addEventListener('click', function(event) {
                    if (event.target.classList.contains('btnCostoEnvio')) {
                        var button = event.target;
                        var descuentoId = button.getAttribute('data-descuento-id');
                        var parentDiv = button.closest('.row');
                        var spanCosto = parentDiv.querySelector('div.col-sm-5 span');
                        
                        if (spanCosto) {
                            var currentCosto = parseFloat(spanCosto.textContent.replace(' Bs.', ''));
                            var inputCosto = document.createElement('input');
                            inputCosto.type = 'text';
                            inputCosto.value = currentCosto;
                            inputCosto.className = 'form-control';
                            inputCosto.style = 'font-size: 16px; color: #3D3B40; text-align: right; width: 100%;';
                            parentDiv.querySelector('div.col-sm-5').replaceChild(inputCosto, spanCosto);
                            button.textContent = 'G';
                            button.classList.remove('btnCostoEnvio');
                            button.classList.add('btnGuardarCostoEnvio');
                            button.addEventListener('click', function() {
                                var nuevoCosto = parseFloat(inputCosto.value);
                                if (isNaN(nuevoCosto)) {
                                    alert('Ingrese un valor válido');
                                    return;
                                }
                                var newSpanCosto = document.createElement('span');
                                newSpanCosto.style = 'font-size: 16px; color: #3D3B40;';
                                newSpanCosto.textContent = nuevoCosto.toFixed(2) + ' Bs.';
            
                                var colSm5Div = parentDiv.querySelector('div.col-sm-5');
                                if (colSm5Div.contains(inputCosto)) {
                                    colSm5Div.replaceChild(newSpanCosto, inputCosto);
                                }
                                button.textContent = 'E';
                                button.classList.remove('btnGuardarCostoEnvio');
                                button.classList.add('btnCostoEnvio');
                                $.ajax({
                                    url: '/api/guardar-costo-envio/' + descuentoId,
                                    type: 'POST',
                                    data: { nuevoCosto: nuevoCosto },
                                    success: function(response) {
                                        GetConsumoDelivery(descuentoId);
                                        agregarDetallesConsumoDelivery(descuentoId);
                                        DivTotalConsumoDelivery(descuentoId);
                                        ListarDescuentosDelivery(descuentoId);
                                        MostrarMensaje("Costo De Envio Actualizado", "success");
                                    },
                                    error: function(error) {
                                        MostrarMensaje("Error al actualizar el costo de envío", "error");
                                    }
                                });
                            }, { once: true });
                        }
                    }
                });

                
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
                                $('#DivFavoriteDelivery').empty();
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
                                    $('#DivFavoriteDelivery').append(elementoHtml);
                                });
    
                                $('#DivFavoriteDelivery').on('click', '.elemento', function() {
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
    
                        $('#BuscarProducto').autocomplete({
                            source: productos.map(producto => ({
                                label: `${producto.CodigoProducto} - ${producto.NombreProducto}`,
                                value: producto.NombreProducto,
                                codigo: producto.CodigoProducto,
                                modificadore: producto.modificadore
                            })),
                            
                            select: function (event, ui) {
                                var productoSeleccionado = productos.find(producto => producto.NombreProducto === ui.item.value);
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
                                                    <input type="text" name="CantProduct" class="form-control CantProduct" value="${productoModificador.Cantidad || 1}" style="padding: 0px; text-align: center;" id="DivModificadorCantidadDelivery${index}-${indexDetalle}">
                                                    <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                                                </div>
                                            </div>
                                            <div style="padding-left: 9px; padding-right: 9px; width: 35%;" id="divdate2">
                                                <a style="font-weight: bold; font-size: 13px; word-wrap: break-word;">${productoModificador.NombreProducto}</a>
                                            </div>
                                            <div style="width: 20%;" id="divdate3">
                                                <input type="number" class="form-control PrecioProduct" value="${detalle.CostoDetalleModificador || 1}" style="padding-right: 0px; padding-left: 0px; text-align: center; width: 55px" id="DivModificadorCostoDelivery${index}-${indexDetalle}">
                                            </div>
                                            <div style="text-align: center; padding: 8px; margin: 0px;" id="divdate4">
                                                <input class="form-check" type="checkbox" style="width: 20px; height: 20px" id="ModificadorCheckDelivery${index}-${indexDetalle}" checked>
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
                                    btnGuardar.style.display = 'none';
                                    AddProduct = document.getElementById('DivAddProduct');
                                    AddProduct.innerHTML = '';
                                    productosSeleccionados = [];
                                    agregarDetallesConsumoDelivery(consumo);
                                    DivTotalConsumoDelivery(consumo);
                                    MostrarMensaje("Producto Agregado", "success");
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
                                        var cantidadInputId = `DivModificadorCantidadDelivery${index}-${indexDetalle}`;
                                        var costoInputId = `DivModificadorCostoDelivery${index}-${indexDetalle}`;
                                        var checkboxId = `ModificadorCheckDelivery${index}-${indexDetalle}`;
                        
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

function ListarDescuentosDelivery(id) {
    $.ajax({
        url: '/api/get-descuento/' + id,
        type: 'get',
        success: function (response) {
            var DivDescuentoDelivery = document.getElementById('DivDeliverySubTotalList');

            DivDescuentoDelivery.innerHTML = '';
            response.forEach(function (descuento) {
                var nuevoDescuentoDiv = document.createElement('div');
                nuevoDescuentoDiv.className = 'row';
                nuevoDescuentoDiv.style.background = '#F0F0F0';
                nuevoDescuentoDiv.style.padding = '6px';
                nuevoDescuentoDiv.style.border = '2px solid white';

                var tipoDescuentoText = descuento.TipoDescuento === 'porcentaje' ?
                    `Descuento de ${descuento.MontoDescuento} %` :
                    `Descuento de ${descuento.TipoDescuento}`;

                    nuevoDescuentoDiv.innerHTML = `
                        <div class="col-sm-6">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 16px; color: #3D3B40">${tipoDescuentoText}</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <span style="font-size: 16px; color: #3D3B40">${descuento.TotalDescuento} Bs.</span>
                        </div>
                        <div class="col-sm-1" style="text-align: right">
                            <button type="button" class="badge bg-red btnDeleteDescuento" data-descuento-id="${descuento.id}">x</button>
                        </div>
                    `;
                    DivDescuentoDelivery.appendChild(nuevoDescuentoDiv);                    

                var btnDeleteDescuento = nuevoDescuentoDiv.querySelector('.btnDeleteDescuento');
                btnDeleteDescuento.addEventListener('click', function () {
                    var descuentoId = btnDeleteDescuento.getAttribute('data-descuento-id');
                    $.ajax({
                        url: '/api/eliminar-descuento/' + descuentoId,
                        type: 'DELETE',
                        success: function (response) {
                            DivDescuentoDelivery.innerHTML = '';
                            ListarDescuentosDelivery(response.id)
                            MostrarMensaje('Descuento Eliminado Correctamente','success');
                            //actualiza total
                            $.ajax({
                                url: '/api/get-delivery-consumo/' + response.id,
                                type: 'GET',
                                dataType: 'json',
                                success: function (consumo) {                               
                                    var SubTotalProduct = document.getElementById('DivPreparandoDeliverySubTotal');
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
                                    var TotalProduct = document.getElementById('DivPreparandoDeliveryTotal');
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
                                    console.error('Error:', error);
                                }
                            });
                        },
                        error: function (error) {
                            MostrarMensaje(error,'error');
                        }
                    });
                });

            });
        },
        error: function (error) {
            MostrarMensaje(error,'error');
        }
    });
}

function agregarDivPago() {
    var pagoDiv = document.createElement('div');
    pagoDiv.className = 'row div-pago';
    pagoDiv.style.background = '#F0F0F0';
    pagoDiv.style.padding = '10px';
    pagoDiv.innerHTML = `
        <div class="col-sm-5">
            <select class="form-control tipoPago">
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Deposito/QR">Deposito/QR</option>
            </select>
        </div>
        <div class="col-sm-5">
            <label for="MontoPago" style="display: inline-block; margin-right: 10px;">Bs.</label>
            <input type="number" class="form-control montoPagoInput" style="width: 70%; display: inline-block;">
        </div>
        <div class="col-sm-2">
            <button class="btn position-relative btnEliminarPagoDelivery" type="button" onclick="eliminarDivPago(this)">x</button>
        </div>
    `;
    var lastChild = document.getElementById('DivPagoTotalDelivery').lastElementChild;
    document.getElementById('DivPagoTotalDelivery').insertBefore(pagoDiv, lastChild);
    mostrarBotonGuardar();
}

function listarpagos(ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-pago/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var pagos = response.pagos;
            var PagosTotal = response.total;
            var ConsumoTotal = response.consumo.total;
            var TotalGeneral = parseFloat(PagosTotal - ConsumoTotal).toFixed(2);

            var divListPagoTotalDelivery = document.getElementById('DivListPagoTotalDelivery');
            divListPagoTotalDelivery.innerHTML = '';

            pagos.forEach(function(pago) {
                var pagoDiv = document.createElement('div');
                pagoDiv.className = 'row';
                pagoDiv.style.padding = '10px';
                pagoDiv.style.background = '#F0F0F0';
                pagoDiv.style.marginBottom = '2px';

                pagoDiv.innerHTML = `
                    <div class="col-sm-3" style="text-align: left">
                        <span><strong>${pago.TipoPago}</strong></span>
                    </div>
                    <div class="col-sm-8">
                        <span>${parseFloat(pago.TotalPago).toFixed(2)}</span>
                    </div>
                    <div class="col-sm-1" style="text-align: right">
                        <button type="button" class="badge bg-red btnDeletePago" data-pago-id="${pago.id}">x</button>
                    </div>
                `;

                divListPagoTotalDelivery.appendChild(pagoDiv);
            });

            var totalDiv = document.createElement('div');
            totalDiv.className = 'row';
            totalDiv.style.background = '#243A73';
            totalDiv.style.marginTop = '10px';

            totalDiv.innerHTML = `
            <div class="row">
                <div class="col-sm-3" style="text-align: left;">
                    <span><strong style="font-size: 20px; color: white">Vuelto</strong></span>
                </div>
                <div class="col-sm-9">
                    <span><strong style="font-size: 20px; color: white; text-align: left;">${TotalGeneral}</strong></span>
                </div>
            </div>
            `;

            divListPagoTotalDelivery.appendChild(totalDiv);

            var btnDeliverySiguiente = document.getElementById('btnDeliverySiguiente');
            if (btnDeliverySiguiente) {
                if (ConsumoTotal > PagosTotal) {
                    btnDeliverySiguiente.style.display = 'none';
                } else {
                    btnDeliverySiguiente.style.display = 'block';
                }
            } else {
                console.error("El botón btnDeliverySiguiente no se encontró en el DOM.");
            }
            
            // Agregar controlador de eventos para eliminar pago
            var deleteButtons = document.getElementsByClassName('btnDeletePago');
            for (var i = 0; i < deleteButtons.length; i++) {
                deleteButtons[i].addEventListener('click', function() {
                    var pagoId = this.getAttribute('data-pago-id');
                    deletePago(pagoId, ConsumoId);
                });
            }
        },
        error: function (error) {
            console.error('Error al obtener pagos:', error);
        }
    });
}

function deletePago(pagoId, ConsumoId) {
    $.ajax({
        url: '/api/delete-pago/' + pagoId,
        type: 'DELETE',
        success: function(response) {
            listarpagos(ConsumoId);
            MostrarMensaje('Eliminado Correctamente','success');
        },
        error: function (error) {
            console.error('Error al eliminar pago:', error);
        }
    });
}

function eliminarDivPago(button) {
    var divPagoTotalDelivery = document.getElementById('DivPagoTotalDelivery');
    var divsPago = divPagoTotalDelivery.getElementsByClassName('div-pago');
    if (divsPago.length > 0) {
        button.parentNode.parentNode.remove();
    }
    mostrarBotonGuardar();
}

function mostrarBotonGuardar() {
    var divPagoTotalDelivery = document.getElementById('DivPagoTotalDelivery');
    var divsPago = divPagoTotalDelivery.getElementsByClassName('div-pago');
    var btnGuardarPago = document.getElementById('btnGuardarPago');
    if (divsPago.length >= 1) {
        btnGuardarPago.style.display = 'block';
    } else {
        btnGuardarPago.style.display = 'none';
    }
}

function enviarPagos(button) {
    var consumoId = button.getAttribute('data-idpago'); // Obtener el data-idpago del botón
    var divPagoTotalDelivery = document.getElementById('DivPagoTotalDelivery');
    var divsPago = divPagoTotalDelivery.getElementsByClassName('div-pago');
    var pagos = [];

    for (var i = 0; i < divsPago.length; i++) {
        var tipoPago = divsPago[i].querySelector('.tipoPago').value;
        var montoPago = divsPago[i].querySelector('.montoPagoInput').value;
        pagos.push({
            tipo: tipoPago,
            monto: montoPago
        });
    }

    var data = {
        consumoId: consumoId,
        pagos: pagos
    };

    $.ajax({
        url: '/api/guardar-pagos-delivery',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            MostrarMensaje("Registro Exitoso", "success");
            while (divsPago.length > 0) {
                divPagoTotalDelivery.removeChild(divsPago[0]);
            }
            mostrarBotonGuardar();
            listarpagos(response.id);
        },
        error: function(xhr, status, error) {
            MostrarMensaje('Error al enviar los pagos', "error");
        }
    });
}

function CambiarEstadoEntregar(button) {
    var consumoId = button.getAttribute('data-id');
    $.ajax({
        url: '/api/estado-entregar/' + consumoId,
        method: 'GET',
        contentType: 'application/json',
        success: function(response) {
            GetDeliveryPreparando()
            GetDeliveryEntregar()
            GetDeliveryEnviar()
            MostrarMensaje("Estado Cambiado Exitosamente", "success");
        },
        error: function(xhr, status, error) {
            MostrarMensaje('Error al enviar el cambio de estado', "error");
        }
    });
}

///para la lista de Entregar function
function GetDeliveryEntregar() {
    $.ajax({
        url: '/api/get-delivery-entregar',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log("Datos Entregar traigos de DB")
            console.log(data)
            $('#DeliveyListoEntregado tbody').empty();
            $.each(data, function (index, consumo) {
                var row = `<tr>
                            <td>${consumo.id}</td>
                            <td>${consumo.fecha_venta}</td>
                            <td>
                                ${consumo.cliente 
                                    ? `${consumo.cliente.CalleCliente} ${consumo.cliente.NumeroCliente} ${consumo.cliente.PisoCliente} ${consumo.cliente.BarrioCliente}` 
                                    : `${consumo.clientetemporal.CalleCliente} ${consumo.clientetemporal.NumeroCliente} ${consumo.clientetemporal.PisoCliente} ${consumo.clientetemporal.BarrioCliente}`
                                }
                            </td>
                            <td>
                                ${consumo.cliente 
                                    ? consumo.cliente.TelefonoCliente 
                                    : consumo.clientetemporal.TelefonoCliente 
                                }
                            </td>
                            <td>
                                ${consumo.cliente 
                                    ? consumo.cliente.NombreCliente 
                                    : consumo.clientetemporal.NombreCliente 
                                }
                            </td>
                            <td>${consumo.repartidor_id}</td>
                            <td>${consumo.total}</td>
                        </tr>`;
                $('#DeliveyListoEntregado tbody').append(row);

                $('#DeliveyListoEntregado').off('click').on('click', 'tbody tr', function (event) {
                    event.preventDefault(); 
                    $('#DeliveyListoEntregado tbody tr').not(this).removeClass('selected');
                    $(this).toggleClass('selected');
                    if ($(this).hasClass('selected')) {
                        id = $(this).find('td:first').text();
                        GetConsumoDeliveryEntregar(id);
                        agregarDetallesConsumoDeliveryEntregar(id);
                        ListarDescuentosDeliveryEntregar(id);
                        /*
                        DivTotalConsumoDelivery(id);
                        listarpagosEntregar(id)*/
                    }
                });
            });
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });
}

function GetConsumoDeliveryEntregar(consumo){
    $.ajax({
        url: '/api/get-delivery-consumo/'+consumo,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var MostradorNuevoPedido = document.getElementById('form_tabs');
                MostradorNuevoPedido.innerHTML = `
                    <form>
                        <div class="card-header" style="background: #3652AD">
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
                                            <p><strong>Cliente:</strong> ${data[0].cliente ? data[0].cliente.NombreCliente : data[0].clientetemporal.NombreCliente}</p>
                                            <p><strong>Telefono:</strong> ${data[0].cliente ? data[0].cliente.TelefonoCliente : data[0].clientetemporal.TelefonoCliente}</p>
                                            <p><strong>Direccion:</strong> ${data[0].cliente ? `${data[0].cliente.BarrioCliente} - ${data[0].cliente.CalleCliente} - ${data[0].cliente.NumeroCliente}` : `${data[0].clientetemporal.BarrioCliente} - ${data[0].clientetemporal.CalleCliente} - ${data[0].clientetemporal.NumeroCliente}`}</p>
                                            <p><strong>Tiempo Estimado:</strong> ${data[0].DeliveryTiempo}</p>
                                            <p><strong>Comentario:</strong> ${data[0].DeliveryComentario}</p>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">                                            
                                        <div class="mb-3" id="DivPreparandoDeliveryEntregar">
                                            
                                        </div>

                                        <div class="row" id="DivDeliveryCosto" style="background: #F0F0F0; padding: 6px; border: 2px solid white">
                                            <div class="col-sm-6">
                                                <div class="input-group" style="width: 100%">
                                                    <span style="font-size: 16px; color: #3D3B40">Costo De Envio</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6" style="text-align: right">
                                                <span style="font-size: 16px; color: #3D3B40">${data[0].DeliveryCosto} Bs.</span>
                                            </div>
                                        </div>
                                        <div id="DivPreparandoDeliverySubTotalEntregar" style="text-align: center">

                                        </div>
                                        <div id="DivDeliverySubTotalListEntregar">
                                            
                                        </div>
                                        <div id="DivPreparandoDeliveryDescuento">
                                            
                                        </div>                                            
                                        <div id="DivPreparandoDeliveryTotalEntregar" style="text-align: center">
                                            <h1 style="color: #61677A">Sin Agregar Detalle al Consumo . . .</h1>
                                        </div>
                                        <div id="DivPagoTotalDeliveryEntregar" style="display: none">
                                            
                                        </div>
                                        <div id="DivListPagoTotalDeliveryEntregar" style="padding: 0px; margin: 0px">
                                            
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="mb-3" id="DivBotonesFooterEntregar">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                  
                    </form>
                `;
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });   
}

function agregarDetallesConsumoDeliveryEntregar(ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-consumo/'+ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            DivagregarDetallesConsumoDeliveryEntregar(consumo[0].detalleconsumos, ConsumoId);
            DivTotalConsumoDeliveryEntregar(consumo[0].id);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function DivagregarDetallesConsumoDeliveryEntregar(detalleconsumos, ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-consumo/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
        var DivPedidosDelivery = document.getElementById('DivPreparandoDeliveryEntregar');
        DivPedidosDelivery.innerHTML = '';

        detalleconsumos.forEach(function (detalle, index) {
            var nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'row producto-row';
            nuevoDiv.style = 'padding: 1px';

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
                                                <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                <p style="font-size: 12px;">
                                                    ${detalle.comentario} 
                                                    <a id="AddModificador" style="color: blue" data-bs-toggle="modal" data-bs-target="#ModalAddModificador" data-IdModificador="${IdMod}" data-IdDetalle="${detalle.id}">Add</a>
                                                </p>
                                            </div>
                                            <div class="col-md-12 col-lg-3" style="width: 50%;">
                                                <h3 class="card-title">${detalle.total}</h3>                                                                    
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
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>                                                        
                                </div>
                            </div>
                        `;
                    }
                }
                DivPedidosDelivery.appendChild(nuevoDiv);
            });
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function DivTotalConsumoDeliveryEntregar(ConsumoId) {

    $.ajax({
        url: '/api/get-delivery-consumo/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            var SubTotalProduct = document.getElementById('DivPreparandoDeliverySubTotalEntregar');
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

            var TotalProduct = document.getElementById('DivPreparandoDeliveryTotalEntregar');
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

            var PagoProduct = document.getElementById('DivPagoTotalDeliveryEntregar');
            PagoProduct.innerHTML = `
                <div>
                    <div class="col-sm-6">
                        <div class="input-group" style="width: 100%"></div>
                    </div>
            
                    <div class="row" style="background: #243A73; padding: 5px;">
                        <div class="col-sm-7">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 20px; color: white">PAGAR CON</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <button class="btn position-relative btnAddPagoDelivery" type="button" onclick="agregarDivPago()">Add</button>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="padding: 10px">
                    <div class="col-sm-12">
                    <button class="btn position-relative btnGuardarPagoDelivery" type="button" style="background: #90D26D; display: none" data-idpago="${ConsumoId}" id="btnGuardarPago" onclick="enviarPagos(this)">Guardar</button>
                    </div>
                </div>
            `;

            
            var DivBotones = document.getElementById('DivBotonesFooterEntregar');
            DivBotones.innerHTML = `
                <div class="col-md-12 col-lg-12" style="margin: 0px; padding: 0px">
                    <button type="button" class="btn btn-danger float-end" data-id="${IdConsumo}" id="btnDeliverySiguiente" onclick="CambiarEstadoEnviado(this)" style="background: #F4CE14; color: black">Enviar Pedido</button>
                </div>
            `;

            listarpagosEntregar(ConsumoId)

        },
        error: function (error) {
            console.error('Error:', error);
        }
    });       

}

function listarpagosEntregar(ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-pago/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var pagos = response.pagos;
            var PagosTotal = response.total;
            var ConsumoTotal = response.consumo.total;
            var TotalGeneral = parseFloat(PagosTotal - ConsumoTotal).toFixed(2);

            var divListPagoTotalDelivery = document.getElementById('DivListPagoTotalDeliveryEntregar');
            divListPagoTotalDelivery.innerHTML = '';

            pagos.forEach(function(pago) {
                var pagoDiv = document.createElement('div');
                pagoDiv.className = 'row';
                pagoDiv.style.padding = '10px';
                pagoDiv.style.background = '#F0F0F0';
                pagoDiv.style.marginBottom = '2px';

                pagoDiv.innerHTML = `
                    <div class="col-sm-3" style="text-align: left">
                        <span><strong>${pago.TipoPago}</strong></span>
                    </div>
                    <div class="col-sm-9">
                        <span>${parseFloat(pago.TotalPago).toFixed(2)}</span>
                    </div>
                `;

                divListPagoTotalDelivery.appendChild(pagoDiv);
            });

            var totalDiv = document.createElement('div');
            totalDiv.className = 'row';
            totalDiv.style.background = '#243A73';
            totalDiv.style.marginTop = '10px';

            totalDiv.innerHTML = `
            <div class="row">
                <div class="col-sm-3" style="text-align: left;">
                    <span><strong style="font-size: 20px; color: white">Vuelto</strong></span>
                </div>
                <div class="col-sm-9">
                    <span><strong style="font-size: 20px; color: white; text-align: left;">${TotalGeneral}</strong></span>
                </div>
            </div>
            `;

            divListPagoTotalDelivery.appendChild(totalDiv);

            var btnDeliverySiguiente = document.getElementById('btnDeliverySiguiente');
            if (btnDeliverySiguiente) {
                if (ConsumoTotal > PagosTotal) {
                    btnDeliverySiguiente.style.display = 'none';
                } else {
                    btnDeliverySiguiente.style.display = 'block';
                }
            } else {
                console.error("El botón btnDeliverySiguiente no se encontró en el DOM.");
            }
            
            // Agregar controlador de eventos para eliminar pago
            var deleteButtons = document.getElementsByClassName('btnDeletePago');
            for (var i = 0; i < deleteButtons.length; i++) {
                deleteButtons[i].addEventListener('click', function() {
                    var pagoId = this.getAttribute('data-pago-id');
                    deletePago(pagoId, ConsumoId);
                });
            }
        },
        error: function (error) {
            console.error('Error al obtener pagos:', error);
        }
    });
}

function ListarDescuentosDeliveryEntregar(id) {
    $.ajax({
        url: '/api/get-descuento/' + id,
        type: 'get',
        success: function (response) {
            var DivDescuentoDelivery = document.getElementById('DivDeliverySubTotalListEntregar');

            DivDescuentoDelivery.innerHTML = '';
            response.forEach(function (descuento) {
                var nuevoDescuentoDiv = document.createElement('div');
                nuevoDescuentoDiv.className = 'row';
                nuevoDescuentoDiv.style.background = '#F0F0F0';
                nuevoDescuentoDiv.style.padding = '6px';
                nuevoDescuentoDiv.style.border = '2px solid white';

                var tipoDescuentoText = descuento.TipoDescuento === 'porcentaje' ?
                    `Descuento de ${descuento.MontoDescuento} %` :
                    `Descuento de ${descuento.TipoDescuento}`;

                    nuevoDescuentoDiv.innerHTML = `
                        <div class="col-sm-6">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 16px; color: #3D3B40">${tipoDescuentoText}</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <span style="font-size: 16px; color: #3D3B40">${descuento.TotalDescuento} Bs.</span>
                        </div>
                    `;
                    DivDescuentoDelivery.appendChild(nuevoDescuentoDiv);                    

            });
        },
        error: function (error) {
            MostrarMensaje(error,'error');
        }
    });
}

function CambiarEstadoEnviado(button) {
    var consumoId = button.getAttribute('data-id');
    $.ajax({
        url: '/api/estado-enviar/' + consumoId,
        method: 'GET',
        contentType: 'application/json',
        success: function(response) {
            GetDeliveryPreparando()
            GetDeliveryEntregar()
            GetDeliveryEnviar()
            MostrarMensaje("Estado Cambiado Exitosamente", "success");
        },
        error: function(xhr, status, error) {
            MostrarMensaje('Error al enviar el cambio de estado', "error");
        }
    });
}

///para la lista de Entregar function
function GetDeliveryEnviar() {
    $.ajax({
        url: '/api/get-delivery-enviar',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log("Datos Enviados traigos de DB")
            console.log(data)
            $('#DeliveyEnviados tbody').empty();
            $.each(data, function (index, consumo) {                
                var row = `<tr>
                            <td>${consumo.id}</td>
                            <td>${consumo.fecha_venta}</td>
                            <td>
                                ${consumo.cliente 
                                    ? `${consumo.cliente.CalleCliente} ${consumo.cliente.NumeroCliente} ${consumo.cliente.PisoCliente} ${consumo.cliente.BarrioCliente}` 
                                    : `${consumo.clientetemporal.CalleCliente} ${consumo.clientetemporal.NumeroCliente} ${consumo.clientetemporal.PisoCliente} ${consumo.clientetemporal.BarrioCliente}`
                                }
                            </td>
                            <td>
                                ${consumo.cliente 
                                    ? consumo.cliente.TelefonoCliente 
                                    : consumo.clientetemporal.TelefonoCliente 
                                }
                            </td>
                            <td>
                                ${consumo.cliente 
                                    ? consumo.cliente.NombreCliente 
                                    : consumo.clientetemporal.NombreCliente 
                                }
                            </td>
                            <td>${consumo.repartidor_id}</td>
                            <td>${consumo.total}</td>
                        </tr>`;
                $('#DeliveyEnviados tbody').append(row);

                console.log("Consumo del foreach")
                console.log(consumo)
                $('#DeliveyEnviados').off('click').on('click', 'tbody tr', function (event) {
                    event.preventDefault(); 
                    $('#DeliveyEnviados tbody tr').not(this).removeClass('selected');
                    $(this).toggleClass('selectedEnviar');
                    if ($(this).hasClass('selectedEnviar')) {
                        id = $(this).find('td:first').text();
                        GetConsumoDeliveryEnviar(id);
                        agregarDetallesConsumoDeliveryEnviar(id);
                        ListarDescuentosDeliveryEnviar(id);
                    }
                });
            });
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });
}

function GetConsumoDeliveryEnviar(consumo){
    $.ajax({
        url: '/api/get-delivery-consumo/'+consumo,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var MostradorNuevoPedido = document.getElementById('form_tabs');
                MostradorNuevoPedido.innerHTML = `
                    <form>
                        <div class="card-header" style="background: #F4CE14">
                            <div class="row" style="width: 100%">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: black">Pedido # ${data[0].id}</h3>
                                </div> 
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="col-md-12">
                                <form class="card">
                                    <div class="card-header">
                                        <div>
                                            <p><strong>Hora De Inicio:</strong> ${data[0].fecha_venta}</p>
                                            <p><strong>Cliente:</strong> ${data[0].cliente ? data[0].cliente.NombreCliente : data[0].clientetemporal.NombreCliente}</p>
                                            <p><strong>Telefono:</strong> ${data[0].cliente ? data[0].cliente.TelefonoCliente : data[0].clientetemporal.TelefonoCliente}</p>
                                            <p><strong>Direccion:</strong> ${data[0].cliente ? `${data[0].cliente.BarrioCliente} - ${data[0].cliente.CalleCliente} - ${data[0].cliente.NumeroCliente}` : `${data[0].clientetemporal.BarrioCliente} - ${data[0].clientetemporal.CalleCliente} - ${data[0].clientetemporal.NumeroCliente}`}</p>
                                            <p><strong>Tiempo Estimado:</strong> ${data[0].DeliveryTiempo}</p>
                                            <p><strong>Comentario:</strong> ${data[0].DeliveryComentario}</p>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">                                            
                                        <div class="mb-3" id="DivPreparandoDeliveryEnviar">
                                            
                                        </div>

                                        <div class="row" id="DivDeliveryCosto" style="background: #F0F0F0; padding: 6px; border: 2px solid white">
                                            <div class="col-sm-6">
                                                <div class="input-group" style="width: 100%">
                                                    <span style="font-size: 16px; color: #3D3B40">Costo De Envio</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6" style="text-align: right">
                                                <span style="font-size: 16px; color: #3D3B40">${data[0].DeliveryCosto} Bs.</span>
                                            </div>
                                        </div>
                                        <div id="DivPreparandoDeliverySubTotalEnviar" style="text-align: center">

                                        </div>
                                        <div id="DivDeliverySubTotalListEnviar">
                                            
                                        </div>
                                        <div id="DivPreparandoDeliveryDescuento">
                                            
                                        </div>                                            
                                        <div id="DivPreparandoDeliveryTotalEnviar" style="text-align: center">
                                            <h1 style="color: #61677A">Sin Agregar Detalle al Consumo . . .</h1>
                                        </div>
                                        <div id="DivPagoTotalDeliveryEnviar" style="display: none">
                                            
                                        </div>
                                        <div id="DivListPagoTotalDeliveryEnviar" style="padding: 0px; margin: 0px">
                                            
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="mb-3" id="DivBotonesFooterEnviar">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                  
                    </form>
                `;
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });   
}

function agregarDetallesConsumoDeliveryEnviar(ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-consumo/'+ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            DivagregarDetallesConsumoDeliveryEnviar(consumo[0].detalleconsumos, ConsumoId);
            DivTotalConsumoDeliveryEnviar(consumo[0].id);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function DivagregarDetallesConsumoDeliveryEnviar(detalleconsumos, ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-consumo/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
        var DivPedidosDelivery = document.getElementById('DivPreparandoDeliveryEnviar');
        DivPedidosDelivery.innerHTML = '';

        detalleconsumos.forEach(function (detalle, index) {
            var nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'row producto-row';
            nuevoDiv.style = 'padding: 1px';

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
                                                <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                <p style="font-size: 12px;">
                                                    ${detalle.comentario} 
                                                    <a id="AddModificador" style="color: blue" data-bs-toggle="modal" data-bs-target="#ModalAddModificador" data-IdModificador="${IdMod}" data-IdDetalle="${detalle.id}">Add</a>
                                                </p>
                                            </div>
                                            <div class="col-md-12 col-lg-3" style="width: 50%;">
                                                <h3 class="card-title">${detalle.total}</h3>                                                                    
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
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>                                                        
                                </div>
                            </div>
                        `;
                    }
                }
                DivPedidosDelivery.appendChild(nuevoDiv);
            });
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function DivTotalConsumoDeliveryEnviar(ConsumoId) {

    $.ajax({
        url: '/api/get-delivery-consumo/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            var SubTotalProduct = document.getElementById('DivPreparandoDeliverySubTotalEnviar');
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

            var TotalProduct = document.getElementById('DivPreparandoDeliveryTotalEnviar');
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

            var PagoProduct = document.getElementById('DivPagoTotalDeliveryEnviar');
            PagoProduct.innerHTML = `
                <div>
                    <div class="col-sm-6">
                        <div class="input-group" style="width: 100%"></div>
                    </div>
            
                    <div class="row" style="background: #243A73; padding: 5px;">
                        <div class="col-sm-7">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 20px; color: white">PAGAR CON</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <button class="btn position-relative btnAddPagoDelivery" type="button" onclick="agregarDivPago()">Add</button>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="padding: 10px">
                    <div class="col-sm-12">
                    <button class="btn position-relative btnGuardarPagoDelivery" type="button" style="background: #90D26D; display: none" data-idpago="${ConsumoId}" id="btnGuardarPago" onclick="enviarPagos(this)">Guardar</button>
                    </div>
                </div>
            `;

            
            var DivBotones = document.getElementById('DivBotonesFooterEnviar');
            DivBotones.innerHTML = `
                <div class="col-md-12 col-lg-12" style="margin: 0px; padding: 0px">
                    <div class="row" style="padding: 10px" hidden>
                        <label class="col-6 col-form-label pt-0">Enviar a CAJAS</label>
                        <div class="col">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" style="border: 1px solid black" id="EnviarCajaDelivery" checked>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12" style="margin: 0px; padding: 0px">
                    <button type="button" class="btn btn-danger float-end" data-id="${IdConsumo}" id="btnDeliverySiguiente" onclick="CambiarEstadoCompleto(this)" style="background: #65B741; color: black">Completar Pedido</button>
                </div>
            `;

            listarpagosEnviar(ConsumoId)

        },
        error: function (error) {
            console.error('Error:', error);
        }
    });       

}

function listarpagosEnviar(ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-pago/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var pagos = response.pagos;
            var PagosTotal = response.total;
            var ConsumoTotal = response.consumo.total;
            var TotalGeneral = parseFloat(PagosTotal - ConsumoTotal).toFixed(2);

            var divListPagoTotalDelivery = document.getElementById('DivListPagoTotalDeliveryEnviar');
            divListPagoTotalDelivery.innerHTML = '';

            pagos.forEach(function(pago) {
                var pagoDiv = document.createElement('div');
                pagoDiv.className = 'row';
                pagoDiv.style.padding = '10px';
                pagoDiv.style.background = '#F0F0F0';
                pagoDiv.style.marginBottom = '2px';

                pagoDiv.innerHTML = `
                    <div class="col-sm-3" style="text-align: left">
                        <span><strong>${pago.TipoPago}</strong></span>
                    </div>
                    <div class="col-sm-9">
                        <span>${parseFloat(pago.TotalPago).toFixed(2)}</span>
                    </div>
                `;

                divListPagoTotalDelivery.appendChild(pagoDiv);
            });

            var totalDiv = document.createElement('div');
            totalDiv.className = 'row';
            totalDiv.style.background = '#243A73';
            totalDiv.style.marginTop = '10px';

            totalDiv.innerHTML = `
            <div class="row">
                <div class="col-sm-3" style="text-align: left;">
                    <span><strong style="font-size: 20px; color: white">Vuelto</strong></span>
                </div>
                <div class="col-sm-9">
                    <span><strong style="font-size: 20px; color: white; text-align: left;">${TotalGeneral}</strong></span>
                </div>
            </div>
            `;

            divListPagoTotalDelivery.appendChild(totalDiv);

            var btnDeliverySiguiente = document.getElementById('btnDeliverySiguiente');
            if (btnDeliverySiguiente) {
                if (ConsumoTotal > PagosTotal) {
                    btnDeliverySiguiente.style.display = 'none';
                } else {
                    btnDeliverySiguiente.style.display = 'block';
                }
            } else {
                console.error("El botón btnDeliverySiguiente no se encontró en el DOM.");
            }
            
            // Agregar controlador de eventos para eliminar pago
            var deleteButtons = document.getElementsByClassName('btnDeletePago');
            for (var i = 0; i < deleteButtons.length; i++) {
                deleteButtons[i].addEventListener('click', function() {
                    var pagoId = this.getAttribute('data-pago-id');
                    deletePago(pagoId, ConsumoId);
                });
            }
        },
        error: function (error) {
            console.error('Error al obtener pagos:', error);
        }
    });
}

function ListarDescuentosDeliveryEnviar(id) {
    $.ajax({
        url: '/api/get-descuento/' + id,
        type: 'get',
        success: function (response) {
            var DivDescuentoDelivery = document.getElementById('DivDeliverySubTotalListEnviar');

            DivDescuentoDelivery.innerHTML = '';
            response.forEach(function (descuento) {
                var nuevoDescuentoDiv = document.createElement('div');
                nuevoDescuentoDiv.className = 'row';
                nuevoDescuentoDiv.style.background = '#F0F0F0';
                nuevoDescuentoDiv.style.padding = '6px';
                nuevoDescuentoDiv.style.border = '2px solid white';

                var tipoDescuentoText = descuento.TipoDescuento === 'porcentaje' ?
                    `Descuento de ${descuento.MontoDescuento} %` :
                    `Descuento de ${descuento.TipoDescuento}`;

                    nuevoDescuentoDiv.innerHTML = `
                        <div class="col-sm-6">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 16px; color: #3D3B40">${tipoDescuentoText}</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <span style="font-size: 16px; color: #3D3B40">${descuento.TotalDescuento} Bs.</span>
                        </div>
                    `;
                    DivDescuentoDelivery.appendChild(nuevoDescuentoDiv);                    

            });
        },
        error: function (error) {
            MostrarMensaje(error,'error');
        }
    });
}

/*function CambiarEstadoCompleto(button) {
    var consumoId = button.getAttribute('data-id');
    var EnviarCajaDelivery = document.getElementById('EnviarCajaDelivery').checked;

    $.ajax({
        url: '/api/estado-completo/' + consumoId,
        method: 'GET',
        contentType: 'application/json',
        success: function(response) {
            document.getElementById('EnviarCajaDelivery').checked = false;
            GetDeliveryPreparando()
            GetDeliveryEntregar()
            GetDeliveryEnviar()
            GetDeliveryCompleto()
            MostrarMensaje("Estado Cambiado Exitosamente", "success");
        },
        error: function(xhr, status, error) {
            MostrarMensaje('Error al enviar el cambio de estado', "error");
        }
    });
}*/

function CambiarEstadoCompleto(button) {
    var consumoId = button.getAttribute('data-id');
    var EnviarCajaDelivery = document.getElementById('EnviarCajaDelivery').checked;

    $.ajax({
        url: '/api/estado-completo/' + consumoId + '?EnviarCajaDelivery=' + EnviarCajaDelivery,
        method: 'GET',
        contentType: 'application/json',
        success: function(response) {
            console.log(response)
            // Restablecer el checkbox a false después de la respuesta
            GetDeliveryPreparando();
            GetDeliveryEntregar();
            GetDeliveryEnviar();
            GetDeliveryCompleto();
            MostrarMensaje("Estado Cambiado Exitosamente", "success");
        },
        error: function(xhr, status, error) {
            MostrarMensaje('Error al enviar el cambio de estado', "error");
        }
    });
}


///para la lista de Entregar function
let itemsPerPage = 5;
let currentPage = 0;
let allData = [];

function GetDeliveryCompleto() {
    $.ajax({
        url: '/api/get-delivery-completo',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log("Datos completos traidos de DB");
            console.log(data);
            allData = data; // Almacena todos los datos obtenidos en una variable global
            currentPage = 0; // Reinicia el contador de páginas
            $('#DeliveyEntregado tbody').empty();
            loadMoreItems(); // Carga los primeros elementos
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });
}

function loadMoreItems() {
    let start = currentPage * itemsPerPage;
    let end = start + itemsPerPage;
    let itemsToLoad = allData.slice(start, end);

    $.each(itemsToLoad, function (index, consumo) {
        var row = `<tr>
                            <td>${consumo.id}</td>
                            <td>${consumo.fecha_venta}</td>
                            <td>
                                ${consumo.cliente 
                                    ? `${consumo.cliente.CalleCliente} ${consumo.cliente.NumeroCliente} ${consumo.cliente.PisoCliente} ${consumo.cliente.BarrioCliente}` 
                                    : `${consumo.clientetemporal.CalleCliente} ${consumo.clientetemporal.NumeroCliente} ${consumo.clientetemporal.PisoCliente} ${consumo.clientetemporal.BarrioCliente}`
                                }
                            </td>
                            <td>
                                ${consumo.cliente 
                                    ? consumo.cliente.TelefonoCliente 
                                    : consumo.clientetemporal.TelefonoCliente 
                                }
                            </td>
                            <td>
                                ${consumo.cliente 
                                    ? consumo.cliente.NombreCliente 
                                    : consumo.clientetemporal.NombreCliente 
                                }
                            </td>
                            <td>${consumo.repartidor_id}</td>
                            <td>${consumo.total}</td>
                        </tr>`;
        $('#DeliveyEntregado tbody').append(row);
    });

    // Incrementa la página actual
    currentPage++;

    // Si no hay más elementos para mostrar, oculta el botón
    if (end >= allData.length) {
        $('#loadMore').hide();
    } else {
        $('#loadMore').show();
    }

    // Agrega el evento de click a las filas de la tabla
    $('#DeliveyEntregado').off('click').on('click', 'tbody tr', function (event) {
        event.preventDefault();
        $('#DeliveyEntregado tbody tr').not(this).removeClass('selected');
        $(this).toggleClass('selectedCompletar');
        if ($(this).hasClass('selectedCompletar')) {
            id = $(this).find('td:first').text();
            GetConsumoDeliveryCompleto(id);
            agregarDetallesConsumoDeliveryCompleto(id);
            ListarDescuentosDeliveryCompleto(id);
        }
    });
}

// Evento de click para el botón "Load More"
$('#loadMore').on('click', function () {
    loadMoreItems();
});

function GetConsumoDeliveryCompleto(consumo){
    $.ajax({
        url: '/api/get-delivery-consumo/'+consumo,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var MostradorNuevoPedido = document.getElementById('form_tabs');
                MostradorNuevoPedido.innerHTML = `
                    <form>
                        <div class="card-header" style="background: #65B741">
                            <div class="row" style="width: 100%">
                                <div class="col-12 col-sm-8">
                                    <h3 class="card-title" style="color: black">Pedido # ${data[0].id}</h3>
                                </div> 
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="col-md-12">
                                <form class="card">
                                    <div class="card-header">
                                        <div>
                                            <p><strong>Hora De Inicio:</strong> ${data[0].fecha_venta}</p>
                                            <p><strong>Cliente:</strong> ${data[0].cliente ? data[0].cliente.NombreCliente : data[0].clientetemporal.NombreCliente}</p>
                                            <p><strong>Telefono:</strong> ${data[0].cliente ? data[0].cliente.TelefonoCliente : data[0].clientetemporal.TelefonoCliente}</p>
                                            <p><strong>Direccion:</strong> ${data[0].cliente ? `${data[0].cliente.BarrioCliente} - ${data[0].cliente.CalleCliente} - ${data[0].cliente.NumeroCliente}` : `${data[0].clientetemporal.BarrioCliente} - ${data[0].clientetemporal.CalleCliente} - ${data[0].clientetemporal.NumeroCliente}`}</p>
                                            <p><strong>Tiempo Estimado:</strong> ${data[0].DeliveryTiempo}</p>
                                            <p><strong>Comentario:</strong> ${data[0].DeliveryComentario}</p>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">                                            
                                        <div class="mb-3" id="DivPreparandoDeliveryCompleto">
                                            
                                        </div>

                                        <div class="row" id="DivDeliveryCosto" style="background: #F0F0F0; padding: 6px; border: 2px solid white">
                                            <div class="col-sm-6">
                                                <div class="input-group" style="width: 100%">
                                                    <span style="font-size: 16px; color: #3D3B40">Costo De Envio</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6" style="text-align: right">
                                                <span style="font-size: 16px; color: #3D3B40">${data[0].DeliveryCosto} Bs.</span>
                                            </div>
                                        </div>
                                        <div id="DivPreparandoDeliverySubTotalCompleto" style="text-align: center">

                                        </div>
                                        <div id="DivDeliverySubTotalListCompleto">
                                            
                                        </div>
                                        <div id="DivPreparandoDeliveryDescuento">
                                            
                                        </div>                                            
                                        <div id="DivPreparandoDeliveryTotalCompleto" style="text-align: center">
                                            <h1 style="color: #61677A">Sin Agregar Detalle al Consumo . . .</h1>
                                        </div>
                                        <div id="DivPagoTotalDeliveryCompleto" style="display: none">
                                            
                                        </div>
                                        <div id="DivListPagoTotalDeliveryCompleto" style="padding: 0px; margin: 0px">
                                            
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <div class="mb-3" id="DivBotonesFooterCompleto">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>                  
                    </form>
                `;
        },
        error: function (error) {
            console.error('Error al obtener datos del servidor:', error);
        }
    });   
}

function agregarDetallesConsumoDeliveryCompleto(ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-consumo/'+ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            DivagregarDetallesConsumoDeliveryCompleto(consumo[0].detalleconsumos, ConsumoId);
            DivTotalConsumoDeliveryCompleto(consumo[0].id);
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function DivagregarDetallesConsumoDeliveryCompleto(detalleconsumos, ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-consumo/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
        var DivPedidosDelivery = document.getElementById('DivPreparandoDeliveryCompleto');
        DivPedidosDelivery.innerHTML = '';

        detalleconsumos.forEach(function (detalle, index) {
            var nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'row producto-row';
            nuevoDiv.style = 'padding: 1px';

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
                                                <p class="card-title">${detalle.producto.NombreProducto} - ${detalle.precio}</p>
                                                <p style="font-size: 12px;">
                                                    ${detalle.comentario} 
                                                    <a id="AddModificador" style="color: blue" data-bs-toggle="modal" data-bs-target="#ModalAddModificador" data-IdModificador="${IdMod}" data-IdDetalle="${detalle.id}">Add</a>
                                                </p>
                                            </div>
                                            <div class="col-md-12 col-lg-3" style="width: 50%;">
                                                <h3 class="card-title">${detalle.total}</h3>                                                                    
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
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>                                                        
                                </div>
                            </div>
                        `;
                    }
                }
                DivPedidosDelivery.appendChild(nuevoDiv);
            });
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}

function DivTotalConsumoDeliveryCompleto(ConsumoId) {

    $.ajax({
        url: '/api/get-delivery-consumo/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            var SubTotalProduct = document.getElementById('DivPreparandoDeliverySubTotalCompleto');
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

            var TotalProduct = document.getElementById('DivPreparandoDeliveryTotalCompleto');
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

            var PagoProduct = document.getElementById('DivPagoTotalDeliveryCompleto');
            PagoProduct.innerHTML = `
                <div>
                    <div class="col-sm-6">
                        <div class="input-group" style="width: 100%"></div>
                    </div>
            
                    <div class="row" style="background: #243A73; padding: 5px;">
                        <div class="col-sm-7">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 20px; color: white">PAGAR CON</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <button class="btn position-relative btnAddPagoDelivery" type="button" onclick="agregarDivPago()">Add</button>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="padding: 10px">
                    <div class="col-sm-12">
                    <button class="btn position-relative btnGuardarPagoDelivery" type="button" style="background: #90D26D; display: none" data-idpago="${ConsumoId}" id="btnGuardarPago" onclick="enviarPagos(this)">Guardar</button>
                    </div>
                </div>
            `;

            listarpagosCompleto(ConsumoId)

        },
        error: function (error) {
            console.error('Error:', error);
        }
    });       

}

function listarpagosCompleto(ConsumoId) {
    $.ajax({
        url: '/api/get-delivery-pago/' + ConsumoId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var pagos = response.pagos;
            var PagosTotal = response.total;
            var ConsumoTotal = response.consumo.total;
            var TotalGeneral = parseFloat(PagosTotal - ConsumoTotal).toFixed(2);

            var divListPagoTotalDelivery = document.getElementById('DivListPagoTotalDeliveryCompleto');
            divListPagoTotalDelivery.innerHTML = '';

            pagos.forEach(function(pago) {
                var pagoDiv = document.createElement('div');
                pagoDiv.className = 'row';
                pagoDiv.style.padding = '10px';
                pagoDiv.style.background = '#F0F0F0';
                pagoDiv.style.marginBottom = '2px';

                pagoDiv.innerHTML = `
                    <div class="col-sm-3" style="text-align: left">
                        <span><strong>${pago.TipoPago}</strong></span>
                    </div>
                    <div class="col-sm-9">
                        <span>${parseFloat(pago.TotalPago).toFixed(2)}</span>
                    </div>
                `;

                divListPagoTotalDelivery.appendChild(pagoDiv);
            });

            var totalDiv = document.createElement('div');
            totalDiv.className = 'row';
            totalDiv.style.background = '#243A73';
            totalDiv.style.marginTop = '10px';

            totalDiv.innerHTML = `
            <div class="row">
                <div class="col-sm-3" style="text-align: left;">
                    <span><strong style="font-size: 20px; color: white">Vuelto</strong></span>
                </div>
                <div class="col-sm-9">
                    <span><strong style="font-size: 20px; color: white; text-align: left;">${TotalGeneral}</strong></span>
                </div>
            </div>
            `;

            divListPagoTotalDelivery.appendChild(totalDiv);

            var btnDeliverySiguiente = document.getElementById('btnDeliverySiguiente');
            if (btnDeliverySiguiente) {
                if (ConsumoTotal > PagosTotal) {
                    btnDeliverySiguiente.style.display = 'none';
                } else {
                    btnDeliverySiguiente.style.display = 'block';
                }
            } else {
                console.error("El botón btnDeliverySiguiente no se encontró en el DOM.");
            }
            
            // Agregar controlador de eventos para eliminar pago
            var deleteButtons = document.getElementsByClassName('btnDeletePago');
            for (var i = 0; i < deleteButtons.length; i++) {
                deleteButtons[i].addEventListener('click', function() {
                    var pagoId = this.getAttribute('data-pago-id');
                    deletePago(pagoId, ConsumoId);
                });
            }
        },
        error: function (error) {
            console.error('Error al obtener pagos:', error);
        }
    });
}

function ListarDescuentosDeliveryCompleto(id) {
    $.ajax({
        url: '/api/get-descuento/' + id,
        type: 'get',
        success: function (response) {
            var DivDescuentoDelivery = document.getElementById('DivDeliverySubTotalListCompleto');

            DivDescuentoDelivery.innerHTML = '';
            response.forEach(function (descuento) {
                var nuevoDescuentoDiv = document.createElement('div');
                nuevoDescuentoDiv.className = 'row';
                nuevoDescuentoDiv.style.background = '#F0F0F0';
                nuevoDescuentoDiv.style.padding = '6px';
                nuevoDescuentoDiv.style.border = '2px solid white';

                var tipoDescuentoText = descuento.TipoDescuento === 'porcentaje' ?
                    `Descuento de ${descuento.MontoDescuento} %` :
                    `Descuento de ${descuento.TipoDescuento}`;

                    nuevoDescuentoDiv.innerHTML = `
                        <div class="col-sm-6">
                            <div class="input-group" style="width: 100%">
                                <span style="font-size: 16px; color: #3D3B40">${tipoDescuentoText}</span>
                            </div>
                        </div>
                        <div class="col-sm-5" style="text-align: right">
                            <span style="font-size: 16px; color: #3D3B40">${descuento.TotalDescuento} Bs.</span>
                        </div>
                    `;
                    DivDescuentoDelivery.appendChild(nuevoDescuentoDiv);                    

            });
        },
        error: function (error) {
            MostrarMensaje(error,'error');
        }
    });
}

function generarPDFDelivery() {
    var deliveryId = document.getElementById('ImprimirDelivery').getAttribute('data-id');
    let pdfLink;
    $.ajax({
        url: window.location.origin + '/api/get-delivery-preparando/' + deliveryId,
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

function generarPDFverDelivery() {
    var mesaId = document.getElementById('VerImprimirDelivery').getAttribute('data-id');
    var pdfUrl = '/api/get-delivery-preparando/' + mesaId;

    // Configura el iframe con la URL del PDF
    document.getElementById('pdfViewerDelivery').src = pdfUrl;

    // Muestra el modal
    var pdfModalDelivery = new bootstrap.Modal(document.getElementById('pdfModalDelivery'));
    pdfModalDelivery.show();
}