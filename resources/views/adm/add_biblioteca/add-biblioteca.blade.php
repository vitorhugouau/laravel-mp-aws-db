<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserindo</title>
    <link rel="stylesheet" href="/css/adm/control.css">
</head>
<body background="../../assets/img/ti2.jpg">
    <!-----------------------------------BOTAO PARA VOLTAR------------------------------------------------------->
    <nav>
        <ul class= "menu">
            <li><a href="{{ route('control') }}">VOLTAR</a></li>
        </ul>
    </nav>
    <!---------------------------------SELECIONE UMA IMAGEM---------------------------------------------------->
    <div class="container">
        <h1 class="heading">PAINEL DE CONTROLE</h1>
    </div>
    <!------------------------------ADICIONANDO DADOS NA TABELA--------------------------------------------->
    <div class="container">
        <form action="" method="get">
            <div class="area">
                <input type="submit" value="ADICIONAR IMAGEM" formaction="{{route('uploads')}}">
                <input type="submit" value="CONTROLE DE IMAGENS" formaction="control_consult.php">
            </div>
        </form>
    </div>
    <!-------------------------------IMAGEM NA TELA-------------------------------------------------------------------->
</body>
</html>
