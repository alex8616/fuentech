$(document).ready(function() {  
    document.getElementById('addinventario').addEventListener('click', function() {
        var formTabsDiv = document.getElementById('form_tabs');
        formTabsDiv.innerHTML = `
        <form id="form-register-product">
            <div class="card-header">
                <h3 class="card-title">Nuevo Cliente</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Perteneciente a</label>
                        <div class="col">
                            <select class="form-control" id="PerteneceCategoria">
                                <option value="Hostal">Hostal</option>
                                <option value="Restaurante">Restaurante</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Nombre</label>
                        <div class="col">
                        <input type="text" class="form-control" id="NombreCategoria" name="NombreCategoria">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-4 col-form-label required">Descripcion</label>
                        <div class="col">
                        <input type="mail" class="form-control" id="DescripcionCategoria" name="DescripcionCategoria">
                        </div>
                    </div>
                </div>                    
            </div>
            <div class="card-footer">
                <div class="d-flex" style="text-align: right">
                    <button type="button" class="btn me-auto">CANCELAR</button>
                    <button type="button" class="btn btn-primary" id="btn-registrar-categoria">GUARDAR</button>
                </div>
            </div>
        </form>
        `;

        $('#btn-registrar-categoria').off('click').on('click', function(event) {
            var PerteneceCategoria = $("#PerteneceCategoria").val();
            var NombreCategoria = $("#NombreCategoria").val();
            var DescripcionCategoria = $("#DescripcionCategoria").val();

            var formData = new FormData();
            formData.append('PerteneceCategoria', PerteneceCategoria);
            formData.append('NombreCategoria', NombreCategoria);
            formData.append('DescripcionCategoria', DescripcionCategoria);
            
            $.ajax({
                url: '/apihostal/registrar-categoria-recurso',
                type: 'POST',
                data: formData, 
                contentType: false,
                processData: false,
                success: function (cliente) {
                    ListarDatosCategoriaRecursos()
                    CanvasTime()
                    MostrarMensaje("Creado Exitosamente","success")
                },
                error: function (error) {
                    console.error('Error al registrar:', error);
                }
            });
        });

    });
});