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
    {{-- <h1 class="heading">Compras de {{ Auth::user()->name }}</h1> --}}
    <h1 class="heading">Minhas Compras</h1>
    <br><br>
    <table class="table">
        <thead>
            <tr>
                <th>Nome do Produto</th>
                <th>Valor</th>
                <th>Status</th>
                <th>IMAGEM</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <td>{{ $compra->product->nome ?? 'Produto não disponível' }}</td>
                    <td>{{ $compra->value ?? 'Valor não disponível' }}</td>
                    <td>{{ $compra->status ?? 'Status não disponível' }}</td>
                    <td class="center-align">
                        @if ($compra->product && $compra->product->url_original)
                            <img src="{{ $compra->product->url_original }}" alt="Imagem" style="max-width: 150px;">
                        @else
                            <span>Imagem não disponível</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-success">Visualizar Imagem</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
