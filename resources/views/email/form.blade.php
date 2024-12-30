<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Email</title>
</head>
<body>
    <h1>Enviar Email com SendGrid</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('send.email') }}" method="POST">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br><br>

        <label for="email">Email do destinatário:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="mensagem">Mensagem:</label>
        <textarea name="mensagem" id="mensagem" rows="4" required></textarea><br><br>

        <button type="submit">Enviar Email</button>
    </form>
</body>
</html>
