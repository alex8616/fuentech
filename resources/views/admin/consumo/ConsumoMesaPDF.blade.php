<!DOCTYPE html>
<html lang="en">
<style>

    @font-face {
        font-family: 'Journal';
        src: url({{ storage_path("fonts/tipo3.ttf") }}) format("truetype");
    }
        
    
    * {
        font-family: 'Journal';
        font-size: 12px;
    }

    * {
        margin: 0;
        margin-left: 2;
        margin-right: 2;
        padding: 0.5px;
    }
</style>
<body>
@foreach($consumos as $objeto)
    <div>
        <center><h1 style="font-size: 19px"></h1></center>

        <div style="display: flex;">
            <center>
                <p style="display: inline;"><span style="font-weight: bold; font-size: 30px">{{ $objeto->empresa->NombreEmpresa }}</span></p>
            </center>
        </div>

        <div style="display: flex;">
            <p style="display: inline; margin-right: 30%;"><span style="font-weight: bold; font-size: 14px">Mesa:</span> {{ $objeto['ambiente_mesa_id'] }}</p>
            <p style="display: inline; margin-left: 30%;"><span style="font-weight: bold; font-size: 14px">Personas:</span>{{ $objeto['CantidadPersonas'] }}</p>
        </div>

        <div style="display: flex;">
            <p style="display: inline; margin-right: 2%;"><span style="font-weight: bold; font-size: 14px">Fecha:</span>{{ $objeto['fecha_venta'] }}</p>
            <p style="display: inline; margin-right: 2%;"><span style="font-weight: bold; font-size: 14px">NRO. Consumo: </span>{{ $objeto['id'] }}</p>             
        </div>
        
        <hr style="border: none; border-top: 1px dashed black; width: 100%; margin: 10px 0;">
        <h3>Detalle de consumos:</h3>
        @foreach($objeto['detalleconsumos'] as $detalle)
            <div>
                <p>Producto: {{ $detalle['producto']['NombreProducto'] }}</p>
                <p>Cantidad: {{ $detalle['cantidad'] }}</p>

            </div>
        @endforeach
        <hr style="border: none; border-top: 1px dashed black; width: 100%; margin: 10px 0;">
        <div style="display: flex; justify-content: flex-start; float: right;">
            <p style="display: inline; font-size: 30px;"><span style="font-weight: bold; font-size: 30px;">TOTAL:</span> {{ $objeto['total'] }} Bs.</p>
        </div><br>

        <div>
            <center>
                <p><span style="font-size: 15px;">DOCUMENTO NO VALIDO COMO FACTURA</p>
            </center>
        </div>
    </div>
@endforeach
</body>
</html>