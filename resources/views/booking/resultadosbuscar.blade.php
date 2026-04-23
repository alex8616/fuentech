<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Habitaciones Disponibles | TUKO'S</title>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link rel="stylesheet" href="{{ asset('utilidades/css/booking.css') }}">

<style>

body{
    background: var(--color-primario);
    color: white;
    margin: 0;
}

/* 🔥 CONTENEDOR GENERAL */
.wrapper{
    width: 80%;
    margin: 0 auto; /* ✅ centra horizontalmente */
}

.titulo-busqueda{
    text-align:center;
    font-size:3rem;
    margin-top:40px;
}

.subtitulo-busqueda{
    text-align:center;
    color:var(--color-secundario);
    margin-bottom:40px;
}

.rooms{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:30px;
    padding:0 40px 60px;
}

.room-card{
    background:var(--color-terciario);
    border-radius:15px;
    overflow:hidden;
    transition:.3s;
}

.room-card:hover{
    transform:translateY(-8px);
}

.room-img{
    height:220px;
    background-size:cover;
    background-position:center;
}

.room-content{
    padding:20px;
    text-align:center;
}

.room-precio{
    font-size:1.8rem;
    color:var(--color-secundario);
}

.room-btn{
    width:100%;
}

.reserva-container{
    width:100%;
    max-width:1200px;
    margin:40px auto;
    padding:40px;
    background:var(--color-terciario);
    border-radius:15px;
}

.reserva-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
}

.reserva-info{
    background:var(--color-primario);
    padding:25px;
    border-radius:15px;
}

.reserva-form{
    padding:25px;
}

.reserva-img{
    height:250px;
    background-size:cover;
    border-radius:10px;
    margin-bottom:15px;
}

.form-group{
    margin-bottom:15px;
}

.form-group input,
.form-group textarea{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:none;
}

.btn-group{
    display:flex;
    gap:10px;
}

.btn-group button{
    flex:1;
}

/* BUSCADOR */
.buscador-top{
    display:flex;
    justify-content:center;
    gap:10px;
    padding:20px;
    flex-wrap:wrap;
}

.buscador-top input,
.buscador-top select{
    padding:10px;
    border-radius:8px;
    border:none;
}

/* CONTADOR */
.contador{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    margin-top:10px;
}

.contador button{
    width:35px;
    height:35px;
    border-radius:50%;
    border:none;
    background:var(--color-secundario);
    color:black;
    font-size:18px;
    cursor:pointer;
}

.contador span{
    min-width:25px;
    text-align:center;
    font-weight:bold;
}

/* FACTURA */
.factura{
    background:#111;
    border-radius:15px;
    padding:20px;
    border:1px solid rgba(197,165,114,0.2);
}

.factura h3{
    text-align:center;
    margin-bottom:15px;
    color:var(--color-secundario);
}

.tabla-factura{
    width:100%;
    border-collapse:collapse;
}

.tabla-factura th,
.tabla-factura td{
    padding:10px;
    border-bottom:1px solid rgba(255,255,255,0.1);
}

.factura-total{
    text-align:right;
    margin-top:15px;
    font-size:1.5rem;
    color:var(--color-secundario);
}

@media(max-width:768px){
    .rooms{grid-template-columns:1fr;}
    .reserva-grid{grid-template-columns:1fr;}
}

/* LOADING */
.loading-overlay{
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.7);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.loading-box{
    text-align:center;
}

.spinner{
    width:60px;
    height:60px;
    border:5px solid rgba(255,255,255,0.2);
    border-top:5px solid var(--color-secundario);
    border-radius:50%;
    animation:spin 1s linear infinite;
    margin:auto;
}

@keyframes spin{
    0%{transform:rotate(0deg);}
    100%{transform:rotate(360deg);}
}

/* MODAL */
.modal-resultado{
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.7);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-box{
    background: var(--color-terciario);
    padding:30px;
    border-radius:15px;
    text-align:center;
    max-width:400px;
}

</style>
</head>

