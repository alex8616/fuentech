<div class="card-header" style="width: 100%; background-color: #1d2736">
    <div class="row" style="width: 100%;">
        <div class="col-12 col-sm-8">
            <h3 class="card-title" style="color: white; font-weight: bold;">TARJETA</h3>
        </div>
        <div class="col-12 col-sm-4" style="text-align: right;">
            <button  id="addcajatarjeta" class="btn position-relative">
                Agregar
            </button>
        </div>
    </div>
</div>
<div class="card-body" style="background: #F5F7F8;">
    <div class="datagrid">
        <div class="datagrid-item">
            <div class="row">
                <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                    <div class="row" style="background: #F5F7F8;">
                        <div class="col-md-11">
                            <div class="row" style="padding-bottom: 10px">
                                <div class="col-md-3">
                                    <select name="DateCajaTarjeta" id="DateCajaTarjeta" class="form-control">
                                        <option value="DiarioCajaTarjeta">Diario</option>
                                        <option value="MensualidadCajaTarjeta">Todo El Mes</option>
                                        <option value="RangoCajaTarjeta">Rango</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="DiaCajaTarjetaContainer">
                                    <select name="DiaCajaTarjeta" id="DiaCajaTarjeta" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-3" id="MesCajaTarjetaContainer">
                                    <select name="MesCajaTarjeta" id="MesCajaTarjeta" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-3" id="AnioCajaTarjetaContainer">
                                    <select name="AnioCajaTarjeta" id="AnioCajaTarjeta" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-3" id="FechaInicioContainerCajaTarjeta">
                                    <input type="date" name="fechaInicioCajaTarjeta" id="fechaInicioCajaTarjeta" class="form-control">
                                </div>
                                <div class="col-md-3" id="FechaFinContainerCajaTarjeta">
                                    <input type="date" name="fechaFinCajaTarjeta" id="fechaFinCajaTarjeta" class="form-control">
                                </div><br><br><br>
                                <div class="col-md-11">
                                    <div class="input-group input-group-flat">
                                        <input type="text" name="searchcajatarjeta" id="searchcajatarjeta" class="form-control">
                                        <span class="input-group-text">
                                            <a href="#" class="link-secondary" data-bs-toggle="tooltip" aria-label="Clear search" data-bs-original-title="Clear search">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path></svg>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="row" style="padding-bottom: 10px; text-align: end;">
                                <span class="badge bg-blue" style="padding: 10px; width: 50%; cursor: pointer;" id="btn-refrescar-tabla-tarjeta">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-reload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12" style="width: 100%; margin: 0px; border-bottom: 1px solid #E6E6E6; border-left: 1px solid #E6E6E6; border-right: 1px solid #E6E6E6;">
                    <div class="row">
                        <div class="col-10 col-md-12" style="border-top: 2px solid #E6E6E6;">
                            <div class="row" style="padding-top: 8px;" >
                                <div class="row" style="width: 100%;">
                                    <div class="col-md-4" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                        <span style="color: #7F8487;">INGRESO <br>
                                            <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="IngresoTarjeta"></span>
                                        </span>
                                    </div>
                                    <div class="col-md-4" style="border-bottom: 1px solid #E6E6E6; padding: 10px">
                                        <span style="color: #7F8487;">TOTAL <br>
                                            <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="TotalTarjeta"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div class="card">
                                <div class="table-responsive" style="overflow-y: scroll; max-height: 500px">
                                    <table class="table table-vcenter card-table" id="tabla-caja-Tarjeta">
                                        <thead style="position: sticky; top: 0; z-index: 1;">
                                            <tr>
                                            <th>N°</th>
                                            <th>Codigo</th>
                                            <th>Nombre Atributo</th>
                                            <th>Descripcion</th>
                                            <th>Fecha Registro</th>
                                            <th>Ingreso</th>
                                            <th>Sumatoria</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .selected-row {
        background-color: #ffeeba;
        color: #000;
    }
</style>

<script src="{{ asset('utilidades/js/InputClass.js') }}" defer></script>

