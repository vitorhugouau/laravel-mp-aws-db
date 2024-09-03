<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Importando scripts e estilos -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/js/fetch.js"></script>
    <link rel="stylesheet" href="/css/login/parte.css">
</head>
<body>
    <h1>SEJA BEM-VINDO</h1>

    <!-- Exibição de erros globais -->
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Conteúdo principal do formulário de login -->
    <div class="meio">
        <div class="form-container">
            <div id="login">
                <form id="loginForm" class="card" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3>LOGIN</h3>
                    <div class="card-header">
                        <div class="card-content">
                            <div class="card-content-area">
                                <label for="email">E-MAIL</label>
                                <input type="email" name="email" id="email" autocomplete="off" value="teste@teste" required>
                                @error('email')
                                    <span style="font-size:11px; color:red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="card-content-area">
                                <label for="password">SENHA</label>
                                <input type="password" name="password" id="password" autocomplete="off" required>
                                @error('password')
                                    <span style="font-size:11px; color:red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="submit">ENTRAR</button>
                        </div>
                        <div class="card-cadastro">
                            <button type="button" class="teste" id="teste" onclick="window.location.href='{{ route('usuarios.create') }}'">FAÇA SEU CADASTRO</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
