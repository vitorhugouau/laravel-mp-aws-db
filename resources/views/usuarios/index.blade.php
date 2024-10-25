<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="/css/viewimg.css">
</head>
<body background="../../assets/img/ti2.jpg">

<!-- Navegação -->
<nav>
    <ul class="menu">
        <li><a href="biblioteca.php">BIBLIOTECA</a></li>
        <li><a href="{{ route('control') }}">VOLTAR</a></li>
    </ul>
</nav>

<!-- Mensagem de sucesso -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<br><br><br><br>
<!-- Formulário para adicionar um novo usuário -->
{{-- <div class="cont">
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="area">
            <label for="name">NOME</label>
            <input type="text" name="name" id="name" required>
        </div>
        
        <div class="area">
            <label for="email">EMAIL</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="area">
            <label for="password">SENHA</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <input type="submit" class="submit" value="Adicionar Usuário">
        </div> 
    </form>
</div> --}}

<!-- Tabela com os dados dos usuários -->
<br>
<table class="table">
        <tr>
            <th>ID</th>
            <th>NOME</th>
            <th>EMAIL</th>
            <th>OPÇÕES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario) <!-- Loop pelos usuários -->
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td style="display:flex;">
                    <!-- Formulário para excluir o usuário -->
                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirmarExclusao()" class="btn btn-danger">EXCLUIR</button>
                    </form>
                    <!-- Botão para editar o usuário -->
                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-success">EDITAR</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Mensagem de confirmação para exclusão -->
<script>
    function confirmarExclusao() {
        return confirm("EXCLUIR ESTE REGISTRO?");
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

