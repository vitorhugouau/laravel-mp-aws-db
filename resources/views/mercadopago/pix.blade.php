<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento via PIX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #444;
        }

        p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .qr-code {
            margin-bottom: 20px;
        }

        .qr-code img {
            max-width: 200px;
            height: auto;
            margin: 0 auto;
        }

        textarea {
            width: 100%;
            height: 40px;
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: none;
            background-color: #f9f9f9;
        }

        textarea[readonly] {
            background-color: #f1f1f1;
        }

        a.btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 20px;
        }

        a.btn:hover {
            background-color: #0056b3;
        }

        .external-reference {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Pagamento via PIX</h1>

        <p>Use o QR Code abaixo para realizar o pagamento:</p>
        <div class="qr-code">
            <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code Pix">
        </div>

        <p>Código PIX (copia e cola):</p>
        <textarea readonly>{{ $qrCode }}</textarea>

        <p>Ou acesse diretamente o link:</p>
        <a href="{{ $ticketUrl }}" target="_blank" class="btn">Clique aqui para pagar</a>

        <p class="external-reference">Referência Externa: {{ $externalReference }}</p>
    </div>
</body>
<script>
    const externalReference = "{{ $externalReference }}"; // ID único do pagamento
    const checkStatusUrl = "{{ route('mercadopago.check-status', ':externalReference') }}".replace(':externalReference', externalReference);

    // Armazena o intervalo para permitir parada posterior
    let paymentCheckInterval = null;

    function checkPaymentStatus() {
        fetch(checkStatusUrl)
            .then(response => response.json())
            .then(data => {
                console.log('Status do pagamento:', data.status);

                if (data.status === 'approved') {
                    // Pagamento aprovado, redirecionar para a página de sucesso
                    clearInterval(paymentCheckInterval); // Para o intervalo
                    window.location.href = "{{ route('payment.success') }}?payment_id=" + data.payment_id + "&status=" + data.status;
                } else if (data.status === 'rejected') {
                    // Pagamento rejeitado, exibir mensagem de erro e parar a verificação
                    clearInterval(paymentCheckInterval); // Para o intervalo
                    
                } else {
                    console.log('Pagamento pendente. Continuando a verificação...');
                }
            })
            .catch(error => {
                console.error('Erro ao verificar status do pagamento:', error);
            });
    }

    // Inicia a verificação a cada 3 segundos
    paymentCheckInterval = setInterval(checkPaymentStatus, 3000);
</script>



</html>