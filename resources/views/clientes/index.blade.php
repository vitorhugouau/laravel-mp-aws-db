<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/biblioteca/type.css">
    <title>Document</title>
    
</head>
<body background="../../assets/img/rio.jpg">
<nav>
    <ul class="menu">
        <li><a href="#">HOME</a></li> 
        {{-- <li><a href="#">SOBRE</a> --}}
        </li>
        {{-- <li><a href="album.php">ÁLBUM</a>
        </li> --}}
        <li><a href="#">CONTATO</a>
            <ul><a href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">INSTAGRAM</a></ul>
        </li>
        <!-- <li><a href="#">SERVIÇOS</a>
            <ul>
                <li><a href="cliente/serviço.php">CONTRATAR SERVIÇO</a></li>
            </ul>
        </li> -->
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

<div class="container">
    <h1>Editar Cliente</h1>
    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $cliente->nome }}">
        </div>
        <!-- Repita o mesmo para os outros campos -->
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>

  <script>
        document.getElementById('sair').addEventListener('click', function() {
                document.getElementById('logout-form').submit();
            });
            function bloquearBotaoDireito(event){
                event.preventDefault();
            }
    </script>
    
    
</body>
</html>