@foreach($consumos as $objeto)
    <div>
        <h1>TUKOS BAR</h1>
        <h2>CONSUMO NRO. {{ $objeto['id'] }}</h2>
        -------------------------------------------------------------
        <p>Fecha: {{ $objeto['fecha_venta'] }}   Mesa: {{ $objeto['ambiente_mesa_id'] }}</p>
        <p>Cantidad de personas: {{ $objeto['CantidadPersonas'] }}</p>

        <h3>Detalle de consumos:</h3>
        @foreach($objeto['detalleconsumos'] as $detalle)
            <div>
                <p>Producto: {{ $detalle['producto']['NombreProducto'] }}</p>
                <p>Cantidad: {{ $detalle['cantidad'] }}</p>

            </div>
        @endforeach
    </div>
@endforeach
