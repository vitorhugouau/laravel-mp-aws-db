<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar Senha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/login/parte-futuro-resetar2.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js/2.0.0/particles.min.js"></script>
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
                <form class="card" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <h3 style="color: white;">RESETAR SENHA</h3>
                    <div class="card-header">

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="flex-column">
                            <label for="email" style="color: white;">E-mail</label>
                        </div>
                        <div class="inputForm">
                            <input class="input" type="email" name="email" id="email" required
                                placeholder="Digite seu e-mail" value="{{ $email }}" readonly>
                        </div>
                        
                        <div class="flex-column">
                            <label for="password" style="color: white;">Nova Senha</label>
                        </div>
                        <div class="inputForm">
                            <input class="input" type="password" name="password" id="password" required
                                placeholder="Digite sua nova senha">
                        </div>
                        <div class="flex-column">
                            <label for="password_confirmation" style="color: white;">Confirmar Senha</label>
                        </div>
                        <div class="inputForm">
                            <input class="input" type="password" name="password_confirmation"
                                id="password_confirmation" required placeholder="Confirme sua nova senha">
                        </div>
                    </div>

                    <div class="message">
                        @if (session('success'))
                            <p style="color: green;">{{ session('success') }}</p>
                        @endif

                        @if ($errors->any())
                            <p style="color: red;">{{ $errors->first() }}</p>
                        @endif
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="submit" id="btn-entrar">RESETAR SENHA</button>
                    </div>

                </form>
                <div class="card-cadastro2">
                    <button type="button" class="teste2" id="teste2" data-url="{{ route('login') }}">VOLTAR</button>
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

        document.getElementById("teste2").onclick = function() {
            window.location.href = this.getAttribute("data-url");
        };
    </script>
</body>

</html>
