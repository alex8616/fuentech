<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card" style="background: white; width: 100%">
    <div class="card-header">
        <div class="row" style="width: 100%">
            <div class="col-12 col-sm-4">
                <span class="h3" id="CantidadHabText">Cantidad Huespedes </span>
            </div>
            <div class="col-12 col-sm-4">
                <span class="h3" id="CategoriaHabText"></span>
            </div>
            <div class="col-12 col-sm-4">
                <input type="text" id="SearchClienteFilter" placeholder="Buscar por cliente..." class="form-control"/>
                <ul id="resultados"></ul>
            </div>
        </div>
    </div>
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
            <a href="#tabs-habitaciones-date-1" class="nav-link active" data-bs-toggle="tab">Habitaciones</a>
            </li>
            <li class="nav-item">
            <a href="#tabs-salones-date-1" class="nav-link" data-bs-toggle="tab">Salones</a>
            </li>
            <li class="nav-item ms-auto">
                <div class="badges-list">
                    <span class="badge badge-outline text-blue" id="textMantenimiento" style="display: none; font-size: 15px">MANTENIMIENTO (<span style="font-size: 18px" id="HabMantenimientoCount"></span>)</span>
                    <span class="badge badge-outline text-red" id="textOcupado" style="display: none; font-size: 15px">OCUPADO (<span id="HabOcupadosCount" style="font-size: 18px"></span>)</span>
                    <span class="badge badge-outline text-orange" id="textLimpieza" style="display: none; font-size: 15px">LIMPIEZA (<span id="HabLimpiezaCount" style="font-size: 18px"></span>)</span>
                    <span class="badge badge-outline text-green" id="textLibre" style="display: none; font-size: 15px">LIBRE (<span id="HabLibreCount" style="font-size: 18px"></span>)</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" style="background: white">
            <div class="tab-pane active show" id="tabs-habitaciones-date-1" style="background: white; padding: 0px; margin: 0px">
                <div class="card-header" id="card-habitaciones" style="width: 100%; background-color: white; display: flex; flex-wrap: wrap; padding: 0px; margin: 0px">
                
                </div>
            </div>
            <div class="tab-pane" id="tabs-salones-date-1" style="background: white; padding: 0px; margin: 0px">
                <div class="card-header" id="card-salones" style="width: 100%; background-color: white; display: flex; flex-wrap: wrap; padding: 0px; margin: 0px">
                
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal agregar pasajeros -->
<div class="modal modal-blur fade" id="modalPasajeros" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">AGREGAR PASAJEROS</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordion-example">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false">
                            Subir Por Imagen
                        </button>
                        </h2>
                        <div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                        <div class="accordion-body pt-0">
                        <div class="row" style="padding: 10px">                   
                            <div class="col-lg-8">
                                <div class="mb-3">
                                        <input type="file" class="form-control" id="InputSubirImagen" name="image">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <a href="#" class="form-control btn btn-primary ms-auto" id="btn-sacar-datos-imagen">
                                            Sacar Datos
                                        </a>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">CI - PASSAPORTE</label>
                                        <input type="text" class="form-control convertmayusculas" id="ObtenidoNDocumento">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nombres</label>
                                        <input type="text" class="form-control convertmayusculas" id="ObtenidoNombres">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Apellidos</label>
                                        <input type="text" class="form-control convertmayusculas" id="ObtenidoApellidos">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nacionalidad</label>
                                        <input type="text" class="form-control convertmayusculas" id="ObtenidoNacionalidad">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Profesion</label>
                                        <input type="text" class="form-control convertmayusculas" id="ObtenidoProfesion">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Fecha Nacimiento</label>
                                        <input type="date" class="form-control convertmayusculas" id="ObtenidoFechaNacimiento">
                                        <input type="text" class="form-control convertmayusculas" id="ObtenidoEdad">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <button href="#" class="form-control btn btn-primary ms-auto" id="btn-registrar-por-IA" disabled>
                                            REGISTRAR
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>    
                        </div>
                    </div>
                </div>

                <div class="row" style="padding: 10px">                   

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">CI - PASSAPORTE</label>
                            <input type="text" class="form-control convertmayusculas" id="InputCiPassaporte">
                            <ul id="suggestions-list" class="list-group" style="background: white; color: black; display: none; position: absolute; z-index: 1;"></ul>
                        </div>
                    </div>
                    <div class="col-lg-4 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label">Nombres</label>
                            <input type="text" class="form-control convertmayusculas" id="InputNombres">
                        </div>
                    </div>
                    <div class="col-lg-4 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label">Apellidos</label>
                            <input type="text" class="form-control convertmayusculas" id="InputApellidos">
                        </div>
                    </div>
                    <div class="col-lg-4 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label">Profesion</label>
                            <input type="text" class="form-control convertmayusculas" id="InputProfesion">
                        </div>
                    </div>
                    <div class="col-lg-4 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label">Nacionalidad</label>
                            <select class="form-control" id="InputNacionalidad">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label">Estado Civil</label>
                            <select class="form-control" id="InputEstadoCivil">
                                <option value="Soltero(a)">Soltero(a)</option>
                                <option value="Casado(a)">Casado(a)</option>
                                <option value="Viudo(a)">Viudo(a)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label">Fecha Nacimiento</label>
                            <input type="date" class="form-control" id="InputFechaNacimiento" onchange="calcularEdad()">
                        </div>
                    </div>
                    <div class="col-lg-2 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label">Edad</label>
                            <input type="text" class="form-control" id="InputEdad" readonly>
                        </div>
                    </div>
                    <div class="col-lg-5 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label">Imagen Documento</label>
                            <input type="file" class="form-control" id="InputImagenPassaporte">
                        </div>
                    </div>
                    <div class="col-lg-2 formulario d-none" style="background: #FEF9D9; padding: 6px">
                        <div class="mb-3">
                            <label class="form-label"><br></label>
                            <a href="#" class="btn btn-success ms-auto" id="btn-agregar-pasajero">
                                Agregar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table" id="table-pasajeros-temporal">
                                <thead>
                                    <tr>
                                    <th>Documento</th>
                                    <th>Nombre Completo</th>
                                    <th>Nacionalidad</th>
                                    <th>Profesion</th>
                                    <th>Edad</th>
                                    <th>Estado</th>
                                    <th></th>
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
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <a href="#" class="btn btn-primary ms-auto" id="btn-agregar-hospedaje" data-bs-dismiss="modal">
                    Registrar al hospedaje
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="Modal-Pagar-Desayuno" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title">Pagar El Servicio</div>
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="ModalLavadoTipoPagoSelect">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" data-bs-dismiss="modal" id="btn-confirmar-modal-desayuno">Si, Enviar EL Pago</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="Modal-Pagar-Lavado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title">Pagar El Servicio</div>
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="ModalDesayunoTipoPagoSelect">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" data-bs-dismiss="modal" id="btn-confirmar-modal-lavado">Si, Enviar EL Pago</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="ModalCerrarConsumoHabitacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title">Pagar El Consumo</div>
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="ModalConsumoTipoPagoSelect">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" data-bs-dismiss="modal" id="btn-confirmar-modal-consumo">Si, Enviar EL Pago</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="ElminarDetalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Detalle Del Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <input type="text" class="form-control" id="detalleIdInput" hidden>
                <div class="mb-3">
                    <label class="form-label">¿Seguro desea cancelar este detalle del Pedido?<span class="form-label-description">56/100</span></label>
                    <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Comentario.." id="TextComentario"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="CancelarDetalle">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modaldetallehospedaje" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">AGREGAR DETALLE</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 10px">
                    <div class="col-12 col-sm-4">
                        <div class="mb-3">
                            <div>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="radios-inline" id="radio-auto" value="auto">
                                    <span class="form-check-label">Mobilidad</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="radios-inline" id="radio-prestamo" value="prestamo">
                                    <span class="form-check-label">Detalle Prestamo</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-8">
                        <div class="mb-3" id="form-div-auto" hidden>
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <div class="mb-3">
                                        <label class="form-label">Placa</label>
                                        <input type="text" class="form-control convertmayusculas" id="PlacaAuto">
                                    </div>
                                </div>                               
                                <div class="col-12 col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Color</label>
                                        <input type="color" class="form-control form-control-color" id="ColorAuto">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">comentario</label>
                                        <textarea class="form-control convertmayusculas" id="ComentarioAuto"></textarea>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="mb-3" id="form-div-prestamo" hidden>
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre Objeto</label>
                                        <input type="text" class="form-control convertmayusculas" id="NombreObjetoPrestamo">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">comentario</label>
                                        <textarea class="form-control convertmayusculas" id="ComentarioPrestamo"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancelar
                </a>
                <a href="#" class="btn btn-primary ms-auto" id="btn-agregar-detalle" data-bs-dismiss="modal">
                    Registrar al hospedaje
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-concluir-hospedaje" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Concluir Hospedaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-5">
                    <div class="card">
                        <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                            <h3 class="card-title">DETALLE HOSPEDAJE</h3>
                        </div>
                        <div class="card-body" style="margin: 4px; padding: 4px;">
                            <div id="MostradorListPagos">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                            <h3 class="card-title" style="margin: 0;">PAGO</h3>
                            <button id="MostradoraddPagos" class="btn btn-danger">+</button>
                        </div>
                        <div id="ListPagos" class="card-body" style="padding: 0px; margin: 0px">
                            
                        </div>
                        <div class="card-header" style="background: #1b293a; color: white; width: 100%; padding: 10px;">
                            <div id="MostradorlistVuelto">
                            
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btnConfirmarPago">Save changes</button>
        </div>
    </div>
    </div>
