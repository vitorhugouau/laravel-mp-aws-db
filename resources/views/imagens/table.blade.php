<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição de Imagem</title>
    <link rel="stylesheet" href="{{ asset('css/viewimg.css') }}">
</head>

<body background="../../assets/img/ti2.jpg">
    <nav>
        <ul class="menu">
            <li><a href="{{ route('biblioteca') }}">BIBLIOTECA</a></li>
            <li><a href="{{ route('control') }}">VOLTAR</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1 class="heading">CONSULTANDO IMAGENS NO BANCO DE DADOS</h1>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>IMAGEM</th>
                <th>VALOR</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @if($imagens->isEmpty())
                <tr>
                    <td colspan="5">Nenhuma imagem encontrada.</td>
                </tr>
            @else
                @foreach($imagens as $imagem)
                    <tr>
                        <td class="center-align">{{ $imagem->id }}</td>
                        <td class="center-align">{{ $imagem->nome }}</td>
                        <td class="center-align">
                            <img src="data:image/jpeg;base64,{{ $imagem->imagem }}" alt="Imagem" style="max-width: 350px;">
                        </td>
                        <td class="center-align">R$ {{ number_format($imagem->valor, 2, ',', '.') }}</td>
                        <td class="center-align">
                            <!-- Botão de EDITAR -->
                            <form method="GET" action="{{ route('imagens.edit', $imagem->id) }}" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success">EDITAR</button>
                            </form>

                            <!-- Botão de EXCLUIR -->
                            <form method="POST" action="{{ route('imagens.destroy', $imagem->id) }}"
                                onsubmit="return confirm('EXCLUIR ESTE REGISTRO?')" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">EXCLUIR</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</body>

</html>
