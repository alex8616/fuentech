@extends('layouts.my-dashboard-layout')

@section('content')

<style>

    /* =========================
    CALENDAR LAYOUT
    ========================= */

    .calendar-wrapper{
        display:flex;
        border:1px solid #eee;
        margin-bottom:30px;
    }

    .room-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        width:100%;
        padding:12px 20px;
        background:#fafafa;
        border:1px solid #eee;
        font-weight:bold;
    }

    .room-edit-btn{
        background:#4CAF50;
        color:white;
        border:none;
        padding:6px 12px;
        border-radius:4px;
    }

    /* =========================
    BOTON CERRAR
    ========================= */

    .btn-cerrar{
        background:#ff7675;
        border:none;
        color:white;
        padding:4px 6px;
        font-size:12px;
        border-radius:4px;
        cursor:pointer;
    }

    .btn-cerrar:hover{
        background:#d63031;
    }

    /* =========================
    PANEL IZQUIERDO
    ========================= */

    .left-panel{
        width:260px;
        min-width:260px;
        background:white;
        border-right:1px solid #eee;
    }

    .left-row{
        padding:10px;
        border-bottom:1px solid #eee;
    }

    /* =========================
    PANEL DERECHO
    ========================= */

    .right-panel{
        flex:1;
        overflow:auto;
    }

    /* =========================
    FILAS
    ========================= */

    .room-row{
        display:flex;
    }

    .cell{
        width:80px;
        min-width:80px;
        border:1px solid #eee;
        padding:6px;
        text-align:center;
        cursor:pointer;
    }

    .cell input{
        width:60px;
        text-align:center;
    }

    /* =========================
    FECHAS
    ========================= */

    .grid-dates{
        display:flex;
        background:white;
    }

    .grid-date{
        width:80px;
        min-width:80px;
        text-align:center;
        border-left:1px solid #eee;
        padding:8px;
    }

    .today{
        background:#ffeaa7;
    }

    /* =========================
    TOOLBAR
    ========================= */

    .calendar-toolbar{
        display:flex;
        justify-content:center;
        gap:20px;
        margin-bottom:20px;
    }

    /* =========================
    TOAST MENSAJE
    ========================= */
    
    .calendar-toast{
        position:fixed;
        bottom:30px;
        right:30px;

        background:#28a745;
        color:white;

        padding:10px 18px;
        border-radius:6px;

        font-size:14px;

        opacity:0;
        transform:translateY(20px);

        transition:all .3s ease;

        z-index:9999;
    }

    .calendar-toast.show{

        opacity:1;
        transform:translateY(0);

    }

    .btn-cerrar.btn-danger{
        background:#e74c3c;
        color:white;
    }

    .closed-day{
    background:#ffdddd !important;
    }

    button{
    background:white;
    }

    .btn-success{
    background-color:#198754 !important;
    border-color:#198754 !important;
    color:white !important;
    }

    .btn-danger{
    background-color:#dc3545 !important;
    border-color:#dc3545 !important;
    color:white !important;
    }
</style>

<div class="calendar-toolbar">
    <button id="prevMonth">◀</button>
    <h3 id="calendarTitle"></h3>
    <button id="nextMonth">▶</button>
</div>

<div id="roomsContainer"></div>




