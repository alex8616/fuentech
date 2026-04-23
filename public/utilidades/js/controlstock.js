function FiltrarDatos(){
    $.ajax({
        url: '/api/get-proveedor',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var proveedorSelect = $('#ProveedorStock');
            data.forEach(function(proveedor) {
                proveedorSelect.append('<option value="' + proveedor.id + '">' + proveedor.name + '</option>');
            });
        },
        error: function(error) {
            console.error('Error al obtener proveedores:', error);
        }
    });

    function actualizarTablaProductos(productos) {
        $('#tabla-stockproducto tbody').empty();
        $.each(productos, function(index, producto) {
            var borderStyle = (producto.MinimoStock > 0) ? 'border-left: 4px solid red;' : 'border-left: 4px solid green;';
            var row = '<tr style="' + borderStyle + '">' +
                '<td hidden>' + producto.id + '</td>' +
                '<td>' + producto.NombreProducto + '</td>' +
                '<td>' + (producto.stockdates[0].StockMinimo) + '</td>' +
                '<td>' + (producto.stockdates[0].Cantidad) + '</td>' +
                '</tr>';
            $('#tabla-stockproducto tbody').append(row);
        });

        agregarEventosTabla();

        $('#tabla-stockproducto tbody').on('click', 'tr', function() {
            var id = $(this).find('td:first').text();
            $.ajax({
                url: '/api/get-productos-seleccionado/' + id,
                type: 'GET', 
                dataType: 'json',
                success: function(data) {
                    InformacionProductoStock(data);
                },
                error: function(error) {
                    console.error('Error al recuperar datos de producto:', error);
                }
            });
        });
    }
}

