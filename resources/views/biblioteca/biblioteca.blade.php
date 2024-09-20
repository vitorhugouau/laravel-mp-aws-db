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
        </li>
        <li><a href="album.php">ÁLBUM</a>
        </li>
        <li><a href="#">CONTATO</a>
            <ul><a href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">INSTAGRAM</a></ul>
        </li>
        <li><a href="#">SERVIÇOS</a>
            <ul>
                <li><a href="cliente/serviço.php">CONTRATAR SERVIÇO</a></li>
            </ul>
        </li>
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
<style>
    .compra{
        left: 20px;
        align-items: center;
        justify-content: center;
        display: flex;
        /* gap: 15px; */
        padding: 10px;
    }
    #boton{
        background-color: rgb(243, 0, 0);
        color: rgb(255, 255, 255);
        border: 5px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        font-size: 14px;
        width: 150px;
        height: 20px;
        left: 20px;
        align-items: center;
        justify-content: center;
        display: flex;

    }
    #boton:hover{
        transform: scale(1.3);
    }
</style>
    <div class="container">
        <h1 class="heading">BIBLIOTECA DE FOTOS</h1>
        <br><br>
        <div class="container-image">
            <div class="image" data-title="cidade toda">
                <img src="../../assets/img/imgnovas/DC0BA660DD51D7CF60947E38295486DD.jpeg" alt="" oncontextmenu="bloquearBotaoDireito(event)">
                <h3>PRAIA DE IACANGA</h3>
                <div class="compra">
                    <button id="boton" onclick="window.location.href='{{ route('teste') }}'" >COMPRAR IMAGEM</button>
                </div>
            </div>
            <div class="image" data-title="manha">
                <img src="../../assets/img/imgnovas/praia.JPG" alt="">
                <h3>PONTE DA PRAIA</h3>
                <div class="compra">
                    <button id="boton" onclick="window.location.href='{{ route('teste') }}'" >COMPRAR IMAGEM</button>
                </div>
            </div>
            <div class="image" data-title="praia">
                <img src="../../assets/img/imgnovas/rio.JPG" alt="">
                <h3>NASCER DO SOL</h3>
                <div class="compra">
                    <button id="boton" onclick="window.location.href='{{ route('teste') }}'" >COMPRAR IMAGEM</button>
                </div>
            </div>
        </div>
    </div>
        
        {{-- <input type="text" placeholder="Pesquisar Imagem" id="search-box"> --}}
    
{{-- fotos aqui --}}
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
            function bloquearBotaoDireito(event){
                event.preventDefault();
            }
    </script>
    
</body>
</html>