</div>


<div class="modal modal-blur fade" id="modal-adelanto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Registrar Adelanto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-5">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="TipoAdelanto">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-2">
                    <div class="mb-3">
                        <label class="form-label">Moneda</label>
                        <select class="form-control moneda" id="TipoMoneda">
                            <option value="Bs">Bs.</option>
                            <option value="Dolar">$</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-5">
                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input class="form-control" id="MontoAdelanto">
                    </div>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btn-registrar-modal-adelanto" data-bs-dismiss="modal">Registrar Adelanto</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-adelanto-grupo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Registrar Adelanto Del Grupo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-5">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="TipoAdelantoGrupo">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-2">
                    <div class="mb-3">
                        <label class="form-label">Moneda</label>
                        <select class="form-control moneda" id="TipoMonedaAdelantoGrupo">
                            <option value="Bs">Bs.</option>
                            <option value="Dolar">$</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-5">
                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input class="form-control" id="MontoAdelantoGrupo">
                    </div>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btn-registrar-modal-adelanto-grupo" data-bs-dismiss="modal">Registrar Adelanto</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-finalizar-grupo-hospedaje" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Concluir Hospedaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-5">
                    <div class="card">
                        <div class="card-header" style="background: #1b293a; color: white; width: 100%;  padding: 5px; margin: 1px">
                            <h3 class="card-title">DETALLE HOSPEDAJE</h3>
                        </div>
                        <div class="card-body" style="margin: 4px; padding: 4px;">
                            <div id="MostradorListPagosGrupo">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                            <h3 class="card-title" style="margin: 0;">PAGO</h3>
                            <button id="MostradoraddPagosGrupo" class="btn btn-danger">+</button>
                        </div>
                        <div id="ListPagosGrupo" class="card-body" style="padding: 0px; margin: 0px">
                            
                        </div>
                        <div class="card-header" style="background: #1b293a; color: white; width: 100%; padding: 10px;">
                            <div id="MostradorlistVueltoGrupo">
                            
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btnConfirmarPagoGrupo">Save changes</button>
        </div>
    </div>
    </div>
</div>

<!-- DATOS PARA EL ARCHIVO OCUPADORESERVASALON.JS-->
<div class="modal modal-blur fade" id="modal-adelanto-reserva-salon-ocupado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Registrar Adelanto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="TipoAdelanto-salon-ocupado">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label">Monto</label>
                        <input class="form-control" id="MontoAdelanto-salon-ocupado">
                    </div>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btn-registrar-modal-adelanto-reserva-salon-ocupado" data-bs-dismiss="modal">Registrar Adelanto</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="Modal-Cerrar-Consumo-Reserva-Salon-Ocupado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-title">Pagar El Consumo</div>
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label">Tipo De Pago</label>
                        <select class="form-control" id="ModalConsumoTipoPagoSelect-ocupado">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Deposito/QR">Deposito/QR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" data-bs-dismiss="modal" id="btn-confirmar-modal-consumo-reserva-salon-ocupado">Si, Enviar EL Pago</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-dar-baja-reserva-salon-ocupado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Adelanto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="form-container">
                    <!-- Formulario principal que siempre estará visible -->
                    <div class="row" id="main-form">
                        <div class="col-12 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label" style="color: red; font-size: 13px">*NOTA EL REGISTRO SE MANDARA A CAJA AUTOMATICAMENTE*</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="mb-3">
                                <label class="form-label">Tipo De Pago</label>
                                <select class="form-control" id="TipoAdelanto-salon-dar-baja">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Deposito/QR">Deposito/QR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="mb-3">
                                <label class="form-label">Monto</label>
                                <input class="form-control" id="MontoAdelanto-salon-dar-baja">
                            </div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <div class="mb-3">
                                <label class="form-label"></label>
                                <button type="button" class="btn btn-secondary mt-3" id="add-form" style="width: 70%">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background: #151f2c; color: white">
                    <div class="row" style="padding: 10px; margin: 10px">
                        <div class="col-12 col-sm-6">
                            <span style="font-size: 16px; font-weight: bold">Cambios: </span>
                        </div>
                        <div class="col-12 col-sm-6">
                            <span style="font-size: 16px; font-weight: bold" id="idtextcambio">0.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-registrar-modal-dar-baja-reserva-salon-ocupado" data-bs-dismiss="modal">Registrar Adelanto</button>
            </div>
        </div>
    </div>
</div>

<!-- DATOS IMPRESION INFORMACION-->
<div class="modal modal-blur fade" id="modalImprimirInformacionHospedaje" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Imprimir Boucher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modalImprimirServiciosHospedaje" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Imprimir Servicios</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modalImprimirConsumosHospedaje" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Imprimir Consumos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modalBtnImprimirServicioDesayuno" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Imprimir Servicio Desayuno</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
    </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modalBtnImprimirConsumo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Imprimir Servicio Desayuno</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
    </div>
    </div>
</div>

