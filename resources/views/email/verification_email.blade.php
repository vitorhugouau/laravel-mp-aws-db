<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Email</title>
    <link rel="stylesheet" href="/css/login/parte4-codigo.css"> 
</head>
<body>
    <h1>SEJA BEM-VINDO</h1>

    <div class="meio">
        <div class="form-container">
            <div id="verify">
                <form class="card" method="POST" action="{{ route('verify.code') }}">
                    @csrf
                    <h3>VERIFIQUE SEU EMAIL</h3>
                    <div class="card-header">
                        <div class="card-content">
                            <div class="card-content-area">
                                <label for="code">Código de Verificação</label>
                                <input type="text" name="code" id="code" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="submit">VERIFICAR CÓDIGO</button>
                        </div>
                        <div class="card-cadastro2">
                            <button type="button" class="teste2" id="teste2" data-url="{{ route('login') }}">VOLTAR</button>
                       </div>
                        <div class="card-footer">
                            <p>Não recebeu o código? <a href="{{ route('send.verification.code') }}">Clique aqui para reenviar.</a></p>
                        </div>
                        <div class="message">
                            @if (session('success'))
                                <p style="color: rgb(255, 0, 0);">{{ session('success') }}</p>
                            @endif
                    
                            @if ($errors->any())
                                <p style="color: red;">{{ $errors->first() }}</p>
                            @endif
                        </div>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        
        document.getElementById("teste2").onclick = function() {
            window.location.href = this.getAttribute("data-url");
        }
    </script>
    

</body>
</html>
