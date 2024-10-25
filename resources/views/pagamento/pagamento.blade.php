<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/biblioteca/type1.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pagamento</title>
</head>
<body>
    <nav>
        <ul class="menu">
            <li><a href="{{ route('biblioteca') }}">HOME</a></li>
            <li><a href="#">CONTATO</a>
                <ul>
                    <a href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">INSTAGRAM</a>
                </ul>
            </li>
            <li><a href="#">SERVIÇOS</a>
                <ul>
                    <li><a href="cliente/serviço.php">CONTRATAR SERVIÇO</a></li>
                </ul>
            </li>
            <li><a href="{{ route('adm.login') }}">PAINEL DE CONTROLE</a></li>
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
            <div class="container-image">
                <div class="image-container">
                    <div style="background-image: url('data:image/jpeg;base64,{{ $imagem->imagem }}'); background-size: cover; background-position: center; width: auto; height: 20rem; display: flex; align-items: center; justify-content: flex-end; flex-direction: column; border-radius: 10px;">
                        <img id="{{ $imagem->id }}" class="imagemaaa" src="{{ asset("assets/image.png") }}" style="height: 200px; width: 50%; opacity: 0.6;">
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 40rem; height: 40px;">
                            <div class="compra">
                                <!-- Exibição do botão de compra -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container1"> 
            <h2>Área de Confirmação</h2>
            <form id="purchaseForm" method="POST">
                <div class="planos">
                    <label>
                        <input type="radio" name="valor" value="125" style="margin-right: 8px;">
                        R$ 125 por esta imagem<br>
                    </label>
                    <strong>→ Confirme Clicando no Botão Abaixo</strong>
                </div>
                
                <button type="button" class="button" onclick="{{route('mercadopago.create')}}">Continuar compra</button>
            </form>
        
            <div class="info">
                Inclui a nossa <a href="#">licença padrão</a>.<br>
            </div>
        </div>
    </div>
    
    <script>
        // Função para obter o valor selecionado
        function getSelectedValue() {
            const selected = document.querySelector('input[name="valor"]:checked');
            return selected ? selected.value : null;
        }
     
        async function buyImage() {
            // Valor fixo para testes
            const valorFixo = 125;
    
            try {
                const response = await fetch("{{ route('mercadopago.create') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ valor: valorFixo }),
            });

    
                if (!response.ok) {
                    throw new Error('Erro ao criar a preferência de pagamento.');
                }
    
                const data = await response.json();
                window.location.href = data.init_point; // Redireciona para o checkout do Mercado Pago
    
            } catch (error) {
                alert('Erro: ' + error.message);
            }
        }

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