<!-- Modal -->
<div class="modal modal-blur fade" id="modalJsonGrupo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Imprimir Boucher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
    </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script src="{{ asset('utilidades/js/hostal/sacarinformacionpasajero.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/hospedajehabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/ocupadohabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/OcupadoReservaSalon.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/hospedajelimpieza.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/hospedajesucio.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/ocupadohabitaciongrupo.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/GrupoInformacionHabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/hospedajemantenimiento.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/cambiarhabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/InputClass.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
    #resultados {
        list-style-type: none;
        padding: 0;
        margin: 0;
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    #resultados li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        font-size: 16px;
        color: #333;
        cursor: pointer;
    }

    #resultados li:last-child {
        border-bottom: none;
    }

    #resultados li:hover {
        background-color: #f1f1f1;
        color: #000;
    }

    #resultados li.no-result {
        color: #888;
        font-style: italic;
        text-align: center;
        padding: 15px 0;
    }



    #habitacion-disponible{
        border: 2px solid green;
        box-shadow: 0 0 15px 5px rgba(0, 255, 0, 0.7);
        transition: box-shadow 0.3s ease-in-out;
    }

    #habitacion-disponible:hover {
        box-shadow: 0 0 25px 10px rgba(0, 255, 0, 1);
    }

    #habitacion-ocupado{
        border: 2px solid green; 
        box-shadow: 0 0 15px 5px rgba(255, 0, 0);
        transition: box-shadow 0.3s ease-in-out;
    }

    #habitacion-ocupado:hover {
        box-shadow: 0 0 25px 10px rgba(255, 0, 1);
    }

    #habitacion-limpieza{
        border: 2px solid green; 
        box-shadow: 0 0 15px 5px rgba(255, 102, 0);
        transition: box-shadow 0.3s ease-in-out;
    }

    #habitacion-limpieza:hover {
        box-shadow: 0 0 25px 10px rgba(255, 102, 1);
    }

    #habitacion-mantenimiento{
        border: 2px solid green; 
        box-shadow: 0 0 15px 5px rgba(65, 116, 255);
        transition: box-shadow 0.3s ease-in-out;
    }

    #habitacion-mantenimiento:hover {
        box-shadow: 0 0 25px 10px rgba(65, 116, 255);
    }

    #habitacion-grupo{
        border: 6px solid brown; 
        box-shadow: 0 0 25px 40px rgb(67, 0, 0);
        transition: box-shadow 0.9s ease-in-out;
    }

    #habitacion-grupo:hover {
        box-shadow: 0 0 25px 10px rgb(67, 0, 0);
    }

    .contenedor {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .elemento {
        flex: 0 0 calc(33.33% - 3px);
        margin-bottom: 3px;
        margin-right: 3px;
        background-color: #EEEEEE;
        padding: 5px;
        box-sizing: border-box;
        border: 1px solid #B2B2B2;
    }

    .elemento:last-child {
        margin-right: 0;
    }


    .autocomplete-bold {
        font-weight: bold;
    }

    .ui-autocomplete {
        position: absolute; 
        cursor: default; 
        border: 1px solid #ccc;
        background-color: #fff;
    }

    .ui-menu-item {
        padding: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        list-style: none;
        margin-left: -25px;
    }

    .ui-menu-item:hover {
        background-color: #f0f0f0;
    }

    [role="status"] {
        display: none !important;
    }

    #CardOcupado{
        background-color: #ffffff;
        opacity: 0.6;
        background-size: 9px 9px;
        background-image: repeating-linear-gradient(45deg, #ff0000 0, #ff0000 0.8px, #ffffff 0, #ffffff 50%);
    }
    #productoDiv{
        background-color: #ffffff;
        opacity: 0.6;
        background-size: 9px 9px;
        background-image: repeating-linear-gradient(45deg, #ff0000 0, #ff0000 0.8px, #ffffff 0, #ffffff 50%);
    }
    .toastify {
        background: #2ecc71;
        color: #fff;
        font-family: 'Arial', sans-serif;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .toastify-error {
        background: #e74c3c;
        color: #fff;
        font-family: 'Arial', sans-serif;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }   

    #tabla-productos .producto-fila:hover {
        background-color: #D5DAEB;
    }
    #tabla-productos .producto-fila.selected {
        background-color: #D5DAEB;
    }
    .selected {
        background-color: #B0DAFF;
    }
    .selectedEnviar {
        background-color: #FFFAE6;
    }
    .star-label {
        cursor: pointer;
    }
    #checkbox-1:checked + .star-label .icon-1 {
        color: gold;
    }

    .mesa {
        margin: 5px;
        padding-top: 0;
        padding-bottom: 0;
        position: relative;
        aspect-ratio: 1;
    }

    .mesa a{
        width: 100%;
        height: 100%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .mesa a.selected-btn {
        border: 10px solid #206bc4 !important;
        box-sizing: border-box !important;
        width: 100% !important;
        margin: 0px !important;
    }

    @media only screen and (max-width: 500px) {
        .mesa a{
            width: 130% !important;
            height: 130% !important;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
        }

        #EditAmbiente{
            display: none;
        }

        .mesa a.selected-btn {
            border: 8px solid #206bc4 !important;
            font-size: 14px !important;
            height: 182% !important;
        }
    }

    @media (min-width:767 and max-width: 768px) {
        .mesa a{
            width: 100% !important;
            height: 100% !important;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
        }

        .mesa a.selected-btn {
            border: 8px solid #206bc4 !important;
            font-size: 14px !important;
            height: 100% !important;
        }
    }


    .editmesa.selected-table {
        background-color: #ffcc00;
    }


    .editmesa {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 80px;
        border: 2px solid #ddd; /* Border color for tables */
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .editmesa.selected-table {
        background-color: #ff7b7b; /* Background color for selected table */
        color: #fff; /* Text color for selected table */
        border-color: #ff7b7b; /* Border color for selected table */
    }

    .BtnMover {
        display: block;
        width: 100%;
        height: 100%;
    }

    .BtnMover svg {
        width: 24px;
        height: 24px;
        fill: #333; /* Icon color */
    }

    .row {
        display: flex;
    }

    #div-editar {
        max-width: 600px;
        margin: 0 auto;
    }

    #MostradorTableCurso tbody tr.selected {
        background-color: #ffeeba;
        color: #212529;
    }

    #MostradorTableCerrado tbody tr.selected {
        background-color: #ffeeba;
        color: #212529;
    }

    #DeliveyPreparacion tbody tr.selected {
        background-color: #FFE3BB;
        color: #212529;
    }

    .select2-container {
        z-index: 9999 !important;
    }

</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputFecha = document.getElementById("InputFechaNacimiento");
        const inputEdad = document.getElementById("InputEdad");

        if (inputFecha && inputEdad) {
            inputFecha.addEventListener("change", function () {
                const fechaNacimiento = inputFecha.value;
                if (!fechaNacimiento) {
                    inputEdad.value = '';
                    return;
                }

                const fechaNacimientoDate = new Date(fechaNacimiento);
                const hoy = new Date();

                let edad = hoy.getFullYear() - fechaNacimientoDate.getFullYear();
                const mes = hoy.getMonth() - fechaNacimientoDate.getMonth();
                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimientoDate.getDate())) {
                    edad--;
                }

                inputEdad.value = edad;
            });
        } else {
            console.warn("No se encontró el input de fecha o edad");
        }
    });
</script>

