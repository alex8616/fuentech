document.addEventListener('DOMContentLoaded', function() {        
    FechaSelectMesas()
});

function FechaSelectMesas() {
    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $('#MesMesas').empty();
    $('#AnioMesas').empty();

    for (var month = 0; month < 12; month++) {
        $('#MesMesas').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
    }
    $('#MesMesas').val(currentMonth + 1);

    var startYear = currentYear - 6;
    var endYear = currentYear;
    for (var year = startYear; year <= endYear; year++) {
        $('#AnioMesas').append('<option value="' + year + '">' + year + '</option>');
    }
    $('#AnioMesas').val(currentYear);

    function updateDaySelectorGasto() {
        var selectedMonth = parseInt($('#MesMesas').val());
        var selectedYear = parseInt($('#AnioMesas').val());
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        $('#DiaMesas').empty();
        for (var day = 1; day <= daysInMonth; day++) {
            $('#DiaMesas').append('<option value="' + day + '">' + day + '</option>');
        }
        if (currentDay > daysInMonth) {
            $('#DiaMesas').val(daysInMonth);
        } else {
            $('#DiaMesas').val(currentDay);
        }
    }

    updateDaySelectorGasto();

    $('#DateMesas').on('change', function() {
        var selectedValue = $(this).val();
        switch (selectedValue) {
            case 'DiarioMesas':
                $('#DiaMesasContainer').show();
                $('#MesMesasContainer').show();
                $('#AnioMesasContainer').show();
                $('#ganttChartDiario').show();
                $('#ganttChartMensual').hide();
                $('#ganttChartAnual').hide();
                break;
            case 'MensualMesas':
                $('#DiaMesasContainer').hide();
                $('#MesMesasContainer').show();
                $('#AnioMesasContainer').show();
                $('#ganttChartDiario').hide();
                $('#ganttChartMensual').show();
                $('#ganttChartAnual').hide();
                break;
            case 'AnualMesas':
                $('#DiaMesasContainer').hide();
                $('#MesMesasContainer').hide();
                $('#AnioMesasContainer').show();
                $('#ganttChartDiario').hide();
                $('#ganttChartMensual').hide();
                $('#ganttChartAnual').show();
                break;
        }
        filtrarDatosMesas();
    });


    $('#MesMesas, #AnioMesas').on('change', function() {
        updateDaySelectorGasto();
        filtrarDatosMesas();
    });

    $('#DiaMesas').on('change', function() {
        filtrarDatosMesas();
    });

    $('#DateMesas').trigger('change');
}

function filtrarDatosMesas(){
    var tipoFiltro = $('#DateMesas').val();
    var dia = $('#DiaMesas').val();
    var mes = $('#MesMesas').val();
    var anio = $('#AnioMesas').val();

    $.ajax({
        url: 'api/filtrar-datos-reporte-mesas',
        method: 'GET',
        data: {
            tipoFiltro: tipoFiltro,
            dia: dia,
            mes: mes,
            anio: anio,
        },
        success: function(response) {
            if(response.tipodeseleccion == "Diario"){
                LlenarDatos(response)
                GraficaGanttMesaDiario(response)
            }

            if(response.tipodeseleccion == "Mensual"){
                LlenarDatos(response)
                GraficaGanttMesaMensual(response)
            }

            if(response.tipodeseleccion == "Anual"){
                LlenarDatos(response)
                GraficaGanttMesaAnual(response)
            }
        },
        error: function(error) {
            console.error('Error al filtrar datos:', error);
        }
    });
}

