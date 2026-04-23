@extends('layouts.my-dashboard-layout')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imagen para Análisis</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Sube una Imagen para Extraer Información</h1>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" id="image" name="image" accept="image/*" required>
        <button type="submit">Analizar Imagen</button>
    </form>
    <div id="result"></div>

    <script>
       
       document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData();
    formData.append('image', document.getElementById('image').files[0]);

    axios.post('/analyze-image', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    .then(response => {
        // Aquí gestionamos la respuesta correctamente.
        if (response.data && response.data.choices && response.data.choices.length > 0) {
            document.getElementById('result').innerHTML = '<strong>Resultado:</strong> ' + response.data.choices[0].message.content;
        } else {
            document.getElementById('result').innerHTML = '<strong>Error:</strong> No se pudo procesar la imagen correctamente.';
        }
    })
    .catch(error => {
        console.error(error);
        document.getElementById('result').innerHTML = '<strong>Error:</strong> Ocurrió un problema con la solicitud.';
    });
});


    </script>
</body>
</html>

@endsection
