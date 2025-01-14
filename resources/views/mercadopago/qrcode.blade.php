<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Pagamento via Mercado Pago</h2>
        <p>Escaneie o QR Code abaixo para concluir o pagamento:</p>
        <div style="text-align: center;">
            <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ urlencode($qr_code_url) }}" alt="QR Code Mercado Pago">
        </div>
        <p>Valor: R$ {{ number_format($valor, 2, ',', '.') }}</p>
    </div>
</body>
</html>