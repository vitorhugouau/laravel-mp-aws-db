<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar Senha</title>
    <link rel="stylesheet" href="/css/login/parte2.css">
</head>

<body>
    <h1>SEJA BEM-VINDO</h1>

    <div class="meio">
        <div class="form-container">
            <div id="reset-password">
                <form class="card" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <h3>RESETAR SENHA</h3>
                    <div class="card-header">
                        <div class="card-content">
                            <!-- Campo de token oculto -->
                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Campo de e-mail -->
                            <div class="card-content-area">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" id="email" required
                                    placeholder="Digite seu e-mail" value="{{ $email }}">
                            </div>

                            <!-- Campo de nova senha -->
                            <div class="card-content-area">
                                <label for="password">Nova Senha</label>
                                <input type="password" name="password" id="password" required
                                    placeholder="Digite sua nova senha">
                            </div>

                            <!-- Campo de confirmação de senha -->
                            <div class="card-content-area">
                                <label for="password_confirmation">Confirmar Senha</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    placeholder="Confirme sua nova senha">
                            </div>
                        </div>

                        <!-- Mensagens de sucesso ou erro -->
                        <div class="message">
                            @if (session('success'))
                                <p style="color: green;">{{ session('success') }}</p>
                            @endif

                            @if ($errors->any())
                                <p style="color: red;">{{ $errors->first() }}</p>
                            @endif
                        </div>

                        <!-- Botões de ações -->
                        <div class="card-footer">
                            <button type="submit" class="submit">RESETAR SENHA</button>
                        </div>

                        <div class="card-cadastro2">
                            <button type="button" class="teste2" id="teste2"
                                data-url="{{ route('login') }}">VOLTAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Redirecionar ao clicar no botão "Voltar"
        document.getElementById("teste2").onclick = function() {
            window.location.href = this.getAttribute("data-url");
        };
    </script>
</body>

</html>
