@extends('layouts.alcira-dashboard')
@section('content')

<div class="col-md-12" style="padding-left: 60px; padding-right: 60px">
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                <li class="nav-item">
                    <a href="#tabs-home-5" class="nav-link active" data-bs-toggle="tab">FORMULARIO REGISTRO</a>
                </li>
                <li class="nav-item">
                    <a href="#tabs-profile-5" class="nav-link" data-bs-toggle="tab">LISTA REGISTRO</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active show" id="tabs-home-5">
                    <div class="row">
                        <div class="col-md-6" id="FormDiv">
                            <form id="envioForm">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="estado_servicio" class="form-label">Estado del servicio</label>
                                        <select name="estado_servicio" id="estado_servicio" class="form-control" required>
                                            <option value="DESAYUNO">DESAYUNO</option>
                                            <option value="ALMUERZO">ALMUERZO</option>
                                            <option value="CENA">CENA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="donde" class="form-label">Donde?</label>
                                        <select name="donde" id="donde" class="form-control" required>
                                            <option value="CAMPAMENTO">CAMPAMENTO</option>
                                            <option value="OFICINA">OFICINA</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="chofer" class="form-label">Chofer / Delivery</label>
                                    <select name="chofer" id="chofer" class="form-control" required>
                                        <option value="">Seleccione un chofer</option>
                                        <option value="ALICIA GARABITO RAMOS">ALICIA GARABITO RAMOS</option>
                                        <option value="LEONCIA ESPINOZA">LEONCIA ESPINOZA</option>
                                        <option value="ALEJANDRO VENTURA">ALEJANDRO VENTURA</option>
                                        <option value="ELSA VERONICA QUIROGA MAMANI">ELSA VERONICA QUIROGA MAMANI</option>
                                        <option value="ELIZABETH MURRILLO">ELIZABETH MURRILLO</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_envio" class="form-label">Fecha de envío</label>
                                    <input type="datetime-local" id="fecha_envio" name="fecha_envio" class="form-control" required>
                                </div>

                                <div class="row align-items-center g-2 mb-3">
                                    <div class="col-md-8 col-6 d-flex align-items-center">
                                        <h4 class="mb-0">Detalle de Productos</h4>
                                    </div>
                                    <div class="col-md-4 col-6 text-end">
                                        <span class="badge bg-primary p-2" style="cursor:pointer; font-size:0.9rem;" onclick="agregarFila()">
                                            + Agregar Detalle
                                        </span>
                                    </div>
                                </div>

                                <div id="detalleContainer"></div>

                                <button type="submit" class="btn btn-primary" style="width: 100%">Guardar Envío</button>
                            </form>
                        </div>
                        <div class="col-md-6" id="PdfDiv"></div>
                    </div>
                </div>
                <div class="tab-pane" id="tabs-profile-5">
                    <div class="row">
                        <div class="col-md-6" id="DivDatos">

                            <div class="mb-3 d-flex gap-2">
                                <select id="filterTipo" class="form-select">
                                    <option value="dia">Día</option>
                                    <option value="mes">Mes</option>
                                    <option value="anio">Año</option>
                                </select>
                                <select id="filterDia" class="form-select"></select>
                                <select id="filterMes" class="form-select"></select>
                                <select id="filterAnio" class="form-select"></select>
                                <button id="btnFiltrar" class="btn btn-primary">Filtrar</button>
                                <button id="btnPdf" class="btn btn-primary">PDF</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tablaEnvios">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha de Envío</th>
                                            <th>Chofer / Delivery</th>
                                            <th>Estado</th>
                                            <th>Donde</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6" id="DivResulPdf">

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agregar SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function agregarFila() {
        const container = document.getElementById('detalleContainer');
        const index = container.children.length;
        const div = document.createElement('div');
        div.className = 'detalle-row mb-3 p-3 border rounded shadow-sm bg-light';
        div.innerHTML = `
            <div class="row align-items-center g-2">
                <div class="col-md-5">
                    <input type="text" name="producto[]" placeholder="Producto" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="cantidad[]" placeholder="Cantidad" class="form-control text-center" min="1" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="observaciones[]" placeholder="Observaciones" class="form-control">
                </div>
                ${index > 0 ? `
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarFila(this)">
                        <i class="fas fa-trash-alt"></i> Eliminar
                    </button>
                </div>` : ''}
            </div>
        `;
        container.appendChild(div);
    }

    function eliminarFila(btn) {
        const fila = btn.closest('.detalle-row');
        if (fila) fila.remove();
    }

    window.onload = function() {
        const now = new Date();
        const localISOTime = now.toISOString().slice(0,16);
        document.getElementById('fecha_envio').value = localISOTime;
        agregarFila();
    }

    const choferSelect = document.getElementById('chofer');
    const choferContainer = choferSelect.parentElement;

    const inputOtros = document.createElement('input');
    inputOtros.type = 'text';
    inputOtros.name = 'chofer_otro';
    inputOtros.id = 'chofer_otro';
    inputOtros.className = 'form-control mt-2';
    inputOtros.placeholder = 'Ingrese otro chofer';
    inputOtros.style.display = 'none';
    choferContainer.appendChild(inputOtros);

    choferSelect.addEventListener('change', () => {
        if (choferSelect.value === 'Otros') {
            inputOtros.style.display = 'block';
            inputOtros.required = true;
        } else {
            inputOtros.style.display = 'none';
            inputOtros.required = false;
        }
    });

    document.getElementById('envioForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const estado_servicio = form.estado_servicio.value;
        const donde = form.donde.value;
        const fecha_envio = form.fecha_envio.value;
        let chofer = form.chofer.value;

        if (chofer === 'Otros') {
            chofer = form.chofer_otro.value.trim();
        }

        const productos = Array.from(form.querySelectorAll('input[name="producto[]"]')).map(i => i.value.trim());
        const cantidades = Array.from(form.querySelectorAll('input[name="cantidad[]"]')).map(i => i.value.trim());
        const observaciones = Array.from(form.querySelectorAll('input[name="observaciones[]"]')).map(i => i.value.trim());

        if (!estado_servicio || !donde || !chofer || !fecha_envio) {
            Swal.fire('Campos incompletos', 'Por favor completa todos los campos obligatorios.', 'warning');
            return;
        }

        if (productos.length === 0) {
            Swal.fire('Sin productos', 'Agrega al menos un producto antes de guardar.', 'warning');
            return;
        }

        const data = {
            estado: estado_servicio,
            donde: donde,
            chofer,
            fecha_envio,
            producto: productos,
            cantidad: cantidades.map(c => parseInt(c)),
            observaciones: observaciones,
        };

        const result = await Swal.fire({
            title: '¿Confirmas que todos los datos son correctos?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, enviar',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            try {
                const res = await fetch("{{ url('/envios') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                if (!res.ok) {
                    const errorData = await res.json();
                    const errors = errorData.errors
                        ? Object.values(errorData.errors).flat().join(' ')
                        : errorData.message || 'Error desconocido';
                    Swal.fire('Error', errors, 'error');
                    return;
                }

                const envioGuardado = await res.json();

                Swal.fire({
                    icon: 'success',
                    title: 'Envío guardado con éxito',
                    showConfirmButton: false,
                    timer: 2000
                });

                const pdfDiv = document.getElementById('PdfDiv');
                pdfDiv.innerHTML = `<iframe src="/envios/pdf/${envioGuardado.id}" style="width:100%; height:600px;" frameborder="0"></iframe>`;

                const detalleContainer = document.getElementById('detalleContainer');

                form.querySelectorAll('input, select').forEach(input => {
                    if (input.id !== 'fecha_envio') {
                        if (input.type === 'select-one') {
                            input.selectedIndex = 0;
                        } else {
                            input.value = '';
                        }
                    }
                });

                detalleContainer.innerHTML = '';
                agregarFila();

                inputOtros.style.display = 'none';
                inputOtros.value = '';
                inputOtros.required = false;

            } catch (error) {
                Swal.fire('Error de conexión', 'No se pudo comunicar con el servidor.', 'error');
            }
        }
    });
