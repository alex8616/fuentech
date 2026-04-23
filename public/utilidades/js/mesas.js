$(document).ready(function() {     
    let Fila = 10;
    function MesasActualizar(ambienteId){
        $.ajax({
            url: 'api/get-ambiente-seleccionado/' + ambienteId,
            type: 'GET',
            dataType: 'json',
            success: function(ambiente) {          
                CanvasTime()          
                $('#restaurant-grid').empty();
                var rows= Fila;
                var cols= Fila;
                var gridContainer = $('#restaurant-grid');

                for (var i = 0; i < rows; i++) {
                    var row = $('<div>').addClass('row');
                    
                    for (var j = 0; j < cols; j++) {
                        var posX = i;
                        var posY = j;

                        var ambientemesas = ambiente[0].ambientemesas || [];

                        var mesaEnPosicion = ambientemesas.find(function(mesa) {
                            return mesa.PosisionX == posX && mesa.PosisionY == posY;
                        });

                        if (mesaEnPosicion) {
                            var mesa = $('<div>')
                                .addClass('mesa col text-center')
                                .data('mesa-id', i * cols + j + 1)
                                .data('pos-x', posX)
                                .data('pos-y', posY);

                            if (mesaEnPosicion.NombreMesas === 'circulo') {
                                mesa.append('<a class="btn btn-light btn-lg" style="width: 70%; height: 90%; border: 2px solid black; border-radius: 50%;"></a>');
                            }else if(mesaEnPosicion.NombreMesas === 'cuadrado'){
                                mesa.append('<a class="btn btn-light btn-lg" style="width: 70%; height: 70%; border: 2px solid black;"></a>');
                            } else {
                                mesa.text(mesaEnPosicion.NombreMesas);
                            }
                        } else {
                            var mesa = $('<div>')
                                .addClass('mesa col text-center')
                                .data('mesa-id', i * cols + j + 1)
                                .data('pos-x', posX)
                                .data('pos-y', posY)
                                .append('<a class="btn btn-light btn-lg abrir-modal" style="width:100%; height:100%;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg></a>');
                        }

                        row.append(mesa);
                    }

                    gridContainer.append(row);
                }
                
                
                $('.mesa').on('click', '.abrir-modal', function() {
                    var mesaId = $(this).closest('.mesa').data('mesa-id');
                    var posX = $(this).closest('.mesa').data('pos-x');
                    var posY = $(this).closest('.mesa').data('pos-y');

                    $('#myModal').modal('show');

                    $('#myModal .elegir-forma').on('click', function() {
                        var formaSeleccionada = $(this).data('forma');
                        var celda = $('.mesa[data-mesa-id="' + mesaId + '"]');
                        celda.empty().append('<div class="' + formaSeleccionada + '"></div>');
                        var token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: '/api/registrar-mesa',
                            type: 'POST',
                            data: {
                                NombreMesas: formaSeleccionada,
                                PosisionX: posX,
                                PosisionY: posY,
                                ambienteId: ambienteId,
                                _token: token,
                            },
                            success: function(mesa) {
                                MostrarMensaje("Mesa Creada Exitosamente","success");
                                MesasActualizar(ambienteId);
                            },
                            error: function(error) {
                                console.error('Error al registrar la mesa:', error);
                            }
                        });

                        $('#myModal').modal('hide');
                    });

                });
            },
            error: function(error) {
                console.error('Error al recuperar datos del ambiente seleccionado:', error);
            }
        });            
    }

    function VerMesa(ambiente) {
        $('#restaurant-grid').empty();
        var rows= Fila;
        var cols= Fila;
        var gridContainer = $('#restaurant-grid');

        for (var i = 0; i < rows; i++) {
            var row = $('<div style="padding: 10px; margin: 0px">').addClass('row');

            for (var j = 0; j < cols; j++) {
                var posX = i;
                var posY = j;
                var ambientemesas = ambiente[0].ambientemesas || [];
                var mesaEnPosicion = ambientemesas.find(function (mesa) {
                    return mesa.PosisionX == posX && mesa.PosisionY == posY;
                });

                if (mesaEnPosicion) {
                    agregarMesaConEvento(mesaEnPosicion, posX, posY);
                } else {
                    var mesa = $('<div>')
                        .addClass('mesa col text-center')
                        .data('mesa-id', i * cols + j + 1)
                        .data('pos-x', posX)
                        .data('pos-y', posY);
                    row.append(mesa);
                }
            }

            gridContainer.append(row);
        }

        function agregarMesaConEvento(mesaEnPosicion, posX, posY) {
            var mesa = $('<div style="height: 100%">')
                .addClass('mesa col text-center')
                .data('mesa-id', mesaEnPosicion.id)
                .data('pos-x', posX)
                .data('pos-y', posY);

            if(mesaEnPosicion.estado === 'libre'){
                if (mesaEnPosicion.NombreMesas === 'circulo') {
                    mesa.append(`<a class="btn btn-light btn-lg" id="mesa-btn-${mesaEnPosicion.id}" style="width: 100%; height: 100%; border: 2px solid black; border-radius: 50%;">${mesaEnPosicion.Name}</a>`);
                } else if (mesaEnPosicion.NombreMesas === 'cuadrado') {
                    mesa.append(`<a class="btn btn-light btn-lg" id="mesa-btn-${mesaEnPosicion.id}" style="width: 100%; height: 100%; border: 2px solid black;">${mesaEnPosicion.Name}</a>`);
                } else {
                    mesa.text(mesaEnPosicion.NombreMesas);
                }
            }else{
                if (mesaEnPosicion.NombreMesas === 'circulo') {
                    mesa.append(`<a class="btn btn-light btn-lg" id="mesa-btn-${mesaEnPosicion.id}" style="width: 100%; position: absolute; height: 100%; border: 2px solid black; border-radius: 50%; background: #FF8080"><span style="color: white">${mesaEnPosicion.Name}</span></a>`);
                } else if (mesaEnPosicion.NombreMesas === 'cuadrado') {
                    mesa.append(`<a class="btn btn-light btn-lg" id="mesa-btn-${mesaEnPosicion.id}" style="width: 100%; position: absolute; height: 100%; border: 2px solid black; background: #FF8080"><span style="color: white">${mesaEnPosicion.Name}</span></a>`);
                } else {
                    mesa.text(mesaEnPosicion.NombreMesas);
                } 
            }

            //al hacer click en la mesa 
            mesa.off('click').on('click', function () {
                $('.mesa a').removeClass('selected-btn');
                $(this).find('a').addClass('selected-btn');
                var mesaId = $(this).data('mesa-id');

                $.ajax({
                    url: 'api/get-mesa-editar/' + mesaId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (mesaselect) {
                        if(mesaselect[0].estado == 'ocupado'){
                            var formTabsDiv = document.getElementById('form_tabs');
                            generarFormularioOcupado(mesaId)
                                .then(function(OcupadoFormulario) {
                                    formTabsDiv.innerHTML = OcupadoFormulario;
                                })
                                .catch(function(error) {
                                    console.error('Error al obtener el formulario:', error);
                                });
                        }else{
                            var formTabsDiv = document.getElementById('form_tabs');
                            var DisponibleFormulario = generarFormularioDisponible(mesaId);
                            formTabsDiv.innerHTML = DisponibleFormulario;
                            
                            //Incrementar y Decrementar cantidad de personas
                            const btnDecrementar = document.getElementById('btnDecrementar');
                            const btnIncrementar = document.getElementById('btnIncrementar');
                            const inputPersonas = document.getElementById('CantPersonas');
                            btnDecrementar.addEventListener('click', decrementarPersonas);
                            btnIncrementar.addEventListener('click', incrementarPersonas);
                            
                            function decrementarPersonas() {
                                const valorActual = parseInt(inputPersonas.value);
                                const nuevoValor = Math.max(1, valorActual - 1);
                                inputPersonas.value = nuevoValor;
                            }

                            function incrementarPersonas() {
                                const valorActual = parseInt(inputPersonas.value);
                                const nuevoValor = valorActual + 1;
                                inputPersonas.value = nuevoValor;
                            }
                            
                            
                            function convertirMayusculas() {
                                const inputs = document.querySelectorAll('.convertmayusculas');
                                inputs.forEach(function(input) {
                                    input.addEventListener('input', function() {
                                        input.value = input.value.toUpperCase();
                                    });
                                });
                            }
                            convertirMayusculas()
                        }                        

                        //para el select cliente
                        $('#SeleccionarCliente').select2({
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
                                $('#SeleccionarCamarero').empty();

                                $('#SeleccionarCamarero').append($('<option>', {
                                    value: '',
                                    text: 'Seleccione un camarero',
                                    selected: true,
                                }));
    
                                for (var i = 0; i < camareros.length; i++) {
                                    var camarero = camareros[i];
                                    $('#SeleccionarCamarero').append($('<option>', {
                                        value: camarero.id,
                                        text: camarero.NombreCamarero
                                    }));
                                }
                            },
                            error: function (error) {
                                console.error('Error al obtener camareros:', error);
                            }
                        });

                        $('#btnAbrirMesa').off('click').on('click', function(event) {
                            $(this).prop('disabled', true);                            
                            event.preventDefault();
                            var idMesa = mesaId;
                            var CantPersonas = $("#CantPersonas").val();
                            var ClienteID = $("#SeleccionarCliente").val();
                            var CamareroID = $("#SeleccionarCamarero").val();
                            var Comentario = $("#Comentario").val();
                            var token = $('meta[name="csrf-token"]').attr('content');
                        
                            $.ajax({
                                url: '/api/registrar-consumo',
                                type: 'POST',
                                data: {
                                    _token: token,
                                    CantidadPersonas: CantPersonas,
                                    cliente_id: ClienteID,
                                    camarero_id: CamareroID,
                                    ambiente_mesa_id: idMesa,
                                    Comentario: Comentario
                                },
                                success: function(consumo) {
                                    MostrarMensaje("Mesa Ocupada", "success");
                                    var formTabsDiv = document.getElementById('form_tabs');
                                
                                    // Llamar a la función y obtener el HTML generado
                                    generarFormularioOcupado(mesaId).then(function (ocupadoFormulario) {
                                        // Agregar el HTML generado al elemento con el id "form_tabs"
                                        formTabsDiv.innerHTML = ocupadoFormulario;
                                    }).catch(function (error) {
                                        // Manejar el error si es necesario
                                        console.error('Error al generar el formulario:', error);
                                    });
                                
                                    var mesaSeleccionada = $('.mesa a.selected-btn');
                                    mesaSeleccionada.css('background-color', '#FF8080');
                                    mesaSeleccionada.css('color', 'white');
                                },
                                
                                error: function(error) {
                                    MostrarMensaje("La Mesa Noce Pudo Ocupar","error");
                                },
                                
                                complete: function() {
                                    $('#btnAbrirMesa').prop('disabled', false);
                                }
                            });
                        });
                        
                        
                    },
                    error: function(error) {
                        console.error('Error al recuperar datos del ambiente seleccionado:', error);
                    }
                });                                         
            });
            row.append(mesa);
        }
    }


    function MoverMesa(ambienteId, mesaId) {
        var messaID = mesaId;
        var SelectX = 0;
        var SelectY = 0;
    
        $.ajax({
            url: 'api/get-ambiente-seleccionado/' + ambienteId,
            type: 'GET',
            dataType: 'json',
            success: function (ambiente) {
                CanvasTime();
                $('#div-editar').empty();
    
                // Contenedor para el input y botón
                var inputContainer = $('<div class="mb-3 d-flex align-items-center">');
                
                // Input para el nombre de la mesa
                var inputName = $('<input>')
                    .attr('type', 'text')
                    .attr('id', 'mesaName')
                    .attr('name', 'mesaName')
                    .addClass('form-control me-2')
                    .attr('placeholder', 'Ingrese el nombre de la mesa');
                
                // Botón para cambiar el nombre
                var btnChangeName = $('<button>')
                    .attr('id', 'btnCambiarNombre')
                    .addClass('btn btn-primary')
                    .text('Cambiar Nombre');
    
                // Agregar input y botón al contenedor
                inputContainer.append(inputName).append(btnChangeName);
                $('#div-editar').append(inputContainer);
    
                var rows = Fila;
                var cols = Fila;
                var gridContainer = $('#div-editar');
                $('#EditMesaId').val(messaID);
    
                // Manejar clic en el botón de cambiar nombre
                btnChangeName.on('click', function (event) {
                    event.preventDefault();
                
                    var mesaName = $('#mesaName').val();
                    if (!mesaName.trim()) {
                        alert('Por favor, ingrese un nombre válido.');
                        return;
                    }
                
                    $.ajax({
                        url: '/api/actualizar-nombre-mesa',
                        type: 'POST',
                        data: {
                            mesaId: messaID,
                            mesaName: mesaName
                        },
                        success: function (response) {
                            CanvasTime();
                            //MesasActualizar(ambienteId);
                            $('#ModalEditar').offcanvas('hide');
                            MostrarMensaje('Nombre de la mesa actualizado correctamente.', 'success');
                        },
                        error: function (error) {
                            console.error('Error al actualizar el nombre:', error);
                            MostrarMensaje('Error al actualizar el nombre de la mesa.', 'error');
                        }
                    });
                });
    
                $.ajax({
                    url: 'api/get-mesa-editar/' + messaID,
                    type: 'GET',
                    dataType: 'json',
                    success: function (mesaselect) {
                        console.log("La mesa seleccionada es ");
                        console.log(messaID);
    
                        var SelectX = mesaselect[0].PosisionX;
                        var SelectY = mesaselect[0].PosisionY;
    
                        for (var i = 0; i < rows; i++) {
                            var row = $('<div>').addClass('row');
    
                            for (var j = 0; j < cols; j++) {
                                var posX = i;
                                var posY = j;
    
                                var ambientemesas = ambiente[0].ambientemesas || [];
                                var mesaEnPosicion = ambientemesas.find(function (mesa) {
                                    return mesa.PosisionX == posX && mesa.PosisionY == posY;
                                });
    
                                var mesa;
                                if (mesaEnPosicion) {
                                    if (posX == SelectX && posY == SelectY) {
                                        mesa = $('<div>')
                                            .addClass('editmesa col text-center')
                                            .data('mesa-id', i * cols + j + 1)
                                            .data('pos-x', posX)
                                            .data('pos-y', posY)
                                            .append('<p>aqui</>');
                                    } else {
                                        mesa = $('<div>')
                                            .addClass('editmesa col text-center')
                                            .data('mesa-id', i * cols + j + 1)
                                            .data('pos-x', posX)
                                            .data('pos-y', posY)
                                            .append('<p>xxx</>');
                                    }
                                } else {
                                    mesa = $('<div>')
                                        .addClass('editmesa col text-center')
                                        .data('mesa-id', i * cols + j + 1)
                                        .data('pos-x', posX)
                                        .data('pos-y', posY)
                                        .append('<a style="width:100%; height:100%;" class="BtnMover"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checks" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg></a>');
                                }
    
                                row.append(mesa);
                            }
                            gridContainer.append(row);
                        }
    
                        gridContainer.on('click', '.BtnMover', function (event) {
                            event.preventDefault();
                            var posX = $(this).parent().data('pos-x');
                            var posY = $(this).parent().data('pos-y');
    
                            $('.editmesa.selected-table').removeClass('selected-table');
                            $(this).parent().addClass('selected-table');
                            $('#EditPosicionX').val(posX);
                            $('#EditPosicionY').val(posY);
    
                            $('#btnCambiarMesa').off('click').on('click', function () {
                                var nuevaPosX = $('#EditPosicionX').val();
                                var nuevaPosY = $('#EditPosicionY').val();
                                var mesaId = $('#EditMesaId').val();
    
                                $.ajax({
                                    url: '/api/actualizar-posicion-mesa',
                                    type: 'POST',
                                    data: {
                                        mesaId: mesaId,
                                        nuevaPosX: nuevaPosX,
                                        nuevaPosY: nuevaPosY
                                    },
                                    success: function (response) {
                                        MesasActualizar(ambienteId);
                                        $('#ModalEditar').offcanvas('hide');
                                        MostrarMensaje('Se Cambió la Mesa Correctamente', 'success');
                                    },
                                    error: function (error) {
                                        console.error('Error en la actualización:', error);
                                    }
                                });
                            });
                        });
                    },
                    error: function (error) {
                        console.error('Error al recuperar datos del ambiente seleccionado:', error);
                    }
                });
            },
            error: function (error) {
                console.error('Error al recuperar datos del ambiente seleccionado:', error);
            }
        });
    }
    
    

    $.ajax({
        url: 'api/get-ambientes',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                var ambientesContainer = $('#listambientes');
                $.each(data, function(index, ambiente) {
                    var button = $('<button>')
                        .addClass('btn btn-ambiente me-2 my-2')
                        .html(`${ambiente.NombreAmbiente}<span class="badge bg-lime ms-2">9</span>`)
                        .data('ambiente-id', ambiente.id);

                    ambientesContainer.append(button);
                });

                $('.btn-ambiente').off('click').on('click', function (event) {
                    event.preventDefault();
                    var ambienteId = $(this).data('ambiente-id');

                    $.ajax({
                        url: 'api/get-ambiente-seleccionado/' + ambienteId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (ambiente) {
                            VerMesa(ambiente);
                            CanvasTime()
                            var OperacionDiv = $('#SectOperaciones');
                            OperacionDiv.empty();
                            var ambienteButton = $('<button>')
                                .addClass('btn btn-primary')
                                .text(ambienteId)
                                .attr('id', 'EditAmbiente');

                            OperacionDiv.css({
                                'display': 'flex',
                                'justify-content': 'flex-end',
                                'align-items': 'center',
                                'padding': '10px'
                            });

                            OperacionDiv.append(ambienteButton);

                            $('#EditAmbiente').off('click').on('click', function (event) {
                                event.preventDefault();
                                var ambienteId = $(this).text();

                                $.ajax({
                                    url: 'api/get-ambiente-seleccionado/' + ambienteId,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function (ambiente) {
                                        CanvasTime()
                                        $('#restaurant-grid').empty();
                                        var rows= Fila;
                                        var cols= Fila;
                                        var gridContainer = $('#restaurant-grid');

                                        for (var i = 0; i < rows; i++) {
                                            var row = $('<div>').addClass('row');

                                            for (var j = 0; j < cols; j++) {
                                                var posX = i;
                                                var posY = j;

                                                var ambientemesas = ambiente[0].ambientemesas || [];
                                                var mesaEnPosicion = ambientemesas.find(function (mesa) {
                                                    return mesa.PosisionX == posX && mesa.PosisionY == posY;
                                                });

                                                if (mesaEnPosicion) {
                                                    var mesa = $('<div>')
                                                        .addClass('mesa col text-center')
                                                        .data('mesa-id', mesaEnPosicion.id)
                                                        .data('pos-x', posX)
                                                        .data('pos-y', posY);

                                                    if (mesaEnPosicion.NombreMesas === 'circulo') {
                                                        mesa.append('<a class="btn btn-light btn-lg" style="width: 70%; height: 90%; border: 2px solid black; border-radius: 50%;"></a>');
                                                    } else if (mesaEnPosicion.NombreMesas === 'cuadrado') {
                                                        mesa.append('<a class="btn btn-light btn-lg" style="width: 70%; height: 70%; border: 2px solid black;"></a>');
                                                    } else {
                                                        mesa.text(mesaEnPosicion.NombreMesas);
                                                    }

                                                    mesa.on('click', function () {
                                                        var offcanvas = new bootstrap.Offcanvas(document.getElementById('ModalEditar'));
                                                        var mesaId = $(this).data('mesa-id');
                                                        offcanvas.show();
                                                        MoverMesa(ambienteId, mesaId);
                                                    });

                                                } else {
                                                    var mesa = $('<div>')
                                                        .addClass('mesa col text-center')
                                                        .data('mesa-id', i * cols + j + 1)
                                                        .data('pos-x', posX)
                                                        .data('pos-y', posY)
                                                        .append('<a class="btn btn-light btn-lg abrir-modal" style="width:100%; height:100%;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg></a>');
                                                }

                                                row.append(mesa);
                                            }

                                            gridContainer.append(row);
                                        }

                                        $('#restaurant-grid').off('click', '.mesa .abrir-modal').on('click', '.mesa .abrir-modal', function () {
                                            var mesaId = $(this).closest('.mesa').data('mesa-id');
                                            var posX = $(this).closest('.mesa').data('pos-x');
                                            var posY = $(this).closest('.mesa').data('pos-y');

                                            $('#myModal').modal('show');

                                            $('#myModal .elegir-forma').off('click').on('click', function () {
                                                var formaSeleccionada = $(this).data('forma');

                                                var celda = $('.mesa[data-mesa-id="' + mesaId + '"]');
                                                celda.empty().append('<div class="' + formaSeleccionada + '"></div>');

                                                $.ajax({
                                                    url: '/api/registrar-mesa',
                                                    type: 'POST',
                                                    data: {
                                                        NombreMesas: formaSeleccionada,
                                                        PosisionX: posX,
                                                        PosisionY: posY,
                                                        ambienteId: ambienteId,
                                                    },
                                                    success: function (mesa) {
                                                        MostrarMensaje("Mesa Creada Exitosamente", "success");
                                                        MesasActualizar(ambienteId);
                                                    },
                                                    error: function (error) {
                                                        console.error('Error al registrar la mesa:', error);
                                                    }
                                                });

                                                $('#myModal').modal('hide');
                                            });
                                        });

                                    },
                                    error: function (error) {
                                        console.error('Error al recuperar datos del ambiente seleccionado:', error);
                                    }
                                });
                            });
                        },
                        error: function (error) {
                            console.error('Error al recuperar datos del ambiente seleccionado:', error);
                        }
                    });
                });

            }
        },
        error: function(error) {
            console.error('Error al recuperar datos:', error);
        }
    });

    function generarFormularioOcupado(mesaId) {
        return new Promise(function(resolve, reject) {
            var productosSeleccionados = []; // Mover la declaración fuera de la función success

            $.ajax({
                url: '/api/get-mesa-ocupado/' + mesaId,
                type: 'GET',
                dataType: 'json',
                success: function (consumo) {    
                    $.ajax({
                        url: '/api/get-productos',
                        type: 'GET',
                        dataType: 'json',
                        success: function (productos) {
                            var DivPedidos = document.getElementById('DivPedidos');
                            DivPedidos.innerHTML = '';
                            agregarDetallesConsumo(mesaId);
                            DivTotalConsumo(mesaId);
                            //favoriteDivsProductos();  

                            $.ajax({
                                url: '/api/get-productos-favorite',
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    $('#DivFavorite').empty();
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
                                        $('#DivFavorite').append(elementoHtml);
                                    });

                                    $('#DivFavorite').on('click', '.elemento', function() {
                                        var nombreProducto = $(this).find('p:eq(1)').text().trim();
                                        var productoSeleccionado = productos.find(producto => producto.NombreProducto === nombreProducto);
                                        if (productoSeleccionado) {
                                            productosSeleccionados.push({
                                                Idproducto: productoSeleccionado.id,
                                                NombreProducto: productoSeleccionado.NombreProducto,
                                                Cantidad: 1,
                                                PrecioProducto: productoSeleccionado.PrecioProducto,
                                                modificador: productoSeleccionado.modificadore
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
                                    modificador: producto.modificadore
                                })),
                                
                                
                                select: function (event, ui) {
                                    var productoSeleccionado = productos.find(producto => producto.NombreProducto === ui.item.value);
                                    // Agregar una nueva instancia del producto seleccionado
                                    productosSeleccionados.push({
                                        Idproducto: productoSeleccionado.id,
                                        NombreProducto: productoSeleccionado.NombreProducto,
                                        Cantidad: 1,
                                        PrecioProducto: productoSeleccionado.PrecioProducto,
                                        modificador: productoSeleccionado.modificadore
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

                            

                            var btnGuardar = document.getElementById('btnGuardar');
                                $('#btnGuardar').off('click').on('click', function (event) {
                                    $(this).prop('disabled', true);
                                    event.preventDefault();

                                    var productosParaGuardar = recuperarDatosProductos();

                                    // Ahora tienes todos los datos de los productos para guardar en 'productosParaGuardar'

                                    $.ajax({
                                        url: '/api/registrar-detalle-consumo',
                                        type: 'POST',
                                        contentType: 'application/json',
                                        data: JSON.stringify(productosParaGuardar),
                                        success: function (response) {      
                                            btnGuardar.style.display = 'none';
                                            MostrarMensaje("Producto Agregado", "success");
                                            DivPedidos.innerHTML = '';
                                            AddProduct = document.getElementById('DivAddProduct');
                                            AddProduct.innerHTML = '';
                                            productosSeleccionados = [];
                                            agregarDetallesConsumo(mesaId);
                                            DivTotalConsumo(mesaId);
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
                                            Idconsumo: consumo[0].id,
                                            Idproducto: producto.Idproducto,
                                            nombre: producto.NombreProducto,
                                            cantidad: producto.Cantidad || 1,
                                            precio: producto.PrecioProducto || 0,
                                            comentario: producto.Comentario || '',
                                            Modificadores: []
                                        };
                                
                                        if (producto.modificador != null) {
                                            producto.modificador.detallemodificador.forEach(function (detalle, indexDetalle) {
                                                var DetalleID = detalle.id; // Usar detalle.id directamente si es único
                                                var cantidadInputId = `DivModificadorCantidad${index}-${indexDetalle}`;
                                                var costoInputId = `DivModificadorCosto${index}-${indexDetalle}`;
                                                var checkboxId = `ModificadorCheck${index}-${indexDetalle}`;
                                
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
                                                    <input type="text" name="CantProduct" class="form-control CantProduct" value="${producto.Cantidad || 1}" style="padding: 0px; text-align: center;" id="divInput" disabled>
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
                                        ${producto.modificador != null ? `
                                            <div style="text-align: center; margin-left: 10%;" id="DivModificadores"><br>
                                                <!-- Aquí listame todos los productos con modificadores -->
                                            </div>
                                        ` : ''}
                                        <div style="text-align: center;"><br>
                                            <input type="text" name="ComentarioProduct" class="form-control ComentarioProduct" style="display: none"><br id="saltoDiv" style="display: none" placeholder="Escriba El Comentario . . .">
                                        </div>
                                    </div>
                                    `;

                                    if (producto.modificador != null) {
                                        var productosModificadoresDiv = nuevoDiv.querySelector('#DivModificadores');
                                        producto.modificador.detallemodificador.forEach(function (detalle, indexDetalle) {
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
                                                                <input type="text" name="CantProduct" class="form-control CantProduct" value="${productoModificador.Cantidad || 1}" style="padding: 0px; text-align: center;" id="DivModificadorCantidad${index}-${indexDetalle}">
                                                                <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                                                            </div>
                                                        </div>
                                                        <div style="padding-left: 9px; padding-right: 9px; width: 35%;" id="divdate2">
                                                            <a style="font-weight: bold; font-size: 13px; word-wrap: break-word;">${productoModificador.NombreProducto}</a>
                                                        </div>
                                                        <div style="width: 20%;" id="divdate3">
                                                            <input type="number" class="form-control PrecioProduct" value="${detalle.CostoDetalleModificador || 1}" style="padding-right: 0px; padding-left: 0px; text-align: center; width: 55px" id="DivModificadorCosto${index}-${indexDetalle}">
                                                        </div>
                                                        <div style="text-align: center; padding: 8px; margin: 0px;" id="divdate4">
                                                            <input class="form-check" type="checkbox" style="width: 20px; height: 20px" id="ModificadorCheck${index}-${indexDetalle}" checked>
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
                                            saltoDiv.style.display = 'block';
                                        } else {
                                            comentarioProductInput.style.display = 'none';
                                            saltoDiv.style.display = 'none';
                                        }
                                    });

                                });

                                btnGuardar.style.display = productosSeleccionados.length >= 1 ? 'block' : 'none';

                            }

                            function DivTotalConsumo(mesaId) {

                                function DescuentoDiv() {
                                    var btn = document.getElementById('btnPorcentaje');
                                    var id = btn.getAttribute('data-id');
                                    // Haz lo que necesites con el id
                                    var DivDescuento = document.getElementById('DivDescuento');
                                    DivDescuento.innerHTML = 
                                    `<div class="d-flex" data-index="${id}" style="background: #DDE6ED; margin: 0px; padding: 10px; width: 100%; display: flex; height: 60px;">
                                        <input type="number" value="${id}" id="IdDescuento" class="form-control" style="width: 100%" hidden>
                                        <div class="mb-6 row" style="width: 200%;">
                                            <label class="col-1 col-form-label" style="white-space: nowrap; width: auto">Descuento: </label>
                                            <div class="col" style="display: flex; align-items: center;">
                                                <input type="text" id="DescuentoPorcentaje" class="form-control" style="width: 80%">
                                                <label class="col-form-label">%</label>
                                            </div>
                                        </div>
                                        <div class="mb-6 row" style="width: 150%;">
                                            <label class="col-3 col-form-label" style="width: auto">Bs: </label>
                                            <div class="col">
                                                <input type="text" id="DescuentoMonto" class="form-control" style="width: 60%">
                                            </div>
                                        </div>
                                        <div class="mb-6 row" style="width: auto; padding: 7px">
                                            <div class="d-flex">
                                                <button type="button" class="badge bg-red-lt" id="btnDescuentoCancelar" style="height: 100%">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                                </button>
                                                <button type="button" class="badge bg-green-lt" id="btnDescuentoConfirmar" style="height: 100%">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                                </button>
                                            </div>                                            
                                        </div>
                                    </div>
                                    `;

                                    document.getElementById('btnDescuentoCancelar').addEventListener('click', function () {
                                        DivDescuento.innerHTML = '';
                                    });

                                    //para los inputs
                                    document.getElementById('DescuentoPorcentaje').addEventListener('input', function () {
                                        var porcentaje = parseInt(this.value, 10) || 0;

                                        if (porcentaje < 1) {
                                            porcentaje = '';
                                        } else if (porcentaje > 100) {
                                            porcentaje = 80;
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

                                        $(this).prop('disabled', true);

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
                                                    url: '/api/get-mesa-ocupado/' + mesaId,
                                                    type: 'GET',
                                                    dataType: 'json',
                                                    success: function (consumo) {
                                                        var SubTotalProduct = document.getElementById('DivSubTotal');
                                                        if (consumo[0].descuentoconsumos.length > 0) {
                                                            SubTotalProduct.innerHTML = `
                                                                <div class="d-flex" style="background: #243A73; padding: 20px;">
                                                                    <div class="flex-grow-1">
                                                                        <div class="input-group" style="width: 100%">
                                                                            <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-shrink-0 text-right">
                                                                        <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                                                                    </div>
                                                                </div>
                                                            `;
                                                        } else {
                                                            SubTotalProduct.innerHTML = '';
                                                        }
                                                        var TotalProduct = document.getElementById('DivTotal');
                                                        TotalProduct.innerHTML = `
                                                            <div style="background: #243A73; padding: 20px; display: flex;">
                                                                <div style="width: 50%;">
                                                                    <div class="input-group" style="width: 100%;">
                                                                        <span style="font-size: 20px; color: white;">TOTAL</span>
                                                                    </div>
                                                                </div>
                                                                <div style="text-align: right; width: 50%;">
                                                                    <span style="font-size: 20px; color: white;">${consumo[0].total} Bs.</span>
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
                                            },
                                            complete: function() {
                                                $('#btnDescuentoConfirmar').prop('disabled', false);
                                            }
                                        });
                                    });                                        

                                }
                                ///aqui total
                                $.ajax({
                                    url: '/api/get-mesa-ocupado/' + mesaId,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function (consumo) {
                                        var SubTotalProduct = document.getElementById('DivSubTotal');
                                        var IdConsumo = consumo[0].id;

                                        if (consumo[0].descuentoconsumos.length > 0) {
                                            SubTotalProduct.innerHTML = `
                                                <div class="d-flex" style="background: #243A73; padding: 20px;">
                                                    <div class="flex-grow-1">
                                                        <div class="input-group" style="width: 100%">
                                                            <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 text-right">
                                                        <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                                                    </div>
                                                </div>
                                            `;
                                        } else {
                                            SubTotalProduct.innerHTML = '';
                                        }

                                        var TotalProduct = document.getElementById('DivTotal');
                                        TotalProduct.innerHTML = `
                                            <div style="background: #243A73; padding: 20px; display: flex;">
                                                <div style="width: 50%;">
                                                    <div class="input-group" style="width: 100%;">
                                                        <span style="font-size: 20px; color: white;">TOTAL</span>
                                                    </div>
                                                </div>
                                                <div style="text-align: right; width: 50%;">
                                                    <span style="font-size: 20px; color: white;">${consumo[0].total} Bs.</span>
                                                </div>
                                            </div>
                                        `;
                                        var DivBotones = document.getElementById('DivBotonesFooter');
                                        DivBotones.innerHTML = `
                                            <div class="col-md-6 col-lg-12 d-flex justify-content-between">
                                                <button type="button" class="btn btn-primary" id="btnPorcentaje" data-id="${IdConsumo}" style="text-align: center; padding: 0px; margin: 0px; padding-left: 6px; padding-right: 6px">
                                                    <span style="font-size: 20px; font-weight: bold;">%</span>
                                                </button>

                                                <button type="button" data-bs-toggle="modal" data-bs-target="#ModalCerrarMesa" class="btn btn-danger" data-id="${IdConsumo}" id="btnCerrarMesa">Cerrar Mesa</button>
                                            </div>
                                        `;

                                        // Vuelve a asignar el controlador de eventos al botón de porcentaje
                                        document.getElementById('btnPorcentaje').onclick = DescuentoDiv;
                                        document.getElementById('btnCerrarMesa').onclick = guardarCambios;

                                    },
                                    error: function (error) {
                                        console.error('Error:', error);
                                    }
                                });

                            }


                            
                            function agregarDetallesConsumo(mesaId) {
                                $.ajax({
                                    url: '/api/get-mesa-ocupado/' + mesaId,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function (consumo) {                                        
                                        DivagregarDetallesConsumo(consumo[0].detalleconsumos, mesaId);
                                        ListarDescuentos(consumo[0].id)
                                        DivTotalConsumo(mesaId);
                                    },
                                    error: function (error) {
                                        console.error('Error:', error);
                                    }
                                });
                            }

                            var DivPedidos = document.getElementById('DivPedidos');

                            function DivagregarDetallesConsumo(detalleconsumos, mesaId) {
                            $.ajax({
                                url: '/api/get-mesa-ocupado/' + mesaId,
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
                                                                            <p class="card-title detalleconsumocortesia" data-bs-toggle="modal" data-bs-target="#modal-cortesia-pensionado" style="cursor: pointer" data-name="${detalle.producto.NombreProducto}" data-iddetalle="${detalle.id}">
                                                                                ${detalle.producto.NombreProducto} - ${detalle.precio}
                                                                                ${detalle.cortesia === 'true' 
                                                                                    ? '  - <span class="badge badge-outline text-red">No se Pagara</span>' 
                                                                                    : ''}
                                                                            </p>
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

                                                    $(document).off('click').on('click', '.detalleconsumocortesia', function () {
                                                        var productName = $(this).attr('data-name');
                                                        var iddetalle = $(this).attr('data-iddetalle');
                                                        $('#product-name-modal').html(`De <strong>${productName}</strong> no se le cobrará ningún monto, ¿está seguro?`);

                                                        
                                                        $('#btn-registrar-cortesia').off('click').on('click', function(event) {
                                                            event.preventDefault();
                                                        
                                                            $.ajax({
                                                                url: '/api/registrar-cortesia-detalle-consumo/'+iddetalle,
                                                                method: 'GET',
                                                                success: function(response) {
                                                                    MostrarMensaje("Se agrego detalle consumo a cortesia", "success");
                                                                    DivPedidos.innerHTML = '';
                                                                    AddProduct = document.getElementById('DivAddProduct');
                                                                    AddProduct.innerHTML = '';
                                                                    productosSeleccionados = [];
                                                                    agregarDetallesConsumo(mesaId);
                                                                    DivTotalConsumo(mesaId);
                                                                },
                                                                error: function(jqXHR, textStatus, errorThrown) {
                                                                    MostrarMensaje("Para Eses horarios tienes reservado el salon!!!","error")
                                                                }
                                                            });
                                                        });
                                                    });
            
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
                                            DivPedidos.appendChild(nuevoDiv);     
                                            
                                            var addButton = nuevoDiv.querySelector('#AddModificador');
                                            if (addButton) {
                                                addButton.addEventListener('click', function() {
                                                    var idModificador = addButton.getAttribute('data-IdModificador');
                                                    var IdDetalle = addButton.getAttribute('data-IdDetalle');
                                                    $.ajax({
                                                        url: '/api/get-modificador-seleccionado/'+idModificador,
                                                        type: 'GET',
                                                        dataType: 'json',
                                                        success: function(data) {
                                                            var modalBody = document.querySelector('#ModalAddModificador .modal-body');
                                                            modalBody.innerHTML = '';
                                                            data.detallemodificador.forEach(function (detalle) {
                                                                var productoHtml = `
                                                                    <div class="row row-cards" id="productoDiv" style="padding: 20px; margin: 2px">
                                                                        <div class="col-sm-6 col-md-1">
                                                                            <input type="text" class="form-control" id="MIdproducto_${detalle.id}" value="${detalle.producto.id}" hidden>
                                                                            <input type="text" class="form-control" id="MIdDetalle_${detalle.id}" value="${detalle.id}" hidden>
                                                                            <div class="mb-3">
                                                                                <label class="form-check" style="padding: 15px; margin: 20px">
                                                                                    <input class="form-check-input" type="checkbox" id="ChexInput_${detalle.id}" style="border: 4px solid black; width: 20px; height: 20px">
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
                                                                                <input type="text" class="form-control" id="MPrecio_${detalle.id}" value="${detalle.CostoDetalleModificador}" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-2">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Cantidad</label>
                                                                                <input type="text" class="form-control" id="MCantidad_${detalle.id}" value="1">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-3">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Total</label>
                                                                                <input type="text" id="MTotal_${detalle.id}" class="form-control" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `;
                                                                modalBody.insertAdjacentHTML('beforeend', productoHtml);
                                                            
                                                                var checkboxId = `ChexInput_${detalle.id}`;
                                                                var cantidadId = `MCantidad_${detalle.id}`;
                                                                var precioId = `MPrecio_${detalle.id}`;
                                                                var totalId = `MTotal_${detalle.id}`;

                                                                var cantidadInput = document.getElementById(cantidadId);
                                                                var precioInput = document.getElementById(precioId);
                                                                var totalInput = document.getElementById(totalId);

                                                                function calcularTotal() {
                                                                    var cantidad = parseInt(cantidadInput.value);
                                                                    var precio = parseFloat(precioInput.value);
                                                                    var total = cantidad * precio;
                                                                    totalInput.value = total.toFixed(2);
                                                                }

                                                                calcularTotal();

                                                                cantidadInput.addEventListener('input', calcularTotal);
                                                                precioInput.addEventListener('input', calcularTotal);
                                                                

                                                                var checkboxId = `ChexInput_${detalle.id}`;
                                                                document.getElementById(checkboxId).addEventListener('change', function() {
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
                                                            
                                                            var addModfBtn = document.getElementById('btnAddMod');
                                                            addModfBtn.addEventListener('click', function handleClick() {
                                                                var detalles = data.detallemodificador;
                                                                var datosArray = [];

                                                                detalles.forEach(function(detalle) {
                                                                    var cantidadElement = document.getElementById(`MCantidad_${detalle.id}`);
                                                                    var precioElement = document.getElementById(`MPrecio_${detalle.id}`);
                                                                    var totalElement = document.getElementById(`MTotal_${detalle.id}`);
                                                                    var idElement = IdDetalle;
                                                                    var idElement2 = document.getElementById(`MIdDetalle_${detalle.id}`);
                                                                    var checkboxId = `ChexInput_${detalle.id}`;
                                                                    var checkboxElement = document.getElementById(checkboxId);

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
                                                                    url: '/api/registrar-modificador-consumo',
                                                                    type: 'POST',
                                                                    contentType: 'application/json',
                                                                    data: JSON.stringify(datosArray),
                                                                    success: function(response) {
                                                                        var modalAdd = document.getElementById('ModalAddModificador');
                                                                        $(modalAdd).modal('hide');
                                                                        DivPedidos.innerHTML = '';
                                                                        AddProduct = document.getElementById('DivAddProduct');
                                                                        AddProduct.innerHTML = '';
                                                                        productosSeleccionados = [];
                                                                        agregarDetallesConsumo(mesaId);
                                                                        DivTotalConsumo(mesaId);
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
                                                    agregarDetallesConsumo(mesaId);
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

                            var btnActualizaMod = document.getElementById('btnActualizaMod');
                            btnActualizaMod.addEventListener('click', function() {                                                
                                var cantidad = parseInt(document.getElementById('EditCantidad').value);
                                var precio = parseFloat(document.getElementById('EditPrecio').value);
                                var total = parseFloat(document.getElementById('EditTotal').value);
                                var id = parseFloat(document.getElementById('EditId').value);

                                var data = {
                                    id: id,
                                    cantidad: cantidad,
                                    precio: precio,
                                    total: total
                                };

                                $.ajax({
                                    url: '/api/actualizar-modificador-consumo',
                                    type: 'POST',
                                    contentType: 'application/json',
                                    data: JSON.stringify(data),
                                    success: function(response) {
                                        DivPedidos.innerHTML = '';
                                        AddProduct = document.getElementById('DivAddProduct');
                                        AddProduct.innerHTML = '';
                                        productosSeleccionados = [];
                                        agregarDetallesConsumo(mesaId);
                                        DivTotalConsumo(mesaId);
                                        MostrarMensaje('Se actualizo exitosamente','success')
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error al enviar los datos:', error);
                                    }
                                });
                                $(this).off('click');
                            });

                            var eliminarModfBtn = document.getElementById('EliminarModf');
                            eliminarModfBtn.addEventListener('click', function() {
                                var id = document.getElementById('EliminarId').value;
                                var data = {
                                    id: id,
                                    total: total
                                };
                                $.ajax({
                                    url: '/api/eliminar-modificador-consumo',
                                    type: 'POST',
                                    contentType: 'application/json',
                                    data: JSON.stringify(data),
                                    success: function(response) {
                                        DivPedidos.innerHTML = '';
                                        AddProduct = document.getElementById('DivAddProduct');
                                        AddProduct.innerHTML = '';
                                        productosSeleccionados = [];
                                        agregarDetallesConsumo(mesaId);
                                        DivTotalConsumo(mesaId);
                                        MostrarMensaje('Se elimino exitosamente','success')
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error al enviar los datos:', error);
                                    }
                                });
                                $(this).off('click');
                            });                            
                        },
                        error: function (error) {
                            console.error('Error al obtener productos:', error);
                        }
                    });
                    resolve(`
                        <form>
                            <div class="card-header" style="background: #FF8080; padding: 0px; padding-right: 6px; padding-left: 6px;">
                                <div class="d-flex align-items-center" style="width: 100%">
                                    <h3 class="card-title" style="color: white; margin: 0">Mesa #${mesaId}</h3>
                                    <div class="ms-auto" style="display: flex; justify-content: flex-start; align-items: center;">
                                       <div class="row g-2 align-items-center">                                            
                                            <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                                                <a href="#" class="btn w-100 btn-icon" data-id="${mesaId}" id="CambiarConsumoHabitacion" onclick="CambiarAHabitacionConsumo()" data-bs-toggle="modal" data-bs-target="#modal-cambiar-mesa-habitacion" style="padding: 14px; text-align: center; display: flex; justify-content: center; align-items: center; margin-right: 10px;" data-bs-toggle="tooltip" title="Cambiar Consumo a Habitacion" >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-left-right">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M21 17l-18 0" />
                                                        <path d="M6 10l-3 -3l3 -3" />
                                                        <path d="M3 7l18 0" />
                                                        <path d="M18 20l3 -3l-3 -3" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                                                <a href="#" class="btn w-100 btn-icon" data-id="${mesaId}" id="ImprimirMesa" onclick="generarPDF()" style="padding: 14px; text-align: center; display: flex; justify-content: center; align-items: center; margin-right: 10px;" data-bs-toggle="tooltip" title="Mandar Directamente a Impresora" >
                                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                        <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                                                <a href="#" class="btn w-100 btn-icon" href="#" class="btn" data-id="${mesaId}" id="VerImprimirMesa" onclick="generarPDFver()" style="padding-right: 6px; padding-left: 6px;" data-bs-toggle="tooltip" title="Ver PDF" >
                                                    VerPDF
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                    
                    
                            <div class="card-body" style="padding: 0px; margin: 0px;">
                                <div class="col-md-12" style="padding: 0px; margin: 0px;">
                                    <form class="card">
                                        <div class="card-header">
                                            <strong style="color: red">
                                                ${consumo[0].Comentario ? consumo[0].Comentario + ' - ' : ''}
                                            </strong>
                                            ${consumo[0].CantidadPersonas ? consumo[0].CantidadPersonas + ' personas,' : ''}
                                            ${consumo[0].cliente ? consumo[0].cliente.NombreCliente + ',' : ''}
                                            ${consumo[0].camarero ? consumo[0].camarero.NombreCamarero + ',' : ''} 
                                            ${consumo[0].fecha_venta ? formatarFecha(consumo[0].fecha_venta) : ''}
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
                                            <div class="contenedor" id="DivFavorite" style="width: 100%; margin: 0px; padding: 0px;">
                                                
                                            </div>
                                        </div>
                                        <div>
                                            <div id="DivAddProduct">
                                                
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
                                                <h1>Cargando ...</h1>
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
                    `);
                },
            });
        });
    }

    ///agrega la funcion para poder enviar productos
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
                            <input type="number" name="CantProduct" class="form-control CantProduct" value="1" style="padding: 0px; text-align: center;">
                            <button class="btn btn-outline-secondary btnIncrementar" type="button" style="width: 15px">+</button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <a style="font-weight: bold; font-size: 13px">${producto.NombreProducto}</a>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" name="PrecioProduct" class="form-control PrecioProduct" value="${producto.PrecioProducto}" style="padding-right: 0px; padding-left: 0px; text-align: center;">
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
                        <input type="text" name="ComentarioProduct" class="form-control ComentarioProduct">
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

            // Agregar controladores de eventos
            btnDecrementar.addEventListener('click', function() {
                // Manejar decremento
                var cantidad = parseInt(cantProductInput.value, 10) || 0;
                if (cantidad > 0) {
                    cantProductInput.value = cantidad - 1;
                }
            });

            btnIncrementar.addEventListener('click', function() {
                // Manejar incremento
                var cantidad = parseInt(cantProductInput.value, 10) || 0;
                cantProductInput.value = cantidad + 1;
            });

            borrarDiv.addEventListener('click', function() {
                var index = borrarDiv.getAttribute('data-index');
                productosSeleccionados.splice(index, 1);
                actualizarDivsProductos();
            });

            // Manejar cambios en la cantidad y precio
            cantProductInput.addEventListener('input', function() {
                producto.Cantidad = cantProductInput.value;
            });

            precioProductInput.addEventListener('input', function() {
                producto.PrecioProducto = precioProductInput.value;
            });

            comentarioProductInput.addEventListener('input', function() {
                producto.Comentario = comentarioProductInput.value;
            });
        });
    }
    
    function generarFormularioDisponible(mesaId) {
        return `
            <form>
                <div class="card-header">
                    <div class="row" style="width: 100%">
                        <div class="col-12 col-sm-12">
                            <div class="row g-2">
                                <div class="col">
                                <input type="text" class="form-control" placeholder="Search for…">
                                </div>
                                <div class="col-auto">
                                <a href="#" class="btn btn-icon" aria-label="Button">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                </a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="card-body" style="margin: 0px; padding: 0px;">
                    <div class="col-md-12" style="margin: 0px; padding: 0px;">
                        <form class="card">
                            <div class="card-header">
                            <h3 class="card-title">Mesa # ${mesaId}</h3>
                            </div>
                            <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Personas</label>
                                <div class="col">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" id="btnDecrementar">-</button>
                                        <input type="number" name="CantPersonas" id="CantPersonas" class="form-control" value="1" style="text-align: center;">
                                        <button class="btn btn-outline-secondary" type="button" id="btnIncrementar">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label">Cliente</label>
                                <div class="col">
                                <select class="form-select" id="SeleccionarCliente" name="SeleccionarCliente">
                                    
                                </select>
                                </div>
                            </div>
                            <div class="mb-3 row" hidden>
                                <label class="col-3 col-form-label">Camarero</label>
                                <div class="col">
                                <select class="form-select" id="SeleccionarCamarero" name="SeleccionarCamarero"> 
                                    
                                </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-3 col-form-label pt-0">Comentario</label>
                                <div class="col">
                                <textarea class="form-control convertmayusculas" rows="5" id="Comentario" name="Comentario"></textarea>
                                </div>
                            </div>
                            </div>
                            <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary" id="btnAbrirMesa">Abrir Mesa</button>
                            </div>
                        </form>
                    </div>
                </div>                    
            </form>
        `;        
    }    

    
    document.getElementById('BorrarDiv').addEventListener('click', function() {
        var divPadre = this.closest('.row');
        divPadre.remove();
    });    
});

function ListarDescuentos(id) {
    var DivLisDescuentos = document.getElementById('DivSubTotalList');
    
    $.ajax({
        url: '/api/get-descuento/' + id,
        type: 'get',
        success: function (response) {
            DivLisDescuentos.innerHTML = '';
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
                DivLisDescuentos.appendChild(nuevoDescuentoDiv);                    

                var btnDeleteDescuento = nuevoDescuentoDiv.querySelector('.btnDeleteDescuento');
                btnDeleteDescuento.addEventListener('click', function () {
                    var descuentoId = btnDeleteDescuento.getAttribute('data-descuento-id');
                    $.ajax({
                        url: '/api/eliminar-descuento/' + descuentoId,
                        type: 'DELETE',
                        success: function (response) {
                            DivDescuento.innerHTML = '';
                            ListarDescuentos(id)
                            MostrarMensaje('Descuento Eliminado Correctamente','success');
                            //actualiza total
                            $.ajax({
                                url: '/api/get-mesa-ocupado/' + response.id,
                                type: 'GET',
                                dataType: 'json',
                                success: function (consumo) {
                                    var SubTotalProduct = document.getElementById('DivSubTotal');
                                    if (consumo[0].descuentoconsumos.length > 0) {
                                        SubTotalProduct.innerHTML = `
                                            <div class="d-flex" style="background: #243A73; padding: 20px;">
                                                <div class="flex-grow-1">
                                                    <div class="input-group" style="width: 100%">
                                                        <span style="font-size: 20px; color: white">SUB TOTAL</span>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 text-right">
                                                    <span style="font-size: 20px; color: white">${consumo[0].subTotal} Bs.</span>
                                                </div>
                                            </div>
                                        `;
                                    } else {
                                        SubTotalProduct.innerHTML = '';
                                    }
                                    var TotalProduct = document.getElementById('DivTotal');
                                    TotalProduct.innerHTML = `
                                        <div style="background: #243A73; padding: 20px; display: flex;">
                                            <div style="width: 50%;">
                                                <div class="input-group" style="width: 100%;">
                                                    <span style="font-size: 20px; color: white;">TOTAL</span>
                                                </div>
                                            </div>
                                            <div style="text-align: right; width: 50%;">
                                                <span style="font-size: 20px; color: white;">${consumo[0].total} Bs.</span>
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

function total(id){
    
}

$('#ModalCerrarMesa').on('shown.bs.modal', function () {
    $('#btnCerrarMesa').off('click').on('click', guardarCambios);
});


function guardarCambios() {
    var idConsumo = $('#IdConsumo').val();
    var btnCerrarMesa = $('#btnCerrarMesa');
    var id = btnCerrarMesa.data('id');
    $.ajax({
        url: '/api/get-mesa-consumo/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (consumo) {
            // Mostrar detalleconsumos en listConsumo
            document.getElementById('ListPagos').innerHTML = '';
            var listConsumo = document.getElementById('listConsumo');
            listConsumo.innerHTML = '';
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
                    listConsumo.appendChild(detalleConsumoItem);
                }
            });

            // Mostrar descuentoconsumos en lisDescuento
            var lisDescuento = document.getElementById('lisDescuento');
            lisDescuento.innerHTML = '';
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
                lisDescuento.appendChild(descuentoItem);
            });

            // Mostrar total en listTotal
            var TotalDiv = document.getElementById('listTotal');
            var totalItem = document.createElement('div');
            TotalDiv.innerHTML = '';        
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
            TotalDiv.appendChild(totalItem);
            
            $('#btnConfirmarPago').off('click');

            $('#addPagos').off('click').on('click', function () {
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
                $('#ListPagos').append(nuevoPago);

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

            document.getElementById('ListPagos').appendChild(primerPago);

            primerPago.querySelector('.montoPagoInput').addEventListener('input', function () {
                calcularYMostrarCambio();
            });

            calcularYMostrarCambio();

            function calcularYMostrarCambio() {
                var elementosPagos = document.querySelectorAll('#ListPagos > div');

                var totalPagos = 0;
                elementosPagos.forEach(function (elementoPago) {
                    var montoPago = parseFloat(elementoPago.querySelector('.montoPagoInput').value) || 0;
                    totalPagos += montoPago;
                });
                var limitePago = parseFloat(consumo[0].total) || 0;
                var cambio = totalPagos - limitePago;

                var listVuelto = document.getElementById('listVuelto');
                listVuelto.innerHTML = `
                    <p>Cambio: ${cambio.toFixed(2)}</p>
                `;
                actualizarEstadoBoton(cambio);
            }

            function actualizarEstadoBoton(cambio) {
                var btnConfirmarPago = document.getElementById('btnConfirmarPago');
                btnConfirmarPago.disabled = cambio < 0;
            }

            $('#btnConfirmarPago').off('click').on('click', function (event) {
                $(this).prop('disabled', true);
                event.preventDefault();
                var elementosPagos = $('#ListPagos > div');
                var pagos = [];
                var isChecked = document.getElementById('EnviarCaja').checked;
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
                    url: '/api/cerrar-mesa/' + id,
                    type: 'POST',
                    data: {
                        _token: token,
                        pagos: pagos,
                        isChecked: isChecked 
                    },
                    success: function (consumo) {
                        $('#ModalCerrarMesa').modal('hide');
                        document.getElementById('ListPagos').innerHTML = '';
                        document.getElementById('listConsumo').innerHTML = '';
                        document.getElementById
                        ('lisDescuento').innerHTML = '';
                        document.getElementById('listTotal').innerHTML = '';
                        document.getElementById('listVuelto').innerHTML = '';
                        document.getElementById('EnviarCaja').checked = false;

                        MostrarMensaje("Mesa Cerrada Correctamente", "success");
                        CanvasTime()
                        var mesaSeleccionada = $('.mesa a.selected-btn');
                        mesaSeleccionada.removeClass('selected-btn');
                        mesaSeleccionada.css('background', 'white');
                        mesaSeleccionada.css('color', 'black');
                    },
                    error: function (error) {
                        MostrarMensaje("La Mesa Noce Pudo Cerrar", "error");
                    },
                    complete: function() {
                        $('#btnConfirmarPago').prop('disabled', false);
                    }
                });
            });

        }
    });
}

function generarPDF() {
    var mesaId = document.getElementById('ImprimirMesa').getAttribute('data-id');
    let pdfLink;
    $.ajax({
        url: window.location.origin + '/api/get-mesa-comanda/' + mesaId,
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

function generarPDFver() {
    var mesaId = document.getElementById('VerImprimirMesa').getAttribute('data-id');
    var pdfUrl = '/api/get-mesa-comanda/' + mesaId;

    // Configura el iframe con la URL del PDF
    document.getElementById('pdfViewer').src = pdfUrl;

    // Muestra el modal
    var pdfModalMesa = new bootstrap.Modal(document.getElementById('pdfModalMesa'));
    pdfModalMesa.show();
}


function formatarFecha(fechaString) {
    const fecha = new Date(fechaString);

    const dia = fecha.getDate();
    const mes = fecha.getMonth() + 1; // Los meses comienzan desde 0
    const anio = fecha.getFullYear();
    const hora = fecha.getHours();
    const minutos = fecha.getMinutes();
    const segundos = fecha.getSeconds();

    // Agregar ceros delante si es necesario
    const diaStr = (dia < 10 ? '0' : '') + dia;
    const mesStr = (mes < 10 ? '0' : '') + mes;
    const horaStr = (hora < 10 ? '0' : '') + hora;
    const minutosStr = (minutos < 10 ? '0' : '') + minutos;
    const segundosStr = (segundos < 10 ? '0' : '') + segundos;

    return `${diaStr}/${mesStr}/${anio} ${horaStr}:${minutosStr}:${segundosStr}`;
}

function CambiarAHabitacionConsumo() {
    var mesaId = document.getElementById('CambiarConsumoHabitacion').getAttribute('data-id');
    $.ajax({
        url: '/apihostal/get-habitaciones-ocupadas',
        type: 'GET',
        dataType: 'json',
        success: function (HabitacionesOcupadas) {
            console.log(HabitacionesOcupadas);
            if (HabitacionesOcupadas.length > 0) {
                $('#habitaciones-select').empty();
                $('#habitaciones-select').append('<option value="">Selecciona una habitación</option>');
                HabitacionesOcupadas.forEach(function(habitacion) {
                    $('#habitaciones-select').append('<option value="' + habitacion.id + '">' + habitacion.Nombre_habitacion + '</option>');
                });
            } else {
                alert('No hay habitaciones ocupadas disponibles.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Hubo un error al obtener las habitaciones ocupadas.');
        }
    });
}

$('#habitaciones-select').on('change', function() {
    var selectedHabitacion = $(this).val();
    if (selectedHabitacion) {
        $('#btn-registrar-cambio-mesa-habitacion').prop('disabled', false);
    } else {
        $('#btn-registrar-cambio-mesa-habitacion').prop('disabled', true);
    }
});

$('#btn-registrar-cambio-mesa-habitacion').on('click', function() {
    var mesaId = document.getElementById('CambiarConsumoHabitacion').getAttribute('data-id');
    var habitacionId = $('#habitaciones-select').val();
    console.log("mesa " + mesaId)
    console.log("habitacion " + habitacionId)
    $.ajax({
        url: '/apihostal/cambiar-consumo-habitacion',
        type: 'POST',
        data: {
            mesaId: mesaId,
            habitacionId: habitacionId,
        },
        success: function(response) {
            console.log(response)
            CanvasTime()
            var mesaSeleccionada = $('.mesa a.selected-btn');
            mesaSeleccionada.removeClass('selected-btn');
            mesaSeleccionada.css('background', 'white');
            mesaSeleccionada.css('color', 'black');
            MostrarMensaje("Mesa Creada Exitosamente","success");
        },
        error: function(error) {
            console.error('Error al registrar la mesa:', error);
        }
    });
});
