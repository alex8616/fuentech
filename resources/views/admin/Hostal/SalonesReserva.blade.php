<div class="card-header" id="card-salones" style="width: 100%; background-color: white; display: flex; flex-wrap: wrap;">
    
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('utilidades/js/hostal/hospedajehabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/ocupadohabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/hospedajelimpieza.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/hospedajesucio.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/ocupadohabitaciongrupo.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/GrupoInformacionHabitacion.js') }}" defer></script>
<script src="{{ asset('utilidades/js/hostal/hospedajemantenimiento.js') }}" defer></script>
<script src="{{ asset('utilidades/js/InputClass.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
    #salon-disponible{
        border: 2px solid green;
        box-shadow: 0 0 15px 5px rgba(0, 255, 0, 0.7);
        transition: box-shadow 0.3s ease-in-out;
    }

    #salon-disponible:hover {
        box-shadow: 0 0 25px 10px rgba(0, 255, 0, 1);
    }

    #salon-ocupado{
        border: 2px solid green; 
        box-shadow: 0 0 15px 5px rgba(255, 0, 0);
        transition: box-shadow 0.3s ease-in-out;
    }

    #salon-ocupado:hover {
        box-shadow: 0 0 25px 10px rgba(255, 0, 1);
    }

    #salon-limpieza{
        border: 2px solid green; 
        box-shadow: 0 0 15px 5px rgba(255, 102, 0);
        transition: box-shadow 0.3s ease-in-out;
    }

    #salon-limpieza:hover {
        box-shadow: 0 0 25px 10px rgba(255, 102, 1);
    }

    #salon-mantenimiento{
        border: 2px solid green; 
        box-shadow: 0 0 15px 5px rgba(65, 116, 255);
        transition: box-shadow 0.3s ease-in-out;
    }

    #salon-mantenimiento:hover {
        box-shadow: 0 0 25px 10px rgba(65, 116, 255);
    }

    #salon-grupo{
        border: 6px solid brown; 
        box-shadow: 0 0 25px 40px rgb(67, 0, 0);
        transition: box-shadow 0.9s ease-in-out;
    }

    #salon-grupo:hover {
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
    $(document).ready(function() { 
        MostrarAmbientes();
    });

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
                                        <a href="#" class="card-btn" onclick="OcupadoHabitacion(${salon.id})">
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

                $('#agregar-salon-ambiente').on('click', function(event) {
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
</script>