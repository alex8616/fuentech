$(document).ready(function() {
    filtrarDatosArqueo()
    FechaSelectArqueo()
});

$(document).ready(function() {
    document.getElementById('addarqueocajas').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Arqueo De Caja</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Hora De Apertura</label>
                        <div class="col">
                             <div class="mb-3 row">
                                <div class="col-8">
                                    <input type="date" class="form-control" id="FechaRegistro" name="FechaRegistro">
                                </div>
                                <div class="col-4">
                                    <input type="time" class="form-control" id="HoraRegistro" name="HoraRegistro">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Monto Inicial</label>
                        <div class="col">
                        <input type="text" class="form-control" id="MontoIncial" name="MontoIncial">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-arqueo">REGISTRAR</button>
                </div>
            </div>
            <div id="alertteam" style="width: 100%; padding: 20px">

            </div>
        </form>
        `;

        $('#btn-registrar-arqueo').off('click').on('click', function(event) {
            $.ajax({
                url: '/api/evaluar-arqueo-caja',
                type: 'GET',
                success: function (response) {
                    if(response == "true"){
                        var FechaRegistro = $("#FechaRegistro").val();
                        var HoraRegistro = $("#HoraRegistro").val();
                        var MontoIncial = $("#MontoIncial").val();

                        var formData = new FormData();
                        formData.append('FechaRegistro', FechaRegistro);
                        formData.append('HoraRegistro', HoraRegistro);
                        formData.append('MontoIncial', MontoIncial);

                        $.ajax({
                            url: '/api/registrar-arqueo-caja',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (arqueocaja) {
                                filtrarDatosArqueo(response);
                                MostrarMensaje("Producto Creada Exitosamente", "success");
                                $("#FechaRegistro").val("");
                                $("#HoraRegistro").val("");
                                $("#MontoIncial").val("");
                            },
                            error: function (error) {
                                console.error('Error al registrar:', error);
                            }
                        });
                    }else{
                        var divalerta = document.getElementById('alertteam');
                        divalerta.innerHTML = `
                            <div class="alert alert-important alert-danger alert-dismissible" role="alert" id="temporary-alert">
                                <div class="d-flex">
                                    <div>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                                        </div>
                                        <div>
                                            No Puedes Registrar Tienes Una Caja Abierta ..
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        setTimeout(function() {
                            var alert = document.getElementById('temporary-alert');
                            if (alert) {
                                alert.remove();
                            }
                        }, 5000);
                    }
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});

function FechaSelectArqueo() {
    filtrarDatosArqueo();

    $('#EstadoArqueo').on('change', function() {
        filtrarDatosArqueo();
    });
}

