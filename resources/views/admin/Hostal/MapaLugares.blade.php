<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mapa con lista de lugares y rutas</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    #map {
      height: 100vh;
      width: 100%;
    }
    .place-item {
      cursor: pointer;
      margin: 10px 0;
      padding: 10px;
      background-color: #FCFAEE;
      border-radius: 5px;
    }
    .place-item:hover {
      background-color: #FFEEAD;
    }
    #details {
      display: none;
    }
  </style>
</head>
<body>

  <div class="container-fluid h-100">
    <div class="row h-100">
      <div class="col-md-4" id="sidebar">
        <div id="place-list" style="background: white; padding: 15px; margin: 15px"></div>
        <div id="details">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <a href="#tabs-settings-2" class="nav-link" title="Settings" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab" id="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M5 12l14 0" />
                  <path d="M5 12l6 6" />
                  <path d="M5 12l6 -6" />
                </svg>
              </a>
              <h5 id="place-name" class="text-center flex-grow-1">Tu Texto Aquí</h5>
            </div>
            <div class="card-body">
              <div class="tab-content">                
                <p id="place-description"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8" id="map"></div>
    </div>
  </div>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
  <script>
    const map = L.map('map').setView([-19.588564224458995, -65.75027835998486], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const staticMarker = L.marker([-19.588564224458995, -65.75027835998486], {
      icon: L.icon({
        iconUrl: '/imagenes/hostal/home2.png',
        iconSize: [30, 30],
        iconAnchor: [15, 30]
      })
    }).addTo(map).bindPopup('<b>HOSTAL TUKOS LA CASA REAL</b>');

    const routingControl = L.Routing.control({
      waypoints: [],
      routeWhileDragging: true,
      show: false,
      createMarker: function() { return null; }
    }).addTo(map);

    async function cargarLugares() {
      const response = await fetch('/apihostal/get-lugares');
      const lugares = await response.json();

      lugares.forEach((lugar) => {
        const coords = lugar.UbicacionLugar.split(', ').map(Number);
        const marker = L.marker(coords).addTo(map)
          .bindPopup(`<span>${lugar.NombreLugar}</span>`);

        const placeItem = document.createElement('div');
        placeItem.className = 'place-item';
        placeItem.textContent = lugar.NombreLugar;
        placeItem.addEventListener('click', () => {
          mostrarDetalles(lugar, coords, marker);
        });
        document.getElementById('place-list').appendChild(placeItem);
      });
    }

    function mostrarDetalles(lugar, coords, marker) {
        map.setView(coords, 16);
        marker.openPopup();
        routingControl.setWaypoints([
            L.latLng(-19.588564224458995, -65.75027835998486), // Ubicación principal
            L.latLng(coords) // Ubicación del lugar seleccionado
        ]);

        document.getElementById('place-name').textContent = lugar.NombreLugar;
        document.getElementById('place-description').innerHTML = lugar.Detalle || 'Detalle no disponible';

        document.getElementById('place-list').style.display = 'none';
        document.getElementById('details').style.display = 'block';
    }

    document.getElementById('back-button').addEventListener('click', () => {
      document.getElementById('details').style.display = 'none';
      document.getElementById('place-list').style.display = 'block';
      routingControl.setWaypoints([]);
    });

    cargarLugares();
  </script>

</body>
</html>