<script>
    $(document).ready(function() { 
        FechaSelectCajaTarjeta()
        InputRangoFechasControl()

        $('#searchcajatarjeta').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $("#tabla-caja-Tarjeta tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $('.input-group-text a').on('click', function(e) {
            e.preventDefault();
            $('#searchcajatarjeta').val('');
        });
        
        document.getElementById('addcajatarjeta').addEventListener('click', function() {
            cargarArticulos();

            var formTabsDiv = document.getElementById('form_tabs');
            var formHtml = `
            <form id="form-register-detalle-tarjeta">
                <div class="card-header" style="background: rgb(24, 36, 51); color: white">
                    <h2 class="card-title">TARJETA</h2>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label required">Selecciona ..</label>
                        <select id="articuloCajaSelect" class="form-select" style="width: 100%;"></select>                       
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Detalle</label>
                        <textarea name="content" id="detalle" rows="4" class="form-control convertmayusculas"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">N Facturado / Recibo</label>
                        <input type="text" id="facturarecibo" class="form-control onlynumber"></input>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Tipo de proceso</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="tipodeaccion" id="tipodeaccioningreso" autocomplete="off" value="Ingreso" checked>
                            <label for="tipodeaccioningreso" class="btn">Ingreso</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Monto</label>
                        <input type="text" id="monto" class="form-control convert"></input>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="btn-registrar-detalle-tarjeta">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;
            formTabsDiv.innerHTML = formHtml;

            transformInputsToUpperCaseAndValidateMonto();

            $('#btn-registrar-detalle-tarjeta').on('click', function(event) {
                event.preventDefault();
                var idCaja = {{ $idcaja }};

                var formData = {
                    articuloIdTarjeta: $('#articuloCajaSelect').val(),
                    detalle: $('#detalle').val(),
                    facturarecibo: $('#facturarecibo').val(),
                    tipoDeAccion: $('input[name="tipodeaccion"]:checked').val(),                    
                    monto: $('#monto').val(),
                    idCaja: idCaja
                };

                $.ajax({
                    url: '/api/registrar-detalle-tarjeta',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        MostrarMensaje("Registrado a Caja Tarjeta Exitosamente","success")
                        FiltrarDatosCajaTarjeta();
                        $('#detalle').val("")
                        $('#monto').val("")
                        $('#facturarecibo').val("")
                    },
                    error: function(error) {
                        console.error('Error al guardar los datos:', error);
                    }
                });
            });
        });

        function MostrarCajaTarjeta(response) {
            var tbody = $('#tabla-caja-Tarjeta tbody');
            var formTabsDiv = $('#form_tabs');
            tbody.empty();
            $('#IngresoTarjeta').text(response.IngresoTarjeta);
            $('#TotalTarjeta').text(response.TotalTarjeta);
            
            response.cajatarjetas.forEach(function(item, index) {
                if(item.Eliminado == "false"){
                    if (item.articulocaja.id != 200 ) {
                        if(item.Ingreso > 0){
                            var row = `
                                <tr class="clickable-row-tarjeta" data-id="${item.id}" style="border-left: 3px solid green">
                                    <td>${index + 1}</td>
                                    <td>${item.articulocaja.Codigo_caja}</td>
                                    <td>${item.codigocaja ? item.articulocaja.Nombre_Articulo : 'No disponible'}</td>
                                    <td>${item.Articulo_description}</td>
                                    <td>${formatearFecha(item.created_at)}</td>
                                    <td style="font-weight: ${item.Ingreso == 0 ? 'normal' : 'bold'}">${item.Ingreso}</td>
                                    <td style="background: #40A2E3; color: white; font-weight: bold; text-align: center">${item.Sumatoria}</td>
                                </tr>
                            `;
                            tbody.append(row);
                        }else{
                            var row = `
                                <tr class="clickable-row-tarjeta" data-id="${item.id}" style="border-left: 3px solid red">
                                    <td>${index + 1}</td>
                                    <td>${item.articulocaja.Codigo_caja}</td>
                                    <td>${item.codigocaja ? item.articulocaja.Nombre_Articulo : 'No disponible'}</td>
                                    <td>${item.Articulo_description}</td>
                                    <td>${formatearFecha(item.created_at)}</td>
                                    <td style="font-weight: ${item.Egreso == 0 ? 'normal' : 'bold'}">${item.Egreso}</td>
                                    <td style="background: #40A2E3; color: white; font-weight: bold; text-align: center">${item.Sumatoria}</td>
                                </tr>
                            `;
                            tbody.append(row);
                        }
                    } else {
                        var row = `
                            <tr>
                                <td colspan="8" style="background: #EE4E4E; color: white; font-weight: bold; text-align: center">
                                    Caja Cerrado por ${item.Articulo_description}
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    }
                }else{
                    var row = `
                        <tr>
                            <td style="text-decoration:line-through red; color: #686D76">${index + 1}</td>
                            <td style="text-decoration:line-through red; color: #686D76">${item.articulocaja.Codigo_caja}</td>
                            <td style="text-decoration:line-through red; color: #686D76">${item.codigocaja ? item.articulocaja.Nombre_Articulo : 'No disponible'}</td>
                            <td style="color: #686D76"><span style="text-decoration:line-through red;">${item.Articulo_description}</span> <br> ${item.ComentarioEliminado}</td>
                            <td style="text-decoration:line-through red; color: #686D76">${formatearFecha(item.created_at)}</td>
                            <td style="text-decoration:line-through red; color: #686D76">${item.Ingreso}</td>
                            <td style="text-decoration:line-through red; color: #686D76">${item.Sumatoria}</td>
                        </tr>
                    `;
                    tbody.append(row);
                }
            });

            // Agregar el evento de clic a las filas que cumplen la condición
            $('.clickable-row-tarjeta').on('click', function() {
                $('.clickable-row-tarjeta').removeClass('selected-row');
                $(this).addClass('selected-row');
                var articuloIdTarjeta = $(this).data('id');
                $.ajax({
                    url: '/api/get-detalle-caja-tarjeta-select/' + articuloIdTarjeta,
                    method: 'GET',
                    success: function(response) {
                        
                        //codigo para cada caja dependiendo su valor
                        var ConsumoExiste = response.ServicioPrestado
                        var TipoServicioPrestado = response.TipoServicioPrestado
                        let tablaconsumos = '';
                        let CabezeraConsumo = '';
                        
                        if(ConsumoExiste != null && TipoServicioPrestado == "Consumo"){
                            if(response.consumo.TipoConsumo == "Mesa"){
                                CabezeraConsumo += `
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">CONSUMO MESA</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.fecha_venta}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.cliente ? response.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Mesa</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A"># ${response.consumo.ambiente_mesa_id} </label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Cantidad Personas</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.CantidadPersonas} </label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.Comentario ? response.consumo.Comentario : "Sin Comentario"} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            
                            if(response.consumo.TipoConsumo == "Mostrador"){
                                CabezeraConsumo += `
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">MOSTRADOR</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.fecha_venta}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.cliente ? response.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.Comentario ? response.consumo.Comentario : "Sin Comentario"} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            
                            if(response.consumo.TipoConsumo == "Delivery"){
                                CabezeraConsumo += `
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">DELIVERY</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.fecha_venta}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.cliente ? response.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.Comentario ? response.consumo.Comentario : "Sin Comentario"} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            
                            if(response.consumo.TipoConsumo == "Habitacion"){
                                CabezeraConsumo += `
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">SERVICIO HABITACION</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.fecha_venta}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.cliente ? response.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.Comentario ? response.consumo.Comentario : "Sin Comentario"} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            
                            if(response.consumo.TipoConsumo == "Salon"){
                                CabezeraConsumo += `
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">SERVICIO SALON </h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.fecha_venta}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.cliente ? response.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.Comentario ? response.consumo.Comentario : "Sin Comentario"} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            
                            if(response.consumo.TipoConsumo == "ServicioPedido"){
                                CabezeraConsumo += `
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">${response.consumo.TipoServicioPedido}</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.fecha_venta}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Nro Orden</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.NroOrdenServicioPedido}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Nro Pedido</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.NroPedidoServicioPedido}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.ClienteServicioPedido}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.Comentario ? response.consumo.Comentario : "Sin Comentario"} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            
                            if(response.consumo.TipoConsumo == "VentaSuelta"){
                                CabezeraConsumo += `
                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                        <h3 class="card-title" style="color: black; margin: 0">VENTA SUELTA</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Fecha Registro</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.fecha_venta}</label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Cliente</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.cliente ? response.consumo.cliente.NombreCliente : "Sin Cliente"} </label>
                                                </div>
                                            </div>
                                            <div class="mb-12 row">
                                                <label class="col-4 col-form-label" style="font-weight: bold">Comentario</label>
                                                <div class="col">
                                                    <label class="col-8 col-form-label" style="color: #61677A">${response.consumo.Comentario ? response.consumo.Comentario : "Sin Comentario"} </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }

                            if (ConsumoExiste != null) {
                                var ConsumoPrivate = response.consumo.detalleconsumos
                                    tablaconsumos += `
                                        <div class="accordion" id="accordion-example">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading-2">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false">
                                                    Venta - Consumo
                                                </button>
                                                </h2>
                                                <div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                                                    <div class="accordion-body pt-0">
                                                        <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                                            <div class="card-body" style="padding: 0px; margin: 0px;">                                                          

                                                                ${CabezeraConsumo}

                                                                        <div class="col-md-12" style="padding: 0px; margin: 0px; background: white">
                                                                            <div class="col-md-12" style="width: 100%; padding: 0px;" id="DivAddProduct">
                                                                                ${response.consumo.detalleconsumos.map((detalle, index) => `
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
                                                                                        <h3 class="card-title" style="color: white">${response.consumo.subTotal}</h3>
                                                                                    </div>
                                                                                </div>

                                                                                ${response.consumo.descuentoconsumos.length > 0 ? ` 
                                                                                    <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                                                                        <h3 class="card-title" style="color: black; margin: 0">DESCUENTO</h3>
                                                                                    </div>
                                                                                    ${response.consumo.descuentoconsumos.map((descuento, index) => `
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
                                                                                        <h3 class="card-title" style="color: white">${response.consumo.total}</h3>
                                                                                    </div>
                                                                                </div>


                                                                                ${response.consumo.pagosconsumos.length > 0 ? ` 
                                                                                    <div class="col-md-12" style="padding: 2px; margin: 0px; background: #DDE6ED; width: 100%">
                                                                                        <h3 class="card-title" style="color: black; margin: 0">Tipo De Pago</h3>
                                                                                    </div>
                                                                                    ${response.consumo.pagosconsumos.map((pago, index) => `
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                                                    
                                    `;
                            }else{
                                tablaconsumos += ``;
                            }
                        }
                        
                        var HospedajeExiste = response.ServicioPrestado
                        let tablahospedaje = '';
                        let CabezeraHospedaje = '';

                        if(HospedajeExiste != null  && TipoServicioPrestado == "Hospedaje"){
                            console.log("entro a hos")
                            CabezeraHospedaje += `
                                <div class="col-md-12" style="padding: 5px; margin: 0px; background: #DDE6ED; width: 100%">
                                    <h3 class="card-title" style="color: black; margin: 0">Habitacion #${ response.hospedaje.habitacion_id } - ${ response.hospedaje.CategoriaHabitacion } </h3>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Codigo</label>
                                            <div class="col">
                                                <label class="col-9 col-form-label" style="color: #61677A">${ response.hospedaje.CodigoHospedaje }</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Fecha Ingreso</label>
                                            <div class="col">
                                                <label class="col-9 col-form-label" style="color: #61677A">${response.hospedaje.ingreso_hospedaje}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Fecha Salida</label>
                                            <div class="col">
                                                <label class="col-9 col-form-label" style="color: #61677A">${response.hospedaje.salida_hospedaje}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Procedencia</label>
                                            <div class="col">
                                                <label class="col-9 col-form-label" style="color: #61677A">${response.hospedaje.procedencia_hospedaje}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Destino</label>
                                            <div class="col">
                                                <label class="col-9 col-form-label" style="color: #61677A">${response.hospedaje.destino_hospedaje}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Huesped</label>
                                            <div class="col">
                                                ${response.hospedaje.detallehospedajes.map((detallehospedaje, index) => `
                                                    <label class="col-9 col-form-label" style="color: #61677A">${detallehospedaje.cliente.NombreCompleto_cliente} - ${detallehospedaje.cliente.Nacionalidad_cliente}</label>
                                                `).join('')}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Movilidad</label>
                                            <div class="col">
                                                ${response.hospedaje.autos.map((auto) => `
                                                    <div class="col-9 col-form-label" style="color: #61677A; display: flex; align-items: center;">
                                                        <span>
                                                            ${auto.comentario || 'Sin comentario'} - ${auto.placa || 'Sin placa'}
                                                        </span>
                                                        <div style="width: 40px; height: 20px; background-color: ${auto.color || '#ccc'}; margin-left: 10px; border: 1px solid #61677A;"></div>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Dolar</label>
                                            <div class="col">
                                                <label class="col-9 col-form-label" style="color: #61677A">${response.hospedaje.CambioDolar} $</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <label class="col-3 col-form-label" style="font-weight: bold">Bolivianos</label>
                                            <div class="col">
                                                <label class="col-9 col-form-label" style="color: #61677A">${response.hospedaje.CambioBolivianos} Bs.</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <div class="col">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td style="width: 70%" colspan="3"><label class="col-12 col-form-label" style="color: black"><label class="col-7 col-form-label" style="font-weight: bold; font-size: 18px">TOTAL HOSPEDAJE</label></label></td>
                                                        <td style="width: 30%" colspan="1"><label class="col-12 col-form-label" style="color: black; font-size: 18px">${response.hospedaje.TotalHospedaje} Bs.</label></td>
                                                    </tr>
                                                </table>                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            ${response.hospedaje.servicios.map((servicio, index) => `
                                                ${servicio.detalleservicio.map((detalleservi, index) => `
                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td style="width: 10%"><label class="col-9 col-form-label" style="color: #61677A">${detalleservi.cantidad}</label></td>
                                                            <td style="width: 40%"><label class="col-9 col-form-label" style="color: #61677A">${detalleservi.TipoServicio}</label></td>
                                                            <td style="width: 25%"><label class="col-9 col-form-label" style="color: #61677A">${detalleservi.precio}</label></td>
                                                            <td style="width: 25%"><label class="col-9 col-form-label" style="color: #61677A">${detalleservi.total}</label></td>
                                                        </tr>
                                                    </table>
                                                `).join('')}
                                            `).join('')}
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <div class="col">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td style="width: 70%" colspan="3"><label class="col-12 col-form-label" style="color: black"><label class="col-7 col-form-label" style="font-weight: bold; font-size: 18px">TOTAL SERVICIO</label></label></td>
                                                        <td style="width: 30%" colspan="1"><label class="col-12 col-form-label" style="color: black; font-size: 18px">${response.hospedaje.TotalServicio} Bs.</label></td>
                                                    </tr>
                                                </table>                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            ${response.hospedaje.servicioconsumos.map((servicioconsumo, index) => `
                                                ${servicioconsumo.consumo.map((miconsumo, index) => `
                                                    ${miconsumo.detalleconsumos.map((detalleconsumo, index) => `
                                                        <table style="width: 100%">
                                                            <tr>
                                                                <td style="width: 10%"><label class="col-9 col-form-label" style="color: #61677A">${detalleconsumo.cantidad}</label></td>
                                                                <td style="width: 40%"><label class="col-9 col-form-label" style="color: #61677A">${detalleconsumo.producto.NombreProducto}</label></td>
                                                                <td style="width: 25%"><label class="col-9 col-form-label" style="color: #61677A">${detalleconsumo.precio}</label></td>
                                                                <td style="width: 25%"><label class="col-9 col-form-label" style="color: #61677A">${detalleconsumo.total}</label></td>
                                                            </tr>
                                                        </table>
                                                    `).join('')}
                                                `).join('')}
                                            `).join('')}
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <div class="col">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td style="width: 70%" colspan="3"><label class="col-12 col-form-label" style="color: black"><label class="col-7 col-form-label" style="font-weight: bold; font-size: 18px">TOTAL CONSUMO</label></label></td>
                                                        <td style="width: 30%" colspan="1"><label class="col-12 col-form-label" style="color: black; font-size: 18px">${response.hospedaje.TotalConsumo} Bs.</label></td>
                                                    </tr>
                                                </table>                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <div class="col">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td style="width: 70%" colspan="3"><label class="col-12 col-form-label" style="color: black"><label class="col-7 col-form-label" style="font-weight: bold; font-size: 18px">SUB TOTAL</label></label></td>
                                                        <td style="width: 30%" colspan="1"><label class="col-12 col-form-label" style="color: black; font-size: 18px">${response.hospedaje.SubTotal} Bs.</label></td>
                                                    </tr>
                                                </table>                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <div class="col">
                                                <table style="width: 100%">
                                                    ${response.hospedaje.adelantos.map((adelanto, index) => {
                                                        const formattedDate = new Date(adelanto.FechaDeAdelanto).toISOString().split('T')[0];
                                                        return `
                                                            <tr>
                                                                <td style="width: 70%" colspan="3">
                                                                    <label class="col-9 col-form-label" style="color: #61677A">
                                                                        Adelanto ${formattedDate} - ${adelanto.TipoAdelanto}
                                                                    </label>
                                                                </td>
                                                                <td style="width: 30%" colspan="1">
                                                                    <label class="col-9 col-form-label" style="color: #61677A">${adelanto.TotalAdelanto}</label>
                                                                </td>
                                                            </tr>
                                                        `;
                                                    }).join('')}
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <div class="col">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td style="width: 70%" colspan="3"><label class="col-12 col-form-label" style="color: black"><label class="col-7 col-form-label" style="font-weight: bold; font-size: 18px">TOTAL</label></label></td>
                                                        <td style="width: 30%" colspan="1"><label class="col-12 col-form-label" style="color: black; font-size: 18px">${response.hospedaje.Total} Bs.</label></td>
                                                    </tr>
                                                </table>                                                
                                            </div>
                                        </div>
                                    </div>                                    

                                    <div class="col-12 col-md-12">
                                        <div class="mb-12 row">
                                            <div class="col">
                                                <table style="width: 100%">
                                                    ${response.hospedaje.pagoshospedaje.map((pago, index) => `
                                                        <tr>
                                                            <td style="width: 70%" colspan="3"><label class="col-9 col-form-label" style="color: #61677A">Pagado en ${pago.TipoPago}</label></td>
                                                            <td style="width: 30%" colspan="1"><label class="col-9 col-form-label" style="color: #61677A">${pago.TotalPago} Bs.</label></td>
                                                        </tr>
                                                    `).join('')}                                                    
                                                </table>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            if (HospedajeExiste != null) {
                                    tablahospedaje += `
                                        <div class="accordion" id="accordion-example">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading-2">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false">
                                                    Hospedaje
                                                </button>
                                                </h2>
                                                <div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                                                    <div class="accordion-body pt-0">
                                                        <div class="card-header" style="font-weight: bold; border: 2px solid #DDE6ED;">
                                                            <div class="card-body" style="padding: 0px; margin: 0px;">                                                          

                                                                ${CabezeraHospedaje}

                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                                                    
                                    `;
                            }else{
                                tablahospedaje += ``;
                            }
                        }
                    
                        //fin de codigo para cada caja dependiendo su valor
                        
                        var formTabsDiv = document.getElementById('form_tabs');
                        var formHtml = `
                        <form id="form-register-detalle-tarjeta">
                            <div class="card-header" style="background: rgb(24, 36, 51); color: white">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h2 class="card-title">INFORMACION DETALLE</h2>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <span id="editardetalletarjeta" class="badge bg-blue" data-id="${articuloIdTarjeta}" style="padding: 7px">Editar</span>
                                        <span id="eliminardetalletarjeta" class="badge bg-red" data-id="${articuloIdTarjeta}" style="padding: 7px">Eliminar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">USER:</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #686D76">${response.caja.user.name}</label>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">FECHA REGISTRO:</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #686D76">${formatearFecha(response.created_at)}</label>
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">ATRIBUTO:</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #686D76">${response.articulocaja.Nombre_Articulo}</label>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">DESCRIPCION:</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #686D76">${response.Articulo_description}</label>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">TIPO DE PROCESO:</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label">
                                            ${response.Ingreso > 0 ? '<span class="badge badge-outline text-green">Ingreso</span>' : '<span class="badge badge-outline text-red">Egreso</span>'}
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-4 col-form-label" style="font-weight: bold;">Monto:</label>
                                    <div class="col">
                                        <label class="col-8 col-form-label" style="color: #686D76">${response.Ingreso > 0 ? response.Ingreso : response.Egreso}</label>                                        
                                    </div>
                                </div>

                                ${tablaconsumos && tablaconsumos.length > 0 ? tablaconsumos : (tablahospedaje && tablahospedaje.length > 0 ? tablahospedaje : " ")}

                            </div>
                        </form>
                        `;
                        formTabsDiv.innerHTML = formHtml;

                        $(document).on('click', '#editardetalletarjeta', function() {
                            var id = $(this).data('id');
                            
                            $.ajax({
                                url: '/api/get-detalle-caja-select-edit/' + id,
                                method: 'GET',
                                success: function(data) {
                                    var formTabsDiv = document.getElementById('form_tabs');
                                    var formHtml = `
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label required">Selecciona ..</label>
                                                <select id="articuloCajaSelectUpdate" class="form-select" style="width: 100%;"></select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label required">Detalle</label>
                                                <textarea name="content" id="detalle" rows="4" class="form-control convertmayusculas">${data.Articulo_description}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">N Facturado / Recibo</label>
                                                <input type="text" id="facturarecibo" class="form-control onlynumber" value="${data.NFactura ? data.NFactura : ''}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label required">Tipo de proceso</label>
                                                <div class="btn-group w-100" role="group">
                                                    <input type="radio" class="btn-check" name="tipodeaccion" id="tipodeaccioningreso" autocomplete="off" value="Ingreso" ${data.Ingreso > 0 ? 'checked' : ''}>
                                                    <label for="tipodeaccioningreso" class="btn">Ingreso</label>
                                                    <input type="radio" class="btn-check" name="tipodeaccion" id="tipodeaccionegreso" autocomplete="off" value="Egreso" ${data.Egreso > 0 ? 'checked' : ''}>
                                                    <label for="tipodeaccionegreso" class="btn">Egreso</label>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label required">Monto</label>
                                                <input type="text" id="monto" class="form-control convert" value="${data.Ingreso > 0 ? data.Ingreso : data.Egreso}">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex" style="text-align: right">
                                                <button type="button" class="btn me-auto" id="btn-cancelar-update">CANCELAR</button>
                                                <button type="button" class="btn btn-primary" id="btn-update-detalle-tarjeta">GUARDAR</button>
                                            </div>
                                        </div>
                                    `;
                                    formTabsDiv.innerHTML = formHtml;

                                    cargarArticulosUpdate(data.articulocaja.id);
                                    transformInputsToUpperCaseAndValidateMonto()
                                    
                                    $('#btn-update-detalle-tarjeta').on('click', function(event) {
                                        event.preventDefault();
                                        var idCaja = {{ $idcaja }};
                                        var iddetalle = id;

                                        var formData = {
                                            articuloIdTarjeta: $('#articuloCajaSelectUpdate').val(),
                                            detalle: $('#detalle').val(),
                                            facturarecibo: $('#facturarecibo').val(),
                                            tipoDeAccion: $('input[name="tipodeaccion"]:checked').val(),                    
                                            monto: $('#monto').val(),
                                            idCaja: idCaja,
                                            iddetalle: iddetalle
                                        };

                                        $.ajax({
                                            url: '/api/actualizar-caja-tarjeta',
                                            method: 'POST',
                                            data: formData,
                                            success: function(response) {
                                                console.log("se actualizo RESTAURANTE")
                                                MostrarMensaje("Se actualizo RESTAURANTE Exitosamente","success");
                                                FiltrarDatosCajaTarjeta();
                                                CanvasTime();
                                            },
                                            error: function(error) {
                                                console.error('Error al guardar los datos:', error);
                                            }
                                        });
                                    });
                                    
                                    $('#btn-cancelar-update').on('click', function(event) {
                                        event.preventDefault();
                                        CanvasTime();
                                    });
                                },
                                error: function(xhr) {
                                    MostrarMensaje("No Puedes Editar, El registro no te pertenece","error");
                                    CanvasTime();
                                }
                            });
                        });

                        $(document).on('click', '#eliminardetalletarjeta', function() {
                            var id = $(this).data('id');
                            
                            $.ajax({
                                url: '/api/get-detalle-caja-select-edit/' + id,
                                method: 'GET',
                                success: function(data) {
                                    var formTabsDiv = document.getElementById('form_tabs');
                                    var formHtml = `
                                        <div class="card-header" style="background: rgb(24, 36, 51); color: white">
                                            <div class="row" style="width: 100%;">
                                                <div class="col-12 col-sm-8">
                                                    <h2 class="card-title">INFORMACION DETALLE</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Detalle por que va a eliminar</label>
                                                <textarea class="form-control convertmayusculas" id="ComentarioEliminado" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex" style="text-align: right">
                                                <button type="button" class="btn btn-primary" id="btn-eliminar-detalle-tarjeta">GUARDAR</button>
                                            </div>
                                        </div>
                                    `;
                                    formTabsDiv.innerHTML = formHtml;
                                    
                                    transformInputsToUpperCaseAndValidateMonto()

                                    $('#btn-eliminar-detalle-tarjeta').on('click', function(event) {
                                        event.preventDefault();
                                        var idCaja = {{ $idcaja }};
                                        var iddetalle = id;

                                        var formData = {
                                            ComentarioEliminado: $('#ComentarioEliminado').val(),
                                            idCaja: idCaja,
                                            iddetalle: iddetalle
                                        };

                                        $.ajax({
                                            url: '/api/eliminar-caja-tarjeta',
                                            method: 'POST',
                                            data: formData,
                                            success: function(response) {
                                                MostrarMensaje("Se elimino Exitosamente","success");
                                                FiltrarDatosCajaTarjeta();
                                                CanvasTime();
                                            },
                                            error: function(error) {
                                                console.error('Error al guardar los datos:', error);
                                            }
                                        });
                                    });
                                },
                                error: function(xhr) {
                                    MostrarMensaje("No Puedes Editar, El registro no te pertenece","error");
                                    CanvasTime();
                                }
                            });
                        });

                    },
                    error: function(xhr) {
                        MostrarMensaje("No Puedes Editar, El registro no te pertenece","error")
                        CanvasTime()
                    }
                });
            });
        }

        function FechaSelectCajaTarjeta() {
            var today = new Date();
            var currentDay = today.getDate();
            var currentMonth = today.getMonth();
            var currentYear = today.getFullYear();
            var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            $('#MesCajaTarjeta').empty();
            $('#AnioCajaTarjeta').empty();

            for (var month = 0; month < 12; month++) {
                $('#MesCajaTarjeta').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
            }
            $('#MesCajaTarjeta').val(currentMonth + 1);

            var startYear = currentYear - 6;
            var endYear = currentYear;
            for (var year = startYear; year <= endYear; year++) {
                $('#AnioCajaTarjeta').append('<option value="' + year + '">' + year + '</option>');
            }
            $('#AnioCajaTarjeta').val(currentYear);
            
            function updateDaySelectorNovedad() {
                var selectedMonth = parseInt($('#MesCajaTarjeta').val());
                var selectedYear = today.getFullYear();
                var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
                $('#DiaCajaTarjeta').empty();
                for (var day = 1; day <= daysInMonth; day++) {
                    $('#DiaCajaTarjeta').append('<option value="' + day + '">' + day + '</option>');
                }
                if (currentDay > daysInMonth) {
                    $('#DiaCajaTarjeta').val(daysInMonth);
                } else {
                    $('#DiaCajaTarjeta').val(currentDay);
                }
            }

            updateDaySelectorNovedad();

            $('#DateCajaTarjeta').on('change', function() {
                var selectedValue = $(this).val();
                switch (selectedValue) {
                    case 'DiarioCajaTarjeta':
                        $('#DiaCajaTarjetaContainer').show();
                        $('#AnioCajaTarjetaContainer').show();
                        $('#FechaInicioContainerCajaTarjeta').hide();
                        $('#FechaFinContainerCajaTarjeta').hide();
                        break;
                    case 'MensualidadCajaTarjeta':
                        $('#MesCajaTarjetaContainer').show();
                        $('#AnioCajaTarjetaContainer').show();
                        $('#DiaCajaTarjetaContainer').hide();
                        $('#FechaInicioContainerCajaTarjeta').hide();
                        $('#FechaFinContainerCajaTarjeta').hide();
                    break;
                    case 'RangoCajaTarjeta':
                        $('#DiaCajaTarjetaContainer').hide();
                        $('#MesCajaTarjetaContainer').hide();
                        $('#AnioCajaTarjetaContainer').hide();
                        $('#FechaInicioContainerCajaTarjeta').show();
                        $('#FechaFinContainerCajaTarjeta').show();
                    break;
                }
                FiltrarDatosCajaTarjeta();
            });


            $('#MesCajaTarjeta').on('change', function() {
                updateDaySelectorNovedad();
                FiltrarDatosCajaTarjeta();
            });

            $('#AnioCajaTarjeta').on('change', function() {
                FiltrarDatosCajaHostal();
            });
            
            $('#DiaCajaTarjeta').on('change', function() {
                FiltrarDatosCajaTarjeta();
            });

            $('#FechaInicioContainerCajaTarjeta').on('change', function() {
                FiltrarDatosCajaTarjeta();
            });

            $('#FechaFinContainerCajaTarjeta').on('change', function() {
                FiltrarDatosCajaTarjeta();
            });

            $('#DateCajaTarjeta').trigger('change');

        }

        function FiltrarDatosCajaTarjeta(){
            var today = new Date();
            var selectedYear = $('#AnioCajaTarjeta').val();
            var tipoFiltro = $('#DateCajaTarjeta').val();
            var dia = $('#DiaCajaTarjeta').val();
            var mes = $('#MesCajaTarjeta').val();
            var anio = selectedYear;
            var fechaInicio = $('#fechaInicioCajaTarjeta').val();
            var fechaFin = $('#fechaFinCajaTarjeta').val();
            var idCaja = {{ $idcaja }};

            $.ajax({
                url: '/api/filtrar-datos-caja-tarjeta',
                method: 'GET',
                data: {
                    tipoFiltro: tipoFiltro,
                    dia: dia,
                    mes: mes,
                    anio: anio,
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin,
                    idCaja: idCaja,
                },
                success: function(response) {
                    console.log(response)
                    MostrarCajaTarjeta(response)
                },
                error: function(error) {
                    console.error('Error al filtrar datos:', error);
                }
            });
        }

        function InputRangoFechasControl(){
            var today = new Date();
            var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            var formatDate = function(date) {
                var day = ('0' + date.getDate()).slice(-2);
                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                return date.getFullYear() + '-' + month + '-' + day;
            }
            var fechaInicioCajaTarjeta = document.getElementById('fechaInicioCajaTarjeta');
            var fechaFinCajaTarjeta = document.getElementById('fechaFinCajaTarjeta');
            fechaInicioCajaTarjeta.min = formatDate(firstDay);
            fechaInicioCajaTarjeta.max = formatDate(lastDay);
            fechaFinCajaTarjeta.min = formatDate(firstDay);
            fechaFinCajaTarjeta.max = formatDate(lastDay);
            fechaInicioCajaTarjeta.value = formatDate(today);
            fechaFinCajaTarjeta.value = formatDate(today);
        }
        
        function cargarArticulos() {
            // Inicializar Select2 con opciones
            $('#articuloCajaSelect').select2({
                placeholder: 'Selecciona un artículo',
                allowClear: true, // Cambiado a true para permitir limpiar la selección
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });

            // Hacer la petición AJAX para obtener los artículos
            $.ajax({
                url: '/api/get-articulos-caja',
                method: 'GET',
                success: function(response) {
                    // Limpiar el select
                    $('#articuloCajaSelect').empty();
                    $('#articuloCajaSelect').append('<option></option>'); // Opción vacía

                    // Añadir las nuevas opciones
                    response.forEach(function(item) {
                        $('#articuloCajaSelect').append(new Option(item.Nombre_Articulo + ' - ' + item.Codigo_caja, item.id));
                    });

                    // Actualizar Select2 para reflejar los cambios
                    $('#articuloCajaSelect').trigger('change');
                },
                error: function(error) {
                    console.error('Error al cargar los artículos:', error);
                }
            });
        }

        function cargarArticulosUpdate(selectedArticuloId){
            $('#articuloCajaSelectUpdate').select2({
                placeholder: 'Selecciona un artículo',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });

            // Hacer la petición AJAX para obtener los artículos
            $.ajax({
                url: '/api/get-articulos-caja',
                method: 'GET',
                success: function(response) {
                    // Limpiar el select
                    $('#articuloCajaSelectUpdate').empty();
                    $('#articuloCajaSelectUpdate').append('<option></option>'); // Opción vacía

                    // Añadir las nuevas opciones
                    response.forEach(function(item) {
                        $('#articuloCajaSelectUpdate').append(new Option(item.Nombre_Articulo + ' - ' + item.Codigo_caja, item.id));
                    });

                    // Establecer el valor seleccionado en el select2
                    if (selectedArticuloId) {
                        $('#articuloCajaSelectUpdate').val(selectedArticuloId).trigger('change');
                    }
                },
                error: function(error) {
                    console.error('Error al cargar los artículos:', error);
                }
            });
        }

        document.getElementById("btn-refrescar-tabla-tarjeta").addEventListener("click", function() {
            FechaSelectCajaTarjeta()
        });
    });
</script>