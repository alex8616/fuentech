<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR con Hugging Face</title>
</head>
<body>
    <form action="{{ url('/extract-text') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Extraer Texto</button>
    </form>
</body>
</html>
