<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Aprovado</title>
    <link rel="stylesheet" href="/css/biblioteca/type2.css">
    <link rel="stylesheet" href="/css/biblioteca/type-sucess.css">
</head>
@include('partials.nav')

<body>
    <div class="payment-page">
        <div class="payment-options">
            <h1>Pagamento Aprovado</h1>

            <p><strong>ID do Pagamento:</strong> {{ $payment_id }}</p>
            <p><strong>Status do Pagamento:</strong> {{ $status }}</p>
        </div>
        <div class="purchase-summary">
            @if ($imagem)
                <h3>Imagem Comprada:</h3>
                <div class="main-container">
                    <div class="container">
                        <div class="container-image">
                            <div class="image-container">
                                <div
                                    style="background-image: url('{{ $imagem->url_original }}'); background-size: cover; background-position: center; width: 690px; height: 387px; display: flex; align-items: center; justify-content: flex-end; flex-direction: column; user-select: none !important;border-radius:4%">
                                    <div
                                        style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 40rem; height: 40px;">
                                        <div class="compra">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p>Informações da imagem não disponíveis.</p>
            @endif

            <div class="button-container">
                <button class="btn btn-primary" onclick="downloadImage()">Baixar Imagem</button>
                <a href="{{ route('biblioteca') }}" class="btn btn-primary">Voltar à Página Inicial</a>
            </div>


        </div>
    </div>
    <script>
        if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
            if (sessionStorage.getItem('formSubmitted')) {

                window.location.href = "{{ route('minhas.compras') }}";
            } else {
                sessionStorage.setItem('formSubmitted', true);
            }
        }
    </script>
    <script>
        const imagemElement = document.getElementById('imagemkk');
        const imagemUrl = imagemElement.style.backgroundImage.slice(5, -2);

        function downloadImage() {
            const link = document.createElement('a');
            link.href = imagemUrl;
            link.download = 'imagem.jpg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
    <style>
        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: bold;
            color: #fff;
            background-color: #000000;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            width: 250px;
            margin: 3px;
        }

        .btn:hover {
            background-color: #ffffff;
            color: #000000;
            transform: translateY(-2px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            background-color: #1c5d8b;
            transform: translateY(0px);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</body>

</html>
