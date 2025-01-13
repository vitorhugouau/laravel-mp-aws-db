<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/css/login/parte-futuro.css">
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

    <i class="bi bi-person" id="logo-profile"></i>
    <div class="meio">
        <div class="form-container">
            <div id="login">
                <form id="loginForm" class="card" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card-header">

                        <div class="flex-column">
                            <label style="color: white">Email</label>
                        </div>
                        <div class="inputForm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20"
                                fill="white">
                                <g data-name="Layer 3" id="Layer_3">
                                    <path
                                        d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z">
                                    </path>
                                </g>
                            </svg>
                            <input placeholder="Insira seu email" class="input" type="text" name="email" required>
                        </div>

                        <div class="flex-column">
                            <label style="color: white">Senha</label>
                        </div>
                        <div class="inputForm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512"
                                height="20" fill="white">
                                <path
                                    d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0">
                                </path>
                                <path
                                    d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0">
                                </path>
                            </svg>
                            <input placeholder="Insira sua senha" class="input" type="password" name="password"
                                required>
                        </div>
                        @error('email')
                            <span style="font-size:11px; color:red;">{{ $message }}</span>
                        @enderror
                        <p class="p">Não tem uma conta? <a href="{{ route('usuarios.create') }}"><span
                                    class="span">Cadastre-se</span></a></p>
                    </div>

                    <div class="card-footer">
                        <p class="password">
                            <a href="{{ route('password.request') }}">
                                Esqueceu sua senha? Redefina aqui.</a>
                        </p>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="submit" id="btn-entrar">ENTRAR</button>
                    </div>
                </form>
                <div class="card-cadastro2">
                    <button type="button" class="teste2" id="teste2"
                        data-url="{{ route('biblioteca') }}">VOLTAR</button>
                </div>
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
</body>

<script src="particles.js"></script>

<script>
    document.getElementById("teste2").onclick = function() {
        window.location.href = this.getAttribute("data-url");
    }
</script>

<script>
    particlesJS.load('particles-js', 'particles.json', function() {
        console.log('particles.js loaded');
    });
</script>

</html>
