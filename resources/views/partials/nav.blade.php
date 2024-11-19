<link rel="stylesheet" href="/css/biblioteca/nav.css">
<link rel="stylesheet" href="/css/biblioteca/nav2.css">

<nav class="nav-01">
    <ul class="menu">
        @auth
            <li class="nav-li-01">Seja Bem-Vindo, {{ auth()->user()->name }}</li>
        @endauth
        
        <li class="nav-li-02"><a href="{{ route('biblioteca') }}">HOME</a></li>

        <li class="nav-li-02"><a href="#">CONTATO</a>
            <ul>
                <li><a href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">INSTAGRAM</a>
                </li>
            </ul>
        </li>

        <li class="nav-li-02"><a href="#">SERVIÇOS</a>
            <ul>
                <li><a href="{{ route('clientes.store') }}">CONTRATAR SERVIÇO</a></li>
            </ul>
        </li>

        @auth
            <li class="nav-li-02"><a href="{{ route('minhas.compras') }}">MINHAS COMPRAS</a></li>

            @if (auth()->user()->role == 'admin')
                <li class="nav-li-02"><a href="{{ route('adm.login') }}">PAINEL DE CONTROLE</a></li>
            @endif

            <li class="logout">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="submit" id="sair">SAIR</button>
                </form>
            </li>
            
        @endauth

        @guest
            <li class="nav-li-02"><a href="{{ route('adm.login') }}">LOGIN</a></li>
        @endguest
    </ul>
</nav>

<div id="menu">
    <div id="menu-bar" onclick="menuOnClick()">
      <div id="bar1" class="bar"></div>
      <div id="bar2" class="bar"></div>
      <div id="bar3" class="bar"></div>
    </div>
    <nav class="nav" id="nav">
        <div class="container-geral">
            <div class="navbar">
                <div class="container-top">
                    <div class="logo">
                        <h1>Seja Bem-Vindo, {{ auth()->user()->name }}</h1>
                    </div>
                    <div class="panel-content">
                        <ul>
                            <li><img src="{{ asset('assets/portrait.png') }}" alt="Ícone" class="icon"><a
                                    href="{{ route('biblioteca') }}">Home</a></li>

                            <li><img src="{{ asset('assets/picture.png') }}" alt="Ícone" class="icon"><a
                                    href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Contato</a></li>

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

                                <li class="logout">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="submit" id="sair">SAIR</button>
                                    </form>
                                </li>
                            @endauth       
                            @guest    
                                <li><img src="{{ asset('assets/galeria.png') }}" alt="Ícone" class="icon"><a
                                href="{{ route('biblioteca') }}">Biblioteca</a></li>

                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav> 
</div>

<div class="menu-bg" id="menu-bg"></div>
</nav>

<script>
    function menuOnClick() {
    document.getElementById("menu-bar").classList.toggle("change");
    document.getElementById("nav").classList.toggle("change");
    document.getElementById("menu-bg").classList.toggle("change-bg");
}
</script>