<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Vendas</title>
    <link rel="stylesheet" href="/css/viewimg2.css">
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
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME DO USUÁRIO</th>
                <th>ID DO PRODUTO</th>
                <th>PAYMENT ID</th>
                <th>STATUS</th>
                <th>VALOR PAGO</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale) 
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->user->name }}</td> 
                    <td>{{ $sale->product_id }}</td> 
                    <td>{{ $sale->payment_id }}</td>
                    <td>{{ $sale->status }}</td>
                    <td>R$ {{ number_format($sale->value, 2, ',', '.') }}</td> 
                    <td style="display:flex;">
                    
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
