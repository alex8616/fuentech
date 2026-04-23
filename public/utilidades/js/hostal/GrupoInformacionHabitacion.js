function GrupoInformacionHabitacion(id) {
  $.ajax({
      url: '/apihostal/get-habitacion-ocupada-grupo-info/'+id,
      method: 'GET',
      success: function(grupo) {
          $('#form_tabs').empty();
          var simpleText = grupo.categoria_counts.SIMPLE > 0 ? `SIMPLE (${grupo.categoria_counts.SIMPLE})` : '';
          var dobleText = grupo.categoria_counts.DOBLE > 0 ? `DOBLE (${grupo.categoria_counts.DOBLE})` : '';
          var tripleText = grupo.categoria_counts.TRIPLE > 0 ? `TRIPLE (${grupo.categoria_counts.TRIPLE})` : '';
          var matrimonialText = grupo.categoria_counts.MATRIMONIAL > 0 ? `MATRIMONIAL (${grupo.categoria_counts.MATRIMONIAL})` : '';
          let tablaadelantosgrupo = '';
          let tablaadelantossumgrupo = '';
          let adelantos = grupo.adelantos;
          var habitacionHtmlGrupo = '';
          
          $('#div-habitaciones-grupo-select').empty();

          $.each(grupo.hospedajes, function(index, hospedaje) {
              var clientesHtml = '';
              $.each(hospedaje.detallehospedajes, function(i, detalleHospedaje) {
                  clientesHtml += `<li>${detalleHospedaje.cliente.NombreCompleto_cliente}</li>`;
              });
              habitacionHtmlGrupo += `
                  <div class="col-sm-6 mb-3">
                    <div class="card card-active">
                      <div class="card-body">
                        <h3 class="card-title">${hospedaje.habitacion.Nombre_habitacion} - ${hospedaje.CategoriaHabitacion}</h3>
                        <ul>
                            ${clientesHtml}
                        </ul>
                      </div>
                      <div class="card-footer card-footer-transparent" style="text-align: right">
                        ${hospedaje.GuiaTuristica == "false" ? `
                            Precio De La Habitacion <strong style="font-size: 18px">${hospedaje.Precio_habitacion} Bs.</strong>
                        ` : '<strong style="font-size: 18px; color: red">Guia Del Grupo</strong>'
                        }
                      </div>
                    </div>                         
                  </div>
              `;
              $('#div-habitaciones-grupo-select').append(habitacionHtmlGrupo);
          });

          if (adelantos.length > 0) {
            adelantos.forEach(function(adelanto) {
                tablaadelantosgrupo += `
                    <tr>
                        <td>${adelanto.FechaDeAdelanto || ''}</td>
                        <td>${adelanto.TipoAdelanto || ''}</td>
                        <td>${adelanto.TotalAdelanto || ''}</td>
                    </tr>
                `;
            });

            tablaadelantossumgrupo += `
                <tr style="background: #EAEAEA">
                    <th colspan="2" style="text-align: right">Sumatoria: </th>
                    <th>${grupo.Adelanto || ''}</th>
                </tr>
            `;
        } else {
            tablaadelantosgrupo += `
                <tr>
                    <td colspan="3">No Existe Adelantos</td>
                </tr>
            `;
        }

          var HabitacionForm = `
              <div class="card-header" style="width: 100%; background-color: #74512D; color: white">
                  <h3 class="card-title">GRUPO ${grupo.TourName} - ${grupo.CodigoHospedaje}</h3>
              </div>
              <div class="card-body">                  
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        Informacion Del Grupo
                      </h3>
                        <div class="card-actions">
                            <a class="badge badge-outline text-blue" id="btn-imprimir-grupo" style="cursor:pointer;"  data-id="${grupo.id}">
                                Imprimir
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                      <dl class="row">
                        <dt class="col-3">GRUPO:</dt>
                        <dd class="col-3">${grupo.TourName}</dd>
                        <dt class="col-3">CODIGO:</dt>
                        <dd class="col-3">${grupo.CodigoHospedaje}</dd>
                        <dt class="col-3">INGRESO:</dt>
                        <dd class="col-3">${formatearFecha(grupo.ingreso_hospedaje)}</dd>
                        <dt class="col-3">SALIDA:</dt>
                        <dd class="col-3">${formatearFecha(grupo.salida_hospedaje)}</dd>
                        <dt class="col-3">CANT. DIAS:</dt>
                        <dd class="col-3">${grupo.dias_hospedarse}</dd>
                        <dt class="col-3">PAX:</dt>
                        <dd class="col-3">${grupo.CantidadPersonas}</dd>
                        <dt class="col-3">PROCEDENCIA:</dt>
                        <dd class="col-3">${grupo.procedencia_hospedaje}</dd>
                        <dt class="col-3">DESTINO:</dt>
                        <dd class="col-3">${grupo.destino_hospedaje}</dd>
                      </dl>   
                    </div>                    
                  </div><br>
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">
                        Habitaciones Asignadas <strong>${simpleText} ${dobleText} ${tripleText} ${matrimonialText}</strong>
                      </h3>
                      <div class="card-actions">
                        
                      </div>
                    </div>
                    <div class="card-body" style="padding: 10px">
                      <div class="row" id="div-habitaciones-grupo-select">
                        ${habitacionHtmlGrupo}
                      </div>
                  </div>
              </div><br>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="mb-3">
                            <div class="card">
                                <div class="card-body" style="margin: 6px; padding: 6px">
                                    <div class="card-header" style="width: 100%; margin: 5px; padding: 5px">  
                                        <h3 class="card-title">ADELANTOS</h3>
                                        <div class="ms-auto">
                                            <span class="badge badge-outline text-blue" style="cursor: pointer;" id="btn-agregar-adelanto" data-bs-toggle="modal" data-bs-target="#modal-adelanto-grupo" data-id="${grupo.id}">
                                                Agregar
                                            </span>
                                        </div>
                                    </div>
                                    <table class="table table-sm table-borderless" id="tabla-adelantos-grupo">
                                        <tbody>
                                            ${tablaadelantosgrupo}
                                        </tbody>
                                        <tfoot>
                                            ${tablaadelantossumgrupo}
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-12 col-sm-6">
                        <div class="mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" style="text-align: right; padding-right: 20px; width: 90%">TOTAL HOSPEDAJE</th>
                                            <td style="text-align: left; padding-left: 20px" id="TotalHospedajeValorGrupo"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="text-align: right; padding-right: 20px">SUB TOTAL</th>
                                            <td style="text-align: left; padding-left: 20px" id="TotalHospedajeSubTotalValorGrupo"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="text-align: right; padding-right: 20px">ADELANTOS</th>
                                            <td style="text-align: left; padding-left: 20px" id="TotalHospedajeAdelantoValorGrupo"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="font-size: 19px; text-align: right; padding-right: 20px">TOTAL A PAGAR</th>
                                            <th style="font-size: 19px; text-align: left; padding-left: 20px" id="TotalHospedajeGeneralValorGrupo"></th>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="mb-3">
                            <div class="card">
                                <div class="card-body" style="margin: 6px; padding: 6px">
                                    <div class="card-header" style="width: 100%; margin: 5px; padding: 5px">  
                                        <h3 class="card-title">Consumos O Servicios</h3>
                                    </div>
                                    <table class="table table-sm table-borderless" id="tabla-consumos-servicios-grupo"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
              <div class="card-footer">
                  <div class="d-flex-end" style="text-align: right">
                      <button type="button" class="btn btn-primary" id="btn-finalizar-grupo" data-bs-toggle="modal" data-bs-target="#modal-finalizar-grupo-hospedaje" disabled>CONCLUIR GRUPO</button>
                  </div>
              </div>
          `;
          
          $('#form_tabs').append(HabitacionForm);
        
$(document).ready(function() {

    $("#btn-imprimir-grupo").on("click", function() {
        const id = $(this).data('id');


        $.ajax({                    
            url: '/apihostal/imprimir-informacion-hospedaje-grupo/'+id,
            type: 'GET',
            data: { id: id },
            success: function(response) {
                const pdfBase64 = response.pdfBase64;
                $('#modalJsonGrupo .modal-body').html(`
                    <iframe src="data:application/pdf;base64,${pdfBase64}" width="100%" height="500px" style="border: none;"></iframe>
                `);
                $('#modalJsonGrupo').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Ocurrió un error al recuperar los datos.');
                console.error(error);
            }
        });

    });

});

          $.ajax({
            url: '/apihostal/get-consumo-habitacion-grupo/' + grupo.id,
            method: 'GET',
            success: function(response) {
                var tabla = $('#tabla-consumos-servicios-grupo');
                var filas = '';
                var tablaVacia = true;
                
                response.forEach(function(hospedaje) {
                    var habitacion = hospedaje.habitacion.Nombre_habitacion;
                    var idhabitacion = hospedaje.habitacion.id;

                    hospedaje.servicios.forEach(function(servicio) {
                        if (servicio.totalgeneral > 0) {
                            filas += `
                                <tr>
                                    <td><a href="javascript:void(0);" onclick="OcupadoHabitacionGrupo(${idhabitacion})">${habitacion}</a></td>
                                    <td>Servicio</td>
                                    <td>${servicio.totalgeneral}</td>
                                </tr>
                            `;
                            tablaVacia = false;
                        }
                    });
        
                    hospedaje.servicioconsumos.forEach(function(consumo) {
                        if (consumo.totalgeneral > 0) {
                            filas += `
                                <tr>
                                    <td><a href="javascript:void(0);" onclick="OcupadoHabitacionGrupo(${idhabitacion})">${habitacion}</a></td>
                                    <td>Consumo</td>
                                    <td>${consumo.totalgeneral}</td>
                                </tr>
                            `;
                            tablaVacia = false;
                        }
                    });
                });
        
                tabla.html(filas); 
                
                if (tablaVacia) {
                    $('#btn-finalizar-grupo').prop('disabled', false);
                } else {
                    $('#btn-finalizar-grupo').prop('disabled', true);
                }
            },
            error: function() {
                alert('Error al cargar los consumos o servicios.');
            }
        });

        
        $('#TotalHospedajeValorGrupo').text(grupo.TotalHospedaje);
        $('#TotalServiciosValorGrupo').text(grupo.TotalServicio);
        $('#TotalConsumosValorGrupo').text(grupo.TotalConsumo);
        $('#TotalHospedajeSubTotalValorGrupo').text(grupo.SubTotal);
        $('#TotalHospedajeAdelantoValorGrupo').text(grupo.Adelanto);
        $('#TotalHospedajeGeneralValorGrupo').text(grupo.Total);


        $('#modal-adelanto-grupo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var hospedajeID = button.data('id');

            $('#btn-registrar-modal-adelanto-grupo').data('id', hospedajeID);
        });

        $('#btn-registrar-modal-adelanto-grupo').off('click').on('click', function(event) {
            event.preventDefault();
            
            const TipoAdelantoGrupo = $('#TipoAdelantoGrupo').val();
            const MontoAdelantoGrupo = $('#MontoAdelantoGrupo').val(); 
            const TipoMonedaAdelantoGrupo = $('#TipoMonedaAdelantoGrupo').val(); 
            const hospedajeIDGrupo = $(this).data('id');
            
            const dataToSend = {
                tipo_pago: TipoAdelantoGrupo,
                monto: MontoAdelantoGrupo,
                tipomoneda: TipoMonedaAdelantoGrupo,
                id: hospedajeIDGrupo,
            };

            $.ajax({
                url: '/apihostal/registrar-adelanto-grupo',
                method: 'POST',
                data: dataToSend,
                success: function(response) {
                    GrupoInformacionHabitacion(id)
                    MostrarMensaje("Consumo Pagado Exitosamente", "success");
                    $('#MontoAdelantoGrupo').val('');
                    $('#TipoAdelantoGrupo').val($('#TipoAdelanto option:first').val());
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error al recuperar:', textStatus, errorThrown);
                }
            });
        });

        $('#btn-finalizar-grupo').off('click').on('click', function(event) {
            event.preventDefault();
            
            $('#modal-finalizar-grupo-hospedaje').on('hidden.bs.modal', function () {
                $('#ListPagosGrupo').empty();
                var DivMostradorListPagos = document.getElementById('MostradorListPagosGrupo');
                DivMostradorListPagos.innerHTML = `
                    <div class="row" style="background: #F5F7F8; border: 1px solid white">
                        <div class="col-12 col-sm-12">
                            <div class="row" style="font-size: 16px">
                                <div class="col-12 col-sm-8"><strong>TOTAL HOSPEDAJE: </strong></div>
                                <div class="col-12 col-sm-4"><span>0.00</span></div>
                                <div class="col-12 col-sm-8"><strong>SUBTOTAL: </strong></div>
                                <div class="col-12 col-sm-4"><span>0.00</span></div>
                                <div class="col-12 col-sm-8"><strong>ADELANTOS: </strong></div>
                                <div class="col-12 col-sm-4"><span>0.00</span></div>
                                <div class="col-12 col-sm-8" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                                    <div class="row">
                                        <div class="col-12 col-sm-8"><strong>Total a Pagar</strong></div>
                                        <div class="col-12 col-sm-4"><span>0.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                
                `;
                $('#MostradorlistVueltoGrupo').html('<span>Cambio: 0.00</span>');
                $('#btnConfirmarPagoGrupo').prop('disabled', true);
            });
            
            var DivMostradorListPagos = document.getElementById('MostradorListPagosGrupo');
            DivMostradorListPagos.innerHTML = `
                <div class="row" style="background: #F5F7F8; border: 1px solid white">
                    <div class="col-12 col-sm-12">
                        <div class="row" style="font-size: 16px">
                            <div class="col-12 col-sm-8"><strong>TOTAL HOSPEDAJE: </strong></div>
                            <div class="col-12 col-sm-4"><span>${grupo.TotalHospedaje}</span></div>
                            <div class="col-12 col-sm-8"><strong>SUBTOTAL: </strong></div>
                            <div class="col-12 col-sm-4"><span>${grupo.SubTotal}</span></div>
                            <div class="col-12 col-sm-8"><strong>ADELANTOS: </strong></div>
                            <div class="col-12 col-sm-4"><span>${grupo.Adelanto}</span></div>
                            <div class="col-12 col-sm-8" style="background: #1b293a; color: white; width: 100%; padding: 5px; margin: 1px;">
                                <div class="row">
                                    <div class="col-12 col-sm-8"><strong>Total a Pagar</strong></div>
                                    <div class="col-12 col-sm-4"><span>${grupo.Total}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            `;
            
            $('#MostradoraddPagosGrupo').off('click').on('click', function () {
                var nuevoPago = $('<div style="padding: 4px; margin: 4px"></div>').html(`
                    <div class="row">
                        <div class="col-sm-4">
                            <select class="form-control" id="TipoPagoGrupoSelect">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Deposito/QR">Deposito/QR</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control monedaGrupoSelect" id="TipoMonedaPagoGrupoSelect">
                                <option value="Bs">Bs.</option>
                                <option value="Dolar">$</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control montoPagoInputGrupoSelect" id="MontoPagoGrupoSelect" style="width: 100%; display: inline-block;">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn position-relative btnEliminarPagoGrupoSelect" type="button">x</button>
                        </div>
                    </div>
                `);

                $('#ListPagosGrupo').append(nuevoPago);

                nuevoPago.find('.btnEliminarPagoGrupoSelect').off('click').on('click', function () {
                    $(this).closest('.row').parent().remove();
                    calcularYMostrarCambio();
                });

                nuevoPago.find('.montoPagoInputGrupoSelect').off('input').on('input', function () {
                    calcularYMostrarCambio();
                });

                calcularYMostrarCambio();
            });



            var primerPago = document.createElement('div');
            
            if(grupo.Total == 0){
                primerPago.innerHTML = `
                    <div style="padding: 4px; margin: 4px">
                        <div class="row">
                            <span style="color: red">No tiene Ninguna deuda pediente!!</span>
                        </div>                        
                    </div>
                `;
                $('#MostradoraddPagosGrupo').hide();

                document.getElementById('ListPagosGrupo').appendChild(primerPago);

            }else{
                $('#MostradoraddPagosGrupo').show();
                
                primerPago.innerHTML = `
                    <div style="padding: 4px; margin: 4px">
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="form-control" id="TipoPagoGrupoSelect">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Deposito/QR">Deposito/QR</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control monedaGrupoSelect" id="TipoMonedaPagoGrupoSelect">
                                    <option value="Bs">Bs.</option>
                                    <option value="Dolar">$</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control montoPagoInputGrupoSelect" value="${grupo.Total}" id="MontoPagoGrupoSelect" style="width: 100%; display: inline-block;">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn position-relative btnEliminarPago" type="button">x</button>
                            </div>
                        </div>                        
                    </div>
                `;

                document.getElementById('ListPagosGrupo').appendChild(primerPago);

                primerPago.querySelector('.montoPagoInputGrupoSelect').addEventListener('input', function () {
                    calcularYMostrarCambio();
                });

                calcularYMostrarCambio();

                function calcularYMostrarCambio() {
                    var elementosPagos = document.querySelectorAll('#ListPagosGrupo > div');
                
                    var totalPagos = 0;
                    elementosPagos.forEach(function (elementoPago) {
                        var montoPago = parseFloat(elementoPago.querySelector('.montoPagoInputGrupoSelect').value) || 0;
                        var tipoMoneda = elementoPago.querySelector('#TipoMonedaPagoGrupoSelect').value;
                
                        // Si la moneda es Dólar, multiplicar por 7
                        if (tipoMoneda === 'Dolar') {
                            montoPago *= 7;
                        }
                
                        totalPagos += montoPago;
                    });
                
                    var limitePago = parseFloat(grupo.Total) || 0;
                    var cambio = totalPagos - limitePago;
                
                    var listVuelto = document.getElementById('MostradorlistVueltoGrupo');
                    listVuelto.innerHTML = `
                        <span>Cambio: ${cambio.toFixed(2)}</span>
                    `;
                    actualizarEstadoBoton(cambio);
                }

                function actualizarEstadoBoton(cambio) {
                    var btnConfirmarPago = document.getElementById('btnConfirmarPagoGrupo');
                    btnConfirmarPago.disabled = cambio < 0;
                }

            }            
            
            $('#btnConfirmarPagoGrupo').off('click').on('click', function (event) {
                if(grupo.Total == 0){
                    var GrupoSelectId = grupo.id
                    $.ajax({
                        url: '/apihostal/concluir-grupo-hospedaje-finalizar',
                        type: 'POST',
                        data: {
                            _token: token,
                            GrupoSelectId: GrupoSelectId,
                        },
                        success: function (data) {
                            MostrarHabitaciones();
                            CanvasTime();
                            MostrarMensaje("Hospedaje Concluida Exitosamente", "success")                     
                        },
                        error: function (error) {
                            MostrarMensaje("No ce puedo concluir", "error");
                        },
                        complete: function() {
                            $('#btnConfirmarPago').prop('disabled', false);
                        }
                    });
                }else{
                    $(this).prop('disabled', true);
                    event.preventDefault();
                    var elementosPagos = $('#ListPagosGrupo > div');
                    var pagos = [];
                    var GrupoSelectId = grupo.id

                    elementosPagos.each(function () {
                        var tipoPagoGrupoSelect = $(this).find('.form-control').val();
                        var tipomonedaPagoGrupoSelect = $(this).find('.monedaGrupoSelect').val();
                        var montoPagoGrupoSelect = parseFloat($(this).find('.montoPagoInputGrupoSelect').val()) || 0;
                        pagos.push({
                            tipo: tipoPagoGrupoSelect,
                            moneda: tipomonedaPagoGrupoSelect,
                            cantidad: montoPagoGrupoSelect
                        });
                    });
                    var token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '/apihostal/concluir-grupo-hospedaje-finalizar',
                        type: 'POST',
                        data: {
                            _token: token,
                            pagos: pagos,
                            GrupoSelectId: GrupoSelectId,
                        },
                        success: function (data) {
                            MostrarHabitaciones();
                            CanvasTime();
                            MostrarMensaje("Hospedaje Concluida Exitosamente", "success")                     
                        },
                        error: function (error) {
                            MostrarMensaje("No ce puedo concluir", "error");
                        },
                        complete: function() {
                            $('#btnConfirmarPago').prop('disabled', false);
                        }
                    });
                }                
            });

        });

      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error al ocupar la habitación:', textStatus, errorThrown);
      }
  });

  function formatearFecha(fecha) {
    const nuevaFecha = new Date(fecha);
    const year = nuevaFecha.getFullYear();
    const month = (nuevaFecha.getMonth() + 1).toString().padStart(2, '0');
    const day = nuevaFecha.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
  }
}

