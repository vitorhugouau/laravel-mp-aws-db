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
            height: 63px;
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
            <img src="data:image/png;base64,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" alt="QR Code Pix">
        </div>

        <p>Código PIX (copia e cola):</p>
        <textarea readonly>00020126360014br.gov.bcb.pix0114+551499886418352040000530398654041.005802BR5916RV202410240940556009Sao Paulo62240520mpqrinter962463847486304672A</textarea>

        

        
    </div>
</body>
<script>
    const externalReference = "Pagamento_675c7ebd55fd3"; // ID único do pagamento
    const checkStatusUrl = "https://ec5a-2a02-6ea0-d07c-0-ae7f-16d1-8cf7-af97.ngrok-free.app/mercadopago/check-status/:externalReference".replace(':externalReference', externalReference);

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
                    window.location.href = "https://ec5a-2a02-6ea0-d07c-0-ae7f-16d1-8cf7-af97.ngrok-free.app/mercadopago/success?payment_id=" + data.payment_id + "&status=" + data.status;
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
