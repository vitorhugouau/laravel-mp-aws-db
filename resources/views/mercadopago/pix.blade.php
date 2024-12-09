<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento via PIX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        h1 {
            color: #007bff;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .qr-code {
            margin: 20px 0;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
            font-size: 16px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            resize: none;
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        p {
            margin: 15px 0;
            font-size: 1rem;
        }

        .external-reference {
            margin-top: 20px;
            font-weight: bold;
            color: #555;
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

</html>
