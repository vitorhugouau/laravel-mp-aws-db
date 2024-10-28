<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gerenciador do Sistema</title>

    <!-- Axios para requisições AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Arquivo de estilo personalizado -->
    <link rel="stylesheet" href="/css/adm/adm.css">
</head>

<body background="../../assets/img/ti2.jpg">
    <header class="header">
        <!-- Seção de cabeçalho (vazia por enquanto) -->
    </header>

    <h1>GERENCIADOR DO SISTEMA</h1>

    <div class="meio">
        <div class="form-container">
            <!-- Formulário de login -->
            <div id="login">
                <form id="loginForm" class="card" method="POST" action="{{ route('adm.login.post') }}">
                    @csrf <!-- CSRF Token obrigatório para formulários POST no Laravel -->

                    <h3>ADMINISTRADOR</h3>
                    <div class="card-header">
                        <div class="card-content">
                            <div class="card-content-area">
                                <label for="email">E-MAIL</label>
                                <input type="text" name="email" id="email" autocomplete="off" value="vitor@hugo">
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
                            <button type="button" class="teste" id="teste"
                                onclick="window.location.href='{{ route('biblioteca') }}'">VOLTAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>