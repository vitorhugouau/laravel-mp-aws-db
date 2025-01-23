<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras</title>
    <link rel="stylesheet" href="/css/biblioteca/type3.css">
    <link rel="stylesheet" href="/css/biblioteca/type3-new-visual.css">
</head>
@include('partials.nav')

<body>
    <br>
    {{-- <h1 class="heading">Compras de {{ Auth::user()->name }}</h1> --}}
    {{-- <h1 class="heading">Minhas Compras</h1> --}}
    <br><br>
   
    <div class="compras-page">
        
        <aside class="filtros-card">
            <h3>Filtrar Compras</h3>
            <form action="{{ route('minhas.compras') }}" method="GET">
                <div class="filtro-item">
                    <label for="data">Data</label>
                    <input type="date" id="data" name="data" value="{{ request('data') }}">
                </div>
                <div class="filtro-item">
                    <label for="valor_min">Valor Mínimo</label>
                    <input type="number" id="valor_min" name="valor_min" placeholder="Ex.: 50"
                        value="{{ request('valor_min') }}">
                </div>
                <div class="filtro-item">
                    <label for="valor_max">Valor Máximo</label>
                    <input type="number" id="valor_max" name="valor_max" placeholder="Ex.: 500"
                        value="{{ request('valor_max') }}">
                </div>
                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                <a href="{{ route('minhas.compras') }}" class="btn btn-secondary" style="margin-top: 10px;">Limpar Filtros</a>
            </form>
        </aside>
        <div class="compras-container">
            @foreach ($compras as $compra)
                <div class="compra-item">
                    
                    <div class="compra-imagem">
                        @if ($compra->product && $compra->product->url_original)
                            <img src="{{ $compra->product->url_original }}" alt="Imagem do Produto">
                        @else
                            <span>Imagem não disponível</span>
                        @endif
                        <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-primary">Visualizar</a>
                    </div>

                    <div class="compra-info">
                        <h4>{{ $compra->product->nome ?? 'Produto não disponível' }}</h4>
                        <p><strong>Valor:</strong> R$ {{ $compra->value ?? 'Indisponível' }}</p>
                        <p><strong>Status:</strong> {{ $compra->status ?? 'Indisponível' }}</p>
                        <p><strong>Data:</strong> {{ $compra->created_at ? $compra->created_at->format('d/m/Y') : 'Indisponível' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>

</html>
