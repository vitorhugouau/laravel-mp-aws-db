<nav>
    <ul class="menu">
        @auth
            <li style="right:320px; color:white">Seja Bem-Vindo, {{ auth()->user()->name }}</li>
        @endauth
        <li><a href="{{ route('biblioteca') }}">HOME</a></li>

        <li><a href="#">CONTATO</a>
            <ul>
                <li><a
                        href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">INSTAGRAM</a>
                </li>
            </ul>
        </li>

        <li><a href="#">SERVIÇOS</a>
            <ul>
                <li><a href="{{ route('clientes.store') }}">CONTRATAR SERVIÇO</a></li>
            </ul>
        </li>

        @auth
            <li><a href="{{ route('minhas.compras') }}">MINHAS COMPRAS</a></li>

            @if (auth()->user()->role == 'admin')
                <li><a href="{{ route('adm.login') }}">PAINEL DE CONTROLE</a></li>
            @endif

            <li class="logout">
                <div class="card">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" class="submit" id="sair"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">SAIR</button>
                </div>
            </li>

        @endauth

        @guest
            <li><a href="{{ route('adm.login') }}">LOGIN</a></li>
        @endguest
    </ul>
</nav>