<div class="offcanvas offcanvas-end" tabindex="-1" id="ModalEditar">
    <div class="offcanvas-header">
        <h4 class="offcanvas-title">Actualizar Datos</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <div class="card-body">
            <div class="accordion" id="accordion-example">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false">
                        ACTUALIZAR PRECIOS
                        </button>
                    </h2>
                    <div id="collapse-2" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                        <div class="accordion-body pt-0">
                            <input type="hidden" id="edit_room_id">
                            <div class="mb-3">
                                <label>Fecha inicio</label>
                                <input type="date" id="fecha_inicio" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Fecha fin</label>
                                <input type="date" id="fecha_fin" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Precio</label>
                                <input type="number" id="precio_masivo" class="form-control">
                            </div>

                            <button id="guardarMasivo" class="btn btn-primary w-100">
                                Actualizar precios
                            </button>
                        </div>
                    </div>
                    </div>
                    <div class="accordion-item">
                    
                    <h2 class="accordion-header" id="heading-3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-3">
                            ACTUALIZAR CANTIDAD
                        </button>
                    </h2>

                    <div id="collapse-3" class="accordion-collapse collapse">

                        <div class="accordion-body pt-0">

                        <input type="hidden" id="edit_room_id_cantidad">

                        <div class="mb-3">
                            <label>Fecha inicio</label>
                            <input type="date" id="fecha_inicio_cantidad" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Fecha fin</label>
                            <input type="date" id="fecha_fin_cantidad" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Cantidad Habitaciones</label>
                            <input type="number" id="cantidad_masiva" class="form-control">
                        </div>

                        <button id="guardarCantidadMasiva" class="btn btn-primary w-100">
                        Actualizar cantidad
                        </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

let currentDate = new Date()
let currentMonth = formatMonth(currentDate)

function formatMonth(date){

    let year = date.getFullYear()
    let month = String(date.getMonth()+1).padStart(2,'0')

    return `${year}-${month}`
}

/* =========================
TOAST MENSAJE
========================= */

function showToast(msg){

    let toast = $(`
        <div class="calendar-toast">${msg}</div>
    `)

    $("body").append(toast)

    setTimeout(function(){
        toast.addClass("show")
    },100)

    setTimeout(function(){
        toast.removeClass("show")

        setTimeout(function(){
            toast.remove()
        },300)

    },2000)
}

/* =========================
PINTAR COLUMNA CERRADA
========================= */

function pintarColumna(room,fecha,cerrar){

    let selector = `.calendar-wrapper[data-room="${room}"] [data-date="${fecha}"]`

    if(cerrar){

        /* solo celdas de esa habitación */
        $(selector).addClass("closed-day")

    }else{

        $(selector).removeClass("closed-day")

    }

}

/* =========================
CARGAR CALENDARIO
========================= */

function loadCalendar(){

    $.ajax({
        url:"/apihostal/admin/calendario-data-info",
        method:"GET",
        data:{ mes:currentMonth },

        success:function(data){

            $("#calendarTitle").text(data.titulo)

            renderRooms(data.rooms || [], data.fechas || [])
        }
    })
}

/* =========================
RENDER HABITACIONES
========================= */

function renderRooms(rooms, fechas){

    let html=""

    rooms.forEach(function(room){

        html+=`

        <div class="room-header">
            <div>${room.nombre}</div>
            <button class="room-edit-btn" data-id="${room.id}" data-bs-toggle="offcanvas" href="#ModalEditar">
                Editar
            </button>
        </div>

        <div class="calendar-wrapper" data-room="${room.id}">

            <div class="left-panel">

                <div class="left-row">Cerrar día</div>
                <div class="left-row">Fechas</div>
                <div class="left-row">Habitaciones</div>
                <div class="left-row">Precio</div>

            </div>

            <div class="right-panel">

                ${renderCerrarRow(room,fechas)}
                ${renderDates(fechas)}
                ${renderHabitacionesRow(room,fechas)}
                ${renderPrecioRow(room,fechas)}

            </div>

        </div>
        `
    })

    $("#roomsContainer").html(html)

    /* 🔴 PINTAR DIAS CERRADOS AL CARGAR */

    rooms.forEach(function(room){

        if(room.cerrados){

            Object.keys(room.cerrados).forEach(function(fecha){

                if(room.cerrados[fecha] == 1){
                    pintarColumna(room.id,fecha,true)
                }

            })

        }

    })

    scrollToToday()
}

/* =========================
BOTON CERRAR
========================= */

