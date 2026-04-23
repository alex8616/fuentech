@extends('adminlte::page')

@section('title', 'Personal')

@section('content_header')
    <h1>Registrar Nuevo Elemento</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                     
                    
                    
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body">
                                    <form action="{{ route('admin.personal.AsistenciaHoja') }}" method="get" target="_blank">
                                        @csrf
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label for="">SELECCIONA EL MES</label><br>
                                                    <input type="month" id="AsistenciaMes" name="AsistenciaMes">
                                                </div>
                                            </div>
                                        <br>
                                        <button type="submit" class="btn btn-success" tabindex="4" style="width: 100%;" >CONSULTAR </button> 
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
    
                    
                    <div class="modal fade" id="ReporteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Reporte</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body">
                                    <form action="{{ route('admin.personal.HorarioAsistencia') }}" method="get" target="_blank">
                                        @csrf
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label for="">SELECCIONA EL MES</label><br>
                                                    <input type="month" id="ReporteMes" name="ReporteMes">
                                                </div>
                                            </div>
                                        <br>
                                        <button type="submit" class="btn btn-success" tabindex="4" style="width: 100%;" >CONSULTAR </button> 
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">                            
                            <div class="container" style="background: white; width: 100%; margin: 0px; border-radius:5px; padding: 15px;">
                                <div style="background: #4F4F4F;"><h5 style="font-size: 25px; color: white;"><center>REGISTRAR PERSONAL</center></h5></div>
                                <form action="{{ route('admin.personal.store') }}" method="POST" id="add-form" enctype="multipart/form-data">
                                @csrf
                                    <div class="row" style="padding: 1px">
                                        <div class="col-md-12">  
                                            <input type="hidden" name="id" id="id" value="">
                                            <div class="form-group">
                                                <label class="col-sm-12 col-form-label is-required" for="nombre">NOMBRE COMPLETO: </label><br>
                                                <input type="text" name="NombreCliente" id="NombreCliente" class="otraclaseform"
                                                    tabindex="1" autofocus onkeyup=" javascript:this.value=this.value.toUpperCase();" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12 col-form-label is-required" for="inicio_caja">DNI: </label><br>
                                                <input type="text" name="Dni" id="Dni" class="otraclaseform"
                                                    tabindex="1" autofocus onkeyup=" javascript:this.value=this.value.toUpperCase();" required>
                                            </div>                                   
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="col-sm-12 col-form-label is-required" for="nombre">CARGO</label><br>
                                                    <input type="text" name="Cargo" id="Cargo" class="otraclaseform"
                                                    tabindex="1" autofocus onkeyup=" javascript:this.value=this.value.toUpperCase();" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12 col-form-label is-required" for="inicio_caja">PIN: </label><br>
                                                <input type="text" name="PinCliente" id="PinCliente" class="otraclaseform"
                                                    tabindex="1" autofocus onkeyup=" javascript:this.value=this.value.toUpperCase();" required>                                        
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-12 col-form-label is-required" for="inicio_caja">TRABAJO </label><br>
                                                <select name="Tiempo" id="Tiempo" class="otraclaseform">
                                                    <option value="MEDIO">MEDIO TIEMPO</option>
                                                    <option value="COMPLETO">TIEMPO COMPLETO</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <p><span>Click Para <a href="#" id="agregarImagen"> Agregar Photo</a></span></p>
                                                <input type="text" class="form-control" name="example-text-input" id="ImagenCliente" hidden>
                                                <img id="vistaPrevia" alt="Vista Previa de la Imagen" style="display:none;" class="img-fluid"><br>                                   
                                            </div>
                                        </div>
                                    </div>
                                    <div id="preview"></div>
                                    <div class="row">
                                        <div class="col-md-6 grid-margin stretch-card">
                                            <button type="submit" class="btn btn-success" tabindex="4" style="width: 100%;" id="registrarBtn">Registrar </button>
                                        </div>
                                        <div class="col-md-6 grid-margin stretch-card">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" style="width: 100%;">Cancelar</button>
                                        </div>
                                    </div>
                                </form> 
                            </div>
                        </div>
                        <div class="col-md-8" style="padding: 15px">
                            <div class="container" style="background: white; width: 100%; margin: 0px; border-radius:5px" id="DivContenido"><br>
                                <table id="personal-table" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>DNI</th>
                                        <th>CARGO</th>                              
                                        <th>ACCIONES</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label class="col-sm-12 col-form-label is-required" for="nombre">NOMBRE COMPLETO: </label><br>
                        <input type="text" name="Edit_Nombre_Completo" id="Edit_Nombre_Completo" class="otraclaseform"
                            tabindex="1" autofocus onkeyup=" javascript:this.value=this.value.toUpperCase();" required>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 col-form-label is-required" for="nombre">DNI: </label><br>
                        <input type="text" name="Edit_Dni" id="Edit_Dni" class="otraclaseform"
                            tabindex="1" autofocus onkeyup=" javascript:this.value=this.value.toUpperCase();" required>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 col-form-label is-required" for="nombre">CARGO: </label><br>
                        <input type="text" name="Edit_Cargo" id="Edit_Cargo" class="otraclaseform"
                            tabindex="1" autofocus onkeyup=" javascript:this.value=this.value.toUpperCase();" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success" style="width: 100%;">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">
