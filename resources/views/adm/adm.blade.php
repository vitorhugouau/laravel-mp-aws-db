<!DOCTYPE html>
 <html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/js/fetch.js"></script>

    <link rel="stylesheet" href="/css/adm/adm.css">
</head>
<body background="../../assets/img/ti2.jpg">
    <header class="header">
    </header> 

    <h1>GERENCIADOR DO SISTEMA</h1>

    <div class="meio">
        <div class="form-container">
            <!-- Formulário de login -->
            <div id="login">
                <form id="loginForm" class="card" method="POST">
                    <h3>ADMINISTRADOR</h3>
                    <div class="card-header"> 
                            <div class="card-content">
                                <div class="card-content-area">
                                    <label for="loginusuario">E-MAIL</label>
                                    <input type="text" name="usuario" id="usuario" autocomplete="off">
                                </div>
                                <div class="card-content-area">
                                    <label for="loginSenha">SENHA</label>
                                    <input type="password" name="senha" id="senha" autocomplete="off">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="submit">ENTRAR</button>
                            </div>
                            <div class="card-cadastro">
                                {{-- <form id="logout-form" action="{{ route('biblioteca') }}" method="POST" style="display: none;">
                                    @csrf
                                </form> --}}
                                <button type="button" class="teste" id="teste" onclick="window.location.href='{{ route('biblioteca') }}'" >VOLTAR</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <script>
                document.getElementById("teste").addEventListener("click", function(event) {
                    event.preventDefault(); 
                        window.location.href = "/php/biblioteca.php";          
                });
            </script> --}}
</body>
</html>