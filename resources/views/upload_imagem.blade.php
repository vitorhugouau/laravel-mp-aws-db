<!DOCTYPE html>
<html>
<head>
    <title>Upload de Imagem</title>
</head>
<body>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('imagem.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="imagem">Escolha uma imagem:</label>
        <input type="file" name="imagem" id="imagem" required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
