<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras</title>
    <link rel="stylesheet" href="/css/biblioteca/type3.css">
</head>
@include('partials.nav')
<body>
<br>
    <h1 class="heading">Compras de {{ Auth::user()->name }}</h1>
<br><br><br><br>    
    <table class="table">
        <thead>
            <tr>
                <th>Nome do Produto</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->product->nome }}</td>
                    <td>{{ $compra->value }}</td>
                    <td>{{ $compra->status }}</td>
                    <td>
                        <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-primary">Visualizar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
