<link rel="stylesheet" href="/css/biblioteca/nav.css">
<link rel="stylesheet" href="/css/biblioteca/nav2.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">


<div class="top-bar">
    Bem-vindo à sua fonte de <strong>imagens</strong> aéreas impressionantes.
</div>


<nav class="nav-01">
    <ul class="menu">
        <li class="logout-3">
            <div class="logout-container02">
                <a href="{{ route('biblioteca') }}">
                    <img src="{{ asset('assets/vitorfilmes2.png') }}" alt="Logout" class="logo-icon-logo">
                </a>
            </div>
        </li>
        <div class="teste">
            <li class="nav-li-02"><a href="{{ route('biblioteca') }}">HOME</a></li>

            <li class="nav-li-02"><a
                    href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">CONTATO</a>
            </li>

            <li class="nav-li-02"><a href="{{ route('clientes.store') }}">SERVIÇOS</a>
            </li>

            @auth

                @if (auth()->user()->role == 'admin')
                    <li class="nav-li-02"><a href="{{ route('adm.login') }}">PAINEL DE CONTROLE</a></li>
                @endif
            </div>
            <li class="logout">
                <div class="logout-container">
                    <img src="{{ asset('assets/usuario.png') }}" alt="Logout" class="logout-icon">
                    @auth
                        <div class="nav-li-01">{{ auth()->user()->name }}</div>
                    @endauth

                    <div class="logout-menu">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-button">SAIR</button>
                        </form>
                    </div>
                </div>
            </li>

            <li class="logout-2">
                <div class="logout-container">
                    <img src="{{ asset('assets/bolsas.png') }}" alt="Logout" class="logout-icon">

                    <div class="logout-menu">
                        <form id="logout-form" action="{{ route('minhas.compras') }}" method="GET">
                            @csrf
                            <button type="submit" class="logout-button">MINHAS COMPRAS</button>
                        </form>
                    </div>
                </div>
            </li>
        @endauth

        @guest
            <li class="nav-li-02"><a href="{{ route('login') }}">LOGIN</a></li>
        @endguest
    </ul>
</nav>

<!-- <div id="menu02">
    <div id="menu02-bar" onclick="menuOnClick()">
        <div id="bar1" class="bar"></div>
        <div id="bar2" class="bar"></div>
        <div id="bar3" class="bar"></div>
    </div>
    <nav class="nav" id="nav">
        <div class="container-geral">
            <button class="close-btn" onclick="menuOnClick()">×</button>
            <div class="navbar">
                <div class="container-top">
                    <div class="logo">
                        @auth
                                                <h1>SEJA BEM-VINDO {{ auth()->user()->name }}</h1>
                                                <br><br>
                        @endauth
                    </div>
                    <div class="panel-content">
                        <ul class="menu-list">
                            <li><img src="{{ asset('assets/portrait.png') }}" alt="Ícone" class="icon"><a
                                    href="{{ route('biblioteca') }}">Home</a></li>
                            <li><img src="{{ asset('assets/picture.png') }}" alt="Ícone" class="icon"><a
                                    href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Contato</a>
                            </li>
                            <li><img src="{{ asset('assets/eye.png') }}" alt="Ícone" class="icon"><a
                                    href="{{ route('clientes.store') }}">Contratar Serviço</a></li>
                            @auth
                                                    <li><img src="{{ asset('assets/users-alt.png') }}" alt="Ícone" class="icon"><a
                                                            href="{{ route('minhas.compras') }}">Minhas Compras</a></li>
                                                    @if (auth()->user()->role == 'admin')
    <li><img src="{{ asset('assets/carrinho-de-compras.png') }}" alt="Ícone" class="icon"><a
                                                                href="{{ route('adm.login') }}">Painel de Controle</a></li>
    @endif
                                                    <li><img src="{{ asset('assets/galeria.png') }}" alt="Ícone" class="icon"><a
                                                            href="{{ route('biblioteca') }}">Biblioteca</a></li>
                                                    <br><br><br>
                                                    <div class="container-bottom">
                                                        <p>
                                                            <a href="#"
                                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                                <i class="bi bi-box-arrow-right"></i> Sair
                                                            </a>
                                                        </p>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                            style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </div>
                            @endauth
                            @guest
                                                    <li><img src="{{ asset('assets/galeria.png') }}" alt="Ícone" class="icon"><a
                                                            href="{{ route('biblioteca') }}">Biblioteca</a></li>
                            @endguest
                            @guest
                                                    <li><img src="{{ asset('assets/galeria.png') }}" alt="Ícone" class="icon"><a
                                                            href="{{ route('adm.login') }}">LOGIN</a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

</div> -->

<div class="menu02-bg" id="menu02-bg"></div>

<script>
    function menuOnClick() {
        document.getElementById("menu02-bar").classList.toggle("change");
        document.getElementById("nav").classList.toggle("change");
        document.getElementById("menu02-bg").classList.toggle("change-bg");
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const topBar = document.querySelector(".top-bar");
        const navBar = document.querySelector(".nav-01");
        let lastScrollPosition = 0;
        let scrollCount = 0;

        window.addEventListener("scroll", () => {
            const currentScrollPosition = window.scrollY;

            if (currentScrollPosition === 0) {
                scrollCount = 0; 
                topBar.style.transform = "translateY(0)"; 
                navBar.style.top = "40px"; 
                return;
            }

            if (currentScrollPosition > lastScrollPosition) {
                scrollCount++;
            } else {
                scrollCount = Math.max(scrollCount - 1, 0); 
            }

            if (scrollCount >= 3) {
                topBar.style.transform = "translateY(-100%)"; 
                navBar.style.top = "0"; 
            } else {
                topBar.style.transform = "translateY(0)"; 
                navBar.style.top = "40px";
            }

            lastScrollPosition = currentScrollPosition;
        });
    });
</script>