<script>
    $(document).ajaxStart(function() {
        mostrarCargandoDatos();
    });

    $(document).ajaxStop(function() {
        ocultarCargandoDatos();
    });

    $(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
        ocultarCargandoDatos();
        if (!navigator.onLine) {
            mostrarMensajeSinConexion();
        } else {
            console.error("Error:", thrownError);
        }
    });

    window.addEventListener('offline', function() {
        mostrarMensajeSinConexion();
    });

    window.addEventListener('online', function() {
        ocultarMensajeSinConexion();
    });


    $(document).ready(function() { 
        MostrarHabitaciones();
        MostrarAmbientes();
        convertirMayusculas();
        TraerPaisesNacionalidad();
    });

    function MostrarHabitaciones() {
        $.ajax({
            url: '/apihostal/get-grupos-habitaciones',
            method: 'GET',
            dataType: 'json',
            success: function(grupos) {
                $('#card-habitaciones').empty();                          

                grupos.forEach(function(grupo) {
                    var habitacionCard = `
                        <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                            <div class="card" id="habitacion-grupo" style="border: 2px solid brown; box-shadow: 0 0 8px 3px rgb(67, 0, 0);">
                                <div class="card-header">
                                    <h3 class="card-title">${grupo.CodigoHospedaje}</h3>                                        
                                </div>
                                <div class="card-cover text-center" style="position: relative; width: 100%; height: 176px; margin: 0; padding: 0;">
                                    <div class="image-blurred" style="background-image: url(./imagenes/hostal/DSC_0381.jpeg); width: 100%; height: 100%; background-size: cover; filter: blur(5px); margin: 0; padding: 0;"></div>
                                    <div class="icon-overlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                        <svg height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-66.56 -66.56 645.12 645.12" xml:space="preserve" fill="#ffffff" stroke="#ffffff" stroke-width="21.503999999999998"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <circle style="fill:#ff0000;" cx="254.956" cy="104.911" r="42.301"></circle> <path style="fill:#ff0000;" d="M327.928,240.998V203.55c0-39.424-43.024-40.144-43.024-40.144h-59.896 c0,0-43.024,0.48-43.024,40.144v37.448H327.928z"></path> <circle style="fill:#ff0000;" cx="439.026" cy="104.911" r="42.301"></circle> <path style="fill:#ff0000;" d="M512,240.998V203.55c0-39.424-43.024-40.144-43.024-40.144H409.08c0,0-43.024,0.48-43.024,40.144 v37.448H512z"></path> </g> <g> <circle style="fill:#ff0000;" cx="72.973" cy="104.911" r="42.301"></circle> <path style="fill:#ff0000;" d="M145.952,240.998V203.55c0-39.424-43.024-40.144-43.024-40.144H43.024 c0,0-43.024,0.48-43.024,40.144v37.448H145.952z"></path> </g> <g> <circle style="fill:#ff0000;" cx="254.956" cy="313.303" r="42.301"></circle> <path style="fill:#ff0000;" d="M327.928,449.389v-37.447c0-39.424-43.024-40.144-43.024-40.144h-59.896 c0,0-43.024,0.48-43.024,40.144v37.448L327.928,449.389L327.928,449.389z"></path> <circle style="fill:#ff0000;" cx="72.973" cy="313.303" r="42.301"></circle> <path style="fill:#ff0000;" d="M145.952,449.389v-37.447c0-39.424-43.024-40.144-43.024-40.144H43.024 c0,0-43.024,0.48-43.024,40.144v37.448L145.952,449.389L145.952,449.389z"></path> <circle style="fill:#ff0000;" cx="439.026" cy="310.776" r="42.301"></circle> <path style="fill:#ff0000;" d="M512,446.878v-37.448c0-39.424-43.024-40.144-43.024-40.144H409.08c0,0-43.024,0.48-43.024,40.144 v37.448H512L512,446.878z"></path> </g> </g></svg>
                                    </div>
                                </div>
                                <div class="card-body" style="text-align: center; background: #74512D; color: white; font-weight: bold;">
                                    <span>${grupo.TourName}</span>
                                </div>                                    
                                <div class="d-flex">
                                    <a href="#" class="card-btn" onclick="GrupoInformacionHabitacion(${grupo.id})">
                                        INGRESAR
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('#card-habitaciones').append(habitacionCard);
                });

                
                $.ajax({
                    url: '/apihostal/get-habitaciones',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        response.habitaciones.forEach(function(habitacion) {
                            var habitacionCard = '';
                            var vardategrupo = '';

                            if (habitacion.Estado_habitacion === "GRUPO") {
                                let vardategrupo = ''; 

                                if (habitacion.hospedajehabitacion[0].GuiaTuristica == "true") {
                                    console.log("Guía Turística encontrada para la habitación " + habitacion.id);
                                    vardategrupo = `
                                        <h1 style="color: red; font-weight: bold; font-size: 19px; padding: 8px; text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff; position: relative; z-index: 9999;">
                                            GUIA DEL GRUPO
                                        </h1>
                                    `;
                                }

                                habitacionCard = `
                                    <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                        <div class="card" id="habitacion-grupo" style="border: 2px solid brown; box-shadow: 0 0 8px 3px rgb(67, 0, 0);">
                                            <div class="card-header">
                                                <h3 class="card-title">HABITACION</h3>
                                                <div class="card-actions btn-actions">
                                                    <div class="ribbon ribbon-top ribbon-bookmark bg-red" style="padding-left: 10px; padding-right: 10px;">
                                                        <h1>${habitacion.id}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-cover text-center" style="position: relative; width: 100%; height: 176px; margin: 0; padding: 0;" id="div-habitaciones-grupo-card">
                                                ${vardategrupo} <!-- Esto ahora solo se muestra si cumple la condición -->
                                                <div class="image-blurred" style="background-image: url(./imagenes/hostal/DSC_0381.jpeg); width: 100%; height: 100%; background-size: cover; filter: blur(5px); margin: 0; padding: 0;"></div>
                                                <div class="icon-overlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <svg height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-307.2 -307.2 1126.40 1126.40" xml:space="preserve" fill="#ffffff" stroke="#ffffff" stroke-width="0.00512"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#FFFFFF;" d="M256,503.999C119.034,503.999,8.001,392.966,8.001,256S119.033,8,256,8 s247.999,111.033,247.999,247.999C503.849,392.904,392.904,503.849,256,503.999z"></path> <path style="fill:#ff0000;" d="M256,16c132.549,0,240,107.451,240,240S388.549,496,256,496S16,388.549,16,256 C16.15,123.514,123.514,16.15,256,16 M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.384,0,256,0z"></path> <circle style="fill:#ff0000;" cx="255.989" cy="162.237" r="68.924"></circle> <path style="fill:#E21B1B;" d="M374.895,384v-61.032c0-64.224-70.104-65.4-70.104-65.4H207.2c0,0-70.104,0.8-70.104,65.4V384 H374.895z"></path> </g></svg>
                                                </div>
                                            </div>
                                            <div class="card-body" style="text-align: center; background: #74512D; color: white; font-weight: bold;">
                                                <span>${habitacion.Estado_habitacion}</span>
                                            </div>                                    
                                            <div class="d-flex">    
                                                <a href="#" class="card-btn" onclick="OcupadoHabitacionGrupo(${habitacion.id})">
                                                    Ver Habitacion
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            } else if (habitacion.Estado_habitacion === "DISPONIBLE") {
                                habitacionCard = `
                                    <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                        <div class="card" id="habitacion-disponible" style="border: 2px solid green; box-shadow: 0 0 8px 3px rgba(0, 255, 0, 0.7);">
                                            <div class="card-header">
                                                <h3 class="card-title">HABITACION</h3>
                                                <div class="card-actions btn-actions">
                                                    <div class="ribbon ribbon-top ribbon-bookmark bg-green" style="padding-left: 10px; padding-right: 10px;">
                                                        <h1>${habitacion.id}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="img-responsive img-responsive-18x9 card-img-top" style="background-image: url(./imagenes/hostal/DSC_0381.jpeg)"></div>
                                            <div class="card-body" style="text-align: center; background: #ebf6ed">
                                                <span class="badge bg-green-lt" style="font-size: 15px; text-align: center">${habitacion.Estado_habitacion}</span>
                                            </div>
                                            <div class="d-flex">    
                                                <a href="#" class="card-btn" onclick="hospedarHabitacion(${habitacion.id})">
                                                    HOSPEDAR
                                                </a>
                                                <div class="dropdown ms-2">
                                                    <a href="#" class="card-btn" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <svg fill="#386aff" width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" stroke="#386aff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M10 1L5 8h10l-5-7zm0 18l5-7H5l5 7z"></path></g></svg>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item" onclick="manejarMantenimiento(${habitacion.id})">Mantenimiento</a></li>
                                                        <li><a class="dropdown-item" id="btn-manejar-evento-sucio" onclick="manejarSucio(${habitacion.id})">Sucio</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            } else if (habitacion.Estado_habitacion === "OCUPADO") {
                                habitacionCard = `
                                    <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                        <div class="card" id="habitacion-ocupado" style="border: 2px solid red; box-shadow: 0 0 8px 3px rgba(255, 0, 0.0);">
                                            <div class="card-header">
                                                <h3 class="card-title">HABITACION</h3>
                                                <div class="card-actions btn-actions">
                                                    <div class="ribbon ribbon-top ribbon-bookmark bg-red" style="padding-left: 10px; padding-right: 10px;">
                                                        <h1>${habitacion.id}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-cover text-center" style="position: relative; width: 100%; height: 176px; margin: 0; padding: 0;">
                                                <div class="image-blurred" style="background-image: url(./imagenes/hostal/DSC_0381.jpeg); width: 100%; height: 100%; background-size: cover; filter: blur(5px); margin: 0; padding: 0;"></div>
                                                <div class="icon-overlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <svg fill="rgba(255, 0, 0.0)" width="150px" height="150px" viewBox="-10 -10 70.00 70.00" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="rgba(255, 0, 0.0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#ffffff" stroke-width="4.7"><path d="M3 9C1.3545455 9 0 10.354545 0 12L0 42L6 42L6 37L44 37L44 42L50 42L50 28L50 23C50 20.254545 47.745455 18 45 18L19 18 A 1.0001 1.0001 0 0 0 18 19L18 28L12 28L6 28L6 12C6 10.354545 4.6454545 9 3 9 z M 12 28C14.749579 28 17 25.749579 17 23C17 20.250421 14.749579 18 12 18C9.2504209 18 7 20.250421 7 23C7 25.749579 9.2504209 28 12 28 z M 12 20C13.668699 20 15 21.331301 15 23C15 24.668699 13.668699 26 12 26C10.331301 26 9 24.668699 9 23C9 21.331301 10.331301 20 12 20 z M 20 20L45 20C46.654545 20 48 21.345455 48 23L48 28L20 28L20 20 z"></path></g><g id="SVGRepo_iconCarrier"><path d="M3 9C1.3545455 9 0 10.354545 0 12L0 42L6 42L6 37L44 37L44 42L50 42L50 28L50 23C50 20.254545 47.745455 18 45 18L19 18 A 1.0001 1.0001 0 0 0 18 19L18 28L12 28L6 28L6 12C6 10.354545 4.6454545 9 3 9 z M 12 28C14.749579 28 17 25.749579 17 23C17 20.250421 14.749579 18 12 18C9.2504209 18 7 20.250421 7 23C7 25.749579 9.2504209 28 12 28 z M 12 20C13.668699 20 15 21.331301 15 23C15 24.668699 13.668699 26 12 26C10.331301 26 9 24.668699 9 23C9 21.331301 10.331301 20 12 20 z M 20 20L45 20C46.654545 20 48 21.345455 48 23L48 28L20 28L20 20 z"></path></g></svg>    
                                                </div>
                                            </div>
                                            <div class="card-body" style="background: #faeaeb; text-align: center">
                                                <span class="badge bg-red text-red-fg" style="font-size: 17px">OCUPADA</span>
                                            </div>
                                            <div class="d-flex">    
                                                <a href="#" class="card-btn" onclick="OcupadoHabitacion(${habitacion.id})">
                                                    INGRESAR
                                                </a>
                                                <div class="dropdown ms-2">
                                                    <a href="#" class="card-btn" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <svg fill="#386aff" width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" stroke="#386aff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M10 1L5 8h10l-5-7zm0 18l5-7H5l5 7z"></path></g></svg>                                            </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li><a class="dropdown-item" href="#" onclick="manejarcambiarhab(${habitacion.id})">CAMBIAR HABITACION</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            } else if (habitacion.Estado_habitacion === "LIMPIEZA") {
                                habitacionCard = `
                                    <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                        <div class="card" id="habitacion-limpieza" style="border: 2px solid orange; box-shadow: 0 0 8px 3px rgba(255, 102, 0);">
                                            <div class="card-header">
                                                <h3 class="card-title">HABITACION</h3>
                                                <div class="card-actions btn-actions">
                                                    <div class="ribbon ribbon-top ribbon-bookmark bg-yellow" style="padding-left: 10px; padding-right: 10px;">
                                                        <h1>${habitacion.id}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-cover text-center" style="position: relative; width: 100%; height: 176px; margin: 0; padding: 0;">
                                                <div class="image-blurred" style="background-image: url(./imagenes/hostal/DSC_0381.jpeg); width: 100%; height: 100%; background-size: cover; filter: blur(5px); margin: 0; padding: 0;"></div>
                                                <div class="icon-overlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <svg fill="rgba(255, 102, 0)" height="120px" width="120px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-29.32 -29.32 547.24 547.24" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#fffafa" stroke-width="22.475646"> <g id="XMLID_27_"> <path id="XMLID_32_" d="M261.133,458.918c0,5.868,4.835,10.305,10.69,10.305h62.091c5.86,0,10.219-4.436,10.219-10.305v-47.695h-83 V458.918z"></path> <path id="XMLID_337_" d="M152.896,95.295c26.302,0,47.639-21.328,47.639-47.644C200.534,21.328,179.197,0,152.896,0 c-26.332,0-47.663,21.328-47.663,47.651C105.233,73.967,126.563,95.295,152.896,95.295z"></path> <path id="XMLID_418_" d="M222.792,238.222h-36.658c0,33,0,13.255,0,45.63c0,5.866-4.629,10.37-10.502,10.37 c-4.808,0-40.664,0-45.501,0c-5.86,0-10.996-4.504-10.996-10.37c0-29.978,0-24.358,0-45.507l-36.356,0.038l-17.641,83.514 c-0.666,3.127,0.176,6.15,2.186,8.642c2.022,2.483,5.111,3.684,8.296,3.684h19.514v129.924c0,13.511,10.979,24.455,24.5,24.455 c13.502,0,24.5-10.944,24.5-24.455V334.222h18v129.924c0,13.511,10.982,24.455,24.503,24.455c13.496,0,24.497-10.944,24.497-24.455 V334.222h19.008c3.203,0,6.243-1.2,8.252-3.684c2.017-2.491,2.798-5.7,2.131-8.827L222.792,238.222z"></path> <path id="XMLID_419_" d="M88.673,212.222h128.53l-4.795-22.668l13.883,20.829c3.058,4.607,8.108,7.746,13.552,8.741l51.29,9.269 V355.63c-17,5.217-29.706,20.592-29.882,39.592h83.234c-0.175-19-12.352-34.375-29.352-39.592V226.035 c4-2.966,6.877-7.259,7.835-12.487c1.398-7.777-1.835-15.158-7.835-19.663V52.5c0-6.751-5.249-12.228-12-12.228 s-12,5.476-12,12.228v134.457l-35.464-6.409l-44.508-66.732c-3.82-5.771-10.185-8.564-16.621-8.707l-83.167-0.225 c-7.611,0.152-14.837,4.387-18.197,11.758L25.221,265.512c-4.681,10.236-0.167,22.329,10.059,27 c10.33,4.699,22.346,0.122,26.996-10.077l20.929-45.672L88.673,212.222z"></path> <path id="XMLID_420_" d="M450.79,456.352c0.177-1.031,0.29-2.085,0.29-3.167c0-10.259-8.316-18.574-18.575-18.574 c-0.876,0-1.731,0.081-2.574,0.198c-2.75-7.409-9.677-12.773-18.032-12.773c-9.106,0-16.433,6.418-18.534,14.88 c-2.071-1.147-4.317-1.974-6.848-1.974c-7.926,0-14.362,6.431-14.362,14.358c0,2.534,0.83,4.786,1.979,6.849 c-8.634,0.414-15.554,7.221-15.554,15.961c0,9.003,7.302,16.112,16.299,16.112h74.05c8.991,0,16.299-7.109,16.299-16.112 C465.229,463.765,458.879,457.309,450.79,456.352z"></path> </g> </g><g id="SVGRepo_iconCarrier"> <g id="XMLID_27_"> <path id="XMLID_32_" d="M261.133,458.918c0,5.868,4.835,10.305,10.69,10.305h62.091c5.86,0,10.219-4.436,10.219-10.305v-47.695h-83 V458.918z"></path> <path id="XMLID_337_" d="M152.896,95.295c26.302,0,47.639-21.328,47.639-47.644C200.534,21.328,179.197,0,152.896,0 c-26.332,0-47.663,21.328-47.663,47.651C105.233,73.967,126.563,95.295,152.896,95.295z"></path> <path id="XMLID_418_" d="M222.792,238.222h-36.658c0,33,0,13.255,0,45.63c0,5.866-4.629,10.37-10.502,10.37 c-4.808,0-40.664,0-45.501,0c-5.86,0-10.996-4.504-10.996-10.37c0-29.978,0-24.358,0-45.507l-36.356,0.038l-17.641,83.514 c-0.666,3.127,0.176,6.15,2.186,8.642c2.022,2.483,5.111,3.684,8.296,3.684h19.514v129.924c0,13.511,10.979,24.455,24.5,24.455 c13.502,0,24.5-10.944,24.5-24.455V334.222h18v129.924c0,13.511,10.982,24.455,24.503,24.455c13.496,0,24.497-10.944,24.497-24.455 V334.222h19.008c3.203,0,6.243-1.2,8.252-3.684c2.017-2.491,2.798-5.7,2.131-8.827L222.792,238.222z"></path> <path id="XMLID_419_" d="M88.673,212.222h128.53l-4.795-22.668l13.883,20.829c3.058,4.607,8.108,7.746,13.552,8.741l51.29,9.269 V355.63c-17,5.217-29.706,20.592-29.882,39.592h83.234c-0.175-19-12.352-34.375-29.352-39.592V226.035 c4-2.966,6.877-7.259,7.835-12.487c1.398-7.777-1.835-15.158-7.835-19.663V52.5c0-6.751-5.249-12.228-12-12.228 s-12,5.476-12,12.228v134.457l-35.464-6.409l-44.508-66.732c-3.82-5.771-10.185-8.564-16.621-8.707l-83.167-0.225 c-7.611,0.152-14.837,4.387-18.197,11.758L25.221,265.512c-4.681,10.236-0.167,22.329,10.059,27 c10.33,4.699,22.346,0.122,26.996-10.077l20.929-45.672L88.673,212.222z"></path> <path id="XMLID_420_" d="M450.79,456.352c0.177-1.031,0.29-2.085,0.29-3.167c0-10.259-8.316-18.574-18.575-18.574 c-0.876,0-1.731,0.081-2.574,0.198c-2.75-7.409-9.677-12.773-18.032-12.773c-9.106,0-16.433,6.418-18.534,14.88 c-2.071-1.147-4.317-1.974-6.848-1.974c-7.926,0-14.362,6.431-14.362,14.358c0,2.534,0.83,4.786,1.979,6.849 c-8.634,0.414-15.554,7.221-15.554,15.961c0,9.003,7.302,16.112,16.299,16.112h74.05c8.991,0,16.299-7.109,16.299-16.112 C465.229,463.765,458.879,457.309,450.79,456.352z"></path> </g> </g></svg>
                                                </div>
                                            </div>
                                            <div class="card-body" style="background: #faeaeb; text-align: center">
                                                <span class="badge bg-orange text-orange-fg" style="font-size: 17px">SUCIO</span>
                                            </div>
                                            <div class="d-flex">    
                                                <a href="#" class="card-btn" onclick="LimpiezaHabitacion(${habitacion.id})">
                                                TERMINAR LIMPIEZA
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            } else if (habitacion.Estado_habitacion === "MANTENIMIENTO") {
                                habitacionCard = `
                                    <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                        <div class="card" id="habitacion-mantenimiento" style="border: 2px solid blue; box-shadow: 0 0 8px 3px rgba(65, 116, 255);">
                                            <div class="card-header">
                                                <h3 class="card-title">HABITACION</h3>
                                                <div class="card-actions btn-actions">
                                                    <div class="ribbon ribbon-top ribbon-bookmark bg-blue" style="padding-left: 10px; padding-right: 10px;">
                                                        <h1>${habitacion.id}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-cover text-center" style="position: relative; width: 100%; height: 176px; margin: 0; padding: 0;">
                                                <div class="image-blurred" style="background-image: url(./imagenes/hostal/DSC_0381.jpeg); width: 100%; height: 100%; background-size: cover; filter: blur(5px); margin: 0; padding: 0;"></div>
                                                <div class="icon-overlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <svg width="120px" height="120px" viewBox="-9.1 -9.1 109.20 109.20" enable-background="new 0 0 91 91" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#fff0f0" stroke-width="7.098000000000001"> <g> <g> <path d="M38.841,55.666l0.682-0.676l-0.02-0.016c-0.881-0.891,4.984-6.855,4.984-6.855l-8.119-8.118L8.663,66.904 c-1.973,1.977-2.92,4.705-2.658,7.686c0.242,2.793,1.533,5.49,3.813,7.771c2.43,2.424,5.553,3.66,8.533,3.66 c2.521,0,4.938-0.889,6.746-2.691l20.258-20.26l-5.111-5.17C39.604,57.252,39.151,56.488,38.841,55.666" fill="rgba(65, 116, 255)"></path> <path d="M87.675,16.767l-1.621-3.891L75.616,23.317c-1.777,1.777-3.336,2.678-4.635,2.678 c-0.992,0-2.006-0.537-3.146-1.674l-0.188-0.184c-1.701-1.701-3.016-3.695,1.037-7.75L79.13,5.942l-3.893-1.621 C67.31,1.019,59.005-1.073,51.952,5.985l-6.457,6.451c-6.553,6.561-8.811,14.01-6.699,21.397l6.51,6.646l5.088-5.088 c0,0,3.248,1.688,5.568,3.182l13.875,14.061c3.398-1.033,6.664-3.059,9.732-6.129l6.441-6.452 C93.073,33.001,90.985,24.692,87.675,16.767" fill="rgba(65, 116, 255)"></path> <path d="M80.097,69.682L54.472,43.714c-0.84-0.855-1.898-1.527-3.148-1.996l-1.51-0.568l-4.578,4.58L21.023,21.518 l2.235-2.237c0.602-0.6,0.9-1.439,0.813-2.283c-0.086-0.846-0.547-1.607-1.258-2.074L9.72,6.321 C8.601,5.587,7.118,5.739,6.169,6.687l-4.482,4.49c-0.945,0.947-1.096,2.428-0.361,3.545l8.6,13.094 c0.465,0.711,1.227,1.174,2.072,1.26c0.096,0.01,0.191,0.014,0.287,0.014c0.746,0,1.465-0.295,1.998-0.826l2.02-2.021 l24.211,24.211l-4.588,4.59l0.572,1.512c0.459,1.207,1.119,2.25,1.965,3.105l25.645,25.984c1.688,1.688,4.006,2.617,6.527,2.617 h0.002c2.994,0,6.018-1.309,8.334-3.627l0.133-0.139c2.057-2.051,3.318-4.678,3.553-7.396 C82.907,74.219,81.993,71.582,80.097,69.682z M75.522,80.99l-0.137,0.145c-1.344,1.344-3.076,2.117-4.75,2.117 c-0.838,0-2.039-0.201-2.979-1.139L42.026,56.141c-0.02-0.02-0.039-0.039-0.059-0.059l8.893-8.895 c0.012,0.014,0.023,0.027,0.035,0.039L76.54,73.211c0.844,0.848,1.246,2.076,1.125,3.455C77.53,78.211,76.784,79.73,75.522,80.99z " fill="rgba(65, 116, 255)"></path> </g> </g> </g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M38.841,55.666l0.682-0.676l-0.02-0.016c-0.881-0.891,4.984-6.855,4.984-6.855l-8.119-8.118L8.663,66.904 c-1.973,1.977-2.92,4.705-2.658,7.686c0.242,2.793,1.533,5.49,3.813,7.771c2.43,2.424,5.553,3.66,8.533,3.66 c2.521,0,4.938-0.889,6.746-2.691l20.258-20.26l-5.111-5.17C39.604,57.252,39.151,56.488,38.841,55.666" fill="rgba(65, 116, 255)"></path> <path d="M87.675,16.767l-1.621-3.891L75.616,23.317c-1.777,1.777-3.336,2.678-4.635,2.678 c-0.992,0-2.006-0.537-3.146-1.674l-0.188-0.184c-1.701-1.701-3.016-3.695,1.037-7.75L79.13,5.942l-3.893-1.621 C67.31,1.019,59.005-1.073,51.952,5.985l-6.457,6.451c-6.553,6.561-8.811,14.01-6.699,21.397l6.51,6.646l5.088-5.088 c0,0,3.248,1.688,5.568,3.182l13.875,14.061c3.398-1.033,6.664-3.059,9.732-6.129l6.441-6.452 C93.073,33.001,90.985,24.692,87.675,16.767" fill="rgba(65, 116, 255)"></path> <path d="M80.097,69.682L54.472,43.714c-0.84-0.855-1.898-1.527-3.148-1.996l-1.51-0.568l-4.578,4.58L21.023,21.518 l2.235-2.237c0.602-0.6,0.9-1.439,0.813-2.283c-0.086-0.846-0.547-1.607-1.258-2.074L9.72,6.321 C8.601,5.587,7.118,5.739,6.169,6.687l-4.482,4.49c-0.945,0.947-1.096,2.428-0.361,3.545l8.6,13.094 c0.465,0.711,1.227,1.174,2.072,1.26c0.096,0.01,0.191,0.014,0.287,0.014c0.746,0,1.465-0.295,1.998-0.826l2.02-2.021 l24.211,24.211l-4.588,4.59l0.572,1.512c0.459,1.207,1.119,2.25,1.965,3.105l25.645,25.984c1.688,1.688,4.006,2.617,6.527,2.617 h0.002c2.994,0,6.018-1.309,8.334-3.627l0.133-0.139c2.057-2.051,3.318-4.678,3.553-7.396 C82.907,74.219,81.993,71.582,80.097,69.682z M75.522,80.99l-0.137,0.145c-1.344,1.344-3.076,2.117-4.75,2.117 c-0.838,0-2.039-0.201-2.979-1.139L42.026,56.141c-0.02-0.02-0.039-0.039-0.059-0.059l8.893-8.895 c0.012,0.014,0.023,0.027,0.035,0.039L76.54,73.211c0.844,0.848,1.246,2.076,1.125,3.455C77.53,78.211,76.784,79.73,75.522,80.99z " fill="rgba(65, 116, 255)"></path> </g> </g> </g></svg>
                                                </div>
                                            </div>
                                            <div class="card-body" style="background: #faeaeb; text-align: center">
                                                <span class="badge bg-blue text-blue-fg" style="font-size: 15px">MANTENIMIENTO</span>
                                            </div>
                                            <div class="d-flex">    
                                                <a href="#" class="card-btn" onclick="SolucionMantenimientoHabitacion(${habitacion.id})">
                                                    MANTENIMIENTO
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            $('#card-habitaciones').append(habitacionCard);
                        });

                        const CantidadHabText = document.getElementById('CantidadHabText');
                        $('#CantidadHabText').text("Cantidad Huesped "+response.cantidadhuspedes);


                        const textOcupado = document.getElementById('textOcupado');
                        if (response.ocupados > 0) {
                            textOcupado.style.display = 'inline';
                            $('#HabOcupadosCount').text(response.ocupados);
                        } else {
                            textOcupado.style.display = 'none';
                        }

                        const textMantenimiento = document.getElementById('textMantenimiento');
                        if (response.mantenimientos > 0) {
                            textMantenimiento.style.display = 'inline';
                            $('#HabMantenimientoCount').text(response.mantenimientos);
                        } else {
                            textMantenimiento.style.display = 'none';
                        }

                        const textLimpieza = document.getElementById('textLimpieza');
                        if (response.limpieza > 0) {
                            textLimpieza.style.display = 'inline';
                            $('#HabLimpiezaCount').text(response.limpieza);
                        } else {
                            textLimpieza.style.display = 'none';
                        }

                        const textLibre = document.getElementById('textLibre');
                        if (response.libre > 0) {
                            textLibre.style.display = 'inline';
                            $('#HabLibreCount').text(response.libre);
                        } else {
                            textLibre.style.display = 'none';
                        }

                    },
                    error: function(xhr, status, error) {
                        MostrarMensaje("Error al obtener habitaciones", "error");
                    }
                });

                $(document).ready(function() {
                    let hospedajesData = [];
                    
                    $.ajax({
                        url: '/apihostal/get-hospedajes-all',
                        type: 'GET',
                        success: function(data) {
                            hospedajesData = data;
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });

                    $('#SearchClienteFilter').on('input', function() {
                        var searchTerm = $('#SearchClienteFilter').val().toLowerCase();
                        
                        if (searchTerm.length >= 3) {
                            var filteredData = hospedajesData.filter(function(item) {
                                return item.nombre_cliente.toLowerCase().includes(searchTerm);
                            });

                            var resultadosHtml = '';
                            if (filteredData.length > 0) {
                                filteredData.forEach(function(item) {
                                    resultadosHtml += `<li data-habitacion-id="${item.habitacion_id}" data-grupo="${item.grupo}">${item.nombre_cliente} - Habitación ${item.habitacion_id}</li>`;
                                });
                            } else {
                                resultadosHtml = '<li class="no-result">No se encontraron resultados</li>';
                            }

                            $('#resultados').html(resultadosHtml);
                        } else {
                            $('#resultados').html('');
                        }
                    });

                    $('#resultados').on('click', 'li', function() {
                        var habitacionId = $(this).data('habitacion-id'); 
                        var grupo = $(this).data('grupo');

                        if (grupo === 'si') {
                            OcupadoHabitacion(habitacionId);
                        } else {
                            OcupadoHabitacionGrupo(habitacionId);
                        }

                        $('#SearchClienteFilter').val('');
                        $('#resultados').html('');
                    });
                });

            },
            error: function(xhr, status, error) {
                MostrarMensaje("Error al obtener grupos de habitaciones", "error");
            }
        });
    }
  
    function MostrarAmbientes() {
        $.ajax({
            url: '/apihostal/get-ambiente-salon',
            method: 'GET',
            dataType: 'json',
            success: function(salones) {
                $('#card-salones').empty();                          
                salones.forEach(function(salon) {
                    if (salon.Estado_salon === "DISPONIBLE") {
                        salonCard = `
                            <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                <div class="card" id="salon-disponible" style="border: 2px solid green; box-shadow: 0 0 8px 3px rgba(0, 255, 0, 0.7);">
                                    <div class="card-header">
                                        <h3 class="card-title">${salon.Nombre_salon}</h3>
                                    </div>
                                    <div class="img-responsive img-responsive-18x9 card-img-top" style="background-image: url(./images/salones/${salon.imagen})"></div>
                                    <div class="card-body" style="text-align: center; background: #ebf6ed">
                                        <span class="badge bg-green-lt" style="font-size: 15px; text-align: center">${salon.Estado_salon}</span>
                                    </div>
                                    <div class="d-flex">    
                                        <a href="#" class="card-btn" onclick="hospedarHabitacion(${salon.id})">
                                            RESERVAR
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else if (salon.Estado_salon === "OCUPADO") {
                        salonCard = `
                            <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                <div class="card" id="salon-ocupado" style="border: 2px solid red; box-shadow: 0 0 8px 3px rgba(255, 0, 0.0);">
                                    <div class="card-header">
                                        <h3 class="card-title">${salon.Nombre_salon}</h3>
                                    </div>
                                    <div class="card-cover text-center" style="position: relative; width: 100%; height: 176px; margin: 0; padding: 0;">
                                        <div class="image-blurred" style="background-image: url(./images/salones/${salon.imagen}); width: 100%; height: 100%; background-size: cover; filter: blur(5px); margin: 0; padding: 0;"></div>
                                        <div class="icon-overlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            <svg fill="rgba(255, 0, 0.0)" width="150px" height="150px" viewBox="-10 -10 70.00 70.00" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" stroke="rgba(255, 0, 0.0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#ffffff" stroke-width="4.7"><path d="M3 9C1.3545455 9 0 10.354545 0 12L0 42L6 42L6 37L44 37L44 42L50 42L50 28L50 23C50 20.254545 47.745455 18 45 18L19 18 A 1.0001 1.0001 0 0 0 18 19L18 28L12 28L6 28L6 12C6 10.354545 4.6454545 9 3 9 z M 12 28C14.749579 28 17 25.749579 17 23C17 20.250421 14.749579 18 12 18C9.2504209 18 7 20.250421 7 23C7 25.749579 9.2504209 28 12 28 z M 12 20C13.668699 20 15 21.331301 15 23C15 24.668699 13.668699 26 12 26C10.331301 26 9 24.668699 9 23C9 21.331301 10.331301 20 12 20 z M 20 20L45 20C46.654545 20 48 21.345455 48 23L48 28L20 28L20 20 z"></path></g><g id="SVGRepo_iconCarrier"><path d="M3 9C1.3545455 9 0 10.354545 0 12L0 42L6 42L6 37L44 37L44 42L50 42L50 28L50 23C50 20.254545 47.745455 18 45 18L19 18 A 1.0001 1.0001 0 0 0 18 19L18 28L12 28L6 28L6 12C6 10.354545 4.6454545 9 3 9 z M 12 28C14.749579 28 17 25.749579 17 23C17 20.250421 14.749579 18 12 18C9.2504209 18 7 20.250421 7 23C7 25.749579 9.2504209 28 12 28 z M 12 20C13.668699 20 15 21.331301 15 23C15 24.668699 13.668699 26 12 26C10.331301 26 9 24.668699 9 23C9 21.331301 10.331301 20 12 20 z M 20 20L45 20C46.654545 20 48 21.345455 48 23L48 28L20 28L20 20 z"></path></g></svg>    
                                        </div>
                                    </div>
                                    <div class="card-body" style="background: #faeaeb; text-align: center">
                                        <span class="badge bg-red text-red-fg" style="font-size: 17px">OCUPADA</span>
                                    </div>
                                    <div class="d-flex">    
                                        <a href="#" class="card-btn" onclick="OcupadoReservaSalon(${salon.id})">
                                            INGRESAR
                                        </a>
                                        <div class="dropdown ms-2">
                                            <a href="#" class="card-btn" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg fill="#386aff" width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" stroke="#386aff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M10 1L5 8h10l-5-7zm0 18l5-7H5l5 7z"></path></g></svg>                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="#" onclick="manejarReserva(${salon.id})">RESERVAR</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else if (salon.Estado_salon === "LIMPIEZA") {
                        salonCard = `
                            <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                                <div class="card" id="salon-limpieza" style="border: 2px solid orange; box-shadow: 0 0 8px 3px rgba(255, 102, 0);">
                                    <div class="card-header">
                                        <h3 class="card-title">${salon.Nombre_salon}</h3>
                                    </div>
                                    <div class="card-cover text-center" style="position: relative; width: 100%; height: 176px; margin: 0; padding: 0;">
                                        <div class="image-blurred" style="background-image: url(./images/salones/${salon.imagen}); width: 100%; height: 100%; background-size: cover; filter: blur(5px); margin: 0; padding: 0;"></div>
                                        <div class="icon-overlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            <svg fill="rgba(255, 102, 0)" height="120px" width="120px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-29.32 -29.32 547.24 547.24" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#fffafa" stroke-width="22.475646"> <g id="XMLID_27_"> <path id="XMLID_32_" d="M261.133,458.918c0,5.868,4.835,10.305,10.69,10.305h62.091c5.86,0,10.219-4.436,10.219-10.305v-47.695h-83 V458.918z"></path> <path id="XMLID_337_" d="M152.896,95.295c26.302,0,47.639-21.328,47.639-47.644C200.534,21.328,179.197,0,152.896,0 c-26.332,0-47.663,21.328-47.663,47.651C105.233,73.967,126.563,95.295,152.896,95.295z"></path> <path id="XMLID_418_" d="M222.792,238.222h-36.658c0,33,0,13.255,0,45.63c0,5.866-4.629,10.37-10.502,10.37 c-4.808,0-40.664,0-45.501,0c-5.86,0-10.996-4.504-10.996-10.37c0-29.978,0-24.358,0-45.507l-36.356,0.038l-17.641,83.514 c-0.666,3.127,0.176,6.15,2.186,8.642c2.022,2.483,5.111,3.684,8.296,3.684h19.514v129.924c0,13.511,10.979,24.455,24.5,24.455 c13.502,0,24.5-10.944,24.5-24.455V334.222h18v129.924c0,13.511,10.982,24.455,24.503,24.455c13.496,0,24.497-10.944,24.497-24.455 V334.222h19.008c3.203,0,6.243-1.2,8.252-3.684c2.017-2.491,2.798-5.7,2.131-8.827L222.792,238.222z"></path> <path id="XMLID_419_" d="M88.673,212.222h128.53l-4.795-22.668l13.883,20.829c3.058,4.607,8.108,7.746,13.552,8.741l51.29,9.269 V355.63c-17,5.217-29.706,20.592-29.882,39.592h83.234c-0.175-19-12.352-34.375-29.352-39.592V226.035 c4-2.966,6.877-7.259,7.835-12.487c1.398-7.777-1.835-15.158-7.835-19.663V52.5c0-6.751-5.249-12.228-12-12.228 s-12,5.476-12,12.228v134.457l-35.464-6.409l-44.508-66.732c-3.82-5.771-10.185-8.564-16.621-8.707l-83.167-0.225 c-7.611,0.152-14.837,4.387-18.197,11.758L25.221,265.512c-4.681,10.236-0.167,22.329,10.059,27 c10.33,4.699,22.346,0.122,26.996-10.077l20.929-45.672L88.673,212.222z"></path> <path id="XMLID_420_" d="M450.79,456.352c0.177-1.031,0.29-2.085,0.29-3.167c0-10.259-8.316-18.574-18.575-18.574 c-0.876,0-1.731,0.081-2.574,0.198c-2.75-7.409-9.677-12.773-18.032-12.773c-9.106,0-16.433,6.418-18.534,14.88 c-2.071-1.147-4.317-1.974-6.848-1.974c-7.926,0-14.362,6.431-14.362,14.358c0,2.534,0.83,4.786,1.979,6.849 c-8.634,0.414-15.554,7.221-15.554,15.961c0,9.003,7.302,16.112,16.299,16.112h74.05c8.991,0,16.299-7.109,16.299-16.112 C465.229,463.765,458.879,457.309,450.79,456.352z"></path> </g> </g><g id="SVGRepo_iconCarrier"> <g id="XMLID_27_"> <path id="XMLID_32_" d="M261.133,458.918c0,5.868,4.835,10.305,10.69,10.305h62.091c5.86,0,10.219-4.436,10.219-10.305v-47.695h-83 V458.918z"></path> <path id="XMLID_337_" d="M152.896,95.295c26.302,0,47.639-21.328,47.639-47.644C200.534,21.328,179.197,0,152.896,0 c-26.332,0-47.663,21.328-47.663,47.651C105.233,73.967,126.563,95.295,152.896,95.295z"></path> <path id="XMLID_418_" d="M222.792,238.222h-36.658c0,33,0,13.255,0,45.63c0,5.866-4.629,10.37-10.502,10.37 c-4.808,0-40.664,0-45.501,0c-5.86,0-10.996-4.504-10.996-10.37c0-29.978,0-24.358,0-45.507l-36.356,0.038l-17.641,83.514 c-0.666,3.127,0.176,6.15,2.186,8.642c2.022,2.483,5.111,3.684,8.296,3.684h19.514v129.924c0,13.511,10.979,24.455,24.5,24.455 c13.502,0,24.5-10.944,24.5-24.455V334.222h18v129.924c0,13.511,10.982,24.455,24.503,24.455c13.496,0,24.497-10.944,24.497-24.455 V334.222h19.008c3.203,0,6.243-1.2,8.252-3.684c2.017-2.491,2.798-5.7,2.131-8.827L222.792,238.222z"></path> <path id="XMLID_419_" d="M88.673,212.222h128.53l-4.795-22.668l13.883,20.829c3.058,4.607,8.108,7.746,13.552,8.741l51.29,9.269 V355.63c-17,5.217-29.706,20.592-29.882,39.592h83.234c-0.175-19-12.352-34.375-29.352-39.592V226.035 c4-2.966,6.877-7.259,7.835-12.487c1.398-7.777-1.835-15.158-7.835-19.663V52.5c0-6.751-5.249-12.228-12-12.228 s-12,5.476-12,12.228v134.457l-35.464-6.409l-44.508-66.732c-3.82-5.771-10.185-8.564-16.621-8.707l-83.167-0.225 c-7.611,0.152-14.837,4.387-18.197,11.758L25.221,265.512c-4.681,10.236-0.167,22.329,10.059,27 c10.33,4.699,22.346,0.122,26.996-10.077l20.929-45.672L88.673,212.222z"></path> <path id="XMLID_420_" d="M450.79,456.352c0.177-1.031,0.29-2.085,0.29-3.167c0-10.259-8.316-18.574-18.575-18.574 c-0.876,0-1.731,0.081-2.574,0.198c-2.75-7.409-9.677-12.773-18.032-12.773c-9.106,0-16.433,6.418-18.534,14.88 c-2.071-1.147-4.317-1.974-6.848-1.974c-7.926,0-14.362,6.431-14.362,14.358c0,2.534,0.83,4.786,1.979,6.849 c-8.634,0.414-15.554,7.221-15.554,15.961c0,9.003,7.302,16.112,16.299,16.112h74.05c8.991,0,16.299-7.109,16.299-16.112 C465.229,463.765,458.879,457.309,450.79,456.352z"></path> </g> </g></svg>
                                        </div>
                                    </div>
                                    <div class="card-body" style="background: #faeaeb; text-align: center">
                                        <span class="badge bg-orange text-orange-fg" style="font-size: 17px">SUCIO</span>
                                    </div>
                                    <div class="d-flex">    
                                        <a href="#" class="card-btn" onclick="LimpiezaHabitacion(${salon.id})">
                                        TERMINAR LIMPIEZA
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }                                       
                    $('#card-salones').append(salonCard);
                });

                salonCard = `
                    <div class="col-md-6 col-lg-3" style="margin-bottom: 20px;">
                        <a style="cursor: pointer" id="agregar-salon-ambiente">
                        <svg width="256px" height="256px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C12.5523 4 13 4.44772 13 5V11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H13V19C13 19.5523 12.5523 20 12 20C11.4477 20 11 19.5523 11 19V13H5C4.44772 13 4 12.5523 4 12C4 11.4477 4.44772 11 5 11H11V5C11 4.44772 11.4477 4 12 4Z" fill="#000000"></path> </g></svg>
                        </a>
                    </div>
                `;
                $('#card-salones').append(salonCard);

                $('#agregar-salon-ambiente').off('click').on('click', function(event) {
                    event.preventDefault();
                    $('#form_tabs').empty();

                    var addFormCardSalon = `
                        <div class="card-header" style="width: 100%;">
                            <h3 class="card-title">Agregar Nuevo Salon</h3>
                        </div>
                        <div class="card-body">
                            <div class="datagrid">
                                <div class="row">
                                    <div class="col-12 col-sm-12" style="padding: 10px">
                                        <div class="mb-3">
                                            <label class="form-label required">Nombre Ambiente - Salon</label>
                                            <input class="form-control convertmayusculas" rows="4" id="Nombre_salonInput">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12" style="padding: 10px">
                                        <div class="mb-3">
                                            <label class="form-label required">Detalle Ambiente - Salon</label>
                                            <textarea class="form-control convertmayusculas" rows="4" id="Detalle_salonInput"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12" style="padding: 10px">
                                        <div class="mb-3">
                                            <label class="form-label">Imagen Salon</label>
                                            <input type="file" class="form-control" id="ImagenInput">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex" style="text-align: right">
                                <button type="button" class="btn me-auto" id="btn-ocupar-habitacion-cancelar">CANCELAR</button>
                                <button type="button" class="btn btn-primary" id="btn-registrar-nuevo-ambiente">REGISTRAR NUEVO</button>
                            </div>
                        </div>
                    `;        
                    $('#form_tabs').append(addFormCardSalon);

                    convertirMayusculas();
                    
                    $('#btn-registrar-nuevo-ambiente').on('click', function(event) {
                        event.preventDefault();
                        
                        var Nombre_salonInput = $('#Nombre_salonInput').val();
                        var Detalle_salonInput = $('#Detalle_salonInput').val();
                        var ImagenInput = $('#ImagenInput')[0].files[0];
                        
                        var formData = new FormData();
                        formData.append('Nombre_salonInput', Nombre_salonInput);
                        formData.append('Detalle_salonInput', Detalle_salonInput);
                        formData.append('ImagenInput', ImagenInput);

                        $.ajax({
                            url: '/apihostal/registrar-salon-ambiente',
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                MostrarAmbientes();
                                MostrarMensaje("Creado Exitosamente", "success");
                                CanvasTime();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('Error al registrar el salón:', textStatus, errorThrown);
                            }
                        });
                    });

                });
            },
            error: function(xhr, status, error) {
                MostrarMensaje("Error al obtener grupos de habitaciones", "error");
            }
        });
    }
    
    function convertirMayusculas() {
        const inputs = document.querySelectorAll('.convertmayusculas');
        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                input.value = input.value.toUpperCase();
            });
        });
    }


    function TraerPaisesNacionalidad() {
        const jsonUrl = '/utilidades/json/countries.json';
        const nacionalidadSelect = $('#InputNacionalidad');

        if (nacionalidadSelect.hasClass("select2-hidden-accessible")) {
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
                    dropdownParent: $('#modalPasajeros'),
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

</script>