</script>
<script>
    async function inicializarFiltros() {
        const selectDia = document.getElementById('filterDia');
        const selectMes = document.getElementById('filterMes');
        const selectAnio = document.getElementById('filterAnio');
        const selectTipo = document.getElementById('filterTipo'); // nuevo select tipo

        // Limpiar selects para no duplicar
        selectDia.innerHTML = '';
        selectMes.innerHTML = '';
        selectAnio.innerHTML = '';

        // Día 1-31
        for (let d = 1; d <= 31; d++) {
            const option = document.createElement('option');
            option.value = d.toString().padStart(2,'0');
            option.textContent = d;
            selectDia.appendChild(option);
        }

        // Mes 1-12
        const meses = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        meses.forEach(m => {
            const option = document.createElement('option');
            option.value = m;
            option.textContent = m;
            selectMes.appendChild(option);
        });

        // Año - últimos 5 años
        const yearActual = new Date().getFullYear();
        for(let y = yearActual; y >= yearActual - 5; y--){
            const option = document.createElement('option');
            option.value = y;
            option.textContent = y;
            selectAnio.appendChild(option);
        }

        // Inicializar con fecha actual
        const now = new Date();
        selectDia.value = now.getDate().toString().padStart(2,'0');
        selectMes.value = (now.getMonth()+1).toString().padStart(2,'0');
        selectAnio.value = now.getFullYear();
        selectTipo.value = 'dia'; // por defecto filtramos por día

        // Ajustar visibilidad de selects según tipo
        ajustarVisibilidadFiltros();

        // Cargar envíos iniciales
        await cargarEnvios();
    }

    // Ajusta visibilidad de selects según tipo de filtro
    function ajustarVisibilidadFiltros() {
        const tipo = document.getElementById('filterTipo').value;
        const dia = document.getElementById('filterDia');
        const mes = document.getElementById('filterMes');
        const anio = document.getElementById('filterAnio');

        if(tipo === 'dia') {
            dia.style.display = 'block';
            mes.style.display = 'block';
            anio.style.display = 'block';
        } else if(tipo === 'mes') {
            dia.style.display = 'none';
            mes.style.display = 'block';
            anio.style.display = 'block';
        } else if(tipo === 'anio') {
            dia.style.display = 'none';
            mes.style.display = 'none';
            anio.style.display = 'block';
        }
    }

    // Función para cargar envíos desde backend según filtros
    async function cargarEnvios() {
        const tipo = document.getElementById('filterTipo').value;
        const dia = document.getElementById('filterDia').value;
        const mes = document.getElementById('filterMes').value;
        const anio = document.getElementById('filterAnio').value;

        const tbody = document.querySelector('#tablaEnvios tbody');
        tbody.innerHTML = '';

        try {
            let url = `{{ url("/envios/lista") }}?anio=${anio}`;
            if(tipo === 'mes' || tipo === 'dia') url += `&mes=${mes}`;
            if(tipo === 'dia') url += `&dia=${dia}`;

            const res = await fetch(url);
            const envios = await res.json();

            envios.forEach(envio => {
                const tr = document.createElement('tr');
                tr.style.cursor = 'pointer';
                tr.innerHTML = `
                    <td>${envio.id}</td>
                    <td>${envio.fecha_envio}</td>
                    <td>${envio.chofer}</td>
                    <td>${envio.estado}</td>
                    <td>${envio.donde}</td>
                    <td>
                        <span class="badge badge-outline text-blue btn-editar" style="cursor:pointer" data-id="${envio.id}">Editar</span>
                        <span class="badge badge-outline text-green btn-pdf" style="cursor:pointer" data-pdf="${envio.id}">PDF</span>
                    </td>
                `;

                tr.querySelector('.btn-editar').addEventListener('click', (e) => {
                    e.stopPropagation();
                    const envioId = e.target.getAttribute('data-id');
                    cargarFormularioPorId(envioId);
                });

                tr.querySelector('.btn-pdf').addEventListener('click', (e) => {
                    e.stopPropagation();
                    const envioId = e.target.getAttribute('data-pdf');
                    document.getElementById('DivResulPdf').innerHTML = `
                        <iframe src="/envios/pdf/${envioId}" style="width:100%; height:600px;" frameborder="0"></iframe>
                    `;
                });

                tbody.appendChild(tr);
            });

        } catch (error) {
            console.error('Error cargando envíos:', error);
        }
    }

    async function cargarFormularioPorId(id) {
        const div = document.getElementById('DivResulPdf');
        div.innerHTML = `<p>Cargando datos del envío...</p>`;

        try {
            const res = await fetch(`/envio-get/${id}`);
            const envio = await res.json();

            const choferFijos = ['ALICIA GARABITO RAMOS','LEONCIA ESPINOZA','ALEJANDRO VENTURA','ELSA VERONICA QUIROGA MAMANI','ELIZABETH MURRILLO'];
            const esOtro = !choferFijos.includes(envio.chofer);

            div.innerHTML = `
                <form id="envioFormEdit" data-envio-id="${id}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="estado_servicioEdit" class="form-label">Estado del servicio</label>
                            <select name="estado_servicioEdit" id="estado_servicioEdit" class="form-control" required>
                                <option value="DESAYUNO" ${envio.estado === 'DESAYUNO' ? 'selected' : ''}>DESAYUNO</option>
                                <option value="ALMUERZO" ${envio.estado === 'ALMUERZO' ? 'selected' : ''}>ALMUERZO</option>
                                <option value="CENA" ${envio.estado === 'CENA' ? 'selected' : ''}>CENA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="dondeEdit" class="form-label">Donde?</label>
                            <select name="dondeEdit" id="dondeEdit" class="form-control" required>
                                <option value="CAMPAMENTO" ${envio.donde === 'CAMPAMENTO' ? 'selected' : ''}>CAMPAMENTO</option>
                                <option value="OFICINA" ${envio.donde === 'OFICINA' ? 'selected' : ''}>OFICINA</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="choferEdit" class="form-label">Chofer / Delivery</label>
                        <div class="d-flex gap-2">
                            <select name="choferEdit" id="choferEdit" class="form-control" required onchange="mostrarInputOtros(this)">
                                <option value="">Seleccione un chofer</option>
                                ${choferFijos.map(c => `<option value="${c}" ${envio.chofer===c?'selected':''}>${c}</option>`).join('')}
                                <option value="Otros" ${esOtro ? 'selected' : ''}>Otros</option>
                            </select>
                            <input type="text" id="choferOtrosEdit" class="form-control" placeholder="Nombre del chofer" 
                                value="${esOtro ? envio.chofer : ''}" 
                                style="display: ${esOtro ? 'block' : 'none'};">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_envioEdit" class="form-label">Fecha de envío</label>
                        <input type="datetime-local" id="fecha_envioEdit" name="fecha_envioEdit" class="form-control" required
                            value="${envio.fecha_envio.substring(0,16)}">
                    </div>

                    <div class="row align-items-center g-2 mb-3">
                        <div class="col-md-8 col-6 d-flex align-items-center">
                            <h4 class="mb-0">Detalle de Productos</h4>
                        </div>
                        <div class="col-md-4 col-6 text-end">
                            <span class="badge bg-primary p-2" style="cursor:pointer; font-size:0.9rem;" onclick="agregarFilaEdit()">+ Agregar Detalle</span>
                        </div>
                    </div>

                    <div id="detalleContainerEdit"></div>

                    <button type="submit" class="btn btn-primary" style="width: 100%">Guardar Envío</button>
                </form>
            `;

            // Llenar detalles
            const container = document.getElementById('detalleContainerEdit');
            envio.items.forEach(item => {
                const div = document.createElement('div');
                div.classList.add('row','mb-2');
                div.innerHTML = `
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Producto" value="${item.producto}" required>
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control" placeholder="Cantidad" value="${item.cantidad}" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaEdit(this)">X</button>
                    </div>
                `;
                container.appendChild(div);
            });

        } catch (error) {
            console.error('Error cargando formulario:', error);
            div.innerHTML = `<p>Error al cargar el formulario.</p>`;
        }
    }

    function mostrarInputOtros(select) {
        const input = document.getElementById('choferOtrosEdit');
        if(select.value === 'Otros'){
            input.style.display = 'block';
            input.required = true;
        } else {
            input.style.display = 'none';
            input.required = false;
        }
    }

    function eliminarFilaEdit(btn) {
        btn.closest('.row').remove();
    }

    function agregarFilaEdit() {
        const container = document.getElementById('detalleContainerEdit');
        const div = document.createElement('div');
        div.classList.add('row','mb-2');
        div.innerHTML = `
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Producto" required>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" placeholder="Cantidad" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFilaEdit(this)">X</button>
            </div>
        `;
        container.appendChild(div);
    }

    document.getElementById('DivResulPdf').addEventListener('submit', async function(e){
        if(e.target && e.target.id === 'envioFormEdit') {
            e.preventDefault();
            const form = e.target;
            const id = form.getAttribute('data-envio-id');

            const items = Array.from(document.querySelectorAll('#detalleContainerEdit .row')).map(row => ({
                producto: row.querySelector('input[placeholder="Producto"]').value,
                cantidad: row.querySelector('input[placeholder="Cantidad"]').value,
            }));

            const choferValue = document.getElementById('choferEdit').value === 'Otros' 
                ? document.getElementById('choferOtrosEdit').value 
                : document.getElementById('choferEdit').value;

            const data = {
                estado_servicioEdit: document.getElementById('estado_servicioEdit').value,
                dondeEdit: document.getElementById('dondeEdit').value,
                choferEdit: choferValue,
                fecha_envioEdit: document.getElementById('fecha_envioEdit').value,
                items: items
            };

            try {
                const res = await fetch(`/envio-update/${id}`, {
                    method: 'PUT',
                    headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    body: JSON.stringify(data)
                });

                const result = await res.json();

                await Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: result.message || 'Envío actualizado correctamente',
                    confirmButtonText: 'Aceptar'
                });

                // Después de cerrar SweetAlert, mostrar el PDF
                document.getElementById('DivResulPdf').innerHTML = `
                    <iframe src="/envios/pdf/${id}" style="width:100%; height:600px;" frameborder="0"></iframe>
                `;

                // Opcional: recargar la tabla después de guardar
                cargarEnvios();

            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al actualizar el envío.',
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    });


    // Eventos
    document.getElementById('filterTipo').addEventListener('change', () => {
        ajustarVisibilidadFiltros();
        cargarEnvios(); // recarga envíos al cambiar tipo
    });
    document.getElementById('btnFiltrar').addEventListener('click', cargarEnvios);
    document.querySelector('a[href="#tabs-profile-5"]').addEventListener('shown.bs.tab', inicializarFiltros);

</script>
<script>
    document.getElementById('btnPdf').addEventListener('click', () => {
        const tipo = document.getElementById('filterTipo').value;
        const dia = document.getElementById('filterDia').value;
        const mes = document.getElementById('filterMes').value;
        const anio = document.getElementById('filterAnio').value;

        // Construir la URL con parámetros según tipo de filtro
        let url = `/envios/pdf-reporte?anio=${anio}`;
        if(tipo === 'mes' || tipo === 'dia') url += `&mes=${mes}`;
        if(tipo === 'dia') url += `&dia=${dia}`;

        // Abrir en nueva ventana/pestaña
        window.open(url, '_blank');
    });
</script>
@endsection
