<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-center text-3xl font-bold mb-6">Upload de Imagem</h1>
        
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('imagem-store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="mb-4">
                <label for="imagem" class="block text-gray-700">Escolha uma imagem:</label>
                <input type="file" name="imagem" id="imagem" required class="block w-full text-gray-700 border border-gray-300 rounded p-2 mt-2">
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">
                Enviar
            </button>
        </form>

        @if (isset($imagens) && count($imagens) > 0)
            <div class="mt-10">
                <h2 class="text-xl font-bold mb-4">Imagens enviadas</h2>
                <div class="grid grid-cols-3 gap-6">
                    @foreach ($imagens as $imagem)
                        <div class="border rounded p-3">
                            <img src="{{ route('imagem-show', $imagem->id) }}" alt="{{ $imagem->nome }}" class="w-full h-auto">
                            <p class="mt-2">{{ $imagem->nome }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>
</html>