<style>
    video{
        margin-top: -800px;
        width: 58%;
        padding: 50px;
        padding-top: 170px;
        margin-left: 665px;
        position: absolute;
        border-radius: 10px solid black;
    }
    #contador {
        z-index: 1;
        top: 5px;
        left: 120px;
        font-size: 60px;
        color: blue;
        font-family: 'Arial', sans-serif; /* Cambia la fuente según tus preferencias */
        font-weight: bold; /* Puedes ajustar la intensidad de la fuente */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Sombra del texto */
        letter-spacing: 2px; /* Espaciado entre letras */
    }

    /*Input FORM*/
    .otraclase{
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .otraclase:focus {
        border-color: #4d94ff;
        box-shadow: 0 0 0 0.25rem rgba(77, 148, 255, 0.25);
    }
    .otraclaseform{
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .otraclaseform:focus {
        border-color: #4d94ff;
        box-shadow: 0 0 0 0.25rem rgba(77, 148, 255, 0.25);
    }
    /*FIN input*/
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    .imagen-articulo {
        display: inline-block;
        width: 110px;
        border: 1px solid #ccc;
        margin-right: 10px;
        border-radius: 10px;
    }
</style>
@stop

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('Face/face-api.min.js')}}"></script>

<script>
    //llenar datos la tabla 
    $('#personal-table').DataTable({
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>tip',
        language: {
            lengthMenu: 'Mostrar _MENU_ Pagina'
        },
        "ordering": false,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Mostrar todos"]],
        "ajax": "{{ route('personal.data') }}",
        "columns": [
            {data: 'id'},
            {data: 'Nombre_Completo'},
            {data: 'Dni'},
            {data: 'Cargo'},
            {
                data: null,
                render: function(data, type, row) {
                  return '<button class="btn btn-success btn-edit" data-id="'+data.id+'" style="margin: 3px; padding: 3px">Editar</button>'+
                        '<button class="btn btn-danger btn-delete" data-id="'+data.id+'" onclick="confirmDelete('+data.id+')" style="margin: 3px; padding: 3px">Eliminar</button>';
                       
                }
            }
        ],
        error : function() {
            alert("Nothing Data");
        }
    });
    
    //editar datos
    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        console.log(id)
        $.ajax({
            type: 'get',
            url: "{{ route('personal.edit', ['id' => ':id']) }}".replace(':id', id),
            data: {
                'id': id
            },
            success: function(data) {
                console.log(data)
                $('#id').val(data.id);
                $('#Edit_Nombre_Completo').val(data.Nombre_Completo);
                $('#Edit_Dni').val(data.Dni);
                $('#Edit_Cargo').val(data.Cargo);
                $('#modalEdit').modal('show');
            },
            error: function() {
                alert("Error al recibir los datos");
            }
        });
        ///actualizar datos    
        $("#modalEdit .btn-success").off('click').on("click", function() {
            var data = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'Edit_Nombre_Completo': $('#Edit_Nombre_Completo').val(),
                'Edit_Dni': $('#Edit_Dni').val(),
                'Edit_Cargo': $('#Edit_Cargo').val(),
            };
            console.log(data)
            $.ajax({
                type: 'put',
                url: "{{ route('updatepersonal', ['id' => ':id']) }}".replace(':id', $('input[name=id]').val()),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function(data) {
                    $('#modalEdit').modal('hide');
                    $('#modalEdit form').trigger('reset');
                    $('#personal-table').DataTable().ajax.reload();
                    toastr.success(data.message, "Mensaje de éxito", {"iconClass": 'toast-success'});
                },
                error: function(xhr, textStatus, errorThrown) {
                    toastr.error('<i class="fas fa-exclamation-circle"></i> Error: No se ha podido actualizar los datos.', 'Error');
                }
            });
        });
    });
    //eliminar fila table
    function confirmDelete(id) {
      if (confirm('¿Estás seguro de que quieres eliminar este registro?')) {
        $.ajax({
          type: 'delete',
          url: "{{ route('eliminarpersonal', ['id' => ':id']) }}".replace(':id', id),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            $('#personal-table').DataTable().ajax.reload();
            toastr.success(data.message, "Mensaje de éxito", {"iconClass": 'toast-success'});
          },
          error: function(xhr, textStatus, errorThrown) {
            toastr.error('<i class="fas fa-exclamation-circle"></i> Error: No se ha podido eliminar los datos.', 'Error');
          }
        });
      }
    }
