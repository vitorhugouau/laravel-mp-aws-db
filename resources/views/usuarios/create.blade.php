<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/cadastro/cadastro.css">
</head>
<body background="/img/nova1920.jpg">
   <header class="header">
        <a href="#" class="logo">
            <img src="" alt="">
        </a>
        <nav class="navbar">
        <!-- NADA -->
        </nav>
    </header>

    <h1>TELA DE CADASTRO</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <div class="meio">
        <div id="login">
            <form action="{{ route('usuarios.store') }}" method="POST" id="cadastroForm" class="card">
                @csrf
                <h3>CADASTRO</h3>
                <div class="card-header">
                    <div class="card-content">
                        <div class="card-content-area">
                            <label for="nome">NOME</label>
                            <input type="text" name="name" id="name" required>
                        </div>
                        <div class="card-content-area">
                            <label for="email">E-MAIL</label>
                            <input type="text" id="email" name="email" required>
                        </div>
                        <div class="card-content-area">
                            <label for="senha">SENHA</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="card-content-area">
                            <label for="confirma">CONFIRME A SENHA</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="submit" name="submit" id="submit" value="CADASTRAR">
                    </div>
                    <div class="card-cadastro">
                        <button type="button" class="teste" id="teste" onclick="window.location.href='{{ route('login') }}'">VOLTAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
