document.addEventListener('DOMContentLoaded', function() {        
    FechaSelectProductos()
    TraerCategoria()
});

function FechaSelectProductos() {
  var today = new Date();
  var currentDay = today.getDate();
  var currentMonth = today.getMonth();
  var currentYear = today.getFullYear();
  var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

  $('#MesProductos').empty();
  $('#AnioProductos').empty();

  for (var month = 0; month < 12; month++) {
      $('#MesProductos').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
  }
  $('#MesProductos').val(currentMonth + 1);

  var startYear = currentYear - 6;
  var endYear = currentYear;
  for (var year = startYear; year <= endYear; year++) {
      $('#AnioProductos').append('<option value="' + year + '">' + year + '</option>');
  }
  $('#AnioProductos').val(currentYear);

  function updateDaySelectorGasto() {
      var selectedMonth = parseInt($('#MesProductos').val());
      var selectedYear = parseInt($('#AnioProductos').val());
      var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
      $('#DiaProductos').empty();
      for (var day = 1; day <= daysInMonth; day++) {
          $('#DiaProductos').append('<option value="' + day + '">' + day + '</option>');
      }
      if (currentDay > daysInMonth) {
          $('#DiaProductos').val(daysInMonth);
      } else {
          $('#DiaProductos').val(currentDay);
      }
  }

  updateDaySelectorGasto();

  $('#DateProductos').on('change', function() {
      var selectedValue = $(this).val();
      switch (selectedValue) {
          case 'DiarioProductos':
              $('#DiaProductosContainer').show();
              $('#MesProductosContainer').show();
              $('#AnioProductosContainer').show();
              $('#GraficaDiarioProductos').show();
              $('#GraficaMensualProductos').hide();
              $('#GraficaAnualProductos').hide();
              break;
          case 'MensualProductos':
              $('#DiaProductosContainer').hide();
              $('#MesProductosContainer').show();
              $('#AnioProductosContainer').show();
              $('#GraficaDiarioProductos').hide();
              $('#GraficaMensualProductos').show();
              $('#GraficaAnualProductos').hide();
              break;
          case 'AnualProductos':
              $('#DiaProductosContainer').hide();
              $('#MesProductosContainer').hide();
              $('#AnioProductosContainer').show();
              $('#GraficaDiarioProductos').hide();
              $('#GraficaMensualProductos').hide();
              $('#GraficaAnualProductos').show();
              break;
      }
      filtrarDatosProductos();
  });


    $('#MesProductos, #AnioProductos').on('change', function() {
        updateDaySelectorGasto();
        filtrarDatosProductos();
    });

    $('#DiaProductos').on('change', function() {
        filtrarDatosProductos();
    });

    $('#RankingProductos').on('change', function() {
        filtrarDatosProductos();
    });

    $('#RankingVentas').on('change', function() {
        filtrarDatosProductos();
    });

    $('#CategoriaProductos').on('change', function() {
        filtrarDatosProductos();
    });

    $('#DateProductos').trigger('change');
}

function filtrarDatosProductos(){
  var tipoFiltro = $('#DateProductos').val();
  var dia = $('#DiaProductos').val();
  var mes = $('#MesProductos').val();
  var anio = $('#AnioProductos').val();
  var RankingProductos = $('#RankingProductos').val();
  var RankingVentas = $('#RankingVentas').val();
  var CategoriaProductos = $('#CategoriaProductos').val();

  $.ajax({
      url: 'api/filtrar-datos-reporte-productos',
      method: 'GET',
      data: {
          tipoFiltro: tipoFiltro,
          dia: dia,
          mes: mes,
          anio: anio,
          RankingProductos : RankingProductos,
          RankingVentas : RankingVentas,
          CategoriaProductos : CategoriaProductos,

      },
      success: function(response) {
            GenerarTablaProductos(response)
            GraficaProductos(response)
      },
      error: function(error) {
          console.error('Error al filtrar datos:', error);
      }
  });
}

let ventasChart; 
function GraficaProductos(data) {
    const nombresProductos = data.ventas.map(venta => venta.NombreProducto);
    const cantidadesVendidas = data.ventas.map(venta => parseInt(venta.cantidad_vendida));
    const colores = data.ventas.map(venta => venta.color);

    const canvas = document.getElementById('GraficaDiarioProductos');
    const ctx = canvas.getContext('2d');

    const alturaPorDato = 100;
    const alturaMaxima = 1000;
    const nuevaAltura = Math.min(alturaPorDato * data.ventas.length, alturaMaxima);
    
    canvas.height = nuevaAltura;

    if (ventasChart) {
        ventasChart.destroy();
    }

    ventasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: nombresProductos,
            datasets: [{
                label: 'Cantidad Vendida',
                data: cantidadesVendidas,
                backgroundColor: colores,
                borderColor: colores.map(color => color),
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true 
                },
                y: {
                    beginAtZero: true 
                }
            }
        }
    });
}


function GenerarTablaProductos(data) {
    const tableBody = document.getElementById('form_tabs');

    // Crear la estructura de la tabla
    let tableRows = `
        <table id="TableProductos" class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Ventas</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody id="TableProductosBody">
    `;

    // Iterar sobre los datos y agregar las filas
    data.ventas.forEach((venta, index) => {
        tableRows += `
            <tr>
                <td>${index + 1}</td>
                <td>
                    <div class="avatar text-blue-fg" style="background-color: ${venta.color};"></div>
                </td>
                <td>${venta.CodigoProducto}</td>
                <td>${venta.NombreProducto}</td>
                <td>${venta.cantidad_vendida}</td>
                <td>${venta.PrecioProducto}</td>
            </tr>
        `;
    });

    // Cerrar la tabla
    tableRows += `
            </tbody>
        </table>
    `;

    // Agregar la tabla al contenedor
    tableBody.innerHTML = tableRows;
}


function generarPDFProductos(data) {
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

function TraerCategoria(){
    var id = $('#CategoriaProductos').val();
    $.ajax({
        url: '/api/get-categorias',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#CategoriaProductos');
            select.empty();
            select.append($('<option></option>').attr('value', 'Todo').text('Categoria'));
            $.each(data, function(index, categoria) {
                select.append($('<option></option>').attr('value', categoria.id).text(categoria.Nombre_categoria));
            });
        },
        error: function(error) {
            console.error('Error al recuperar datos de subcategorías:', error);
        }
    });
}
