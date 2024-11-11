<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Email</title>
    <link rel="stylesheet" href="/css/login/parte2.css"> 
</head>
<body>
    <h1>SEJA BEM-VINDO</h1>

    <div class="meio">
        <div class="form-container">
            <div id="verify">
                <form class="card" method="POST" action="{{ route('verify.code') }}">
                    @csrf
                    <h3>Verifique seu Email</h3>
                    <div class="card-header">
                        <div class="card-content">
                            <div class="card-content-area">
                                <label for="code">Código de Verificação</label>
                                <input type="text" name="code" id="code" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="submit">Verificar Código</button>
                        </div>
                        <div class="card-footer">
                            <p>Não recebeu o código? <a href="{{ route('send.verification.code') }}">Clique aqui para reenviar.</a></p>
                        </div>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Exibe mensagens de sucesso ou erro -->
    <div class="message">
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <p style="color: red;">{{ $errors->first() }}</p>
        @endif
    </div>

</body>
</html>
