<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento via Pix</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f7f7f7;
        color: #333;
    }

    .container {
        max-width: 600px;
        margin: 30px auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
    }

    .qr-code {
        margin: 20px 0;
    }

    textarea {
        width: 100%;
        height: 80px;
        margin-top: 10px;
        font-size: 14px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: none;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border-radius: 4px;
    }

    a:hover {
        background-color: #0056b3;
    }
</style>

<body>
    <h1>Pagamento via Pix</h1>

    <p>Use o QR Code abaixo para realizar o pagamento:</p>

    <!-- Exibindo o QR Code -->
    @if ($qrCodeBase64)
        <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code Pix" />
    @else
        <p>Erro ao gerar o QR Code.</p>
    @endif

    <h1>Pagamento via Pix</h1>
    <p>Referência Externa: {{ $externalReference }}</p>
    <p>Link para pagamento: <a href="{{ $ticketUrl }}" target="_blank">Abrir Link</a></p>

    <h3>QR Code</h3>
    <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code Pix">



</body>

</html>
