<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/alterando.css">
    <title>Document</title>
    
</head>
<body background="../../assets/img/rio.jpg">
    <nav>
        <ul class="menu">
            <li><a href="{{ route('biblioteca') }}">BIBLIOTECA</a></li>
            <li><a href="{{ route('control') }}">VOLTAR</a></li>
        </ul>
    </nav>
<br><br>
<div class="cont">
    <h1>Editar Cliente</h1>
    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="area">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $cliente->nome }}" required>
        </div>

        <div class="area">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control" id="cpf" name="cpf" value="{{ $cliente->cpf }}" required>
        </div>

        <div class="area">
            <label for="datadenascimento">Data de Nascimento:</label>
            <input type="date" class="form-control" id="datadenascimento" name="datadenascimento" value="{{ $cliente->datadenascimento }}">
        </div>

        <div class="area">
            <label for="sexo">Sexo:</label>
            <select class="form-control" id="sexo" name="sexo">
                <option value="Masculino" {{ $cliente->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Feminino" {{ $cliente->sexo == 'Feminino' ? 'selected' : '' }}>Feminino</option>
                <option value="Outro" {{ $cliente->sexo == 'Outro' ? 'selected' : '' }}>Outro</option>
            </select>
        </div>

        <div class="area">
            <label for="estadocivil">Estado Civil:</label>
            <select class="form-control" id="estadocivil" name="estadocivil">
                <option value="Solteiro" {{ $cliente->estadocivil == 'Solteiro' ? 'selected' : '' }}>Solteiro</option>
                <option value="Casado" {{ $cliente->estadocivil == 'Casado' ? 'selected' : '' }}>Casado</option>
                <option value="Divorciado" {{ $cliente->estadocivil == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                <option value="Viúvo" {{ $cliente->estadocivil == 'Viúvo' ? 'selected' : '' }}>Viúvo</option>
            </select>
        </div>

        <div class="area">
            <label for="estado">Estado:</label>
            <input type="text" class="form-control" id="estado" name="estado" value="{{ $cliente->estado }}" required>
        </div>

        <div class="area">
            <label for="logradouro">Logradouro:</label>
            <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{ $cliente->logradouro }}" required>
        </div>

        <div class="area">
            <label for="numero">Número:</label>
            <input type="text" class="form-control" id="numero" name="numero" value="{{ $cliente->numero }}" required>
        </div>

        <div class="area">
            <label for="complemento">Complemento:</label>
            <input type="text" class="form-control" id="complemento" name="complemento" value="{{ $cliente->complemento }}">
        </div>

        <div class="area">
            <label for="cidade">Cidade:</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $cliente->cidade }}" required>
        </div>

        <div class="area">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $cliente->email }}" required>
        </div>

        <button type="submit" id="boton">Salvar</button>
    </form>
</div>
<style>
    #boton {
            background-color: rgb(0, 153, 33);
            color: rgb(255, 255, 255);
            border: 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            font-size: 14px;
            width: 560px;
            height: 40px;
            left: 20px;
            align-items: center;
            justify-content: center;
            display: flex;

        }

        #boton:hover {
            transform: scale(1.2);
        }
</style>


  
  <script>
        document.getElementById('sair').addEventListener('click', function() {
                document.getElementById('logout-form').submit();
            });
            function bloquearBotaoDireito(event){
                event.preventDefault();
            }
    </script>
    
    
</body>
</html>