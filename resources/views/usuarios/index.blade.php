<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="/css/viewimg.css">
</head>

<body background="../../assets/img/ti2.jpg">

    <nav>
        <ul class="menu">
            <li><a href="{{ route('biblioteca') }}">BIBLIOTECA</a></li>
            <li><a href="{{ route('control') }}">VOLTAR</a></li>
        </ul>
    </nav>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <br><br><br><br>

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
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td style="display:flex;">
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirmarExclusao()"
                                class="btn btn-danger">EXCLUIR</button>
                        </form>
                     
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-success">EDITAR</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmarExclusao() {
            return confirm("EXCLUIR ESTE REGISTRO?");
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>