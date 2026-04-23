<form action="/upload" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image">
    <button type="submit">Subir Imagen</button>
</form>