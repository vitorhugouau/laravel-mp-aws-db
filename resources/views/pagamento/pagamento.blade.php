<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/biblioteca/type1.css">
    <link rel="stylesheet" href="/css/biblioteca/type-pagamento.css">
    <title>Pagamento</title>
</head>

<body>
    @include('partials.nav')

    <br><br><br>
    {{-- <div class="main-container">
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
        </div> --}}

        {{-- <div id="paymentModal" style="display: none;">
            <div class="modal-content">
                <span id="closeModal" style="cursor: pointer;">&times;</span>
                <h2>Pagamento via Pix</h2>
                <div id="qrCodeContainer"></div>
                <button id="cancelPayment">Cancelar</button>
                <button id="confirmPayment">Confirmar Pagamento</button>
            </div>
        </div> --}}

        {{-- <div class="pay">
            <form action="{{ route('mercadopago.create') }}" method="POST" id="paymentForm">
                @csrf
                <input type="hidden" name="imagem_id" value="{{ $imagem->id }}">
                <div class="container1">
                    <h2>Área de Confirmação</h2>
                    <div class="planos">
                        <label>
                            <input type="radio" name="valor" value="{{ $imagem->valor }}" style="margin-right: 8px;" required>
                            R$ {{ number_format($imagem->valor, 2, ',', '.') }} por esta imagem<br>
                        </label>
                        <strong>→ Confirme Clicando no Botão Abaixo</strong>
                    </div>

                    <!-- Botão Pix que submete o formulário -->
                    <button class="button" onclick="checkSelection(event)">
                        Pagamento via Pix
                    </button>

                    <div class="info">
                        Inclui a nossa <a href="#">licença padrão</a>.<br>
                    </div>
                </div>
            </form>
            <br>
            <br>

            <form action="{{ route('mercadopago.createCard') }}" method="post" id="paymentForm">
                @csrf
                <input type="hidden" name="imagem_id" value="{{ $imagem->id }}">
                <div class="container2">
                    <h2>Área de Confirmação</h2>
                    <div class="planos">
                        <label>
                            <input type="radio" name="valor" value="{{ $imagem->valor }}" style="margin-right: 8px;">
                            R$ {{ number_format($imagem->valor, 2, ',', '.') }} por esta imagem<br>
                        </label>
                        <strong>→ Confirme Clicando no Botão Abaixo</strong>
                    </div>
                    <button class="button" onclick="checkSelection()">Pagamento via Cartão</button>

                    <div class="info">
                        Inclui a nossa <a href="#">licença padrão</a>.<br>
                    </div>
                </div>
            </form>
        </div> --}}

{{-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ --}}

<div class="payment-page">
    <!-- Escolha como pagar -->
    <div class="payment-options">
        <h2 class="payment-title">Escolha como pagar</h2>

        {{-- <div class="payment-method">
            <input type="radio" id="combine" name="payment_method" class="payment-radio">
            <label for="combine">
                <div class="method-details">
                    <span>Combinar 2 meios de pagamento</span>
                    <span class="new-option">NOVA OPÇÃO</span>
                </div>
            </label>
        </div> --}}

        {{-- <div class="payment-method">
            <input type="radio" id="saldo" name="payment_method" class="payment-radio">
            <label for="saldo">
                <div class="method-details">
                    <img src="link_para_imagem_saldo" alt="Ícone Saldo" class="method-icon">
                    <div>
                        <span>Saldo no Mercado Pago</span>
                        <span class="method-subtitle">Saldo: R$ 6,90</span>
                    </div>
                </div>
            </label>
        </div> --}}

        <div class="payment-method">
            <input type="radio" id="pix" name="payment_method" class="payment-radio">
            <label for="pix">
                <div class="method-details">
                    <img src="{{ asset('assets/pagamento/pix.png') }}" alt="Ícone Pix" class="method-icon">
                    <div>
                        <span>Pix</span>
                        <span class="method-subtitle">Aprovação imediata</span>
                        <span class="new-option">NOVA OPÇÃO</span>
                    </div>
                </div>
            </label>
        </div>

        <div class="payment-method">
            <input type="radio" id="cartao" name="payment_method" class="payment-radio">
            <label for="cartao">
                <div class="method-details">
                    <img src="{{ asset('assets/credit-card.png') }}" alt="Ícone Cartão" class="method-icon">
                    <div>
                        <span>Cartão de crédito</span>
                    </div>
                </div>
            </label>
        </div>

        {{-- <div class="payment-method">
            <input type="radio" id="boleto" name="payment_method" class="payment-radio">
            <label for="boleto">
                <div class="method-details">
                    <img src="link_para_imagem_boleto" alt="Ícone Boleto" class="method-icon">
                    <div>
                        <span>Boleto</span>
                        <span class="method-subtitle">Aprovação em 1 a 2 dias úteis</span>
                    </div>
                </div>
            </label>
        </div> --}}

        <button class="continue-button">Continuar</button>
    </div>

    <!-- Resumo da compra -->
    <div class="purchase-summary">
        <h3 class="summary-title">Resumo da compra</h3>
        <div class="summary-item">
            <span>Produto</span>
            <span class="price">{{ number_format($imagem->valor, 2, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span>Trânsferencia</span>
            <span class="free">Grátis</span>
        </div>
        {{-- <div class="coupon">
            <a href="#" class="coupon-link">Inserir código do cupom</a>
        </div> --}}
        <hr class="divider">
        <div class="summary-total">
            <span>Você pagará</span>
            <span class="total-price">{{ number_format($imagem->valor, 2, ',', '.') }}</span>
        </div>
        <div class="main-container">
            <div class="container">
                <div class="container-image">
                    <div class="image-container">
                        <div
                            style="background-image: url('{{ $imagem->url_marca_dagua }}'); background-size: cover; background-position: center; width: 284px; height: 162px; display: flex; align-items: center; justify-content: flex-end; flex-direction: column; user-select: none !important;border-radius:6%">
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
</div>


{{-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ --}}

        
        
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