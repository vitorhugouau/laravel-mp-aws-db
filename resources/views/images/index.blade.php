<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($images as $image)
    <div>
        <p>Nome: {{ $image->nome }}</p>
        <p>Valor: R$ {{ number_format($image->valor, 2, ',', '.') }}</p>
        <p>Original:</p>
        <img src="{{ $image->url_original }}" alt="Original">
        <p>Com Marca d'Água:</p>
        <img src="{{ $image->url_marca_dagua }}" alt="Com Marca d'Água">
    </div>
@endforeach
</body>
</html>