function MostrarTablaProductStock(){
    $.ajax({
        url: 'api/get-productos-stock',
        type: 'GET',
        success: function(data) {
            $('#tabla-stockproducto tbody').empty();
            $.each(data, function(index, producto) {
                var borderStyle = (producto.MinimoStock > 0) ? 'border-left: 4px solid red;' : 'border-left: 4px solid green;';
                var row = '<tr style="' + borderStyle + '">' +
                    '<td hidden>' + producto.id + '</td>' +
                    '<td>' + producto.NombreProducto + '</td>' +
                    '<td>' + (producto.stockdates[0].StockMinimo) + '</td>' +
                    '<td>' + (producto.stockdates[0].Cantidad) + '</td>' +
                    '</tr>';
                $('#tabla-stockproducto tbody').append(row);
            });

            agregarEventosTabla();

            $('#tabla-stockproducto tbody').on('click', 'tr', function() {
                var id = $(this).find('td:first').text();
                $.ajax({
                    url: '/api/get-productos-seleccionado-stock/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        InformacionProductoStock(data);
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos de producto:', error);
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function agregarEventosTabla() {
    $('#tabla-stockproducto tbody tr').hover(function() {
        $(this).addClass('hovered');
    }, function() {
        $(this).removeClass('hovered');
    });
    $('#tabla-stockproducto tbody tr').click(function() {
        $('#tabla-stockproducto tbody tr').removeClass('tableproducseleccionado');
        $(this).addClass('tableproducseleccionado').siblings().removeClass('tableproducseleccionado');
    });
}

function InformacionProductoStock(data){
    var TotalProduct = document.getElementById('form_tabs');
    TotalProduct.innerHTML = `
        <div class="col-md-6 col-lg-12">
            <div class="card">
                <div class="card-header" style="background: #1d2736; color: white; font-weight: bold;">
                    <h3 class="card-title">${data.NombreProducto}</h3>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Stock</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.stockdates[0].Cantidad}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Stock Minimo</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.stockdates[0].StockMinimo}</label>
                                </div>
                            </div>
                            <div class="mb-12 row">
                                <label class="col-4 col-form-label" style="font-weight: bold">Precio Producto</label>
                                <div class="col">
                                    <label class="col-8 col-form-label" style="color: #61677A">${data.PrecioProducto}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col d-flex justify-content-between align-items-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#ModalIngreso" id="ModalIngresoKardex" data-ingreso-id="${data.stockdates[0].id}">
                                Registrar Ingreso
                            </a>
                            <a style="color: red; font-weight: bold;" href="#" data-bs-toggle="modal" data-bs-target="#ModalFaltante" id="ModalFaltanteKardex" data-ingreso-id="${data.stockdates[0].id}">
                                Faltante / Sobrante
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-12" style="height: 100%">
                    <div class="row">
                        <div class="col-12 col-md-12" id="DetallesControlStock">
                            <!-- Aquí se cargarán los detalles de los movimientos de stock -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    let detallesControlStockHTML = '';
    data.stockdates[0].detalle_stock_dates.forEach(detalle => {
        if(detalle.TipoStock == "Ingreso"){
            detallesControlStockHTML += `
                <table class="table table-vcenter">
                    <tbody>
                        <tr style="padding: 2px; margin: 2px;">
                            <td class="w-4" style="padding: 2px; margin: 2px;">
                                <span class="legend me-2 bg-success" style="margin: 2px; padding: 2px;"></span>
                            </td>
                            <td class="td-truncate" style="padding: 2px; margin: 2px;">
                                <div class="text-truncate" style="padding: 2px; margin: 2px;">
                                    <label class="col-12 col-form-label" style="color: #61677A; padding: 2px; margin: 2px;">
                                        ${detalle.proveedores && detalle.proveedores.name ? detalle.proveedores.name : 'Sin proveedor'}
                                    </label>
                                    <label class="col-12 col-form-label" style="color: #61677A; padding: 2px; margin: 2px;">
                                        ${detalle.TipoStock} - ${detalle.DetalleStock}
                                    </label>
                                </div>
                            </td>
                            <td class="text-nowrap text-muted" style="padding: 2px; margin: 2px;">
                                <label class="col-12 col-form-label" style="color: #61677A; padding: 2px; margin: 2px;">
                                    ${detalle.Diferencia}
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            `;
        }else{
            detallesControlStockHTML += `
                <table class="table table-vcenter">
                    <tbody>
                        <tr style="padding: 2px; margin: 2px;">
                            <td class="w-4" style="padding: 2px; margin: 2px;">
                                <span class="legend me-2 bg-danger" style="margin: 2px; padding: 2px;"></span>
                            </td>
                            <td class="td-truncate" style="padding: 2px; margin: 2px;">
                                <div class="text-truncate" style="padding: 2px; margin: 2px;">
                                    <label class="col-12 col-form-label" style="color: #61677A; padding: 2px; margin: 2px;">
                                        ${detalle.TipoStock} - ${detalle.DetalleStock}
                                    </label>
                                </div>
                            </td>
                            <td class="text-nowrap text-muted" style="padding: 2px; margin: 2px;">
                                <label class="col-12 col-form-label" style="color: #61677A; padding: 2px; margin: 2px;">
                                    ${detalle.Diferencia}
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            `;
        }
        
    });

    document.getElementById('DetallesControlStock').innerHTML = detallesControlStockHTML;


    $('#ModalIngresoKardex').off('click').on('click', function(event) {
        event.preventDefault();
        var IngresoStockId = $(this).data('ingreso-id');
        console.log(IngresoStockId)
        $('#RegistrarIngresoKardex').off('click').on('click', function(event) {
            var ProveedorKardex = $("#ProveedorKardex").val();
            var CantidadIngreso = $("#CantidadIngreso").val();
            var DescripcionIngreso = $("#DescripcionIngreso").val();

            var formData = new FormData();
            formData.append('ProveedorKardex', ProveedorKardex);
            formData.append('CantidadIngreso', CantidadIngreso);
            formData.append('DescripcionIngreso', DescripcionIngreso);
            formData.append('IngresoStockId', IngresoStockId);
        
            $.ajax({
                url: '/api/registrar-ingreso-stock',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function(response) {
                    CanvasTime();
                    FiltrarDatos();
                    MostrarTablaProductStock();
                    $('#ModalIngreso').modal('hide');
                    $('#ProveedorKardex').val('');
                    $('#CantidadIngreso').val('');
                    $('#DescripcionIngreso').val('');
                    MostrarMensaje("Ingreso Registrado Exitosamente", "success");
                },
                error: function(error) {
                    console.error('Error al registrar:', error);
                }
            });
        });
    });

    $('#ModalFaltanteKardex').off('click').on('click', function(event) {
        event.preventDefault();
        var StockId = $(this).data('ingreso-id');
        cargarUsuarios()
        $('#RegistrarFaltanteKardex').off('click').on('click', function(event) {
            var ResponsableFaltante = $("#ResponsableFaltante").val();
            var CantidadFaltante = $("#CantidadFaltante").val();
            var DescripcionFaltante = $("#DescripcionFaltante").val();
            var TipoAccion = $("#TipoAccion").val();
    
            var formData = new FormData();
            formData.append('ResponsableFaltante', ResponsableFaltante);
            formData.append('CantidadFaltante', CantidadFaltante);
            formData.append('DescripcionFaltante', DescripcionFaltante);
            formData.append('StockId', StockId);
            formData.append('TipoAccion', TipoAccion);
        
            $.ajax({
                url: '/api/registrar-faltante-stock',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function(response) {
                    CanvasTime();
                    filtrarDatosKardex();
                    $('#ModalFaltante').modal('hide');
                    $('#CantidadFaltante').val('');
                    $('#ResponsableFaltante').val('');
                    $('#DescripcionFaltante').val('');
                    MostrarMensaje("Ingreso Registrado Exitosamente", "success");
                },
                error: function(error) {
                    console.error('Error al registrar:', error);
                }
            });
        });
    });
}


function cargarUsuarios() {
    $.ajax({
        url: '/api/get-usuario',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const selectResponsable = $('#ResponsableFaltante');
            selectResponsable.empty();
            selectResponsable.append('<option value="">Seleccione un usuario</option>');
            response.forEach(function(usuario) {
                selectResponsable.append(
                    `<option value="${usuario.id}">${usuario.name}</option>`
                );
            });
        },
        error: function(error) {
            console.error('Error al cargar los usuarios:', error);
        }
    });
}


$(document).ready(function() {
    FiltrarDatos();
    MostrarTablaProductStock();
});


