// Inicializar AOS
AOS.init({
    duration: 800,
    once: true,
});

// Configuración de Lightbox
lightbox.option({
    resizeDuration: 200,
    wrapAround: true,
    albumLabel: "Imagen %1 de %2",
    fadeDuration: 300,
    imageFadeDuration: 300,
});

// Fechas por defecto
let hoy = new Date();
let manana = new Date(hoy);
manana.setDate(manana.getDate() + 1);

document.getElementById("checkin").value = hoy.toISOString().split("T")[0];
document.getElementById("checkout").value = manana.toISOString().split("T")[0];

// Scroll
function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: "smooth" });
    }
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" });
}

// Reserva de habitación
function reservarHabitacion(nombre, precio) {
    alert(
        "Has seleccionado: " +
            nombre +
            " - $" +
            precio +
            " por noche. Pronto podrás completar tu reserva.",
    );
}

// Solicitar cotización
let salonActual = "";

function solicitarCotizacion(salon) {
    salonActual = salon;
    document.getElementById("cotizacionModal").classList.add("active");
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove("active");
}

function enviarCotizacion() {
    alert(
        "Solicitud enviada para " +
            salonActual +
            ". Nos pondremos en contacto contigo pronto.",
    );
    closeModal("cotizacionModal");
}

// Restaurante
function verMenu() {
    alert("Descargando menú PDF...");
}

function reservarMesa() {
    alert("Funcionalidad de reserva de mesa - Próximamente");
}

// Contacto
function enviarMensaje() {
    const nombre = document.getElementById("contactoNombre").value;
    if (!nombre) {
        alert("Por favor ingresa tu nombre");
        return;
    }
    alert("Mensaje enviado. Te responderemos a la brevedad.");
}

// Redes sociales
function openSocial(social) {
    const urls = {
        instagram: "https://instagram.com/tukos",
        facebook: "https://facebook.com/tukos",
        twitter: "https://twitter.com/tukos",
    };
    window.open(urls[social], "_blank");
}

// Cerrar modal con Escape
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        document.querySelectorAll(".modal.active").forEach((modal) => {
            modal.classList.remove("active");
        });
    }
});

/*CARUSEL HEADER*/
let slides = document.querySelectorAll(".slide");
let index = 0;

setInterval(() => {
    slides[index].classList.remove("active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
}, 4000); // cambia cada 4 segundos
/*FIN CARUSEL HEADER*/

/*card habitaicones */
document.querySelectorAll(".acceso-slider").forEach((slider) => {
    let images = slider.querySelectorAll(".acceso-img");
    let index = 0;

    setInterval(() => {
        images[index].classList.remove("active");
        index = (index + 1) % images.length;
        images[index].classList.add("active");
    }, 3000); // cambia cada 3 segundos
});
/*fin card habitaciones */

/*habitaciones */
const serviciosHTML = `
    <span class="servicio-tag"><i class="fas fa-wifi"></i> WiFi</span>
    <span class="servicio-tag"><i class="fas fa-tv"></i> TV Cable</span>
    <span class="servicio-tag"><i class="fas fa-shower"></i> Ducha</span>
    <span class="servicio-tag"><i class="fas fa-fire"></i> Calefacción</span>
    <span class="servicio-tag"><i class="fas fa-bath"></i> Baño Privado</span>
    <span class="servicio-tag"><i class="fas fa-utensils"></i> Desayuno Buffet</span>
`;

document.querySelectorAll(".habitacion-servicios").forEach((el) => {
    el.innerHTML = serviciosHTML;
});
/*fin habitaciones */
function irABooking() {
    const booking = document.getElementById("booking");

    if (!booking) return;

    const offset = -100; // ajusta según tu header
    const top =
        booking.getBoundingClientRect().top + window.pageYOffset + offset;

    window.scrollTo({
        top: top,
        behavior: "smooth",
    });
}
/*reservas */
function buscarHabitaciones() {
    let checkin = document.getElementById("checkin").value;
    let checkout = document.getElementById("checkout").value;
    let personas = document.getElementById("personas").value;

    if (!checkin || !checkout) {
        alert("Selecciona fechas");
        return;
    }

    let url = `/buscar?checkin=${checkin}&checkout=${checkout}&personas=${personas}`;

    // 🔥 ABRE EN OTRA PESTAÑA
    window.open(url, "_blank");
}
/*fin reservas */
