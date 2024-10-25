<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/biblioteca/type1.css">
    <title>Pagamento</title>
</head>
<body>
    <nav>
        <ul class="menu">
            <li><a href="{{ route('biblioteca') }}">HOME</a></li> 
            {{-- <li><a href="#">SOBRE</a> --}}
            </li>
            {{-- <li><a href="album.php">ÁLBUM</a> --}}
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
    <br><br><br>
<div class="main-container">
    <div class="container">
        <div class="container-image" >
            <div class="image-container">
                <div style="background-image: url('data:image/jpeg;base64,{{ $imagem->imagem }}'); background-size: cover; background-position: center; width: auto; height: 20rem; display: flex; align-items: center; justify-content: flex-end; flex-direction: column; user-select: none !important; border-radius: 10px; " class="image" data-title="{{ $imagem->nome }}">
                    <!-- Exibe a imagem armazenada no banco de dados em Base64 -->
                    <img id="{{ $imagem->id }}" class="imagemaaa" src="{{ asset("assets/image.png") }}" style="height: 200px !important; width: 50% !important; opacity: 0.6 !important; user-select: none">
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 40rem; height: 40px; " >
                        
                        {{-- <h3 style="color: aliceblue; margin-top:20px;">{{ $imagem->nome }}</h3> --}}
                        <div class="compra">
                            <!-- <button id="boton" onclick="window.location.href='{{ route('teste') }}'">COMPRAR IMAGEM</button> -->
                            {{-- <button id="boton" onclick="buyImage({{ $imagem->id }})">COMPRAR IMAGEM</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container1">
        <h2>Área de Confirmação</h2>
        <p></p>
        
        <div class="planos">
            <label>
                <input type="radio" name="plano" value="125">
                R$ 125 por esta imagem<br>
            </label>
            <strong style="">-> Confirme Clicando no Botão Abaixo</strong>
            
        </div>
        
        <button class="button" onclick="buyImage({{ $imagem->id }})">Continuar compra</button>
        {{-- <a href="#" class="ver-planos">Ver planos e preços</a> --}}
        
        <div class="info">
            Inclui a nossa <a href="#">licença padrão</a>.<br>
        </div>
    </div>
</div>
<script>
    const buyImage = (id) => {
    window.location.href = `/mercadopago/create`;
};
</script>
    <script>
        
        const buyImage = (id) => {
        const imagemComprada = document.getElementById(id);
        imagemComprada.style.display = 'none';
    };
    </script>

    <script>
        document.addEventListener('keydown',
            function(e){
                if (e.key === "F12" || (e.ctrlKey && 
            e.shiftKey && e.key === 'I' )) {
                e.preventDefault();
            }
            }
        );

        document.addEventListener('contextmenu',
            function (e){
                e.preventDefault();
            }
        );
    </script>
  
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
