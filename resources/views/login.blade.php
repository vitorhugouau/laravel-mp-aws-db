@extends('master')

@section('content')
    

<!DOCTYPE html>
 <html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/js/fetch.js"></script>

    <link rel="stylesheet" href="css/login/parte.css">
</head>
<body>
    <header class="header">
        <a href="{{route('home')}}">HOME</a>
    </header>

    <h1>SEJA BEM-VINDO</h1>

    <div class="meio">
        <div class="form-container">
            <!-- Formulário de login -->
            <div id="login">
                <form id="loginForm" class="card" method="POST" action="{{ route('login.store')}}">
                    @csrf
                    <h3>LOGIN</h3>
                    <div class="card-header">
                            <div class="card-content">
                                <div class="card-content-area">
                                    <label for="loginEmail">E-MAIL</label>
                                    <input type="text" name="email" id="email" autocomplete="off">
                                    @error('email')
                                        <span style="font-size:11px">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="card-content-area">
                                    <label for="loginSenha">SENHA</label>
                                    <input type="password" name="password" id="senha" autocomplete="off">
                                    @error('password')
                                    <span style="font-size:11px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="submit">ENTRAR</button>
                            </div>
                            <div class="card-cadastro">
                                <button type="submit" class="teste" id="teste">FAÇA SEU CADASTRO</button>
                            </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("teste").addEventListener("click", function(event) {
            event.preventDefault();
                window.location.href = "/php/cadastro.php";
        });
    </script>
</body>
</html>
@endsection