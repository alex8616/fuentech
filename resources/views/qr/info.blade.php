<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukos - Restaurante La Casa Real</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --azul-claro: #5CD7F2;
            --turquesa: #05F2DB;
            --naranja: #F25C05;
            --rojo: #A60303;
            --negro: #0D0D0D;
            --gris-claro: #f5f5f5;
            --gris-medio: #e0e0e0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, var(--negro) 0%, #1a1a1a 100%);
            color: var(--gris-claro);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            max-width: 1200px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        
        header {
            text-align: center;
            margin-bottom: 10px;
            padding: 30px 20px;
            border-radius: 20px;
            background: rgba(13, 13, 13, 0.8);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(92, 215, 242, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .logo-img {
            height: 240px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 5px 15px rgba(5, 242, 219, 0.3));
            transition: transform 0.3s ease;
            border-radius: 15px;
        }
        
        .logo-img:hover {
            transform: scale(1.05);
        }
        
        .logo-text {
            font-size: 3.2rem;
            font-weight: 800;
            background: linear-gradient(to right, var(--azul-claro), var(--turquesa));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 2px;
            text-shadow: 0 2px 10px rgba(5, 242, 219, 0.2);
            margin-top: 10px;
        }
        
        .tagline {
            font-size: 1.6rem;
            color: var(--naranja);
            font-weight: 600;
            margin-top: 10px;
            padding: 12px 25px;
            border-radius: 10px;
            background: rgba(242, 92, 5, 0.1);
            border: 1px solid rgba(242, 92, 5, 0.3);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .restaurant-tagline {
            font-size: 1.2rem;
            color: var(--turquesa);
            margin-top: 10px;
            font-style: italic;
        }
        
        .content-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }
        
        .info-section {
            flex: 1;
            min-width: 300px;
            background: rgba(13, 13, 13, 0.8);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(92, 215, 242, 0.2);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        
        .info-section:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4), 0 0 15px rgba(92, 215, 242, 0.1);
        }
        
        .section-title {
            font-size: 1.9rem;
            color: var(--turquesa);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--naranja);
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 80px;
            height: 2px;
            background: var(--turquesa);
        }
        
        .description {
            font-size: 1.15rem;
            color: var(--gris-claro);
            margin-bottom: 25px;
            line-height: 1.7;
        }
        
        .highlight {
            color: var(--naranja);
            font-weight: 600;
        }
        
        .social-section {
            flex: 1;
            min-width: 300px;
            background: rgba(13, 13, 13, 0.8);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(242, 92, 5, 0.2);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        
        .social-section:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4), 0 0 15px rgba(242, 92, 5, 0.1);
        }
        
        .social-links {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }
        
        .social-item {
            display: flex;
            align-items: center;
            padding: 20px 25px;
            border-radius: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            background: rgba(13, 13, 13, 0.9);
            border: 1px solid rgba(92, 215, 242, 0.1);
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }
        
        .social-item:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            border-color: rgba(92, 215, 242, 0.3);
            text-decoration: none;
        }
        
        .social-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .social-item:hover::before {
            width: 100%;
            opacity: 0.1;
        }
        
        .facebook-item::before {
            background: #1877F2;
        }
        
        .instagram-item::before {
            background: #E4405F;
        }
        
        .tiktok-item::before {
            background: #000000;
        }
        
        .whatsapp-item::before {
            background: #25D366;
        }
        
        .phone-item::before {
            background: var(--turquesa);
        }
        
        .social-icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-right: 20px;
            color: white;
            z-index: 1;
            flex-shrink: 0;
        }
        
        .facebook-bg {
            background: linear-gradient(135deg, #1877F2, #3b5998);
        }
        
        .instagram-bg {
            background: linear-gradient(45deg, #E4405F, #F77737, #FCAF45);
        }
        
        .tiktok-bg {
            background: linear-gradient(135deg, #000000, #25F4EE, #FE2C55);
        }
        
        .whatsapp-bg {
            background: linear-gradient(135deg, #25D366, #128C7E);
        }
        
        .phone-bg {
            background: linear-gradient(135deg, var(--turquesa), var(--azul-claro));
        }
        
        .social-text h3 {
            font-size: 1.4rem;
            margin-bottom: 8px;
            color: var(--gris-claro);
            z-index: 1;
        }
        
        .social-text p {
            color: var(--gris-medio);
            font-size: 1rem;
            z-index: 1;
        }
        
        .contact-info {
            margin-top: 30px;
            padding: 20px;
            background: rgba(166, 3, 3, 0.1);
            border-radius: 15px;
            border-left: 4px solid var(--rojo);
        }
        
        .contact-info p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }
        
        .contact-info i {
            color: var(--naranja);
            width: 25px;
            font-size: 1.2rem;
        }
        
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 25px;
            color: var(--gris-medio);
            font-size: 0.95rem;
            border-radius: 15px;
            background: rgba(13, 13, 13, 0.8);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(242, 92, 5, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        footer .highlight {
            color: var(--turquesa);
        }
        
        .footer-logo {
            color: var(--naranja);
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .footer-logo-img {
            height: 40px;
            width: auto;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 5px rgba(5, 242, 219, 0.3));
            border-radius: 8px;
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
            }
            
            .info-section, .social-section {
                min-width: 100%;
                padding: 25px;
            }
            
            .logo-text {
                font-size: 2.5rem;
            }
            
            .logo-img {
                height: 100px;
            }
            
            .tagline {
                font-size: 1.3rem;
                text-align: center;
                padding: 10px 15px;
            }
            
            .restaurant-tagline {
                font-size: 1rem;
                text-align: center;
            }
        }
        
        .hours-info {
            margin-top: 25px;
            padding: 20px;
            background: rgba(5, 242, 219, 0.1);
            border-radius: 15px;
            border-left: 4px solid var(--turquesa);
        }
        
        .hours-info h4 {
            color: var(--turquesa);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .hours-info p {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }
        
        .hours-info .day {
            color: var(--gris-claro);
        }
        
        .hours-info .time {
            color: var(--naranja);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo-container">
                <!-- Aquí se carga tu logo desde la carpeta public/img/ -->
                <img src="/img/Logo.png" alt="Logo de Tukos Restaurante" class="logo-img">
                <div class="restaurant-tagline">Sabor y tradición en cada plato</div>
            </div>
        </header>
        
        <div class="content-wrapper">
            
            <section class="social-section">
                <h2 class="section-title">Conéctate Con Nosotros</h2>
                <p class="description">
                    Síguenos en nuestras redes sociales para mantenerte actualizado con nuestras últimas promociones, nuevos platos y eventos especiales.
                </p>
                
                <div class="social-links">
                    <a href="https://www.facebook.com/share/17jsh76wUS/" target="_blank" class="social-item facebook-item">
                        <div class="social-icon facebook-bg">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="social-text">
                            <h3>Facebook</h3>
                            <p>Síguenos en Facebook para conocer nuestras novedades</p>
                        </div>
                    </a>
                    
                    <a href="https://www.instagram.com/tukos.resto?igsh=MWtmNnk0d2Jod3VwZQ==" target="_blank" class="social-item instagram-item">
                        <div class="social-icon instagram-bg">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <div class="social-text">
                            <h3>Instagram</h3>
                            <p>Descubre nuestros platos en imágenes y videos</p>
                        </div>
                    </a>
                    
                    <a href="https://www.tiktok.com/@tukos_lacasareal?_r=1&_t=ZM-93D42UIhqJP" target="_blank" class="social-item tiktok-item">
                        <div class="social-icon tiktok-bg">
                            <i class="fab fa-tiktok"></i>
                        </div>
                        <div class="social-text">
                            <h3>TikTok</h3>
                            <p>Mira nuestros videos y contenido divertido</p>
                        </div>
                    </a>
                    
                    <a href="https://wa.me/59164367150" target="_blank" class="social-item whatsapp-item">
                        <div class="social-icon whatsapp-bg">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="social-text">
                            <h3>WhatsApp</h3>
                            <p>Reservas y pedidos al +591 64367150</p>
                        </div>
                    </a>
                    
                    <div class="social-item phone-item" onclick="window.location.href='tel:26230689'">
                        <div class="social-icon phone-bg">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="social-text">
                            <h3>Teléfono</h3>
                            <p>Llámanos al 262 - 30689</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> Dirección: Calle Hoyos #29 - Potosi</p>
                    <p><i class="fas fa-envelope"></i> Email: restotukos@gmail.com</p>
                    <p><i class="fas fa-clock"></i> Horario: Domingo a Viernes</p>
                </div>
            </section>
        </div>
        
        <footer>
            <!-- Logo más pequeño en el footer -->
            <img src="/img/Logo.png" alt="Logo de Tukos Restaurante" class="footer-logo-img">
            <p>© 2026 <span class="footer-logo">TUKO'S - La Casa Real</span> | Todos los derechos reservados</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Síguenos en nuestras redes sociales para no perderte nada</p>
        </footer>
    </div>

    <script>
        // Alternativa para logo si no se carga correctamente
        window.addEventListener('load', function() {
            const logoImg = document.querySelector('.logo-img');
            const footerLogoImg = document.querySelector('.footer-logo-img');
            
            // Si el logo no se carga, mostramos un placeholder
            logoImg.onerror = function() {
                this.style.display = 'none';
                const logoContainer = document.querySelector('.logo-container');
                const placeholder = document.createElement('div');
                placeholder.className = 'logo-placeholder';
                placeholder.innerHTML = '<div style="width:120px;height:120px;border-radius:20px;background:linear-gradient(135deg, #F25C05, #A60303);display:flex;align-items:center;justify-content:center;font-size:3rem;color:white;font-weight:bold;box-shadow:0 5px 15px rgba(242,92,5,0.3);">T</div>';
                logoContainer.insertBefore(placeholder, logoContainer.firstChild);
            };
            
            footerLogoImg.onerror = function() {
                this.style.display = 'none';
                const footer = this.parentElement;
                const placeholder = document.createElement('div');
                placeholder.innerHTML = '<div style="width:40px;height:40px;border-radius:8px;background:linear-gradient(135deg, #F25C05, #A60303);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:white;font-weight:bold;margin-bottom:10px;">T</div>';
                footer.insertBefore(placeholder, footer.firstChild);
            };
        });
        
        // Efecto al hacer clic en elementos sociales
        document.querySelectorAll('.social-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Solo animamos si no es un enlace
                if(!this.href) {
                    this.style.transform = 'translateX(8px) scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'translateX(8px)';
                    }, 150);
                }
            });
        });
    </script>
</body>
</html>