@extends('layouts.my-dashboard-layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card-body" style="padding-left: 90px; padding-right: 90px;">
        <ul class="steps steps-green steps-counter my-4">
            <li class="step-item" id="step-seleccionar-impresora">SELECCIONAR IMPRESORA</li>
            <li class="step-item" id="step-completado">COMPLETADO</li>
        </ul>

        <div class="row" id="impresoras-container">

        </div>

    </div>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        AllImpresora();
    });

    function AllImpresora(){
        const impresorasContainer = document.getElementById('impresoras-container');
        $.ajax({
            url: '/api/obtener-count-impresoras',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.length > 0) {
                const stepElementSI = document.getElementById('step-seleccionar-impresora');
                const stepElementSP = document.getElementById('step-preferencias');
                const stepElementSC = document.getElementById('step-completado');
                stepElementSI.classList.remove('active');
                stepElementSC.classList.add('active');

                impresorasContainer.innerHTML = '';
                const card = document.createElement('div');
                card.classList.add('col-md-12', 'col-lg-5');
                card.innerHTML = `
                <div class="page-body">
                    <div class="container-xl">
                        <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                            <div class="list-group card-list-group">
                                <div class="list-group-item">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto fs-3">
                                    1
                                    </div>
                                    <div class="col-auto">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-51.2 -51.2 614.40 614.40" xml:space="preserve" width="81px" height="81px" fill="#000000" stroke="#000000" stroke-width="0.00512"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="53.248000000000005"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#4D4D4D;" d="M421.978,118.159H256v163.154h199.736V151.917C455.736,133.35,440.545,118.159,421.978,118.159z"></path> <path style="fill:#737373;" d="M90.022,118.159c-18.567,0-33.758,15.191-33.758,33.758v129.395H256V118.159H90.022z"></path> <polygon style="fill:#DCDCDC;" points="399.473,0.016 399.473,281.313 286.945,281.313 365.714,0.016 "></polygon> <rect x="112.527" y="0.006" style="fill:#EEEEEE;" width="253.187" height="281.296"></rect> <path style="fill:#02ACAB;" d="M466.989,236.302h-33.758v135.033L512,326.323v-45.011C512,256.556,491.745,236.302,466.989,236.302z "></path> <path style="fill:#42C8C6;" d="M478.242,281.313v123.78L0,326.323v-45.011c0-24.756,20.255-45.011,45.011-45.011h388.22 C457.987,236.302,478.242,256.556,478.242,281.313z"></path> <polygon style="fill:#B9B9B9;" points="512,326.323 512,511.994 478.242,511.994 455.736,419.159 478.242,326.323 "></polygon> <polygon style="fill:#DCDCDC;" points="478.242,326.323 478.242,511.994 433.231,511.994 256,427.598 78.769,511.994 0,511.994 0,326.323 "></polygon> <polygon style="fill:#4D4D4D;" points="433.231,393.84 433.231,427.598 365.714,467.782 399.473,393.84 "></polygon> <g> <polygon style="fill:#737373;" points="399.473,393.84 399.473,427.598 239.121,461.356 78.769,427.598 78.769,393.84 "></polygon> <polygon style="fill:#737373;" points="433.231,427.598 433.231,511.994 399.473,511.994 365.714,469.796 399.473,427.598 "></polygon> </g> <rect x="78.769" y="427.598" style="fill:#969696;" width="320.703" height="84.396"></rect> <g> <path style="fill:#4D4D4D;" d="M326.33,81.587H185.67c-4.661,0-8.44-3.778-8.44-8.44c0-4.662,3.779-8.44,8.44-8.44H326.33 c4.662,0,8.44,3.778,8.44,8.44C334.769,77.81,330.992,81.587,326.33,81.587z"></path> <path style="fill:#4D4D4D;" d="M326.33,126.598H185.67c-4.661,0-8.44-3.778-8.44-8.44s3.779-8.44,8.44-8.44H326.33 c4.662,0,8.44,3.778,8.44,8.44S330.992,126.598,326.33,126.598z"></path> <path style="fill:#4D4D4D;" d="M272.506,171.609H185.67c-4.661,0-8.44-3.778-8.44-8.44s3.779-8.44,8.44-8.44h86.835 c4.662,0,8.44,3.778,8.44,8.44S277.168,171.609,272.506,171.609z"></path> </g> <path style="fill:#FFFFFF;" d="M444.484,289.752h-11.253c-4.662,0-8.44-3.778-8.44-8.44s3.778-8.44,8.44-8.44h11.253 c4.662,0,8.44,3.778,8.44,8.44S449.146,289.752,444.484,289.752z"></path> </g></svg>
                                    </div>
                                    <div class="col">
                                        ${response[0].NombreImpresora}
                                    <div class="text-muted">
                                        ${response[0].NombreImpresora} <br>
                                        <a href="#" class="link-secondary btnImprimirPrueba" data-name="${response[0].NombreImpresora}">
                                            <span class="switch-icon-a" style="color: blue">
                                                Impresion De Prueba
                                            </span>
                                        </a>
                                    </div>
                                    </div>
                                    <div class="col-auto" style="text-align: center;">
                                    <a href="#" class="link-secondary btnEliminarImpresora" data-id="${response[0].id}">
                                        <span class="switch-icon-a" style="color: #D80032">
                                                Eliminar <br> Impresora
                                        </span>
                                    </a>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                `;
                impresorasContainer.appendChild(card);
                EliminarImpresora(response[0].id);
                btnImprimirPrueba(response[0].id);
            }else{
                const stepElementSI = document.getElementById('step-seleccionar-impresora');
                const stepElementSP = document.getElementById('step-preferencias');
                const stepElementSC = document.getElementById('step-completado');
                stepElementSI.classList.add('active');

                impresorasContainer.innerHTML = '';
                    fetch('/api/get-list-print')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(impresora => {
                            const card = document.createElement('div');
                            card.classList.add('col-md-6', 'col-lg-2');
                            card.innerHTML = `
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h3 class="card-title"><strong>${impresora}</strong></h3>
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-51.2 -51.2 614.40 614.40" xml:space="preserve" width="177px" height="177px" fill="#000000" stroke="#000000" stroke-width="0.00512"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="53.248000000000005"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#4D4D4D;" d="M421.978,118.159H256v163.154h199.736V151.917C455.736,133.35,440.545,118.159,421.978,118.159z"></path> <path style="fill:#737373;" d="M90.022,118.159c-18.567,0-33.758,15.191-33.758,33.758v129.395H256V118.159H90.022z"></path> <polygon style="fill:#DCDCDC;" points="399.473,0.016 399.473,281.313 286.945,281.313 365.714,0.016 "></polygon> <rect x="112.527" y="0.006" style="fill:#EEEEEE;" width="253.187" height="281.296"></rect> <path style="fill:#02ACAB;" d="M466.989,236.302h-33.758v135.033L512,326.323v-45.011C512,256.556,491.745,236.302,466.989,236.302z "></path> <path style="fill:#42C8C6;" d="M478.242,281.313v123.78L0,326.323v-45.011c0-24.756,20.255-45.011,45.011-45.011h388.22 C457.987,236.302,478.242,256.556,478.242,281.313z"></path> <polygon style="fill:#B9B9B9;" points="512,326.323 512,511.994 478.242,511.994 455.736,419.159 478.242,326.323 "></polygon> <polygon style="fill:#DCDCDC;" points="478.242,326.323 478.242,511.994 433.231,511.994 256,427.598 78.769,511.994 0,511.994 0,326.323 "></polygon> <polygon style="fill:#4D4D4D;" points="433.231,393.84 433.231,427.598 365.714,467.782 399.473,393.84 "></polygon> <g> <polygon style="fill:#737373;" points="399.473,393.84 399.473,427.598 239.121,461.356 78.769,427.598 78.769,393.84 "></polygon> <polygon style="fill:#737373;" points="433.231,427.598 433.231,511.994 399.473,511.994 365.714,469.796 399.473,427.598 "></polygon> </g> <rect x="78.769" y="427.598" style="fill:#969696;" width="320.703" height="84.396"></rect> <g> <path style="fill:#4D4D4D;" d="M326.33,81.587H185.67c-4.661,0-8.44-3.778-8.44-8.44c0-4.662,3.779-8.44,8.44-8.44H326.33 c4.662,0,8.44,3.778,8.44,8.44C334.769,77.81,330.992,81.587,326.33,81.587z"></path> <path style="fill:#4D4D4D;" d="M326.33,126.598H185.67c-4.661,0-8.44-3.778-8.44-8.44s3.779-8.44,8.44-8.44H326.33 c4.662,0,8.44,3.778,8.44,8.44S330.992,126.598,326.33,126.598z"></path> <path style="fill:#4D4D4D;" d="M272.506,171.609H185.67c-4.661,0-8.44-3.778-8.44-8.44s3.779-8.44,8.44-8.44h86.835 c4.662,0,8.44,3.778,8.44,8.44S277.168,171.609,272.506,171.609z"></path> </g> <path style="fill:#FFFFFF;" d="M444.484,289.752h-11.253c-4.662,0-8.44-3.778-8.44-8.44s3.778-8.44,8.44-8.44h11.253 c4.662,0,8.44,3.778,8.44,8.44S449.146,289.752,444.484,289.752z"></path> </g></svg>
                                    </div>
                                    <div class="card-footer" style="margin: 0px; padding: 0px">
                                        <button class="btn btn-primary" onclick="seleccionarImpresora('${impresora}')" style="width: 100%">Seleccionar impresora</button>
                                    </div>
                                </div>
                            `;
                            impresorasContainer.appendChild(card);
                        });
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }


    function EliminarImpresora(id){
        $(".btnEliminarImpresora").click(function(e) {
            e.preventDefault();
            var idImpresora = $(this).data('id');
            if (confirm("¿Estás seguro de que quieres eliminar esta impresora?")) {
                $.ajax({
                    url: '/api/eliminar-impresora/' + idImpresora,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            AllImpresora();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    }


    function btnImprimirPrueba(id){
        $(".btnImprimirPrueba").click(function(e) {
            e.preventDefault();
            let urlPdf;
            let nombreImpresora = $(this).data('name');
            $.ajax({
                url: window.location.origin + '/api/generar-pdf',
                type: 'GET',
                beforeSend: function(xhr, settings) {
                    urlPdf = settings.url;
                },
                success: function(data) {
                    const url = `http://localhost:8080/url?urlPdf=${urlPdf}&impresora=${nombreImpresora}`;
                    fetch(url)
                    .then(respuesta => {
                        if (respuesta.status === 200) {
                            console.log("Impresión OK");
                        } else {
                            respuesta.json()
                            .then(mensaje => {
                                console.log("Error: " + mensaje);
                            });
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    }


    function seleccionarImpresora(nombreImpresora) {
        $.ajax({
            url: '/api/registrar-impresora',
            type: 'POST',
            data: { nombreImpresora: nombreImpresora },
            success: function(data) {
                AllImpresora();

                console.log('Impresora registrada:', data);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

</script>
@livewireStyles

@livewireScripts
