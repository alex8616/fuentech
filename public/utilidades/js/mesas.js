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
                        mesa.append(`<a class="btn btn-light btn-lg" id="mesa-btn-${mesaEnPosicion.id}" style="width: 100%; height: 100%; border: 2px solid black; border-radius: 50%;">${mesaEnPosicion.id}</a>`);
                    } else if (mesaEnPosicion.NombreMesas === 'cuadrado') {
                        mesa.append(`<a class="btn btn-light btn-lg" id="mesa-btn-${mesaEnPosicion.id}" style="width: 100%; height: 100%; border: 2px solid black;">${mesaEnPosicion.id}</a>`);
                    } else {
                        mesa.text(mesaEnPosicion.NombreMesas);
                    }
                }else{
                    if (mesaEnPosicion.NombreMesas === 'circulo') {
                        mesa.append(`<a class="btn btn-light btn-lg" id="mesa-btn-${mesaEnPosicion.id}" style="width: 100%; position: absolute; height: 100%; border: 2px solid black; border-radius: 50%; background: #FF8080"><span style="color: white">${mesaEnPosicion.id}</span></a>`);
                    } else if (mesaEnPosicion.NombreMesas === 'cuadrado') {
                        mesa.append(`<a class="btn btn-light btn-lg" id="mesa-btn-${mesaEnPosicion.id}" style="width: 100%; position: absolute; height: 100%; border: 2px solid black; background: #FF8080"><span style="color: white">${mesaEnPosicion.id}</span></a>`);
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
                            }
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

                            //para el select cliente
                            $.ajax({
                                url: '/api/get-clientes',
                                type: 'GET',
                                dataType: 'json',
                                success: function (clientes) {
                                    $('#SeleccionarCliente').empty();

                                    $('#SeleccionarCliente').append($('<option>', {
                                        value: '',
                                        text: 'Seleccione un cliente',
                                        selected: true,
                                    }));
                                    
                                    for (var i = 0; i < clientes.length; i++) {
                                        var cliente = clientes[i];
                                        $('#SeleccionarCliente').append($('<option>', {
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


        function MoverMesa(ambienteId,mesaId){
            var messaID = mesaId;
            var SelectX = 0;
            var SelectY = 0;

            $.ajax({
                url: 'api/get-ambiente-seleccionado/' + ambienteId,
                type: 'GET',
                dataType: 'json',
                success: function (ambiente) {
                    CanvasTime()
                    $('#div-editar').empty();                    
                    var rows= Fila;
                    var cols= Fila;
                    var gridContainer = $('#div-editar');
                    $('#EditMesaId').val(messaID);

                    $.ajax({
                        url: 'api/get-mesa-editar/' + messaID,
                        type: 'GET',
                        dataType: 'json',
                        success: function (mesaselect) {
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

                                if (mesaEnPosicion) {    
                                    if(posX == SelectX && posY == SelectY){
                                        var mesa = $('<div">')
                                        .addClass('editmesa col text-center')
                                        .data('mesa-id', i * cols + j + 1)
                                        .data('pos-x', posX)
                                        .data('pos-y', posY)
                                        .append('<p>aqui</>');
                                    }else{
                                        var mesa = $('<div>')
                                        .addClass('editmesa col text-center')
                                        .data('mesa-id', i * cols + j + 1)
                                        .data('pos-x', posX)
                                        .data('pos-y', posY)
                                        .append('<p>xxx</>');
                                    }  
                                } else {
                                    var mesa = $('<div>')
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
                                            MesasActualizar(ambienteId)
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
                        error: function(error) {
                            console.error('Error al recuperar datos del ambiente seleccionado:', error);
                        }
                    });
                    
                },

                error: function(error) {
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

                } else {
                    ambientesContainer.html('<p class="text-muted">No se encontraron ambientes.</p>');
                }
            },
            error: function(error) {
                console.error('Error al recuperar datos:', error);
            }
        });

        function generarFormularioOcupado(mesaId) {
            return new Promise(function(resolve, reject) {
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
                                var productosSeleccionados = [];

                                $('#BuscarProducto').autocomplete({
                                    source: productos.map(producto => ({
                                        label: `${producto.CodigoProducto} - ${producto.NombreProducto}`,
                                        value: producto.NombreProducto,
                                        codigo: producto.CodigoProducto
                                    })),
                                    select: function (event, ui) {
                                        var productoSeleccionado = productos.find(producto => producto.NombreProducto === ui.item.value);
                                        var codigoProducto = ui.item.codigo;
                                        productosSeleccionados.push(Object.assign({}, productoSeleccionado));
                                        actualizarDivsProductos();
                                        ui.item.value = '';
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

                                    var productosParaGuardar = productosSeleccionados.map(function (producto) {
                                        return {
                                            Idconsumo: consumo[0].id,
                                            Idproducto: producto.id,
                                            nombre: producto.NombreProducto,
                                            cantidad: producto.Cantidad || 1,
                                            precio: producto.PrecioProducto || 0,
                                            comentario: producto.Comentario || ''
                                        };
                                    });

                                    $.ajax({
                                        url: '/api/registrar-detalle-consumo',
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
                                            agregarDetallesConsumo(mesaId);
                                            DivTotalConsumo(mesaId);                                            
                                        },
                                        error: function (error) {
                                            console.error('Error:', error);
                                        },
                                        complete: function() {
                                            $('#btnGuardar').prop('disabled', false);
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
                                                <div style="text-align: center; width: 25%; padding: 0px; margin: 0px; id="divdate4"">
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
                                            <div style="text-align: center;"><br>
                                                <input type="text" name="ComentarioProduct" class="form-control ComentarioProduct" style="display: none"><br id="saltoDiv" style="display: none">
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

                                

                            },
                            error: function (error) {
                                console.error('Error al obtener productos:', error);
                            }                            
                        });
                        resolve(`
                            <form>
                                <div class="card-header" style="background: #FF8080">
                                    <div class="d-flex align-items-center" style="width: 100%">
                                        <h3 class="card-title" style="color: white; margin: 0">Mesa #${mesaId}</h3>
                                        <div class="ms-auto">
                                            <a class="badge bg-blue-lt" data-id="${mesaId}" id="ImprimirMesa" onclick="generarPDF()" style="color: white; text-decoration: underline;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                                            </a>
                                            <a class="badge bg-red-lt" style="color: white; text-decoration: underline;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-color-picker"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 7l6 6" /><path d="M4 16l11.7 -11.7a1 1 0 0 1 1.4 0l2.6 2.6a1 1 0 0 1 0 1.4l-11.7 11.7h-4v-4z" /></svg>
                                            </a>
                                        </div>
                                    </div> 
                                </div>
                        
                        
                                <div class="card-body" style="padding: 0px; margin: 0px">
                                    <div class="col-md-12">
                                        <form class="card">
                                            <div class="card-header">
                                            <h3 class="card-title">${consumo[0].CantidadPersonas ? consumo[0].CantidadPersonas + ' personas,' : ''}</h3>
                                                                    ${consumo[0].cliente ? consumo[0].cliente.NombreCliente : ''} 
                                                                    ${consumo[0].camarero ? consumo[0].camarero.NombreCamarero : ''} 
                                                                    ${consumo[0].fecha_venta ? consumo[0].fecha_venta : ''}
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
                                                <div class="row" id="DivFavorite" style="width: 100%">
                                                    
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
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Camarero</label>
                                    <div class="col">
                                    <select class="form-select" id="SeleccionarCamarero" name="SeleccionarCamarero"> 
                                        
                                    </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label pt-0">Comentario</label>
                                    <div class="col">
                                    <textarea class="form-control" rows="5" id="Comentario" name="Comentario"></textarea>
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

    function CanvasTime(){
        var TotalProduct = document.getElementById('form_tabs');
        TotalProduct.innerHTML = `
            <div class="col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <h3 class="card-title" style="color: #424769">Sin Seleccionar Nada, En Espera ...</h3>
                    </div>
                    <div class="img-responsive img-responsive-21x21 card-img-bottom" style="background-image: url('/utilidades/svg/espera.svg')"></div>
                </div>
            </div>
        `;        
    }
    
    $('#ModalCerrarMesa').on('shown.bs.modal', function () {
        $('#btnPorcentaje').off('click').on('click', DescuentoDiv);
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
                            pagos: pagos 
                        },
                        success: function (consumo) {
                            $('#ModalCerrarMesa').modal('hide');
                            document.getElementById('ListPagos').innerHTML = '';
                            document.getElementById('listConsumo').innerHTML = '';
                            document.getElementById
                            ('lisDescuento').innerHTML = '';
                            document.getElementById('listTotal').innerHTML = '';
                            document.getElementById('listVuelto').innerHTML = '';

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
                    success: function(impresora) {
                        let printerName = impresora.NombreImpresora;
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'http://localhost:8080/imprimir/' + printerName, true);
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                alert('El archivo PDF se envió correctamente para imprimir.');
                            } else {
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