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
        <li><a href="#">SOBRE</a>
            <ul>
                <li><a href="equipamento.php">EQUIPAMENTOS USADOS</a></li>
            </ul>
        </li>
        <li><a href="album.php">ÁLBUM</a>
        </li>
        <li><a href="#">CONTATO</a>
            <ul><a href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">INSTAGRAM</a></ul>
        </li>
        <li><a href="artistas.php">ARTISTAS</a>

        <li><a href="#">SERVIÇOS</a>
            <ul>
                <li><a href="cliente/serviço.php">CONTRATAR SERVIÇO</a></li>
            </ul>
        </li>
        <li><a href="{{ route('adm') }}">PAINEL DE CONTROLE</a>
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
        <h1 class="heading">BIBLIOTECA DE FOTOS</h1>

        {{-- <input type="text" placeholder="Pesquisar Imagem" id="search-box"> --}}
    
{{-- fotos aqui --}}
</div>
    {{-- <script src="/js/main.js"></script>
    <script>
        document.getElementById("sair").addEventListener("click", function(event) {
            event.preventDefault(); 
                window.location.href = "logout.php";          
        });
    </script> --}}
    <script>
        document.getElementById('sair').addEventListener('click', function() {
                document.getElementById('logout-form').submit();
            });

    </script>
    
</body>
</html>