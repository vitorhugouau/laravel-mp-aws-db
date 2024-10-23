<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/biblioteca/type.css">
    <title>Pagamento</title>
</head>
<body background="../../assets/img/rio.jpg">
    <nav>
        <!-- Reaproveita o menu anterior -->
        <ul class="menu">
            <li><a href="#">HOME</a></li>
            <li><a href="#">SOBRE</a></li>
            <li><a href="album.php">ÁLBUM</a></li>
            <li><a href="#">CONTATO</a></li>
            <li><a href="#">SERVIÇOS</a></li>
            <li><a href="{{ route('adm.login') }}">PAINEL DE CONTROLE</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1 class="heading">Pagamento da Imagem</h1>
        <br><br>

        <!-- Mostra a imagem selecionada -->
        {{-- <div class="image-container">
            <div style="background-image: url('data:image/jpeg;base64,{{ $imagem->imagem }}'); background-size: cover; background-position: center; width: auto; height: 300px; display: flex; align-items: center; justify-content: flex-end; flex-direction: column;" class="image">
                <img id="{{ $imagem->id }}" src="data:image/jpeg;base64,{{ $imagem->imagem }}" alt="{{ $imagem->nome }}" style="width: 60%; opacity: 0.6;">
                <div style="background: white; width: 100%; text-align: center;">
                    <h3>{{ $imagem->nome }}</h3>
                </div>
            </div>
        </div> --}}
        
        <!-- Formulário de pagamento -->
        <form method="POST" action="{{ route('finalizarPagamento', ['imagem' => $imagem->id]) }}">
            @csrf
            <div class="form-group">
                <label for="card-number">Número do Cartão</label>
                <input type="text" id="card-number" name="card-number" required>
            </div>
            <div class="form-group">
                <label for="expiration">Data de Expiração</label>
                <input type="text" id="expiration" name="expiration" placeholder="MM/AA" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>
            </div>
            <div class="form-group">
                <button type="submit" id="boton">Finalizar Pagamento</button>
            </div>
        </form>
    </div>

    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-size: 16px;
        }
        input {
            padding: 10px;
            font-size: 14px;
            width: 100%;
            max-width: 300px;
            margin-bottom: 10px;
        }
        #boton {
            background-color: rgb(243, 0, 0);
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        #boton:hover {
            transform: scale(1.1);
        }
    </style>
</body>
</html>
