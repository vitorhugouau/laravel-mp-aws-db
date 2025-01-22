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
    

    {{-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ --}}

    <div class="payment-page">
        <!-- Escolha como pagar -->
        <div class="payment-options">
            <h2 class="payment-title">Escolha como pagar</h2>

            
            <form action="{{ route('mercadopago.create') }}" method="post" id="paymentForm">
                @csrf
                <input type="hidden" name="imagem_id" value="{{ $imagem->id }}">
                <input type="hidden" id="paymentMethod" name="payment_method" value="pix"> 

                <div class="payment-method">
                    <input type="radio" id="pix" name="valor" class="payment-radio"
                        value="{{ $imagem->valor }}" required checked>
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
                    <input type="radio" id="cartao" name="valor" class="payment-radio"
                        value="{{ $imagem->valor }}" required>
                    <label for="cartao">
                        <div class="method-details">
                            <img src="{{ asset('assets/credit-card.png') }}" alt="Ícone Cartão" class="method-icon">
                            <div>
                                <span>Cartão de crédito</span>
                            </div>
                        </div>
                    </label>
                </div>

                <button class="continue-button" onclick="checkSelection(event)">Continuar</button>

                <div class="info">
                    Inclui a nossa <a href="{{ route ('licenca') }}">licença padrão</a>.
                </div>
            </form>

            <script>
                
                function checkSelection(event) {
                    event.preventDefault();

                    const paymentMethod = document.querySelector('input[name="valor"]:checked').id;

                    console.log('Método de pagamento selecionado:', paymentMethod); 

                    if (paymentMethod === 'pix') {
                        console.log('Alterando ação para Pix'); 
                        document.getElementById('paymentForm').action = '{{ route('mercadopago.create') }}';
                    } else if (paymentMethod === 'cartao') {
                        console.log(
                        'Alterando ação para Cartão de Crédito'); 
                        document.getElementById('paymentForm').action = '{{ route('mercadopago.createCard') }}';
                    }

                    console.log('Ação do formulário:', document.getElementById('paymentForm').action);

                    document.getElementById('paymentForm').submit();
                } 
            </script>


        </div>
       

        <!-- Resumo da compra -->
        <div class="purchase-summary">
            <h3 class="summary-title">Resumo da compra</h3>
            <div class="summary-item">
                <span>Produto</span>
                <span class="price">R$ {{ number_format($imagem->valor, 2, ',', '.') }}</span>
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
                <span class="total-price">R$ {{ number_format($imagem->valor, 2, ',', '.') }}</span>
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


        {{-- <script>
            function checkSelection() {
                const radioChecked = document.querySelector('input[name="valor"]:checked');
                if (!radioChecked) {
                    alert("Por favor, selecione um valor antes de continuar.");
                } else {
                    document.getElementById('paymentForm').submit();
                }
            }
        </script> --}}


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
