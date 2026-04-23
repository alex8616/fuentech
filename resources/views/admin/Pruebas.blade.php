<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Backup de la Base de Datos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">

    <h1 class="mb-4">Enviar Backup de Base de Datos por Correo</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    <form action="{{ route('enviar.backup') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">
            Enviar Backup por Correo
        </button>
    </form>


</body>
</html>
