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
        .payment-form {
            display: none;
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

    <div class="payment-container">
        <div class="payment-header">Selecione o método de pagamento</div>

        <!-- Métodos de pagamento -->
        <div class="payment-methods">
            <label for="credit-card-option">
                <img src="../../assets/mastercard.png" alt="Cartão de Crédito" style="height: 29px;">
                <div class="cartao" style="padding: 10px">
                Cartão de Crédito
                  </div>
                <input type="radio" id="credit-card-option" name="payment-method" value="credit" onclick="togglePaymentForm('credit')">
            </label>

            <label for="pix-option">
                <img src="../../assets/pix.png" alt="Pix" style="height: 30px;">
                Pix
                <input type="radio" id="pix-option" name="payment-method" value="pix" onclick="togglePaymentForm('pix')">
            </label>
        </div>

        <!-- Formulário de pagamento por cartão -->
        <div id="credit-card-form" class="payment-form">
            <form method="POST" action="{{ route('finalizarPagamento', ['imagem' => $imagem->id]) }}">
                @csrf
                <div class="form-group">
                    <label for="card-name">Nome no cartão</label>
                    <input type="text" id="card-name" name="card-name" placeholder="Nome no cartão" required>
                </div>

                <div class="form-group">
                    <label for="card-cpf">CPF/CPNJ</label>
                    <input type="number" id="card-cpf" name="card-cpf" placeholder="CPF/CNPJ do titular" oninput="if(this.value.length > 14) this.value = this.value.slice(0, 14);" required>
                </div>

                <div class="form-group">
                    <label for="card-number">Número do cartão</label>
                    <input type="number" id="card-number" name="card-number" placeholder="Número do cartão" oninput="if(this.value.length > 16) this.value = this.value.slice(0, 16);" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="expiration">MM / AA</label>
                        <input type="text" id="expiration" name="expiration" placeholder="MM / AA" required>
                    </div>

                    <div class="form-group">
                        <label for="cvv">Código de segurança</label>
                        <input type="text" id="cvv" name="cvv" placeholder="CVV" required>
                    </div>
                </div>

                <button type="submit" class="submit-button">Efetuar pagamento</button>
            </form>
        </div>

        <!-- Formulário de pagamento por Pix -->
        <div id="pix-form" class="payment-form">
            <form method="POST" > 
                {{-- action="{{ route('finalizarPagamentoPix', ['imagem' => $imagem->id]) }}" --}}
                @csrf
                <div class="form-group">
                    <label for="pix-cpf">CPF/CPNJ do pagador</label>
                    <input type="number" id="pix-cpf" name="pix-cpf" placeholder="Informe seu CPF/CPNJ" oninput="if(this.value.length > 14) this.value = this.value.slice(0, 14);" required>
                </div>

                <button type="submit" class="submit-button">Efetuar pagamento com Pix</button>
            </form>
        </div>
    </div>

    <script>
        function togglePaymentForm(method) {
            document.getElementById('credit-card-form').style.display = (method === 'credit') ? 'block' : 'none';
            document.getElementById('pix-form').style.display = (method === 'pix') ? 'block' : 'none';
        }
    </script>
    
</body>
</html>
