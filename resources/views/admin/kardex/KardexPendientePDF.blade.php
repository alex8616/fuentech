<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h3>Kardex - {{$detalles->TipoStock}}</h3>
    <span style="font-size: 13px">RESPONSABLE: {{$detalles->users->name}}</span><br>
    <span style="font-size: 13px">FECHA INICIO: {{$detalles->FechaInicioSolucion}}</span><br>
    <span style="font-size: 13px">PRODUCTO: {{$detalles->stockdates->productos->NombreProducto}}</span><br>
    <span style="font-size: 13px">CANTIDAD: {{$detalles->CantidadFaltante}}</span><br>
</body>
</html>