function GraficaGanttMesaDiario(data) {
    document.getElementById('loadingMessage').style.display = 'block';

    // Verificar y destruir el gráfico existente si es válido
    if (window.ganttChartDiario && window.ganttChartDiario instanceof Chart) {
        window.ganttChartDiario.destroy();
    }

    // Remover el canvas del DOM si existe
    const existingCanvas = document.getElementById('ganttChartDiario');
    if (existingCanvas) {
        existingCanvas.remove();
    }

    // Crear un nuevo canvas
    const canvas = document.createElement('canvas');
    canvas.id = 'ganttChartDiario';
    document.getElementById('chartContainer').appendChild(canvas);

    const ctx = canvas.getContext('2d');

    const selectedYear = parseInt(data.anio);
    const selectedMonth = parseInt(data.mes) - 1;
    const selectedDay = parseInt(data.dia);

    // Definir las horas del día
    const horas = Array.from({ length: 24 }, (_, i) => i);

    const colors = [
        'rgba(75, 192, 192, 0.2)',  
        'rgba(255, 99, 132, 0.2)',  
        'rgba(54, 162, 235, 0.2)',  
        'rgba(255, 206, 86, 0.2)',  
        'rgba(153, 102, 255, 0.2)', 
        'rgba(255, 159, 64, 0.2)'
    ];

    const borderColors = [
        'rgba(75, 192, 192, 1)',  
        'rgba(255, 99, 132, 1)',  
        'rgba(54, 162, 235, 1)',  
        'rgba(255, 206, 86, 1)',  
        'rgba(153, 102, 255, 1)', 
        'rgba(255, 159, 64, 1)'   
    ];

    const datasets = [];
    const mesasSet = new Set();

    const mesasArray = data.mesas;

    mesasArray.forEach((item, index) => {
        const mesa = 'Mesa ' + item.mesa;
        mesasSet.add(mesa);

        const mesaDataset = {
            label: mesa,
            data: [],
            backgroundColor: colors[index % colors.length],
            borderColor: borderColors[index % colors.length],
            borderWidth: 1,
            pointStyle: 'rect',
            pointRadius: 10,
            barThickness: 20,
            showLine: true,
        };

        item.ventas.forEach(venta => {
            const ventaDate = new Date(venta.fecha_venta);
            const hour = ventaDate.getHours();

            if (ventaDate.getFullYear() === selectedYear &&
                ventaDate.getMonth() === selectedMonth &&
                ventaDate.getDate() === selectedDay) {

                mesaDataset.data.push({
                    x: hour,
                    y: mesa,
                    consumoId: venta.label,
                    total: venta.total
                });
            }
        });

        if (mesaDataset.data.length > 0) {
            datasets.push(mesaDataset);
        }
    });

    // Crear el gráfico con los datos actualizados
    window.ganttChartDiario = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    min: 0,
                    max: 23,
                    title: {
                        display: true,
                        text: 'Horas'
                    },
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return `${value}:00`;
                        }
                    }
                },
                y: {
                    type: 'category',
                    labels: Array.from(mesasSet),
                    title: {
                        display: true,
                        text: 'Mesas'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.raw.consumoId} - Total ${tooltipItem.raw.total}`;
                        }
                    }
                }
            }
        }
    });

    document.getElementById('loadingMessage').style.display = 'none';
}

function GraficaGanttMesaMensual(data) {
    document.getElementById('loadingMessage').style.display = 'block';

    // Verificar y destruir el gráfico existente si es válido
    if (window.ganttChartMensual && window.ganttChartMensual instanceof Chart) {
        window.ganttChartMensual.destroy();
    }

    // Remover el canvas del DOM si existe
    const existingCanvas = document.getElementById('ganttChartMensual');
    if (existingCanvas) {
        existingCanvas.remove();
    }

    // Crear un nuevo canvas
    const canvas = document.createElement('canvas');
    canvas.id = 'ganttChartMensual';
    document.getElementById('chartContainer').appendChild(canvas);

    const ctx = canvas.getContext('2d');

    const selectedYear = parseInt(data.anio);
    const selectedMonth = parseInt(data.mes) - 1;
    const diasEnMes = new Date(selectedYear, selectedMonth + 1, 0).getDate();

    const dias = Array.from({ length: diasEnMes }, (_, i) => i + 1);

    const colors = [
        'rgba(75, 192, 192, 0.2)',  
        'rgba(255, 99, 132, 0.2)',  
        'rgba(54, 162, 235, 0.2)',  
        'rgba(255, 206, 86, 0.2)',  
        'rgba(153, 102, 255, 0.2)', 
        'rgba(255, 159, 64, 0.2)'
    ];

    const borderColors = [
        'rgba(75, 192, 192, 1)',  
        'rgba(255, 99, 132, 1)',  
        'rgba(54, 162, 235, 1)',  
        'rgba(255, 206, 86, 1)',  
        'rgba(153, 102, 255, 1)', 
        'rgba(255, 159, 64, 1)'   
    ];

    const datasets = [];
    const mesasSet = new Set();

    const mesasArray = data.mesas;

    mesasArray.forEach((item, index) => {
        const mesa = 'Mesa ' + item.mesa;
        mesasSet.add(mesa);

        const mesaDataset = {
            label: mesa,
            data: [],
            backgroundColor: colors[index % colors.length],
            borderColor: borderColors[index % colors.length],
            borderWidth: 1,
            pointStyle: 'rect',
            pointRadius: 10,
            barThickness: 20,
            showLine: false,
        };

        item.ventas.forEach(venta => {
            const ventaDate = new Date(venta.fecha_venta);
            const day = ventaDate.getDate();

            if (ventaDate.getFullYear() === selectedYear && ventaDate.getMonth() === selectedMonth) {
                mesaDataset.data.push({
                    x: mesa,
                    y: day,
                    consumoId: venta.label,
                    total: venta.total
                });
            }
        });

        if (mesaDataset.data.length > 0) {
            datasets.push(mesaDataset);
        }
    });

    // Crear el gráfico con los datos actualizados
    window.ganttChartMensual = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'category',
                    labels: Array.from(mesasSet),
                    title: {
                        display: true,
                        text: 'Mesas'
                    }
                },
                y: {
                    type: 'linear',
                    position: 'bottom',
                    min: 1,
                    max: diasEnMes,
                    title: {
                        display: true,
                        text: 'Días'
                    },
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return `Día ${value}`;
                        }
                    }                    
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.raw.consumoId} - Total ${tooltipItem.raw.total}`;
                        }
                    }
                }
            }
        }
    });

    document.getElementById('loadingMessage').style.display = 'none';
}

