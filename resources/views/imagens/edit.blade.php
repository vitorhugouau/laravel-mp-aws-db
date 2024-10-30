<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/adm/upload.css') }}">
    <title>Editar Imagem</title>
</head>

<body background="../../assets/img/ti2.jpg">
    <nav>
        <ul class="menu">
            <li><a href="{{ url('/biblioteca') }}">BIBLIOTECA</a></li>
            <li><a href="{{ route('control') }}">VOLTAR</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1 class="heading">EDITAR REGISTRO</h1>
    </div>

    <div class="cont">
        <form action="{{ route('imagens.update', $imagem->id) }}" method="POST" onsubmit="return confirmarEdicao()">
            @csrf
            <div class="area">
                <label for="nome">NOME</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome', $imagem->nome) }}">
            </div>
            <div>
                <input type="submit" value="SALVAR ALTERAÇÕES">
            </div>
        </form>
    </div>

    <script>
        function confirmarEdicao() {
            return confirm("SALVAR AS ALTERAÇÕES?");
        }
    </script>
</body>

</html>