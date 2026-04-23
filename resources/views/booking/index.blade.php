<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUKO'S LA CASA REAL | Hotel Boutique</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="{{ asset('utilidades/css/booking.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo" onclick="scrollToTop()">
                TUKO'S <span>La Casa Real</span>
            </div>
            <nav class="nav">
                <a onclick="scrollToSection('inicio')">INICIO</a>
                <a onclick="scrollToSection('habitaciones')">HABITACIONES</a>
                <a onclick="scrollToSection('salones')">SALONES</a>
                <a onclick="scrollToSection('restaurante')">RESTAURANTE</a>
                <a onclick="scrollToSection('galeria')">GALERÍA</a>
                <a onclick="scrollToSection('nosotros')">NOSOTROS</a>
                <a onclick="scrollToSection('contacto')">CONTACTO</a>
                <a onclick="scrollToSection('habitaciones')" class="btn-reserva">RESERVAR</a>
            </nav>
        </div>
    </header>

    <!-- INICIO / HOME -->
    <section class="hero">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('/booking/fachada.jpg');"></div>
            <div class="slide" style="background-image: url('/booking/patio.jpg');"></div>
            <div class="slide" style="background-image: url('/booking/terraza.jpg');"></div>
        </div>

        <div class="hero-content">
            <p class="hero-subtitle">BIENVENIDO</p>
            <h1 class="hero-title">TUKO'S <span>La Casa Real</span></h1>
            <p class="hero-description">Disfruta una experiencia única</p>
        </div>
    </section>

    <!-- Buscador de Reservas -->
    <div class="booking-wrapper" id="booking">
        <div class="booking-bar">
            <div class="booking-item">
                <div class="booking-label">ENTRADA</div>
                <input type="date" id="checkin" class="booking-input">
            </div>
            <div class="booking-item">
                <div class="booking-label">SALIDA</div>
                <input type="date" id="checkout" class="booking-input">
            </div>
            <div class="booking-item">
                <div class="booking-label">PERSONAS</div>
                <select id="personas" class="booking-input">
                    <option value="1">1 Persona</option>
                    <option value="2" selected>2 Personas</option>
                    <option value="3">3 Personas</option>
                    <option value="4">4 Personas</option>
                    <option value="5">5+ Personas</option>
                </select>
            </div>
            <button type="button" class="booking-button" onclick="buscarHabitaciones()">
                RESERVAR AHORA
            </button>
        </div>
    </div>

    <!-- Resumen del Hotel + Beneficios -->
    <div class="section">
        <div class="container">
            <div class="section-title">
                <h2>Tu Hogar Lejos de Casa</h2>
                <p>Más de 25 años brindando la mejor hospitalidad en el corazón de la ciudad</p>
            </div>

            <div class="beneficios-grid">
                <div class="beneficio-item" data-aos="fade-up">
                    <div class="beneficio-icon"><i class="fas fa-wifi"></i></div>
                    <h4>WiFi</h4>
                    <p>Conexión de alta velocidad en todo el hotel</p>
                </div>
                <div class="beneficio-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="beneficio-icon"><i class="fas fa-coffee"></i></div>
                    <h4>Desayuno Incluido</h4>
                    <p>Buffet gourmet todas las mañanas</p>
                </div>
                <div class="beneficio-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="beneficio-icon"><i class="fas fa-parking"></i></div>
                    <h4>Parqueo Privado</h4>
                    <p>Estacionamiento cubierto y vigilado</p>
                </div>
                <div class="beneficio-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="beneficio-icon"><i class="fas fa-clock"></i></div>
                    <h4>Recepción 24/7</h4>
                    <p>Siempre listos para ayudarte</p>
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="accesos-grid">
                <div class="acceso-card" onclick="scrollToSection('habitaciones')">
                    <div class="acceso-card" onclick="scrollToSection('habitaciones')">
                        <div class="acceso-slider">
                            <img src="{{ asset('booking/habitacion.jpg') }}" class="acceso-img active">
                            <img src="{{ asset('booking/habitacion2.jpg') }}" class="acceso-img">
                            <img src="{{ asset('booking/habitacion1.jpg') }}" class="acceso-img">
                        </div>
                        <div class="acceso-overlay">
                            <h3>Habitaciones</h3>
                            <p>Espacios únicos</p>
                        </div>
                    </div>
                    <div class="acceso-overlay">
                        <h3>Habitaciones</h3>
                        <p>espacios únicos</p>
                    </div>
                </div>
                <div class="acceso-card" onclick="scrollToSection('salones')">
                    <div class="acceso-slider">
                        <img src="{{ asset('booking/salon.jpg') }}" class="acceso-img active">
                        <img src="{{ asset('booking/salon1.jpg') }}" class="acceso-img">
                        <img src="{{ asset('booking/salon2.jpg') }}" class="acceso-img">
                    </div>
                    <div class="acceso-overlay">
                        <h3>Salones</h3>
                        <p>Eventos y reuniones</p>
                    </div>
                </div>
                <div class="acceso-card" onclick="scrollToSection('restaurante')">
                    <div class="acceso-slider">
                        <img src="{{ asset('booking/restaurante.jpeg') }}" class="acceso-img active">
                        <img src="{{ asset('booking/restaurante1.jpg') }}" class="acceso-img">
                        <img src="{{ asset('booking/restaurante3.jpg') }}" class="acceso-img">
                    </div>
                    <div class="acceso-overlay">
                        <h3>Restaurante</h3>
                        <p>Cocina de autor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HABITACIONES -->
    <section id="habitaciones" class="section" style="background: var(--color-primario);">
        <div class="container">
            <div class="section-title">
                <h2>Nuestras Habitaciones</h2>
                <p>Diseñadas para tu descanso y confort</p>
            </div>

            <div class="habitaciones-grid">
                <!-- Habitación Simple -->
                <div class="habitacion-card" data-aos="fade-up">
                    <div class="habitacion-img" style="background-image: url('{{ asset('booking/habitacion2.jpg') }}');">
                        <div class="habitacion-badge">180 Bs.</div>
                    </div>
                    <div class="habitacion-content">
                        <h3 class="habitacion-nombre">Habitación Simple</h3>
                        <div class="habitacion-precio">180 Bs. <small>/noche</small></div>
                        <p class="habitacion-descripcion">Ideal para viajeros individuales que buscan comodidad y tranquilidad en un espacio acogedor.</p>
                        <div class="habitacion-capacidad">
                            <i class="fas fa-user"></i> 1 Persona
                        </div>
                        <div class="habitacion-servicios">
                            <span class="servicio-tag"><i class="fas fa-wifi"></i> WiFi</span>
                            <span class="servicio-tag"><i class="fas fa-tv"></i> TV</span>
                            <span class="servicio-tag"><i class="fas fa-shower"></i> Baño</span>
                            <span class="servicio-tag"><i class="fas fa-snowflake"></i> A/C</span>
                        </div>
                        <button type="button" class="booking-button" style="width: 100%;" onclick="irABooking()">RESERVAR</button>
                    </div>
                </div>

                <!-- Habitación Matrimonial -->
                <div class="habitacion-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="habitacion-img" style="background-image: url('{{ asset('booking/habitacionMatrimonial.jpg') }}');">
                        <div class="habitacion-badge">280 Bs.</div>
                    </div>
                    <div class="habitacion-content">
                        <h3 class="habitacion-nombre">Habitación Matrimonial</h3>
                        <div class="habitacion-precio">280 Bs. <small>/noche</small></div>
                        <p class="habitacion-descripcion">Diseñada para parejas, ofrece un ambiente íntimo y confortable para una estancia placentera.</p>
                        <div class="habitacion-capacidad">
                            <i class="fas fa-users"></i> 2 Personas
                        </div>
                        <div class="habitacion-servicios">
                            <span class="servicio-tag"><i class="fas fa-wifi"></i> WiFi</span>
                            <span class="servicio-tag"><i class="fas fa-tv"></i> TV Cable</span>
                            <span class="servicio-tag"><i class="fas fa-shower"></i> Ducha</span>
                            <span class="servicio-tag"><i class="fas fa-fire"></i> Calefacción</span>
                            <span class="servicio-tag"><i class="fas fa-bath"></i> Baño Privado</span>
                            <span class="servicio-tag"><i class="fas fa-utensils"></i> Desayuno Buffet</span>
                        </div>
                        <button type="button" class="booking-button" style="width: 100%;" onclick="irABooking()">RESERVAR</button>
                    </div>
                </div>

                <!-- Habitación Doble -->
                <div class="habitacion-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="habitacion-img" style="background-image: url('{{ asset('booking/habitacionDoble.jpg') }}');">
                        <div class="habitacion-badge">280 Bs.</div>
                    </div>
                    <div class="habitacion-content">
                        <h3 class="habitacion-nombre">Habitación Doble</h3>
                        <div class="habitacion-precio">280 Bs.<small>/noche</small></div>
                        <p class="habitacion-descripcion">Perfecta para compartir, con el equilibrio ideal entre confort y funcionalidad para dos personas.</p>
                        <div class="habitacion-capacidad">
                            <i class="fas fa-users"></i> 2 Personas
                        </div>
                        <div class="habitacion-servicios">
                            <span class="servicio-tag"><i class="fas fa-wifi"></i> WiFi</span>
                            <span class="servicio-tag"><i class="fas fa-tv"></i> TV Cable</span>
                            <span class="servicio-tag"><i class="fas fa-shower"></i> Ducha</span>
                            <span class="servicio-tag"><i class="fas fa-fire"></i> Calefacción</span>
                            <span class="servicio-tag"><i class="fas fa-bath"></i> Baño Privado</span>
                            <span class="servicio-tag"><i class="fas fa-utensils"></i> Desayuno Buffet</span>
                        </div>
                        <button type="button" class="booking-button" style="width: 100%;" onclick="irABooking()">RESERVAR</button>
                    </div>
                </div>
                
                <!-- Habitación Triple -->
                <div class="habitacion-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="habitacion-img" style="background-image: url('{{ asset('booking/habitacionTriple.jpg') }}');">
                        <div class="habitacion-badge">380 Bs.</div>
                    </div>
                    <div class="habitacion-content">
                        <h3 class="habitacion-nombre">Habitación Triple</h3>
                        <div class="habitacion-precio">380 Bs. <small>/noche</small></div>
                        <p class="habitacion-descripcion">Espaciosa y versátil, ideal para grupos o familias que buscan comodidad sin perder estilo.</p>
                        <div class="habitacion-capacidad">
                            <i class="fas fa-users"></i> 3 Personas
                        </div>
                        <div class="habitacion-servicios">
                            <span class="servicio-tag"><i class="fas fa-wifi"></i> WiFi</span>
                            <span class="servicio-tag"><i class="fas fa-tv"></i> TV Cable</span>
                            <span class="servicio-tag"><i class="fas fa-shower"></i> Ducha</span>
                            <span class="servicio-tag"><i class="fas fa-fire"></i> Calefacción</span>
                            <span class="servicio-tag"><i class="fas fa-bath"></i> Baño Privado</span>
                            <span class="servicio-tag"><i class="fas fa-utensils"></i> Desayuno Buffet</span>
                        </div>
                        <button type="button" class="booking-button" style="width: 100%;" onclick="irABooking()">RESERVAR</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SALONES / EVENTOS -->
    <section id="salones" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Salones para Eventos</h2>
                <p>El espacio perfecto para tus celebraciones</p>
            </div>

            <div class="salones-grid">
                <!-- Salón Real -->
                <div class="salon-card" data-aos="fade-right">
                    <div class="salon-img" style="background-image: url('{{ asset('booking/salon2.jpg') }}');"></div>
                    <div class="salon-content">
                        <h3 class="salon-nombre">Salón Grande</h3>
                        <div class="salon-capacidad"><i class="fas fa-users"></i> Hasta 150 personas</div>
                        <p>Ideal para conferencias y grandes celebraciones.</p>
                        <div class="salon-equipamiento">
                            <span class="servicio-tag">Proyector</span>
                            <span class="servicio-tag">Pizarrón</span>
                            <span class="servicio-tag">Sonido</span>
                            <span class="servicio-tag">WiFi</span>
                            <span class="servicio-tag">Catering</span>
                        </div>
                        <button class="btn-secundario" style="width: 100%; margin-top: 20px;" onclick="solicitarCotizacion('Salón Real')">
                            SOLICITAR COTIZACIÓN
                        </button>
                    </div>
                </div>

                <!-- Salón Colonial -->
                <div class="salon-card" data-aos="fade-left">
                    <div class="salon-img" style="background-image: url('{{ asset('booking/salon.jpg') }}');"></div>
                    <div class="salon-content">
                        <h3 class="salon-nombre">Salón Pequeño</h3>
                        <div class="salon-capacidad"><i class="fas fa-users"></i> Hasta 50 personas</div>
                        <p>Perfecto para reuniones ejecutivas, cursos y eventos empresariales. Ambiente íntimo y profesional.</p>
                        <div class="salon-equipamiento">
                            <span class="servicio-tag">Proyector</span>
                            <span class="servicio-tag">Pizarrón</span>
                            <span class="servicio-tag">Sonido</span>
                            <span class="servicio-tag">WiFi</span>
                            <span class="servicio-tag">Catering</span>
                        </div>
                        <button class="btn-secundario" style="width: 100%; margin-top: 20px;" onclick="solicitarCotizacion('Salón Colonial')">
                            SOLICITAR COTIZACIÓN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GALERÍA DE FOTOS -->
    <section id="galeria" class="galeria-section">
        <div class="container">
            <div class="section-title">
                <h2>Galería de Fotos</h2>
                <p>Descubre todos los espacios de Tuko's La Casa Real</p>
            </div>

            <div class="galeria-grid">
                <!-- Habitaciones -->
                <div class="galeria-item" data-aos="zoom-in">
                    <span class="galeria-categoria">Habitaciones</span>
                    <a href="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Habitación Matrimonial - Tuko's La Casa Real">
                        <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Habitación Matrimonial">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="100">
                    <span class="galeria-categoria">Suite</span>
                    <a href="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Suite Real - Tuko's La Casa Real">
                        <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Suite Real">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="200">
                    <span class="galeria-categoria">Baño</span>
                    <a href="https://images.unsplash.com/photo-1552321554-5f0ce5dfdbab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Baño de Lujo - Tuko's La Casa Real">
                        <img src="https://images.unsplash.com/photo-1552321554-5f0ce5dfdbab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Baño">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <!-- Salones -->
                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="300">
                    <span class="galeria-categoria">Salones</span>
                    <a href="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Salón Real - Eventos">
                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Salón Real">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="400">
                    <span class="galeria-categoria">Salones</span>
                    <a href="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Salón Colonial - Reuniones">
                        <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Salón Colonial">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <!-- Restaurante -->
                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="500">
                    <span class="galeria-categoria">Restaurante</span>
                    <a href="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Restaurante La Real">
                        <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Restaurante">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="600">
                    <span class="galeria-categoria">Comida</span>
                    <a href="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Platillo de Autor">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Platillo">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <!-- Áreas comunes -->
                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="700">
                    <span class="galeria-categoria">Lobby</span>
                    <a href="https://images.unsplash.com/photo-1540541338287-41700207dee6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Lobby Principal">
                        <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Lobby">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="800">
                    <span class="galeria-categoria">Terraza</span>
                    <a href="https://images.unsplash.com/photo-1560185007-c5ca9d2c045d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Terraza Colonial">
                        <img src="https://images.unsplash.com/photo-1560185007-c5ca9d2c045d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Terraza">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>

                <div class="galeria-item" data-aos="zoom-in" data-aos-delay="900">
                    <span class="galeria-categoria">Jardín</span>
                    <a href="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" data-lightbox="galeria" data-title="Jardín Secreto">
                        <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="Jardín">
                        <div class="galeria-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SOBRE NOSOTROS -->
    <section id="nosotros" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Sobre Nosotros</h2>
                <p>Más de 25 años de historia</p>
            </div>

            <div class="nosotros-grid">
                <div class="nosotros-historia">
                    <h3>Nuestra Historia</h3>
                    <p>Fundado en 1995, Tuko's La Casa Real nació del sueño de una familia de crear un espacio donde los viajeros se sintieran como en casa. Lo que comenzó como una pequeña casa familiar, hoy es uno de los hoteles boutique más reconocidos de la ciudad.</p>
                    
                    <div class="nosotros-mision">
                        <h4 style="color: var(--color-secundario);">Misión</h4>
                        <p>Brindar experiencias únicas a nuestros huéspedes a través de un servicio personalizado y atención a los detalles.</p>
                    </div>
                    
                    <div class="nosotros-mision">
                        <h4 style="color: var(--color-secundario);">Visión</h4>
                        <p>Ser el hotel boutique de referencia en la región, reconocido por nuestra calidez y excelencia en el servicio.</p>
                    </div>
                </div>

                <div class="mapa-container">
                    <iframe 
                        src="https://www.google.com/maps?q=-19.588602,-65.750275&hl=es&z=17&output=embed"
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACTO -->
    <section id="contacto" class="section" style="background: var(--color-primario);">
        <div class="container">
            <div class="section-title">
                <h2>Contacto</h2>
                <p>Estamos aquí para ayudarte</p>
            </div>

            <div class="contacto-grid">
                <div class="contacto-info">
                    <div class="contacto-item">
                        <div class="contacto-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <h4>Teléfono</h4>
                            <p>26230689</p>
                        </div>
                    </div>

                    <div class="contacto-item">
                        <div class="contacto-icon"><i class="fab fa-whatsapp"></i></div>
                        <div>
                            <h4>WhatsApp</h4>
                            <p>+591 64367150</p>
                        </div>
                    </div>

                    <div class="contacto-item">
                        <div class="contacto-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h4>Email</h4>
                            <p>reservas@tukos.com</p>
                        </div>
                    </div>

                    <div class="contacto-item">
                        <div class="contacto-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h4>Dirección</h4>
                            <p>Calle Hoyos #29</p>
                        </div>
                    </div>
                </div>

                <div class="contacto-form">
                    <h3 style="color: var(--color-blanco); margin-bottom: 20px;">Envíanos un mensaje</h3>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Tu nombre" id="contactoNombre">
                    </div>
                    
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Tu email" id="contactoEmail">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Asunto" id="contactoAsunto">
                    </div>
                    
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Tu mensaje" id="contactoMensaje"></textarea>
                    </div>
                    
                    <button class="booking-button" style="width: 100%;" onclick="enviarMensaje()">
                        ENVIAR MENSAJE
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div>
                    <h4>TUKO'S</h4>
                    <p>La Casa Real<br>Desde 1995</p>
                    <div class="social-links">
                        <a onclick="openSocial('instagram')"><i class="fab fa-instagram"></i></a>
                        <a onclick="openSocial('facebook')"><i class="fab fa-facebook-f"></i></a>
                        <a onclick="openSocial('twitter')"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4>ENLACES</h4>
                    <p><a onclick="scrollToSection('inicio')">Inicio</a></p>
                    <p><a onclick="scrollToSection('habitaciones')">Habitaciones</a></p>
                    <p><a onclick="scrollToSection('salones')">Salones</a></p>
                    <p><a onclick="scrollToSection('restaurante')">Restaurante</a></p>
                    <p><a onclick="scrollToSection('galeria')">Galería</a></p>
                </div>
                
                <div>
                    <h4>CONTACTO</h4>
                    <p><i class="fas fa-phone"></i> 26230689</p>
                    <p><i class="fas fa-envelope"></i> info@tukos.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Calle Hoyos #29</p>
                </div>
                
                <div>
                    <h4>HORARIO</h4>
                    <p>Recepción: 24/7</p>
                    <p>Restaurante: 12am - 14pm</p>
                </div>
            </div>
            
            <div class="copyright">
                © 2025 TUKO'S LA CASA REAL. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="{{ asset('utilidades/js/booking.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>