function renderCerrarRow(room,fechas){

    let cells=""

    fechas.forEach(function(f){

        let cerrado = room.cerrados?.[f.fecha] ?? 0

        let texto = cerrado ? "Abrir" : "Cerrar"
        let clase = cerrado ? "btn-success" : "btn-danger"

        cells+=`
        <div class="cell" 
             data-date="${f.fecha}"
             data-room="${room.id}">
             
            <button class="btn ${clase} btn-cerrar"
                data-room="${room.id}"
                data-date="${f.fecha}"
                data-cerrado="${cerrado}">
                ${texto}
            </button>
        </div>`
    })

    return `<div class="room-row">${cells}</div>`
}

/* =========================
CERRAR / ABRIR DIA
========================= */

$(document).on("click",".btn-cerrar",function(){

    let btn = $(this)

    let room = btn.data("room")
    let fecha = btn.data("date")
    let cerrado = btn.data("cerrado")

    let nuevoEstado = cerrado == 1 ? 0 : 1

    $.ajax({

        url:"/apihostal/admin/update-cerrar-dia",
        method:"POST",

        data:{
            room_id:room,
            fecha:fecha,
            cerrado:nuevoEstado,
            _token:"{{ csrf_token() }}"
        },

        success:function(){

            if(nuevoEstado == 1){

                btn.text("Abrir")
                btn.data("cerrado",1)

                btn.removeClass("btn-danger")
                btn.addClass("btn-success")

                pintarColumna(room,fecha,true)

            }else{

                btn.text("Cerrar")
                btn.data("cerrado",0)

                btn.removeClass("btn-success")
                btn.addClass("btn-danger")

                pintarColumna(room,fecha,false)

            }

            showToast("✔ Estado actualizado")

        }

    })

})

/* =========================
FILAS FECHAS
========================= */

function renderDates(fechas){

    let html=`<div class="grid-dates">`
    let today = new Date().toISOString().split("T")[0]

    fechas.forEach(function(f){

        let clase = (f.fecha==today) ? "today" : ""

        html+=`
        <div class="grid-date ${clase}" data-date="${f.fecha}">
            <div>${f.dia}</div>
            <small>${f.dia_semana}</small>
        </div>`
    })

    html+=`</div>`

    return html
}

/* =========================
FILAS HABITACIONES
========================= */

function renderHabitacionesRow(room,fechas){

    let cells = ""

    fechas.forEach(function(f){

        let hab = room.habitaciones?.[f.fecha] ?? 0

        cells += `
        <div class="cell editable habitaciones"
            data-room="${room.id}"
            data-date="${f.fecha}"
            data-type="habitaciones">
            ${hab}
        </div>`
    })

    return `<div class="room-row">${cells}</div>`
}

/* =========================
FILAS PRECIO
========================= */

function renderPrecioRow(room,fechas){

    let cells=""

    fechas.forEach(function(f){

        let precio = room.precios?.[f.fecha]

        if(precio === null || precio === undefined){
            precio = 0
        }

        cells+=`
        <div class="cell editable precio"
            data-room="${room.id}"
            data-date="${f.fecha}"
            data-type="precio">
            ${precio}
        </div>`
    })

    return `<div class="room-row">${cells}</div>`
}

/* =========================
DOBLE CLICK EDITAR
========================= */

$(document).on("dblclick",".editable",function(){

    let value = $(this).text().trim()

    let input = `<input type="number" value="${value}" style="width:60px;">`

    $(this).html(input)

    $(this).find("input").focus()
})

/* =========================
GUARDAR VALOR
========================= */

