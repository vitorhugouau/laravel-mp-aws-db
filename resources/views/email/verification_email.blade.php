<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Email</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/login/parte-futuro-email.css">
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
    {{-- <div id="particles-js"></div> --}}

    <div class="meio">
        <div class="form-container">
            <div id="login">
                <form class="card" method="POST" action="{{ route('verify.code') }}">
                    @csrf

                    <h3>VERIFIQUE SEU EMAIL</h3>
                    <div class="card-header">
                        <div class="flex-column">
                            <label style="color: white">Código de Verificação</label>
                        </div>
                        <div class="inputForm">
                            <input class="input" type="text" name="code" id="code" required>
                        </div>
                        <div class="message">
                            @if (session('success'))
                                <p style="color: green; font-size: 11px;">{{ session('success') }}</p>
                            @endif
                            @if ($errors->any())
                                <p style="color: red; font-size: 14px;">{{ $errors->first() }}</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="submit" id="btn-entrar" >VERIFICAR CÓDIGO</button>
                        </div>
                    </div>
                </form>
                <div class="card-cadastro2">
                    <button type="button" class="teste2" id="teste2" data-url="{{ route('login') }}">VOLTAR</button>
                </div>
                <div class="card-footer">
                    <p style="color: white; font-size:12px">Não recebeu o código? <a href="{{ route('send.verification.code') }}" style="color: lightblue;">Clique aqui para reenviar.</a></p>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">

        <div class="footer-logo">
            <img src="{{ asset('assets/vitorfilmes2.png') }}" alt="Logout" class="logo-footer">
        </div>
        <div class="footer-copyright">
            © 2024 Company, Inc
        </div>
    </footer>

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
