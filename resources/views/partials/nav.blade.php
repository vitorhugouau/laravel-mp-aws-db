<nav>
    <ul class="menu">
        <li><a href="{{route ('biblioteca')}}">HOME</a></li>
        
        </li>
        {{-- <li><a href="album.php">ÁLBUM</a>
        </li> --}}
        <li><a href="#">CONTATO</a>
            <ul><a
                    href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">INSTAGRAM</a>
            </ul>
        </li>
        <li><a href="#">SERVIÇOS</a>
            <ul>
                <li><a href="{{ route('clientes.store') }}">CONTRATAR SERVIÇO</a></li>
            </ul>
        </li>
        <li><a href="{{route ('minhas.compras')}}">MINHAS COMPRAS</a>
        <li><a href="{{ route('adm.login') }}">PAINEL DE CONTROLE</a>
        <li class="logout">
            <div class="card">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button type="button" class="submit" id="sair">SAIR</button>
            </div>
        </li>
    </ul>
</nav>