function GraficaGanttMesaAnual(data) {
    document.getElementById('loadingMessage').style.display = 'block';

    const selectedYear = parseInt(data.anio);
    const existingCanvas = document.getElementById('ganttChartAnual');
    if (existingCanvas) {
        existingCanvas.remove();
    }

    const newCanvas = document.createElement('canvas');
    newCanvas.id = 'ganttChartAnual';
    newCanvas.height = '100%';
    newCanvas.width = Math.max(800, data.mesas.length * 150); // Ajusta el multiplicador según sea necesario
    document.getElementById('chartContainer').appendChild(newCanvas);

    const datasets = [];
    const mesasSet = new Set();

    const meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    const colors = [
        'rgba(75, 192, 192, 0.2)',  
        'rgba(255, 99, 132, 0.2)',  
        'rgba(54, 162, 235, 0.2)',  
        'rgba(255, 206, 86, 0.2)',  
        'rgba(153, 102, 255, 0.2)', 
        'rgba(255, 159, 64, 0.2)'
    ];

    const borderColors = [
        'rgba(75, 192, 192, 1)',  
        'rgba(255, 99, 132, 1)',  
        'rgba(54, 162, 235, 1)',  
        'rgba(255, 206, 86, 1)',  
        'rgba(153, 102, 255, 1)', 
        'rgba(255, 159, 64, 1)'   
    ];

    const mesasArray = data.mesas;

    mesasArray.forEach((item, index) => {
        const mesa = 'Mesa ' + item.mesa;
        mesasSet.add(mesa);

        item.ventas.forEach(venta => {
            const startDate = new Date(venta.fecha_venta);
            const startMonthIndex = startDate.getMonth() + 1;

            if (startDate.getFullYear() === selectedYear) {
                const colorIndex = index % colors.length;

                datasets.push({
                    label: mesa,
                    data: [{
                        x: mesa,
                        y: meses[startMonthIndex]
                    }],
                    backgroundColor: colors[colorIndex],
                    borderColor: borderColors[colorIndex],
                    borderWidth: 1,
                    pointStyle: 'rect',
                    pointRadius: 15,
                    consumoId: venta.label, 
                    total: venta.total      
                });
            }
        });
    });

    const ctx = document.getElementById('ganttChartAnual').getContext('2d');
    new Chart(ctx, {
        type: 'line', // Cambia a 'bar' para gráfico de barras horizontales
        data: {
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'category',
                    labels: ['', ...mesasSet],
                    title: {
                        display: true,
                        text: 'Mesas'
                    },
                    ticks: {
                        autoSkip: false // Evita que se omitan las etiquetas
                    }
                },
                y: {
                    type: 'category',
                    labels: meses,
                    title: {
                        display: true,
                        text: 'Meses'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.dataset.consumoId} - Total ${tooltipItem.dataset.total}`;
                        }
                    }
                }
            }
        }
    });

    // Ocultar mensaje de carga al finalizar
    document.getElementById('loadingMessage').style.display = 'none';
}

function LlenarDatos(data){
    if(data.tipodeseleccion == "Diario"){
        const dia = data.dia
        const mes = data.mes
        const anio = data.anio 
        const cantidadregistro = data.cantidadregistro
        const cantiadmesas = data.cantidadmesas
        const total = (data.totalsum).toFixed(2)
        const promediomesas = (total/cantiadmesas).toFixed(2)
        const promedioventa = (total/cantidadregistro).toFixed(2)
        document.getElementById('TextoContenido').textContent = `Datos Del Dia ${dia}/${mes}/${anio} con ${cantidadregistro} registros`;
        document.getElementById('CantidadMesas').textContent = `${cantiadmesas}`;
        document.getElementById('PrecioTotal').textContent = `${total}`;
        document.getElementById('PromedioMesas').textContent = `${promediomesas}`;
        document.getElementById('PromedioVenta').textContent = `${promedioventa}`;
    }

    if(data.tipodeseleccion == "Mensual"){
        const dia = data.dia
        const mes = data.mes
        const anio = data.anio 
        const cantidadregistro = data.cantidadregistro
        const cantiadmesas = data.cantidadmesas
        const total = (data.totalsum).toFixed(2)
        const promediomesas = (total/cantiadmesas).toFixed(2)
        const promedioventa = (total/cantidadregistro).toFixed(2)
        document.getElementById('TextoContenido').textContent = `Datos Del Mes ${mes}/${anio} con ${cantidadregistro} registros`;
        document.getElementById('CantidadMesas').textContent = `${cantiadmesas}`;
        document.getElementById('PrecioTotal').textContent = `${total}`;
        document.getElementById('PromedioMesas').textContent = `${promediomesas}`;
        document.getElementById('PromedioVenta').textContent = `${promedioventa}`;
    }   

    if(data.tipodeseleccion == "Anual"){
        const dia = data.dia
        const mes = data.mes
        const anio = data.anio 
        const cantidadregistro = data.cantidadregistro
        const cantiadmesas = data.cantidadmesas
        const total = (data.totalsum).toFixed(2)
        const promediomesas = (total/cantiadmesas).toFixed(2)
        const promedioventa = (total/cantidadregistro).toFixed(2)
        document.getElementById('TextoContenido').textContent = `Datos Del Año ${anio} con ${cantidadregistro} registros`;
        document.getElementById('CantidadMesas').textContent = `${cantiadmesas}`;
        document.getElementById('PrecioTotal').textContent = `${total}`;
        document.getElementById('PromedioMesas').textContent = `${promediomesas}`;
        document.getElementById('PromedioVenta').textContent = `${promedioventa}`;
    }
}

function generarPDF(data) {
    $.ajax({
        url: '/api/reporte-mesa-download-pdf',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            datos: data
        },
        success: function(response) {
            console.log(response)
            window.open(response.url, '_blank');
        },
        error: function(error) {
            console.error('Error al generar PDF:', error);
        }
    });
}
