<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/biblioteca/type.css">
    <title>Pagamento</title>
    <style>
        .payment-container {
            width: 350px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            font-family: Arial, sans-serif;
        }

        .payment-header {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }

        .payment-methods label {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }

        .payment-methods input {
            margin-left: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
        }

        .form-row input {
            width: 54%;
        }

        .submit-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }

        /* Esconde os formulários por padrão */
        
    </style>
    <style>
        *{
            user-select: none;
        }
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
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container-image {
            flex-basis: 100%; 
            display: block;
        }
        .payment-container{
            align-items: center;
            justify-content: center;
            margin-right: 10%;
            flex-basis: 50%;
        }

    </style>
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
    <br><br><br>
<div class="main-container">
    <div class="container">
        <div class="container-image" >
            <div class="image-container">
                <div style="background-image: url('data:image/jpeg;base64,{{ $imagem->imagem }}'); background-size: cover; background-position: center; width: auto; height: 20rem; display: flex; align-items: center; justify-content: flex-end; flex-direction: column; user-select: none !important" class="image" data-title="{{ $imagem->nome }}">
                    <!-- Exibe a imagem armazenada no banco de dados em Base64 -->
                    <img id="{{ $imagem->id }}" class="imagemaaa" src="{{ asset("assets/image.png") }}" style="height: 250px !important; width: 50% !important; opacity: 0.6 !important; user-select: none">
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: white; width: 40rem; height: 40px; " >
                        <h3>{{ $imagem->nome }}</h3>
                        <div class="compra">
                            <!-- <button id="boton" onclick="window.location.href='{{ route('teste') }}'">COMPRAR IMAGEM</button> -->
                            {{-- <button id="boton" onclick="buyImage({{ $imagem->id }})">COMPRAR IMAGEM</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="payment-container">
        <div class="payment-header">Selecione o seu Email</div>

        <!-- Métodos de pagamento -->
        <!-- Formulário de pagamento por Pix -->
        <div id="pix-form" class="payment-form">
            <form method="POST" action="{{ route('adm.login.post') }}"> 
                {{-- action="{{ route('finalizarPagamentoPix', ['imagem' => $imagem->id]) }}" --}}
                @csrf
                <div class="form-group">
                    <label for="pix-cpf">Email</label>
                    <input type="email" id="pix-cpf" name="pix-cpf" placeholder="Informe seu Email" required>
                </div>

                <button type="submit" class="submit-button" id="boton" onclick="buyImage({{ $imagem->id }})" >Efetuar pagamento </button>
            </form>
        </div>
    </div>
</div>
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
