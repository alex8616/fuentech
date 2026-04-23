<div class="card-header" style="width: 100%; background-color: #1d2736">
    <div class="row" style="width: 100%;">
        <div class="col-12 col-sm-8">
            <h3 class="card-title" style="color: white; font-weight: bold;">HOSTAL</h3>
        </div>
        <div class="col-12 col-sm-4" style="text-align: right;">
            <button  id="addcajahostal" class="btn position-relative">
                Agregar
            </button>
            <button  id="cerrarcaja" class="btn position-relative" data-bs-toggle="modal" data-bs-target="#modal-cerrar-caja" style="background: #EF5A6F; color: white">
                Cerrar Caja
            </button>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="datagrid">
        <div class="datagrid-item">
            <div class="row">
                <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                    <div class="row" style="background: #F5F7F8;">
                        <div class="col-md-11">
                            <div class="row" style="padding-bottom: 10px">
                                <div class="col-md-3">
                                    <select name="DateCajaHostal" id="DateCajaHostal" class="form-control">
                                        <option value="DiarioCajaHostal">Diario</option>
                                        <option value="MensualidadCajaHostal">Todo El Mes</option>
                                        <option value="RangoCajaHostal">Rango</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="DiaCajaHostalContainer">
                                    <select name="DiaCajaHostal" id="DiaCajaHostal" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-3" id="MesCajaHostalContainer">
                                    <select name="MesCajaHostal" id="MesCajaHostal" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-3" id="AnioCajaHostalContainer">
                                    <select name="AnioCajaHostal" id="AnioCajaHostal" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-3" id="FechaInicioContainerCajaHostal">
                                    <input type="date" name="fechaInicioCajaHostal" id="fechaInicioCajaHostal" class="form-control">
                                </div>
                                <div class="col-md-3" id="FechaFinContainerCajaHostal">
                                    <input type="date" name="fechaFinCajaHostal" id="fechaFinCajaHostal" class="form-control">
                                </div><br><br><br>
                                <div class="col-md-11">
                                    <div class="input-group input-group-flat">
                                        <input type="text" name="searchcajahostal" id="searchcajahostal" class="form-control">
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
                                <span class="badge bg-blue" style="padding: 10px; width: 50%; cursor: pointer;" id="btn-refrescar-tabla-hostal">
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
                                            <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="IngresoHostal"></span>
                                        </span>
                                    </div>
                                    <div class="col-md-4" style="border-right: 2px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; padding: 10px">
                                        <span style="color: #7F8487;">EGRESO <br>
                                            <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="EgresoHostal"></span>
                                        </span>
                                    </div>
                                    <div class="col-md-4" style="border-bottom: 1px solid #E6E6E6; padding: 10px">
                                        <span style="color: #7F8487;">TOTAL <br>
                                            <span style="color: #2C3333; font-weight: bold; font-size: 22px" id="TotalHostal"></span>
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
                                    <table class="table table-vcenter card-table" id="tabla-caja-hostal">
                                        <thead style="position: sticky; top: 0; z-index: 1;">
                                            <tr>
                                            <th>N°</th>
                                            <th>Codigo</th>
                                            <th>Nombre Atributo</th>
                                            <th>Descripcion</th>
                                            <th>Fecha Registro</th>
                                            <th>Ingreso</th>
                                            <th>Egreso</th>
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

