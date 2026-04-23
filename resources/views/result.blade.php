<!-- resources/views/result.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Extraídos</title>
</head>
<body>
    <h1>Datos Extraídos y Traducidos</h1>
    <pre>{{ $data }}</pre>
    <a href="/ocr">Subir otra imagen</a>
</body>
</html>