<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/table.css">
    <title>Document</title>
    
</head>
<body background="../../assets/img/ti2.jpg">
    <nav>
        <ul class="menu">
            <li><a href="{{ route('biblioteca') }}">BIBLIOTECA</a></li>
            <li><a href="{{ route('control') }}">VOLTAR</a></li>
        </ul>
    </nav>

<div class="container">
    <h1>Clientes</h1>
    <br><br>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>Sexo</th>
                <th>Estado Civil</th>
                <th>Estado</th>
                <th>Logradouro</th>
                <th>Número</th>
                <th>Complemento</th>
                <th>Cidade</th>
                <th>Email</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->cpf }}</td>
                    <td>{{ $cliente->datadenascimento }}</td>
                    <td>{{ $cliente->sexo }}</td>
                    <td>{{ $cliente->estadocivil }}</td>
                    <td>{{ $cliente->estado }}</td>
                    <td>{{ $cliente->logradouro }}</td>
                    <td>{{ $cliente->numero }}</td>
                    <td>{{ $cliente->complemento }}</td>
                    <td>{{ $cliente->cidade }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>
                        <form action="{{ route('clientes.destroy', ['id' => $cliente->id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</button>
                        </form>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-success">EDITAR</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


  <script>
        document.getElementById('sair').addEventListener('click', function() {
                document.getElementById('logout-form').submit();
            });
            function bloquearBotaoDireito(event){
                event.preventDefault();
            }
    </script>
    
    
</body>
</html>