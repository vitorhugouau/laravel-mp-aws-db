<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem</title>
</head>
<body>
    <h1>Upload de Imagem com Cloudinary</h1>

    <!-- Exibe a mensagem de sucesso -->
    @if (session('success'))
        <div style="color: green; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="nome">Nome da Imagem:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="valor">Valor:</label>
        <input type="number" id="valor" name="valor" required>
        
        <label for="image">Escolha uma imagem:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        
        <button type="submit">Fazer Upload</button>
    </form>
</body>
</html>
