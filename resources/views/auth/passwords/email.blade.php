<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar Senha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/login/parte-futuro-resetar.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #000;
            overflow: hidden;
            z-index: -1;
        }
    </style>
</head>

<body class="body">
    <div id="particles-js"></div>

    <div class="meio">
        <div class="form-container">
            <div id="login">
                <form class="loginForm" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <h3>RESETAR SENHA</h3>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-header">
                        <div class="flex-column">
                            <label style="color: white">Email</label>
                        </div>
                        <div class="inputForm">
                            <input class="input" type="email" name="email" id="email"
                                value="{{ old('email') }}" required>
                        </div>
                        @if ($errors->any())
                            <p style="color: red; font-size: 14px;">{{ $errors->first() }}</p>
                        @endif

                        <div class="card-footer">
                            <button type="submit" class="submit" id="btn-entrar">Enviar Link de Redefinição</button>
                        </div>
                    </div>
                </form>
                <div class="card-cadastro2">
                    <button type="button" class="teste2" id="teste2"
                        data-url="{{ route('login') }}">VOLTAR</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 100
                },
                size: {
                    value: 3
                },
                move: {
                    speed: 1
                },
                shape: {
                    type: "circle"
                },
                line_linked: {
                    enable: true,
                    distance: 150
                }
            }
        });
    </script>

    <script>
        document.getElementById("teste2").onclick = function() {
            window.location.href = this.getAttribute("data-url");
        }
    </script>
</body>

</html>
