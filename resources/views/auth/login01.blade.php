<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="/css/login/parte.css">
</head>

<body>
    <h1>SEJA BEM-VINDO</h1>

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
                                <input type="email" name="email" id="email" autocomplete="off"
                                    value="admin@teste.com" required placeholder="Digite sua email">
                            </div>
                            <div class="card-content-area">
                                <label for="password">SENHA</label>
                                <input type="password" name="password" id="password" autocomplete="off" required placeholder="Digite sua senha">
                                @error('email')
                                    <span style="font-size:11px; color:red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="password">
                                <a href="{{ route('password.request') }}">
                                    Esqueceu sua senha? Redefina aqui.</a>
                            </p>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="submit">ENTRAR</button>
                        </div>
                        <div class="card-cadastro2">
                            <button type="button" class="teste2" id="teste2"
                                data-url="{{ route('biblioteca') }}">VOLTAR</button>
                        </div>
                        <div class="card-footer">
                            <div class="conta">
                                <p>Não tem conta? <a href="{{ route('usuarios.create') }}">Clique aqui para se cadastrar.</a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    document.getElementById("teste2").onclick = function() {
        window.location.href = this.getAttribute("data-url");
    }
</script>
