<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Vendas</title>
    <link rel="stylesheet" href="/css/viewimg2.css">
</head>

<body background="../../assets/img/ti2.jpg">

    <!-- Navegação -->
    <nav>
        <ul class="menu">
            <li><a href="{{ route('biblioteca') }}">BIBLIOTECA</a></li>
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

    <br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME DO USUÁRIO</th>
                <th>ID DO PRODUTO</th>
                <th>PAYMENT ID</th>
                <th>STATUS</th>
                <th>VALOR PAGO</th> <!-- Adiciona o cabeçalho para o valor pago -->
                <th>OPÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale) <!-- Loop pelas vendas -->
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->user->name }}</td> <!-- Exibe o nome do usuário -->
                    <td>{{ $sale->product_id }}</td> <!-- Exibe o ID do produto -->
                    <td>{{ $sale->payment_id }}</td>
                    <td>{{ $sale->status }}</td>
                    <td>R$ {{ number_format($sale->value, 2, ',', '.') }}</td> <!-- Exibe o valor pago -->
                    <td style="display:flex;">
                        <!-- Formulário para excluir a venda -->
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirmarExclusao()" class="btn btn-danger">EXCLUIR</button>
                        </form>
                        <!-- Botão para editar a venda -->
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-success">EDITAR</a>
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
