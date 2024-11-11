<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 15px;
        }

        .resend-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .resend-link a {
            color: #007bff;
            text-decoration: none;
        }

        .resend-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verifique seu Email</h1>

        <!-- Formulário para verificar o código -->
        <form action="{{ route('verify.code') }}" method="POST">
            @csrf
            <label for="code">Código de Verificação:</label>
            <input type="text" id="code" name="code" required>

            <button type="submit">Verificar Código</button>
        </form>

        <!-- Exibe mensagens de sucesso ou erro -->
        <div class="message">
            @if (session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <p style="color: red;">{{ $errors->first() }}</p>
            @endif
        </div>

        <!-- Link para reenviar o código caso necessário -->
        <div class="resend-link">
            <p>Não recebeu o código? <a href="{{ route('send.verification.code') }}">Clique aqui para reenviar.</a></p>
        </div>
    </div>
</body>
</html>