<body>
<div class="wrapper">
    <h1 class="titulo-busqueda">Habitaciones disponibles</h1>
    <p id="fechasBusqueda" class="subtitulo-busqueda"></p>

    <div class="buscador-top" id="buscadorTop">
        <input type="date" id="checkinInput">
        <input type="date" id="checkoutInput">

        <select id="personasInput">
            <option value="1">1 Persona</option>
            <option value="2">2 Personas</option>
            <option value="3">3 Personas</option>
            <option value="4">4 Personas</option>
            <option value="5">5+</option>
        </select>

        <button onclick="buscarNuevamente()" class="booking-button">
            BUSCAR
        </button>
    </div>

    <div id="habitacionesDisponibles" class="rooms"></div>
</div>

<!-- LOADING -->
<div id="loadingOverlay" class="loading-overlay">
    <div class="loading-box">
        <div class="spinner"></div>
        <p>Procesando tu reserva...</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

const params = new URLSearchParams(window.location.search)

let checkin = params.get('checkin')
let checkout = params.get('checkout')

let roomsData = []
let selectedRooms = []

document.getElementById('fechasBusqueda').innerHTML =
`Desde <b>${checkin}</b> hasta <b>${checkout}</b>`

$("#checkinInput").val(checkin)
$("#checkoutInput").val(checkout)

function getImagen(nombre){
    let img="/booking/default.jpg"
    nombre = nombre.toLowerCase()

    if(nombre.includes("simple")) img="/booking/habitacion2.jpg"
    if(nombre.includes("matrimonial")) img="/booking/habitacionMatrimonial.jpg"
    if(nombre.includes("doble")) img="/booking/habitacionDoble.jpg"
    if(nombre.includes("triple")) img="/booking/habitacionTriple.jpg"

    return img
}

function buscarNuevamente(){
    let c=$("#checkinInput").val()
    let co=$("#checkoutInput").val()
    if(!c || !co) return alert("Selecciona fechas")
    window.location.href=`?checkin=${c}&checkout=${co}`
}

function cargarHabitaciones(){

    $("#buscadorTop").show()
    $("#habitacionesDisponibles").addClass("rooms")

    $.get("/apihostal/disponibilidad",{checkin,checkout},function(rooms){

        roomsData=rooms
        let html=""

        rooms.forEach(room=>{
            let img=getImagen(room.nombre)

            html+=`
            <div class="room-card">
                <div class="room-img" style="background-image:url('${img}')"></div>
                <div class="room-content">
                    <h3>Habitacion ${room.nombre}</h3>
                    <div class="room-precio">${room.precio} Bs.</div>
                    <p>${room.disponibles} disponibles</p>

                    <div class="contador">
                        <button onclick="cambiarCantidad(${room.id}, -1)">-</button>
                        <span id="cantidad-${room.id}">0</span>
                        <button onclick="cambiarCantidad(${room.id}, 1)">+</button>
                    </div>
                </div>
            </div>`
        })

        html+=`<div style="grid-column:1/-1;text-align:center;">
        <button class="booking-button" onclick="continuarReserva()">CONTINUAR RESERVA</button>
        </div>`

        $("#habitacionesDisponibles").html(html)
    })
}

function cambiarCantidad(id,cambio){
    const room=roomsData.find(r=>r.id==id)
    let span=document.getElementById(`cantidad-${id}`)
    let actual=parseInt(span.innerText)
    let nueva=Math.max(0,Math.min(room.disponibles,actual+cambio))
    span.innerText=nueva
    agregarHabitacion(id,nueva)
}

function agregarHabitacion(id,cantidad){
    selectedRooms=selectedRooms.filter(r=>r.id!=id)
    if(cantidad>0){
        let room=roomsData.find(r=>r.id==id)
        selectedRooms.push({...room,cantidad})
    }
}

