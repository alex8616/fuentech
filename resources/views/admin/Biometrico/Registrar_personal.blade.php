@extends('layouts.my-dashboard-person')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-sm-6">
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" name="example-text-input" id="NombreCliente">
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" name="example-text-input" id="PinCliente">
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" name="example-text-input" id="ImagenCliente" hidden>
        </div>
        
        <a href="#" id="agregarImagen">Agregar Imagen</a>
        <img id="vistaPrevia" alt="Vista Previa de la Imagen" style="display:none;"><br>

        <button type="button" id="registrarBtn">Registrar Personal</button>
    </div>
    <div class="col-sm-6">
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="w-1"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td >Paweł Kuna</td>
                                <td class="text-muted" >
                                UI Designer, Training
                                </td>
                                <td class="text-muted" ><a href="#" class="text-reset">paweluna@howstuffworks.com</a></td>
                                <td class="text-muted" >
                                User
                                </td>
                                <td>
                                <a href="#">Edit</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('Face/face-api.min.js')}}"></script>
<script>
    function actualizarFechaHora() {
        var fechaHora = new Date();
        var opcionesFecha = { day: '2-digit', month: 'long', year: 'numeric' };
        var fechaFormateada = fechaHora.toLocaleDateString('es-ES', opcionesFecha);
        var horaFormateada = ("0" + fechaHora.getHours()).slice(-2) + ":" + ("0" + fechaHora.getMinutes()).slice(-2) + ":" + ("0" + fechaHora.getSeconds()).slice(-2);

        // Actualizar el contenido de los divs correspondientes
        document.getElementById("FechaDiv").innerHTML = fechaFormateada;
        document.getElementById("HoraDiv").innerHTML = horaFormateada;
    }
    setInterval(actualizarFechaHora, 1000);
    actualizarFechaHora();
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
                        guia.style.borderTop = '4px solid red';
                        guia.style.borderBottom = '4px solid red';
                        guia.style.borderLeft = '4px solid red';
                        guia.style.borderRight = '4px solid red';
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
                        contador.style.position = 'absolute';
                        contador.style.top = '5px';
                        contador.style.left = '5px';
                        contador.style.fontSize = '60px';
                        contador.style.color = 'white';
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

        $('#registrarBtn').click(function() {
            const nombreCliente = $('#NombreCliente').val();
            const pinCliente = $('#PinCliente').val();
            const imagenCliente = $('#ImagenCliente').val();
            const token = $('meta[name="csrf-token"]').attr('content');

            // Extraer descriptores faciales en el lado del cliente
            extraerDescriptoresFacial(imagenCliente)
                .then((descriptores) => {
                    console.log('Descriptores faciales extraídos:', descriptores);

                    // Enviar datos al servidor, incluyendo descriptores faciales
                    $.ajax({
                        url: '/Registrar-personal',
                        type: 'POST',
                        data: {
                            _token: token,
                            nombre: nombreCliente,
                            pin: pinCliente,
                            imagen: imagenCliente,
                            descriptores: descriptores,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Registro exitoso:', response);
                        },
                        error: function(error) {
                            console.error('Error en la solicitud AJAX:', error);
                        }
                    });
                })
                .catch((error) => {
                    console.error('Error al extraer descriptores faciales:', error);
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
@endsection


@livewireStyles

@livewireScripts