<div class="modal modal-blur fade" id="modal-cerrar-caja" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-danger"></div>
        <div class="modal-body text-center py-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
        <h3>Estas Seguro De Cerrar La Caja</h3>
        <div class="text-muted">. . .</div>
        </div>
        <div class="modal-footer">
        <div class="w-100">
            <div class="row">
                <div class="col">
                    <a href="#" class="btn w-100" data-bs-dismiss="modal">
                        Cancel
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="btn btn-danger w-100" id="btn-modal-cerrar" data-bs-dismiss="modal">
                        Cerrar Caja
                    </a>
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
        FechaSelectCajaHostal()
        InputRangoFechasControl()
        
        $('#searchcajahostal').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $("#tabla-caja-hostal tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $('.input-group-text a').on('click', function(e) {
            e.preventDefault();
            $('#searchcajahostal').val('');
        });

        $(document).ready(function() {
            $('#btn-modal-cerrar').on('click', function(event) {
                event.preventDefault();
                var idCaja = {{ $idcaja }};

                var formData = {
                    idCaja: idCaja
                };

                $.ajax({
                    url: '/api/cerrar-caja',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        MostrarMensaje("Registrado a Caja Hostal Exitosamente","success")
                        FiltrarDatosCajaHostal();
                    },
                    error: function(error) {
                        console.error('Error al guardar los datos:', error);
                    }
                });
            });
        });

        document.getElementById('addcajahostal').addEventListener('click', function() {
            cargarArticulos();

            var formTabsDiv = document.getElementById('form_tabs');
            var formHtml = `
            <form id="form-register-detalle-hostal">
                <div class="card-header" style="background: rgb(24, 36, 51); color: white">
                    <h2 class="card-title">HOSTAL</h2>
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
                            <input type="radio" class="btn-check" name="tipodeaccion" id="tipodeaccioningreso" autocomplete="off" value="Ingreso">
                            <label for="tipodeaccioningreso" class="btn">Ingreso</label>
                            <input type="radio" class="btn-check" name="tipodeaccion" id="tipodeaccionegreso" autocomplete="off" value="Egreso">
                            <label for="tipodeaccionegreso" class="btn">Egreso</label>
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
                        <button type="button" class="btn btn-primary" id="btn-registrar-detalle-hostal">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;
            formTabsDiv.innerHTML = formHtml;

            // Llama a la función para transformar textos a mayúsculas y validar el monto después de cargar el formulario
            transformInputsToUpperCaseAndValidateMonto();

            $('#btn-registrar-detalle-hostal').on('click', function(event) {
                event.preventDefault();
                var idCaja = {{ $idcaja }};

                var formData = {
                    articuloId: $('#articuloCajaSelect').val(),
                    detalle: $('#detalle').val(),
                    facturarecibo: $('#facturarecibo').val(),
                    tipoDeAccion: $('input[name="tipodeaccion"]:checked').val(),                    
                    monto: $('#monto').val(),
                    idCaja: idCaja
                };

                $.ajax({
                    url: '/api/registrar-detalle-hostal',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        MostrarMensaje("Registrado a Caja Hostal Exitosamente","success")
                        FiltrarDatosCajaHostal();
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


        function MostrarCajaHostal(response) {
            var tbody = $('#tabla-caja-hostal tbody');
            var formTabsDiv = $('#form_tabs');
            tbody.empty();
            $('#IngresoHostal').text(response.IngresoHostal);
            $('#EgresoHostal').text(response.EgresoHostal);
            $('#TotalHostal').text(response.TotalHostal);
            
            response.cajahostals.forEach(function(item, index) {
                if(item.Eliminado == "false"){
                    if (item.articulocaja.id != 200 ) {
                        if(item.Ingreso > 0){
                            var row = `
                                <tr class="clickable-row" data-id="${item.id}" style="border-left: 3px solid green">
                                    <td>${index + 1}</td>
                                    <td>${item.articulocaja.Codigo_caja}</td>
                                    <td>${item.codigocaja ? item.articulocaja.Nombre_Articulo : 'No disponible'}</td>
                                    <td>${item.Articulo_description}</td>
                                    <td>${formatearFecha(item.created_at)}</td>
                                    <td style="font-weight: ${item.Ingreso == 0 ? 'normal' : 'bold'}">${item.Ingreso}</td>
                                    <td style="font-weight: ${item.Egreso == 0 ? 'normal' : 'bold'}">${item.Egreso}</td>
                                    <td style="background: #40A2E3; color: white; font-weight: bold; text-align: center">${item.Sumatoria}</td>
                                </tr>
                            `;
                            tbody.append(row);
                        }else{
                            var row = `
                                <tr class="clickable-row" data-id="${item.id}" style="border-left: 3px solid red">
                                    <td>${index + 1}</td>
                                    <td>${item.articulocaja.Codigo_caja}</td>
                                    <td>${item.codigocaja ? item.articulocaja.Nombre_Articulo : 'No disponible'}</td>
                                    <td>${item.Articulo_description}</td>
                                    <td>${formatearFecha(item.created_at)}</td>
                                    <td style="font-weight: ${item.Ingreso == 0 ? 'normal' : 'bold'}">${item.Ingreso}</td>
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
                            <td style="text-decoration:line-through red; color: #686D76">${item.Egreso}</td>
                            <td style="text-decoration:line-through red; color: #686D76">${item.Sumatoria}</td>
                        </tr>
                    `;
                    tbody.append(row);
                }
            });

            // Agregar el evento de clic a las filas que cumplen la condición
            $('.clickable-row').on('click', function() {
                $('.clickable-row').removeClass('selected-row');
                $(this).addClass('selected-row');
                var articuloId = $(this).data('id');
                $.ajax({
                    url: '/api/get-detalle-caja-select/' + articuloId,
                    method: 'GET',
                    success: function(response) {
                        //codigo para cada caja dependiendo su valor
                        var HospedajeExiste = response.ServicioPrestado
                        let tablahospedaje = '';
                        let CabezeraHospedaje = '';
                       
                        if(HospedajeExiste != null){
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

                        var formTabsDiv = document.getElementById('form_tabs');
                        var formHtml = `
                        <form id="form-register-detalle-hostal">
                            <div class="card-header" style="background: rgb(24, 36, 51); color: white">
                                <div class="row" style="width: 100%;">
                                    <div class="col-12 col-sm-8">
                                        <h2 class="card-title">INFORMACION DETALLE</h2>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right;">
                                        <span id="editardetallehostal" class="badge bg-blue" data-id="${articuloId}" style="padding: 7px">Editar</span>
                                        <span id="eliminardetallehostal" class="badge bg-red" data-id="${articuloId}" style="padding: 7px">Eliminar</span>
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

                                ${ tablahospedaje }
                                 
                            </div>
                        </form>
                        `;
                        formTabsDiv.innerHTML = formHtml;

                        $(document).on('click', '#editardetallehostal', function() {
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
                                                <button type="button" class="btn btn-primary" id="btn-update-detalle-hostal">GUARDAR</button>
                                            </div>
                                        </div>
                                    `;
                                    formTabsDiv.innerHTML = formHtml;

                                    cargarArticulosUpdate(data.articulocaja.id);
                                    transformInputsToUpperCaseAndValidateMonto()
                                    
                                    $('#btn-update-detalle-hostal').on('click', function(event) {
                                        event.preventDefault();
                                        var idCaja = {{ $idcaja }};
                                        var iddetalle = id;

                                        var formData = {
                                            articuloId: $('#articuloCajaSelectUpdate').val(),
                                            detalle: $('#detalle').val(),
                                            facturarecibo: $('#facturarecibo').val(),
                                            tipoDeAccion: $('input[name="tipodeaccion"]:checked').val(),                    
                                            monto: $('#monto').val(),
                                            idCaja: idCaja,
                                            iddetalle: iddetalle
                                        };

                                        $.ajax({
                                            url: '/api/actualizar-caja-hostal',
                                            method: 'POST',
                                            data: formData,
                                            success: function(response) {
                                                console.log("se actualizo HOSTAL")
                                                MostrarMensaje("Se actualizo HOSTAL Exitosamente","success");
                                                FiltrarDatosCajaHostal();
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

                        $(document).on('click', '#eliminardetallehostal', function() {
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
                                                <button type="button" class="btn btn-primary" id="btn-eliminar-detalle-hostal">GUARDAR</button>
                                            </div>
                                        </div>
                                    `;
                                    formTabsDiv.innerHTML = formHtml;
                                    
                                    transformInputsToUpperCaseAndValidateMonto()

                                    $('#btn-eliminar-detalle-hostal').on('click', function(event) {
                                        event.preventDefault();
                                        var idCaja = {{ $idcaja }};
                                        var iddetalle = id;

                                        var formData = {
                                            ComentarioEliminado: $('#ComentarioEliminado').val(),
                                            idCaja: idCaja,
                                            iddetalle: iddetalle
                                        };

                                        $.ajax({
                                            url: '/api/eliminar-caja-hostal',
                                            method: 'POST',
                                            data: formData,
                                            success: function(response) {
                                                MostrarMensaje("Se elimino Exitosamente","success");
                                                FiltrarDatosCajaHostal();
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


        function FechaSelectCajaHostal() {
            var today = new Date();
            var currentDay = today.getDate();
            var currentMonth = today.getMonth();
            var currentYear = today.getFullYear();
            var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            $('#MesCajaHostal').empty();
            $('#AnioCajaHostal').empty();

            for (var month = 0; month < 12; month++) {
                $('#MesCajaHostal').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
            }
            $('#MesCajaHostal').val(currentMonth + 1);

            var startYear = currentYear - 6;
            var endYear = currentYear;
            for (var year = startYear; year <= endYear; year++) {
                $('#AnioCajaHostal').append('<option value="' + year + '">' + year + '</option>');
            }
            $('#AnioCajaHostal').val(currentYear);
            
            function updateDaySelectorNovedad() {
                var selectedMonth = parseInt($('#MesCajaHostal').val());
                var selectedYear = parseInt($('#AnioVenta').val());

                var selectedYear = today.getFullYear();
                var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
                $('#DiaCajaHostal').empty();
                for (var day = 1; day <= daysInMonth; day++) {
                    $('#DiaCajaHostal').append('<option value="' + day + '">' + day + '</option>');
                }
                if (currentDay > daysInMonth) {
                    $('#DiaCajaHostal').val(daysInMonth);
                } else {
                    $('#DiaCajaHostal').val(currentDay);
                }
            }

            updateDaySelectorNovedad();

            $('#DateCajaHostal').on('change', function() {
                var selectedValue = $(this).val();
                switch (selectedValue) {
                    case 'DiarioCajaHostal':
                        $('#DiaCajaHostalContainer').show();
                        $('#AnioCajaHostalContainer').show();
                        $('#FechaInicioContainerCajaHostal').hide();
                        $('#FechaFinContainerCajaHostal').hide();
                        break;
                    case 'MensualidadCajaHostal':
                        $('#MesCajaHostalContainer').show();
                        $('#AnioCajaHostalContainer').show();
                        $('#DiaCajaHostalContainer').hide();
                        $('#FechaInicioContainerCajaHostal').hide();
                        $('#FechaFinContainerCajaHostal').hide();
                    break;
                    case 'RangoCajaHostal':
                        $('#DiaCajaHostalContainer').hide();
                        $('#MesCajaHostalContainer').hide();
                        $('#AnioCajaHostalContainer').hide();
                        $('#FechaInicioContainerCajaHostal').show();
                        $('#FechaFinContainerCajaHostal').show();
                    break;
                }
                FiltrarDatosCajaHostal();
            });


            $('#MesCajaHostal').on('change', function() {
                updateDaySelectorNovedad();
                FiltrarDatosCajaHostal();
            });

            $('#AnioCajaHostal').on('change', function() {
                FiltrarDatosCajaHostal();
            });

            $('#DiaCajaHostal').on('change', function() {
                FiltrarDatosCajaHostal();
            });

            $('#FechaInicioContainerCajaHostal').on('change', function() {
                FiltrarDatosCajaHostal();
            });

            $('#FechaFinContainerCajaHostal').on('change', function() {
                FiltrarDatosCajaHostal();
            });

            $('#DateCajaHostal').trigger('change');

        }

        function FiltrarDatosCajaHostal(){
            var today = new Date();
            var selectedYear = $('#AnioCajaHostal').val();
            var tipoFiltro = $('#DateCajaHostal').val();
            var dia = $('#DiaCajaHostal').val();
            var mes = $('#MesCajaHostal').val();
            var anio = selectedYear;
            var fechaInicio = $('#fechaInicioCajaHostal').val();
            var fechaFin = $('#fechaFinCajaHostal').val();
            var idCaja = {{ $idcaja }};

            $.ajax({
                url: '/api/filtrar-datos-caja-hostal',
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
                    MostrarCajaHostal(response)
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
            var fechaInicioCajaHostal = document.getElementById('fechaInicioCajaHostal');
            var fechaFinCajaHostal = document.getElementById('fechaFinCajaHostal');
            fechaInicioCajaHostal.min = formatDate(firstDay);
            fechaInicioCajaHostal.max = formatDate(lastDay);
            fechaFinCajaHostal.min = formatDate(firstDay);
            fechaFinCajaHostal.max = formatDate(lastDay);
            fechaInicioCajaHostal.value = formatDate(today);
            fechaFinCajaHostal.value = formatDate(today);
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

        document.getElementById("btn-refrescar-tabla-hostal").addEventListener("click", function() {
            FechaSelectCajaHostal()
        });
    });
</script>