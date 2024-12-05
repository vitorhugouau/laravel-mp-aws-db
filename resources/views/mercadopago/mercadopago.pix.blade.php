<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento via Pix</title>
</head>

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