function continuarReserva(){

    if(selectedRooms.length===0) return alert("Selecciona habitaciones")

    $("#buscadorTop").hide()
    $("#habitacionesDisponibles").removeClass("rooms")

    let total=0
    let filas=""

    selectedRooms.forEach(r=>{
        let sub=r.precio*r.cantidad
        total+=sub

        filas+=`
        <tr>
            <td>${r.nombre}</td>
            <td>${r.cantidad}</td>
            <td>${r.precio}</td>
            <td>${sub}</td>
        </tr>`
    })

    let html=`
    <div class="reserva-container">

        <h2>Confirmar Reserva</h2>

        <div class="reserva-grid">

            <div class="reserva-info">
                <div class="factura">
                    <h3>🧾 Resumen</h3>

                    <table class="tabla-factura">
                        <thead>
                            <tr>
                                <th>Habitación</th>
                                <th>Cant.</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>${filas}</tbody>
                    </table>

                    <p><b>Fechas:</b> ${checkin} → ${checkout}</p>

                    <div class="factura-total">
                        TOTAL: ${total} Bs.
                    </div>
                </div>
            </div>

            <div class="reserva-form">

                <form id="formReserva">

                    <div class="form-group">
                        <input type="text" id="nombre" placeholder="Nombre completo" required>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" placeholder="Correo electrónico" required>
                    </div>

                    <div class="form-group">
                        <input type="text" id="telefono" placeholder="Celular" required>
                    </div>

                    <div class="form-group">
                        <textarea id="observaciones" placeholder="Observaciones"></textarea>
                    </div>

                    <div class="btn-group">
                        <button class="booking-button">CONFIRMAR</button>
                        <button type="button" onclick="cargarHabitaciones()" class="booking-button">VOLVER</button>
                    </div>

                </form>

            </div>

        </div>
    </div>`

    $("#habitacionesDisponibles").html(html)
}

$(document).on("submit","#formReserva",function(e){
    e.preventDefault()

    // 🔥 MOSTRAR LOADING
    $("#loadingOverlay").css("display","flex")

    let data = {
        checkin,
        checkout,
        nombre: $("#nombre").val(),
        telefono: $("#telefono").val(),
        email: $("#email").val(),
        observaciones: $("#observaciones").val(),
        rooms: selectedRooms
    }

    $.ajax({
        url: "/apihostal/reserva-habitacion-booking",
        method: "POST",
        data: data,

        success: function(res){

            $("#loadingOverlay").hide()

            let detalle = ""
            let total = 0

            selectedRooms.forEach(r=>{
                let subtotal = r.precio * r.cantidad
                total += subtotal

                detalle += `
                <tr>
                    <td>${r.nombre}</td>
                    <td>${r.cantidad}</td>
                    <td>${r.precio} Bs.</td>
                    <td>${subtotal} Bs.</td>
                </tr>
                `
            })

            let html = `
            <div class="reserva-container">

                <div style="text-align:center; margin-bottom:30px;">
                    <h1 style="color:var(--color-secundario);">
                        🎉 ¡Reserva Enviada!
                    </h1>

                    <p>
                        Gracias <b>${$("#nombre").val()}</b>, tu reserva fue registrada correctamente.
                    </p>

                    <p>
                        📩 Te enviamos un correo para que puedas verificar el estado de tu reserva.
                    </p>

                    <p>
                        <b>Código de reserva:</b> ${res.codigo}
                    </p>
                </div>

                <div class="factura">

                    <h3>🧾 Detalle de tu reserva</h3>

                    <table class="tabla-factura">
                        <thead>
                            <tr>
                                <th>Habitación</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            ${detalle}
                        </tbody>
                    </table>

                    <p style="margin-top:15px;">
                        <b>Fechas:</b> ${checkin} → ${checkout}
                    </p>

                    <div class="factura-total">
                        TOTAL: ${total} Bs.
                    </div>

                </div>

                <div style="text-align:center; margin-top:30px;">
                    <button onclick="salir()" class="booking-button">
                        FINALIZAR
                    </button>
                </div>

            </div>
            `

            $("#habitacionesDisponibles").html(html)
        },

        error: function(){

            $("#loadingOverlay").hide()

            $("#modalTitulo").text("Error ❌")
            $("#modalMensaje").text("Ocurrió un problema al guardar la reserva")

            $("#modalResultado").css("display","flex")
        }
    })
})

function salir(){
    window.location.replace("/reservas-tukos")
}

cargarHabitaciones()

</script>

</body>
</html>