function filtrarDatosArqueo() {
    var EstadoArqueo = $('#EstadoArqueo').val();

    $.ajax({
        url: 'api/filtrar-datos-arqueo',
        method: 'GET',
        data: {
            EstadoArqueo: EstadoArqueo,
        },
        success: function(response) {
            mostrarResultadosArqueo(response);
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function mostrarResultadosArqueo(filteredData) {
    $('#tabla-arqueocaja tbody').empty();
    $.each(filteredData, function(index, arqueocaja) {
        if(arqueocaja.Estado === 'Eliminado'){
            var row = '<tr>' +
                '<td hidden>' + arqueocaja.id + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + formatarFecha(arqueocaja.created_at) + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + formatarFecha(arqueocaja.updated_at) + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + arqueocaja.Segun_SistemaTotal + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + arqueocaja.Segun_UsuarioTotal + '</td>' +
                '<td style="text-decoration: line-through; color: #686D76">' + arqueocaja.Diferencia + '</td>' +
                '<td>' + '<span class="badge badge-outline text-blue" style="font-weight: bold; text-decoration: line-through; color: #686D76">Eliminado</span>' +'</td>';
                '<td style="text-decoration: line-through; color: #686D76">' + arqueocaja.Estado + '</td>' +
                '</tr>';

            $('#tabla-arqueocaja tbody').append(row);
        }else{
            var row = '<tr>' +
                '<td hidden>' + arqueocaja.id + '</td>' +
                '<td>' + formatarFecha(arqueocaja.created_at) + '</td>' +
                '<td>' + formatarFecha(arqueocaja.updated_at) + '</td>' +
                '<td>' + arqueocaja.Segun_SistemaTotal + '</td>' +
                '<td>' + arqueocaja.Segun_UsuarioTotal + '</td>' +
                '<td>' + arqueocaja.Diferencia + '</td>' +
                '<td style="font-weight: bold;">' +
                ((arqueocaja.Estado === 'Abierto') ?
                    '<span class="badge badge-outline text-green">Abierto</span>' :
                    (arqueocaja.Estado === 'Cerrado' ?
                        '<span class="badge badge-outline text-red">Cerrado</span>' :
                        '<span class="badge badge-outline text-gray">Eliminado</span>')) +
                '</td>';
                '<td>' + arqueocaja.Estado + '</td>' +
                '</tr>';

            $('#tabla-arqueocaja tbody').append(row);
        }
    });

    agregarEventosMovimientoTabla();

    $('#tabla-arqueocaja tbody').on('click', 'tr', function() {
        $('#tabla-arqueocaja tbody tr').removeClass('selected-row');
        $(this).addClass('selected-row');

        var id = $(this).find('td:first').text();
        $.ajax({
            url: '/api/get-arqueo-seleccionado/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                InformacionArqueo(data);
            },
            error: function(error) {
                console.error('Error al recuperar datos de producto:', error);
            }
        });
    });
}


function agregarEventosMovimientoTabla() {
    $('#tabla-venta tbody tr').hover(function() {
        $(this).addClass('hovered');
    }, function() {
        $(this).removeClass('hovered');
    });
    $('#tabla-venta tbody tr').click(function() {
        $('#tabla-venta tbody tr').removeClass('tableproducseleccionado');
        $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
    });
}

function converNumber(){
    const inputs = document.querySelectorAll('.currency-input');

    inputs.forEach(input => {
        input.addEventListener('focus', (e) => {
            if (e.target.value === '0.00') {
                e.target.value = '';
            }
        });

        input.addEventListener('blur', (e) => {
            if (e.target.value === '') {
                e.target.value = '0.00';
            } else {
                e.target.value = parseFloat(e.target.value).toFixed(2);
            }
        });

        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^\d.]/g, '');
        });

        input.addEventListener('input', SumTotalUsuario);
        input.addEventListener('blur', SumTotalUsuario);
    });
}

function SumTotalUsuario(){
    let Sumatotal = 0;
    let diferencia = 0;
    let valorTotalSistema = 0;
    let valorfinalUsuario = 0;
    const inputs = document.querySelectorAll('.currency-input');

    inputs.forEach(input => {
        let value = parseFloat(input.value);
        if (!isNaN(value)) {
            Sumatotal += value;
        }
    });

    valorTotalSistema = document.getElementById('txtSegun_UsuarioTotal').value = Sumatotal.toFixed(2);
    valorfinalUsuario = document.getElementById('txtDiferencia').value;
    valorfinalUsuarioEvaluado = valorfinalUsuario
    if(valorfinalUsuario > 0){
        Diferencia = valorTotalSistema - valorfinalUsuarioEvaluado
    }else{
        valorfinalUsuarioEvaluado
        Diferencia = Math.abs(valorTotalSistema) - Math.abs(valorfinalUsuarioEvaluado);
    }
    document.getElementById('txtDiferenciaRecogido').value = Diferencia .toFixed(2);

    //aparecer boton
    const input = document.getElementById('txtDiferenciaRecogido');
    const button = document.getElementById('btn-cerrar-arqueo');
    input.addEventListener('input', function () {
        const value = parseFloat(input.value);
        if (value > 0) {
            button.style.display = 'inline-block';
        } else {
            button.style.display = 'none';
        }
    });

    if (parseFloat(input.value) > 0) {
        button.style.display = 'inline-block';
    } else {
        button.style.display = 'none';
    }
}

