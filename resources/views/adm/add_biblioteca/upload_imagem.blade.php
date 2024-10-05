<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem</title>
    <link rel="stylesheet" href="/css/adm/upload.css">
</head>
<body background="../../assets/img/ti2.jpg">
    <nav>
        <ul class="menu">
            <li><a href="biblioteca.php">BIBLIOTECA</a></li>
            <li><a href="album.php">ÁLBUM</a></li>
            <li><a href="control.php">VOLTAR</a></li>
        </ul>
    </nav>
    
    <!-- SELECIONE UMA IMAGEM -->
    <div class="container">
        <h1 class="heading">SELECIONE UMA FOTO</h1>
    </div>

    <!-- ADICIONANDO DADOS NA TABELA -->
    <div class="cont">
        <form action="{{ route('imagem-store') }}" method="POST" enctype="multipart/form-data" id="file">
            @csrf
            <div class="area">
                <input type="file" accept="image/jpeg" name="imagem" id="fileInput" onchange="previewImage(event)" required><br>
            </div>
            <div>
                <input type="submit" class="submit" value="Enviar" name="submit" id="submit">
            </div>
        </form>
    </div>

    <!-- IMAGEM NA TELA -->
    <div class="container">
        <div class="container-image">
            <div class="image" data-title="cidade toda">
                <div class="imagem">
                    <img id="imagemExibida" src="#" alt="Imagem selecionada" style="display:none;" width="500px">
                </div>
            </div>
        </div>
    </div>

    <!-- MENSAGEM PARA CONFIRMAÇÃO DE EXCLUSÃO -->
    <!-- @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->

    <!-- Imagens Enviadas -->
    @if (isset($imagens) && count($imagens) > 0)
        <div class="container mt-10">
            <h2 class="heading">Imagens enviadas</h2>
            <div class="container-image">
                @foreach ($imagens as $imagem)
                    <div class="image" data-title="{{ $imagem->nome }}">
                        <div class="imagem">
                            <img src="{{ route('imagem-show', $imagem->id) }}" alt="{{ $imagem->nome }}" width="500px">
                        </div>
                        <p>{{ $imagem->nome }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <script>
        function previewImage(event) {
            var input = event.target;
            var imagemExibida = document.getElementById('imagemExibida');
            imagemExibida.style.display = 'block';
            var reader = new FileReader();
            reader.onload = function() {
                imagemExibida.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
</body>
</html>