</script>
<script>
    function limpiarImagenes() {
        const imagenesPrevias = document.querySelectorAll('.imagenPrevia');
        imagenesPrevias.forEach((imagen) => {
            document.body.removeChild(imagen);
        });

        // Oculta la imagen de vista previa
        const vistaPreviaImg = document.getElementById('vistaPrevia');
        vistaPreviaImg.style.display = 'none';

        // Limpia el valor del campo de entrada de imagen
        const imagenClienteInput = document.getElementById('ImagenCliente');
        imagenClienteInput.value = '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const agregarImagen = document.getElementById('agregarImagen');
        const vistaPreviaImg = document.getElementById('vistaPrevia');

        agregarImagen.addEventListener('click', () => {
            limpiarImagenes();  // Limpia las imágenes previas

            abrirCamara()
                .then((fotoDataURL) => {
                    vistaPreviaImg.src = fotoDataURL;
                    vistaPreviaImg.style.display = 'block';
                    const imagenClienteInput = document.getElementById('ImagenCliente');
                    imagenClienteInput.value = fotoDataURL;
                })
                .catch((error) => {
                    console.error('Error al abrir la cámara:', error);
                });
        });

        function abrirCamara() {
            return new Promise((resolve, reject) => {
                const constraints = { video: true };

                navigator.mediaDevices.getUserMedia(constraints)
                    .then((stream) => {
                        const guia = document.createElement('div');
                        guia.id = 'guia';
                        guia.style.position = 'absolute';
                        guia.style.width = '300px';
                        guia.style.height = '400px';
                        guia.style.borderTopLeftRadius = '10px';
                        guia.style.borderTopRightRadius = '10px';
                        guia.style.borderBottomLeftRadius = '10px';
                        guia.style.borderBottomRightRadius = '10px';
                        guia.style.boxSizing = 'border-box';
                        guia.style.pointerEvents = 'none';
                        guia.style.top = '50%';
                        guia.style.left = '50%';
                        guia.style.transform = 'translate(-50%, -50%)';

                        const contador = document.createElement('div');
                        contador.id = 'contador';
                        guia.appendChild(contador);

                        document.body.appendChild(guia);

                        const video = document.createElement('video');
                        document.body.appendChild(video);
                        video.srcObject = stream;
                        video.play();

                        let tiempoRestante = 6;
                        const contadorInterval = setInterval(() => {
                            contador.textContent = tiempoRestante + 's';
                            tiempoRestante--;

                            if (tiempoRestante < 0) {
                                clearInterval(contadorInterval);

                                const canvas = document.createElement('canvas');
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;
                                const context = canvas.getContext('2d');
                                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                                const fotoDataURL = canvas.toDataURL('image/png');
                                video.pause();
                                stream.getTracks().forEach(track => track.stop());
                                document.body.removeChild(video);
                                document.body.removeChild(guia);
                                resolve(fotoDataURL);
                            }
                        }, 1000);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        }

        
        $('#registrarBtn').click(function(e) {
            e.preventDefault();
        
            // Ocultar el botón
            $('#registrarBtn').prop('disabled', true).text('Registrando...');
        
            const nombreCliente = $('#NombreCliente').val();
            const dniCliente = $('#Dni').val();
            const pinCliente = $('#PinCliente').val();
            const imagenCliente = $('#ImagenCliente').val();
            const cargoCliente = $('#Cargo').val();
            const tiempoCliente = $('#Tiempo').val();
            const token = $('meta[name="csrf-token"]').attr('content');
        
            extraerDescriptoresFacial(imagenCliente)
                .then((descriptores) => {
                    console.log('Descriptores faciales extraídos:', descriptores);
                    $.ajax({
                        url: '/Registrar-personal',
                        type: 'POST',
                        data: {
                            _token: token,
                            nombre: nombreCliente,
                            pin: pinCliente,
                            imagen: imagenCliente,
                            descriptores: descriptores,
                            dni: dniCliente,
                            cargo: cargoCliente,
                            tiempo: tiempoCliente,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Mostrar el botón de nuevo y cambiar el texto al original
                            $('#registrarBtn').prop('disabled', false).text('Registrar');
        
                            $('#personal-table').DataTable().ajax.reload();
                            $('#add-form').trigger('reset');
                            limpiarImagenes();
                            preview.innerHTML = "";
                            toastr.success("Se ha registrado con éxito.", "Mensaje de éxito", {
                                "iconClass": 'toast-success'
                            });
                        },
                        error: function(error) {
                            // Mostrar el botón de nuevo en caso de error
                            $('#registrarBtn').prop('disabled', false).text('Registrar');
        
                            toastr.error("Error en la solicitud AJAX.", "Mensaje de error", {
                                "iconClass": 'toast-error'
                            });
                        }
                    });
                })
                .catch((error) => {
                    // Mostrar el botón de nuevo si hay un error al extraer descriptores faciales
                    $('#registrarBtn').prop('disabled', false).text('Registrar');
        
                    toastr.error("Error al extraer descriptores faciales.", "Mensaje de error", {
                        "iconClass": 'toast-error'
                    });
                });
        });

        
        function extraerDescriptoresFacial(imagenBase64) {
            return new Promise(async (resolve, reject) => {
                try {
                    // Convierte la imagen base64 en un objeto Image
                    const image = new Image();
                    image.src = imagenBase64;

                    image.onload = async () => {
                        console.log('Imagen cargada correctamente');

                        // Carga el modelo face-api.js
                        await faceapi.nets.faceRecognitionNet.loadFromUri('Face/models');
                        await faceapi.nets.faceLandmark68Net.loadFromUri('Face/models');
                        await faceapi.nets.ssdMobilenetv1.loadFromUri('Face/models');

                        console.log('Modelos cargados correctamente');

                        // Detecta rostros y landmarks en la imagen
                        const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors();

                        console.log('Rostros detectados:', detections);

                        // Extrae los descriptores faciales
                        const descriptors = detections.map((detection) => detection.descriptor);

                        console.log('Descriptores faciales extraídos:', descriptors);

                        resolve(descriptors);
                    };
                } catch (error) {
                    reject(error);
                }
            });
        }


    });
</script>
@stop

