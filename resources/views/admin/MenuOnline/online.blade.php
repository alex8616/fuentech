<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú | Tuko's</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        header {
            width: 100%;
            height: 200px;
            background-image: url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        header .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        header img {
            height: 80px;
            margin-bottom: 10px;
        }
        .tabs {
            display: flex;
            width: 100%;
            background-color: white;
            border-bottom: 2px solid #ccc;
            margin-bottom: 30px;
        }
        .tabs button {
            flex: 1;
            padding: 16px;
            border: none;
            background: none;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            color: #1f2937;
            border-bottom: 4px solid transparent;
            transition: all 0.3s ease;
        }
        .tabs button.active {
            color: #1d4ed8;
            border-bottom: 4px solid #1d4ed8;
            background-color: #f0f4ff;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        section {
            margin-bottom: 40px;
        }
        section h2 {
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 16px;
            text-align: center;
        }
        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .card h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .card p {
            font-size: 14px;
            color: #555;
        }
        .price {
            color: #1d4ed8;
            font-weight: bold;
            margin-top: 8px;
        }
        footer {
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            padding: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="overlay">
            <img src="/imagenes/hostal/logo.png" alt="Logo Tuko's">
            <h1>Menú Especial - Día de la Madre</h1>
            <p>12 de Mayo de 2025</p>
        </div>
    </header>

    <main class="container">
        <!-- Tabs -->
        <div class="tabs">
            <button onclick="openTab('restaurante')" id="tab-restaurante" class="active">RESTAURANTE</button>
            <button onclick="openTab('bar')" id="tab-bar">BAR</button>
            <button onclick="openTab('promocion')" id="tab-promocion">PROMOCIÓN DEL DÍA</button>
        </div>

        <div id="restaurante" class="tab-content">
            <div id="menu-categorias-restaurante"></div>
        </div>

        <div id="bar" class="tab-content" style="display:none;">
            <div id="menu-categorias-bar"></div>
        </div>

        <div id="promocion" class="tab-content" style="display:none;">
            <div id="menu-categorias-promocion"></div>
        </div>

    </main>


    <footer>
        &copy; 2025 Tuko's - Todos los derechos reservados
    </footer>

    <script>
        function openTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';

            document.getElementById('tab-restaurante').classList.remove('active');
            document.getElementById('tab-bar').classList.remove('active');
            document.getElementById('tab-promocion').classList.remove('active');

            document.getElementById('tab-' + tabId).classList.add('active');
        }

        document.addEventListener("DOMContentLoaded", function () {
            fetch('/api/get-categoria-menu-online')
                .then(res => res.json())
                .then(data => renderCategorias(data))
                .catch(err => console.error('Error al cargar el menú:', err));
        });

        function renderCategorias(categorias) {
            const contenedorRestaurante = document.getElementById("menu-categorias-restaurante");
            const contenedorBar = document.getElementById("menu-categorias-bar");
            const contenedorPromocion = document.getElementById('menu-categorias-promocion');

            contenedorRestaurante.innerHTML = '';
            contenedorBar.innerHTML = '';
            contenedorPromocion.innerHTML = '';

            categorias.forEach(categoria => {
                let contenidoCategoria = '';

                const esParaMayores = categoria.mayordeedad === "true";
                const esPromocionDiaria = categoria.promosionesdiarias === "true";

                // Productos
                if (categoria.productos && categoria.productos.length) {
                    contenidoCategoria += `<section>
                        <h2>${categoria.Nombre_categoria}</h2>
                        <div class="grid">`;

                    categoria.productos.forEach(producto => {
                        contenidoCategoria += esPromocionDiaria 
                            ? renderProductoPromocion(producto) 
                            : renderProducto(producto);
                    });

                    contenidoCategoria += `</div></section>`;
                }

                // Subcategorías
                if (categoria.subcategorias && categoria.subcategorias.length) {
                    categoria.subcategorias.forEach(sub => {
                        if (sub.productos && sub.productos.length) {
                            contenidoCategoria += `<section>
                                <h3>${sub.Nombre_subcategoria}</h3>
                                <div class="grid">`;

                            sub.productos.forEach(producto => {
                                contenidoCategoria += esPromocionDiaria 
                                    ? renderProductoPromocion(producto) 
                                    : renderProducto(producto);
                            });

                            contenidoCategoria += `</div></section>`;
                        }
                    });
                }

                if (esPromocionDiaria) {
                    contenedorPromocion.innerHTML += contenidoCategoria;
                } else if (esParaMayores) {
                    contenedorBar.innerHTML += contenidoCategoria;
                } else {
                    contenedorRestaurante.innerHTML += contenidoCategoria;
                }
            });
        }

        const misvg = `
            <svg fill="#000000" width="99px" height="99px" viewBox="-11.2 -11.2 54.40 54.40" xmlns="http://www.w3.org/2000/svg"><path d="M30,3.4141,28.5859,2,2,28.5859,3.4141,30l2-2H26a2.0027,2.0027,0,0,0,2-2V5.4141ZM26,26H7.4141l7.7929-7.793,2.3788,2.3787a2,2,0,0,0,2.8284,0L22,19l4,3.9973Zm0-5.8318-2.5858-2.5859a2,2,0,0,0-2.8284,0L19,19.1682l-2.377-2.3771L26,7.4141Z"></path><path d="M6,22V19l5-4.9966,1.3733,1.3733,1.4159-1.416-1.375-1.375a2,2,0,0,0-2.8284,0L6,16.1716V6H22V4H6A2.002,2.002,0,0,0,4,6V22Z"></path></svg>
        `;

        function renderProducto(producto) {
            return `
                <div class="card" style="display: flex; align-items: center; gap: 1rem;">
                    <div style="flex: 0 0 40%; height: 100px;">
                        ${producto.ImagenProducto 
                            ? `<img src="${producto.ImagenProducto}" alt="${producto.NombreProducto}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">`
                            : `<div style="width: 100%; height: 100%;">${misvg}</div>`
                        }
                    </div>

                    <div style="flex: 1;">
                        <h3 style="margin: 0 0 0.5rem 0;">${producto.NombreProducto}</h3>
                        <p style="margin: 0 0 0.5rem 0;">${producto.DescripcionProducto ?? ''}</p>
                        <div class="price" style="font-weight: bold;">Bs ${parseFloat(producto.PrecioProducto).toFixed(2)}</div>
                    </div>
                </div>
            `;
        }

        function renderProductoPromocion(producto) {
            return `
                <div class="promo-card" style="position: relative; background: #fff; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.08); padding: 1rem; margin-bottom: 1.5rem;">
                    <span style="position: absolute; top: -10px; left: -10px; background: #ff4d4f; color: white; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: bold; border-radius: 4px;">
                        PROMO
                    </span>
                    
                    <div style="display: flex; gap: 1rem;">
                        <div style="flex: 0 0 35%; height: 100px;">
                            ${producto.ImagenProducto 
                                ? `<img src="${producto.ImagenProducto}" alt="${producto.NombreProducto}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">`
                                : `<div style="width: 100%; height: 100%;">${misvg}</div>`
                            }
                        </div>
                        <div style="flex: 1;">
                            <h3 style="margin: 0 0 0.25rem 0;">${producto.NombreProducto}</h3>
                            <p style="margin: 0 0 0.5rem 0; color: #666;">
                                ${producto.DescripcionProducto ?? 'Promoción especial limitada'}
                            </p>
                        </div>
                    </div>

                    <!-- Precio en etiqueta roja en la esquina inferior derecha -->
                    <span style="position: absolute; bottom: -10px; right: -10px; background: #ff4d4f; color: white; padding: 0.35rem 0.75rem; font-size: 0.95rem; font-weight: bold; border-radius: 4px;">
                        Bs ${parseFloat(producto.PrecioProducto).toFixed(2)}
                    </span>
                </div>
            `;
        }


    </script>



</body>
</html>