function InformacionArqueo(data){
    var TotalProduct = document.getElementById('form_tabs');
    if(data[0].Estado == "Abierto"){
        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">ARQUEO DE CAJA ${data[0].id}</h3>
                    <div class="card-actions">

                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Hora De Apertura</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${formatarFecha(data[0].created_at)}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Creado Por</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].user.name}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">
                                    ${((data[0].Estado === 'Abierto') ?
                                        '<span class="badge badge-outline text-green">Abierto</span>' :
                                        (data[0].Estado === 'Cerrado' ?
                                            '<span class="badge badge-outline text-red">Cerrado</span>' :
                                            '<span class="badge badge-outline text-gray">Eliminado</span>'))}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">SEGUN SISTEMA</h3>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="accordion" id="accordion-example">
                        <div class="accordion-item" style="padding: 10px">
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                        MONTO INICIAL
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].MontoInicial}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="row" style="margin: 0;">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisListIngreso" aria-expanded="false" style="font-size: 15px; cursor: pointer;">
                                        INGRESO
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].Segun_SistemaTotalIngreso}
                                    </h2>
                                </div>
                            </div>

                            <div id="SisListIngreso" class="accordion-collapse collapse" data-bs-parent="#accordion-Ingreso">
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoEfectivo > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0;">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisEfectivo" aria-expanded="false" style="font-size: 15px">
                                                    Efectivo
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoEfectivo}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisEfectivo" class="accordion-collapse collapse" data-bs-parent="#accordion-efectivo">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoTarjeta > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisTarjeta" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Tarjeta De Credito
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoTarjeta}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisTarjeta" class="accordion-collapse collapse" data-bs-parent="#accordion-tarjeta">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoDepositoQR > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisDeposito" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Deposito QR
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoDepositoQR}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisDeposito" class="accordion-collapse collapse" data-bs-parent="#accordion-deposito">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                            </div>

                        </div>

                        <div class="accordion-item">
                            <div class="row" style="margin: 0;">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisListEgreso" aria-expanded="false" style="font-size: 15px; cursor: pointer;">
                                        EGRESO
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        - ${data[0].Segun_SistemaTotalEgreso}
                                    </h2>
                                </div>
                            </div>

                            <div id="SisListEgreso" class="accordion-collapse collapse" data-bs-parent="#accordion-Egreso">
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoEfectivo > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0;">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisEfectivo" aria-expanded="false" style="font-size: 15px">
                                                    Efectivo
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoEfectivo}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisEfectivo" class="accordion-collapse collapse" data-bs-parent="#accordion-efectivo">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoTarjeta > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisTarjeta" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Tarjeta De Credito
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoTarjeta}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisTarjeta" class="accordion-collapse collapse" data-bs-parent="#accordion-tarjeta">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoDepositoQR > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisDeposito" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Deposito QR
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoDepositoQR}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisDeposito" class="accordion-collapse collapse" data-bs-parent="#accordion-deposito">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" style="padding: 10px; background: #e5e5e5">
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                        TOTAL
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].Segun_SistemaTotal}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">SEGUN USUARIO</h3>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label required">Efectivo</label>
                            <div class="col">
                                <div class="mb-3 row">
                                    <div class="col-12">
                                        <input type="text" class="form-control currency-input" id="SUEfectivo" name="SUEfectivo" value="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>

                        ${data[0].Segun_SistemaEgresoTarjeta > 0 || data[0].Segun_SistemaIngresoTarjeta > 0 ? `
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label required">Tarjeta</label>
                            <div class="col">
                                <div class="mb-3 row">
                                    <div class="col-12">
                                        <input type="text" class="form-control currency-input" id="SUTarjeta" name="SUTarjeta" value="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>
                        ` : ``}

                        ${data[0].Segun_SistemaEgresoDepositoQR > 0 || data[0].Segun_SistemaIngresoDepositoQR > 0 ? `
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label required">Deposito QR</label>
                            <div class="col">
                                <div class="mb-3 row">
                                    <div class="col-12">
                                        <input type="text" class="form-control currency-input" id="SUDepositoQR" name="SUDepositoQR" value="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>
                        ` : ``}

                        <div class="mb-3 row">
                            <label class="col-4 col-form-label required">Comentario</label>
                            <div class="col">
                            <textarea type="text" class="form-control" id="SegunUsuarioComentario" name="SegunUsuarioComentario"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="accordion-item" style="padding: 10px; background: #e5e5e5">
                                <div class="row">
                                    <div class="col-12 col-sm-8">
                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                            TOTAL
                                        </h2>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right">
                                        <input type="text" id="txtSegun_UsuarioTotal" class="form-control" disable>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" style="background: red; color: white; font-weight: bold;">
                    <h3 class="card-title">DIFERENCIA</h3>
                    <div class="card-actions">
                        <input type="text" id="txtDiferenciaRecogido" class="form-control" value="${data[0].Segun_SistemaTotal}" style="color: black" >
                        <input type="text" id="txtDiferencia" class="form-control" value="${data[0].Segun_SistemaTotal}" style="color: black" hidden>
                    </div>
                </div>
                <div class="card-header">
                    <a id="btn-cerrar-arqueo" class="btn btn-outline-success w-100" style="display: none;">Enviar</a>
                </div>
            </div>
        </div>`;

        $('#btn-cerrar-arqueo').off('click').on('click', function(event) {
            var idarqueo = data[0].id;
            var InputEfectivo = $("#SUEfectivo").val();
            var InputTarjeta = $("#SUTarjeta").val();
            var InputDeposito = $("#SUDepositoQR        ").val();
            var InputComentario = $("#SegunUsuarioComentario").val();
            var diferencia = $("#txtDiferenciaRecogido").val();
            var total = $("#txtSegun_UsuarioTotal").val();

            var formData = new FormData();
            formData.append('idarqueo', idarqueo);
            formData.append('InputEfectivo', InputEfectivo);
            formData.append('InputTarjeta', InputTarjeta);
            formData.append('InputDeposito', InputDeposito);
            formData.append('InputComentario', InputComentario);
            formData.append('diferencia', diferencia);
            formData.append('total', total);

            $.ajax({
                url: '/api/cerrar-arqueo-caja',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (arqueocaja) {
                    CanvasTime()
                    filtrarDatosArqueo()
                    MostrarMensaje("Se Cerro La Caja Exitosamente", "success");
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    }else if(data[0].Estado == "Cerrado"){
        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">ARQUEO DE CAJA ${data[0].id}</h3>
                    <div class="card-actions">
                    <center>
                        <a class="btn btn-outline-danger" id="btn-delete-arqueo" style="width: 40%; padding-left: 65%" data-bs-toggle="modal" data-bs-target="#modal-delete-arqueo">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="32"  height="32"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7h16" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>
                        </a>
                    </center>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Hora De Apertura</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${formatarFecha(data[0].created_at)}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Creado Por</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].user.name}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">
                                    ${((data[0].Estado === 'Abierto') ?
                                        '<span class="badge badge-outline text-green">Abierto</span>' :
                                        (data[0].Estado === 'Cerrado' ?
                                            '<span class="badge badge-outline text-red">Cerrado</span>' :
                                            '<span class="badge badge-outline text-gray">Eliminado</span>'))}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">SEGUN SISTEMA</h3>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="accordion" id="accordion-example">
                        <div class="accordion-item" style="padding: 10px">
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                        MONTO INICIAL
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].MontoInicial}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="row" style="margin: 0;">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisListIngreso" aria-expanded="false" style="font-size: 15px; cursor: pointer;">
                                        INGRESO
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].Segun_SistemaTotalIngreso}
                                    </h2>
                                </div>
                            </div>

                            <div id="SisListIngreso" class="accordion-collapse collapse" data-bs-parent="#accordion-Ingreso">
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoEfectivo > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0;">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisEfectivo" aria-expanded="false" style="font-size: 15px">
                                                    Efectivo
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoEfectivo}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisEfectivo" class="accordion-collapse collapse" data-bs-parent="#accordion-efectivo">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoTarjeta > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisTarjeta" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Tarjeta De Credito
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoTarjeta}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisTarjeta" class="accordion-collapse collapse" data-bs-parent="#accordion-tarjeta">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoDepositoQR > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisDeposito" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Deposito QR
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoDepositoQR}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisDeposito" class="accordion-collapse collapse" data-bs-parent="#accordion-deposito">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                            </div>

                        </div>

                        <div class="accordion-item">
                            <div class="row" style="margin: 0;">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisListEgreso" aria-expanded="false" style="font-size: 15px; cursor: pointer;">
                                        EGRESO
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        - ${data[0].Segun_SistemaTotalEgreso}
                                    </h2>
                                </div>
                            </div>

                            <div id="SisListEgreso" class="accordion-collapse collapse" data-bs-parent="#accordion-Egreso">
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoEfectivo > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0;">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisEfectivo" aria-expanded="false" style="font-size: 15px">
                                                    Efectivo
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoEfectivo}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisEfectivo" class="accordion-collapse collapse" data-bs-parent="#accordion-efectivo">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoTarjeta > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisTarjeta" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Tarjeta De Credito
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoTarjeta}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisTarjeta" class="accordion-collapse collapse" data-bs-parent="#accordion-tarjeta">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoDepositoQR > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisDeposito" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Deposito QR
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoDepositoQR}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisDeposito" class="accordion-collapse collapse" data-bs-parent="#accordion-deposito">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" style="padding: 10px; background: #e5e5e5">
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                        TOTAL
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].Segun_SistemaTotal}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">SEGUN USUARIO</h3>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    Efectivo
                                </h2>
                            </div>
                            <div class="col-12 col-sm-4" style="text-align: right">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    ${data[0].Segun_UsuarioEfectivo}
                                </h2>
                            </div>
                        </div>

                        ${data[0].Segun_SistemaEgresoTarjeta > 0 || data[0].Segun_SistemaIngresoTarjeta > 0 ? `
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    Tarjeta
                                </h2>
                            </div>
                            <div class="col-12 col-sm-4" style="text-align: right">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    ${data[0].Segun_UsuarioTarjeta}
                                </h2>
                            </div>
                        </div>
                        ` : ``}

                        ${data[0].Segun_SistemaEgresoDepositoQR > 0 || data[0].Segun_SistemaIngresoDepositoQR > 0 ? `
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    Deposito QR
                                </h2>
                            </div>
                            <div class="col-12 col-sm-4" style="text-align: right">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    ${data[0].Segun_UsuarioDepositoQR}
                                </h2>
                            </div>
                        </div>
                        ` : ``}

                        <div class="mb-3 row">
                            <label class="col-4 col-form-label">Comentario</label>
                            <div class="col">
                                <label class="col-12 col-form-label">${data[0].Segun_UsuarioComentario}</label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="accordion-item" style="padding: 10px; background: #e5e5e5">
                                <div class="row">
                                    <div class="col-12 col-sm-8">
                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                            TOTAL
                                        </h2>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right">
                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                            ${data[0].Segun_UsuarioTotal}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" style="background: red; color: white; font-weight: bold;">
                    <h3 class="card-title">DIFERENCIA</h3>
                    <div class="card-actions">
                        <h3 class="card-title">${data[0].Diferencia}</h3>
                    </div>
                </div>
            </div>
        </div>`;

        $('#btn-delete-arqueo').on('click', function(event) {
            var idarqueo = data[0].id

            $('#confirmDeleteBtnArqueo').one('click', function () {
                var formData = new FormData();
                formData.append('idarqueo', idarqueo);

                $.ajax({
                    url: '/api/delete-arqueo-caja',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (arqueocaja) {
                        CanvasTime();
                        filtrarDatosArqueo();
                        MostrarMensaje("Se Eliminó Exitosamente", "success");
                    },
                    error: function (error) {
                        console.error('Error al eliminar:', error);
                    }
                });
            });
        });
    }else{
        TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">ARQUEO DE CAJA ${data[0].id}</h3>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Hora De Apertura</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${formatarFecha(data[0].created_at)}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Creado Por</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data[0].user.name}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Estado</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">
                                    ${((data[0].Estado === 'Abierto') ?
                                        '<span class="badge badge-outline text-green">Abierto</span>' :
                                        (data[0].Estado === 'Cerrado' ?
                                            '<span class="badge badge-outline text-red">Cerrado</span>' :
                                            '<span class="badge badge-outline text-blue">Eliminado</span>'))}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">SEGUN SISTEMA</h3>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="accordion" id="accordion-example">
                        <div class="accordion-item" style="padding: 10px">
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                        MONTO INICIAL
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].MontoInicial}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="row" style="margin: 0;">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisListIngreso" aria-expanded="false" style="font-size: 15px; cursor: pointer;">
                                        INGRESO
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].Segun_SistemaTotalIngreso}
                                    </h2>
                                </div>
                            </div>

                            <div id="SisListIngreso" class="accordion-collapse collapse" data-bs-parent="#accordion-Ingreso">
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoEfectivo > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0;">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisEfectivo" aria-expanded="false" style="font-size: 15px">
                                                    Efectivo
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoEfectivo}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisEfectivo" class="accordion-collapse collapse" data-bs-parent="#accordion-efectivo">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoTarjeta > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisTarjeta" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Tarjeta De Credito
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoTarjeta}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisTarjeta" class="accordion-collapse collapse" data-bs-parent="#accordion-tarjeta">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaIngresoDepositoQR > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisDeposito" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Deposito QR
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaIngresoDepositoQR}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisDeposito" class="accordion-collapse collapse" data-bs-parent="#accordion-deposito">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaIngresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Ventas
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalVentaCajaIngresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                            </div>

                        </div>

                        <div class="accordion-item">
                            <div class="row" style="margin: 0;">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisListEgreso" aria-expanded="false" style="font-size: 15px; cursor: pointer;">
                                        EGRESO
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        - ${data[0].Segun_SistemaTotalEgreso}
                                    </h2>
                                </div>
                            </div>

                            <div id="SisListEgreso" class="accordion-collapse collapse" data-bs-parent="#accordion-Egreso">
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoEfectivo > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0;">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisEfectivo" aria-expanded="false" style="font-size: 15px">
                                                    Efectivo
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoEfectivo}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisEfectivo" class="accordion-collapse collapse" data-bs-parent="#accordion-efectivo">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoEfectivo}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoTarjeta > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisTarjeta" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Tarjeta De Credito
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoTarjeta}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisTarjeta" class="accordion-collapse collapse" data-bs-parent="#accordion-tarjeta">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoTarjeta}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                                <div style="margin-left: 40px; padding: 10px">
                                    ${data[0].Segun_SistemaEgresoDepositoQR > 0 ? `
                                    <div>
                                        <div class="row" style="margin: 0; font-size: 14px; color: red">
                                            <div class="col-12 col-sm-8">
                                                <h2 class="accordion-header" id="heading-1" data-bs-toggle="collapse" data-bs-target="#SisDeposito" aria-expanded="false" style="font-size: 15px; color: black">
                                                    Deposito QR
                                                </h2>
                                            </div>
                                            <div class="col-12 col-sm-4" style="text-align: left; color: black">
                                                <h2 class="accordion-header" id="heading-1">
                                                    ${data[0].Segun_SistemaEgresoDepositoQR}
                                                </h2>
                                            </div>
                                        </div>
                                        <div id="SisDeposito" class="accordion-collapse collapse" data-bs-parent="#accordion-deposito">
                                            <div class="accordion-body pt-0">
                                                <div class="row" style="margin: 10; font-size: 18px;">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Movimiento de Caja
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left;">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalMovimientoCajaEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Gastos
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalGastoEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin: 10; font-size: 18px">
                                                    <div class="col-12 col-sm-6">
                                                        <h2 class="accordion-header" style="font-size: 14px; color: #61677A">
                                                            Pagos proovedores
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 col-sm-4" style="text-align: left">
                                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px; color: #61677A">
                                                            ${data[0].TotalCuentaProveedorEgresoDepositoQR}
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        ` : ``}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item" style="padding: 10px; background: #e5e5e5">
                            <div class="row">
                                <div class="col-12 col-sm-8">
                                    <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                        TOTAL
                                    </h2>
                                </div>
                                <div class="col-12 col-sm-4" style="text-align: right">
                                    <h2 class="accordion-header" id="heading-1">
                                        ${data[0].Segun_SistemaTotal}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">SEGUN USUARIO</h3>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    Efectivo
                                </h2>
                            </div>
                            <div class="col-12 col-sm-4" style="text-align: right">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    ${data[0].Segun_UsuarioEfectivo}
                                </h2>
                            </div>
                        </div>

                        ${data[0].Segun_SistemaEgresoTarjeta > 0 || data[0].Segun_SistemaIngresoTarjeta > 0 ? `
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    Tarjeta
                                </h2>
                            </div>
                            <div class="col-12 col-sm-4" style="text-align: right">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    ${data[0].Segun_UsuarioTarjeta}
                                </h2>
                            </div>
                        </div>
                        ` : ``}

                        ${data[0].Segun_SistemaEgresoDepositoQR > 0 || data[0].Segun_SistemaIngresoDepositoQR > 0 ? `
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    Deposito QR
                                </h2>
                            </div>
                            <div class="col-12 col-sm-4" style="text-align: right">
                                <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                    ${data[0].Segun_UsuarioDepositoQR}
                                </h2>
                            </div>
                        </div>
                        ` : ``}

                        <div class="mb-3 row">
                            <label class="col-4 col-form-label">Comentario</label>
                            <div class="col">
                                <label class="col-12 col-form-label">${data[0].Segun_UsuarioComentario}</label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="accordion-item" style="padding: 10px; background: #e5e5e5">
                                <div class="row">
                                    <div class="col-12 col-sm-8">
                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                            TOTAL
                                        </h2>
                                    </div>
                                    <div class="col-12 col-sm-4" style="text-align: right">
                                        <h2 class="accordion-header" id="heading-1" style="font-size: 15px">
                                            ${data[0].Segun_UsuarioTotal}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" style="background: red; color: white; font-weight: bold;">
                    <h3 class="card-title">DIFERENCIA</h3>
                    <div class="card-actions">
                        <h3 class="card-title">${data[0].Diferencia}</h3>
                    </div>
                </div>
            </div>
        </div>`;
    }
    converNumber()
    SumTotalUsuario()
}

//formatear fecha
function formatarFecha(fechaString) {
    const fecha = new Date(fechaString);

    const dia = fecha.getDate();
    const mes = fecha.getMonth() + 1;
    const anio = fecha.getFullYear();
    const hora = fecha.getHours();
    const minutos = fecha.getMinutes();
    const segundos = fecha.getSeconds();

    const diaStr = (dia < 10 ? '0' : '') + dia;
    const mesStr = (mes < 10 ? '0' : '') + mes;
    const horaStr = (hora < 10 ? '0' : '') + hora;
    const minutosStr = (minutos < 10 ? '0' : '') + minutos;
    const segundosStr = (segundos < 10 ? '0' : '') + segundos;

    return `${diaStr}/${mesStr}/${anio} ${horaStr}:${minutosStr}:${segundosStr}`;
}
