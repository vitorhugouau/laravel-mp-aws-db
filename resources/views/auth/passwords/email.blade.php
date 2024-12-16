<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar Senha</title>
    <link rel="stylesheet" href="/css/login/parte3-email.css">
</head>

{{-- <body>
    <div class="container">
        <h2>Redefinir Senha</h2>
        
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Enviar Link de Redefinição</button>
        </form>
    </div>
</body> --}}

<body>
    <h1>SEJA BEM-VINDO</h1>

    <div class="meio">
        <div class="form-container">
            <div id="reset-password">
                <form class="card" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <h3>RESETAR SENHA</h3>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-header">
                        <div class="card-content">
                            <!-- Campo de nova senha -->
                            <div class="card-content-area">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" required placeholder="Digite sua email">
                            </div>
                            <div class="message">
                                @if (session('success'))
                                    <p style="color: green;">{{ session('success') }}</p>
                                @endif

                                @if ($errors->any())
                                    <p style="color: red;">{{ $errors->first() }}</p>
                                @endif
                            </div>
                            <div class="card-cadastro2">
                                <button type="submit" class="teste2">Enviar Link de Redefinição</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