$(document).on("blur",".editable input",function(){

    let input = $(this)

    let value = input.val().trim()

    let cell = input.parent()

    let fecha = cell.attr("data-date")
    let type  = cell.attr("data-type")

    let room = cell.closest(".calendar-wrapper").attr("data-room")

    if(!room){
        console.error("room_id undefined",cell)
        return
    }

    cell.text(value)

    $.ajax({

        url:"/apihostal/admin/update-calendario",
        method:"POST",

        data:{
            room_id:room,
            fecha:fecha,
            campo:type,
            valor:value,
            _token:"{{ csrf_token() }}"
        },

        success:function(){
            showToast("✔ Guardado correctamente")
        }

    })

})

/* =========================
DRAG TIPO EXCEL
========================= */

let dragging=false
let dragValue=null
let dragType=null

$(document).on("mousedown",".editable",function(){

    dragging=true
    dragValue=$(this).text().trim()
    dragType=$(this).attr("data-type")

})

$(document).on("mouseenter",".editable",function(){

    if(!dragging) return

    let cell=$(this)

    if(cell.attr("data-type")!=dragType) return

    let fecha=cell.attr("data-date")
    let room=cell.closest(".calendar-wrapper").attr("data-room")

    cell.text(dragValue)

    $.ajax({

        url:"/apihostal/admin/update-calendario",
        method:"POST",

        data:{
            room_id:room,
            fecha:fecha,
            campo:dragType,
            valor:dragValue,
            _token:"{{ csrf_token() }}"
        }

    })

})

$(document).on("mouseup",function(){
    dragging=false
})

/* =========================
SCROLL HOY
========================= */

function scrollToToday(){

    let todayCell = $(".grid-date.today")

    if(todayCell.length){

        let container = $(".right-panel")

        container.scrollLeft(
            todayCell.position().left + container.scrollLeft() - 200
        )
    }
}

/* =========================
BOTON EDITAR
========================= */

$(document).on("click",".room-edit-btn",function(){

    let room_id = $(this).data("id")

    $("#edit_room_id").val(room_id)
    $("#edit_room_id_cantidad").val(room_id)

})

/* =========================
PRECIO MASIVO
========================= */

$("#guardarMasivo").click(function(){

    let room_id = $("#edit_room_id").val()
    let inicio  = $("#fecha_inicio").val()
    let fin     = $("#fecha_fin").val()
    let precio  = $("#precio_masivo").val()

    if(!inicio || !fin || !precio){
        alert("Completa todos los campos")
        return
    }

    $.ajax({

        url:"/apihostal/admin/update-precio-rango",
        method:"POST",

        data:{
            room_id:room_id,
            fecha_inicio:inicio,
            fecha_fin:fin,
            precio:precio,
            _token:"{{ csrf_token() }}"
        },

        success:function(){

            showToast("✔ Precios actualizados")

            loadCalendar()

        }

    })

})

/* =========================
CANTIDAD MASIVA
========================= */

$("#guardarCantidadMasiva").click(function(){

    let room_id = $("#edit_room_id_cantidad").val()
    let inicio  = $("#fecha_inicio_cantidad").val()
    let fin     = $("#fecha_fin_cantidad").val()
    let cantidad = $("#cantidad_masiva").val()

    if(!inicio || !fin || !cantidad){
        alert("Completa todos los campos")
        return
    }

    $.ajax({

        url:"/apihostal/admin/update-cantidad-rango",
        method:"POST",

        data:{
            room_id:room_id,
            fecha_inicio:inicio,
            fecha_fin:fin,
            cantidad:cantidad,
            _token:"{{ csrf_token() }}"
        },

        success:function(){

            showToast("✔ Cantidades actualizadas")

            loadCalendar()

        }

    })

})

/* =========================
CAMBIAR MES
========================= */

$("#prevMonth").click(function(){

    currentDate.setMonth(currentDate.getMonth()-1)

    currentMonth = formatMonth(currentDate)

    loadCalendar()
})

$("#nextMonth").click(function(){

    currentDate.setMonth(currentDate.getMonth()+1)

    currentMonth = formatMonth(currentDate)

    loadCalendar()
})

$(document).ready(function(){
    loadCalendar()
})

</script>

@endsection

