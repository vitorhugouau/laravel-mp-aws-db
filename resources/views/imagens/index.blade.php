<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagens Armazenadas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-center text-3xl font-bold mb-6">Imagens Armazenadas</h1>
        
        @if (isset($imagens) && count($imagens) > 0)
            <div class="grid grid-cols-3 gap-6">
                @foreach ($imagens as $imagem)
                    <div class="border rounded p-3 bg-white shadow-md">
                        <p class="font-bold mb-2">{{ $imagem->nome }}</p>
                        <img src="data:image/jpeg;base64,{{ $imagem->imagem }}" alt="{{ $imagem->nome }}" class="w-full h-auto">
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-red-500">Nenhuma imagem encontrada.</p>
        @endif
    </div>
</body>
</html>
