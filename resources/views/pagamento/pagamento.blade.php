<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/biblioteca/type1.css">
    <title>Pagamento</title>
</head>

<body>
    @include('partials.nav')

    <br><br><br>
    <div class="main-container">
        <div class="container">
            <div class="container-image">
                <div class="image-container">
                    <div
                        style="background-image: url('{{ $imagem->url_marca_dagua }}'); background-size: cover; background-position: center; width: auto; height: 300px; display: flex; align-items: center; justify-content: flex-end; flex-direction: column; user-select: none !important">
                        <div
                            style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 40rem; height: 40px;">
                            <div class="compra">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div id="paymentModal" style="display: none;">
            <div class="modal-content">
                <span id="closeModal" style="cursor: pointer;">&times;</span>
                <h2>Pagamento via Pix</h2>
                <div id="qrCodeContainer"></div>
                <button id="cancelPayment">Cancelar</button>
                <button id="confirmPayment">Confirmar Pagamento</button>
            </div>
        </div> --}}


        <form action="{{ route('mercadopago.create') }}" method="post" id="paymentForm">
            @csrf
            <input type="hidden" name="imagem_id" value="{{ $imagem->id }}">
            <div class="container1">
                <h2>Área de Confirmação</h2>
                <div class="planos">
                    <label>
                        <input type="radio" name="valor" value="{{ $imagem->valor }}" style="margin-right: 8px;">
                        R$ {{ number_format($imagem->valor, 2, ',', '.') }} por esta imagem<br>
                    </label>
                    <strong>→ Confirme Clicando no Botão Abaixo</strong>
                </div>

                <!-- Botão Pix alterado para link -->
                <a href="{{ route('mercadopago.pix', ['imagem_id' => $imagem->id]) }}">
                    <button type="button" class="button" id="pixButton">Pagamento via Pix</button>
                </a>

                <br><br>
                <button class="button" onclick="checkSelection()">Pagamento via Cartão</button>

                <div class="info">
                    Inclui a nossa <a href="#">licença padrão</a>.<br>
                </div>
            </div>
        </form>




        <script>
            function checkSelection() {
                const radioChecked = document.querySelector('input[name="valor"]:checked');
                if (!radioChecked) {
                    alert("Por favor, selecione um valor antes de continuar.");
                } else {
                    document.getElementById('paymentForm').submit();
                }
            }
        </script>

        <script>
            document.getElementById('paymentForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.init_point) {
                            window.location.href = data.init_point;
                        } else {
                            alert(data.error || 'Erro ao processar o pagamento.');
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            });
        </script>

        {{-- -------------------------------------------------------------------------------------------------------------------------------------------------- --}}

       

        {{-- ---------------------------------------------------- --}}
        <script>
            document.getElementById('sair').addEventListener('click', function() {
                document.getElementById('logout-form').submit();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === "F12" || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
                    e.preventDefault();
                }
            });

            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
        </script>
</body>

</html>
