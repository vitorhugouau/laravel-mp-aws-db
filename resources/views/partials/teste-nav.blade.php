<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Painel de Controle</title> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/adm/panelcontrol.css">
</head>
<style>
    .icon {
        filter: invert(1);
    }
</style>

<body>
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
    </body>
</html>
