<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="/css/viewimg.css">
</head>
<body background="../../assets/img/ti2.jpg">

    <!---------------------------------------BOTÃO PARA VOLTAR------------------------------------------------------>
    <nav>
        <ul class="menu">
            <li><a href="{{ route('usuarios.index') }}">VOLTAR</a></li>
        </ul>
    </nav>
    <br>
    <h1>EDITAR REGISTRO</h1>
    <br>
    <div class="cont">
        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" onsubmit="return confirmarEdicao()">
            @csrf
            @method('PUT')
            <div class="area">
                <label for="nome">NOME</label>
                <input type="text" name="name" id="name" value="{{ $usuario->name }}" class="form-control" required>
            </div>
            <div class="area">
                <label for="email">EMAIL</label>
                <input type="email" name="email" id="email" value="{{ $usuario->email }}" class="form-control" required>
            </div>
            <div class="area">
                <label for="senha">NOVA SENHA (opcional)</label>
                <input type="password" name="password" id="senha" class="form-control">
            </div>
            <div>
                <input type="submit" value="SALVAR ALTERAÇÕES" class="btn btn-primary">
            </div>
        </form>
    </div>

    <script>
        function confirmarEdicao() {
            return confirm("SALVAR AS ALTERAÇÕES?");
        }
    </script>
</body>
</html>
