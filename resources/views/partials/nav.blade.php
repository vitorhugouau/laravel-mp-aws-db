<link rel="stylesheet" href="/css/biblioteca/nav.css">

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
