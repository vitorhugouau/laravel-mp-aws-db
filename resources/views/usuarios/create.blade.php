<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h1>Cadastro de Usuário</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="password_confirmation">Confirme a Senha:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
